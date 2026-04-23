<?
/*
 * Classe de funções de e-mail. Content-Type: text/html; charset=us-ascii"
 */
 
class Email{
	var $erro;
	var $email;
	var $titulo;
	var $mensagem;
	var $headers;
	
	/*Construtor*/
	function Email(){
				
	}
	
	/*Valida e-mail*/
	function validaEmail($email){
		//Validando e-mail
		return preg_match("/^([0-9,a-z,A-Z]+)([.,_]([0-9,a-z,A-Z]+))*[@]([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])?$/", $email);
	}
	
	/* Envia e-mail */
	
		//Seta email
		function setEmail($email){$this->email .= $email;}
		
		//Seta titulo
		function setTitulo($titulo){$this->titulo .= $titulo;}
		
		//Seta mensagem
		function setMensagem($mensagem){$this->mensagem .= $mensagem;}
		
		//Seta headers
		function setHeaders($headers){$this->headers .= $headers;}
		
		//Envia o email
		function sendEmail(){mail($this->email, $this->titulo, $this->mensagem,$this->headers);}
	
	/* FIM das funcoes de envio de email */
	
	//Retorna erro
	function getErro(){
		return $this->erro;
	}
}

// Cria objeto
$_ClassEmail = new Email;
?>

