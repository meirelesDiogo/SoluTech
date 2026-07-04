<?php

class EmailService
{
    public static function enviarOrcamento(array $dados)
    {
        $mail = require __DIR__ . '/../config/mail.php';

        $mail->addAddress($dados['email'], $dados['nome']);

        $mail->Subject = 'Recebemos sua solicitação de orçamento!';

        $mail->Body = "
        <div style='font-family:Arial,sans-serif;max-width:600px;margin:auto;'>
            <h2>Olá, {$dados['nome']}!</h2>

            <p>Recebemos sua solicitação de orçamento com sucesso.</p>

            <hr>

            <p><b>Empresa:</b> {$dados['empresa']}</p>
            <p><b>Cidade:</b> {$dados['cidade']}</p>
            <p><b>Telefone:</b> {$dados['telefone']}</p>
            <p><b>Urgência:</b> {$dados['urgencia']}</p>
            <p><b>Orçamento:</b> {$dados['orcamento']}</p>

            <hr>

            <p>{$dados['descricao']}</p>

            <p>SoluTech IA</p>
        </div>";

        $mail->send();
    }

    public static function enviarContato() {}
    public static function enviarCadastro() {}
    public static function enviarRecuperacaoSenha() {}
    public static function enviarChamado() {}
    public static function enviarResposta() {}
}