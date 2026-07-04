<?php
/**
 * includes/conexao.php
 * Conexão central com o banco de dados MySQL via PDO.
 * Todas as páginas do sistema devem incluir este arquivo.
 */

// ---- Configurações de acesso ao banco (ajuste conforme seu ambiente) ----
define('DB_HOST', 'localhost');
define('DB_NAME', 'solutech');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Chave usada apenas como placeholder para a API do ChatGPT.
// Nunca exponha a chave real no front-end. Defina via variável de ambiente
// no servidor: putenv / .htaccess / php.ini, e leia com getenv().
define('OPENAI_API_KEY', getenv('OPENAI_API_KEY') ?: 'SUA_CHAVE_AQUI');

try {
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
    $opcoes = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, // Prepared statements reais (proteção contra SQL Injection)
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $opcoes);
} catch (PDOException $e) {
    // Em produção, não exiba o erro real ao usuário.
    http_response_code(500);
    die('Erro de conexão com o banco de dados. Tente novamente mais tarde.');
}

/**
 * Sanitiza uma string recebida de formulários (proteção básica contra XSS).
 */
function limpar(string $valor): string
{
    return htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8');
}
