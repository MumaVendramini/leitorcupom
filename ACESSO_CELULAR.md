# 📱 COMO ACESSAR DO CELULAR

## ✅ Servidor configurado!

---

## 🎯 NO SEU CELULAR, ACESSE:

### **URL:** http://192.168.0.11:8000

---

## 📋 IMPORTANTE:

### 1. Celular e Computador devem estar na **MESMA REDE Wi-Fi**

- ✅ Conecte seu celular no mesmo Wi-Fi do computador
- ✅ Se estiver usando cabo de rede, conecte o celular no Wi-Fi da mesma rede

### 2. Firewall do Windows

**Se não conseguir acessar**, pode ser o firewall bloqueando.

**Solução rápida:**

Abra PowerShell **como Administrador** e execute:

```powershell
New-NetFirewallRule -DisplayName "Laravel Dev Server" -Direction Inbound -LocalPort 8000 -Protocol TCP -Action Allow
```

Ou desative temporariamente o firewall:
1. Painel de Controle
2. Sistema e Segurança
3. Firewall do Windows Defender
4. Desativar (temporariamente)

---

## 🚀 TESTANDO NO CELULAR:

### 1️⃣ Abra o navegador do celular

- Chrome, Safari, Firefox, etc.

### 2️⃣ Digite a URL:

```
http://192.168.0.11:8000
```

### 3️⃣ Faça login:

**Como Facilitador:**
- Email: `joao@facilitador.com`
- Senha: `password`

**Como Usuário:**
- Email: `pedro@usuario.com`
- Senha: `password`

---

## 📸 SCANNER DE QR CODE NO CELULAR

### Com usuário logado:

1. Acesse: http://192.168.0.11:8000/scan-qrcode
2. **Permita acesso à câmera** quando solicitado
3. Aponte para um QR Code de nota fiscal
4. Sistema registra automaticamente!

**Ou teste manualmente:**
- Role até "Ou digite a chave manualmente"
- Cole: `35250212345678000123550010000009991234567894`
- Clique em "Registrar"

---

## 🔗 TODAS AS URLs PARA CELULAR:

| Página | URL |
|--------|-----|
| Login | http://192.168.0.11:8000/login |
| Cadastro | http://192.168.0.11:8000/register |
| Dashboard Usuário | http://192.168.0.11:8000/dashboard |
| Dashboard Facilitador | http://192.168.0.11:8000/facilitador/dashboard |
| Scan QR Code | http://192.168.0.11:8000/scan-qrcode |

---

## 📱 DICAS PARA TESTE NO CELULAR:

### ✅ Câmera funciona melhor:
- ✅ Em boa iluminação
- ✅ QR Code bem focado
- ✅ Sem reflexos

### ✅ Se não tiver QR Code físico:
- Use a opção de digitação manual
- Ou imprima um QR Code de teste
- Ou use gerador online: https://www.qr-code-generator.com/

### ✅ Layout responsivo:
- O sistema já está otimizado para mobile
- Funciona em qualquer tamanho de tela

---

## 🐛 PROBLEMAS?

### "Não consigo acessar do celular"

**1. Verifique se está na mesma rede:**
```
Computador Wi-Fi: Mesma rede
Celular Wi-Fi: Mesma rede
```

**2. Teste ping do celular:**
- Baixe app "Network Utilities" ou "Ping Tools"
- Ping para: 192.168.0.11
- Deve responder

**3. Firewall:**
- Execute o comando do firewall acima
- Ou desative temporariamente

**4. Servidor rodando?**
- No computador, deve mostrar: `PHP 7.4.30 Development Server (http://0.0.0.0:8000) started`

### "Câmera não funciona"

**1. Permissões:**
- Navegador pede permissão de câmera
- Clique em "Permitir"

**2. HTTPS necessário:**
- Para câmera funcionar em produção, precisa HTTPS
- Em desenvolvimento local (192.168.x.x), alguns navegadores permitem

**3. Use digitação manual:**
- Alternativa se câmera não funcionar

---

## 🎯 RESUMO:

### No Computador:
✅ Servidor rodando em: `http://0.0.0.0:8000`
✅ Acessível pelo IP: `192.168.0.11`

### No Celular:
✅ Acesse: `http://192.168.0.11:8000`
✅ Login: `pedro@usuario.com` / `password`
✅ Scan QR: `http://192.168.0.11:8000/scan-qrcode`

---

**Pronto para testar no celular!** 📱✨
