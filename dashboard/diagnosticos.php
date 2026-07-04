<?php
/**
 * dashboard/diagnosticos.php
 * Lista os diagnósticos gerados pela IA, com visualização detalhada e exclusão.
 */
require_once __DIR__ . '/../includes/conexao.php';
require_once __DIR__ . '/../includes/auth.php';
protegerPagina();

$paginaDash = 'diagnosticos';
$tituloDash = 'Diagnósticos';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['acao'] ?? '') === 'excluir') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id) $pdo->prepare('DELETE FROM diagnosticos WHERE id = ?')->execute([$id]);
    header('Location: diagnosticos.php');
    exit;
}

$busca = limpar($_GET['busca'] ?? '');
$where = '';
$params = [];
if ($busca !== '') {
    $where = 'WHERE c.nome LIKE ? OR c.empresa LIKE ? OR d.problema LIKE ?';
    $params = ["%$busca%", "%$busca%", "%$busca%"];
}

$stmt = $pdo->prepare("
    SELECT d.*, c.nome, c.empresa
    FROM diagnosticos d JOIN clientes c ON c.id = d.cliente_id
    $where
    ORDER BY d.id DESC
");
$stmt->execute($params);
$diagnosticos = $stmt->fetchAll();

include __DIR__ . '/includes_dash_layout_top.php';
?>

<div class="toolbar">
  <div class="busca-box">
    <i class="fa-solid fa-magnifying-glass"></i>
    <form method="GET"><input type="text" name="busca" placeholder="Pesquisar diagnóstico..." value="<?= htmlspecialchars($busca) ?>" onchange="this.form.submit()"></form>
  </div>
</div>

<div class="painel">
  <div class="tabela-wrap">
    <table class="tabela-dash">
      <thead><tr><th>Cliente</th><th>Empresa</th><th>Problema</th><th>Maturidade</th><th>Data</th><th>Ações</th></tr></thead>
      <tbody>
        <?php foreach ($diagnosticos as $d): ?>
        <tr>
          <td><?= htmlspecialchars($d['nome']) ?></td>
          <td><?= htmlspecialchars($d['empresa']) ?></td>
          <td><?= htmlspecialchars(mb_substr($d['problema'], 0, 40)) ?>...</td>
          <td><?= htmlspecialchars($d['nivel_maturidade']) ?></td>
          <td><?= date('d/m/Y', strtotime($d['criado_em'])) ?></td>
          <td>
            <div class="acoes-tabela">
              <a href="../resultado.php?id=<?= $d['id'] ?>" target="_blank"><i class="fa-solid fa-eye"></i></a>
              <form method="POST" style="display:inline;" onsubmit="return confirmarExclusao(this);">
                <input type="hidden" name="acao" value="excluir">
                <input type="hidden" name="id" value="<?= $d['id'] ?>">
                <button type="submit"><i class="fa-solid fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (!$diagnosticos): ?><tr><td colspan="6">Nenhum diagnóstico encontrado.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/includes_dash_layout_bottom.php'; ?>
