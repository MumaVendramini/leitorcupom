@extends('admin.layout')

@section('admin-content')
<div>
    <h2 class="text-2xl font-bold mb-6">Relatório Mensal de Cupons</h2>

    <div class="mb-6 flex gap-4">
        <form action="{{ route('admin.relatorio-mensal') }}" method="GET" class="flex gap-4">
            <div>
                <label for="mes" class="block text-sm font-medium text-gray-700">Mês</label>
                <select id="mes" name="mes" class="mt-1 rounded-md border-gray-300 border px-3 py-2">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('mes', now()->month) == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::createFromDate(2024, $i, 1)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="ano" class="block text-sm font-medium text-gray-700">Ano</label>
                <select id="ano" name="ano" class="mt-1 rounded-md border-gray-300 border px-3 py-2">
                    @for($i = now()->year; $i >= now()->year - 5; $i--)
                        <option value="{{ $i }}" {{ request('ano', now()->year) == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    @if(count($cupons) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Facilitador</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuário</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($cupons as $cupom)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">
                                {{ $cupom->created_at->format('d/m/Y H:i') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $cupom->facilitador->nome ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">{{ $cupom->usuario->nome ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            R$ {{ number_format($cupom->valor, 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Ativo
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $cupons->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">Nenhum cupom encontrado para o período selecionado</p>
        </div>
    @endif
</div>
@endsection
