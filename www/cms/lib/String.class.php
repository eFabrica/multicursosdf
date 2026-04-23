<?
/*
 * Classe de funções de strings.
 */
 
class Strings{
	var $erro;
	
	/*Construtor*/
	function Strings(){
		
	}
	
	//Retira acentos
	function acentos($string){ 
		$string = eregi_replace("[àáâäã]","a",$string); 
		$string = eregi_replace("[èéêë]","e",$string); 
		$string = eregi_replace("[ìíîï]","i",$string); 
		$string = eregi_replace("[òóôöõ]","o",$string); 
		$string = eregi_replace("[ùúûü]","u",$string); 
		$string = eregi_replace("[ÀÁÂÄÃ]","A",$string); 
		$string = eregi_replace("[ÈÉÊË]","E",$string); 
		$string = eregi_replace("[ÌÍÎÏ]","I",$string); 
		$string = eregi_replace("[ÒÓÔÖÕ]","O",$string); 
		$string = eregi_replace("[ÙÚÛÜ]","U",$string); 
		$string = eregi_replace("ç","c",$string); 
		$string = eregi_replace("Ç","C",$string); 
		$string = eregi_replace("ñ","n",$string); 
		$string = eregi_replace("Ñ","N",$string); 
		$string = str_replace("´","",$string); 
		$string = str_replace("`","",$string); 
		$string = str_replace("¨","",$string); 
		$string = str_replace("^","",$string); 
		$string = str_replace("~","",$string); 
		
		return $string; 
	} 
	
	function filtraTexto ($texto){
		
		// Filtra Texto
		$texto = str_replace("'", "\'", $texto);
		//$texto = str_replace("\"", "\'", $texto);
		
		return $texto;
		
	}
	
	//Retorna erro
	function getErro(){
		return $this->erro;
	}
}

//Cria objeto
$_ClassString = new Strings;
?>

