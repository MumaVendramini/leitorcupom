@extends('admin.layout')

@section('admin-content')
<div>
    <h2 class="text-2xl font-bold mb-6">Dashboard</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 stats-container">
        <!-- Total Facilitadores -->
        <div class="stats-card dashboard-card bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-6 text-white" data-value="{{ $totalFacilitadores }}">
            <div class="text-sm font-semibold opacity-90">Total de Facilitadores</div>
            <div class="text-3xl font-bold mt-2">{{ $totalFacilitadores }}</div>
            <div class="text-xs mt-2 opacity-75">Cadastrados no sistema</div>
        </div>

        <!-- Total Cupons -->
        <div class="stats-card dashboard-card bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white" data-value="{{ $totalCupons }}">
            <div class="text-sm font-semibold opacity-90">Total de Cupons</div>
            <div class="text-3xl font-bold mt-2">{{ $totalCupons }}</div>
            <div class="text-xs mt-2 opacity-75">Emitidos</div>
        </div>

        <!-- Cupons este Mês -->
        <div class="stats-card dashboard-card bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white" data-value="{{ $cupomsMês }}">
            <div class="text-sm font-semibold opacity-90">Cupons este Mês</div>
            <div class="text-3xl font-bold mt-2">{{ $cupomsMês }}</div>
            <div class="text-xs mt-2 opacity-75">Comparado ao mês anterior</div>
        </div>

        <!-- Valor Total -->
        <div class="stats-card dashboard-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-6 text-white" data-value="{{ $valorTotal }}">
            <div class="text-sm font-semibold opacity-90">Valor Total (R$)</div>
            <div class="text-3xl font-bold mt-2">{{ number_format($valorTotal, 2, ',', '.') }}</div>
            <div class="text-xs mt-2 opacity-75">Em cupons</div>
        </div>
    </div>

    <!-- Cupons por Facilitador -->
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold">Cupons por Facilitador</h3>
            <button onclick="toggleTableOrientation()" class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition" title="Alternar orientação da tabela">
                <svg id="orientationIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg>
            </button>
        </div>

        @if(count($cupomsPorFacilitador) > 0)
            <div class="overflow-x-auto table-container">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Facilitador</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cupons</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuários</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($cupomsPorFacilitador as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $item['facilitador'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $item['cupons'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $item['usuarios'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                R$ {{ number_format($item['valor'], 2, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-gray-500 py-8">Nenhum cupom emitido ainda.</p>
        @endif
    </div>
</div>
@endsection
