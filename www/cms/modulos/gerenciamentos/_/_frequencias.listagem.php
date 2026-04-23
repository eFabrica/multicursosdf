<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = '../../../';

// Arquivo de Configurações
require_once($pathInc . "inc/config.inc.php");

# Dados de Logado
	
	// Verifica se está logado
	if($_SESSION["dadosLogin"]["idLogado"] > 0){

		// Dados do Logado
		$_dadosLogado = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Dados da Unidade
		$_dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N'");
		
	
	}

// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");
	
// Dados da Matrícula
$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_REQUEST["idMatricula"] . "'");

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $dadosMatricula->turma . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");

// Dados do Turno
$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");

// Dados da Matéria
$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $dadosMatricula->materia . "'");

// Dados do Aluno
$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");
?>
<html>
	<head>
		<?php require_once($pathInc . "includes/head.php"); ?>
	</head>
	
	<body>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="menu_topico">Dados da Matrícula</td>
			</tr>
			<tr>
				<td align='left'>
					<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
						<tr>
							<td align="right" width="15%"><b>Aluno:</b></td>
							<td width='85%' align='left'><?php print($dadosAluno->nome . " (" . $_ClassUtilitarios->formataCPF($dadosAluno->cpf) . ")");?></td>
						</tr>
						<tr>
							<td align="right"><b>Turma:</b></td>
							<td align='left'><?php print($dadosCurso->sigla . $dadosTurma->numero);?></td>
						</tr>
						<tr>
							<td align="right"><b>Truno:</b></td>
							<td align='left'><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof);?></td>
						</tr>
						<tr>
							<td align="right"><b>Concluído:</b></td>
							<td align='left'><img src="<?php print($pathInc);?>imagens/diversos/<?php print((($dadosMatricula->reprovado == "S")?"X.png":$dadosMatricula->concluido));?>.png"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="menu_topico">Listagem das Frequências <?php if($_REQUEST["ref"] != ""){?><a href="?idMatricula=<?php print($_REQUEST["idMatricula"]);?>">[ Nova Consulta ]</a><?php }?></td>
			</tr>
			<?php
			// Verifica referência
			if($_REQUEST["ref"] == ""){
				?>
				<tr>
					<td align="center">
						<form action="?ref=buscar&idMatricula=<?php print($_REQUEST["idMatricula"]);?>" method="POST" name="formFrequencias">
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
																												 disen(document.formFrequencias.habilitarMateria);checkedDisable(document.formFrequencias.habilitarMateria);
																												 disen(document.formFrequencias.habilitarInstrutor);checkedDisable(document.formFrequencias.habilitarInstrutor);
																												 disen(document.formFrequencias.habilitarSala);checkedDisable(document.formFrequencias.habilitarSala);
																												 disable(document.formFrequencias.dataI);
																												 disable(document.formFrequencias.dataF);
																												 disable(document.formFrequencias.materia);
																												 disable(document.formFrequencias.instrutor);
																												 disable(document.formFrequencias.sala);
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
				<?php
			}else{
				
				/* Gravando dados da pesquisa na sessão */
				if($_REQUEST["a"] == "S"){
				
					// Consulta
					$_SESSION["consultaFrequenciasPop"]["consultaFrequencias"] = $_POST;
					
				}
				
				?>
				<tr>
					<td align='left'>
						<table width="99%" border="0" cellpadding="2" cellspacing="2">
							<?php
							// Verifica se a busca é por todas as notas fiscais
							if($_SESSION["consultaFrequenciasPopPop"]["consultaFrequencias"]["todas"] == "sim"){
								?>
								<tr>
									<td align='left'><ol><strong>Aula de Hoje (<?php print(date("d/m/Y"));?>)</strong></ol></td>
								</tr>
								<?php
							}
							 
							// Verifica se foi habilitado o campo de data
							if($_SESSION["consultaFrequenciasPopPop"]["consultaFrequencias"]["habilitarData"] == "sim"){
								?>
								<tr>
									<td align='left'><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaFrequenciasPopPop"]["consultaFrequencias"]["dataI"]?> até <?php echo $_SESSION["consultaFrequenciasPopPop"]["consultaFrequencias"]["dataF"]?></ol></td>
								</tr>
								<?php
							}
							
							// Verifica se foi habilitado o campo de matéria
							if($_SESSION["consultaFrequenciasPopPop"]["consultaFrequencias"]["habilitarMateria"] == "sim"){
							
								// Dados da Matéria
								$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $_SESSION["consultaFrequenciasPopPop"]["consultaFrequencias"]["materia"] . "'");
								?>
								<tr>
									<td align='left'><ol><strong>Matéria:</strong>&nbsp;<?php print($dadosMateria->materia);?></ol></td>
								</tr>
								<?php
								
							}
							
							//Verifica se foi habilitado o campo de Instrutores
							if($_SESSION["consultaFrequenciasPopPop"]["consultaFrequencias"]["habilitarInstrutor"] == "sim"){
								
								// Dados do Instrutor
								$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaFrequenciasPopPop"]["consultaFrequencias"]["instrutor"] . "'");
								?>
								<tr>
									<td align='left'><ol><strong>Instrutor:</strong>&nbsp;<?php print($dadosInstrutor->nome);?> (<?php print($dadosInstrutor->cpf);?>)</ol></td>
								</tr>
								<?php
							}
							
							//Verifica se foi habilitado o campo de sala
							if($_SESSION["consultaFrequenciasPopPop"]["consultaFrequencias"]["habilitarSala"] == "sim"){
								?>
								<tr>
									<td align='left'><ol><strong>Sala:</strong>&nbsp;<?php echo $_SESSION["consultaFrequenciasPopPop"]["consultaFrequencias"]["sala"]?></ol></td>
								</tr>
								<?php
							}				
							?>
						</table>
					</td>
				</tr>
				<?php
				// Verifica ação
				switch ($_REQUEST["act"]) {
					
					// Caso for Confirmar Presença
					case "cpresenca":
						
						// Lê Registros
						for($i = 0; $i < count($_REQUEST["registros"]); $i++){
							
							// Dados da Grade Horária
							$dadosGradeHoraria = $_ClassRn->getDadosTable("gradehoraria", "*", "id = '" . $_REQUEST["registros"][$i] . "'");
							
							// Busca Matrícula nas frequências
							$buscaMatriculaFrequencia = $_ClassMysql->query("SELECT * FROM `frequencias` WHERE matricula = '" . $dadosMatricula->id . "' AND gradehoraria = '" . $dadosGradeHoraria->id . "' AND deletado = 'N'");
							
							// Verifica o total achado
							if(mysql_num_rows($buscaMatriculaFrequencia) == 0){
								
								// Confirma Frequência
								$_ClassMysql->query("INSERT INTO `frequencias` SET matricula = '" . $dadosMatricula->id . "',
																				   gradehoraria = '" . $dadosGradeHoraria->id . "',
																				   quemcriou = '" . $_dadosLogado->id . "',
																				   datahorac = NOW();");
								
								// Redireciona
								print($_ClassUtilitarios->redirecionarJS("?ref=buscar&idMatricula=" . $_REQUEST["idMatricula"], 1, array("Foi confirmada " . count($_REQUEST["registros"]) . " presença(s).")));
								
							}
							
						}
						
					break;
					
					// Caso for Retirar Presença
					case "rpresenca":
						
						// Lê Registros
						for($i = 0; $i < count($_REQUEST["registros"]); $i++){
							
							// Dados da Grade Horária
							$dadosGradeHoraria = $_ClassRn->getDadosTable("gradehoraria", "*", "id = '" . $_REQUEST["registros"][$i] . "'");
							
							// Busca Matrícula nas frequências
							$buscaMatriculaFrequencia = $_ClassMysql->query("SELECT * FROM `frequencias` WHERE matricula = '" . $dadosMatricula->id . "' AND gradehoraria = '" . $dadosGradeHoraria->id . "' AND deletado = 'N'");
							
							// Verifica o total achado
							if(mysql_num_rows($buscaMatriculaFrequencia) > 0){
								
								// Deleta Frequência
								$_ClassMysql->query("UPDATE `frequencias` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id. "', datahorad = NOW() WHERE matricula = '" . $dadosMatricula->id . "' AND gradehoraria = '" . $dadosGradeHoraria->id . "'");
								
								// Redireciona
								print($_ClassUtilitarios->redirecionarJS("?ref=buscar&idMatricula=" . $_REQUEST["idMatricula"], 1, array("Foi retirada a confirmação de " . count($_REQUEST["registros"]) . " presença(s).")));
								
							}
							
						}
						
					break;
				}
				
				print(count($_REQUEST["registros"]));
				?>
				<tr>
					<td align='left'>
						<table width="99%" border="0" cellpadding="2" cellspacing="2">
							<?php
							// Verifica se a turma já foi concluida
							if($dadosTurma->concluido == 'N'){
								?>
								<tr>
									<td width="15%" align="right">Com Selecionados:</td>
									<td width='85%' align='left'>
										<select onchange="document.formFrequencias.act.value = '' + this.options[this.selectedIndex].value; document.formFrequencias.submit();">
											<option value=""></option>
											<option value="cpresenca">Confirmar Presença</option>
											<option value="rpresenca">Retirar Presença</option>
										</select>
									</td>
								</tr>
								<?php
							}
							?>
							<tr>
								<td colspan="2">
									<form action="" method="POST" name="formFrequencias">
										<input type="hidden" name="act" value="">
										<table class="consulta" cellspacing="1" align="center">
											<thead>
												<tr>
													<th width="1%"><?php print($_ClassUtilitarios->OrdemControl("#", "?ref=buscar&idMatricula=" . $_REQUEST["idMatricula"] . "&pg=" . $_REQUEST["pg"], "id", $pathInc)); ?></th>
													<?php if($dadosTurma->concluido == 'N'){?><th width="1%" align="center"><input type="checkbox" onclick="select_all('formFrequencias', 'registros[]')"></th><?php }?>
													<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Data", "?ref=buscar&idMatricula=" . $_REQUEST["idMatricula"] . "&pg=" . $_REQUEST["pg"], "data", $pathInc)); ?></th>
													<th width="40%"><?php print($_ClassUtilitarios->OrdemControl("Matéria", "?ref=buscar&idMatricula=" . $_REQUEST["idMatricula"] . "&pg=" . $_REQUEST["pg"], "materia", $pathInc)); ?></th>
													<th width="35%"><?php print($_ClassUtilitarios->OrdemControl("Instrutor", "?ref=buscar&idMatricula=" . $_REQUEST["idMatricula"] . "&pg=" . $_REQUEST["pg"], "instrutor", $pathInc)); ?></th>
													<th width="5%"><?php print($_ClassUtilitarios->OrdemControl("Sala", "?ref=buscar&idMatricula=" . $_REQUEST["idMatricula"] . "&pg=" . $_REQUEST["pg"], "sala", $pathInc)); ?></th>
													<th width="5%">Presente</th>
												</tr>
											</thead>
											<tbody>
												<?php	
												/* Construindo sql */
												$sql = "SELECT * FROM `gradehoraria`";
												$sql .= " WHERE turma = '" . $dadosMatricula->turma . "' AND turno = '" . $dadosTurma->turno . "' AND ";
												if($_SESSION["consultaFrequenciasPop"]["consultaFrequencias"]["todas"] != "sim"){
													
													$sql .= (($_SESSION["consultaFrequenciasPop"]["consultaFrequencias"]["habilitarData"] == "sim")?" data >= '" . $_ClassData->transformaData($_SESSION["consultaFrequenciasPop"]["consultaFrequencias"]["dataI"]) . "' AND data <= '" . $_ClassData->transformaData($_SESSION["consultaFrequenciasPop"]["consultaFrequencias"]["dataF"]) . "' AND":"");
													$sql .= (($_SESSION["consultaFrequenciasPop"]["consultaFrequencias"]["habilitarMateria"] == "sim")?" materia = '" . $_SESSION["consultaFrequenciasPop"]["consultaFrequencias"]["materia"] . "' AND":"");
													$sql .= (($_SESSION["consultaFrequenciasPop"]["consultaFrequencias"]["habilitarInstrutor"] == "sim")?" instrutor = '" . $_SESSION["consultaFrequenciasPop"]["consultaFrequencias"]["instrutor"] . "' AND":"");
													$sql .= (($_SESSION["consultaFrequenciasPop"]["consultaFrequencias"]["habilitarSala"] == "sim")?" sala = '" . $_SESSION["consultaFrequenciasPop"]["consultaFrequencias"]["sala"] . "' AND":"");
													
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
												$_ClassPaginacao->setUrl("?ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"]);
												$_ClassPaginacao->setRegistrosPorPagina("10");
												$_ClassPaginacao->setPaginaAtual((($_REQUEST["pg"] == 0)?"1":$_REQUEST["pg"]));
												$_ClassPaginacao->paginando($pathInc);
																		
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
									
														// Dados da Matéria
														$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazResultados->materia . "'");
														
														// Dados do Instrutor
														$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $trazResultados->instrutor . "'");
														
														// Busca Matrícula nas frequências
														$buscaMatriculaFrequencia = $_ClassMysql->query("SELECT * FROM `frequencias` WHERE matricula = '" . $dadosMatricula->id . "' AND gradehoraria = '" . $trazResultados->id . "' AND deletado = 'N'");
														?>
														<tr class=row0>
															<td align='left'><?php print($trazResultados->id); ?></td>
															<?php if($dadosTurma->concluido == 'N'){?><td align="center"><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"></td><?php }?>
															<td align="center"><a name="<?=$trazResultados->id?>"></a><?php print($_ClassData->transformaData($trazResultados->data, 2));?></td>
															<td align="center"><?php print($dadosMateria->sigla); ?></td>
															<td align="center"><?php print($_ClassUtilitarios->abreviaNome1($dadosInstrutor->nome)); ?></td>
															<td align="center"><?php print($trazResultados->sala); ?></td>
															<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print(((mysql_num_rows($buscaMatriculaFrequencia) > 0)?"S":"N"));?>.png"></td>
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
				<?php
				
			}
			?>
		</table>
	</body>
</html>