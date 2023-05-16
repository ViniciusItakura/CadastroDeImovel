<?php
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Instanciando o objeto PHPMailer
$mail = new PHPMailer(true);

try {
    // Configurações do servidor de email (SMTP)
    $mail->isSMTP();
    $mail->Host       = 'servidor-smtp';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'seu-email@example.com';
    $mail->Password   = 'sua-senha';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Configurações do email
    $mail->setFrom('seu-email@example.com', 'Seu Nome');
    $mail->addAddress('destinatario@example.com');
    $mail->addReplyTo($_POST['email'], $_POST['nome']);

    // Conteúdo do email
    $mail->isHTML(true);
    $mail->Subject = 'Assunto do Email';
    $mail->Body    = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                h1 {
                    color: #444444;
                }
                p {
                    color: #666666;
                }
            </style>
        </head>
        <body>
            <h1>Ola Central da Imobiliaria Inglaterra!</h1>
            <p>Aqui estão os dados de um novo cadastro de imovel:</p>
            <ul>
                <li><strong>Nome Completo:</strong> ' . $_POST['nome'] . '</li>
                <li><strong>Celular:</strong> ' . $_POST['celular'] . '</li>
                <li><strong>E-mail:</strong> ' . $_POST['email'] . '</li>
                <li><strong>Documento:</strong> ' . $_POST['documento'] . '</li>
                <li><strong>Tipo do imóvel:</strong> ' . $_POST['tipo'] . '</li>
                <li><strong>Está ocupado?:</strong> ' . $_POST['ocupado'] . '</li>
                <li><strong>Interesse:</strong> ' . $_POST['interesse'] . '</li>
                <li><strong>Valor:</strong> ' . $_POST['valor'] . '</li>
                <li><strong>Quartos:</strong> ' . $_POST['quartos'] . '</li>
                <li><strong>Suítes:</strong> ' . $_POST['suites'] . '</li>
                <li><strong>Banheiros:</strong> ' . $_POST['banheiros'] . '</li>
                <li><strong>Metragem Total:</strong> ' . $_POST['metragemtotal'] . '</li>
                <li><strong>Metragem Construida:</strong> ' . $_POST['metragemconstruida'] . '</li>
                <li><strong>Endereço:</strong> ' . $_POST['endereco'] . '</li>
                <li><strong>Condomínio:</strong> ' . $_POST['condominio'] . '</li>
                <li><strong>Complemento:</strong> ' . $_POST['complemento'] . '</li>
                <li><strong>Armários na cozinha:</strong> ' . $_POST['armarioscozinha'] . '</li>
                <li><strong>Armários nos quartos:</strong> ' . $_POST['armariosquartos'] . '</li>
                <li><strong>Armários nos banheiros:</strong> ' . $_POST['armariosbanheiros'] . '</li>
                <li><strong>Quantas vagas de garagem:</strong> ' . $_POST['vagasgaragem'] . '</li>
                <li><strong>Exclusividade:</strong> ' . $_POST['exclusividade'] . '</li>
            </ul>
        </body>
        </html>';

    // Verifica se foram enviados arquivos
    if (isset($_FILES['fotos'])) {
        $totalFiles = count($_FILES['fotos']['name']);
        
        // Loop para processar cada arquivo
    for ($i = 0; $i < $totalFiles; $i++) {
        $tmpFilePath = $_FILES['fotos']['tmp_name'][$i];

        // Verifica se o arquivo foi enviado com sucesso
        if ($tmpFilePath != "") {
            // Obtem informações sobre o arquivo
            $fileName = $_FILES['fotos']['name'][$i];
            $fileSize = $_FILES['fotos']['size'][$i];
            $fileType = $_FILES['fotos']['type'][$i];

            // Lê o conteúdo do arquivo
            $fileContent = file_get_contents($tmpFilePath);

            // Adiciona o arquivo como anexo ao email
            $mail->addStringAttachment($fileContent, $fileName);
        }
    }
}

// Enviar o email
$mail->send();

echo 'Email enviado com sucesso!';
} catch (Exception $e) {
    echo 'Erro ao enviar o email: ' . $mail->ErrorInfo;
}