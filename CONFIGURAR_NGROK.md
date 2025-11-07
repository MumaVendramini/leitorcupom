# 🎥 HABILITAR CÂMERA NO CELULAR - NGROK

## Por que usar ngrok?

A câmera do celular **só funciona** em sites HTTPS (seguro).

Ngrok cria um túnel HTTPS temporário para seu servidor local.

---

## 📥 INSTALAÇÃO RÁPIDA DO NGROK:

### Opção 1: Download Direto (MAIS RÁPIDO)

1. **Baixe ngrok:**
   - Acesse: https://ngrok.com/download
   - Clique em "Download for Windows"
   - Baixa um arquivo `.zip`

2. **Extraia o arquivo:**
   - Extraia `ngrok.exe` para: `C:\ngrok\`
   - Ou qualquer pasta de sua preferência

3. **Adicione ao PATH (opcional):**
   - Ou execute direto da pasta

### Opção 2: Via PowerShell (Direto)

Execute no PowerShell:

```powershell
# Criar pasta
New-Item -Path "C:\ngrok" -ItemType Directory -Force

# Baixar
Invoke-WebRequest -Uri "https://bin.equinox.io/c/bNyj1mQVY4c/ngrok-v3-stable-windows-amd64.zip" -OutFile "C:\ngrok\ngrok.zip"

# Extrair
Expand-Archive -Path "C:\ngrok\ngrok.zip" -DestinationPath "C:\ngrok" -Force

# Testar
C:\ngrok\ngrok.exe version
```

---

## 🚀 USAR NGROK:

### 1. Certifique-se que o servidor Laravel está rodando:

```powershell
php artisan serve --host=0.0.0.0 --port=8000
```

### 2. Abra OUTRO terminal e execute ngrok:

```powershell
# Se adicionou ao PATH:
ngrok http 8000

# Ou execute direto da pasta:
C:\ngrok\ngrok.exe http 8000
```

### 3. Ngrok vai exibir algo assim:

```
Session Status                online
Account                       Free
Version                       3.x.x
Region                        United States (us)
Latency                       -
Web Interface                 http://127.0.0.1:4040
Forwarding                    https://abc123xyz.ngrok-free.app -> http://localhost:8000
```

### 4. COPIE a URL HTTPS:

Exemplo: `https://abc123xyz.ngrok-free.app`

---

## 📱 ACESSAR NO CELULAR COM CÂMERA:

### 1. No celular, acesse a URL HTTPS do ngrok:

```
https://abc123xyz.ngrok-free.app
```

(Substitua pela URL que ngrok gerou para você)

### 2. Ngrok pode mostrar uma tela de aviso:

Clique em **"Visit Site"**

### 3. Faça login normalmente:

- Email: `pedro@usuario.com`
- Senha: `password`

### 4. Acesse: `/scan-qrcode`

### 5. Agora o navegador vai PEDIR permissão para câmera:

Clique em **"Permitir"**

### 6. ✅ CÂMERA FUNCIONANDO!

Aponte para um QR Code de nota fiscal e teste!

---

## 🧪 TESTAR QR CODE:

### Opção 1: Cupom Fiscal Real

Use qualquer cupom fiscal com QR Code

### Opção 2: Gerar QR Code de Teste

1. Acesse: https://www.qr-code-generator.com/
2. Tipo: "Text"
3. Cole uma chave de 44 dígitos:
   ```
   35250212345678000123550010000009991234567894
   ```
4. Clique em "Create QR Code"
5. Mostre o QR Code gerado para a câmera

### Opção 3: QR Code com URL (mais realista)

No gerador de QR Code, use:
```
https://www.sefaz.pe.gov.br/nfce-web/consultarNFCe?chNFe=35250212345678000123550010000009991234567894
```

---

## ⚙️ CONFIGURAR .env PARA NGROK:

Quando ngrok gerar a URL, atualize o `.env`:

```env
APP_URL=https://abc123xyz.ngrok-free.app
SESSION_DOMAIN=.ngrok-free.app
```

Depois execute:

```powershell
php artisan config:clear
```

---

## 💡 DICAS IMPORTANTES:

### ✅ Grátis e Sem Cadastro:

Ngrok versão gratuita funciona sem cadastro, mas:
- URL muda toda vez que reinicia
- Sessão tem limite de tempo
- Pode ter banner de aviso

### ✅ Melhorar Experiência (Opcional):

1. Crie conta grátis em: https://dashboard.ngrok.com/signup
2. Copie seu authtoken
3. Execute:
   ```powershell
   C:\ngrok\ngrok.exe config add-authtoken SEU_TOKEN_AQUI
   ```
4. Benefícios:
   - URLs mais longas (sem timeout rápido)
   - Sem banner de aviso
   - Estatísticas de uso

### ✅ Múltiplos Usuários Testando:

Com ngrok, qualquer pessoa com a URL pode acessar!

Perfeito para:
- Testar com colegas
- Demonstrar para cliente
- Validar em múltiplos dispositivos

---

## 🎯 RESUMO DO FLUXO:

### Terminal 1 (Servidor Laravel):
```powershell
php artisan serve --host=0.0.0.0 --port=8000
```

### Terminal 2 (Ngrok):
```powershell
C:\ngrok\ngrok.exe http 8000
```

### Celular:
1. Acesse URL HTTPS do ngrok
2. Login
3. Scan QR Code
4. **Permitir câmera**
5. ✅ FUNCIONA!

---

## 🐛 PROBLEMAS COMUNS:

### "URL não abre no celular"

- Copie a URL HTTPS corretamente
- Certifique-se que é `https://` (não `http://`)
- Clique em "Visit Site" se aparecer aviso do ngrok

### "Câmera ainda não funciona"

- Verifique se é HTTPS mesmo
- Limpe cache do navegador mobile
- Teste em outro navegador (Chrome, Safari)
- Garanta que permitiu acesso à câmera

### "Servidor desconectou"

- Ngrok precisa estar rodando enquanto testa
- Servidor Laravel também precisa estar ativo
- Ambos terminais devem ficar abertos

---

## 🎉 PRONTO!

Depois de configurar ngrok:

✅ Câmera funcionará 100% no celular
✅ Scanner de QR Code operacional
✅ Teste completo da funcionalidade principal

**Baixe ngrok agora e teste!** 🎥📱
