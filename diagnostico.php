<?php
require_once __DIR__ . '/includes/conexao.php';
$paginaAtual = 'diagnostico';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diagnóstico com IA — SoluTech</title>
  <meta name="description" content="Conte o problema da sua empresa e receba um diagnóstico tecnológico gerado por Inteligência Artificial.">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/animations.css">
</head>
<body>
<div id="loader"><div class="loader-spinner"></div></div>
<?php include __DIR__ . '/includes/navbar.php'; ?>

<section class="section" style="padding-top:160px;">
  <div class="container" style="max-width:900px;">
    <div class="section-header" data-animate="fade-in">
      <span class="section-tag">Diagnóstico Inteligente</span>
      <h2>Conte sua dor. A IA cuida do resto.</h2>
      <p>Preencha os dados abaixo com atenção. Quanto mais detalhado o problema, melhor será a análise da nossa IA.</p>
    </div>

    <div class="form-card" data-animate="slide-up">
      <form id="form-diagnostico" autocomplete="off">
        <div class="form-grid">
          <div class="form-group">
            <label for="nome">Nome completo</label>
            <input type="text" id="nome" name="nome" required>
          </div>
          <div class="form-group">
            <label for="empresa">Empresa</label>
            <input type="text" id="empresa" name="empresa" required>
          </div>
          <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="telefone">Telefone</label>
            <input type="text" id="telefone" name="telefone" required>
          </div>
          <div class="form-group">
            <label for="cidade">Cidade</label>
            <input type="text" id="cidade" name="cidade" required>
          </div>
          <div class="form-group">
            <label for="segmento">Segmento</label>
            <input type="text" id="segmento" name="segmento" placeholder="Ex: Varejo, Saúde, Indústria..." required>
          </div>
          <div class="form-group">
            <label for="funcionarios">Número de funcionários</label>
            <select id="funcionarios" name="funcionarios" required>
              <option value="">Selecione</option>
              <option>1 a 5</option>
              <option>6 a 20</option>
              <option>21 a 50</option>
              <option>51 a 200</option>
              <option>Mais de 200</option>
            </select>
          </div>
          <div class="form-group">
            <label for="faturamento">Faturamento aproximado</label>
            <select id="faturamento" name="faturamento" required>
              <option value="">Selecione</option>
              <option>Até R$ 10 mil/mês</option>
              <option>R$ 10 mil a R$ 50 mil/mês</option>
              <option>R$ 50 mil a R$ 200 mil/mês</option>
              <option>Acima de R$ 200 mil/mês</option>
            </select>
          </div>
          <div class="form-group full">
            <label for="problema">Descreva seu problema</label>
            <textarea id="problema" name="problema" placeholder="Explique com o máximo de detalhes possível a dificuldade que sua empresa enfrenta hoje..." required></textarea>
          </div>
        </div>

        <button type="submit" id="btn-analisar" class="btn btn-primary btn-analisar glow-hover">
          <i class="fa-solid fa-wand-magic-sparkles"></i> ANALISAR COM IA
        </button>
      </form>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script>
document.getElementById('form-diagnostico').addEventListener('submit', async function (e) {
  e.preventDefault();
  const botao = document.getElementById('btn-analisar');
  ativarLoadingBotao(botao, 'Analisando com IA...');

  const dados = Object.fromEntries(new FormData(this).entries());

  try {
    const resposta = await fetch('api/chatgpt.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(dados)
    });
    const resultado = await resposta.json();

    if (!resposta.ok || resultado.erro) {
      throw new Error(resultado.erro || 'Erro ao processar diagnóstico.');
    }

    mostrarToast('Diagnóstico gerado com sucesso!', 'success');
    // Redireciona para a página de resultado usando o id salvo no banco
    window.location.href = 'resultado.php?id=' + resultado.diagnostico_id;

  } catch (err) {
    mostrarToast(err.message || 'Não foi possível concluir a análise.', 'error');
    desativarLoadingBotao(botao);
  }
});
</script>
</body>
</html>
