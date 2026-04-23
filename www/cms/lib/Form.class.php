<?
/*
 * Classe de funções de formulários.
 */
 
class Form{
	var $erro;
	
	/*Construtor*/
	function Form(){
		
	}
	
	//Verifica se o campo está em branco
	function cb($campo, $erro){
		return empty($campo)?$erro . "<br>":"";
	}
	
	//Retorna erro
	function getErro(){
		return $this->erro;
	}
}

// Cria objeto
$_ClassForm = new Form;
?>

