<?php
// Limpa Sessão
unset($_SESSION["matricula"]["idAluno"]);
unset($_SESSION["matricula"]["documentos"]);
unset($_SESSION["matricula"]["numero"]);
unset($_SESSION["matricula"]["tipo"]);
unset($_SESSION["matricula"]["empresa"]);
unset($_SESSION["matricula"]["idTurma"]);

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Salva na sessão aluno escolhido
	$_SESSION["matricula"]["idAluno"] = $_REQUEST["registros"];
	
	// Redireciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=novo&etapa=2"));
	
}

// Verifica Sucesso
if(!$sucesso){
	?>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="?sessao=matriculas&ref=novo&etapa=1&submenu=buscar" method="POST" name="formMatricula_Busca">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td align="right" width="10%"><b>Palavra-Chave:</b></td>
						<td width='90%' align='left'><input type="text" name="texto" size="50"></td>
					</tr>
					<tr>
						<td align='left'></td>
						<td align='left'><?php print($_ClassUtilitarios->criaMenu("Buscar", "#", "document.formMatricula_Busca.submit();", "esq", "007"));?></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
	// Verifica Ação
	if($_REQUEST["submenu"] == "buscar"){
		?>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align='left'>
				<form action="" method="POST" name="formMatricula">
					<input type="hidden" name="act" value="salvar">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
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
						$_ClassConsulta->setCamposTopico(array("Nome", "Data&nbsp;Nasc.", "R.G",  "Org. Exp", "CPF", "Telefone"));
						
						// Seta o Tamanho dos Campos
						$_ClassConsulta->setCamposTopicoTamanho(array("35%", "10%", "10%", "10%", "15%", "20%"));
						
						// Seta Dados dos Campos
						$_ClassConsulta->setCamposDados(array("nome", "datanascimento", "rg", "orgexp", "cpf", "telefone"));
						
						// Seta Campo Link Edição
						$_ClassConsulta->setCampoLinkEdit("nome");
						
						// Seta Posição dos Dados dos Campos
						$_ClassConsulta->setPosicaoCamposDados(array("left", "center", "center", "center", "center", "center"));
						
						# Constrói Modificações no Dados
							
							// Modificações
							$modificacoes["modificacoes"] = array("datanascimento" => array("tipo" => "4",
																							"tipot" => "2"),
																							
																  "cpf" => array("tipo" => "12",
																  				 "campos" => "cpf"));
						
						// Seta Modificações no Dados
						$_ClassConsulta->setModificarDados($modificacoes);		
						
						// Seta Query
						$_ClassConsulta->setQuery("SELECT * FROM `alunos` WHERE rg LIKE '%" . $_REQUEST["texto"] . "%' AND deletado = 'N' OR
																				cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_REQUEST["texto"]) . "%' AND deletado = 'N' OR
																				nome LIKE '%" . $_REQUEST["texto"] . "%' AND deletado = 'N'");
						
						// Seta Url da Paginação
						$_ClassConsulta->setUrlPaginacao("?sessao=" . $_REQUEST["sessao"] . 
														 "&ref=" . $_REQUEST["ref"] . 
												 		 "&submenu=" . $_REQUEST["submenu"] . 
												 		 "&texto=" . $_REQUEST["texto"]);
						
						// Seta Total Pagina
						$_ClassConsulta->setTotalPagina(5);
				
						// GeraConsulta
						$_ClassConsulta->geraConsulta();	
						
						// Exibe a Pesquisa
						print($_ClassConsulta->getHtml());
						?>
					</table>
				</form>
			</td>
		</tr>
		<?php
	}
	
}
?>