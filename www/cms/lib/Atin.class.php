<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
/*
 * Classe de funções sql injection.
 */
 
class Sqlinjection{
	var $erro;
	/*Construtor*/
	function Sqlinjection(){
		
	}
	
	//Função anti injection
	function atin($string){		
		//Verifica string
		if(is_array($string)){
			//String temp
			$stringTemp = array();
			
			//Executa anti sqlinjection
			for($i=0;$i<count($string);$i++){
				$stringTemp[$i] = !get_magic_quotes_gpc()?mysql_escape_string($string[$i]):$string[$i];
			}
			
			//Retorna dados
			return $stringTemp;
		}else{
			return !get_magic_quotes_gpc()?mysql_escape_string($string):$string;
		}
	}
	
	//Retorna erro
	function getErro(){
		return $this->erro;
	}
}

//Função anti injection
function atin($string){
	//Verifica string
	if(is_array($string)){
		//String temp
		$stringTemp = array();
		
		//Executa anti sqlinjection
		for($i=0;$i<count($string);$i++){
			$stringTemp[$i] = !get_magic_quotes_gpc()?mysql_escape_string($string[$i]):$string[$i];
		}
		
		//Retorna dados
		return $stringTemp;
	}else{
		return !get_magic_quotes_gpc()?mysql_escape_string($string):$string;
	}
}

//Cria objeto
$_ClassAtin = new Sqlinjection;
?>
