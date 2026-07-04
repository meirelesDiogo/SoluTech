<?php
require_once __DIR__ . '/includes/conexao.php';
$paginaAtual = 'sobre';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre — SoluTech</title>
  <meta name="description" content="Conheça a missão, visão e valores da SoluTech.">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/animations.css">
</head>
<body>
<div id="loader"><div class="loader-spinner"></div></div>
<?php include __DIR__ . '/includes/navbar.php'; ?>

<section class="section" style="padding-top:160px;">
  <div class="container">
    <div class="section-header" data-animate="fade-in">
      <span class="section-tag">Quem Somos</span>
      <h2>Sobre a <span class="text-gradient">SoluTech</span></h2>
      <p>Somos uma empresa de tecnologia dedicada a transformar dores de negócio em soluções digitais inteligentes.</p>
    </div>

    <div class="grid grid-3">
      <div class="card" data-animate="slide-up" data-delay="1">
        <div class="servico-icon"><i class="fa-solid fa-bullseye"></i></div>
        <h3>Missão</h3>
        <p style="color:var(--texto-secundario); font-size:14.5px;">Democratizar o acesso à tecnologia de qualidade, ajudando empresas de todos os portes a crescerem com eficiência.</p>
      </div>
      <div class="card" data-animate="slide-up" data-delay="2">
        <div class="servico-icon"><i class="fa-solid fa-eye"></i></div>
        <h3>Visão</h3>
        <p style="color:var(--texto-secundario); font-size:14.5px;">Ser referência nacional em diagnóstico e implementação de soluções tecnológicas orientadas por dados e IA.</p>
      </div>
      <div class="card" data-animate="slide-up" data-delay="3">
        <div class="servico-icon"><i class="fa-solid fa-gem"></i></div>
        <h3>Valores</h3>
        <p style="color:var(--texto-secundario); font-size:14.5px;">Inovação, transparência, foco no cliente e excelência técnica em cada projeto entregue.</p>
      </div>
    </div>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <div class="section-header" data-animate="fade-in">
      <span class="section-tag">Nossa Trajetória</span>
      <h2>Linha do Tempo</h2>
    </div>

    <div class="grid grid-4">
      <?php
      $linha = [
        ['2019', 'Fundação da SoluTech com foco em desenvolvimento web.'],
        ['2021', 'Expansão para automação de processos e integrações.'],
        ['2023', 'Lançamento da área de Inteligência Artificial e Chatbots.'],
        ['2025', 'Criação do Diagnóstico Inteligente powered by IA.'],
      ];
      foreach ($linha as $i => $item):
      ?>
      <div class="card" data-animate="slide-up" data-delay="<?= $i + 1 ?>">
        <h3 class="text-gradient" style="font-size:26px;"><?= $item[0] ?></h3>
        <p style="color:var(--texto-secundario); font-size:14px; margin-top:10px;"><?= $item[1] ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container numeros">
    <div class="numero-item" data-animate="fade-in"><div class="num"><span data-count="320">0</span>+</div><span class="label">Projetos entregues</span></div>
    <div class="numero-item" data-animate="fade-in" data-delay="1"><div class="num"><span data-count="150">0</span>+</div><span class="label">Empresas atendidas</span></div>
    <div class="numero-item" data-animate="fade-in" data-delay="2"><div class="num"><span data-count="40">0</span>+</div><span class="label">Especialistas</span></div>
    <div class="numero-item" data-animate="fade-in" data-delay="3"><div class="num"><span data-count="7">0</span></div><span class="label">Anos de mercado</span></div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
