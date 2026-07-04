<?php
/**
 * index.php
 * Landing page principal da SoluTech.
 */
require_once __DIR__ . '/includes/conexao.php';
$paginaAtual = 'home';
$tituloPagina = 'SoluTech — Soluções Inteligentes para Empresas';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $tituloPagina ?></title>
  <meta name="description" content="A SoluTech utiliza Inteligência Artificial para diagnosticar as dores do seu negócio e sugerir soluções tecnológicas sob medida.">
  <meta property="og:title" content="SoluTech — Soluções Inteligentes para Empresas">
  <meta property="og:description" content="Diagnóstico gratuito com IA e orçamento personalizado para o seu negócio.">
  <meta property="og:type" content="website">
  <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>⚡</text></svg>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/animations.css">
</head>
<body>

<div id="loader"><div class="loader-spinner"></div></div>

<?php include __DIR__ . '/includes/navbar.php'; ?>

<!-- HERO -->
<section class="hero">
  <canvas id="particles-bg"></canvas>
  <div class="container hero-content">
    <div class="hero-badge"><i class="fa-solid fa-robot"></i> Diagnóstico com Inteligência Artificial</div>
    <h1>Soluções <span class="text-gradient">Inteligentes</span> para Empresas</h1>
    <p>Conte sua dor, deixe nossa IA analisar e receba uma solução tecnológica sob medida para o seu negócio — em minutos.</p>
    <div class="hero-buttons">
      <a href="diagnostico.php" class="btn btn-primary glow-hover">Solicitar Diagnóstico</a>
      <a href="servicos.php" class="btn btn-outline">Conhecer Serviços</a>
    </div>

    <div class="hero-illustration floating">
      <i class="fa-solid fa-microchip" style="font-size:120px; background:linear-gradient(135deg,#FFC107,#FF6B00); -webkit-background-clip:text; background-clip:text; color:transparent;"></i>
    </div>
  </div>
</section>

<!-- COMO FUNCIONA -->
<section class="section" id="como-funciona">
  <div class="container">
    <div class="section-header" data-animate="fade-in">
      <span class="section-tag">Como Funciona</span>
      <h2>Do problema à solução em 4 passos</h2>
      <p>Um processo simples, rápido e guiado por Inteligência Artificial.</p>
    </div>

    <div class="passos">
      <div class="passo" data-animate="slide-up" data-delay="1">
        <div class="passo-num">1</div>
        <h3>Conte seu problema</h3>
        <p style="color:var(--texto-secundario); font-size:14px; margin-top:8px;">Preencha um formulário simples sobre a dor do seu negócio.</p>
      </div>
      <div class="passo-seta"><i class="fa-solid fa-arrow-right"></i></div>
      <div class="passo" data-animate="slide-up" data-delay="2">
        <div class="passo-num">2</div>
        <h3>A IA analisa</h3>
        <p style="color:var(--texto-secundario); font-size:14px; margin-top:8px;">Nossa IA processa as informações e identifica a melhor solução.</p>
      </div>
      <div class="passo-seta"><i class="fa-solid fa-arrow-right"></i></div>
      <div class="passo" data-animate="slide-up" data-delay="3">
        <div class="passo-num">3</div>
        <h3>Receba a solução</h3>
        <p style="color:var(--texto-secundario); font-size:14px; margin-top:8px;">Veja diagnóstico completo, tecnologias e nível de maturidade digital.</p>
      </div>
      <div class="passo-seta"><i class="fa-solid fa-arrow-right"></i></div>
      <div class="passo" data-animate="slide-up" data-delay="4">
        <div class="passo-num">4</div>
        <h3>Solicite um orçamento</h3>
        <p style="color:var(--texto-secundario); font-size:14px; margin-top:8px;">Fale com nossa equipe e receba uma proposta personalizada.</p>
      </div>
    </div>
  </div>
</section>

<!-- SERVIÇOS (resumo) -->
<section class="section section-alt">
  <div class="container">
    <div class="section-header" data-animate="fade-in">
      <span class="section-tag">Nossos Serviços</span>
      <h2>Tecnologia sob medida para o seu negócio</h2>
      <p>Da automação à inteligência artificial, cobrimos toda a jornada digital da sua empresa.</p>
    </div>

    <div class="grid grid-4">
      <?php
      $servicosResumo = [
        ['fa-code', 'Desenvolvimento Web'],
        ['fa-mobile-screen', 'Aplicativos'],
        ['fa-gears', 'Automação'],
        ['fa-brain', 'Inteligência Artificial'],
      ];
      foreach ($servicosResumo as $i => $s):
      ?>
      <div class="card servico-card" data-animate="slide-up" data-delay="<?= $i + 1 ?>">
        <div class="servico-icon"><i class="fa-solid <?= $s[0] ?>"></i></div>
        <h3><?= $s[1] ?></h3>
        <p>Soluções completas e personalizadas para transformar sua operação.</p>
        <a href="servicos.php" class="servico-link">Saiba mais <i class="fa-solid fa-arrow-right"></i></a>
      </div>
      <?php endforeach; ?>
    </div>

    <div style="text-align:center; margin-top:50px;">
      <a href="servicos.php" class="btn btn-outline">Ver todos os serviços</a>
    </div>
  </div>
</section>

<!-- NÚMEROS -->
<section class="section">
  <div class="container">
    <div class="numeros">
      <div class="numero-item" data-animate="fade-in">
        <div class="num"><span data-count="320">0</span>+</div>
        <span class="label">Projetos entregues</span>
      </div>
      <div class="numero-item" data-animate="fade-in" data-delay="1">
        <div class="num"><span data-count="150">0</span>+</div>
        <span class="label">Empresas atendidas</span>
      </div>
      <div class="numero-item" data-animate="fade-in" data-delay="2">
        <div class="num"><span data-count="98">0</span>%</div>
        <span class="label">Satisfação dos clientes</span>
      </div>
      <div class="numero-item" data-animate="fade-in" data-delay="3">
        <div class="num"><span data-count="24">0</span>h</div>
        <span class="label">Tempo médio de diagnóstico</span>
      </div>
    </div>
  </div>
</section>

<!-- DEPOIMENTOS -->
<section class="section section-alt">
  <div class="container">
    <div class="section-header" data-animate="fade-in">
      <span class="section-tag">Depoimentos</span>
      <h2>O que dizem nossos clientes</h2>
    </div>

    <div class="grid grid-3">
      <?php
      $depoimentos = [
        ['Mariana Costa', 'Ápice Contábil', 'A IA da SoluTech identificou exatamente onde estávamos perdendo tempo. Resultado impressionante.'],
        ['Rafael Souza', 'Grupo Nova Vista', 'Processo simples e solução entregue no prazo. Recomendo fortemente.'],
        ['Juliana Alves', 'Alves & Cia', 'Equipe atenciosa e tecnologia de ponta. Nosso faturamento melhorou depois da automação.'],
      ];
      foreach ($depoimentos as $i => $d):
      ?>
      <div class="card depoimento-card" data-animate="slide-up" data-delay="<?= $i + 1 ?>">
        <div class="estrelas">★★★★★</div>
        <p style="color:var(--texto-secundario); font-size:14.5px;">"<?= $d[2] ?>"</p>
        <div class="depoimento-header">
          <img src="https://i.pravatar.cc/100?img=<?= $i + 12 ?>" alt="<?= $d[0] ?>">
          <div>
            <h4><?= $d[0] ?></h4>
            <span><?= $d[1] ?></span>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA FINAL -->
<section class="section">
  <div class="container" style="text-align:center;" data-animate="fade-in">
    <h2 style="font-size:2.2rem; margin-bottom:18px;">Pronto para transformar seu negócio?</h2>
    <p style="color:var(--texto-secundario); margin-bottom:32px;">Descubra em minutos qual solução tecnológica é ideal para você.</p>
    <a href="diagnostico.php" class="btn btn-primary glow-hover">Começar Diagnóstico Gratuito</a>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
