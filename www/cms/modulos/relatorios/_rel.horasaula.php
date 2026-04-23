<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
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
					<td align="left" width="" class="menu_topico">Relatórios [Horas Aula Detalhada] <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == "buscar"){							
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=rel_horasaula"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
								<td align="center"><div class="caixaIcone"><a href="<?php print($pathInc);?>modulos/relatorios/_rel.horasaula.emitir.php<?php print("?ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"]);?>" target="_blank"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Emitir</a></div></td>
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
				<form action="?sessao=rel_horasaula&ref=buscar" method="POST" name="formRelHorasAula">
					<input type="hidden" name="a" value="S">
					<table border="0" cellpadding="2" cellspacing="2" align="center">
						<tr>
							<td width="15%" align="right"><strong>Data:</strong></td>
							<td align='left'>
								De <input type="text" id="dataI" name="dataI" size="12" onKeyUp="maskData(this, document.formRelHorasAula.dataF)" disabled>
						  		até <input type="text" id="dataF" name="dataF" size="12" onKeyUp="maskData(this, document.formRelHorasAula.dataF)" disabled>
							</td>
						 	<td width="5%" align="center"><input type="checkbox" name="habilitarData" value="sim" onClick="disen(document.formRelHorasAula.dataI);disen(document.formRelHorasAula.dataF);" ></td>
						</tr>
						<tr>
							<td align="right"><strong>Turma:</strong></td>
							<td align='left'>
								<select name="turma" disabled>
									<?php
									// Busca Turmas
									$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND concluido = 'N' AND deletado = 'N'");
									
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
						 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formRelHorasAula.turma);" ></td>
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
						 	<td align="center"><input type="checkbox" name="habilitarTurno" value="sim" onClick="disen(document.formRelHorasAula.turno);" ></td>
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
							<td align="center"><input type="checkbox" name="habilitarMateria" value="sim" onClick="disen(document.formRelHorasAula.materia)" ></td>
						</tr>
						<?php
						// Verifica Nível
						if($_dadosLogado->nivel != "95"){
							?>
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
							  	<td align="center"><input type="checkbox" name="habilitarInstrutor" value="sim" onClick="disen(document.formRelHorasAula.instrutor);" ></td>
							</tr>
							<?php
						}
						?>
						<tr>
							<td align="right"><strong>Sala:</strong></td>
						  	<td align='left'><input type="text" id="sala" name="sala" size="5" disabled></td>
						  	<td align="center"><input type="checkbox" name="habilitarSala" value="sim" onClick="disen(document.formRelHorasAula.sala);" ></td>
						</tr>
						<tr>
							<td align='left'>&nbsp;</td>
							<td align="right"><strong>Todas</strong></td>
							<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formRelHorasAula.habilitarData);checkedDisable(document.formRelHorasAula.habilitarData);
																										 disen(document.formRelHorasAula.habilitarTurma);checkedDisable(document.formRelHorasAula.habilitarTurma);
																										 disen(document.formRelHorasAula.habilitarTurno);checkedDisable(document.formRelHorasAula.habilitarTurno);
																										 disen(document.formRelHorasAula.habilitarMateria);checkedDisable(document.formRelHorasAula.habilitarMateria);
																										 <?php if($_dadosLogado->nivel != "95"){?>disen(document.formRelHorasAula.habilitarInstrutor);checkedDisable(document.formRelHorasAula.habilitarInstrutor);<?php }?>
																										 disen(document.formRelHorasAula.habilitarSala);checkedDisable(document.formRelHorasAula.habilitarSala);
																										 disable(document.formRelHorasAula.dataI);
																										 disable(document.formRelHorasAula.dataF);
																										 disable(document.formRelHorasAula.turma);
																										 disable(document.formRelHorasAula.turno);
																										 disable(document.formRelHorasAula.materia);
																										 <?php if($_dadosLogado->nivel != "95"){?>disable(document.formRelHorasAula.instrutor);<?php }?>
																										 disable(document.formRelHorasAula.sala);
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
			$_SESSION["consultaHorasAulas"] = $_POST;
			
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
					if($_SESSION["consultaHorasAulas"]["todas"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Todas as Horas Aulas</strong></ol></td>
						</tr>
						<?php
					}
					 
					// Verifica se foi habilitado o campo de data
					if($_SESSION["consultaHorasAulas"]["habilitarData"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaHorasAulas"]["dataI"]?> até <?php echo $_SESSION["consultaHorasAulas"]["dataF"]?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de turma
					if($_SESSION["consultaHorasAulas"]["habilitarTurma"] == "sim"){
						
						// Dados da Turma
						$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaHorasAulas"]["turma"] . "'");
						
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de turno
					if($_SESSION["consultaHorasAulas"]["habilitarTurno"] == "sim"){
						
						// Dados do Turno
						$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $_SESSION["consultaHorasAulas"]["turno"] . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Turno:</strong>&nbsp;<?php print($dadosTurno->turno . " (" . $dadosTurno->horarioi . " - " . $dadosTurno->horariof . ")"); ?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de matéria
					if($_SESSION["consultaHorasAulas"]["habilitarMateria"] == "sim"){
					
						// Dados da Matéria
						$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $_SESSION["consultaHorasAulas"]["materia"] . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Matéria:</strong>&nbsp;<?php print($dadosMateria->materia);?></ol></td>
						</tr>
						<?php
						
					}
					
					//Verifica se foi habilitado o campo de Instrutores
					if($_SESSION["consultaHorasAulas"]["habilitarInstrutor"] == "sim"){
						
						// Dados do Instrutor
						$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaHorasAulas"]["instrutor"] . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Instrutor:</strong>&nbsp;<?php print($dadosInstrutor->nome);?> (<?php print($_ClassUtilitarios->formataCPF($dadosInstrutor->cpf));?>)</ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de sala
					if($_SESSION["consultaHorasAulas"]["habilitarSala"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Sala:</strong>&nbsp;<?php echo $_SESSION["consultaHorasAulas"]["sala"]?></ol></td>
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
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%"><?php print($_ClassUtilitarios->OrdemControl("#", "?sessao=rel_horasaula&ref=buscar&pg=" . $_REQUEST["pg"], "id", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Data", "?sessao=rel_horasaula&ref=buscar&pg=" . $_REQUEST["pg"], "data", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Turma", "?sessao=rel_horasaula&ref=buscar&pg=" . $_REQUEST["pg"], "turma", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Turno", "?sessao=rel_horasaula&ref=buscar&pg=" . $_REQUEST["pg"], "turno", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Matéria", "?sessao=rel_horasaula&ref=buscar&pg=" . $_REQUEST["pg"], "materia", $pathInc)); ?></th>
										<th width="30%"><?php print($_ClassUtilitarios->OrdemControl("Instrutor", "?sessao=rel_horasaula&ref=buscar&pg=" . $_REQUEST["pg"], "instrutor", $pathInc)); ?></th>
										<th width="10%"><?php print($_ClassUtilitarios->OrdemControl("Horas", "?sessao=rel_horasaula&ref=buscar&pg=" . $_REQUEST["pg"], "horasaula", $pathInc)); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php	
									/* Construindo sql */
									$sql = "SELECT * FROM `diarioclasse`";
									$sql .= " WHERE ";
									if($_SESSION["consultaHorasAulas"]["todas"] != "sim"){
										
										$sql .= (($_SESSION["consultaHorasAulas"]["habilitarData"] == "sim")?" data >= '" . $_ClassData->transformaData($_SESSION["consultaHorasAulas"]["dataI"]) . "' AND data <= '" . $_ClassData->transformaData($_SESSION["consultaHorasAulas"]["dataF"]) . "' AND":"");
										$sql .= (($_SESSION["consultaHorasAulas"]["habilitarTurma"] == "sim")?" turma = '" . $_SESSION["consultaHorasAulas"]["turma"] . "' AND":"");
										$sql .= (($_SESSION["consultaHorasAulas"]["habilitarTurno"] == "sim")?" turno = '" . $_SESSION["consultaHorasAulas"]["turno"] . "' AND":"");
										$sql .= (($_SESSION["consultaHorasAulas"]["habilitarMateria"] == "sim")?" materia = '" . $_SESSION["consultaHorasAulas"]["materia"] . "' AND":"");
										// Verifica Nível
										if($_dadosLogado->nivel != "95"){
											$sql .= (($_SESSION["consultaHorasAulas"]["habilitarInstrutor"] == "sim")?" instrutor = '" . $_SESSION["consultaHorasAulas"]["instrutor"] . "' AND":"");
										}else{
											$sql .= " instrutor = '" . $_dadosLogado->id . "' AND";
										}
										$sql .= (($_SESSION["consultaHorasAulas"]["habilitarSala"] == "sim")?" sala = '" . $_SESSION["consultaHorasAulas"]["sala"] . "' AND":"");
										
										//$sql .= (($_POST["habilitar"] == "sim")?"":"");
									}else{
										if($_dadosLogado->nivel == "95"){
											$sql .= " instrutor = '" . $_dadosLogado->id . "' AND";
										}
									}
									
									$sql .= " deletado = 'N' ORDER BY " . (($_REQUEST['campo'] == '')?'id':$_REQUEST['campo']) . " " . (($_REQUEST['ordem'] == '')?"ASC":$_REQUEST['ordem']);
				
									/* Fim da construção */
									
									// Busca Horas Aulas
									$totHorasAula = $_ClassMysql->query(str_replace("SELECT * FROM", "SELECT SUM(horasaula) as totalhorasaulas FROM", $sql));
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=rel_horasaula&ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&filtro=" . $_REQUEST["filtro"]);
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
											
											// Dados do Instrutor
											$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $trazResultados->instrutor . "'");
											?>
											<tr class=row0>
												<td align='left'><?php print($trazResultados->id); ?></td>
												<td align="center"><a name="<?=$trazResultados->id?>"></a><?php print($_ClassData->transformaData($trazResultados->data, 2));?></td>
												<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
												<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
												<td align="center"><?php print($dadosMateria->sigla); ?></td>
												<td align="center"><?php print($_ClassUtilitarios->abreviaNome1($dadosInstrutor->nome)); ?></td>
												<td align="center"><?php print($trazResultados->horasaula); ?></td>
											</tr>
											<?php
											
										}
										
									}
									?>
								</tbody>
								<tfoot>
									<td colspan="8" style="text-align: right;">
										<table width="99%" border="0" cellpadding="0" cellspacing="0" align="right">
											<tr>
												<td align="right"><b>Total de Horas: </b><?php print(mysql_result($totHorasAula, 0, "totalhorasaulas"));?></td>
											</tr>
											<tr>
												<td align='left'><?php echo $_ClassPaginacao->showPaginacao();?></td>
											</tr>
										</table>
									</td>
								</tfoot>
							</table>
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