<?php
/**
 * login.php
 * Tela de login premium para acesso ao dashboard administrativo.
 */
require_once __DIR__ . '/includes/conexao.php';
require_once __DIR__ . '/includes/auth.php';

if (estaLogado()) {
    header('Location: dashboard/index.php');
    exit;
}

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'] ?? '';

    if (tentarLogin($pdo, $email, $senha)) {
        header('Location: dashboard/index.php');
        exit;
    }
    $erro = 'E-mail ou senha inválidos.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — SoluTech</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>⚡</text></svg>">
  <link rel="stylesheet" href="css/animations.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>
<div id="loader"><div class="loader-spinner"></div></div>

<div class="login-wrapper">
  <div class="login-visual">
    <i class="fa-solid fa-microchip floating" style="font-size:180px; background:linear-gradient(135deg,#00C6FF,#0072FF); -webkit-background-clip:text; background-clip:text; color:transparent;"></i>
  </div>

  <div class="login-form-side">
    <div class="login-card" data-animate="fade-in">
      <a href="index.php" class="logo" style="display:block; margin-bottom:8px;">Solu<span style="color:var(--amarelo);">Tech</span></a>
      <h2 style="margin:14px 0 6px;">Acesso Administrativo</h2>
      <p style="color:var(--texto-secundario); font-size:14px; margin-bottom:28px;">Entre com suas credenciais para acessar o painel.</p>

      <?php if ($erro): ?>
        <div class="card" style="border-color:rgba(255,75,75,.4); padding:14px; margin-bottom:20px;">
          <p style="color:#FF4B4B; font-size:14px;"><i class="fa-solid fa-circle-exclamation"></i> <?= $erro ?></p>
        </div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-group">
          <label>E-mail</label>
          <input type="email" name="email" required>
        </div>
        <div class="form-group">
          <label>Senha</label>
          <input type="password" name="senha" required>
        </div>
        <button type="submit" class="btn btn-primary btn-analisar glow-hover">
          <i class="fa-solid fa-right-to-bracket"></i> Entrar
        </button>
      </form>

      <p style="text-align:center; margin-top:24px;"><a href="index.php" style="color:var(--texto-secundario); font-size:13.5px;">← Voltar ao site</a></p>
    </div>
  </div>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="js/scroll.js"></script>
<script src="js/main.js"></script>
</body>
</html>
