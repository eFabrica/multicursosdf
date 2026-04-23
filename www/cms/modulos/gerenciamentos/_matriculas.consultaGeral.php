<?php require_once("php7_mysql_shim.php");
// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica URL Pesquisa
if($_REQUEST["idRegistro"] > 0){
	
	// Cadastra tipo do Registro na sessão
	$_SESSION["consultaMatricula"]["tipoRegistro"] = "geral";
	
	// Cadastra id Registro na sessão
	$_SESSION["consultaMatricula"]["idRegistro"] = $_REQUEST["idRegistro"];
	
	// Cadastra URL da pesquisa na sessão
	$_SESSION["consultaMatricula"]["urlPesquisa"] = "&subsessao=consultageral&pg=" . $_REQUEST["pg"] . "&ref=buscar";
	
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
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00018.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Matrículas [Relatório Geral] <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == "buscar"){
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&subsessao=consultageral&subsessao=consultageral"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
								<?php
							}
							?>
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
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	// Class de data
	require_once($pathInc . "lib/Data.class.php");
	
	// Class de Dinheiro
	require_once($pathInc . "lib/Dinheiro.class.php");
	
	// Verifica referência
	if($_REQUEST["ref"] == ""){
		?>
		<tr>
			<td align='left'><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<form action="?sessao=matriculas&subsessao=consultageral&ref=buscar" method="POST" name="formMatricula">
					<input type="hidden" name="a" value="S">
					<table border="0" cellpadding="2" cellspacing="2" align="center">
						<tr>
							<td width="15%" align="right"><strong>Palavra-Chave:</strong></td>
							<td align='left'><input type="text" name="palavraChave" size="50" disabled></td>
						 	<td width="5%" align="center"><input type="checkbox" name="habilitarPalavraChave" value="sim" onClick="disen(document.formMatricula.palavraChave);" ></td>
						</tr>
						<tr>
							<td align="right"><b>Filtrar Turmas:</b></td>
							<td align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formMatricula.turma);" disabled></td>
							<td align='left'></td>
						</tr>
						<tr>
							<td align="right"><strong>Turma:</strong></td>
							<td align='left'>
								<select name="turma" disabled>
									<?php
									// Busca Turmas
									$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N' ORDER BY concluido");
									
									// Traz Turmas
									while($trazTurmas = mysql_fetch_object($buscaTurmas)){
										
										// Dados do Curso
										$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazTurmas->curso . "'");
										?>
										<option value="<?php print($trazTurmas->id);?>"><?php print($dadosCurso->sigla . $trazTurmas->numero . " (" . $_ClassData->transformaData($trazTurmas->datainicio, 2) . ")");?></option>
										<?php
										
									}
									?>
								</select>
							</td>
						 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formMatricula.turma);disen(document.formMatricula.procura);" ></td>
						</tr>
						<tr>
							<td align='left'>&nbsp;</td>
							<td align="right"><strong>Todas</strong></td>
							<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formMatricula.habilitarPalavraChave);checkedDisable(document.formMatricula.habilitarPalavraChave);
																										 disen(document.formMatricula.habilitarTurma);checkedDisable(document.formMatricula.habilitarTurma);
																										 disable(document.formMatricula.palavraChave);
																										 disable(document.formMatricula.turma);
																										 disen(document.formMatricula.procura);
																										 this.disabled = false;" ></td>
						</tr>
						<tr>
							<td align='left'>&nbsp;</td>
							<td align='left'><input type="submit" value="Consultar"></td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
		<tr>
			<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
	}elseif($_REQUEST["ref"] == "buscar"){
		
		/* Verifica  Filtro */
		if($_REQUEST["filtro"] != ""){
			
			// Todas
			$_SESSION["consultaMatriculasGeral"]["todas"] = "";
			
			// Palavra Chave
			$_SESSION["consultaMatriculasGeral"]["habilitarPalavraChave"] = "sim";
			
			// Atribui Filtro
			$_SESSION["consultaMatriculasGeral"]["palavraChave"] = $_REQUEST["filtro"];
			
		}
		
		/* Gravando dados da pesquisa na sessão */
		if($_REQUEST["a"] == "S"){
		
			// Consulta
			$_SESSION["consultaMatriculasGeral"] = $_POST;
			
		}
		
		?>
		<tr>
			<td align='left'><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table width="99%" border="0" cellpadding="2" cellspacing="2">
					<tr>
						<td class="menu_topico">Buscando por: </td>
					</tr>
					<?php
					// Verifica se a busca é por todas as matriculas
					if($_SESSION["consultaMatriculasGeral"]["todas"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Todas as Matrículas</strong></ol></td>
						</tr>
						<?php
					}
					 
					// Verifica se foi habilitado o campo de palavra Chave
					if($_SESSION["consultaMatriculasGeral"]["habilitarPalavraChave"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Palavra-Chave:</strong>&nbsp;<?php echo $_SESSION["consultaMatriculasGeral"]["palavraChave"]?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de turma
					if($_SESSION["consultaMatriculasGeral"]["habilitarTurma"] == "sim"){
						
						// Dados da Turma
						$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaMatriculasGeral"]["turma"] . "'");
						
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></td>
						</tr>
						<?php
					}
					?>
				</table>
			</td>
		</tr>
		<tr>
			<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<?php
		// Verifica Ação
		if($_REQUEST["act"] == "deletar"){
			
			// Lê Registros
			for($y = 0; $y < count($_REQUEST["registros"]); $y++){
				
				// Dados da Matricula
				$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "turma", "id= '" . $_REQUEST["registros"][$y] . "'");
				
				// Desocupa Vaga na Turma
				$desocupaVaga = $_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = (vagasocupadas-1) WHERE id= '" . $dadosMatricula->turma . "'");
				
				// Deleta Parcelas
				$deletaParcelas = $_ClassMysql->query("UPDATE `parcelas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id ."', datahorad = NOW() WHERE matricula = '" . $_REQUEST["registros"][$y] . "'");
				
				// Deleta Documentos em Falta
				$deletaFaltaDocumentos = $_ClassMysql->query("UPDATE `faltadocumentos` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id ."', datahorad = NOW() WHERE matricula = '" . $_REQUEST["registros"][$y] . "'");
				
				// Deleta Registros
				$_ClassMysql->query("UPDATE `matriculas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
				
			}
			
			// Seta largura das mensagens
			$_ClassMensagens->setLargura(100);
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " matrícula(s) foi(ram) deletada(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
			
			?>
			<tr>
				<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
			</tr>
			<tr>
				<td style='height:5px';>&nbsp;</td>
			</tr>
			<?php
			
		}
		?>
		<tr>
			<td align='left'><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table width="99%" border="0" cellpadding="2" cellspacing="2">
					<tr>
						<td width="15%" align="right">Com Selecionados:</td>
						<td width="75%">
							<select onchange="if(confirm('Deseja mesmo deletar este(s) registro(s)?')){document.formMatricula.act.value = '' + this.options[this.selectedIndex].value; document.formMatricula.submit();}">
								<option value=""></option>
								<option value="deletar">Deletar</option>
							</select>
						</td>
						<td align="right">Palavra-Chave:</td>
						<td align='left'><form action="" method="POST" name='fastSearch'><input type="text" name="filtro" value="<?php print($_SESSION["consultaMatriculasGeral"]["palavraChave"]);?>"></form></td>
						<td align='left'><?php print($_ClassUtilitarios->criaMenu("Buscar", "#", "document.fastSearch.submit();", "esq", "007", $pathInc)); ?></td>
					</tr>
					<tr>
						<td colspan="5">
							<form action='' method="POST" name="formMatricula">
								<input type="hidden" name="act" value="">
								<table class="consulta" cellspacing="1" align="center">
									<thead>
										<tr>
											<th width="1%">#</th>
											<th width="1%" align="center"><input type="checkbox" onclick="select_all('formMatricula', 'registros[]')"></th>
											<th width="45%">Aluno</th>
											<th width="25%">Curso/Turma</th>
											<th width="15%">Turno</th>
											<th width="10%">Empresa</th>
											<th width="5%">Concluído</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										/* Construindo sql */
										$sql = "SELECT matriculas.id,
												   matriculas.turma,
												   matriculas.aluno,
												   matriculas.concluido,
												   matriculas.empresa,
												   matriculas.reprovado,
												   matriculas.numero FROM `matriculas`,`alunos`";
										$sql .= " WHERE ";
										if($_SESSION["consultaMatriculasGeral"]["todas"] != "sim"){
											
											$sql1 = (($_SESSION["consultaMatriculasGeral"]["habilitarTurma"] == "sim")?" alunos.id = matriculas.aluno AND alunos.deletado = 'N' AND matriculas.deletado = 'N' AND matriculas.turma = '" . $_SESSION["consultaMatriculasGeral"]["turma"] . "' AND":"");
											$sql2 = (($_SESSION["consultaMatriculasGeral"]["habilitarPalavraChave"] == "sim")? $sql1. " alunos.id = matriculas.aluno AND alunos.rg LIKE '%" . $_SESSION["consultaMatriculasGeral"]["palavraChave"] . "%' AND alunos.deletado = 'N' AND matriculas.deletado = 'N' OR
																											    " . $sql1 . " alunos.id = matriculas.aluno AND alunos.cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_SESSION["consultaMatriculasGeral"]["palavraChave"]) . "%' AND alunos.deletado = 'N' AND matriculas.deletado = 'N' OR
																											 	" . $sql1 . " alunos.id = matriculas.aluno AND alunos.nome LIKE '%" . $_SESSION["consultaMatriculasGeral"]["palavraChave"] . "%' AND alunos.deletado = 'N' AND matriculas.deletado = 'N'  
																											 	" . (($_SESSION["consultaMatriculasGeral"]["palavraChave"] > 0)?" OR " . $sql1 . " alunos.id = matriculas.aluno AND alunos.deletado = 'N' AND matriculas.numero = '" . $_SESSION["consultaMatriculasGeral"]["palavraChave"] . "' AND matriculas.deletado = 'N' AND ":" AND "):"");
											
											//$sql .= (($_POST["habilitar"] == "sim")?"":"");
										}else{
											
											$sql .= "alunos.id = matriculas.aluno AND alunos.deletado = 'N' AND matriculas.deletado = 'N' AND ";
											
										}
										$sql .= (($sql1 != "" && $sql2 != "")?$sql2:(($sql1 != "" && $sql2 == "")?$sql1:(($sql1 == "" && $sql2 != "")?$sql2:"")));
										$sql .= "{aqui}";
										$sql = str_replace("AND {aqui}", "", $sql);
										$sql = str_replace("AND{aqui}", "", $sql);
										$sql = str_replace("{aqui}", "", $sql);
										$sql .= " ORDER BY alunos.nome";
										//print($sql);
										/* Fim da construção */
										
										// Paginação
										require_once($pathInc . "lib/Paginacao.class.php");
										
										// Configurações da paginacao
										$_ClassPaginacao->setQuery($sql);
										$_ClassPaginacao->setUrl("?sessao=matriculas&subsessao=consultageral&ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&filtro=" . $_REQUEST["filtro"]);
										$_ClassPaginacao->setRegistrosPorPagina("45");
										$_ClassPaginacao->setPaginaAtual((($_REQUEST["pg"] == 0)?"1":$_REQUEST["pg"]));
										$_ClassPaginacao->paginando();
																
										// Verifica total achado
										if($_ClassPaginacao->getTotalAchadoQuery() == 0){
											?>
											<tr>
												<td align="center" colspan="9"><b>Nenhum resultado encontrado.</b></td>
											</tr>
											<?
										}else{
											
											// Traz resultados
											while($trazResultados = mysql_fetch_object($_ClassPaginacao->getBusca())){
											
												// Dados da Turma
												$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $trazResultados->turma . "'");
												
												// Dados do Curso
												$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
							
												// Dados do Turno
												$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
							
												// Dados da Matéria
												$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazResultados->materia . "'");
												
												// Dados do Aluno
												$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazResultados->aluno . "'");
												
												// Dados do Cliente
												$dadosCliente = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $trazResultados->empresa . "'");
												?>
												<tr class=row0>
													<td align='left'><?php print($trazResultados->numero); ?></td>
													<td align="center"><?php if($trazResultados->concluido == "N"){?><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"><?php }?></td>
													<td align="center"><a name="<?=$trazResultados->id?>"></a><a href="?sessao=matriculas<?php print((($trazResultados->empresa > 0)?"&subsessao=empresas":""));?>&y=n<?="&pg=" . $_REQUEST['pg'] . "&ref=edit&idRegistro=" . $trazResultados->id?>"><?php print($dadosAluno->nome);?></a></td>
													<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
													<td align="center"><?php print($dadosTurno->turno); ?></td>
													<td align="center"><?php print((($trazResultados->empresa > 0)?$dadosCliente->nomefantasia:"<img src='" . $pathInc . "imagens/diversos/N.png'>"));?></td>
													<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print((($trazResultados->reprovado == "S")?"X":$trazResultados->concluido));?>.png"></td>
												</tr>
												<?php
											}
											
										}
										?>
									</tbody>
									<tfoot>
										<td colspan="9"><?php echo $_ClassPaginacao->showPaginacao();?></td>
									</tfoot>
								</table>
							</form>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
	}
	?>
</table>