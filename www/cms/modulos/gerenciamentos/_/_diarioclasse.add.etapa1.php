<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica referência
if($_REQUEST["subref"] == ""){
	?>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="?sessao=diarioclasse&ref=novo&subref=buscar" method="POST" name="formDiarioClasse">
				<input type="hidden" name="a" value="S">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td width="15%" align="right"><strong>Data:</strong></td>
						<td align="left">
							De <input type="text" id="dataI" name="dataI" size="12" onKeyUp="maskData(this, document.formDiarioClasse.dataF)" disabled>
					  		até <input type="text" id="dataF" name="dataF" size="12" onKeyUp="maskData(this, document.formDiarioClasse.dataF)" disabled>
						</td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitarData" value="sim" onClick="disen(document.formDiarioClasse.dataI);disen(document.formDiarioClasse.dataF);" ></td>
					</tr>
					<tr>
						<td align="right"><b>Filtrar Turmas:</b></td>
						<td align="left"><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formDiarioClasse.turma);" disabled></td>
						<td align="left"></td>
					</tr>
					<tr>
						<td align="right"><strong>Turma:</strong></td>
						<td align="left">
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
					 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formDiarioClasse.turma);disen(document.formDiarioClasse.procura);" ></td>
					</tr>
					<tr>
						<td align="right"><strong>Turno:</strong></td>
						<td align="left">
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
					 	<td align="center"><input type="checkbox" name="habilitarTurno" value="sim" onClick="disen(document.formDiarioClasse.turno);" ></td>
					</tr>
					<tr>
						<td align="right"><strong>Matéria:</strong></td>
						<td align="left">
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
						<td align="center"><input type="checkbox" name="habilitarMateria" value="sim" onClick="disen(document.formDiarioClasse.materia)" ></td>
					</tr>
					<tr>
						<td align="right"><strong>Instrutor:</strong></td>
					  	<td align="left">
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
					  	<td align="center"><input type="checkbox" name="habilitarInstrutor" value="sim" onClick="disen(document.formDiarioClasse.instrutor);" ></td>
					</tr>
					<tr>
						<td align="right"><strong>Sala:</strong></td>
					  	<td align="left"><input type="text" id="sala" name="sala" size="5" disabled></td>
					  	<td align="center"><input type="checkbox" name="habilitarSala" value="sim" onClick="disen(document.formDiarioClasse.sala);" ></td>
					</tr>
					<tr>
						<td align="left">&nbsp;</td>
						<td align="right"><strong>Hoje</strong></td>
						<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formDiarioClasse.habilitarData);checkedDisable(document.formDiarioClasse.habilitarData);
																									 disen(document.formDiarioClasse.habilitarTurma);checkedDisable(document.formDiarioClasse.habilitarTurma);
																									 disen(document.formDiarioClasse.habilitarTurno);checkedDisable(document.formDiarioClasse.habilitarTurno);
																									 disen(document.formDiarioClasse.habilitarMateria);checkedDisable(document.formDiarioClasse.habilitarMateria);
																									 disen(document.formDiarioClasse.habilitarInstrutor);checkedDisable(document.formDiarioClasse.habilitarInstrutor);
																									 disen(document.formDiarioClasse.habilitarSala);checkedDisable(document.formDiarioClasse.habilitarSala);
																									 disable(document.formDiarioClasse.dataI);
																									 disable(document.formDiarioClasse.dataF);
																									 disable(document.formDiarioClasse.turma);
																									 disable(document.formDiarioClasse.turno);
																									 disable(document.formDiarioClasse.materia);
																									 disable(document.formDiarioClasse.procura);
																									 disable(document.formDiarioClasse.instrutor);
																									 disable(document.formDiarioClasse.sala);
																									 this.disabled = false;" ></td>
					</tr>
					<tr>
						<td align="left">&nbsp;</td>
						<td align="left"><input type="submit" value="Consultar"></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}elseif($_REQUEST["subref"] == "buscar"){
	
	/* Gravando dados da pesquisa na sessão */
	if($_REQUEST["a"] == "S"){
	
		// Consulta
		$_SESSION["consultaDiarioClasse"] = $_POST;
		
	}
	
	?>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td class="menu_topico">Buscando por: </td>
				</tr>
				<?php
				// Verifica se a busca é por todas as notas fiscais
				if($_SESSION["consultaDiarioClasse"]["todas"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Aula de Hoje (<?php print(date("d/m/Y"));?>)</strong></ol></td>
					</tr>
					<?php
				}
				 
				// Verifica se foi habilitado o campo de data
				if($_SESSION["consultaDiarioClasse"]["habilitarData"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaDiarioClasse"]["dataI"]?> até <?php echo $_SESSION["consultaDiarioClasse"]["dataF"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de turma
				if($_SESSION["consultaDiarioClasse"]["habilitarTurma"] == "sim"){
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaDiarioClasse"]["turma"] . "'");
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
					?>
					<tr>
						<td align="left"><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de turno
				if($_SESSION["consultaDiarioClasse"]["habilitarTurno"] == "sim"){
					
					// Dados do Turno
					$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $_SESSION["consultaDiarioClasse"]["turno"] . "'");
					?>
					<tr>
						<td align="left"><ol><strong>Turno:</strong>&nbsp;<?php print($dadosTurno->turno . " (" . $dadosTurno->horarioi . " - " . $dadosTurno->horariof . ")"); ?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de matéria
				if($_SESSION["consultaDiarioClasse"]["habilitarMateria"] == "sim"){
				
					// Dados da Matéria
					$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $_SESSION["consultaDiarioClasse"]["materia"] . "'");
					?>
					<tr>
						<td align="left"><ol><strong>Matéria:</strong>&nbsp;<?php print($dadosMateria->materia);?></ol></td>
					</tr>
					<?php
					
				}
				
				//Verifica se foi habilitado o campo de Instrutores
				if($_SESSION["consultaDiarioClasse"]["habilitarInstrutor"] == "sim"){
					
					// Dados do Instrutor
					$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaDiarioClasse"]["instrutor"] . "'");
					?>
					<tr>
						<td align="left"><ol><strong>Instrutor:</strong>&nbsp;<?php print($dadosInstrutor->nome);?> (<?php print($dadosInstrutor->cpf);?>)</ol></td>
					</tr>
					<?php
				}
				
				//Verifica se foi habilitado o campo de sala
				if($_SESSION["consultaDiarioClasse"]["habilitarSala"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Sala:</strong>&nbsp;<?php echo $_SESSION["consultaDiarioClasse"]["sala"]?></ol></td>
					</tr>
					<?php
				}				
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td align="left">
						<form action="?sessao=diarioclasse&ref=novo&etapa=2" method="POST" name="formDiarioClasse">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%"><?php print($_ClassUtilitarios->OrdemControl("#", "?sessao=diarioclasse&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "id", $pathInc)); ?></th>
										<th width="1%" align="center"></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Data", "?sessao=diarioclasse&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "data", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Turma", "?sessao=diarioclasse&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "turma", $pathInc)); ?></th>
										<th width="20%"><?php print($_ClassUtilitarios->OrdemControl("Turno", "?sessao=diarioclasse&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "turno", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Matéria", "?sessao=diarioclasse&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "materia", $pathInc)); ?></th>
										<th width="30%"><?php print($_ClassUtilitarios->OrdemControl("Instrutor", "?sessao=diarioclasse&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "instrutor", $pathInc)); ?></th>
										<th width="5%"><?php print($_ClassUtilitarios->OrdemControl("Sala", "?sessao=diarioclasse&ref=novo&subref=buscar&pg=" . $_REQUEST["pg"], "sala", $pathInc)); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php	
									/* Construindo sql */
									$sql = "SELECT * FROM `gradehoraria`";
									$sql .= " WHERE ";
									if($_SESSION["consultaDiarioClasse"]["todas"] != "sim"){
										
										$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarData"] == "sim")?" data >= '" . $_ClassData->transformaData($_SESSION["consultaDiarioClasse"]["dataI"]) . "' AND data <='" . $_ClassData->transformaData($_SESSION["consultaDiarioClasse"]["dataF"]) . "' AND":"");
										$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarTurma"] == "sim")?" turma = '" . $_SESSION["consultaDiarioClasse"]["turma"] . "' AND":"");
										$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarTurno"] == "sim")?" turno = '" . $_SESSION["consultaDiarioClasse"]["turno"] . "' AND":"");
										$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarMateria"] == "sim")?" materia = '" . $_SESSION["consultaDiarioClasse"]["materia"] . "' AND":"");
										$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarInstrutor"] == "sim")?" instrutor = '" . $_SESSION["consultaDiarioClasse"]["instrutor"] . "' AND":"");
										$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarSala"] == "sim")?" sala = '" . $_SESSION["consultaDiarioClasse"]["sala"] . "' AND":"");
										
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
									$_ClassPaginacao->setUrl("?sessao=diarioclasse&ref=novo&subref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&filtro=" . $_REQUEST["filtro"]);
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

											// Url do Pai
											$_SESSION["urlPai"] = "../../../?" . $_SERVER['QUERY_STRING'];
											?>
											<tr class=row0>
												<td align="left"><?php print($trazResultados->id); ?></td>
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
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}
?>