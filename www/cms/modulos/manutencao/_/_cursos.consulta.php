<?php
// Verifica Ação
if($_REQUEST["act"] == "deletar"){
	
	// Lê Registros
	for($y = 0; $y < count($_REQUEST["registros"]); $y++){
		
		// Deleta Registros
		$_ClassMysql->query("UPDATE `cursos` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
		
	}
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Seta Mensagem de Sucesso
	$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " curso(s) foi(ram) deletado(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
	
	?>
	<tr>
		<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}

// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Importa Consulta
require_once("lib/Consulta.class.php");

// Seta Ações
$_ClassConsulta->setAcoes(array("Deletar"));

// Seta OnChange
$_ClassConsulta->setOnChange("if(confirm('Deseja mesmo deletar este(s) registro(s)?')){document.consulta.action = '' + this.options[this.selectedIndex].value; document.consulta.submit();}");

// Seta Links das Ações
$_ClassConsulta->setLinksAcoes(array("?sessao=cursos&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "&act=deletar"));

// Seta Texto do Filtro
$_ClassConsulta->setTextFiltro("Sigla");

// Seta Campo do Filtro
$_ClassConsulta->setCampoFiltro("sigla");

// Seta Campos do Topico
$_ClassConsulta->setCamposTopico(array("Nome", "Sigla", "Valor"));

// Seta o Tamanho dos Campos
$_ClassConsulta->setCamposTopicoTamanho(array("50%", "15%", "35%"));

// Seta Dados dos Campos
$_ClassConsulta->setCamposDados(array("nome", "sigla", "valor"));

// Seta Campo Link Edição
$_ClassConsulta->setCampoLinkEdit("nome");

// Seta Posição dos Dados dos Campos
$_ClassConsulta->setPosicaoCamposDados(array("left", "center", "right"));

# Constrói Modificações no Dados
	
	// Modificações
	$modificacoes["modificacoes"] = array("valor" => array("tipo" => "3"));

// Seta Modificações no Dados
$_ClassConsulta->setModificarDados($modificacoes);

// Seta Query
$_ClassConsulta->setQuery("SELECT * FROM `cursos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");

// Seta Url da Paginação
$_ClassConsulta->setUrlPaginacao("?sessao=" . $_REQUEST["sessao"]);

// Seta Total Pagina
$_ClassConsulta->setTotalPagina(10);

// GeraConsulta
$_ClassConsulta->geraConsulta();	

// Exibe a Pesquisa
print($_ClassConsulta->getHtml());
?>