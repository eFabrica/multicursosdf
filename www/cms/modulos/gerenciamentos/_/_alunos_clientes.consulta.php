<?php
// Verifica Ação
if($_REQUEST["act"] == "deletar"){
	
	// Lê Registros
	for($y = 0; $y < count($_REQUEST["registros"]); $y++){
		
		// Deleta Registros
		$_ClassMysql->query("UPDATE `alunos` SET empresa = '', ultimoeditou = '" . $_dadosLogado->id . "', datahorae = now() WHERE id = '" . $_REQUEST["registros"][$y] . "' AND empresa = '" . $_dadosLogado->empresa . "'");
		
	}
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Seta Mensagem de Sucesso
	$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " aluno(s) foi(ram) deletado(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
	
	?>
	<tr>
		<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}

// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Importa Consulta
require_once("lib/Consulta.class.php");

// Seta Ações
$_ClassConsulta->setAcoes(array("Deletar"));

// Seta OnChange
$_ClassConsulta->setOnChange("if(confirm('Deseja mesmo deletar este(s) registro(s)?')){document.consulta.action = '' + this.options[this.selectedIndex].value; document.consulta.submit();}");

// Seta Links das Ações
$_ClassConsulta->setLinksAcoes(array("?sessao=alunos_clientes&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "&act=deletar"));

// Seta Texto do Filtro
$_ClassConsulta->setTextFiltro("Nome");

// Seta Campo do Filtro
$_ClassConsulta->setCampoFiltro("nome");

// Seta Campos do Topico
$_ClassConsulta->setCamposTopico(array("Nome", "Data&nbsp;Nasc.", "R.G",  "CPF"));

// Seta o Tamanho dos Campos
$_ClassConsulta->setCamposTopicoTamanho(array("45%", "15%", "20%", "20%"));

// Seta Dados dos Campos
$_ClassConsulta->setCamposDados(array("nome", "datanascimento", "rg", "cpf"));

// Seta Campo Link Edição
$_ClassConsulta->setCampoLinkEdit("nome");

// Seta Posição dos Dados dos Campos
$_ClassConsulta->setPosicaoCamposDados(array("left", "center", "center", "center"));

# Constrói Modificações no Dados
	
	// Modificações
	$modificacoes["modificacoes"] = array("datanascimento" => array("tipo" => "4",
																	"tipot" => "2"),
																	
										  "cpf" => array("tipo" => "12",
										  				 "campos" => "cpf"));

// Seta Modificações no Dados
$_ClassConsulta->setModificarDados($modificacoes);		

// Seta Query
$_ClassConsulta->setQuery("SELECT * FROM `alunos` WHERE empresa = '" . $_dadosLogado->empresa . "' AND deletado = 'N'");

// Seta Url da Paginação
$_ClassConsulta->setUrlPaginacao("?sessao=" . $_REQUEST["sessao"]);

// Seta Total Pagina
$_ClassConsulta->setTotalPagina(10);

// GeraConsulta
$_ClassConsulta->geraConsulta();	

// Exibe a Pesquisa
print($_ClassConsulta->getHtml());
?>