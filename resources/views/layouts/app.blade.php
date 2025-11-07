<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-language" content="pt-br">
    <meta name="language" content="Portuguese">
    <meta name="google" content="notranslate">
    <title>@yield('title', 'Leitor de Cupom Fiscal')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">
                            📱 Leitor Cupom
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    @auth
                        <div class="relative" id="perfil-dropdown">
                            <button class="px-4 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition" onclick="toggleDropdown()">
                                Perfil
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden" id="dropdown-menu">
                                <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 rounded-t-lg">
                                    Ver Perfil
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 rounded-b-lg">
                                        Sair
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded font-semibold transition @if(Route::currentRouteName() === 'login') bg-blue-600 text-white @else bg-white text-blue-600 hover:bg-gray-100 @endif">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded font-semibold transition @if(Route::currentRouteName() === 'register') bg-blue-600 text-white @else bg-white text-blue-600 hover:bg-gray-100 @endif">
                            Cadastrar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
    
    <script>
        function toggleDropdown() {
            const menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('hidden');
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('perfil-dropdown');
            if (dropdown && !dropdown.contains(event.target)) {
                document.getElementById('dropdown-menu').classList.add('hidden');
            }
        });
    </script>
</body>
</html>
