<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
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
			<form action="?sessao=turmasconcluidas&ref=buscar" method="POST" name="formTurma">
				<input type="hidden" name="a" value="S">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td width="15%" align="right"><strong>Data Início:</strong></td>
						<td align='left'><input type="text" name="datainicio" size="12" maxlength="10" onKeyUp="maskData(this, this)" disabled></td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitarDataInicio" value="sim" onClick="disen(document.formTurma.datainicio);" ></td>
					</tr>
					<tr>
						<td align="right"><strong>Curso:</strong></td>
						<td align='left'>
							<select name="curso" disabled>
								<?php
								// Busca Cursos
								$buscaCursos = $_ClassMysql->query("SELECT * FROM `cursos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N' ORDER BY nome");
								
								// Traz Cursos
								while($trazCursos = mysql_fetch_object($buscaCursos)){
									
									?>
									<option value="<?php print($trazCursos->id);?>"><?php print($trazCursos->sigla . " - " . $trazCursos->nome);?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					 	<td align="center"><input type="checkbox" name="habilitarCurso" value="sim" onClick="disen(document.formTurma.curso);" ></td>
					</tr>
					<tr>
						<td align="right"><b>Filtrar Turmas:</b></td>
						<td align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formTurma.turma);" disabled></td>
						<td align='left'></td>
					</tr>
					<tr>
						<td align="right"><strong>Turma:</strong></td>
						<td align='left'>
							<select name="turma" disabled>
								<?php
								// Busca Turmas
								$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE concluido = 'S' AND unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
								
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
					 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formTurma.turma);disen(document.formTurma.procura);" ></td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
						<td align="right"><strong>Todas</strong></td>
						<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formTurma.habilitarDataInicio);checkedDisable(document.formTurma.habilitarDataInicio);
																									 disen(document.formTurma.habilitarCurso);checkedDisable(document.formTurma.habilitarCurso);
																									 isen(document.formTurma.habilitarTurma);checkedDisable(document.formTurma.habilitarTurma);
																									 disable(document.formTurma.curso);
																									 disable(document.formTurma.datainicio);
																									 disable(document.formTurma.procura);
																									 disable(document.formTurma.turma);
																									 this.disabled = false;" ></td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
						<td align="left"><input type="submit" value="Consultar"></td>
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
	
	/* Gravando dados da pesquisa na sessão */
	if($_REQUEST["a"] == "S"){
	
		// Consulta
		$_SESSION["consultaTurmasConcluidas"] = $_POST;
		
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
				// Verifica se a busca é por todas as TUrmas
				if($_SESSION["consultaTurmasConcluidas"]["todas"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Todas as Turmas</strong></ol></td>
					</tr>
					<?php
				}
				 
				// Verifica se foi habilitado o campo de Data de Início
				if($_SESSION["consultaTurmasConcluidas"]["habilitarDataInicio"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Data Início:</strong>&nbsp;<?php echo $_SESSION["consultaTurmasConcluidas"]["datainicio"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de curso
				if($_SESSION["consultaTurmasConcluidas"]["habilitarCurso"] == "sim"){
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $_SESSION["consultaTurmasConcluidas"]["curso"] . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Curso:</strong>&nbsp;<?php print($dadosCurso->sigla . " - " . $dadosCurso->nome);?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de turma
				if($_SESSION["consultaTurmasConcluidas"]["habilitarTurma"] == "sim"){
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaTurmasConcluidas"]["turma"] . "'");
					
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
			
			// Deleta Grade
			$_ClassMysql->query("UPDATE `gradehoraria` SET deletado = 'S' WHERE turma = '" . $_REQUEST["registros"][$y] . "'");
			
			// Deleta Matrículas
			$_ClassMysql->query("UPDATE `matriculas` SET deletado = 'S' WHERE turma = '" . $_REQUEST["registros"][$y] . "'");
			
			// Deleta Registros
			$_ClassMysql->query("UPDATE `turmas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
			
		}
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);
		
		// Seta Mensagem de Sucesso
		$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " turma(s) foi(ram) deletada(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
		
		?>
		<tr>
			<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<?php
		
	}elseif($_REQUEST["act"] == "ativar"){
		
		// Lê Registros
		for($y = 0; $y < count($_REQUEST["registros"]); $y++){
			
			// Ativa Matrículas
			$_ClassMysql->query("UPDATE `matriculas` SET concluido = 'N' WHERE turma = '" . $_REQUEST["registros"][$y] . "'");
			
			// Deleta Registros
			$_ClassMysql->query("UPDATE `turmas` SET concluido = 'N' WHERE id = '" . $_REQUEST["registros"][$y] . "'");
			
		}
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);
		
		// Seta Mensagem de Sucesso
		$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " turma(s) foi(ram) ativada(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=ativar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
		
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
					<td width='85%' align='left'>
						<select onchange="if(document.formTurma.act.value == 'deletar'){if(confirm('Deseja mesmo deletar este(s) registro(s)?')){document.formTurma.act.value = '' + this.options[this.selectedIndex].value; document.formTurma.submit();}}else{document.formTurma.act.value = '' + this.options[this.selectedIndex].value; document.formTurma.submit();}">
							<option value=""></option>
							<option value="deletar">Deletar</option>
							<option value="ativar">Ativar</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<form action="" method="POST" name="formTurma">
							<input type="hidden" name="act" value="">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%">#</th>
										<th width="1%" align="center"><input type="checkbox" onclick="select_all('formTurma', 'registros[]')"></th>
										<th width="25%">Sigla/Turma</th>
										<th width="15%">Turno</th>
										<th width="15%">Vagas</th>
										<th width="15%">Vagas&nbsp;Restantes</th>
										<th width="15%">Data&nbsp;Início</th>
										<th width="15%">Data&nbsp;Término</th>
										<th width="5%">Dados</th>
									</tr>
								</thead>
								<tbody>
									<?php
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// SQL
										$sql .= "SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND concluido = 'S' AND deletado = 'N' AND ";
										
										// Verifica Pesquisa
										if($_SESSION["consultaTurmasConcluidas"]["todas"] != "sim"){
											
											$sql .= (($_SESSION["consultaTurmasConcluidas"]["habilitarTurma"] == "sim")?" id = '" . $_SESSION["consultaTurmasConcluidas"]["turma"] . "' AND ":"");
											$sql .= (($_SESSION["consultaTurmasConcluidas"]["habilitarDataInicio"] == "sim")?"datainicio = '" . $_ClassData->transformaData($_SESSION["consultaTurmasConcluidas"]["datainicio"]) . "' AND ":"");
											$sql .= (($_SESSION["consultaTurmasConcluidas"]["habilitarCurso"] == "sim")?" curso = '" . $_SESSION["consultaTurmasConcluidas"]["curso"] . "' AND ":"");
											
											//$sql .= (($_POST["habilitar"] == "sim")?"":"");
										}
										
										// Limpa Query
										$sql .= "{aqui}";
										$sql = str_replace("AND {aqui}", "", $sql);
										$sql = str_replace("{aqui}", "", $sql);
										
										// SQL
										$sql .= " ORDER BY id DESC";
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=turmasconcluidas&ref=buscar");
									$_ClassPaginacao->setRegistrosPorPagina("10");
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
										
										// Contador
										$cont = 0;
										
										// Traz resultados
										while($trazResultados = mysql_fetch_object($_ClassPaginacao->getBusca())){										
											
											// Dados do Curso
											$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazResultados->curso . "'");
						
											// Dados do Turno
											$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $trazResultados->turno . "'");
											?>
											<tr class=row0>
												<td align='left'><?php print($trazResultados->id); ?></td>
												<td align="center"><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"></td>
												<td align="center"><?php print($dadosCurso->sigla . $trazResultados->numero);?></td>
												<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
												<td align="center"><?php print($trazResultados->vagas);?></td>
												<td align="center"><?php print($trazResultados->vagas-$trazResultados->vagasocupadas);?></td>
												<td align="center"><?php print($_ClassData->transformaData($trazResultados->datainicio, 2));?></td>
												<td align="center"><?php print($_ClassData->transformaData($trazResultados->datatermino, 2));?></td>
												<td align="center"><a href="#" onclick="popup('turmas<?php print($trazResultados->id); ?>', '<?php print($pathInc);?>modulos/manutencao/_/_turmasconcluidas.listagem.php?idTurma=<?php print($trazResultados->id);?>', 730, 400, 'yes');"><img src="<?php print($pathInc);?>imagens/icones/sh.png" border="0"></td>
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