<?php require_once("php7_mysql_shim.php");
// Class de data
require_once($pathInc . "lib/Data.class.php");

// Class de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");
	
// Verifica se tem id do registro
if($_REQUEST["idRegistro"] > 0){
	
	// Adiciona na sessão
	$_SESSION["idGrade"] = $_REQUEST["idRegistro"];
	$_SESSION["urlPesquisa"] = "&ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"];
	
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
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00037.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Relatórios [Grade Horária] <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == "buscar"){							
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=rel_gradehoraria"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
								<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formGrade.submit();"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Emitir</a></div></td>
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
	// Verifica referência
	if($_REQUEST["ref"] == ""){
		?>
		<tr>
			<td align='left'><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<form action="?sessao=rel_gradehoraria&ref=buscar" method="POST" name="formGrade">
					<input type="hidden" name="a" value="S">
					<input type="hidden" name="campo" value="data">
					<input type="hidden" name="ordem" value="ASC">
					<table border="0" cellpadding="2" cellspacing="2" align="center">
						<tr>
							<td width="15%" align="right"><strong>Data:</strong></td>
							<td align='left'>
								De <input type="text" id="dataI" name="dataI" size="12" onKeyUp="maskData(this, document.formGrade.dataF)" disabled>
						  		até <input type="text" id="dataF" name="dataF" size="12" onKeyUp="maskData(this, document.formGrade.dataF)" disabled>
							</td>
						 	<td width="5%" align="center"><input type="checkbox" name="habilitarData" value="sim" onClick="disen(document.formGrade.dataI);disen(document.formGrade.dataF);"></td>
						</tr>
						<tr>
							<td align="right"><b>Filtrar Turmas:</b></td>
							<td align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formGrade.turma);" disabled></td>
							<td align='left'></td>
						</tr>
						<tr>
							<td align="right"><strong>Turma:</strong></td>
							<td align='left'>
								<select name="turma" disabled>
									<?php
									// Busca Turmas
									$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N' ORDER BY concluido ASC");
									
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
						 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formGrade.turma);disen(document.formGrade.procura);" ></td>
						</tr>
						<tr>
							<td align="right"><strong>Turno:</strong></td>
							<td align='left'>
								<select name="turno" disabled>
									<?php
									// Busca Turnos
									$buscaTurnos = $_ClassMysql->query("SELECT * FROM `turnos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N' ORDER BY turno ASC");
									
									// Traz Turnos
									while($trazTurnos = mysql_fetch_object($buscaTurnos)){
										
										?>
										<option value="<?php print($trazTurnos->id); ?>"><?php print($trazTurnos->turno . " (" . $trazTurnos->horarioi . " - " . $trazTurnos->horariof . ")"); ?></option>
										<?php
										
									}
									?>
								</select>
							</td>
						 	<td align="center"><input type="checkbox" name="habilitarTurno" value="sim" onClick="disen(document.formGrade.turno);" ></td>
						</tr>
						<tr>
							<td align="right"><strong>Matéria:</strong></td>
							<td align='left'>
								<select name="materia" disabled>
									<?php
									// Busca Matérias
									$buscaMaterias = $_ClassMysql->query("SELECT * FROM `materias` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
									
									// Traz Matérias
									while($trazMaterias = mysql_fetch_object($buscaMaterias)){
										?>
										<option value="<?php print($trazMaterias->id);?>"><?php print($trazMaterias->materia);?></option>
										<?php
										
									}
									?>
								</select>
							</td>
							<td align="center"><input type="checkbox" name="habilitarMateria" value="sim" onClick="disen(document.formGrade.materia)" ></td>
						</tr>
						<tr>
							<td align="right"><strong>Instrutor:</strong></td>
						  	<td align='left'>
						  		<select name="instrutor" disabled>
									<?php								
									// Busca Instrutores
									$buscaInstrutores = $_ClassMysql->query("SELECT * FROM `usuarios` WHERE unidade = '" . $_dadosUnidade->id . "' AND nivel = '95' AND suspenso = 'N' AND deletado = 'N'");
									
									// Traz Instrutores
									while($trazInstrutores = mysql_fetch_object($buscaInstrutores)){
										?>
										<option value="<?php print($trazInstrutores->id);?>"><?php print($trazInstrutores->nome);?> (<?php print($trazInstrutores->cpf);?>)</option>
										<?php
										
									}
									
									?>
								</select>
						  	</td>
						  	<td align="center"><input type="checkbox" name="habilitarInstrutor" value="sim" onClick="disen(document.formGrade.instrutor);" ></td>
						</tr>
						<tr>
							<td align="right"><strong>Sala:</strong></td>
						  	<td align='left'><input type="text" id="sala" name="sala" size="5" disabled></td>
						  	<td align="center"><input type="checkbox" name="habilitarSala" value="sim" onClick="disen(document.formGrade.sala);" ></td>
						</tr>
						<tr>
							<td align='left'>&nbsp;</td>
							<td align="right"><strong>Todas</strong></td>
							<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formGrade.habilitarData);checkedDisable(document.formGrade.habilitarData);
																										 disen(document.formGrade.habilitarTurma);checkedDisable(document.formGrade.habilitarTurma);
																										 disen(document.formGrade.habilitarTurno);checkedDisable(document.formGrade.habilitarTurno);
																										 disen(document.formGrade.habilitarMateria);checkedDisable(document.formGrade.habilitarMateria);
																										 disen(document.formGrade.habilitarInstrutor);checkedDisable(document.formGrade.habilitarInstrutor);
																										 disen(document.formGrade.habilitarSala);checkedDisable(document.formGrade.habilitarSala);
																										 disable(document.formGrade.dataI);
																										 disable(document.formGrade.dataF);
																										 disable(document.formGrade.turma);
																										 disable(document.formGrade.turno);
																										 disable(document.formGrade.materia);
																										 disable(document.formGrade.procura);
																										 disable(document.formGrade.instrutor);
																										 disable(document.formGrade.sala);
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
			$_SESSION["consultaGradeHorariaRel"] = $_POST;
			
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
					// Verifica se a busca é por todas as notas fiscais
					if($_SESSION["consultaGradeHorariaRel"]["todas"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Todas as Grades Horárias</strong></ol></td>
						</tr>
						<?php
					}
					 
					// Verifica se foi habilitado o campo de data
					if($_SESSION["consultaGradeHorariaRel"]["habilitarData"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaGradeHorariaRel"]["dataI"]?> até <?php echo $_SESSION["consultaGradeHorariaRel"]["dataF"]?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de turma
					if($_SESSION["consultaGradeHorariaRel"]["habilitarTurma"] == "sim"){
						
						// Dados da Turma
						$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaGradeHorariaRel"]["turma"] . "'");
						
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de turno
					if($_SESSION["consultaGradeHorariaRel"]["habilitarTurno"] == "sim"){
						
						// Dados do Turno
						$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $_SESSION["consultaGradeHorariaRel"]["turno"] . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Turno:</strong>&nbsp;<?php print($dadosTurno->turno . " (" . $dadosTurno->horarioi . " - " . $dadosTurno->horariof . ")"); ?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de matéria
					if($_SESSION["consultaGradeHorariaRel"]["habilitarMateria"] == "sim"){
					
						// Dados da Matéria
						$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $_SESSION["consultaGradeHorariaRel"]["materia"] . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Matéria:</strong>&nbsp;<?php print($dadosMateria->materia);?></ol></td>
						</tr>
						<?php
						
					}
					
					//Verifica se foi habilitado o campo de Instrutores
					if($_SESSION["consultaGradeHorariaRel"]["habilitarInstrutor"] == "sim"){
						
						// Dados do Instrutor
						$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaGradeHorariaRel"]["instrutor"] . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Instrutor:</strong>&nbsp;<?php print($dadosInstrutor->nome);?> (<?php print($_ClassUtilitarios->formataCPF($dadosInstrutor->cpf));?>)</ol></td>
						</tr>
						<?php
					}
					
					//Verifica se foi habilitado o campo de sala
					if($_SESSION["consultaGradeHorariaRel"]["habilitarSala"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Sala:</strong>&nbsp;<?php echo $_SESSION["consultaGradeHorariaRel"]["sala"]?></ol></td>
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
		<tr>
			<td align='left'><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table width="99%" border="0" cellpadding="2" cellspacing="2">
					<tr>
						<td align='left'>
							<form action="<?php print($pathInc);?>modulos/relatorios/_rel.gradehoraria.emitir.php" method="POST" name="formGrade" target="_blank">
								<table class="consulta" cellspacing="1" align="center">
									<thead>
										<tr>
											<th width="1%"><?php print($_ClassUtilitarios->OrdemControl("#", "?sessao=gradehoraria&ref=buscar&pg=" . $_REQUEST["pg"], "id", $pathInc)); ?></th>
											<th width="1%" align="center"><input type="checkbox" onclick="select_all('formGrade', 'registros[]')"></th>
											<th width="20%"><?php print($_ClassUtilitarios->OrdemControl("Data", "?sessao=rel_gradehoraria&ref=buscar&pg=" . $_REQUEST["pg"], "data", $pathInc)); ?></th>
											<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Turma", "?sessao=rel_gradehoraria&ref=buscar&pg=" . $_REQUEST["pg"], "turma", $pathInc)); ?></th>
											<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Turno", "?sessao=rel_gradehoraria&ref=buscar&pg=" . $_REQUEST["pg"], "turno", $pathInc)); ?></th>
											<th width="45%"><?php print($_ClassUtilitarios->OrdemControl("Matéria", "?sessao=rel_gradehoraria&ref=buscar&pg=" . $_REQUEST["pg"], "materia", $pathInc)); ?></th>
											<th width="5%"><?php print($_ClassUtilitarios->OrdemControl("Sala", "?sessao=rel_gradehoraria&ref=buscar&pg=" . $_REQUEST["pg"], "sala", $pathInc)); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php	
										/* Construindo sql */
										$sql = "SELECT * FROM `gradehoraria`";
										$sql .= " WHERE deletado = 'N' AND";
										if($_SESSION["consultaGradeHorariaRel"]["todas"] != "sim"){
											
											$sql .= (($_SESSION["consultaGradeHorariaRel"]["habilitarData"] == "sim")?" data >= '" . $_ClassData->transformaData($_SESSION["consultaGradeHorariaRel"]["dataI"]) . "' AND data <= '" . $_ClassData->transformaData($_SESSION["consultaGradeHorariaRel"]["dataF"]) . "' AND":"");
											$sql .= (($_SESSION["consultaGradeHorariaRel"]["habilitarTurma"] == "sim")?" turma = '" . $_SESSION["consultaGradeHorariaRel"]["turma"] . "' AND":"");
											$sql .= (($_SESSION["consultaGradeHorariaRel"]["habilitarTurno"] == "sim")?" turno = '" . $_SESSION["consultaGradeHorariaRel"]["turno"] . "' AND":"");
											$sql .= (($_SESSION["consultaGradeHorariaRel"]["habilitarMateria"] == "sim")?" materia = '" . $_SESSION["consultaGradeHorariaRel"]["materia"] . "' AND":"");
											$sql .= (($_SESSION["consultaGradeHorariaRel"]["habilitarInstrutor"] == "sim")?" instrutor = '" . $_SESSION["consultaGradeHorariaRel"]["instrutor"] . "' AND":"");
											$sql .= (($_SESSION["consultaGradeHorariaRel"]["habilitarSala"] == "sim")?" sala = '" . $_SESSION["consultaGradeHorariaRel"]["sala"] . "' AND":"");
											
											//$sql .= (($_POST["habilitar"] == "sim")?"":"");
										}
										
										$sql .= " deletado = 'N' ORDER BY " . (($_REQUEST['campo'] == '')?'id':$_REQUEST['campo']) . " " . (($_REQUEST['ordem'] == '')?"ASC":$_REQUEST['ordem']);
					
										/* Fim da construção */
										
										// Paginação
										require_once($pathInc . "lib/Paginacao.class.php");
										
										// Configurações da paginacao
										$_ClassPaginacao->setQuery($sql);
										$_ClassPaginacao->setUrl("?sessao=rel_gradehoraria&ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&filtro=" . $_REQUEST["filtro"]);
										$_ClassPaginacao->setRegistrosPorPagina("100");
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
												$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $trazResultados->turno . "'");
							
												// Dados da Matéria
												$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazResultados->materia . "'");
	
												// Url do Pai
												$_SESSION["urlPai"] = "../../../?" . $_SERVER['QUERY_STRING'];
												?>
												<tr class=row0>
													<td align='left'><?php print($trazResultados->id); ?></td>
													<td align="center"><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"></td>
													<td align="center"><a name="<?=$trazResultados->id?>"></a><?php print($_ClassData->transformaData($trazResultados->data, 2));?></td>
													<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
													<td align="center"><?php print($dadosTurno->turno); ?></td>
													<td align="center"><?php print($dadosMateria->materia); ?></td>
													<td align="center"><?php print($trazResultados->sala); ?></td>
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