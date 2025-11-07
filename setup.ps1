# Script de Setup Rápido - Leitor de Cupom Fiscal
# Execute este script no PowerShell para configurar o projeto

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  Leitor de Cupom Fiscal - Setup" -ForegroundColor Cyan
Write-Host "========================================`n" -ForegroundColor Cyan

# Passo 1: Verificar dependências
Write-Host "[1/6] Verificando dependências..." -ForegroundColor Yellow

if (!(Get-Command php -ErrorAction SilentlyContinue)) {
    Write-Host "❌ PHP não encontrado. Instale PHP 7.4+ antes de continuar." -ForegroundColor Red
    exit 1
}

if (!(Get-Command composer -ErrorAction SilentlyContinue)) {
    Write-Host "❌ Composer não encontrado. Instale Composer antes de continuar." -ForegroundColor Red
    exit 1
}

if (!(Get-Command npm -ErrorAction SilentlyContinue)) {
    Write-Host "❌ NPM não encontrado. Instale Node.js antes de continuar." -ForegroundColor Red
    exit 1
}

Write-Host "✅ Dependências OK" -ForegroundColor Green

# Passo 2: Instalar dependências PHP
Write-Host "`n[2/6] Instalando dependências PHP (composer)..." -ForegroundColor Yellow
composer install --no-interaction
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Erro ao instalar dependências PHP" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Dependências PHP instaladas" -ForegroundColor Green

# Passo 3: Instalar dependências JS
Write-Host "`n[3/6] Instalando dependências JavaScript (npm)..." -ForegroundColor Yellow
npm install
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Erro ao instalar dependências NPM" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Dependências JavaScript instaladas" -ForegroundColor Green

# Passo 4: Configurar .env
Write-Host "`n[4/6] Configurando arquivo .env..." -ForegroundColor Yellow
if (!(Test-Path .env)) {
    Copy-Item .env.example .env
    Write-Host "✅ Arquivo .env criado" -ForegroundColor Green
} else {
    Write-Host "⚠️  Arquivo .env já existe" -ForegroundColor Yellow
}

# Gerar chave da aplicação
php artisan key:generate --no-interaction
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Erro ao gerar chave da aplicação" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Chave da aplicação gerada" -ForegroundColor Green

# Passo 5: Informações sobre banco de dados
Write-Host "`n[5/6] Configuração do Banco de Dados" -ForegroundColor Yellow
Write-Host "⚠️  ATENÇÃO: Configure o PostgreSQL manualmente!" -ForegroundColor Yellow
Write-Host ""
Write-Host "1. Abra o PostgreSQL (psql ou pgAdmin)" -ForegroundColor White
Write-Host "2. Execute: CREATE DATABASE leitorcupom;" -ForegroundColor White
Write-Host "3. Edite o arquivo .env com suas credenciais:" -ForegroundColor White
Write-Host "   DB_CONNECTION=pgsql" -ForegroundColor Gray
Write-Host "   DB_HOST=127.0.0.1" -ForegroundColor Gray
Write-Host "   DB_PORT=5432" -ForegroundColor Gray
Write-Host "   DB_DATABASE=leitorcupom" -ForegroundColor Gray
Write-Host "   DB_USERNAME=seu_usuario" -ForegroundColor Gray
Write-Host "   DB_PASSWORD=sua_senha" -ForegroundColor Gray
Write-Host ""
Write-Host "Pressione ENTER depois de configurar o banco..." -ForegroundColor Cyan
Read-Host

# Passo 6: Rodar migrations e seeder
Write-Host "`n[6/6] Executando migrations e seeder..." -ForegroundColor Yellow

Write-Host "Criando tabelas..." -ForegroundColor White
php artisan migrate --no-interaction
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Erro ao executar migrations. Verifique a conexão com o banco." -ForegroundColor Red
    Write-Host "   Certifique-se que o PostgreSQL está rodando e o banco 'leitorcupom' foi criado." -ForegroundColor Yellow
    exit 1
}
Write-Host "✅ Tabelas criadas" -ForegroundColor Green

Write-Host "Populando dados de teste..." -ForegroundColor White
php artisan db:seed --class=DemoSeeder --no-interaction
if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ Erro ao popular dados de teste" -ForegroundColor Red
    exit 1
}
Write-Host "✅ Dados de teste populados" -ForegroundColor Green

# Resumo
Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  ✅ Setup Concluído!" -ForegroundColor Green
Write-Host "========================================`n" -ForegroundColor Cyan

Write-Host "Dados de teste criados:" -ForegroundColor Yellow
Write-Host ""
Write-Host "FACILITADORES:" -ForegroundColor White
Write-Host "  • joao@facilitador.com | senha: password | Código: JOAO2025" -ForegroundColor Gray
Write-Host "  • maria@facilitador.com | senha: password | Código: MARIA2025" -ForegroundColor Gray
Write-Host ""
Write-Host "USUÁRIOS:" -ForegroundColor White
Write-Host "  • pedro@usuario.com | senha: password" -ForegroundColor Gray
Write-Host "  • ana@usuario.com | senha: password" -ForegroundColor Gray
Write-Host "  • carlos@usuario.com | senha: password" -ForegroundColor Gray
Write-Host ""

Write-Host "Para iniciar o servidor:" -ForegroundColor Yellow
Write-Host "  Terminal 1: php artisan serve" -ForegroundColor White
Write-Host "  Terminal 2: npm run dev" -ForegroundColor White
Write-Host ""
Write-Host "Acesse: http://localhost:8000" -ForegroundColor Cyan
Write-Host ""
Write-Host "Para rodar testes automatizados:" -ForegroundColor Yellow
Write-Host "  php artisan test" -ForegroundColor White
Write-Host ""
Write-Host "📖 Consulte GUIA_TESTES.md para instruções detalhadas de teste" -ForegroundColor Green
Write-Host ""
