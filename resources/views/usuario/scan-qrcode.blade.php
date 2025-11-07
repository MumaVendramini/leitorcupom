@extends('layouts.app')

@section('title', 'Escanear QR Code')

@section('content')
<div class="px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('usuario.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                ← Voltar ao Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Escanear Cupom Fiscal</h1>
            <p class="text-gray-600">Aponte a câmera para o QR Code do cupom fiscal</p>
        </div>

        <!-- Área do scanner -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div id="reader" class="mb-4"></div>
            
            <div id="status" class="hidden mb-4 p-4 rounded-md">
                <p id="status-message" class="text-sm"></p>
            </div>

            <div id="raw-container" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-1">Conteúdo lido do QR</label>
                <textarea id="raw-text" rows="3" class="w-full text-xs p-2 border border-gray-300 rounded-md" readonly></textarea>
            </div>

            <!-- Formulário manual (caso o scan não funcione) -->
            <div class="border-t pt-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Ou digite a chave manualmente</h3>
                <form id="form-manual" onsubmit="submitManual(event)">
                    <div class="space-y-4">
                        <div>
                            <label for="chave_manual" class="block text-sm font-medium text-gray-700">
                                Chave de Acesso (44 dígitos)
                            </label>
                            <input type="text" id="chave_manual" name="chave_acesso" 
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Digite os 44 dígitos da chave"
                                   maxlength="44"
                                   pattern="[0-9]{44}">
                            <p class="text-xs text-gray-500 mt-1">Digite apenas números, sem espaços</p>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Registrar Cupom
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Histórico de scans na sessão -->
        <div id="scan-history" class="mt-6 hidden">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Cupons Registrados nesta Sessão</h2>
            <div id="history-list" class="space-y-2"></div>
        </div>
    </div>
</div>

@push('scripts')
<!-- html5-qrcode library -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
let html5QrCode;
let scanHistory = [];
let lastRawText = null;

// Haptics (vibração) com fallback para beep
function haptic(pattern = [90]) {
    try {
        if (navigator.vibrate) {
            navigator.vibrate(pattern);
            return;
        }
    } catch (e) { /* ignore */ }
    // Fallback: beep curto
    try {
        const AudioCtx = window.AudioContext || window.webkitAudioContext;
        if (!AudioCtx) return;
        const ctx = new AudioCtx();
        const o = ctx.createOscillator();
        const g = ctx.createGain();
        o.connect(g); g.connect(ctx.destination);
        o.type = 'square';
        o.frequency.value = 880;
        o.start();
        g.gain.setValueAtTime(0.2, ctx.currentTime);
        g.gain.exponentialRampToValueAtTime(0.00001, ctx.currentTime + 0.12);
        setTimeout(() => { try { o.stop(); ctx.close(); } catch(e){} }, 160);
    } catch (e) { /* ignore */ }
}

// Inicializar o scanner
function initScanner() {
    html5QrCode = new Html5Qrcode("reader");
    
    const config = {
        fps: 10,
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0
    };

    html5QrCode.start(
        { facingMode: "environment" },
        config,
        onScanSuccess,
        onScanError
    ).catch(err => {
        console.error('Erro ao iniciar scanner:', err);
        showStatus('error', 'Não foi possível acessar a câmera. Use o formulário manual abaixo.');
    });
}

// Callback quando QR Code é lido com sucesso
function onScanSuccess(decodedText, decodedResult) {
    console.log('QR Code detectado:', decodedText);
    lastRawText = decodedText;
    const rawEl = document.getElementById('raw-text');
    const rawContainer = document.getElementById('raw-container');
    rawEl.value = decodedText;
    rawContainer.classList.remove('hidden');
    haptic([60]);
    
    // Extrair chave de acesso do QR Code
    // O QR Code da NF-e geralmente contém a URL ou apenas a chave
    let chaveAcesso = extractChaveAcesso(decodedText);
    
    if (chaveAcesso) {
        html5QrCode.pause();
        submitNota(chaveAcesso, decodedText);
    } else {
        showStatus('error', 'QR Code inválido. Não foi possível extrair a chave de acesso.');
    }
}

function onScanError(errorMessage) {
    // Ignorar erros de scan contínuo
}

// Extrair chave de acesso do texto do QR Code
function extractChaveAcesso(text) {
    // Remove espaços e quebras de linha
    text = text.replace(/\s/g, '');
    
    // Tenta encontrar 44 dígitos consecutivos
    const match = text.match(/\d{44}/);
    
    if (match) {
        return match[0];
    }
    
    // Se o QR Code contém URL, tenta extrair da URL
    if (text.includes('chNFe=') || text.includes('chave=')) {
        const urlMatch = text.match(/(?:chNFe|chave)=(\d{44})/);
        if (urlMatch) {
            return urlMatch[1];
        }
    }
    
    return null;
}

// Submeter nota ao backend
async function submitNota(chaveAcesso, rawText=null) {
    showStatus('info', 'Registrando cupom fiscal...');
    
    try {
        const response = await fetch('/api/notas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'include',
            body: JSON.stringify({
                chave_acesso: chaveAcesso,
                qr_conteudo: rawText
            })
        });
        const text = await response.text();
        let data;
        try { data = JSON.parse(text); } catch(e) { data = { success: false, message: text || 'Resposta não é JSON' }; }

        console.log('POST /api/notas status:', response.status);
        console.log('POST /api/notas body:', data);

        if (response.ok && data.success) {
            showStatus('success', 'Cupom registrado com sucesso! ✓');
            haptic([50, 30, 50]);
            addToHistory(data.cupom);
            
            // Limpar campo manual se tiver
            document.getElementById('chave_manual').value = '';
            
            // Retomar scan após 2 segundos
            setTimeout(() => {
                hideStatus();
                if (html5QrCode) {
                    html5QrCode.resume();
                }
            }, 2000);
        } else {
            showStatus('error', data.message || 'Erro ao registrar cupom.');
            haptic([100]);
            setTimeout(() => {
                if (html5QrCode) {
                    html5QrCode.resume();
                }
            }, 3000);
        }
    } catch (error) {
    console.error('Erro na requisição /api/notas:', error);
        showStatus('error', 'Erro de conexão. Tente novamente.');
        haptic([120]);
        setTimeout(() => {
            if (html5QrCode) {
                html5QrCode.resume();
            }
        }, 3000);
    }
}

// Submeter formulário manual
function submitManual(event) {
    event.preventDefault();
    const chaveInput = document.getElementById('chave_manual');
    const chave = chaveInput.value.replace(/\s/g, '');
    
    if (chave.length !== 44) {
        showStatus('error', 'A chave deve ter exatamente 44 dígitos.');
        return;
    }
    
    submitNota(chave, lastRawText || chave);
}

// Mostrar status
function showStatus(type, message) {
    const statusDiv = document.getElementById('status');
    const statusMessage = document.getElementById('status-message');
    
    statusDiv.className = 'mb-4 p-4 rounded-md';
    
    if (type === 'success') {
        statusDiv.classList.add('bg-green-100', 'border', 'border-green-400', 'text-green-700');
    } else if (type === 'error') {
        statusDiv.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700');
    } else {
        statusDiv.classList.add('bg-blue-100', 'border', 'border-blue-400', 'text-blue-700');
    }
    
    statusMessage.textContent = message;
    statusDiv.classList.remove('hidden');
}

function hideStatus() {
    document.getElementById('status').classList.add('hidden');
}

// Adicionar ao histórico da sessão
function addToHistory(cupom) {
    scanHistory.push(cupom);
    
    const historyDiv = document.getElementById('scan-history');
    const historyList = document.getElementById('history-list');
    
    const item = document.createElement('div');
    item.className = 'bg-green-50 border border-green-200 rounded-md p-4';
    item.innerHTML = `
        <p class="font-medium text-green-900">Cupom #${cupom.numero_nf}</p>
        <p class="text-sm text-green-700">CNPJ: ${cupom.cnpj}</p>
        <p class="text-sm text-green-700">Valor: R$ ${cupom.valor}</p>
    `;
    
    historyList.prepend(item);
    historyDiv.classList.remove('hidden');
}

// Iniciar quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    initScanner();
});

// Parar scanner quando sair da página
window.addEventListener('beforeunload', function() {
    if (html5QrCode) {
        html5QrCode.stop();
    }
});
</script>
@endpush
@endsection
