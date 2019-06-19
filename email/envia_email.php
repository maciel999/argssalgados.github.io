<?php
$data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$contato = utf8_decode("<h1>Dados enviados pelo formulário do site</h1>");
foreach ($data as $chave => $valor){
    $campo = strtoupper($chave);
    $contato.= utf8_decode("<b>{$campo}</b>: {$valor}<br>");
}
$email = $data["email"];
$nome = $data["nome"];

// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
require_once("./class.phpmailer.php");
require_once("./class.smtp.php");

// Inicia a classe PHPMailer
$mail = new PHPMailer();

// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Host = "br634.hostgator.com.br"; // Endereço do servidor SMTP
$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
$mail->Username = 'contatos@professorbrunomarques.com.br'; // Usuário do servidor SMTP
$mail->Password = 'bsm007'; // Senha do servidor SMTP
$mail->SMTPSecure = 'tls'; // Tipo de segurança
$mail->Port = '587'; // Porta para envio autenticado

// Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->From = "contatos@professorbrunomarques.com.br"; // Seu e-mail
$mail->FromName = $nome; // Seu nome

// Define os destinatário(s)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->AddAddress('bruno_s_marques@hotmail.com', 'Novo contato');
//$mail->AddAddress('ciclano@site.net');
//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

// // Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->Subject  = "Mensagem Teste"; // Assunto da mensagem
//$mail->Body = "Este é o corpo da mensagem de teste, em <b>HTML</b>!  :)";
$mail->Body = $contato;
//$mail->AltBody = "Este é o corpo da mensagem de teste, em Texto Plano! \r\n :)";

// // Define os anexos (opcional)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo

// Envia o e-mail
$enviado = $mail->Send();

// Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();

// Exibe uma mensagem de resultado
if ($enviado) {
  echo "<script>alert('Email enviado com sucesso!'); location.href='index.html';</script>";
} else {
  echo "<script>alert('".$mail->ErrorInfo."'); location.href=history.back();</script>";
}

?>
