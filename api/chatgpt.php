<?php
/**
 * api/chatgpt.php
 * Recebe os dados do formulário de diagnóstico, envia o problema para a
 * API do ChatGPT, salva cliente + diagnóstico no MySQL e devolve o JSON
 * com o resultado (e o ID salvo) para o front-end.
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/conexao.php';

// Apenas POST é aceito nesta rota
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido.']);
    exit;
}

// ---- Lê e valida o corpo JSON enviado pelo front-end ----
$corpo = json_decode(file_get_contents('php://input'), true);

$camposObrigatorios = ['nome', 'empresa', 'email', 'telefone', 'cidade', 'segmento', 'funcionarios', 'faturamento', 'problema'];
foreach ($camposObrigatorios as $campo) {
    if (empty($corpo[$campo])) {
        http_response_code(422);
        echo json_encode(['erro' => "Campo obrigatório ausente: $campo"]);
        exit;
    }
}

// ---- Sanitização ----
$nome         = limpar($corpo['nome']);
$empresa      = limpar($corpo['empresa']);
$email        = filter_var($corpo['email'], FILTER_SANITIZE_EMAIL);
$telefone     = limpar($corpo['telefone']);
$cidade       = limpar($corpo['cidade']);
$segmento     = limpar($corpo['segmento']);
$funcionarios = limpar($corpo['funcionarios']);
$faturamento  = limpar($corpo['faturamento']);
$problema     = limpar($corpo['problema']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['erro' => 'E-mail inválido.']);
    exit;
}

try {
    // ---- 1. Salva (ou localiza) o cliente ----
    $stmt = $pdo->prepare('SELECT id FROM clientes WHERE email = ? ORDER BY id DESC LIMIT 1');
    $stmt->execute([$email]);
    $clienteExistente = $stmt->fetch();

    if ($clienteExistente) {
        $clienteId = $clienteExistente['id'];
        $pdo->prepare('UPDATE clientes SET nome=?, empresa=?, telefone=?, cidade=?, segmento=?, num_funcionarios=?, faturamento=? WHERE id=?')
            ->execute([$nome, $empresa, $telefone, $cidade, $segmento, $funcionarios, $faturamento, $clienteId]);
    } else {
        $pdo->prepare('INSERT INTO clientes (nome, empresa, email, telefone, cidade, segmento, num_funcionarios, faturamento) VALUES (?,?,?,?,?,?,?,?)')
            ->execute([$nome, $empresa, $email, $telefone, $cidade, $segmento, $funcionarios, $faturamento]);
        $clienteId = $pdo->lastInsertId();
    }

    // ---- 2. Chama a API do ChatGPT ----
    $respostaIA = consultarChatGPT($problema, $segmento, $funcionarios, $faturamento);

    // ---- 3. Salva o diagnóstico no banco ----
    $stmt = $pdo->prepare('
        INSERT INTO diagnosticos
        (cliente_id, problema, resposta_ia, diagnostico, nivel_maturidade, pontuacao, solucao, beneficios,
         tecnologias, tempo, complexidade, prioridade, orcamento_estimado, recomendacoes)
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ');
    $stmt->execute([
        $clienteId,
        $problema,
        json_encode($respostaIA, JSON_UNESCAPED_UNICODE),
        $respostaIA['diagnostico'],
        $respostaIA['nivel_maturidade'],
        (int)($respostaIA['pontuacao'] ?? 0),
        $respostaIA['solucao'],
        $respostaIA['beneficios'],
        $respostaIA['tecnologias'],
        $respostaIA['tempo'],
        $respostaIA['complexidade'],
        $respostaIA['prioridade'],
        $respostaIA['orcamento_estimado'],
        $respostaIA['recomendacoes'],
    ]);

    $diagnosticoId = $pdo->lastInsertId();

    echo json_encode([
        'sucesso'         => true,
        'diagnostico_id'  => $diagnosticoId,
        'resultado'       => $respostaIA,
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    // Não exponha detalhes internos em produção; aqui mantemos uma mensagem genérica.
    echo json_encode(['erro' => 'Não foi possível concluir o diagnóstico. Tente novamente em instantes.']);
}

/**
 * Envia o problema relatado para a API do ChatGPT e retorna o JSON
 * estruturado com o diagnóstico. Caso a chamada falhe (ex: sem chave de API
 * configurada em ambiente de testes), retorna um fallback simulado para que
 * o fluxo do sistema continue funcional durante o desenvolvimento/demonstração.
 */
function consultarChatGPT(string $problema, string $segmento, string $funcionarios, string $faturamento): array
{
    $promptSistema = <<<PROMPT
Você é uma consultora de tecnologia da empresa SoluTech. Analise a dor relatada
pelo cliente e responda EXCLUSIVAMENTE com um objeto JSON válido (sem texto
adicional, sem markdown), contendo exatamente estes campos:

{
  "diagnostico": "resumo do problema identificado",
  "nivel_maturidade": "Baixo, Médio ou Alto",
  "pontuacao": "número de 0 a 100 representando a maturidade digital",
  "solucao": "solução tecnológica recomendada",
  "beneficios": "principais benefícios da solução",
  "tecnologias": "tecnologias sugeridas, separadas por vírgula",
  "tempo": "tempo estimado de implementação",
  "complexidade": "Baixa, Média ou Alta",
  "prioridade": "Baixa, Média ou Alta",
  "orcamento_estimado": "faixa de investimento estimada em R$",
  "recomendacoes": "recomendações adicionais para o cliente"
}
PROMPT;

    $promptUsuario = "Segmento: {$segmento}\nFuncionários: {$funcionarios}\nFaturamento: {$faturamento}\nProblema relatado: {$problema}";

    // Se nenhuma chave de API real foi configurada, devolve um diagnóstico
    // simulado (útil para testes locais / apresentação do TCC sem custo de API).
    if (OPENAI_API_KEY === 'SUA_CHAVE_AQUI') {
        return gerarDiagnosticoSimulado($problema, $segmento);
    }

    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . OPENAI_API_KEY,
        ],
        CURLOPT_POSTFIELDS => json_encode([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => $promptSistema],
                ['role' => 'user', 'content' => $promptUsuario],
            ],
            'response_format' => ['type' => 'json_object'],
            'temperature' => 0.4,
        ]),
        CURLOPT_TIMEOUT => 30,
    ]);

    $resposta = curl_exec($ch);
    $erroCurl = curl_error($ch);
    curl_close($ch);

    if ($erroCurl || !$resposta) {
        // Fallback em caso de falha de rede/API para não travar o sistema.
        return gerarDiagnosticoSimulado($problema, $segmento);
    }

    $dados = json_decode($resposta, true);
    $conteudo = $dados['choices'][0]['message']['content'] ?? null;
    $json = $conteudo ? json_decode($conteudo, true) : null;

    return $json ?: gerarDiagnosticoSimulado($problema, $segmento);
}

/**
 * Gera um diagnóstico simulado (heurístico) para uso sem chave de API real —
 * garante que o sistema completo funcione de ponta a ponta em ambiente de
 * demonstração/TCC, sem custos de API.
 */
function gerarDiagnosticoSimulado(string $problema, string $segmento): array
{
    $pontuacao = rand(35, 75);
    $nivel = $pontuacao < 40 ? 'Baixo' : ($pontuacao < 70 ? 'Médio' : 'Alto');

    return [
        'diagnostico'         => "Identificamos gargalos operacionais relacionados a processos manuais no segmento de {$segmento}, com impacto direto na produtividade da equipe.",
        'nivel_maturidade'    => $nivel,
        'pontuacao'           => (string)$pontuacao,
        'solucao'             => 'Implementação de um sistema de automação de processos integrado a um painel de indicadores (dashboard) em tempo real.',
        'beneficios'          => 'Redução de retrabalho, ganho de produtividade, visibilidade de dados em tempo real e melhor tomada de decisão.',
        'tecnologias'         => 'PHP, MySQL, API de Inteligência Artificial, Dashboards com Chart.js',
        'tempo'               => '4 a 8 semanas',
        'complexidade'        => 'Média',
        'prioridade'          => 'Alta',
        'orcamento_estimado'  => 'R$ 8.000 a R$ 25.000',
        'recomendacoes'       => 'Recomendamos iniciar com um projeto piloto em um setor específico antes da expansão para toda a operação.',
    ];
}
