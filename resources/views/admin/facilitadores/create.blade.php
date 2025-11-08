@extends('admin.layout')

@section('admin-content')
<div>
    <div class="mb-6">
        <a href="{{ route('admin.facilitadores.index') }}" class="text-blue-600 hover:text-blue-900">← Voltar</a>
    </div>

    <h2 class="text-2xl font-bold mb-6">Novo Facilitador</h2>

    <form action="{{ route('admin.facilitadores.store') }}" method="POST" class="max-w-2xl">
        @csrf

        <div class="mb-4">
            <label for="nome" class="block text-sm font-medium text-gray-700">Nome *</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2">
            @error('nome')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2">
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Senha *</label>
            <div class="relative">
                <input type="password" id="password" name="password" required minlength="6"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2 pr-10">
                <button type="button" onclick="togglePassword()" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">Mínimo de 6 caracteres</p>
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
            <input type="text" id="telefone" name="telefone" value="{{ old('telefone') }}" placeholder="(11) 99999-9999" maxlength="15"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2">
            @error('telefone')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="cpf" class="block text-sm font-medium text-gray-700">CPF *</label>
            <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" placeholder="000.000.000-00" maxlength="14" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 border px-3 py-2">
            @error('cpf')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade *</label>
                <input type="text" id="cidade" name="cidade" value="{{ old('cidade') }}" required
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
                    <option value="AC">Acre</option>
                    <option value="AL">Alagoas</option>
                    <option value="AP">Amapá</option>
                    <option value="AM">Amazonas</option>
                    <option value="BA">Bahia</option>
                    <option value="CE">Ceará</option>
                    <option value="DF">Distrito Federal</option>
                    <option value="ES">Espírito Santo</option>
                    <option value="GO">Goiás</option>
                    <option value="MA">Maranhão</option>
                    <option value="MT">Mato Grosso</option>
                    <option value="MS">Mato Grosso do Sul</option>
                    <option value="MG">Minas Gerais</option>
                    <option value="PA">Pará</option>
                    <option value="PB">Paraíba</option>
                    <option value="PR">Paraná</option>
                    <option value="PE">Pernambuco</option>
                    <option value="PI">Piauí</option>
                    <option value="RJ">Rio de Janeiro</option>
                    <option value="RN">Rio Grande do Norte</option>
                    <option value="RS">Rio Grande do Sul</option>
                    <option value="RO">Rondônia</option>
                    <option value="RR">Roraima</option>
                    <option value="SC">Santa Catarina</option>
                    <option value="SP">São Paulo</option>
                    <option value="SE">Sergipe</option>
                    <option value="TO">Tocantins</option>
                </select>
                @error('estado')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                Salvar Facilitador
            </button>
            <a href="{{ route('admin.facilitadores.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                Cancelar
            </a>
        </div>
    </form>
</div>

<script>
    // Toggle de visibilidade da senha
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }

    // Validação de CPF
    function validarCPF(cpf) {
        cpf = cpf.replace(/[^\d]/g, '');
        
        if (cpf.length !== 11) return false;
        if (/^(\d)\1{10}$/.test(cpf)) return false; // CPFs com todos dígitos iguais
        
        // Valida primeiro dígito verificador
        let soma = 0;
        for (let i = 0; i < 9; i++) {
            soma += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let resto = 11 - (soma % 11);
        let digitoVerificador1 = resto === 10 || resto === 11 ? 0 : resto;
        
        if (digitoVerificador1 !== parseInt(cpf.charAt(9))) return false;
        
        // Valida segundo dígito verificador
        soma = 0;
        for (let i = 0; i < 10; i++) {
            soma += parseInt(cpf.charAt(i)) * (11 - i);
        }
        resto = 11 - (soma % 11);
        let digitoVerificador2 = resto === 10 || resto === 11 ? 0 : resto;
        
        return digitoVerificador2 === parseInt(cpf.charAt(10));
    }

    // Formatar telefone: (XX) XXXXX-XXXX
    document.getElementById('telefone').addEventListener('blur', function(e) {
        let valor = e.target.value.replace(/\D/g, '');

        // Validação de telefone (mínimo 10 dígitos)
        if (valor.length > 0 && valor.length < 10) {
            e.target.setCustomValidity('Telefone deve ter pelo menos 10 dígitos');
            e.target.reportValidity();
            return;
        } else {
            e.target.setCustomValidity('');
        }

        if (valor.length === 11) {
            // Celular: (XX) XXXXX-XXXX
            e.target.value = valor.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else if (valor.length === 10) {
            // Fixo: (XX) XXXX-XXXX
            e.target.value = valor.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
        } else if (valor.length > 0) {
            // Mantém apenas números se formato inválido
            e.target.value = valor;
        }
    });

    // Formatar CPF: XXX.XXX.XXX-XX
    document.getElementById('cpf').addEventListener('blur', function(e) {
        let valor = e.target.value.replace(/\D/g, '');

        // Validação de CPF
        if (valor.length > 0) {
            if (valor.length !== 11) {
                e.target.setCustomValidity('CPF deve ter 11 dígitos');
                e.target.reportValidity();
                return;
            }
            
            if (!validarCPF(valor)) {
                e.target.setCustomValidity('CPF inválido');
                e.target.reportValidity();
                return;
            }
            
            e.target.setCustomValidity('');
        }

        if (valor.length === 11) {
            e.target.value = valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        } else if (valor.length > 0) {
            // Mantém apenas números se formato inválido
            e.target.value = valor;
        }
    });

    // Permite apenas números durante digitação
    document.getElementById('telefone').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^\d()-\s]/g, '');
    });

    document.getElementById('cpf').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^\d.-]/g, '');
    });
</script>

@endsection
