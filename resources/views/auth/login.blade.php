@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Entrar no Sistema
            </h2>
        </div>
        
        <!-- Tabs para escolher tipo de login -->
        <div class="flex border-b">
            <button onclick="showTab('usuario')" id="tab-usuario" class="flex-1 py-2 px-4 text-center border-b-2 border-blue-500 font-semibold text-blue-600">
                Usuário
            </button>
            <button onclick="showTab('facilitador')" id="tab-facilitador" class="flex-1 py-2 px-4 text-center border-b-2 border-transparent font-semibold text-gray-500 hover:text-gray-700">
                Facilitador
            </button>
        </div>

        <!-- Form Login Usuário -->
        <form id="form-usuario" class="mt-8 space-y-6" method="POST" action="{{ route('login.usuario') }}">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="usuario-email" class="sr-only">Email</label>
                    <input id="usuario-email" name="email" type="email" required value="pedro@usuario.com" autofocus
                           class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Email">
                </div>
                <div class="relative">
                    <label for="usuario-password" class="sr-only">Senha</label>
                    <input id="usuario-password" name="password" type="password" required value="password"
                           class="appearance-none rounded-b-md relative block w-full pr-12 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Senha">
                    <button type="button" onclick="togglePassword('usuario-password','toggle-usuario')" id="toggle-usuario"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                        👁️
                    </button>
                </div>
            </div>

            @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Entrar como Usuário
                </button>
            </div>
        </form>

        <!-- Form Login Facilitador -->
        <form id="form-facilitador" class="mt-8 space-y-6 hidden" method="POST" action="{{ route('login.facilitador') }}">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="facilitador-email" class="sr-only">Email</label>
                    <input id="facilitador-email" name="email" type="email" value="joao@facilitador.com"
                           class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Email">
                </div>
                <div class="relative">
                    <label for="facilitador-password" class="sr-only">Senha</label>
                    <input id="facilitador-password" name="password" type="password" value="password"
                           class="appearance-none rounded-b-md relative block w-full pr-12 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                           placeholder="Senha">
                    <button type="button" onclick="togglePassword('facilitador-password','toggle-facilitador')" id="toggle-facilitador"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                        👁️
                    </button>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Entrar como Facilitador
                </button>
            </div>
        </form>

        <div class="text-center">
            <p class="text-sm text-gray-600">
                Não tem uma conta? 
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Cadastre-se
                </a>
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showTab(type) {
    const usuarioTab = document.getElementById('tab-usuario');
    const facilitadorTab = document.getElementById('tab-facilitador');
    const usuarioForm = document.getElementById('form-usuario');
    const facilitadorForm = document.getElementById('form-facilitador');

    if (type === 'usuario') {
        usuarioTab.classList.add('border-blue-500', 'text-blue-600');
        usuarioTab.classList.remove('border-transparent', 'text-gray-500');
        facilitadorTab.classList.remove('border-blue-500', 'text-blue-600');
        facilitadorTab.classList.add('border-transparent', 'text-gray-500');
        usuarioForm.classList.remove('hidden');
        facilitadorForm.classList.add('hidden');
    } else {
        facilitadorTab.classList.add('border-green-500', 'text-green-600');
        facilitadorTab.classList.remove('border-transparent', 'text-gray-500');
        usuarioTab.classList.remove('border-blue-500', 'text-blue-600');
        usuarioTab.classList.add('border-transparent', 'text-gray-500');
        facilitadorForm.classList.remove('hidden');
        usuarioForm.classList.add('hidden');
    }
}

function togglePassword(inputId, btnId) {
    const input = document.getElementById(inputId);
    const btn = document.getElementById(btnId);
    if (!input) return;
    if (input.type === 'password') {
        input.type = 'text';
        btn.textContent = '🙈';
    } else {
        input.type = 'password';
        btn.textContent = '👁️';
    }
}
</script>
@endpush
@endsection
