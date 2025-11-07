# 📱 TESTAR NO CELULAR - MODO MANUAL

## ✅ É NORMAL a câmera não funcionar!

Navegadores mobile bloqueiam acesso à câmera em HTTP (sem HTTPS).

**SOLUÇÃO:** Use o **formulário manual** que já aparece na tela!

---

## 🎯 COMO TESTAR NO CELULAR:

### 1. No celular, acesse:
```
http://192.168.0.11:8000/login
```

### 2. Faça login:
- Email: `pedro@usuario.com`
- Senha: `password`

### 3. No dashboard, clique em **"Escanear QR Code"**

### 4. Vai aparecer a mensagem:
> "Não foi possível acessar a câmera. Use o formulário manual abaixo."

### 5. Role para baixo até ver:
**"Ou digite a chave manualmente"**

### 6. Cole esta chave de teste (44 dígitos):
```
35250212345678000123550010000009991234567894
```

### 7. Clique em **"Registrar Cupom"**

### 8. ✅ Sucesso! Vai aparecer:
> "Cupom registrado com sucesso! ✓"

---

## 📋 MAIS CHAVES PARA TESTAR:

Use estas chaves para registrar múltiplas notas:

**Chave 1:**
```
35250212345678000123550010000009991234567894
```

**Chave 2:**
```
35250312345678000123550010000008881234567893
```

**Chave 3:**
```
35250412345678000123550010000007771234567892
```

**Chave 4:**
```
35250512345678000123550010000006661234567891
```

---

## ✅ O QUE TESTAR NO CELULAR:

### Fluxo Completo:

1. ✅ Login como usuário
2. ✅ Ver dashboard (notas existentes)
3. ✅ Acessar página de scan
4. ✅ Registrar nota pelo formulário manual
5. ✅ Ver confirmação de sucesso
6. ✅ Voltar ao dashboard
7. ✅ Verificar que nova nota aparece
8. ✅ Logout
9. ✅ Login como facilitador (`joao@facilitador.com` / `password`)
10. ✅ Ver que total de notas aumentou

### Teste de Cadastro:

1. ✅ Logout
2. ✅ Ir para `/register`
3. ✅ Cadastrar novo usuário com código `JOAO2025`
4. ✅ Registrar nota
5. ✅ Login como facilitador
6. ✅ Ver novo usuário na lista

### Teste Responsivo:

1. ✅ Navegar entre páginas
2. ✅ Verificar layout mobile
3. ✅ Testar formulários
4. ✅ Verificar menus e botões

---

## 🔐 PARA CÂMERA FUNCIONAR NO CELULAR (FUTURO):

### Opção 1: Usar HTTPS

Em produção, com domínio e certificado SSL, a câmera funcionará.

### Opção 2: Desenvolvimento Local com HTTPS

Instalar certificado local autoassinado (mais complexo).

### Opção 3: Usar ngrok (temporário)

Cria túnel HTTPS para teste:

```powershell
# Instalar ngrok
choco install ngrok

# Criar túnel
ngrok http 8000
```

Ngrok vai gerar URL HTTPS tipo: `https://abc123.ngrok.io`

Com essa URL, câmera funcionará no celular!

---

## 📸 ALTERNATIVA: Testar QR Code Real

Se quiser testar com QR Code real:

1. Pegue um cupom fiscal físico
2. Use app de leitura QR (qualquer app)
3. Copie a chave de 44 dígitos
4. Cole no formulário manual do app

Ou:

1. Gere QR Code online em: https://www.qr-code-generator.com/
2. Coloque uma chave de 44 dígitos
3. Mostre o QR Code gerado para a câmera do PC
4. No celular, use formulário manual

---

## 🎯 RESUMO:

### PC (Windows):
- ✅ Câmera funciona normalmente
- ✅ Pode escanear QR Code direto

### Celular (HTTP):
- ⚠️ Câmera bloqueada por segurança
- ✅ Formulário manual funciona 100%
- ✅ Todas as outras funcionalidades OK

### Produção (HTTPS):
- ✅ Câmera funcionará em qualquer dispositivo
- ✅ Scanner completo operacional

---

## 💡 DICA:

**Para seus testes, o formulário manual é suficiente!**

Você consegue:
- ✅ Registrar notas
- ✅ Testar validações
- ✅ Ver agregações
- ✅ Testar todo o fluxo

A câmera é só uma facilidade extra que funcionará em produção com HTTPS.

---

**Teste agora no celular usando o formulário manual!** 📱✨
