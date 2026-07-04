<?php
/**
 * includes/navbar.php
 * Navbar fixa reutilizada em todas as páginas públicas.
 * Espera opcionalmente a variável $paginaAtual para destacar o link ativo.
 */
$paginaAtual = $paginaAtual ?? '';
?>
<nav class="navbar">
  <div class="container">
    <a href="index.php" class="logo">Solu<span>Tech</span></a>

    <ul class="nav-links">
      <li><a href="index.php" class="<?= $paginaAtual === 'home' ? 'ativo' : '' ?>">Home</a></li>
      <li><a href="sobre.php" class="<?= $paginaAtual === 'sobre' ? 'ativo' : '' ?>">Sobre</a></li>
      <li><a href="servicos.php" class="<?= $paginaAtual === 'servicos' ? 'ativo' : '' ?>">Serviços</a></li>
      <li><a href="diagnostico.php" class="<?= $paginaAtual === 'diagnostico' ? 'ativo' : '' ?>">Diagnóstico IA</a></li>
      <li><a href="contato.php" class="<?= $paginaAtual === 'contato' ? 'ativo' : '' ?>">Contato</a></li>
      <li><a href="login.php" class="nav-cta">Login</a></li>
    </ul>

    <button class="nav-toggle" aria-label="Abrir menu">
      <i class="fa-solid fa-bars"></i>
    </button>
  </div>
</nav>
