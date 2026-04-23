<?
/*
 * Classe de funções de datas.
 */
 
class Data{
	var $erro;
	
	/*Construtor*/
	function Data(){
		
	}
	
	/* Função que transforma data de AAAA-MM-DD para DD/MM/AAAA e de DD/MM/AAAA para AAAA-MM-DD*/
	function transformaData($data, $modo=1){
		
		// Verifica se foi informado alguma data
		if($data != "" && $data != "0000-00-00" && $data != "00/00/0000"){
		
			//Verifica modo
			switch($modo){
				case 1:
					
					// Verifica se tem data
					if($data != ""){
						
						// Explode data e atribui as variáveis.
						list($dia, $mes, $ano) = explode("/", $data);
						
						// Novo formato da data
						$data = $ano . "-" . $mes . "-" . $dia;
						
					}
				break;
				
				case 2:
					
					// Verifica se tem data
					if($data != ""){
					
						// Explode data e atribui as variáveis.
						list($ano, $mes, $dia) = explode("-", $data);
					
						// Novo formato da data
						$data = $dia . "/" . $mes . "/" . $ano;
						
					}
					
				break;
				
				case 3:
					//Explode data e hora
					list($data, $hora) = explode(" ", $data);
					
					//Explode data e atribui as variáveis.
					list($ano, $mes, $dia) = explode("-", $data);
					
					//Novo formato da data
					$data = $dia . "/" . $mes . "/" . $ano . " " . $hora;
				break;
				
				case 4:
					//Explode data e hora
					list($data, $hora) = explode(" ", $data);
					
					//Explode data e atribui as variáveis.
					list($ano, $mes, $dia) = explode("-", $data);
					
					//Novo formato da data
					$data = $dia . "/" . $mes . "/" . $ano . " " . $hora;
				break;
				
				default: $this->erro = "Modo não existente.";
			}
			
			return $data;
			
		}
		
	}
	
	/* Verifica data */
	function validaData($data){
		//Verifica em qual formato ela está
		if(preg_match("/[0-9][0-9]-[0-9][0-9]-[0-9][0-9]/i", $data)){
			//explode data
			list($ano, $mes, $dia) = explode("-", $data);
		}elseif(preg_match("#[0-9][0-9]/[0-9][0-9]/[0-9][0-9]#i", $data)){
			//explode data
			list($dia, $mes, $ano) = explode("/", $data);
		}else{
			//Erro
			$this->erro = "Data em formato desconhecido.";
		}
		
		//Valida data
		return (!checkdate($mes, $dia, $ano))?false:true;
	}
	
	//Retorna erro
	function getErro(){
		return $this->erro;
	}
}

// Cria objeto
$_ClassData = new Data;
?>
