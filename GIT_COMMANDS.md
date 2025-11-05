# 🚀 Guia de Comandos Git

## Primeiro Push para o GitHub

### 1. Verificar status dos arquivos
```powershell
git status
```

### 2. Adicionar todos os arquivos
```powershell
git add .
```

### 3. Fazer commit inicial
```powershell
git commit -m "feat: Sistema completo de leitor de cupom fiscal

- Implementação de models (Facilitador, Usuario, NotaFiscal)
- Controllers para autenticação e gestão
- Sistema de leitura de QR Code com html5-qrcode
- Dashboards para usuário e facilitador
- Views com Tailwind CSS
- Migrations PostgreSQL
- Sistema de autenticação com guards separados
- API para registro de notas fiscais"
```

### 4. Adicionar remote (se ainda não tiver)
```powershell
git remote add origin https://github.com/MumaVendramini/leitorcupom.git
```

### 5. Verificar remote
```powershell
git remote -v
```

### 6. Fazer push para GitHub
```powershell
git push -u origin main
```

Se o branch for `master` em vez de `main`:
```powershell
git push -u origin master
```

### 7. Se houver conflito ou branch não existir
```powershell
# Ver qual branch você está
git branch

# Se estiver em master mas o GitHub espera main:
git branch -M main
git push -u origin main
```

## Commits Futuros

Depois do primeiro push, para novos commits:

```powershell
# Ver o que mudou
git status

# Adicionar arquivos modificados
git add .

# Fazer commit
git commit -m "sua mensagem aqui"

# Enviar para GitHub
git push
```

## Comandos Úteis

### Ver histórico de commits
```powershell
git log --oneline
```

### Ver diferenças
```powershell
git diff
```

### Desfazer mudanças não commitadas
```powershell
git restore arquivo.php
```

### Criar nova branch
```powershell
git checkout -b nome-da-branch
```

### Mudar de branch
```powershell
git checkout nome-da-branch
```

## Estrutura de Commits Semânticos (Recomendado)

- `feat:` - Nova funcionalidade
- `fix:` - Correção de bug
- `docs:` - Mudanças na documentação
- `style:` - Formatação, ponto e vírgula, etc
- `refactor:` - Refatoração de código
- `test:` - Adição de testes
- `chore:` - Atualização de dependências, etc

### Exemplos:
```powershell
git commit -m "feat: adiciona integração com SEFAZ"
git commit -m "fix: corrige erro na leitura do QR Code"
git commit -m "docs: atualiza README com instruções de instalação"
```

## .gitignore

Certifique-se que o arquivo `.gitignore` contém:

```
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
/.idea
/.vscode
```

Isso evita enviar arquivos desnecessários para o GitHub.
