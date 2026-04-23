<?php
/*
 * Classe de tratamento de números
 */
 
class Numeros{
	var $erro;
	
	/* Construtor */
	function Numeros(){
		
	}
	
	// Verifica se a string só contém números
	function verificaStringNum($string){
		return preg_match("/[0-9]/i", $string);
	}
	
	// Deixa numeros
	function deixaNumeros($string){
		//Verifica cadaq char da string
		for($i=0;$i<strlen($string);$i++){
			//Verifica se o char e numero
			if($this->verificaStringNum($string{$i})){$stringTemp{$i} = $string{$i};}
		}
		return $stringTemp;
	}
	
	//Retorna erro
	function getErro(){
		return $this->erro;
	}
}

//Cria objeto
$_ClassNumeros = new Numeros;
?>

