# 🐘 Como Instalar PostgreSQL no Windows

## Opção 1: Instalador Oficial (RECOMENDADO)

### 1. Baixar PostgreSQL

Acesse: https://www.postgresql.org/download/windows/

Ou baixe direto: https://www.enterprisedb.com/downloads/postgres-postgresql-downloads

**Versão recomendada:** PostgreSQL 15.x ou 16.x (64-bit Windows)

### 2. Executar o instalador

1. Execute o arquivo `.exe` baixado
2. Clique em "Next"
3. Escolha a pasta de instalação (padrão: `C:\Program Files\PostgreSQL\16`)
4. Selecione componentes:
   - ✅ PostgreSQL Server
   - ✅ pgAdmin 4 (interface gráfica)
   - ✅ Command Line Tools
5. Escolha pasta de dados (pode deixar padrão)
6. **IMPORTANTE:** Defina uma senha para o usuário `postgres`
   - **Anote essa senha!** Você vai precisar dela
7. Porta: `5432` (padrão - deixe assim)
8. Locale: Padrão do sistema
9. Clique em "Next" e "Install"
10. Aguarde instalação (pode demorar alguns minutos)

### 3. Após a instalação

O PostgreSQL será instalado como serviço do Windows e iniciará automaticamente.

---

## Opção 2: Via Chocolatey (Mais Rápido)

Se você tiver permissões de administrador:

### Instalar Chocolatey primeiro:

Abra PowerShell **como Administrador** e execute:

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))
```

### Depois instale PostgreSQL:

```powershell
choco install postgresql15 -y
```

Senha padrão será `postgres` para o usuário `postgres`.

---

## Verificar se PostgreSQL está rodando

Abra PowerShell e execute:

```powershell
Get-Service -Name "*postgres*"
```

Deve mostrar status: **Running**

---

## Criar o Banco de Dados

### Opção A: Via pgAdmin (Interface Gráfica)

1. Abra **pgAdmin 4** (instalado junto com PostgreSQL)
2. Conecte-se ao servidor local
   - Host: `localhost`
   - Porta: `5432`
   - Usuário: `postgres`
   - Senha: (a que você definiu na instalação)
3. Clique com botão direito em "Databases"
4. Selecione "Create" > "Database"
5. Nome: `leitorcupom`
6. Clique em "Save"

### Opção B: Via Linha de Comando

Abra PowerShell e execute:

```powershell
# Adicionar psql ao PATH temporariamente
$env:Path += ";C:\Program Files\PostgreSQL\16\bin"

# Criar banco
psql -U postgres -c "CREATE DATABASE leitorcupom;"
```

Digite a senha do postgres quando solicitado.

---

## Configurar o Projeto Laravel

Depois de instalar PostgreSQL e criar o banco, volte para o projeto:

1. Edite o arquivo `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=leitorcupom
DB_USERNAME=postgres
DB_PASSWORD=sua_senha_aqui
```

2. Execute as migrations:

```powershell
php artisan migrate
```

3. Popule com dados de teste:

```powershell
php artisan db:seed --class=DemoSeeder
```

4. Inicie o servidor:

```powershell
php artisan serve
```

Acesse: http://localhost:8000

---

## 🎯 QUANTO TEMPO VAI LEVAR?

- Download: ~2-5 minutos (depende da internet)
- Instalação: ~3-5 minutos
- Configuração: ~2 minutos
- **TOTAL: ~10-15 minutos**

---

## ✅ Checklist

- [ ] Baixei o instalador PostgreSQL
- [ ] Instalei e defini senha para usuário `postgres`
- [ ] PostgreSQL está rodando (verifiquei o serviço)
- [ ] Criei o banco `leitorcupom` (via pgAdmin ou psql)
- [ ] Editei `.env` com as credenciais corretas
- [ ] Executei `php artisan migrate`
- [ ] Executei `php artisan db:seed --class=DemoSeeder`
- [ ] Servidor rodando (`php artisan serve`)

---

## 🐛 Problemas Comuns

### "Não consigo conectar ao banco"
- Verifique se o serviço PostgreSQL está rodando
- Confirme que a senha no `.env` está correta
- Tente conectar via pgAdmin primeiro para testar

### "psql não é reconhecido"
- Adicione ao PATH: `C:\Program Files\PostgreSQL\16\bin`
- Ou use pgAdmin para criar o banco

### "Porta 5432 já está em uso"
- Você pode ter outro PostgreSQL rodando
- Ou outro serviço usando essa porta
- Mude para porta 5433 no instalador e no `.env`

---

## 💡 DICA

Se quiser testar AGORA sem instalar PostgreSQL:

1. Eu configuro SQLite temporariamente
2. Você testa todas as funcionalidades
3. Depois migra para PostgreSQL quando precisar escalar

**Diferenças SQLite vs PostgreSQL para este projeto:**

| Recurso | SQLite | PostgreSQL |
|---------|--------|------------|
| **Desenvolvimento local** | ✅ Perfeito | ✅ Perfeito |
| **Milhões de linhas** | ❌ Lento/instável | ✅ Otimizado |
| **Queries complexas** | ⚠️ Limitado | ✅ Completo |
| **Concorrência** | ❌ Bloqueios | ✅ Múltiplos usuários |
| **Produção** | ❌ Não recomendado | ✅ Ideal |
| **Instalação** | ✅ Zero (built-in) | ⚠️ Precisa instalar |

**Para testar agora:** SQLite
**Para produção com milhões de registros:** PostgreSQL obrigatório

---

**O que você prefere?**

1. **Instalar PostgreSQL agora** (siga este guia - 15 min)
2. **Testar com SQLite agora** e migrar depois (eu configuro em 2 min)
