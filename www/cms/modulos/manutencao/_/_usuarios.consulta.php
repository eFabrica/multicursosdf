<?php
// Verifica Ação
if($_REQUEST["act"] == "suspender"){
	
	// Lê Registros
	for($y = 0; $y < count($_REQUEST["registros"]); $y++){
		
		// Deleta Registros
		$_ClassMysql->query("UPDATE `usuarios` SET suspenso = 'S', ultimosuspendeu = '" . $_dadosLogado->id . "', datahoras = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
		
	}
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Seta Mensagem de Sucesso
	$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " usuário(s) foi(ram) suspenso(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
	
	?>
	<tr>
		<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}elseif($_REQUEST["act"] == "deletar"){
	
	// Lê Registros
	for($y = 0; $y < count($_REQUEST["registros"]); $y++){
		
		// Deleta Registros
		$_ClassMysql->query("UPDATE `usuarios` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
		
	}
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Seta Mensagem de Sucesso
	$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " usuário(s) foi(ram) deletado(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
	
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
$_ClassConsulta->setAcoes(array("Suspender", "Deletar"));

// Seta OnChange
$_ClassConsulta->setOnChange("if(confirm('Deseja mesmo deletar este(s) registro(s)?')){document.consulta.action = '' + this.options[this.selectedIndex].value; document.consulta.submit();}");

// Seta Links das Ações
$_ClassConsulta->setLinksAcoes(array("?sessao=usuarios&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "&act=suspender",
									 "?sessao=usuarios&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "&act=deletar"));
									 
// Seta Texto do Filtro
$_ClassConsulta->setTextFiltro("Nome");

// Seta Campo do Filtro
$_ClassConsulta->setCampoFiltro("nome");

// Seta Campos do Topico
$_ClassConsulta->setCamposTopico(array("Nome", "Nível", "CPF/Login", "Tel&nbsp;Alternativo"));

// Seta o Tamanho dos Campos
$_ClassConsulta->setCamposTopicoTamanho(array("40%", "10%", "25%", "25%"));

// Seta Dados dos Campos
$_ClassConsulta->setCamposDados(array("nome", "nivel", "cpf", "telefonealternativo"));

// Seta Campo Link Edição
$_ClassConsulta->setCampoLinkEdit("nome");

// Seta Posição dos Dados dos Campos
$_ClassConsulta->setPosicaoCamposDados(array("left", "center", "center", "center"));

# Constrói Modificações no Dados
	
	// Modificações
	$modificacoes["modificacoes"] = array("cpf" => array("tipo" => "12",
										  				 "campos" => "cpf"));

// Seta Modificações no Dados
$_ClassConsulta->setModificarDados($modificacoes);		

// Seta Query
$_ClassConsulta->setQuery("SELECT * FROM `usuarios` WHERE nivel != '94' " . (($_dadosLogado->nivel == "99")?" AND nivel != '100'":"") . " AND unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");

// Seta Url da Paginação
$_ClassConsulta->setUrlPaginacao("?sessao=" . $_REQUEST["sessao"]);

// Seta Total Pagina
$_ClassConsulta->setTotalPagina(10);

// GeraConsulta
$_ClassConsulta->geraConsulta();	

// Exibe a Pesquisa
print($_ClassConsulta->getHtml());
?>