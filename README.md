# SoluTech — Sistema de Diagnóstico Tecnológico com IA

Sistema completo em **HTML5, CSS3, JavaScript, PHP 8+ e MySQL**, com landing page
premium, diagnóstico automatizado via API do ChatGPT e painel administrativo
completo. Ideal para apresentação como TCC.

## 🚀 Como rodar localmente

### 1. Requisitos
- PHP 8.1+ com extensão `pdo_mysql` e `curl`
- MySQL 5.7+ ou MariaDB
- Servidor local: XAMPP, Laragon, WAMP, ou `php -S`

### 2. Banco de dados
1. Crie o banco importando o arquivo `database.sql`:
   ```
   mysql -u root -p < database.sql
   ```
2. Isso cria o banco `solutech`, todas as tabelas e um usuário administrador padrão:
   - **E-mail:** admin@solutech.com
   - **Senha:** admin123

   ⚠️ Troque essa senha em Configurações após o primeiro login.

### 3. Configuração de conexão
Edite `includes/conexao.php` se necessário (host, usuário, senha do MySQL).

### 4. API do ChatGPT (opcional para testes)
Defina a variável de ambiente `OPENAI_API_KEY` com sua chave da OpenAI.
**Sem chave configurada**, o sistema funciona normalmente usando um gerador de
diagnóstico simulado (heurístico) em `api/chatgpt.php`, ideal para demonstrações
sem custo de API.

### 5. Subindo o servidor
Com PHP embutido (útil para testes rápidos):
```
php -S localhost:8000
```
Acesse `http://localhost:8000`.

Ou copie a pasta `solutech/` para `htdocs` (XAMPP) / `www` (Laragon) e acesse
via `http://localhost/solutech`.

## 📁 Estrutura de pastas

```
/
├── index.php, sobre.php, servicos.php, diagnostico.php,
│   resultado.php, orcamento.php, contato.php, login.php, logout.php
├── dashboard/        → painel administrativo (protegido por login)
├── includes/         → navbar, footer, conexão PDO, autenticação
├── api/chatgpt.php   → integração com a API do ChatGPT
├── css/              → estilos (tema dark premium + animações)
├── js/               → scripts (interações, scroll reveal, dashboard)
└── database.sql      → schema completo do banco de dados
```

## 🔒 Segurança implementada
- Prepared Statements (PDO) em todas as consultas
- `password_hash()` / `password_verify()` para senhas
- Sanitização de entradas (`htmlspecialchars`, `filter_var`)
- Sessões PHP protegidas (`cookie_httponly`, regeneração de ID no login)
- Proteção de páginas do dashboard via `protegerPagina()`

## 🎨 Identidade visual
Tema **Dark Premium**: fundo `#0D0D0D`, cards `#1A1A1A`, destaque em gradiente
amarelo (`#FFC107`) → laranja (`#FF6B00`), com glassmorphism, animações de
scroll reveal, contadores animados e microinterações.

## 🧩 Principais funcionalidades
- Landing page com hero animado, seções institucionais, serviços, depoimentos
- Diagnóstico com IA: formulário → chamada à API → resultado visual com
  velocímetro de maturidade digital e gráficos (Chart.js)
- Solicitação de orçamento vinculada ao diagnóstico, salva no MySQL
- Painel administrativo: KPIs, gráficos, CRUD de clientes, listagem de
  diagnósticos, gestão de orçamentos (com mudança de status) e relatórios
