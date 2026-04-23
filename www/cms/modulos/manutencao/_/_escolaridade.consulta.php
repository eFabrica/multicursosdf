<?php
// Verifica Ação
if($_REQUEST["act"] == "deletar"){
	
	// Lê Registros
	for($y = 0; $y < count($_REQUEST["registros"]); $y++){
		
		// Deleta Registros
		$_ClassMysql->query("UPDATE `escolaridade` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
		
	}
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Seta Mensagem de Sucesso
	$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " escolaridade(s) foi(ram) deletada(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
	
	?>
	<tr>
		<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}

// Importa Consulta
require_once("lib/Consulta.class.php");

// Seta Ações
$_ClassConsulta->setAcoes(array("Deletar"));

// Seta OnChange
$_ClassConsulta->setOnChange("if(confirm('Deseja mesmo deletar este(s) registro(s)?')){document.consulta.action = '' + this.options[this.selectedIndex].value; document.consulta.submit();}");

// Seta Links das Ações
$_ClassConsulta->setLinksAcoes(array("?sessao=escolaridade&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "&act=deletar"));

// Seta Texto do Filtro
$_ClassConsulta->setTextFiltro("Escolaridade");

// Seta Campo do Filtro
$_ClassConsulta->setCampoFiltro("escolaridade");

// Seta Campos do Topico
$_ClassConsulta->setCamposTopico(array("Escolaridade"));

// Seta o Tamanho dos Campos
$_ClassConsulta->setCamposTopicoTamanho(array("100%"));

// Seta Dados dos Campos
$_ClassConsulta->setCamposDados(array("escolaridade"));

// Seta Campo Link Edição
$_ClassConsulta->setCampoLinkEdit("escolaridade");

// Seta Posição dos Dados dos Campos
$_ClassConsulta->setPosicaoCamposDados(array("left"));

// Seta Query
$_ClassConsulta->setQuery("SELECT * FROM `escolaridade` WHERE deletado = 'N'");

// Seta Url da Paginação
$_ClassConsulta->setUrlPaginacao("?sessao=" . $_REQUEST["sessao"]);

// Seta Total Pagina
$_ClassConsulta->setTotalPagina(10);

// GeraConsulta
$_ClassConsulta->geraConsulta();	

// Exibe a Pesquisa
print($_ClassConsulta->getHtml());
?>