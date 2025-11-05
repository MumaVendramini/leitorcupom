@extends('layouts.app')

@section('title', 'Cadastro')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Criar Conta
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Cadastre-se para registrar cupons fiscais
            </p>
        </div>
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register.usuario') }}">
            @csrf
            
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="nome" class="block text-sm font-medium text-gray-700">Nome completo</label>
                    <input id="nome" name="nome" type="text" required value="{{ old('nome') }}"
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="João Silva">
                    @error('nome')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="seu@email.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                    <input id="password" name="password" type="password" required
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="Mínimo 6 caracteres">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar senha</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                           placeholder="Digite a senha novamente">
                </div>

                <div>
                    <label for="codigo_facilitador" class="block text-sm font-medium text-gray-700">
                        Código do Facilitador <span class="text-red-500">*</span>
                    </label>
                    <input id="codigo_facilitador" name="codigo_facilitador" type="text" required value="{{ old('codigo_facilitador') }}"
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm uppercase" 
                           placeholder="Digite o código fornecido">
                    <p class="text-xs text-gray-500 mt-1">Informe o código que você recebeu do seu facilitador</p>
                    @error('codigo_facilitador')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Criar Conta
                </button>
            </div>
        </form>

        <div class="text-center">
            <p class="text-sm text-gray-600">
                Já tem uma conta? 
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Faça login
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
