<?php
require_once __DIR__ . '/includes/conexao.php';
$paginaAtual = 'servicos';

$servicos = [
  ['fa-code', 'Desenvolvimento Web', 'Sites institucionais, sistemas web e plataformas sob medida com tecnologia moderna.'],
  ['fa-mobile-screen', 'Aplicativos', 'Apps nativos e híbridos para Android e iOS focados em experiência do usuário.'],
  ['fa-gears', 'Automação', 'Automatize processos repetitivos e ganhe eficiência operacional.'],
  ['fa-database', 'Banco de Dados', 'Modelagem, otimização e migração de bancos de dados robustos e seguros.'],
  ['fa-chart-line', 'Dashboards', 'Painéis visuais para acompanhar indicadores em tempo real.'],
  ['fa-brain', 'Inteligência Artificial', 'Modelos de IA aplicados a diagnóstico, previsão e automação de decisões.'],
  ['fa-comments', 'Chatbots', 'Atendimento automatizado 24h com IA conversacional.'],
  ['fa-lightbulb', 'Consultoria', 'Análise estratégica para orientar a transformação digital da sua empresa.'],
  ['fa-cloud', 'Cloud', 'Infraestrutura em nuvem escalável, segura e de alta disponibilidade.'],
  ['fa-plug', 'Integrações', 'Conecte sistemas, APIs e plataformas para um fluxo de dados unificado.'],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Serviços — SoluTech</title>
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
      <span class="section-tag">Nossos Serviços</span>
      <h2>Tudo que sua empresa precisa em tecnologia</h2>
      <p>Soluções completas para cada etapa da transformação digital do seu negócio.</p>
    </div>

    <div class="grid grid-3">
      <?php foreach ($servicos as $i => $s): ?>
      <div class="card servico-card" data-animate="slide-up" data-delay="<?= ($i % 3) + 1 ?>">
        <div class="servico-icon"><i class="fa-solid <?= $s[0] ?>"></i></div>
        <h3><?= $s[1] ?></h3>
        <p><?= $s[2] ?></p>
        <a href="diagnostico.php" class="servico-link">Saiba mais <i class="fa-solid fa-arrow-right"></i></a>
      </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align:center; margin-top:60px;" data-animate="fade-in">
      <a href="diagnostico.php" class="btn btn-primary glow-hover">Solicitar Diagnóstico Gratuito</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
