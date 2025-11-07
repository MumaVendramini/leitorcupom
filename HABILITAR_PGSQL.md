# ⚡ HABILITAR POSTGRESQL NO PHP (2 MINUTOS)

## O que aconteceu?
O PHP precisa do driver PostgreSQL habilitado para conectar ao banco.

## ✅ FAÇA ISSO AGORA:

### 1. Abra o arquivo php.ini

Caminho: `C:\xampp\php\php.ini`

**Pode abrir com:**
- Bloco de Notas
- Notepad++
- VS Code
- Qualquer editor de texto

### 2. Procure a linha (Ctrl+F):

```
;extension=pdo_pgsql
```

### 3. Remova o ponto e vírgula (;) do início:

**ANTES:**
```ini
;extension=pdo_pgsql
;extension=pgsql
```

**DEPOIS:**
```ini
extension=pdo_pgsql
extension=pgsql
```

### 4. Salve o arquivo (Ctrl+S)

### 5. PRONTO!

Volte aqui e me avise que habilitou.

---

## 🔍 Dica de Busca

No php.ini, procure pela seção que tem várias linhas começando com `extension=`

Você vai ver algo assim:

```ini
extension=bz2
extension=curl
;extension=ffi
;extension=ftp
extension=fileinfo
extension=gd
extension=gettext
extension=gmp
extension=intl
;extension=ldap
extension=mbstring
extension=exif
extension=mysqli
extension=odbc
extension=openssl
;extension=pdo_firebird
extension=pdo_mysql
;extension=pdo_oci
extension=pdo_odbc
;extension=pdo_pgsql    <--- ENCONTRE ESTA E REMOVA O ;
;extension=pgsql        <--- ENCONTRE ESTA E REMOVA O ;
```

---

**Depois de salvar, me avise que eu continuo a configuração!**
