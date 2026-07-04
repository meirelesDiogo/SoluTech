<?php
/**
 * includes/auth.php
 * Controle de sessão e autenticação de administradores.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ]);
}

/**
 * Verifica se há um administrador logado.
 */
function estaLogado(): bool
{
    return isset($_SESSION['usuario_id']);
}

/**
 * Bloqueia o acesso a páginas restritas do dashboard.
 */
function protegerPagina(): void
{
    if (!estaLogado()) {
        header('Location: ../login.php');
        exit;
    }
}

/**
 * Realiza login validando e-mail e senha (hash) no banco.
 */
function tentarLogin(PDO $pdo, string $email, string $senha): bool
{
    $stmt = $pdo->prepare('SELECT id, nome, senha, cargo FROM usuarios WHERE email = ? AND ativo = 1 LIMIT 1');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        session_regenerate_id(true);
        $_SESSION['usuario_id']   = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_cargo'] = $usuario['cargo'];
        return true;
    }
    return false;
}

function fazerLogout(): void
{
    $_SESSION = [];
    session_destroy();
}

/**
 * Gera e valida token CSRF simples para formulários do dashboard.
 */
function gerarTokenCSRF(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validarTokenCSRF(?string $token): bool
{
    return isset($_SESSION['csrf_token']) && $token !== null && hash_equals($_SESSION['csrf_token'], $token);
}
