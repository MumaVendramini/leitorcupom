# 🚀 Instruções de Instalação e Teste

## ✅ Sistema Implementado

O sistema de Leitor de Cupom Fiscal está completo com:

- ✅ Models com relacionamentos (Facilitador, Usuario, NotaFiscal)
- ✅ Migrations configuradas para PostgreSQL
- ✅ Controllers (Auth, Usuario, Facilitador, NotaFiscal)
- ✅ Rotas web e API
- ✅ Views com Tailwind CSS
- ✅ Sistema de leitura de QR Code (html5-qrcode)
- ✅ Autenticação separada para Usuários e Facilitadores
- ✅ Dashboards funcionais

## 📦 Passos para Instalação

### 1. Instalar dependências PHP

```powershell
composer install
```

### 2. Configurar ambiente

```powershell
# Copiar arquivo de ambiente
copy .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 3. Configurar PostgreSQL

Edite o arquivo `.env` e configure:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=leitorcupom
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Criar banco de dados

No PostgreSQL:

```sql
CREATE DATABASE leitorcupom;
```

### 5. Executar migrations

```powershell
php artisan migrate
```

### 6. (OPCIONAL) Popular banco com dados de teste

```powershell
php artisan db:seed --class=DemoSeeder
```

Isso criará:
- 2 Facilitadores (joao@facilitador.com / maria@facilitador.com)
- 3 Usuários (pedro@usuario.com / ana@usuario.com / carlos@usuario.com)
- 4 Notas fiscais de exemplo
- Todas as senhas: `password`

### 7. Iniciar servidor

```powershell
php artisan serve
```

Acesse: http://localhost:8000

## 🎯 Testando o Sistema

### Como Facilitador:

1. Acesse http://localhost:8000/login
2. Clique na aba "Facilitador"
3. Login: `joao@facilitador.com` / Senha: `password`
4. Veja seu código de indicação: **JOAO2025**
5. Dashboard mostra usuários indicados e suas notas

### Como Usuário:

1. Acesse http://localhost:8000/register
2. Preencha os dados e use o código: **JOAO2025**
3. Ou faça login com: `pedro@usuario.com` / Senha: `password`
4. No dashboard, clique em "Escanear QR Code"
5. Permita acesso à câmera
6. Aponte para um QR Code de nota fiscal

### Teste Manual (sem QR Code físico):

1. Na página de scan, role até "Ou digite a chave manualmente"
2. Digite uma chave de 44 dígitos (exemplo):
   ```
   35250212345678000123550010000001271234567894
   ```
3. Clique em "Registrar Cupom"

## 📱 Funcionalidades Implementadas

### Autenticação
- ✅ Login separado para Usuário e Facilitador
- ✅ Cadastro de usuário com código do facilitador
- ✅ Guards de autenticação configurados

### Dashboard Usuário
- ✅ Total de notas cadastradas
- ✅ Valor total
- ✅ Últimas 10 notas
- ✅ Botão para escanear QR Code

### Dashboard Facilitador
- ✅ Código de indicação destacado
- ✅ Total de usuários indicados
- ✅ Total de notas dos usuários
- ✅ Valor total
- ✅ Lista de usuários com contagem de notas

### Leitura de QR Code
- ✅ Acesso à câmera via html5-qrcode
- ✅ Extração automática da chave de acesso
- ✅ Envio via API para registro
- ✅ Feedback visual de sucesso/erro
- ✅ Opção de digitação manual
- ✅ Histórico da sessão

### API
- ✅ POST /api/notas - Registrar nota
- ✅ GET /api/notas - Listar notas do usuário
- ✅ GET /api/notas/{id} - Ver detalhes
- ✅ DELETE /api/notas/{id} - Remover nota

## 🗂️ Estrutura de Arquivos Criados/Modificados

```
app/
├── Http/Controllers/
│   ├── AuthController.php         ✅ NOVO
│   ├── FacilitadorController.php  ✅ NOVO
│   ├── UsuarioController.php      ✅ NOVO
│   └── NotaFiscalController.php   ✅ NOVO
├── Models/
│   ├── Facilitador.php            ✅ ATUALIZADO
│   ├── Usuario.php                ✅ ATUALIZADO
│   └── NotaFiscal.php             ✅ ATUALIZADO

config/
└── auth.php                       ✅ ATUALIZADO (guards)

database/
├── migrations/
│   ├── 2025_11_05_201242_create_facilitadors_table.php    ✅ ATUALIZADO
│   ├── 2025_11_05_201250_create_usuarios_table.php        ✅ ATUALIZADO
│   └── 2025_11_05_201259_create_nota_fiscals_table.php    ✅ ATUALIZADO
└── seeders/
    └── DemoSeeder.php             ✅ NOVO

resources/views/
├── layouts/
│   └── app.blade.php              ✅ NOVO
├── auth/
│   ├── login.blade.php            ✅ NOVO
│   └── register.blade.php         ✅ NOVO
├── usuario/
│   ├── dashboard.blade.php        ✅ NOVO
│   └── scan-qrcode.blade.php      ✅ NOVO
└── facilitador/
    └── dashboard.blade.php        ✅ NOVO

routes/
├── web.php                        ✅ ATUALIZADO
└── api.php                        ✅ ATUALIZADO

.env.example                       ✅ ATUALIZADO
README.md                          ✅ ATUALIZADO
```

## 🔧 Possíveis Problemas e Soluções

### Erro de chave da aplicação
```powershell
php artisan key:generate
```

### Erro de permissão nas pastas storage/bootstrap
```powershell
# Windows (PowerShell como Admin)
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

### Câmera não funciona
- Use HTTPS ou localhost (necessário para API de câmera)
- Permita acesso à câmera no navegador
- Use a opção de digitação manual como alternativa

### Erro nas migrations
```powershell
# Limpar e recriar
php artisan migrate:fresh
php artisan db:seed --class=DemoSeeder
```

## 📝 Próximos Passos

1. **Integração com SEFAZ** - Buscar dados reais das notas
2. **Validação avançada** - Verificar notas duplicadas por período
3. **Sistema de créditos** - Calcular pontos/valores
4. **Relatórios exportáveis** - PDF/Excel
5. **Admin dashboard** - Gerenciar facilitadores
6. **OCR** - Leitura sem QR Code (futuro)

## 📞 Suporte

Para testar localmente:
1. Configure PostgreSQL
2. Execute as migrations
3. Use o DemoSeeder para dados de teste
4. Acesse http://localhost:8000

Todas as funcionalidades principais estão implementadas e prontas para uso! 🎉
