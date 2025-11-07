# 🧪 Guia de Testes do Leitor de Cupom Fiscal

## ✅ Testes Automatizados - CONCLUÍDOS

Todos os 18 testes automatizados estão **PASSANDO**:

```powershell
php artisan test
```

### Cobertura dos Testes:
- ✅ Login de usuário e facilitador
- ✅ Registro de novo usuário com código válido/inválido
- ✅ Logout seguro
- ✅ Registro de nota fiscal via API
- ✅ Validação de chave duplicada
- ✅ Listagem e exclusão de notas
- ✅ Acesso aos dashboards
- ✅ Proteção de rotas (autenticação)

---

## 🚀 AGORA VOCÊ PRECISA TESTAR MANUALMENTE

### Pré-requisitos Para Você Validar

1. **PostgreSQL instalado e rodando**
2. **Arquivo `.env` configurado** (vou criar se não existir)
3. **Banco de dados criado**
4. **Migrations executadas**
5. **Dados de teste populados**

---

## 📋 CHECKLIST DE TESTES PARA VOCÊ EXECUTAR

### ✅ TESTE 1: Configuração Inicial do Ambiente

Execute estes comandos em sequência:

```powershell
# 1. Criar arquivo .env (se não existir)
# (Vou criar para você)

# 2. Gerar chave da aplicação
php artisan key:generate

# 3. Criar banco de dados no PostgreSQL
# Abra psql ou pgAdmin e execute:
CREATE DATABASE leitorcupom;

# 4. Rodar migrations
php artisan migrate

# 5. Popular dados de teste
php artisan db:seed --class=DemoSeeder
```

**O que você deve verificar:**
- [ ] Comando `php artisan key:generate` executou sem erro
- [ ] Banco `leitorcupom` foi criado no PostgreSQL
- [ ] Migrations criaram 7 tabelas sem erro
- [ ] Seeder exibiu mensagens de sucesso com emails e códigos

**Dados de teste criados:**

**Facilitadores:**
- Email: `joao@facilitador.com` | Senha: `password` | Código: `JOAO2025`
- Email: `maria@facilitador.com` | Senha: `password` | Código: `MARIA2025`

**Usuários:**
- Email: `pedro@usuario.com` | Senha: `password` (indicado por JOAO2025)
- Email: `ana@usuario.com` | Senha: `password` (indicado por JOAO2025)
- Email: `carlos@usuario.com` | Senha: `password` (indicado por MARIA2025)

---

### ✅ TESTE 2: Subir Servidor e Assets

Execute em **dois terminais separados**:

**Terminal 1 - Servidor Laravel:**
```powershell
php artisan serve
```

**Terminal 2 - Compilação de Assets:**
```powershell
npm run dev
```

**O que você deve verificar:**
- [ ] Servidor subiu em `http://localhost:8000`
- [ ] npm compilou assets sem erro
- [ ] Acessando `http://localhost:8000` no navegador carrega a página inicial

---

### ✅ TESTE 3: Login como Facilitador

1. Acesse: `http://localhost:8000/login`
2. Clique na aba **"Facilitador"**
3. Digite:
   - Email: `joao@facilitador.com`
   - Senha: `password`
4. Clique em "Entrar"

**O que você deve verificar:**
- [ ] Redirecionou para `/facilitador/dashboard`
- [ ] Dashboard mostra o nome "João Silva"
- [ ] Exibe código de indicação: **JOAO2025**
- [ ] Mostra quantidade de usuários indicados (2)
- [ ] Mostra total de notas cadastradas
- [ ] Lista os usuários "Pedro Oliveira" e "Ana Costa"

---

### ✅ TESTE 4: Logout e Login como Usuário

1. No dashboard do facilitador, faça logout
2. Volte para `http://localhost:8000/login`
3. Na aba **"Usuário"**, digite:
   - Email: `pedro@usuario.com`
   - Senha: `password`
4. Clique em "Entrar"

**O que você deve verificar:**
- [ ] Redirecionou para `/dashboard`
- [ ] Dashboard mostra o nome "Pedro Oliveira"
- [ ] Exibe total de notas cadastradas (2 notas criadas pelo seeder)
- [ ] Mostra valor total das notas
- [ ] Lista as últimas notas com chaves, valores e datas

---

### ✅ TESTE 5: Acessar Página de Scan QR Code

1. Logado como usuário, clique em **"Escanear QR Code"** (ou acesse `/scan-qrcode`)

**O que você deve verificar:**
- [ ] Página carregou sem erro
- [ ] Existe área para câmera/scanner
- [ ] Existe opção de digitação manual de chave
- [ ] Existe histórico de notas escaneadas (se houver)

---

### ✅ TESTE 6: Registrar Nota Fiscal Manualmente (SEM QR Code Físico)

Na página `/scan-qrcode`:

1. Procure a seção **"Ou digite a chave manualmente"**
2. Digite esta chave de teste (44 dígitos):
   ```
   35250212345678000123550010000009991234567894
   ```
3. Clique em **"Registrar Cupom"**

**O que você deve verificar:**
- [ ] Mensagem de sucesso apareceu
- [ ] Nota foi adicionada ao histórico da página
- [ ] Voltando ao dashboard (`/dashboard`), a nova nota aparece na lista
- [ ] Total de notas aumentou

---

### ✅ TESTE 7: Tentar Registrar Nota Duplicada

1. Ainda em `/scan-qrcode`, tente registrar a **MESMA** chave novamente:
   ```
   35250212345678000123550010000009991234567894
   ```

**O que você deve verificar:**
- [ ] Sistema exibe erro de chave duplicada
- [ ] Nota NÃO foi registrada novamente

---

### ✅ TESTE 8: Registrar Novo Usuário com Código de Indicação

1. Faça logout
2. Acesse: `http://localhost:8000/register`
3. Preencha:
   - Nome: `Seu Nome Teste`
   - Email: `teste@exemplo.com`
   - Senha: `password`
   - Confirmar Senha: `password`
   - Código do Facilitador: `JOAO2025`
4. Clique em "Cadastrar"

**O que você deve verificar:**
- [ ] Cadastro realizado com sucesso
- [ ] Redirecionou para `/dashboard`
- [ ] Dashboard mostra o nome que você digitou
- [ ] Total de notas é zero (usuário novo)

---

### ✅ TESTE 9: Tentar Cadastro com Código Inválido

1. Faça logout
2. Volte para `/register`
3. Tente cadastrar com código: `INVALIDO123`

**O que você deve verificar:**
- [ ] Sistema exibe erro de validação
- [ ] Usuário NÃO foi cadastrado
- [ ] Mensagem indica que código não existe

---

### ✅ TESTE 10: Verificar Dados do Novo Usuário no Dashboard do Facilitador

1. Faça logout do usuário
2. Faça login como facilitador:
   - Email: `joao@facilitador.com`
   - Senha: `password`
3. Acesse `/facilitador/dashboard`

**O que você deve verificar:**
- [ ] Total de usuários indicados AUMENTOU (agora 3, se você criou o usuário teste)
- [ ] Novo usuário aparece na lista de indicados
- [ ] Facilitador consegue ver todas as notas dos seus usuários

---

### ✅ TESTE 11: Testar API via Console do Navegador (DevTools)

1. Faça login como usuário (`pedro@usuario.com`)
2. Abra DevTools (F12)
3. Na aba Console, execute:

```javascript
// Listar notas do usuário logado
fetch('/api/notas')
  .then(r => r.json())
  .then(data => console.log('Minhas notas:', data));
```

**O que você deve verificar:**
- [ ] Console retornou JSON com lista de notas
- [ ] Contém paginação e dados corretos

4. Registrar nova nota via API:

```javascript
fetch('/api/notas', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  },
  body: JSON.stringify({
    chave_acesso: '35250212345678000123550010000008881234567893'
  })
})
.then(r => r.json())
.then(data => console.log('Resultado:', data));
```

**O que você deve verificar:**
- [ ] Retornou `{ "success": true, ... }`
- [ ] Nova nota foi criada
- [ ] Recarregando `/api/notas`, a nota aparece

---

### ✅ TESTE 12: Proteção de Rotas Admin

1. **SEM estar logado**, tente acessar:
   - `http://localhost:8000/admin/facilitadores`

**O que você deve verificar:**
- [ ] Redirecionou para `/login`
- [ ] Não conseguiu acessar sem autenticação

2. Faça login como **usuário** (não facilitador):
   - Tente acessar: `http://localhost:8000/admin/facilitadores`

**O que você deve verificar:**
- [ ] Redirecionou ou deu erro 403/401
- [ ] Usuário comum NÃO pode acessar área admin

3. Faça login como **facilitador**:
   - Acesse: `http://localhost:8000/admin/facilitadores`

**O que você deve verificar:**
- [ ] Página carregou com lista de facilitadores
- [ ] Facilitador consegue ver dados administrativos

---

### ✅ TESTE 13: Responsividade (Mobile)

1. Abra DevTools (F12)
2. Ative modo responsivo (Ctrl+Shift+M)
3. Simule iPhone/Android
4. Navegue pelas páginas:
   - Login
   - Dashboard
   - Scan QR Code

**O que você deve verificar:**
- [ ] Layout se ajusta para mobile
- [ ] Botões são clicáveis
- [ ] Textos legíveis
- [ ] Scanner de QR Code funciona em mobile simulado

---

## 🎯 RESUMO DO QUE VOCÊ DEVE VALIDAR

### Ambiente:
- [x] PHP 7.4.30 funcionando
- [x] Composer instalado
- [ ] PostgreSQL instalado e configurado
- [ ] Banco `leitorcupom` criado
- [ ] Arquivo `.env` configurado

### Funcionalidades:
- [ ] Login Usuário
- [ ] Login Facilitador
- [ ] Logout (multi-guard)
- [ ] Cadastro com código válido
- [ ] Cadastro com código inválido (erro)
- [ ] Dashboard Usuário
- [ ] Dashboard Facilitador
- [ ] Scan QR Code (página)
- [ ] Registro manual de nota
- [ ] Validação nota duplicada
- [ ] Listagem de notas (API)
- [ ] Proteção de rotas admin
- [ ] Agregações corretas (totais, valores)

---

## 🐛 Se Encontrar Problemas

### Erro de conexão ao banco:
```powershell
# Verifique .env:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=leitorcupom
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### Erro de permissão (storage/logs):
```powershell
# Windows PowerShell (como admin):
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

### Assets não carregam:
```powershell
npm install
npm run dev
```

### Migrations com erro:
```powershell
php artisan migrate:fresh
php artisan db:seed --class=DemoSeeder
```

---

## 📊 Status dos Testes Automatizados

```
✅ 18/18 testes passando (100%)

- AuthenticationTest: 5 testes
- NotaFiscalTest: 6 testes  
- DashboardTest: 5 testes
- ExampleTest: 2 testes
```

Executar novamente:
```powershell
php artisan test
```

---

## ✨ Próximos Passos Após Validação

Depois que você validar tudo funcionando:

1. **Commit das melhorias** (quando você pedir)
2. **Adicionar Tailwind CSS** (se quiser)
3. **Criar testes E2E** com browser automation
4. **Integração SEFAZ** para validar notas reais
5. **Deploy** em produção

---

**Última atualização:** Novembro 7, 2025
**Status:** ✅ Testes automatizados OK | ⏳ Aguardando testes manuais
