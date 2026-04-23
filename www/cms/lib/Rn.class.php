<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
/*
 * Regras de negócios
*/

class Rn{
	
	var $erro;
	var $tot;
	var $query;
	/*Construtor*/
	function Rn(){
		/**/
	}
	
	/*Setar*/
	
		/* Seta erro */
		function setErro($erro){
			//Insere erro no log
			mysql_query("INSERT INTO log_erros (`erro`) VALUES ('" . $erro . "')");
		}
	/*Retornar*/
	
		/*Retorna dados de determinada tabela*/
		function getDadosTable($tabela, $campos, $condicao=0, $conex=false){
			
			$this->query = "SELECT " . $campos . " FROM `" . $tabela . "`" . (($condicao != "")?" WHERE " . $condicao:"");
			
			//Busca dados
			if ($conex) $buscaDados = @mysql_query($this->query, $conex) or die (mysql_error()); else $buscaDados = @mysql_query($this->query) or die (mysql_error());
			
			// total achado
			$this->tot = mysql_num_rows($buscaDados);
			
			//retorna dados
			return mysql_fetch_object($buscaDados);
		}
		
		//Retorna erro
		function getErro(){
			return $this->erro;
		}
		
		//Retorna tot
		function getTot(){
			return $this->tot;
		}
		
		//Retorna query
		function getQuery(){
			return $this->query;
		}
}

//Cria objeto
$_ClassRn = new Rn;
?>
