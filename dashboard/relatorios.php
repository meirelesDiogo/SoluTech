<?php
/**
 * dashboard/relatorios.php
 * Relatórios gerenciais com gráficos (Chart.js): diagnósticos, clientes,
 * orçamentos, problemas mais comuns, segmentos e evolução mensal.
 */
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/../includes/auth.php';
protegerPagina();

$paginaDash = 'relatorios';
$tituloDash = 'Relatórios';

$totalDiagnosticos = $pdo->query('SELECT COUNT(*) FROM diagnosticos')->fetchColumn();
$totalClientes      = $pdo->query('SELECT COUNT(*) FROM clientes')->fetchColumn();
$totalOrcamentos    = $pdo->query('SELECT COUNT(*) FROM orcamentos')->fetchColumn();

$segmentos = $pdo->query('
    SELECT segmento, COUNT(*) as total FROM clientes
    WHERE segmento IS NOT NULL AND segmento <> ""
    GROUP BY segmento ORDER BY total DESC LIMIT 6
')->fetchAll();

$porMes = $pdo->query("
    SELECT DATE_FORMAT(criado_em, '%Y-%m') AS mes, COUNT(*) AS total
    FROM diagnosticos
    GROUP BY mes ORDER BY mes DESC LIMIT 6
")->fetchAll();
$porMes = array_reverse($porMes);

$niveis = $pdo->query('SELECT nivel_maturidade, COUNT(*) as total FROM diagnosticos GROUP BY nivel_maturidade')->fetchAll();

include __DIR__ . '/includes_dash_layout_top.php';
?>

<div class="kpi-grid">
  <div class="kpi-card" data-animate="fade-in">
    <div class="kpi-icon"><i class="fa-solid fa-stethoscope"></i></div>
    <div><div class="kpi-value"><?= $totalDiagnosticos ?></div><div class="kpi-label">Total de Diagnósticos</div></div>
  </div>
  <div class="kpi-card" data-animate="fade-in" data-delay="1">
    <div class="kpi-icon"><i class="fa-solid fa-users"></i></div>
    <div><div class="kpi-value"><?= $totalClientes ?></div><div class="kpi-label">Total de Clientes</div></div>
  </div>
  <div class="kpi-card" data-animate="fade-in" data-delay="2">
    <div class="kpi-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
    <div><div class="kpi-value"><?= $totalOrcamentos ?></div><div class="kpi-label">Total de Orçamentos</div></div>
  </div>
</div>

<div class="dash-grid-2">
  <div class="painel" data-animate="fade-in">
    <h3><i class="fa-solid fa-chart-line"></i> Diagnósticos por Mês</h3>
    <canvas id="grafico-mensal" height="110"></canvas>
  </div>
  <div class="painel" data-animate="fade-in">
    <h3><i class="fa-solid fa-layer-group"></i> Nível de Maturidade</h3>
    <canvas id="grafico-maturidade" height="110"></canvas>
  </div>
</div>

<div class="painel" data-animate="fade-in">
  <h3><i class="fa-solid fa-building"></i> Segmentos Mais Atendidos</h3>
  <canvas id="grafico-segmentos" height="90"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
  new Chart(document.getElementById('grafico-mensal'), {
    type: 'line',
    data: {
      labels: <?= json_encode(array_column($porMes, 'mes')) ?>,
      datasets: [{
        label: 'Diagnósticos',
        data: <?= json_encode(array_column($porMes, 'total')) ?>,
        borderColor: '#FFC107',
        backgroundColor: 'rgba(255,193,7,.15)',
        fill: true,
        tension: .35,
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      scales: {
        x: { ticks: { color: '#CFCFCF' }, grid: { display: false } },
        y: { beginAtZero: true, ticks: { color: '#CFCFCF' }, grid: { color: 'rgba(255,255,255,.06)' } }
      }
    }
  });

  new Chart(document.getElementById('grafico-maturidade'), {
    type: 'pie',
    data: {
      labels: <?= json_encode(array_column($niveis, 'nivel_maturidade')) ?>,
      datasets: [{
        data: <?= json_encode(array_column($niveis, 'total')) ?>,
        backgroundColor: ['#FF4B4B', '#FFC107', '#2ecc71'],
        borderWidth: 0,
      }]
    },
    options: { plugins: { legend: { position: 'bottom', labels: { color: '#CFCFCF' } } } }
  });

  new Chart(document.getElementById('grafico-segmentos'), {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_column($segmentos, 'segmento')) ?>,
      datasets: [{
        label: 'Clientes',
        data: <?= json_encode(array_column($segmentos, 'total')) ?>,
        backgroundColor: '#FF6B00',
        borderRadius: 8,
      }]
    },
    options: {
      indexAxis: 'y',
      plugins: { legend: { display: false } },
      scales: {
        x: { beginAtZero: true, ticks: { color: '#CFCFCF' }, grid: { color: 'rgba(255,255,255,.06)' } },
        y: { ticks: { color: '#CFCFCF' }, grid: { display: false } }
      }
    }
  });
</script>

<?php include __DIR__ . '/includes_dash_layout_bottom.php'; ?>
