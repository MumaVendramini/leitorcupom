@extends('admin.layout')

@section('admin-content')
<div>
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <h2 class="text-2xl md:text-3xl font-bold leading-tight">Facilitadores</h2>
        <a href="{{ route('admin.facilitadores.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 md:px-4 md:py-2 rounded-lg text-sm md:text-base transition whitespace-nowrap">
            + Novo Facilitador
        </a>
    </div>

    @if(count($facilitadores) > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>

                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuários</th>
                        <th class="px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($facilitadores as $facilitador)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $facilitador->nome }}</div>
                        </td>

                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $facilitador->codigo_indicacao ?? 'Gerar' }}
                            </span>
                        </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $facilitador->usuarios_count ?? 0 }}
                            </span>
                        </td>
                        <td class="px-4 md:px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            @if(!$facilitador->codigo_indicacao)
                                <form action="{{ route('admin.gerar-codigo', $facilitador) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 transition text-xs md:text-sm">Gerar</button>
                                </form>
                            @endif
                            <a href="{{ route('admin.facilitadores.edit', $facilitador) }}" class="text-blue-600 hover:text-blue-900 transition text-xs md:text-sm">Editar</a>
                            <form action="{{ route('admin.facilitadores.destroy', $facilitador) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition text-xs md:text-sm">Deletar</button>
                            </form>
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
            <p class="text-gray-500 mb-4">Nenhum facilitador cadastrado</p>
            <a href="{{ route('admin.facilitadores.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                + Criar Primeiro Facilitador
            </a>
        </div>
    @endif
</div>
@endsection
