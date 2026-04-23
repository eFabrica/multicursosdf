<?php require_once("php7_mysql_shim.php");
// Classe de Paginação
require_once($pathInc . "lib/Paginacao.class.php");

/* Classe de consulta  */
class Consulta {
	
	/* Atributos */
	
		protected $onchange;
		protected $pacoes = true;
		protected $acoes;
		protected $linksAcoes;
		protected $filtro = true;
		protected $textFiltro;
		protected $campoFiltro;
		protected $camposTopico;
		protected $camposTopicoTamanho;
		protected $tOrdenacao = true;
		protected $camposDados;
		protected $pcampoLinkEdit = true;
		protected $campoLinkEdit;
		protected $posicaoCamposDados;
		protected $modificarDados;
		protected $query;
		protected $urlPaginacao;
		protected $totalPagina;
		protected $html;
		protected $marcador = "checkbox";
		protected $tamanhoTablePrincipal = "100%";
		protected $pPaginacao = true;
		protected $utilitarios;
		protected $paginacao;
		protected $dinheiro;
		protected $data;
		
	/* Construtor */
	
		public function __construct(){
			
			
			
		}
		
	/* Métodos */	
		
		// Gera Consulta
		public function geraConsulta (){
			
			// Html
			$this->setHtml("<tr>
								<td align='left'><div id='border-top'><div><div></div></div></div></td>
							</tr>
							<tr>
								<td class='table_main'>
									<table width='" . $this->tamanhoTablePrincipal . "' border='0' cellpadding='1' cellspacing='1' align='center'>");
			// Verifica se foi permitido ações
			if($this->pacoes){
				
				// Html
				$this->setHtml("		<tr>
											<td width='15%' align='right'>Com&nbsp;Selecionados:</td>
											<td width='75%'>
												<select onchange=\"" . $this->onchange . "\">
													<option value=''></option>");	
				
				// Lê Ações
				for($a = 0; $a < count($this->acoes); $a++){
					
					// Html
					$this->setHtml("				<option value='" . $this->linksAcoes[$a] . "'>" . $this->acoes[$a] . "</option>");
					
				}
				
				// Html
				$this->setHtml("				</select>
											</td>");
				
			}
			
			// Html
			$this->setHtml((($this->filtro)?"<td width='" . ((!$this->pacoes)?"100%":"10%") . "' align='right'>" . $this->textFiltro . ":</td><td align='left'><form action='' method='POST' name='filtrar'><input type='text' name='filtro' value='" . $_REQUEST["filtro"] . "'></form></td><td width='10%'>" . $this->utilitarios->criaMenu("Filtrar", "#", "document.filtrar.submit();", "esq", "007") . "</td>":"") . "</tr>");
			
			// Query String
			$queryString = $_SERVER['QUERY_STRING'];
			
			// Limpa Query String
			$queryString = str_replace("&campo=" . $_REQUEST["campo"], "", $queryString);
			$queryString = str_replace("&campo=", "", $queryString);
			$queryString = str_replace("&ordem=" . $_REQUEST["ordem"], "", $queryString);
			$queryString = str_replace("&ordem=", "", $queryString);
			$queryString = str_replace("&filtro=" . $_REQUEST["filtro"], "", $queryString);
			$queryString = str_replace("&filtro=", "", $queryString);
			$queryString = "?".$queryString . "&filtro=" . $_REQUEST["filtro"];
			
			// Html
			$this->setHtml("			<tr>
											<td colspan='5'>
												<form action='' method='POST' name='consulta'>
													<table class='consulta' cellspacing='1' align='center'>
														<thead>
															<tr>
																<th width='5'>" . ((!$this->tOrdenacao)?"#":$this->utilitarios->OrdemControl("#", $queryString, "id")) . "</th>
																<th width='5' align='center'>" . (($this->marcador == "checkbox")?"<input type='checkbox' onclick=\"select_all('consulta', 'registros[]')\">":"") . "</th>");
			
			// Lê Campos do Tópico
			for($b = 0; $b < count($this->camposTopico); $b++){
				
				// Html
				$this->setHtml("								<th width='" . $this->camposTopicoTamanho[$b] . "'>" . ((!$this->tOrdenacao)?$this->camposTopico[$b]:$this->utilitarios->OrdemControl($this->camposTopico[$b], $queryString, $this->camposDados[$b])) . "</th>");
				
			}
			
			// Html
			$this->setHtml("								</tr>
														</thead>
														<tbody>");			
			
			
			// Configurações da paginacao
			$this->paginacao->setQuery($this->query . (($this->filtro)?((strpos($this->query, "where") > 0)?" AND " . $this->campoFiltro . " LIKE '%" . $_REQUEST["filtro"] . "%'":" WHERE " . $this->campoFiltro . " LIKE '%" . $_REQUEST["filtro"] . "%'"):"") . (($this->tOrdenacao)?" ORDER BY " . (($_REQUEST['campo'] == '')?'id':$_REQUEST['campo']) . " " . (($_REQUEST['ordem'] == '')?"DESC":$_REQUEST['ordem']):""));
			$this->paginacao->setUrl($this->urlPaginacao . '&ordem=' . $_REQUEST['ordem'] . '&campo=' . $_REQUEST['campo'] . '&filtro=' . $_REQUEST['filtro']);
			$this->paginacao->setRegistrosPorPagina($this->totalPagina);
			$this->paginacao->setPaginaAtual((($_REQUEST['pg'] == 0)?'1':$_REQUEST['pg']));
			$this->paginacao->paginando();
			
			// Verifica total achado
			if($this->paginacao->getTotalAchadoQuery() == 0){
				
				// Html
				$this->setHtml("							<tr>
																<td align='center' colspan='" . (count($this->camposTopico)+2) . "' class='menu'>Nenhum resultado encontrado.</td>
															</tr>");
			}else{
				
				// Contador
				$cont = 1;
				
				// Traz resultados
				while($trazResultados = mysql_fetch_assoc($this->paginacao->getBusca())){
					
					// Html
					$this->setHtml("						<tr class='row0'>
																<td align='left'>" . $trazResultados["id"] . "</td>
																<td align='center'>" . (($this->marcador == "checkbox")?"<input type='checkbox' id='registros' name='registros[]' value='" . $trazResultados["id"] . "'>":"<input type='radio' id='registros' name='registros' value='" . $trazResultados["id"] . "' " . (($cont++ == 1)?"checked":"") . ">") . "</td>");
								
					// Lê Campos dos Campos
					for($c = 0; $c < count($this->camposDados); $c++){
						
						// Verifica Modifição
						switch ($this->modificarDados["modificacoes"][$this->camposDados[$c]]["tipo"]){
							
							// Caso for 1
							case "1":
								
								// Busca Dados 
								$buscaDados = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela"] . " WHERE id = '" . $trazResultados[$this->camposDados[$c]] . "' " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao"]);
								
								// Traz Dados
								$trazDados = mysql_fetch_assoc($buscaDados);
								
								// Define Campo
								$campo = $trazDados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["exibirCampo"]];
								
							break;
							
							// Caso for 2
							case "2":
								
								// Campo
								$campoOri = $trazResultados[$this->camposDados[$c]];
								
								// Verifica se tem limite
								if($this->modificarDados["modificacoes"][$this->camposDados[$c]]["limite"] == "true"){

									// Limita o número de caracteres
									$campo = substr($campoOri, $this->modificarDados["modificacoes"][$this->camposDados[$c]]["comecoT"], $this->modificarDados["modificacoes"][$this->camposDados[$c]]["qtdT"]) . "...";
									
								}
								
								// Verifica Se tem Legenda
								if($this->modificarDados["modificacoes"][$this->camposDados[$c]]["legenda"] == "true"){
									
									// Coloca Legenda
									$campo = "<div " . $this->utilitarios->criaLegenda($campoOri, 1) . ">" . $campo . "</div>";
									
								}
								
							break;
							
							// Caso for 3
							case "3":
								
								// Campo
								$campo = "R$ " . $this->dinheiro->formataMoeda($trazResultados[$this->camposDados[$c]]);
								
							break;
							
							// Caso 4
							case "4":
								
								// Campo
								$campo = $this->data->transformaData($trazResultados[$this->camposDados[$c]], $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tipot"]);
								
							break;
							
							// Caso 5
							case "5":
								
								// Busca Dados 
								$buscaDados1 = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos1"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela1"] . " WHERE id = '" . $trazResultados[$this->camposDados[$c]] . "'" . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao1"]);
								
								// Traz Dados
								$trazDados1 = mysql_fetch_assoc($buscaDados1);
								
								// Busca Dados 
								$buscaDados2 = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos2"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela2"] . " WHERE id = '" . $trazDados1[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["campob1"]] . "'" . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao1"]);
								
								// Traz Dados
								$trazDados2 = mysql_fetch_assoc($buscaDados2);
								
								// Define Campo
								$campo = $trazDados2[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["exibirCampo"]];
								
							break;
							
							// Caso for 6
							case "6":
								
								// Busca Dados 
								$buscaDados = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela"] . " WHERE id = '" . $trazResultados["id"] . "' " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao"]);
								
								// Traz Dados
								$trazDados = mysql_fetch_assoc($buscaDados);
								
								// Define Campo
								$campo = $trazDados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["exibirCampo"]];
								
							break;
							
							case "7":
								
								// Busca Dados 
								$buscaDados = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela"] . " WHERE id = '" . $trazResultados["id"] . "' " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao"]);
								
								// Traz Dados
								$trazDados = mysql_fetch_assoc($buscaDados);
								
								// Busca Dados 
								$buscaDados1 = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos1"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela1"] . " WHERE id = '" . $trazDados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["campob"]] . "'" . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao1"]);
								
								// Traz Dados
								$trazDados1 = mysql_fetch_assoc($buscaDados1);
								
								// Busca Dados 
								$buscaDados2 = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos2"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela2"] . " WHERE id = '" . $trazDados1[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["campob1"]] . "'" . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao1"]);
								
								// Traz Dados
								$trazDados2 = mysql_fetch_assoc($buscaDados2);
								
								// Define Campo
								$campo = $trazDados2[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["exibirCampo"]];
								
							break;
							
							case "8":
								
								// Busca Dados 
								$buscaDados = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela"] . " WHERE id = '" . $trazResultados["id"] . "' " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao"]);
								
								// Traz Dados
								$trazDados = mysql_fetch_assoc($buscaDados);
								
								// Busca Dados 
								$buscaDados1 = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos1"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela1"] . " WHERE id = '" . $trazDados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["campob"]] . "'" . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao1"]);
								
								// Traz Dados
								$trazDados1 = mysql_fetch_assoc($buscaDados1);
								
								// Define Campo
								$campo = $trazDados1[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["exibirCampo"]];
								
							break;
							
							// Caso for 9
							case "9":
								
								// Busca Dados 
								$buscaDados = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela"] . " WHERE id = '" . $trazResultados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["campoP"]] . "' " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao"]);
								
								// Traz Dados
								$trazDados = mysql_fetch_assoc($buscaDados);
								
								// Define Campo
								$campo = $trazDados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["exibirCampo"]];
								
							break;
							
							// Caso for 10
							case "10":
								
								// Campo
								$campo = $this->utilitarios->completaZ($trazResultados[$this->camposDados[$c]], 4);
								
							break;
							
							// Caso for 11
							case "11":
								
								// Busca Dados 
								$buscaDados = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos1"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela1"] . " WHERE id = '" . $trazResultados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["campoP1"]] . "' " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao1"]);
								
								// Traz Dados
								$trazDados = mysql_fetch_assoc($buscaDados);
								
								// Define Campo
								$campo = $trazDados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["exibirCampo1"]];
								
								###
								
								// Busca Dados 
								$buscaDados = mysql_query("SELECT " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["campos2"] . " FROM " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["tabela2"] . " WHERE id = '" . $trazResultados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["campoP2"]] . "' " . $this->modificarDados["modificacoes"][$this->camposDados[$c]]["condicao2"]);
								
								// Traz Dados
								$trazDados = mysql_fetch_assoc($buscaDados);
								
								// Define Campo
								$campo .= $trazDados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["msgConcat"]] . $trazDados[$this->modificarDados["modificacoes"][$this->camposDados[$c]]["exibirCampo2"]];
								
							break;
							
							default:
								
								// Define campo
								$campo = $trazResultados[$this->camposDados[$c]];
							
						}
						
						
						// Html
						$this->setHtml("						<td align='" . $this->posicaoCamposDados[$c] . "'>" . (($this->campoLinkEdit == $this->camposDados[$c] && $this->pcampoLinkEdit)?"<a href='" . $this->urlPaginacao . "&ordem=" . $_REQUEST['ordem'] . "&campo=" . $_REQUEST['campo'] . "&pg=" . $_REQUEST['pg'] . '&filtro=' . $_REQUEST['filtro'] . "&ref=edit&idRegistro=" . $trazResultados["id"] . "'><b>" . $campo . "</b></a>":$campo) . "</td>");
						
					}
					
					// Html
					$this->setHtml("						</tr>");
												
				}
				
				// Html
				$this->setHtml("						</tbody>
														<tfoot>
															<td colspan='" . (count($this->camposTopico)+2) . "'>" . (($this->pPaginacao)?$this->paginacao->showPaginacao():"") . "</td>
														</tfoot>
													</table>
												</form>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align='left'><div id='border-bottom'><div><div></div></div></div></td>
							</tr>");
			}
			
		}
		
	/* Sets */
		
		public function setHtml ($html){
			
			// Atribui
			$this->html .= $html;
			
		}
		
		public function setMarcador ($marcador){
			
			// Atribui
			$this->marcador = $marcador;
			
		}
		
		public function setTordenacao ($tOrdenacao){
			
			// Atribui
			$this->tOrdenacao = $tOrdenacao;
			
		}
		
		public function setTamanhoTablePrincipal ($tamanhoTablePrincipalr){
			
			// Atribui
			$this->tamanhoTablePrincipal = $tamanhoTablePrincipalr;
			
		}
		
		public function setPpaginacao ($pPaginacao){
			
			// Atribui
			$this->pPaginacao = $pPaginacao;
			
		}
		
		public function setPacoes ($pAcoes){
			
			// Atribui
			$this->pacoes = $pAcoes;
			
		}
		
		public function setPcampoLinkEdit ($pcampoLinkEdit){
			
			// Atribui
			$this->pcampoLinkEdit = $pcampoLinkEdit;
			
		}
		
		public function setOnChange ($onchange){
			
			// Atribui
			$this->onchange = $onchange;
			
		}
	
		public function setAcoes ($acoes){
			
			// Atribui
			$this->acoes = $acoes;
			
		}
		
		public function setFiltro ($filtro){
			
			// Atribui
			$this->filtro = $filtro;
			
		}
		
		public function setLinksAcoes ($linksAcoes){
			
			// Atribui
			$this->linksAcoes = $linksAcoes;
			
		}
		
		public function setTextFiltro ($textFiltro){
			
			// Atribui
			$this->textFiltro = $textFiltro;
			
		}
		
		public function setCampoFiltro ($campoFiltro){
			
			// Atribui
			$this->campoFiltro = $campoFiltro;
			
		}
		
		public function setCamposTopico ($camposTopico){
			
			// Atribui
			$this->camposTopico = $camposTopico;
			
		}
		
		public function setCamposTopicoTamanho ($camposTopicoTamanho){
			
			// Atribui
			$this->camposTopicoTamanho = $camposTopicoTamanho;
			
		}
		
		public function setCamposDados ($camposDados){
			
			// Atribui
			$this->camposDados = $camposDados;
			
		}
		
		public function setCampoLinkEdit ($campoLinkEdit){
			
			// Atribui
			$this->campoLinkEdit = $campoLinkEdit;
			
		}
		
		public function setPosicaoCamposDados ($posicaoCamposDados){
			
			// Atribui
			$this->posicaoCamposDados = $posicaoCamposDados;
			
		}
		
		public function setModificarDados ($modificarDados){
			
			// Atribui
			$this->modificarDados = $modificarDados;
			
		}
		
		public function setQuery ($query){
			
			// Atribui
			$this->query = strtolower($query);
			
		}
		
		public function setUrlPaginacao ($urlPaginacao){
			
			// Atribui
			$this->urlPaginacao = $urlPaginacao;
			
		}
		
		public function setTotalPagina ($totalPagina){
			
			// Atribui
			$this->totalPagina = $totalPagina;
			
		}
		
		public function setUtilitarios ($utilitarios){
			
			// Atribui
			$this->utilitarios = $utilitarios;
			
		}
		
		public function setPaginacao ($paginacao){
			
			// Atribui
			$this->paginacao = $paginacao;
			
		}
		
		public function setDinheiro ($dinheiro){
			
			// Atribui
			$this->dinheiro = $dinheiro;
			
		}
		
		public function setData ($data){
			
			// Atribui
			$this->data = $data;
			
		}
	
	/* Gets */
		
		public function getHtml (){
			
			// Retorna
			return $this->html;
			
		}
		
		public function getOnChange (){
			
			// Retorna
			return $this->onchange;
			
		}
	
		public function getAcoes (){
			
			// Retorna
			return $this->acoes;
			
		}
		
		public function getLinksAcoes (){
			
			// Retorna
			return $this->linksAcoes;
			
		}
		
		public function getTextFiltro (){
			
			// Retorna
			return $this->textFiltro;
			
		}
		
		public function getCampoFiltro (){
			
			// Retorna
			return $this->campoFiltro;
			
		}
		
		public function getCamposTopico (){
			
			// Retorna
			return $this->camposTopico;
			
		}
		
		public function getCamposTopicoTamanho (){
			
			// Retorna
			return $this->camposTopicoTamanho;
			
		}
		
		public function getCamposDados (){
			
			// Retorna
			return $this->camposDados;
			
		}
		
		public function getPosicaoCamposDados (){
			
			// Retorna
			return $this->posicaoCamposDados;
			
		}
		
		public function getModificarDados (){
			
			// Retorna
			return $this->modificarDados;
			
		}
		
		public function getQuery (){
			
			// Retorna
			return $this->query;
			
		}
		
		public function getUrlPaginacao (){
			
			// Retorna
			return $this->urlPaginacao;
			
		}
		
		public function getTotalPagina (){
			
			// Retorna
			return $this->totalPagina;
			
		}
		
		public function getUtilitarios (){
			
			// Retorna
			return $this->utilitarios;
			
		}
		
		public function getPaginacao (){
			
			// Retorna
			return $this->paginacao;
			
		}
	
}

// Instancia o Objeto
$_ClassConsulta = new Consulta();

// Seta Utilitarios
$_ClassConsulta->setUtilitarios($_ClassUtilitarios);

// Seta Paginação
$_ClassConsulta->setPaginacao($_ClassPaginacao);

// Seta Dinheiro
$_ClassConsulta->setDinheiro($_ClassDinheiro);

// Seta Data
$_ClassConsulta->setData($_ClassData);
?>
