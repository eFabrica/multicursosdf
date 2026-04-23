<?php
// Verifica se tem id
if($_REQUEST["registros"] > 0){
	
	// Cadastra na sessão
	$_SESSION["idUnidade"] = $_REQUEST["registros"];
	
	// Redireciona
	print($_ClassUtilitarios->redirecionarJS($pathInc . "?sessao=inicial"));
	
}else{
	
	// Limpa sessão
	unset($_SESSION["idUnidade"]);
	
}
?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00034.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Escolher Unidade para Administrar <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<td align="center"><div class="caixaIcone"><a href="#" onclick="document.escolherUnidade.submit();"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Selecionar</a></div></td>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td align='left'><br></td>
	</tr>
	<tr>
		<td align='left'>
			<form action="" method="POST" name="escolherUnidade">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<?php
				// Importa Consulta
				require_once($pathInc . "lib/Consulta.class.php");
				
				// Tira Ações
				$_ClassConsulta->setPacoes(false);
				
				// Tira Filtro
				$_ClassConsulta->setFiltro(false);
				
				// Tira Link do Campo
				$_ClassConsulta->setPcampoLinkEdit(false);
				
				// Muda marcador
				$_ClassConsulta->setMarcador("radio");
				
				// Tira Ordenação dos Tópicos
				$_ClassConsulta->setTordenacao(false);
				
				// Seta Campos do Topico
				$_ClassConsulta->setCamposTopico(array("Acesso", "Razão Social", "CNPJ", "Cidade", "Estado", "Telefone F.", "Responsável"));
				
				// Seta o Tamanho dos Campos
				$_ClassConsulta->setCamposTopicoTamanho(array("5%", "25%", "15%", "20%", "5%", "15%", "15%"));
				
				// Seta Dados dos Campos
				$_ClassConsulta->setCamposDados(array("acesso", "razaosocial", "cnpj", "cidade", "estado", "telefonefixo", "responsavel"));
				
				// Seta Campo Link Edição
				$_ClassConsulta->setCampoLinkEdit("razaosocial");
				
				// Seta Posição dos Dados dos Campos
				$_ClassConsulta->setPosicaoCamposDados(array("center", "left", "center", "center", "center", "center", "center"));
				
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
				$_ClassConsulta->setQuery("SELECT * FROM `unidades` WHERE deletado = 'N' AND acesso = 'L'");
				
				// Seta Url da Paginação
				$_ClassConsulta->setUrlPaginacao("?sessao=" . $_REQUEST["sessao"]);
				
				// Seta Total Pagina
				$_ClassConsulta->setTotalPagina(10);
				
				// GeraConsulta
				$_ClassConsulta->geraConsulta();	
				
				// Exibe a Pesquisa
				print($_ClassConsulta->getHtml());
				?>
				</table>
			</form>
		</td>
	</tr>
</table>