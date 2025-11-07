# 🚀 APP RODANDO! ACESSE AGORA

## ✅ Servidor iniciado em: http://localhost:8000

---

## 🎯 COMECE TESTANDO AQUI:

### 1️⃣ Login como FACILITADOR

**URL:** http://localhost:8000/login

**Clique na aba "Facilitador"**

- **Email:** `joao@facilitador.com`
- **Senha:** `password`

**O que você vai ver:**
- ✅ Dashboard do facilitador
- ✅ Código de indicação: **JOAO2025**
- ✅ 2 usuários indicados (Pedro e Ana)
- ✅ Total de notas cadastradas
- ✅ Valor total

---

### 2️⃣ Login como USUÁRIO

**URL:** http://localhost:8000/login

**Clique na aba "Usuário"**

- **Email:** `pedro@usuario.com`
- **Senha:** `password`

**O que você vai ver:**
- ✅ Dashboard do usuário
- ✅ 2 notas fiscais já cadastradas
- ✅ Valor total
- ✅ Botão "Escanear QR Code"

---

### 3️⃣ Escanear QR Code (Registrar Nota)

**Com usuário logado, acesse:**

http://localhost:8000/scan-qrcode

**Como testar SEM QR Code físico:**

1. Role até "Ou digite a chave manualmente"
2. Cole esta chave de teste (44 dígitos):
   ```
   35250212345678000123550010000009991234567894
   ```
3. Clique em "Registrar Cupom"
4. ✅ Nota será registrada!

---

### 4️⃣ Cadastrar Novo Usuário

**URL:** http://localhost:8000/register

**Preencha:**
- Nome: Seu Nome
- Email: teste@exemplo.com
- Senha: password
- Confirmar Senha: password
- **Código do Facilitador:** `JOAO2025`

**Resultado:**
- ✅ Usuário criado e logado automaticamente
- ✅ Dashboard vazio (nenhuma nota ainda)

---

## 📋 TODOS OS LOGINS DISPONÍVEIS:

### Facilitadores:
| Email | Senha | Código |
|-------|-------|--------|
| joao@facilitador.com | password | JOAO2025 |
| maria@facilitador.com | password | MARIA2025 |

### Usuários:
| Email | Senha | Facilitador |
|-------|-------|-------------|
| pedro@usuario.com | password | João (JOAO2025) |
| ana@usuario.com | password | João (JOAO2025) |
| carlos@usuario.com | password | Maria (MARIA2025) |

---

## 🧪 TESTANDO A API (Console do Navegador)

### Abra DevTools (F12) → Aba Console

**1. Listar suas notas:**
```javascript
fetch('/api/notas')
  .then(r => r.json())
  .then(data => console.log(data));
```

**2. Registrar nova nota:**
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
.then(data => console.log(data));
```

---

## 🎨 PÁGINAS PRINCIPAIS:

| URL | Descrição |
|-----|-----------|
| http://localhost:8000 | Página inicial |
| http://localhost:8000/login | Login (Usuário ou Facilitador) |
| http://localhost:8000/register | Cadastro de novo usuário |
| http://localhost:8000/dashboard | Dashboard do Usuário |
| http://localhost:8000/facilitador/dashboard | Dashboard do Facilitador |
| http://localhost:8000/scan-qrcode | Página de leitura de QR Code |
| http://localhost:8000/admin/facilitadores | Admin (só facilitador logado) |

---

## ✅ FLUXO COMPLETO DE TESTE:

1. ✅ Acesse http://localhost:8000/login
2. ✅ Logue como facilitador (`joao@facilitador.com` / `password`)
3. ✅ Veja código JOAO2025 e usuários indicados
4. ✅ Faça logout
5. ✅ Logue como usuário (`pedro@usuario.com` / `password`)
6. ✅ Veja 2 notas já cadastradas
7. ✅ Clique em "Escanear QR Code"
8. ✅ Registre nova nota manualmente
9. ✅ Volte ao dashboard e veja a nova nota
10. ✅ Faça logout
11. ✅ Cadastre novo usuário com código JOAO2025
12. ✅ Logue como facilitador de novo
13. ✅ Veja que agora tem 3 usuários indicados!

---

## 🐛 Se algo não funcionar:

**Ver erros:**
- Abra DevTools (F12) → Aba Console
- Abra DevTools (F12) → Aba Network

**Servidor caiu?**
```powershell
php artisan serve
```

**Ver logs do Laravel:**
- Arquivo: `storage/logs/laravel.log`

---

## 🎉 PRONTO PARA TESTAR!

**Servidor rodando em:** http://localhost:8000

**Primeiro acesso:** http://localhost:8000/login

**Facilitador:** `joao@facilitador.com` / `password`

**Usuário:** `pedro@usuario.com` / `password`

---

**Aproveite e teste tudo! Qualquer dúvida, me chame!** 🚀
