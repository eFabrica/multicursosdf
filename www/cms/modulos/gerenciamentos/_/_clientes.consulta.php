<?php
// Verifica Ação
if($_REQUEST["act"] == "deletar"){
	
	// Lê Registros
	for($y = 0; $y < count($_REQUEST["registros"]); $y++){
		
		// Deleta usuários dessa empresa
		$_ClassMysql->query("UPDATE `usuarios` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE unidade = '" . $_dadosUnidade->id . "' AND empresa = '" . $_REQUEST["registros"][$y] . "'");
		
		// Deleta Registros
		$_ClassMysql->query("UPDATE `clientes` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
		
	}
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Seta Mensagem de Sucesso
	$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " cliente(s) foi(ram) deletado(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
	
	?>
	<tr>
		<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
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
$_ClassConsulta->setLinksAcoes(array("?sessao=clientes&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "&act=deletar"));

// Seta Texto do Filtro
$_ClassConsulta->setTextFiltro("Razão&nbsp;Social");

// Seta Campo do Filtro
$_ClassConsulta->setCampoFiltro("razaosocial");

// Seta Campos do Topico
$_ClassConsulta->setCamposTopico(array("Razão Social", "CNPJ", "Cidade", "Estado", "Telefone F."));

// Seta o Tamanho dos Campos
$_ClassConsulta->setCamposTopicoTamanho(array("25%", "25%", "25%", "5%", "20%"));

// Seta Dados dos Campos
$_ClassConsulta->setCamposDados(array("razaosocial", "cnpj", "cidade", "estado", "telefonefixo"));

// Seta Campo Link Edição
$_ClassConsulta->setCampoLinkEdit("razaosocial");

// Seta Posição dos Dados dos Campos
$_ClassConsulta->setPosicaoCamposDados(array("center", "center", "center", "center", "center"));

# Constrói Modificações no Dados

	// Campos
	$modificacoes["campos"] = array("cidade");
	
	// Modificações
	$modificacoes["modificacoes"] = array("cidade" => array("tipo" => "1",
															"campos" => "cidade",
															"tabela" => "cidades",
															"condicao" => "",
															"exibirCampo" => "cidade"),
															
										  "cnpj" => array("tipo" => "14",
														  "campos" => "cnpj"));
	

// Seta Modificações no Dados
$_ClassConsulta->setModificarDados($modificacoes);

// Seta Query
$_ClassConsulta->setQuery("SELECT * FROM `clientes` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");

// Seta Url da Paginação
$_ClassConsulta->setUrlPaginacao("?sessao=" . $_REQUEST["sessao"]);

// Seta Total Pagina
$_ClassConsulta->setTotalPagina(10);

// GeraConsulta
$_ClassConsulta->geraConsulta();	

// Exibe a Pesquisa
print($_ClassConsulta->getHtml());
?>