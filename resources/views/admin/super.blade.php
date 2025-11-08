@extends('admin.layout')

@section('admin-content')
<div>
    <h2 class="text-2xl font-bold mb-6">Super Admin Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- System Stats -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg p-6 text-white">
            <div class="text-sm font-semibold opacity-90">Usuários Admin</div>
            <div class="text-3xl font-bold mt-2">{{ \App\Models\User::whereIn('role', ['admin', 'super_admin'])->count() }}</div>
            <div class="text-xs mt-2 opacity-75">Contas administrativas</div>
        </div>

        <!-- Database Info -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg p-6 text-white">
            <div class="text-sm font-semibold opacity-90">Total de Facilitadores</div>
            <div class="text-3xl font-bold mt-2">{{ \App\Models\Facilitador::count() }}</div>
            <div class="text-xs mt-2 opacity-75">Cadastros ativos</div>
        </div>

        <!-- API Status -->
        <div class="bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg p-6 text-white">
            <div class="text-sm font-semibold opacity-90">Total de Cupons</div>
            <div class="text-3xl font-bold mt-2">{{ \App\Models\NotaFiscal::count() }}</div>
            <div class="text-xs mt-2 opacity-75">Cupons no sistema</div>
        </div>

        <!-- Storage -->
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg p-6 text-white">
            <div class="text-sm font-semibold opacity-90">Total de Usuários</div>
            <div class="text-3xl font-bold mt-2">{{ \App\Models\Usuario::count() }}</div>
            <div class="text-xs mt-2 opacity-75">Contas de usuários</div>
        </div>
    </div>

    <!-- Developer Tools -->
    <div class="mt-8 bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-bold mb-4">Ferramentas do Desenvolvedor</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 border border-gray-200 rounded-lg">
                <h4 class="font-semibold mb-2">Informações do Sistema</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><strong>Laravel:</strong> {{ app()->version() }}</li>
                    <li><strong>PHP:</strong> {{ phpversion() }}</li>
                    <li><strong>Ambiente:</strong> {{ config('app.env') }}</li>
                    <li><strong>Debug:</strong> {{ config('app.debug') ? 'Ativado' : 'Desativado' }}</li>
                </ul>
            </div>

            <div class="p-4 border border-gray-200 rounded-lg">
                <h4 class="font-semibold mb-2">Ações Rápidas</h4>
                <ul class="text-sm space-y-2">
                    <li>
                        <form action="{{ route('admin.relatorio-facilitador') }}" method="GET" class="inline">
                            <button type="submit" class="text-blue-600 hover:text-blue-900 transition">
                                Ver Todos os Facilitadores →
                            </button>
                        </form>
                    </li>
                    <li>
                        <form action="{{ route('admin.facilitadores.create') }}" method="GET" class="inline">
                            <button type="submit" class="text-blue-600 hover:text-blue-900 transition">
                                Novo Facilitador →
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Database Tables Info -->
    <div class="mt-8 bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-lg font-bold mb-4">Estado do Banco de Dados</h3>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="p-4 bg-blue-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ \App\Models\User::count() }}</div>
                <div class="text-xs text-gray-600 mt-1">Users</div>
            </div>

            <div class="p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ \App\Models\Facilitador::count() }}</div>
                <div class="text-xs text-gray-600 mt-1">Facilitadores</div>
            </div>

            <div class="p-4 bg-purple-50 rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ \App\Models\Usuario::count() }}</div>
                <div class="text-xs text-gray-600 mt-1">Usuários</div>
            </div>

            <div class="p-4 bg-orange-50 rounded-lg">
                <div class="text-2xl font-bold text-orange-600">{{ \App\Models\NotaFiscal::count() }}</div>
                <div class="text-xs text-gray-600 mt-1">Notas Fiscais</div>
            </div>
        </div>
    </div>
</div>
@endsection
