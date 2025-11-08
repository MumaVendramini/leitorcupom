@extends('admin.layout')

@section('admin-content')
<div>
    <h2 class="text-2xl font-bold mb-6">Relatório de Facilitadores</h2>

    @if(count($facilitadores) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Facilitador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuários</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cupons</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket Médio</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($facilitadores as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $item['nome'] }}</div>
                            <div class="text-xs text-gray-600">{{ $item['email'] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $item['total_usuarios'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $item['total_cupons'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            R$ {{ number_format($item['valor_total'], 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($item['total_cupons'] > 0)
                                R$ {{ number_format($item['valor_total'] / $item['total_cupons'], 2, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $facilitadores->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">Nenhum facilitador com dados para exibir</p>
        </div>
    @endif
</div>
@endsection
