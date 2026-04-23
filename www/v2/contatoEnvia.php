<?php
require_once(__DIR__ . '/inc/security.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}

csrf_check();

// Remove \r e \n (previne header injection) e aplica trim.
function sanitize_line($s) {
    return trim(str_replace(["\r", "\n"], ' ', (string)$s));
}

$nome     = sanitize_line($_POST['nome']     ?? '');
$email    = sanitize_line($_POST['email']    ?? '');
$assunto  = sanitize_line($_POST['assunto']  ?? '');
$mensagem = trim((string)($_POST['mensagem'] ?? ''));

$errors = [];
if ($nome === '' || mb_strlen($nome) > 100) $errors[] = 'Nome inválido.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 100) $errors[] = 'E-mail inválido.';
if ($assunto === '' || mb_strlen($assunto) > 150) $errors[] = 'Assunto inválido.';
if ($mensagem === '' || mb_strlen($mensagem) > 5000) $errors[] = 'Mensagem inválida.';

if ($errors) {
    http_response_code(400);
    echo '<!doctype html><meta charset="utf-8"><title>Dados inválidos</title>';
    echo '<h1>Não foi possível enviar</h1><ul>';
    foreach ($errors as $e) echo '<li>' . h($e) . '</li>';
    echo '</ul><p><a href="contato.php">Voltar</a></p>';
    exit;
}

$mensagemHTML = '<table border="1" cellpadding="6" cellspacing="0" style="font-family:Arial,sans-serif;font-size:14px">'
    . '<tr><td><b>NOME</b></td><td>'     . h($nome)     . '</td></tr>'
    . '<tr><td><b>E-MAIL</b></td><td>'   . h($email)    . '</td></tr>'
    . '<tr><td><b>ASSUNTO</b></td><td>'  . h($assunto)  . '</td></tr>'
    . '<tr><td><b>MENSAGEM</b></td><td>' . nl2br(h($mensagem)) . '</td></tr>'
    . '</table>';

$emailsender       = 'contato@multicursosdf.com.br';
$emaildestinatario = 'multicursosdf@hotmail.com';
$assuntoFinal      = 'Fale Conosco: ' . $assunto;
$quebra_linha      = (PATH_SEPARATOR === ';') ? "\r\n" : "\n";

$headers  = 'MIME-Version: 1.0' . $quebra_linha;
$headers .= 'Content-type: text/html; charset=UTF-8' . $quebra_linha;
$headers .= 'From: ' . $emailsender . $quebra_linha;
$headers .= 'Reply-To: ' . $email . $quebra_linha;

$enviado = @mail($emaildestinatario, $assuntoFinal, $mensagemHTML, $headers, '-r' . $emailsender);
if (!$enviado) {
    $headers .= 'Return-Path: ' . $emailsender . $quebra_linha;
    $enviado = @mail($emaildestinatario, $assuntoFinal, $mensagemHTML, $headers);
}

// Regenera o token (anti-replay do mesmo formulário).
unset($_SESSION['_csrf']);
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Mensagem enviada</title>
<meta http-equiv="refresh" content="3;url=index.php">
<style>body{font-family:system-ui,sans-serif;max-width:540px;margin:6rem auto;padding:0 1rem;text-align:center;color:#1a1f2a}
h1{color:#e86a10}a{color:#e86a10}</style>
</head>
<body>
<?php if ($enviado): ?>
  <h1>Mensagem enviada!</h1>
  <p>Obrigado por entrar em contato com a Multicursos. Entraremos em contato o mais breve possível.</p>
  <p>Redirecionando para a página inicial… <a href="index.php">clique aqui</a> se preferir.</p>
<?php else: ?>
  <h1>Falha no envio</h1>
  <p>Não foi possível enviar sua mensagem no momento. Tente novamente em instantes ou ligue para (61) 3967-7270.</p>
  <p><a href="contato.php">Voltar</a></p>
<?php endif; ?>
</body>
</html>
