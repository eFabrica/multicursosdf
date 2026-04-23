<?php
/*
 * Classe de tratamento de valores financeiros
 */
class Dinheiro{
	var $erro;
	
	/* Construtor */
	function Dinheiro(){
		
	}
	
	// Formata moeda
	function formataMoeda($valor, $moeda="real"){
		if ($valor > 0){
			//Verifica moeda
			switch($moeda){
				case "real": $valor = number_format($valor, 2, ',', '.'); break;
			}
			
			//retorna valor
			return $valor;
		}
	}
	
	// Limpa formatação da moeda
	function limpaFormatacaoMoeda($valor, $moeda="real"){
		//Verifica moeda
		switch($moeda){
			case "real": 
				$valor = str_replace(".", "", $valor); 
				$valor = str_replace(",", ".", $valor);
			break;
		}
		
		//retorna valor
		return $valor;
	}
	
	//Retorna erro
	function getErro(){
		return $this->erro;
	}
}

// Cria objeto
$_ClassDinheiro = new Dinheiro;
?>

