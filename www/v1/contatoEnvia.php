<?php

$nome     = $_POST['nome'];
$mensagem     = $_POST['mensagem'];
$email     = $_POST['email'];
$assunto     = $_POST['assunto'];


$mensagemHTML = "<table border='1'>
                    	<tr>
                        	<td align='left'><b>NOME:</b>&nbsp;
                            <font size='2'><br>".$nome."</font><br>                      		 
                            </td>
						</tr>
                        <tr>
                        	<td align='left'><b>ASSUNTO:</b>&nbsp;
                            <font  size='2'><br>".$assunto."</font><br>                      		
                            </td>
                        </tr>						
						<tr>
                            <td	align='left'><b>MENSAGEM:</b>&nbsp;
                            <font  size='2'><br>".$mensagem."</font><br>                            
                            </td>
                        </tr>
                        <tr>
                        	<td align='left'><b>EMAIL:</b>&nbsp;
                            <font size='2'><br>".$email."</font><br>
                            </td>
                        </tr>
                    </table>";


 
/* Medida preventiva para evitar que outros domínios sejam remetente da sua mensagem. */
$emailsender = "contato@multicursosdf.com.br";
 
/* Verifica qual éo sistema operacional do servidor para ajustar o cabeçalho de forma correta.  */
if(PATH_SEPARATOR == ";") $quebra_linha = "\r\n"; //Se for Windows
else $quebra_linha = "\n"; //Se "nÃ£o for Windows"
 
// Passando os dados obtidos pelo formulário para as variáveis abaixo
$nomeremetente     = "Multicursos - Formação Profissional";
$emailremetente    = "contato@multicursosdf.com.br";
$emaildestinatario = "multicursosdf@hotmail.com";
$comcopia          = $mensagemHTML;
$comcopiaoculta    = "";
$assunto           = "Fale Conosco";
 
 
/* Montando o cabeÃ§alho da mensagem */
$headers = "MIME-Version: 1.1" .$quebra_linha;
$headers .= "Content-type: text/html; charset=iso-8859-1" .$quebra_linha;

// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
$headers .= "From: " . $emailsender.$quebra_linha;
$headers .= "Cc: " . $comcopia . $quebra_linha;
$headers .= "Bcc: " . $comcopiaoculta . $quebra_linha;
$headers .= "Reply-To: " . $emailremetente . $quebra_linha;
// Note que o e-mail do remetente será usado no campo Reply-To (Responder Para)
 
/* Enviando a mensagem */

//É obrigatório o uso do parâmetro -r (concatenação do "From na linha de envio"), aqui na Locaweb:

if(!mail($emaildestinatario, $assunto, $mensagemHTML, $headers ,"-r".$emailsender)){ // Se for Postfix
    $headers .= "Return-Path: " . $emailsender . $quebra_linha; // Se "não for Postfix"
    mail($emaildestinatario, $assunto, $mensagemHTML, $headers );
}
 
echo "
<script language='JavaScript'>
	alert('Obrigado por entrar em contato com a Multicursos. Entraremos em contato o mais breve poss\xEDvel.');
	document.location.href ='http://www.multicursosdf.com.br';
</script>"

?>
