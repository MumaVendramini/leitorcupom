<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leitor de Cupom Fiscal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen">
    
    <!-- Desktop Layout -->
    <div id="desktop-view" class="container mx-auto px-4 py-16">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-white mb-4">
                📱 Leitor de Cupom Fiscal
            </h1>
            <p class="text-xl text-white opacity-90">
                Registre suas notas fiscais de forma rápida e fácil
            </p>
        </div>

        <!-- Cards de funcionalidades -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <div class="bg-white rounded-lg shadow-xl p-6 transform hover:scale-105 transition">
                <div class="text-4xl mb-4">📸</div>
                <h3 class="text-xl font-bold mb-2">Escaneie QR Codes</h3>
                <p class="text-gray-600">Use sua câmera para ler cupons fiscais instantaneamente</p>
            </div>

            <div class="bg-white rounded-lg shadow-xl p-6 transform hover:scale-105 transition">
                <div class="text-4xl mb-4">📊</div>
                <h3 class="text-xl font-bold mb-2">Acompanhe Resultados</h3>
                <p class="text-gray-600">Veja suas estatísticas e histórico de notas registradas</p>
            </div>

            <div class="bg-white rounded-lg shadow-xl p-6 transform hover:scale-105 transition">
                <div class="text-4xl mb-4">💰</div>
                <h3 class="text-xl font-bold mb-2">Ganhe Créditos</h3>
                <p class="text-gray-600">Registre notas e acumule créditos para resgatar</p>
            </div>
        </div>

        <!-- Botões de ação -->
        <div class="flex flex-col md:flex-row justify-center gap-4 mb-12">
            <a href="{{ route('register') }}" class="px-8 py-4 rounded-lg text-lg font-semibold transition shadow-lg text-center @if(Route::currentRouteName() === 'register') bg-blue-600 text-white @else bg-white text-blue-600 hover:bg-gray-100 @endif">
                Criar Conta Grátis
            </a>
            <a href="{{ route('login') }}" class="px-8 py-4 rounded-lg text-lg font-semibold transition text-center @if(Route::currentRouteName() === 'login') bg-blue-600 text-white @else bg-white text-blue-600 border-2 border-white hover:bg-gray-100 @endif">
                Já tenho conta
            </a>
        </div>

        <!-- Informações adicionais -->
        <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-8 text-white max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold mb-4">Como funciona?</h2>
            <ol class="space-y-3">
                <li class="flex items-start">
                    <span class="font-bold mr-3">1.</span>
                    <span>Cadastre-se usando o código de indicação do seu facilitador</span>
                </li>
                <li class="flex items-start">
                    <span class="font-bold mr-3">2.</span>
                    <span>Faça login e acesse a área de escaneamento</span>
                </li>
                <li class="flex items-start">
                    <span class="font-bold mr-3">3.</span>
                    <span>Aponte a câmera para o QR Code do cupom fiscal</span>
                </li>
                <li class="flex items-start">
                    <span class="font-bold mr-3">4.</span>
                    <span>Acompanhe suas notas e créditos no dashboard</span>
                </li>
            </ol>
        </div>

        <div class="text-center mt-12 text-white opacity-75">
            <p>&copy; 2025 Leitor de Cupom Fiscal. Todos os direitos reservados.</p>
        </div>
    </div>

    <!-- Mobile Layout -->
    <div id="mobile-view" class="hidden container mx-auto px-4 py-6">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-white mb-2">📱 Leitor de Cupom</h1>
            <p class="text-base text-white opacity-90">Registre suas notas fiscais</p>
        </div>

        <div class="flex flex-col gap-3 mb-6">
            <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg text-base font-semibold hover:bg-gray-100 transition shadow-lg text-center">
                Já tenho conta
            </a>
            <a href="{{ route('register') }}" class="bg-transparent border-2 border-white text-white px-6 py-3 rounded-lg text-base font-semibold hover:bg-white hover:text-blue-600 transition text-center">
                Criar Conta Grátis
            </a>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-xl p-4">
                <div class="text-3xl mb-2">📸</div>
                <h3 class="text-base font-bold mb-1">Escaneie QR Codes</h3>
                <p class="text-xs text-gray-600">Use sua câmera para ler cupons</p>
            </div>

            <div class="bg-white rounded-lg shadow-xl p-4">
                <div class="text-3xl mb-2">📊</div>
                <h3 class="text-base font-bold mb-1">Acompanhe Resultados</h3>
                <p class="text-xs text-gray-600">Veja estatísticas e histórico</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-xl p-4">
                <div class="text-3xl mb-2">💰</div>
                <h3 class="text-base font-bold mb-1">Ganhe Créditos</h3>
                <p class="text-xs text-gray-600">Acumule créditos para resgatar</p>
            </div>
        </div>

        <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-4 text-white">
            <h2 class="text-xl font-bold mb-3">Como funciona?</h2>
            <ol class="space-y-2 text-sm">
                <li class="flex items-start">
                    <span class="font-bold mr-2">1.</span>
                    <span>Cadastre-se com código do facilitador</span>
                </li>
                <li class="flex items-start">
                    <span class="font-bold mr-2">2.</span>
                    <span>Faça login e acesse o escaneamento</span>
                </li>
                <li class="flex items-start">
                    <span class="font-bold mr-2">3.</span>
                    <span>Aponte câmera para o QR Code</span>
                </li>
                <li class="flex items-start">
                    <span class="font-bold mr-2">4.</span>
                    <span>Acompanhe no dashboard</span>
                </li>
            </ol>
        </div>

        <div class="text-center mt-6 text-white opacity-75 text-xs">
            <p>&copy; 2025 Leitor de Cupom Fiscal</p>
        </div>
    </div>

    <script>
        function isMobile() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || window.innerWidth <= 768;
        }

        if (isMobile()) {
            document.getElementById('desktop-view').classList.add('hidden');
            document.getElementById('mobile-view').classList.remove('hidden');
        }
    </script>
</body>
</html>
