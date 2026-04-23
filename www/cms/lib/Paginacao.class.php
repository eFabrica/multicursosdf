<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
/*
Esta classe foi desenvolvida para facilitar a paginação. Ela contém vários tipos de paginação.
*/
class Paginacao{
	
	/*Variáveis uteis*/
	var $erroPagi = ""; // Erros
	var $modelo = 1; // Iniciando com o padrão
	var $paginaAtual = 1; // Iniciando com o padrão
	var $conex; // Conexão com banco
	var $query = ""; // Inicia sem valor
	var $file = ""; // Inicia sem valor
	var $exibe = 10; // Valor padrão
	var $url = "?"; // Valor padrão
	var $totalAchadoQuery = 0; //Valor padrão
	var $urlProximo = ""; // Inicia sem valor
	var $urlAnterior = ""; // Inicia sem valor
	var $totalPaginas = 0; // Valor padrão
	var $html = ""; // Sem valor
	var $buscaRegistrosPG; //sem valor
	var $pathImg = "./imagens/";
	
	/*Iniciando o construtor*/
	function paginando($pathInc=""){
		/*Chamando função de escolha de modelo*/
		$this->escolheModelo($pathInc);
	}
	
	/*Escolhendo modelo*/
	function escolheModelo($pathInc=""){
		//opções
		switch($this->modelo){
			case 1: $this->getModelo1($pathInc); break;
			default: $this->setErro("Modelo não encontrado.");
		}
	}
	
	/*Tipos de modelos*/
		/*Modelo 1*/
		function getModelo1($pathInc=""){
			//Limite inicial
			$inicioLimit = ( $this->paginaAtual - 1 ) * $this->exibe;
			
			//Verifica se tem uma query
			if($this->query != ""){
				//Buscando registro
				$this->buscaRegistros = @mysql_query($this->query . " LIMIT " . $inicioLimit . "," . $this->exibe) or die($this->setErro(mysql_errno()));
				$this->buscaRegistrosPG = @mysql_query($this->query) or die($this->setErro(mysql_errno()));
				
				//Total achado
				$this->totalAchadoQuery = mysql_num_rows($this->buscaRegistrosPG);

				//Total de páginas
				$this->totalPaginas = ceil($this->totalAchadoQuery / $this->exibe);
				
				//Próximo
				$proximo = $this->paginaAtual + 1;
				
				//Anterior
				$anterior = $this->paginaAtual - 1;
				
				//Verifica se tem paginação
				if($this->totalPaginas > 0){
				
					/*html*/
					$this->html .= "<table width='100%' border='0' cellpadding='0' cellspacing='0' align='center'>";
					$this->html .= "  <tr>";
					$this->html .= "    <td align='right'>";
					//Verifica anterior
					if($this->paginaAtual > 1){
						//URL
						$this->urlAnterior = $this->url . (($this->url != "?")?"&":"") . "pg=" . $anterior;
						$this->html .= "    	<a href=\"" . $this->urlAnterior . "\"><img src='" . $pathInc . "imagens/botoes/botaoAnterior_on.png' border='0'></a>";
					}else{
						$this->html .= "    	<img src='" . $pathInc . "imagens/botoes/botaoAnterior_off.png'>";
					}
					$this->html .= "    </td>";
					$this->html .= "    <td >";
					$this->html .= "		<table width='210' align='center' border='0' cellpadding='' cellspacing='0'>";
					$this->html .= "			<tr>";
					$this->html .= "				<td align='right'>";
					$this->html .= "					" . (($this->totalPaginas <= 1)?"<img src='" . $pathInc . "imagens/botoes/botaoVerPagina_off.png' border='0'>":"<a href='#' onClick=\"location.href='" . $this->url . "&pg='+document.getElementById('pg').value\"><img src='" . $pathInc . "imagens/botoes/botaoVerPagina_on.png' border='0' class='nda'></a>");
					$this->html .= "				</td>";
					$this->html .= "				<td height='25' width='100%' valign='middle' style='background-image:url(" . $pathInc . "imagens/botoes/botaoBlank.png);background-position:center;background-repeat:no-repeat;'>
														<input style='text-align:center;margin-top:0px;margin-left:10px;height:16px;font-size:9px;' name=\"pg\" type=\"text\" size=\"1\" id=\"pg\" value=\"" . $this->paginaAtual . "\"" . (($this->totalPaginas <= 1)?"disabled":"") . ">
														de <strong>" . $this->totalPaginas . "</strong> p&aacute;ginas
													</td>";
					$this->html .= "			</tr>";
					$this->html .= "		</table>";
					$this->html .= "	</td>";
					$this->html .= "    <td >";
					//Verificando proximo
					if($this->paginaAtual < $this->totalPaginas){
						//URL
						$this->urlProxima = $this->url . (($this->url != "?")?"&":"") . "pg=" . $proximo;
						$this->html .= "    	<a href=\"" . $this->urlProxima . "\"><img src='" . $pathInc . "imagens/botoes/botaoProximo_on.png' border='0'></a>";
					}else {
						$this->html .= "    	<img src='" . $pathInc . "imagens/botoes/botaoProximo_off.png'>";
					}
					$this->html .= "    </td>";
					$this->html .= "  </tr>";
					$this->html .= "</table>";
					
				}
			}else{
				//erroPagi
				$this->setErro("É preciso informar a query.");
			}
		}
	/*Fim dos modelos*/
	
	/*Show*/
	function showPaginacao(){
		return $this->html;
	}
	
	/*Regras de negócios*/	
		/*Atribuições*/
			/*Seta erroPagi*/
			function setErro($erroPagi){
				$this->erroPagi .= $erroPagi . "<br>";
			}
			
			/*Seta modelo de paginação*/
			function setModelo ($modelo){ 
				$this->modelo = $modelo; 
			}
			
			/*Seta a url*/
			function setUrl($url){
				$this->url = $url;
			}
			
			/*Seta a url proximo*/
			function setUrlProximo($urlProximo){
				$this->urlProximo = $urlProximo;
			
			}
			
			/*Seta a url anterior*/
			function setUrlAnterior($urlAnterior){
				$this->urlAnterior = $urlAnterior;
			}
			
			/*Seta conex*/
			function setConex($conex){
				$this->conex = $conex;
			}
			
			/*Seta a query*/
			function setQuery($query){
				$this->query = $query;
			}
			
			/*Seta pagina inicial*/
			function setPaginaAtual($paginaAtual){
				$this->paginaAtual = $paginaAtual;
			}
			
			/*Seta o total de paginas a exibir*/
			function setRegistrosPorPagina($qtd){
				$this->exibe = $qtd;
			}
			
			/*Seta o caminho das imagens*/
			function setPathImg($pathImg){
				$this->pathImg = $pathImg;
			}
			
		/*Retorno*/
			/*Retorna erroPagi*/
			function getErro(){
				return $this->erroPagi;
			}
			
			/*Retorna modelo de paginação*/
			function getModelo (){
				return $this->modelo;
			}
			
			/*Retorna url*/
			function getUrl(){
				return $this->url;
			}
			
			/*Retorna url proximo*/
			function getUrlProximo(){
				return $this->urlProximo;
			}
			
			/*Retorna url anterior*/
			function getUrlAnterior(){
				return $this->urlAnterior;
			}
			
			/*Retorna o total achado*/
			function getTotalAchadoQuery(){
				return $this->totalAchadoQuery;
			}
			
			/*Retorna busca*/
			function getBusca(){
				return $this->buscaRegistros;
			}
			
	/*Fim das regras de negocios*/
}

//Cria objeto
$_ClassPaginacao = new Paginacao;
?>

