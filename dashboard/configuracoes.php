<?php
/**
 * dashboard/configuracoes.php
 * Configurações da conta do administrador (nome, e-mail, senha).
 */
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/../includes/auth.php';
protegerPagina();

$paginaDash = 'configuracoes';
$tituloDash = 'Configurações';

$mensagem = '';
$erro = '';

$stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id = ?');
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = limpar($_POST['nome']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $novaSenha = $_POST['nova_senha'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } else {
        if ($novaSenha !== '') {
            $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $pdo->prepare('UPDATE usuarios SET nome=?, email=?, senha=? WHERE id=?')->execute([$nome, $email, $hash, $usuario['id']]);
        } else {
            $pdo->prepare('UPDATE usuarios SET nome=?, email=? WHERE id=?')->execute([$nome, $email, $usuario['id']]);
        }
        $_SESSION['usuario_nome'] = $nome;
        $mensagem = 'Dados atualizados com sucesso!';
        $usuario['nome'] = $nome;
        $usuario['email'] = $email;
    }
}

include __DIR__ . '/includes_dash_layout_top.php';
?>

<div class="painel" style="max-width:560px;" data-animate="fade-in">
  <h3><i class="fa-solid fa-user-gear"></i> Meus Dados</h3>

  <?php if ($mensagem): ?>
    <p style="color:#2ecc71; margin-bottom:16px;"><i class="fa-solid fa-circle-check"></i> <?= $mensagem ?></p>
  <?php endif; ?>
  <?php if ($erro): ?>
    <p style="color:#FF4B4B; margin-bottom:16px;"><i class="fa-solid fa-circle-exclamation"></i> <?= $erro ?></p>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group"><label>Nome</label><input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required></div>
    <div class="form-group"><label>E-mail</label><input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required></div>
    <div class="form-group"><label>Nova senha (deixe em branco para manter a atual)</label><input type="password" name="nova_senha"></div>
    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
  </form>
</div>

<?php include __DIR__ . '/includes_dash_layout_bottom.php'; ?>
