<?php
/**
 * dashboard/index.php
 * Visão geral do painel administrativo com KPIs e gráficos.
 */
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/../includes/auth.php';
protegerPagina();

$paginaDash = 'inicio';
$tituloDash = 'Visão Geral';

$totalClientes     = $pdo->query('SELECT COUNT(*) FROM clientes')->fetchColumn();
$totalDiagnosticos = $pdo->query('SELECT COUNT(*) FROM diagnosticos')->fetchColumn();
$totalOrcamentos   = $pdo->query('SELECT COUNT(*) FROM orcamentos')->fetchColumn();
$totalAprovados    = $pdo->query("SELECT COUNT(*) FROM orcamentos WHERE status = 'Aprovado'")->fetchColumn();

$ultimosDiagnosticos = $pdo->query('
    SELECT d.id, c.nome, c.empresa, d.nivel_maturidade, d.criado_em
    FROM diagnosticos d JOIN clientes c ON c.id = d.cliente_id
    ORDER BY d.id DESC LIMIT 5
')->fetchAll();

$ultimosOrcamentos = $pdo->query('
    SELECT id, nome, empresa, status, criado_em FROM orcamentos ORDER BY id DESC LIMIT 5
')->fetchAll();

// Dados para gráfico de pizza: status de orçamentos
$statusCount = $pdo->query('SELECT status, COUNT(*) as total FROM orcamentos GROUP BY status')->fetchAll();

// Dados para gráfico de barras: diagnósticos por mês (últimos 6 meses)
$porMes = $pdo->query("
    SELECT DATE_FORMAT(criado_em, '%Y-%m') AS mes, COUNT(*) AS total
    FROM diagnosticos
    WHERE criado_em >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY mes ORDER BY mes
")->fetchAll();

include __DIR__ . '/includes_dash_layout_top.php';
?>

<div class="kpi-grid">
  <div class="kpi-card" data-animate="fade-in">
    <div class="kpi-icon"><i class="fa-solid fa-users"></i></div>
    <div><div class="kpi-value"><?= $totalClientes ?></div><div class="kpi-label">Clientes</div></div>
  </div>
  <div class="kpi-card" data-animate="fade-in" data-delay="1">
    <div class="kpi-icon"><i class="fa-solid fa-stethoscope"></i></div>
    <div><div class="kpi-value"><?= $totalDiagnosticos ?></div><div class="kpi-label">Diagnósticos</div></div>
  </div>
  <div class="kpi-card" data-animate="fade-in" data-delay="2">
    <div class="kpi-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
    <div><div class="kpi-value"><?= $totalOrcamentos ?></div><div class="kpi-label">Orçamentos</div></div>
  </div>
  <div class="kpi-card" data-animate="fade-in" data-delay="3">
    <div class="kpi-icon"><i class="fa-solid fa-circle-check"></i></div>
    <div><div class="kpi-value"><?= $totalAprovados ?></div><div class="kpi-label">Aprovados</div></div>
  </div>
</div>

<div class="dash-grid-2">
  <div class="painel" data-animate="fade-in">
    <h3><i class="fa-solid fa-chart-column"></i> Diagnósticos por Mês</h3>
    <canvas id="grafico-barras" height="110"></canvas>
  </div>
  <div class="painel" data-animate="fade-in">
    <h3><i class="fa-solid fa-chart-pie"></i> Status dos Orçamentos</h3>
    <canvas id="grafico-pizza" height="110"></canvas>
  </div>
</div>

<div class="dash-grid-2">
  <div class="painel" data-animate="fade-in">
    <h3><i class="fa-solid fa-stethoscope"></i> Últimos Diagnósticos</h3>
    <div class="tabela-wrap">
      <table class="tabela-dash">
        <thead><tr><th>Cliente</th><th>Empresa</th><th>Maturidade</th><th>Data</th></tr></thead>
        <tbody>
          <?php foreach ($ultimosDiagnosticos as $d): ?>
          <tr>
            <td><?= htmlspecialchars($d['nome']) ?></td>
            <td><?= htmlspecialchars($d['empresa']) ?></td>
            <td><?= htmlspecialchars($d['nivel_maturidade']) ?></td>
            <td><?= date('d/m/Y', strtotime($d['criado_em'])) ?></td>
          </tr>
          <?php endforeach; ?>
          <?php if (!$ultimosDiagnosticos): ?><tr><td colspan="4">Nenhum diagnóstico ainda.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="painel" data-animate="fade-in">
    <h3><i class="fa-solid fa-file-invoice-dollar"></i> Últimos Orçamentos</h3>
    <div class="tabela-wrap">
      <table class="tabela-dash">
        <thead><tr><th>Nome</th><th>Status</th><th>Data</th></tr></thead>
        <tbody>
          <?php foreach ($ultimosOrcamentos as $o): ?>
          <tr>
            <td><?= htmlspecialchars($o['nome']) ?></td>
            <td><span class="badge badge-<?= strtolower(str_replace(['á','ã','ç',' '], ['a','a','c',''], $o['status'])) ?>"><?= htmlspecialchars($o['status']) ?></span></td>
            <td><?= date('d/m/Y', strtotime($o['criado_em'])) ?></td>
          </tr>
          <?php endforeach; ?>
          <?php if (!$ultimosOrcamentos): ?><tr><td colspan="3">Nenhum orçamento ainda.</td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
  new Chart(document.getElementById('grafico-barras'), {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_column($porMes, 'mes')) ?>,
      datasets: [{
        label: 'Diagnósticos',
        data: <?= json_encode(array_column($porMes, 'total')) ?>,
        backgroundColor: '#FFC107',
        borderRadius: 8,
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

  new Chart(document.getElementById('grafico-pizza'), {
    type: 'doughnut',
    data: {
      labels: <?= json_encode(array_column($statusCount, 'status')) ?>,
      datasets: [{
        data: <?= json_encode(array_column($statusCount, 'total')) ?>,
        backgroundColor: ['#FFC107', '#FF6B00', '#3498db', '#2ecc71', '#FF4B4B', '#9b59b6'],
        borderWidth: 0,
      }]
    },
    options: {
      plugins: { legend: { position: 'bottom', labels: { color: '#CFCFCF' } } }
    }
  });
</script>

<?php include __DIR__ . '/includes_dash_layout_bottom.php'; ?>
