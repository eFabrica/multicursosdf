<?php require_once("php7_mysql_shim.php");
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica referência
if($_REQUEST["subref"] == ""){
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="?sessao=frequencias&ref=novo&subref=buscar" method="POST" name="formFrequencias">
				<input type="hidden" name="a" value="S">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td width="15%" align="right"><strong>Data:</strong></td>
						<td align='left'>
							De <input type="text" id="dataI" name="dataI" size="12" onKeyUp="maskData(this, document.formFrequencias.dataF)" disabled>
					  		até <input type="text" id="dataF" name="dataF" size="12" onKeyUp="maskData(this, document.formFrequencias.dataF)" disabled>
						</td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitarData" value="sim" onClick="disen(document.formFrequencias.dataI);disen(document.formFrequencias.dataF);" ></td>
					</tr>
					<tr>
						<td align="right"><b>Filtrar Turmas:</b></td>
						<td align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formFrequencias.turma);" disabled></td>
						<td align='left'></td>
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
					 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formFrequencias.turma);disen(document.formFrequencias.procura);" ></td>
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
					 	<td align="center"><input type="checkbox" name="habilitarTurno" value="sim" onClick="disen(document.formFrequencias.turno);" ></td>
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
						<td align="center"><input type="checkbox" name="habilitarMateria" value="sim" onClick="disen(document.formFrequencias.materia)" ></td>
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
					  	<td align="center"><input type="checkbox" name="habilitarInstrutor" value="sim" onClick="disen(document.formFrequencias.instrutor);" ></td>
					</tr>
					<tr>
						<td align="right"><strong>Sala:</strong></td>
					  	<td align='left'><input type="text" id="sala" name="sala" size="5" disabled></td>
					  	<td align="center"><input type="checkbox" name="habilitarSala" value="sim" onClick="disen(document.formFrequencias.sala);" ></td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
						<td align="right"><strong>Hoje</strong></td>
						<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formFrequencias.habilitarData);checkedDisable(document.formFrequencias.habilitarData);
																									 disen(document.formFrequencias.habilitarTurma);checkedDisable(document.formFrequencias.habilitarTurma);
																									 disen(document.formFrequencias.habilitarTurno);checkedDisable(document.formFrequencias.habilitarTurno);
																									 disen(document.formFrequencias.habilitarMateria);checkedDisable(document.formFrequencias.habilitarMateria);
																									 disen(document.formFrequencias.habilitarInstrutor);checkedDisable(document.formFrequencias.habilitarInstrutor);
																									 disen(document.formFrequencias.habilitarSala);checkedDisable(document.formFrequencias.habilitarSala);
																									 disable(document.formFrequencias.dataI);
																									 disable(document.formFrequencias.dataF);
																									 disable(document.formFrequencias.turma);
																									 disable(document.formFrequencias.turno);
																									 disable(document.formFrequencias.materia);
																									 disable(document.formFrequencias.instrutor);
																									 disable(document.formFrequencias.sala);
																									 disable(document.formFrequencias.procura);
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
}elseif($_REQUEST["subref"] == "buscar"){
	
	/* Gravando dados da pesquisa na sessão */
	if($_REQUEST["a"] == "S"){
	
		// Consulta
		$_SESSION["consultaFrequencias"]["consultaFrequencias"] = $_POST;
		
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
				if($_SESSION["consultaFrequencias"]["consultaFrequencias"]["todas"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Aula de Hoje (<?php print(date("d/m/Y"));?>)</strong></ol></td>
					</tr>
					<?php
				}
				 
				// Verifica se foi habilitado o campo de data
				if($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarData"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaFrequencias"]["consultaFrequencias"]["dataI"]?> até <?php echo $_SESSION["consultaFrequencias"]["consultaFrequencias"]["dataF"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de turma
				if($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarTurma"] == "sim"){
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaFrequencias"]["consultaFrequencias"]["turma"] . "'");
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de turno
				if($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarTurno"] == "sim"){
					
					// Dados do Turno
					$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $_SESSION["consultaFrequencias"]["consultaFrequencias"]["turno"] . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Turno:</strong>&nbsp;<?php print($dadosTurno->turno . " (" . $dadosTurno->horarioi . " - " . $dadosTurno->horariof . ")"); ?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de matéria
				if($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarMateria"] == "sim"){
				
					// Dados da Matéria
					$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $_SESSION["consultaFrequencias"]["consultaFrequencias"]["materia"] . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Matéria:</strong>&nbsp;<?php print($dadosMateria->materia);?></ol></td>
					</tr>
					<?php
					
				}
				
				//Verifica se foi habilitado o campo de Instrutores
				if($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarInstrutor"] == "sim"){
					
					// Dados do Instrutor
					$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaFrequencias"]["consultaFrequencias"]["instrutor"] . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Instrutor:</strong>&nbsp;<?php print($dadosInstrutor->nome);?> (<?php print($dadosInstrutor->cpf);?>)</ol></td>
					</tr>
					<?php
				}
				
				//Verifica se foi habilitado o campo de sala
				if($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarSala"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Sala:</strong>&nbsp;<?php echo $_SESSION["consultaFrequencias"]["consultaFrequencias"]["sala"]?></ol></td>
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
						<form action="?sessao=frequencias&ref=novo&etapa=2" method="POST" name="formFrequencias">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%"><?php print($_ClassUtilitarios->OrdemControl("#", "?sessao=frequencias&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "id", $pathInc)); ?></th>
										<th width="1%" align="center"></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Data", "?sessao=frequencias&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "data", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Turma", "?sessao=frequencias&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "turma", $pathInc)); ?></th>
										<th width="20%"><?php print($_ClassUtilitarios->OrdemControl("Turno", "?sessao=frequencias&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "turno", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Matéria", "?sessao=frequencias&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "materia", $pathInc)); ?></th>
										<th width="30%"><?php print($_ClassUtilitarios->OrdemControl("Instrutor", "?sessao=frequencias&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "instrutor", $pathInc)); ?></th>
										<th width="5%"><?php print($_ClassUtilitarios->OrdemControl("Sala", "?sessao=frequencias&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "sala", $pathInc)); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php	
									/* Construindo sql */
									$sql = "SELECT * FROM `gradehoraria`";
									$sql .= " WHERE ";
									if($_SESSION["consultaFrequencias"]["consultaFrequencias"]["todas"] != "sim"){
										
										$sql .= (($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarData"] == "sim")?" data >= '" . $_ClassData->transformaData($_SESSION["consultaFrequencias"]["consultaFrequencias"]["dataI"]) . "' AND data <= '" . $_ClassData->transformaData($_SESSION["consultaFrequencias"]["consultaFrequencias"]["dataF"]) . "' AND":"");
										$sql .= (($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarTurma"] == "sim")?" turma = '" . $_SESSION["consultaFrequencias"]["consultaFrequencias"]["turma"] . "' AND":"");
										$sql .= (($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarTurno"] == "sim")?" turno = '" . $_SESSION["consultaFrequencias"]["consultaFrequencias"]["turno"] . "' AND":"");
										$sql .= (($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarMateria"] == "sim")?" materia = '" . $_SESSION["consultaFrequencias"]["consultaFrequencias"]["materia"] . "' AND":"");
										$sql .= (($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarInstrutor"] == "sim")?" instrutor = '" . $_SESSION["consultaFrequencias"]["consultaFrequencias"]["instrutor"] . "' AND":"");
										$sql .= (($_SESSION["consultaFrequencias"]["consultaFrequencias"]["habilitarSala"] == "sim")?" sala = '" . $_SESSION["consultaFrequencias"]["consultaFrequencias"]["sala"] . "' AND":"");
										
										//$sql .= (($_POST["habilitar"] == "sim")?"":"");
									}else{
										
										$sql .= " data >= '" . date("Y-m-d") . "' AND data <= '" . date("Y-m-d") . "' AND";
										
									}
									
									$sql .= " deletado = 'N' ORDER BY " . (($_REQUEST['campo'] == '')?'id':$_REQUEST['campo']) . " " . (($_REQUEST['ordem'] == '')?"ASC":$_REQUEST['ordem']);
				
									/* Fim da construção */
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=frequencias&ref=novo&subref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&filtro=" . $_REQUEST["filtro"]);
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
										$cont = 1;
										
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
												<td align="center"><input type="radio" name="idGrade" value="<?=$trazResultados->id?>" <?php print((($cont++ == 1)?"checked":""));?>></td>
												<td align="center"><a name="<?=$trazResultados->id?>"></a><?php print($_ClassData->transformaData($trazResultados->data, 2));?></td>
												<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
												<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
												<td align="center"><?php print($dadosMateria->sigla); ?></td>
												<td align="center"><?php print($_ClassUtilitarios->abreviaNome1($dadosInstrutor->nome)); ?></td>
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