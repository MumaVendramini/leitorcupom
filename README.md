# Leitor de Cupom Fiscal 📱

Sistema web para registro de notas fiscais através da leitura de QR Code, com gestão de usuários e facilitadores.

## 🎯 Funcionalidades

- **Cadastro de Usuários**: Usuários se cadastram com código de indicação do facilitador
- **Leitura de QR Code**: Escaneamento direto de cupons fiscais via câmera
- **Gestão de Notas**: Armazenamento automático dos dados da nota fiscal
- **Dashboard Usuário**: Visualização das próprias notas cadastradas
- **Dashboard Facilitador**: Acompanhamento de usuários indicados e suas notas
- **Relatórios**: Base para cálculo de créditos e remuneração

## 🛠️ Tecnologias

- **Backend**: PHP 7.4+ com Laravel 8
- **Frontend**: Blade Templates + Tailwind CSS
- **Banco de Dados**: PostgreSQL
- **QR Code**: html5-qrcode library

## 📋 Requisitos

- PHP >= 7.4
- Composer
- PostgreSQL
- Node.js e NPM

## 🚀 Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/MumaVendramini/leitorcupom.git
cd leitorcupom
```

### 2. Instale as dependências

```bash
composer install
npm install
```

### 3. Configure o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

Edite o arquivo `.env` e configure o banco de dados PostgreSQL:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=leitorcupom
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Execute as migrations

```bash
php artisan migrate
```

### 5. Crie um facilitador admin (opcional)

```bash
php artisan tinker
```

Dentro do tinker:

```php
$facilitador = App\Models\Facilitador::create([
    'nome' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'codigo_indicacao' => 'ADMIN001'
]);
```

### 6. Inicie o servidor

```bash
php artisan serve
```

Acesse: `http://localhost:8000`

## 📱 Como Usar

### Para Facilitadores

1. Receba ou crie seu código de indicação
2. Compartilhe o código com usuários
3. Acompanhe o desempenho no dashboard

### Para Usuários

1. Cadastre-se com o código do facilitador
2. Faça login
3. Acesse "Escanear QR Code"
4. Aponte a câmera para o QR Code do cupom
5. O sistema registra automaticamente os dados

## 🗂️ Estrutura do Banco de Dados

### Tabela: facilitadors
- id, nome, email, password, codigo_indicacao (único)

### Tabela: usuarios
- id, nome, email, password, facilitador_id

### Tabela: nota_fiscals
- id, usuario_id, chave_acesso, cnpj, data_emissao, valor, cidade, ano, mes, modelo, numero_nf, serie, sat

## 🔐 Autenticação

O sistema possui dois tipos de login:
- **Usuário**: Acesso para registrar cupons e ver suas próprias notas
- **Facilitador**: Acesso para visualizar usuários indicados e suas estatísticas

## 📊 Relatórios

- Dashboard do usuário mostra total de notas e valores
- Dashboard do facilitador mostra usuários indicados e notas totais
- Base estruturada para cálculo de créditos futuros

## 🔜 Melhorias Futuras

- [ ] Integração com API da SEFAZ para validação automática
- [ ] Sistema de OCR para cupons sem QR Code
- [ ] Cálculo automático de créditos
- [ ] Sistema de pagamento
- [ ] Área administrativa completa
- [ ] Relatórios avançados com gráficos
- [ ] Exportação de dados (CSV, PDF)

## 📝 Licença

Este projeto é privado e proprietário.

## 👥 Contato

Para dúvidas ou sugestões, entre em contato.
