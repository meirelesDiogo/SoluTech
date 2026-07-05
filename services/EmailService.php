<?php

class EmailService
{
    public static function enviarOrcamento(array $dados)
    {
        $mail = require __DIR__ . '/../config/mail.php';

        $mail->addAddress($dados['email'], $dados['nome']);
        $mail->isHTML(true);

        $mail->Subject = 'Recebemos sua solicitação de orçamento!';

        $mail->Body = "
<div style='font-family:Arial,sans-serif;max-width:600px;margin:auto;background:#ffffff;padding:20px;border-radius:10px;border:1px solid #eee;'>

    <h2 style='color:#1e66ff;margin-bottom:10px;'>Olá, {$dados['nome']}!</h2>

    <p style='font-size:14px;color:#333;'>
        Recebemos sua solicitação de orçamento com sucesso.
        Nossa equipe da <strong>SoluTech IA</strong> já está analisando.
    </p>

    <hr style='border:none;border-top:1px solid #eee;margin:20px 0;'>

    <h3 style='color:#1e66ff;margin-bottom:10px;'>Resumo da solicitação</h3>

    <div style='font-size:14px;color:#444;line-height:1.6;'>
        <p><strong>Empresa:</strong> {$dados['empresa']}</p>
        <p><strong>Cidade:</strong> {$dados['cidade']}</p>
        <p><strong>Telefone:</strong> {$dados['telefone']}</p>
        <p><strong>Urgência:</strong> {$dados['urgencia']}</p>
        <p><strong>Orçamento disponível:</strong> {$dados['orcamento']}</p>
    </div>

    <hr style='border:none;border-top:1px solid #eee;margin:20px 0;'>

    <h3 style='color:#1e66ff;margin-bottom:10px;'>Descrição do projeto</h3>

    <p style='font-size:14px;color:#444;line-height:1.6;'>
        {$dados['descricao']}
    </p>

    <br>

    <p style='font-size:13px;color:#777;'>
        Em breve nossa equipe entrará em contato.
    </p>

    <p style='margin-top:20px;font-weight:bold;color:#1e66ff;'>
        SoluTech IA
    </p>

</div>
";

        $mail->send();
    }

    public static function enviarContato() {}
    public static function enviarCadastro() {}
    public static function enviarRecuperacaoSenha() {}
    public static function enviarChamado() {}
    public static function enviarResposta() {}
}