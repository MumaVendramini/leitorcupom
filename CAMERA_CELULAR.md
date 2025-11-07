# 🚀 PASSO A PASSO PARA CÂMERA FUNCIONAR NO CELULAR

## ⚡ CONFIGURAÇÃO RÁPIDA (5 MINUTOS)

### 1️⃣ Criar Conta no Ngrok (Grátis)

**Acesse:** https://dashboard.ngrok.com/signup

**Cadastre-se com:**
- Email
- Ou conta Google
- Ou conta GitHub

É **GRATUITO** e leva 30 segundos!

---

### 2️⃣ Pegar seu Token

Depois de criar a conta:

1. Ngrok vai te redirecionar para: https://dashboard.ngrok.com/get-started/your-authtoken

2. **Copie o authtoken** que aparece na tela
   - É uma string tipo: `2abc...xyz123`

---

### 3️⃣ Configurar Ngrok no Windows

Abra PowerShell e execute:

```powershell
C:\ngrok\ngrok.exe config add-authtoken SEU_TOKEN_AQUI
```

**Exemplo:**
```powershell
C:\ngrok\ngrok.exe config add-authtoken 2abcdefGHIJKlmn123xyz
```

---

### 4️⃣ Iniciar Túnel HTTPS

```powershell
C:\ngrok\ngrok.exe http 8000
```

Vai aparecer algo assim:

```
ngrok

Session Status                online
Account                       Seu Email
Version                       3.x.x
Region                        United States (us)
Latency                       45ms
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://abc123xyz.ngrok-free.app -> http://localhost:8000
```

---

### 5️⃣ Copiar URL HTTPS

**COPIE** a URL que aparece em "Forwarding":

Exemplo: `https://abc123xyz.ngrok-free.app`

---

### 6️⃣ Testar no Celular

1. **No celular, abra o navegador**

2. **Acesse a URL HTTPS do ngrok:**
   ```
   https://abc123xyz.ngrok-free.app
   ```

3. **Se aparecer tela de aviso do ngrok:**
   - Clique em **"Visit Site"**

4. **Faça login:**
   - Email: `pedro@usuario.com`
   - Senha: `password`

5. **Acesse scanner:**
   ```
   https://abc123xyz.ngrok-free.app/scan-qrcode
   ```

6. **Quando pedir permissão de câmera:**
   - Clique em **"Permitir"**

7. **✅ CÂMERA FUNCIONANDO!**
   - Aponte para QR Code
   - Sistema detecta e registra automaticamente!

---

## 🎯 RESUMO RÁPIDO:

```powershell
# 1. Criar conta: https://dashboard.ngrok.com/signup

# 2. Copiar token e configurar:
C:\ngrok\ngrok.exe config add-authtoken SEU_TOKEN

# 3. Iniciar túnel:
C:\ngrok\ngrok.exe http 8000

# 4. Copiar URL HTTPS e acessar no celular!
```

---

## 📱 TESTE COMPLETO:

### No Celular (com câmera funcionando):

✅ Abrir URL HTTPS
✅ Login como usuário
✅ Acessar scanner
✅ **Permitir câmera**
✅ Apontar para QR Code real
✅ Ver confirmação de registro
✅ Voltar ao dashboard
✅ Nova nota aparece!

---

## 🎥 TESTAR COM QR CODE:

### Opção 1: Cupom Fiscal Real
- Pegue qualquer nota fiscal com QR Code
- Aponte a câmera
- Pronto!

### Opção 2: Gerar QR Code Online
1. Acesse: https://www.qr-code-generator.com/
2. Tipo: "Text"
3. Cole: `35250212345678000123550010000009991234567894`
4. Gerar QR Code
5. Mostre para câmera do celular

### Opção 3: Imprimir Chave
- Gere QR Code online
- Imprima
- Escaneie do papel

---

## 💡 APÓS CONFIGURAR:

### Dois terminais rodando:

**Terminal 1 - Servidor:**
```powershell
php artisan serve --host=0.0.0.0 --port=8000
```

**Terminal 2 - Ngrok:**
```powershell
C:\ngrok\ngrok.exe http 8000
```

### Celular:
- Acessa URL HTTPS do ngrok
- Câmera funciona 100%!

---

## 🔗 LINKS IMPORTANTES:

1. **Criar conta (grátis):**
   https://dashboard.ngrok.com/signup

2. **Pegar token:**
   https://dashboard.ngrok.com/get-started/your-authtoken

3. **Gerador de QR Code:**
   https://www.qr-code-generator.com/

---

## ⏱️ TEMPO TOTAL: ~5 minutos

1. Criar conta ngrok: 1 min
2. Configurar token: 30 seg
3. Iniciar túnel: 30 seg
4. Testar no celular: 2 min

---

## 🎉 DEPOIS DISSO:

✅ Câmera funcionará perfeitamente no celular
✅ Scanner de QR Code 100% operacional
✅ Funcionalidade principal testada
✅ Pronto para validar o sistema completo!

---

**COMECE AGORA:**

1. Abra: https://dashboard.ngrok.com/signup
2. Crie conta
3. Copie token
4. Configure e teste!

🎥📱✨
