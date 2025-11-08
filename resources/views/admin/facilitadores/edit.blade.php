@extends('admin.layout')

@section('admin-content')
<div>
    <div class="mb-6">
        <a href="{{ route('admin.facilitadores.index') }}" class="text-blue-600 hover:text-blue-900">← Voltar</a>
    </div>

    <h2 class="text-2xl font-bold mb-6">Editar Facilitador</h2>

    <form action="{{ route('admin.facilitadores.update', $facilitador) }}" method="POST" class="max-w-2xl">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nome" class="block text-sm font-medium text-gray-700">Nome *</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome', $facilitador->nome) }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2">
            @error('nome')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email', $facilitador->email) }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $facilitador->telefone) }}" placeholder="(11) 99999-9999"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2">
            @error('telefone')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="cpf" class="block text-sm font-medium text-gray-700">CPF *</label>
            <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $facilitador->cpf) }}" placeholder="000.000.000-00" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2">
            @error('cpf')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade *</label>
                <input type="text" id="cidade" name="cidade" value="{{ old('cidade', $facilitador->cidade) }}" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2">
                @error('cidade')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado *</label>
                <select id="estado" name="estado" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2">
                    <option value="">Selecione um estado</option>
                    <option value="AC" {{ old('estado', $facilitador->estado) === 'AC' ? 'selected' : '' }}>Acre</option>
                    <option value="AL" {{ old('estado', $facilitador->estado) === 'AL' ? 'selected' : '' }}>Alagoas</option>
                    <option value="AP" {{ old('estado', $facilitador->estado) === 'AP' ? 'selected' : '' }}>Amapá</option>
                    <option value="AM" {{ old('estado', $facilitador->estado) === 'AM' ? 'selected' : '' }}>Amazonas</option>
                    <option value="BA" {{ old('estado', $facilitador->estado) === 'BA' ? 'selected' : '' }}>Bahia</option>
                    <option value="CE" {{ old('estado', $facilitador->estado) === 'CE' ? 'selected' : '' }}>Ceará</option>
                    <option value="DF" {{ old('estado', $facilitador->estado) === 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                    <option value="ES" {{ old('estado', $facilitador->estado) === 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                    <option value="GO" {{ old('estado', $facilitador->estado) === 'GO' ? 'selected' : '' }}>Goiás</option>
                    <option value="MA" {{ old('estado', $facilitador->estado) === 'MA' ? 'selected' : '' }}>Maranhão</option>
                    <option value="MT" {{ old('estado', $facilitador->estado) === 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                    <option value="MS" {{ old('estado', $facilitador->estado) === 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                    <option value="MG" {{ old('estado', $facilitador->estado) === 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                    <option value="PA" {{ old('estado', $facilitador->estado) === 'PA' ? 'selected' : '' }}>Pará</option>
                    <option value="PB" {{ old('estado', $facilitador->estado) === 'PB' ? 'selected' : '' }}>Paraíba</option>
                    <option value="PR" {{ old('estado', $facilitador->estado) === 'PR' ? 'selected' : '' }}>Paraná</option>
                    <option value="PE" {{ old('estado', $facilitador->estado) === 'PE' ? 'selected' : '' }}>Pernambuco</option>
                    <option value="PI" {{ old('estado', $facilitador->estado) === 'PI' ? 'selected' : '' }}>Piauí</option>
                    <option value="RJ" {{ old('estado', $facilitador->estado) === 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                    <option value="RN" {{ old('estado', $facilitador->estado) === 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                    <option value="RS" {{ old('estado', $facilitador->estado) === 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                    <option value="RO" {{ old('estado', $facilitador->estado) === 'RO' ? 'selected' : '' }}>Rondônia</option>
                    <option value="RR" {{ old('estado', $facilitador->estado) === 'RR' ? 'selected' : '' }}>Roraima</option>
                    <option value="SC" {{ old('estado', $facilitador->estado) === 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                    <option value="SP" {{ old('estado', $facilitador->estado) === 'SP' ? 'selected' : '' }}>São Paulo</option>
                    <option value="SE" {{ old('estado', $facilitador->estado) === 'SE' ? 'selected' : '' }}>Sergipe</option>
                    <option value="TO" {{ old('estado', $facilitador->estado) === 'TO' ? 'selected' : '' }}>Tocantins</option>
                </select>
                @error('estado')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                Atualizar Facilitador
            </button>
            <a href="{{ route('admin.facilitadores.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
