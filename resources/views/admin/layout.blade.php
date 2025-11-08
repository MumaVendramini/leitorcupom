@extends('layouts.app')

@section('content')
<script>
    async function toggleTableOrientation() {
        const icon = document.getElementById('orientationIcon');
        
        try {
            // Verifica se a API de orientação está disponível
            if (screen.orientation && screen.orientation.lock) {
                const currentOrientation = screen.orientation.type;
                
                if (currentOrientation.includes('portrait')) {
                    // Mudar para landscape
                    await screen.orientation.lock('landscape');
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                } else {
                    // Voltar para portrait
                    screen.orientation.unlock();
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 0h-4" />';
                }
            } else {
                // Fallback: solicitar fullscreen em landscape
                const elem = document.documentElement;
                if (!document.fullscreenElement) {
                    await elem.requestFullscreen({ orientation: 'landscape' });
                    if (screen.orientation) {
                        await screen.orientation.lock('landscape');
                    }
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                } else {
                    document.exitFullscreen();
                    if (screen.orientation) {
                        screen.orientation.unlock();
                    }
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 0h-4" />';
                }
            }
        } catch (error) {
            // Se não funcionar, mostra mensagem
            alert('Por favor, vire seu celular manualmente para visualizar melhor a tabela em modo paisagem.');
            console.error('Erro ao mudar orientação:', error);
        }
    }
</script>
<style>
    @media (max-width: 768px) {
        .admin-navigation {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 0.75rem !important;
        }
        .stats-container {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 0.75rem !important;
        }
        /* Cards de estatísticas uniformes */
        .stats-card {
            min-height: 140px !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            padding: 1rem !important;
            text-align: center !important;
        }
        .stats-card .text-sm {
            font-size: 0.7rem !important;
            line-height: 1.2 !important;
            white-space: normal !important;
        }
        .stats-card .text-3xl {
            font-size: 1.75rem !important;
            font-weight: 700 !important;
            margin: 0.5rem 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex: 1 !important;
        }
        .stats-card .text-xs {
            font-size: 0.65rem !important;
            line-height: 1.2 !important;
        }
        /* Padding lateral no mobile */
        .min-h-screen .container .py-8 {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }
        /* Tabela centralizada no mobile */
        .overflow-x-auto table {
            margin: 0 auto !important;
        }
        .overflow-x-auto td,
        .overflow-x-auto th {
            text-align: center !important;
        }
        /* Primeira coluna (nome) alinhada à esquerda */
        .overflow-x-auto td:first-child,
        .overflow-x-auto th:first-child {
            text-align: left !important;
        }

    }
    @media (max-width: 480px) {
        /* Cards menores em telas pequenas */
        .stats-card {
            min-height: 120px !important;
            padding: 0.875rem !important;
            text-align: center !important;
        }
        .stats-card .text-sm {
            font-size: 0.65rem !important;
        }
        .stats-card .text-3xl {
            font-size: 1.4rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            flex: 1 !important;
        }
        .stats-card .text-xs {
            font-size: 0.6rem !important;
        }
        /* Padding menor em telas muito pequenas */
        .min-h-screen .container .py-8 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
    }
</style>
<div class="min-h-screen bg-gray-100">
    <div class="container mx-auto">
        <div class="py-8">
            <!-- Admin Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ $title ?? 'Admin Panel' }}</h1>
                <p class="text-gray-600 mt-2">{{ $description ?? '' }}</p>
            </div>

            <!-- Admin Navigation -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 admin-navigation">
                <a href="{{ route('admin.dashboard') }}" class="dashboard-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-2xl font-bold text-blue-600">📊</div>
                    <div class="mt-2 font-semibold">Dashboard</div>
                    <div class="text-sm text-gray-600">Visão geral</div>
                </a>

                <a href="{{ route('admin.facilitadores.index') }}" class="dashboard-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-2xl font-bold text-green-600">👥</div>
                    <div class="mt-2 font-semibold">Facilitadores</div>
                    <div class="text-sm text-gray-600">Gerenciar facilitadores</div>
                </a>

                <a href="{{ route('admin.relatorio-facilitador') }}" class="dashboard-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-2xl font-bold text-purple-600">📈</div>
                    <div class="mt-2 font-semibold">Relatório Facilitadores</div>
                    <div class="text-sm text-gray-600">Dados dos facilitadores</div>
                </a>

                <a href="{{ route('admin.relatorio-mensal') }}" class="dashboard-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
                    <div class="text-2xl font-bold text-orange-600">📅</div>
                    <div class="mt-2 font-semibold">Relatório Mensal</div>
                    <div class="text-sm text-gray-600">Cupons por mês</div>
                </a>

                @if(auth()->user()->isSuperAdmin())
                <a href="{{ route('admin.super') }}" class="dashboard-card bg-white p-4 rounded-lg shadow hover:shadow-lg transition md:col-span-4">
                    <div class="text-2xl font-bold text-red-600">⚙️</div>
                    <div class="mt-2 font-semibold">Super Admin</div>
                    <div class="text-sm text-gray-600">Configurações do sistema</div>
                </a>
                @endif
            </div>

            <!-- Content -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <strong>Erros:</strong>
                        <ul class="list-disc list-inside mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('admin-content')
            </div>
        </div>
    </div>
</div>
@endsection
