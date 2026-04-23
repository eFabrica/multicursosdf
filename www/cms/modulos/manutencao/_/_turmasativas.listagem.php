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

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $_REQUEST["idTurma"] . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");

// Dados do Turno
$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");

// Importa calsse cpf
require_once($pathInc . "lib/Cpf.class.php");

/*#### FUNÇÃO PARA VERIFICAR INCONSISTENCIAS ####*/
function inconsistencias ($dadosAluno, $matricula, $curso) {
	
	$_ClassData = new Data();
	$_ClassMysql = new Mysql();
	$_ClassRn = new Rn();
	$_ClassCpf = new CPF();
	
	// Dados da Turma
	$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $_REQUEST["idTurma"] . "'");
	
	// Dados do Curso
	$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
	
	// Dados do Turno
	$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
	
	$mensagem = "";
	
	// Permissão
	$permissao = true;
	
	// Verifica dados
	if (empty($dadosAluno->nome)) 							    $mensagem .= "<b>Nome não informado.</b><br />";
	if (empty($dadosAluno->datanascimento)) 				    $mensagem .= "<b>Data de Nascimento não informada.</b><br />";
	if ($dadosAluno->datanascimento != "" && 
		!$_ClassData->validaData($dadosAluno->datanascimento))  $mensagem .= "<b>Data de Nascimento inválida.</b><br />";
	if (empty($dadosAluno->cpf)) 								$mensagem .= "<b>CPF não informado.</b><br />";
	if ($dadosAluno->cpf != "" && 
		!$_ClassCpf->validaCPF($dadosAluno->cpf)) 				$mensagem .= "<b>CPF inválido.</b><br />";
	if (empty($dadosAluno->rg)) 								$mensagem .= "<b>RG não informado.</b><br />";
	if (empty($dadosAluno->orgexp)) 							$mensagem .= "<b>Orgão Expeditor do RG não informado.</b><br />";
	if (empty($dadosAluno->sexo)) 								$mensagem .= "<b>Sexo não informado.</b><br />";
	if (empty($dadosAluno->naturalidade)) 						$mensagem .= "<b>Naturalidade não informada.</b><br />";
	if (empty($dadosAluno->mae)) 								$mensagem .= "<b>Mãe não informada.</b><br />";
	if (empty($dadosAluno->endereco)) 							$mensagem .= "<b>Endereço não informado.</b><br />";
	if (empty($dadosAluno->estado))					 			$mensagem .= "<b>Estado não informado.</b><br />";
	if (empty($dadosAluno->cidade)) 							$mensagem .= "<b>Cidade não informada.</b><br />";
	
	// Verifica curso
	if(strtoupper(substr($dadosCurso->sigla, 0, 2)) == "RB"){
		
		// Verifica dados de formação desse aluno
		if($dadosAluno->numerorg == "" ||
		   $dadosAluno->academiaform == "" ||
		   $dadosAluno->dataform == "" ||
		   $dadosAluno->dataform == "0000-00-00" ||
		   $dadosAluno->orgao == ""){
		   	
			// Exibe mensagem
			$mensagem .= "<b>Dados de Formação Incompletos</b><br />";
			
			// Permissão
			$permissao = false;
			
		}
		
	}
	
	// Busca Falta de Documentos
	$buscaFaltaDocumentos = $_ClassMysql->query("SELECT * FROM `faltadocumentos` WHERE matricula = '" . $matricula . "' AND deletado = 'N'");
	
	// Total achado
	$totalFaltaDocumentos = mysql_num_rows($buscaFaltaDocumentos);
	
	// Busca Parcelas
	$buscaParcelas = $_ClassMysql->query("SELECT * FROM `parcelas` WHERE matricula = '" . $matricula . "' AND paga = 'N' AND deletado = 'N'");
	
	// Total achado
	$totalParcelas = mysql_num_rows($buscaParcelas);
	
	// Verifica o total achado de falta de documentos
	if($totalFaltaDocumentos > 0){
		
		// Traz Documentos em Falta
		while($trazFaltaDocumentos = mysql_fetch_object($buscaFaltaDocumentos)){
			
			// Dados do Documento
			$dadosDocumento = $_ClassRn->getDadosTable("documentos", "*", "id = '" . $trazFaltaDocumentos->documento . "'");
			
			// Exibe mensagem
			$mensagem .= "<b>Falta do documento:&nbsp;</b>" . $dadosDocumento->documento . "<br />";
			
		}
		
	}
	
	// Verifica o total achado de parcelas
	if($totalParcelas > 0){
		
		// Traz Parcela pendente
		while($trazParcelas = mysql_fetch_object($buscaParcelas)){
			
			// Verifica tipo
			if($trazParcelas->tipo == "B"){
				
				// Exibe mensagem
				$mensagem .= "<b>Percela " . $trazParcelas->numero . " do Boleto Pendente:&nbsp;</b><b>Valor</b>:&nbsp;R$ " . $_ClassDinheiro->formataMoeda($trazParcelas->valor) . " <b>|</b> <b>Data</b>: " . $_ClassData->transformaData($trazParcelas->data, 2) . "<br />";
				
			}else{
				
				// Exibe mensagem
				$mensagem .= "<b>Percela " . $trazParcelas->numero . " do Cheque Pendente:&nbsp;</b><b><b>Valor</b></b>: R$ " . $_ClassDinheiro->formataMoeda($trazParcelas->valor) . " <b>|</b> <b>Data</b>: " . $_ClassData->transformaData($trazParcelas->data, 2) . " <b>|</b> <b>Bco</b>: " . $trazParcelas->bco . " <b>|</b> <b>N. CH.</b>: " . $trazParcelas->numeroch . "<br />";
				
			}
			
		}
		
	}
	
	// Permissão
	$permissaoMate = true;
	
	// Busca Matérias
	$buscaMaterias = $_ClassMysql->query("SELECT * FROM `materias` WHERE curso = '" . $curso . "' AND deletado = 'N'");
	
	// Traz Matérias
	while($trazMaterias = mysql_fetch_object($buscaMaterias)){
		
		// Busca Notas dessa matrícula nessa matérias
		$buscaNotas = $_ClassMysql->query("SELECT * FROM `notas` WHERE matricula = '" . $matricula . "' AND materia = '" . $trazMaterias->id . "' AND nota != '' AND deletado = 'N'");
		
		// Verifica o total achado
		if(mysql_num_rows($buscaNotas) <= 0){
			
			// Permissão
			$permissaoMate = false;
			
			// Exibe Mensagem
			$mensagem .= "É necessário definir nota para este aluno na matéria: <b>" . $trazMaterias->materia . "</b><br />";
			
		}
		
	}
	
	// Verifica Inconsistências
	if(($totalFaltaDocumentos+$totalParcelas) == 0 && $permissao && $permissaoMate){
		
		// Exibe Mensagem
		$mensagem .= "Nenhuma Inconsistência.";
		
		// Retorna Mensagem
		return array(true, $mensagem);
		
	}else{
		
		// Retorna Mensagem
		return array(false, $mensagem);
		
	}
	
}

// Verifica ação
if($_REQUEST["act"] == "concluir"){
	
	// Contador
	$conta = 0;
	
	// Verifica a quantidade de registros
	if(count($_REQUEST["registros"]) > 0){
		
		// Lê registros
		for($k = 0; $k < count($_REQUEST["registros"]); $k++){
			
			// Pemissão
			$permissao = true;
			
			// Dados da Matrícula
			$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_REQUEST["registros"][$k] . "'");
			
			// Dados Alunos
			$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");
			
			// Inconsistências
			$inconsistencia = inconsistencias($dadosAluno, $dadosMatricula->id, $dadosCurso->id);
			
			// Verifica o total achado de falta de documentos
			if($inconsistencia[0]){
				
				// Contador
				$conta++;
				
				// Concluí Matrícula deste aluno
				$_ClassMysql->query("UPDATE `matriculas` SET reprovado = 'N', motivoreprovacao = '', concluido = 'S', ultimoeditou = '" . $_dadosLogado->id . "', datahorae = NOW() WHERE id = '" . $dadosMatricula->id . "'");
				
			}else{
			
				// Pende Matrícula deste aluno
				$_ClassMysql->query("UPDATE `matriculas` SET reprovado = 'N', motivoreprovacao = '', concluido = 'N', ultimoeditou = '" . $_dadosLogado->id . "', datahorae = NOW() WHERE id = '" . $dadosMatricula->id . "'");
				
			}
		
		}
		
	}
	
	// Busca Matrículas
	$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas`,`alunos` WHERE matriculas.unidade = '" . $_dadosUnidade->id . "' AND 
																					  matriculas.turma = '" . $_REQUEST["idTurma"] . "' AND 
																					  matriculas.deletado = 'N' AND
																					  alunos.id = matriculas.aluno AND
																				      alunos.deletado = 'N'");
	
	// Total Matriculas
	$totalMatriculas = mysql_num_rows($buscaMatriculas);
	
	// Busca Matrículas Concluídas
	$buscaMatriculasConcluidas = $_ClassMysql->query("SELECT * FROM `matriculas`,`alunos` WHERE matriculas.unidade = '" . $_dadosUnidade->id . "' AND 
																							    matriculas.turma = '" . $_REQUEST["idTurma"] . "' AND 
																							    matriculas.deletado = 'N' AND
																							    alunos.id = matriculas.aluno AND
																						        alunos.deletado = 'N' AND
																						        matriculas.concluido = 'N'");
	
	// Total Matriculas Concluídas
	$totalMatriculasConcluidas = mysql_num_rows($buscaMatriculasConcluidas);
	
	// Busca Matrículas Reprovadas
	$buscaMatriculasReprovadas = $_ClassMysql->query("SELECT * FROM `matriculas`,`alunos` WHERE matriculas.unidade = '" . $_dadosUnidade->id . "' AND 
																							    matriculas.turma = '" . $_REQUEST["idTurma"] . "' AND 
																							    matriculas.deletado = 'N' AND
																							    alunos.id = matriculas.aluno AND
																						        alunos.deletado = 'N' AND
																						        matriculas.reprovado = 'N'");
	
	// Total Matriculas Reprovadas
	$totalMatriculasReprovadas = mysql_num_rows($buscaMatriculasReprovadas);
	
	// Verifica o total achado
	if(($totalMatriculasConcluidas+$totalMatriculasReprovadas) == $totalMatriculas){
		
		// Conclui a turma
		$_ClassMysql->query("UPDATE `turmas` SET concluido = 'S', ultimoeditou = '" . $_dadosLogado->id . "', datahorae = NOW() WHERE id = '" . $_REQUEST["idTurma"] . "'");
		
	}
	
	// Redireicona
	print($_ClassUtilitarios->redirecionarJS("?idTurma=" . $_REQUEST["idTurma"], 3, array($conta . " matrícula(s) foi(ram) concluída(s) com sucesso!" . ((($totalMatriculasConcluidas+$totalMatriculasReprovadas) == $totalMatriculas)?" e a Turma foi Concluída.":""), $pathInc . "index.php?sessao=turmasativas")));
	
}elseif($_REQUEST["act"] == "reprovar"){
	
	// Contador 
	$cont = 0;
	
	// Verifica a quantidade de registros
	if(count($_REQUEST["regs"]) > 0){
		
		// Lê registros
		for($k = 0; $k < count($_REQUEST["regs"]); $k++){
			
			// Verifica se foi informado o texto
			if($_REQUEST["motivos"][$k] != ""){
			
				// Reprova matrículas
				$reprova = $_ClassMysql->query("UPDATE `matriculas` SET concluido = 'N', reprovado = 'S', motivoreprovacao = '" . $_ClassString->filtraTexto($_REQUEST["motivos"][$k]) . "', ultimoeditou = '" . $_dadosLogado->id . "', datahorae = NOW() WHERE id = '" . $_REQUEST["regs"][$k] . "'");
				
				// Se reprovou
				if($reprova){$cont++;}
				
			}
			
		}
		
		// Busca Matrículas
		$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $_REQUEST["idTurma"] . "' AND reprovado = 'N' AND concluido = 'N' AND deletado = 'N' GROUP BY aluno");
		
		// Verifica o total achado
		if(mysql_num_rows($buscaMatriculas) <= 0){
			
			// Conclui a turma
			$_ClassMysql->query("UPDATE `turmas` SET concluido = 'S', ultimoeditou = '" . $_dadosLogado->id . "', datahorae = NOW() WHERE id = '" . $_REQUEST["idTurma"] . "'");
			
		}
		
		// Redireicona
		print($_ClassUtilitarios->redirecionarJS("?idTurma=" . $_REQUEST["idTurma"], 3, array($cont . " matrícula(s) foi(ram) reprovada(s) com sucesso!" . ((mysql_num_rows($buscaMatriculas) <= 0)?" e a Turma foi Concluída.":""), $pathInc . "index.php?sessao=turmasativas")));
		
	}
	
}
?>
<html>
	<head>
		<?php require_once($pathInc . "includes/head.php"); ?>
	</head>
	
	<body>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="menu_topico" width="50%">Dados da Turma</td>
				<td width="50%" rowspan="4" align="right">
					<table border="0" cellpadding="2" cellspacing="2" align="right">
						<?php
						// Verifica Sessão
						if($_REQUEST["sessao"] != "reprovar"){
							?>
							<tr>
								<td align='left'><div class="caixaIcone"><a href="<?php print($pathInc);?>modulos/manutencao/_/_turmasativas.imprimir.php?idTurma=<?php print($_REQUEST["idTurma"]);?>" target="_blank"><img src="<?php print($pathInc);?>modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Imprimir</a><div></td>
								<td align='left'><div class="caixaIcone"><a href="#" onclick="document.formTurma.sessao.value = 'reprovar';document.formTurma.act.value = '';document.formTurma.submit();"><img src="<?php print($pathInc);?>modulos/sistema/img.php?img=../../imagens/icones/00047.png&l=50&a=50" border="0"><br>Reprovar</a><div></td>
								<td align='left'><div class="caixaIcone"><a href="#" onclick="subForm1(document.formTurma, '', '_self', 'Deseja mesmo concluir este(s) aluno(s)?');"><img src="<?php print($pathInc);?>modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Concluir</a><div></td>
							</tr>
							<?php
						}else{
							?>
							<tr>
								<td align='left'><div class="caixaIcone"><a href="?idTurma=<?php print($_REQUEST["idTurma"]);?>"><img src="<?php print($pathInc);?>modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Voltar</a><div></td>
								<td align='left'><div class="caixaIcone"><a href="#" onclick="subForm1(document.formTurma, '', '_self', 'Deseja mesmo reprovar este(s) aluno(s)?');"><img src="<?php print($pathInc);?>modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a><div></td>
							</tr>
							<?php
						}
						?>
					</table>
				</td>
			</tr>
			<tr>
				<td align='left'>
					<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
						<tr>
							<td width="15%" align="right"><b>Turma:</b></td>
							<td width='85%' align='left'><?php print($dadosCurso->sigla . $dadosTurma->numero);?></td>
						</tr>
						<tr>
							<td align="right"><b>Turno:</b></td>
							<td align='left'><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof);?></td>
						</tr>
					</table>
				</td>
			</tr>
			<?php
			// Verifica Sessão
			switch ($_REQUEST["sessao"]){
				
				// Caso for reprovar alunos
				case "reprovar":
					
					?>
					<tr>
						<td class="menu_topico">Listagem dos alunos Reprovados</td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td colspan="2">
							<?php
							// Verifica total de registros informados
							if(count($_REQUEST["registros"]) > 0){
								?>
								<form action="" method="POST" name="formTurma">
									<input type="hidden" name="act" value="reprovar">
									<?php
									
									// Lê Alunos
									for($i = 0; $i < count($_REQUEST["registros"]); $i++){
										
										// Dados da Matrícula
										$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_REQUEST["registros"][$i] . "'");
										
										// Dados do Aluno
										$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");
										?>
										<input type="hidden" name="regs[]" value="<?php print($_REQUEST["registros"][$i]);?>">
										<fieldset>
											<legend><?php print($dadosAluno->nome . " (" . $_ClassUtilitarios->formataCPF($dadosAluno->cpf) . ") <img src=\"" . $pathInc . "imagens/diversos/" . (($dadosMatricula->concluido == "S")?"S":(($dadosMatricula->reprovado == "S")?"X":"N")) . ".png\">");?></legend>
											<table border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td align='left'>
														<textarea rows="5" name="motivos[]" style="width:100%;">
															<?php
															print("\r\n");
															// Verifica Motivo da Reprovação
															if($dadosMatricula->motivoreprovacao != ""){
																
																print($dadosMatricula->motivoreprovacao);
																
															}else{
																
																// Inconsistências
																$inconsistencia = inconsistencias($dadosAluno, $dadosMatricula->id, $dadosCurso->id);
															
																// Exibe Inconsistências
																print ($inconsistencia[1]);
																
															}
															?>
														</textarea>
													</td>
												</tr>
											</table>
										</fieldset>
										<?php
										
									}
									
									?>
								</form>
								<?php
								
							}else{
								
								// Redireciona
								print($_ClassUtilitarios->redirecionarJS("?idTurma=" . $_REQUEST["idTurma"], 1, array("Nenhum aluno informado.")));
								
							}
							?>
						</td>
					</tr>
					<?php
					
				break;
				
				// Default
				default:
					?>
					<tr>
						<td class="menu_topico">Listagem das Inconsistências</td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'>
							<img src="<?php print($pathInc);?>imagens/diversos/S.png" border="0"> Concluído |
							<img src="<?php print($pathInc);?>imagens/diversos/N.png" border="0"> Pendente |
							<img src="<?php print($pathInc);?>imagens/diversos/X.png" border="0"> Reprovado
							<br><br>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<form action="" method="POST" name="formTurma">
								<input type="hidden" name="sessao" value="">
								<input type="hidden" name="act" value="concluir">
								<?php
								// Busca Matrículas
								$buscaMatriculas = $_ClassMysql->query("SELECT matriculas.aluno, 
																			   matriculas.id, 
																			   matriculas.concluido,
																			   matriculas.reprovado FROM `matriculas`, `alunos` WHERE matriculas.unidade = '" . $_dadosUnidade->id . "' AND 
																																      matriculas.turma = '" . $_REQUEST["idTurma"] . "' AND 
																																      alunos.id = matriculas.aluno AND
																																      alunos.deletado = 'N' AND
																																      matriculas.deletado = 'N' GROUP BY matriculas.aluno ORDER BY alunos.nome");
								
								// Verifica o total encontrado
								if(mysql_num_rows($buscaMatriculas) > 0) {
									
									?>
									<input type="checkbox" onclick="select_all('formTurma', 'registros[]')" style="margin-left:16px;"> Selecionar Todos<Br><br>
									<?php
									
									// Traz Matrículas
									while ($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
										
										// Pemissão
										$permissao = true;
										
										// Dados do Aluno
										$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");
										?>
										<fieldset>
											<legend><input type="checkbox" name="registros[]" value="<?php print($trazMatriculas->id);?>"><?php print($dadosAluno->nome . " (" . $_ClassUtilitarios->formataCPF($dadosAluno->cpf) . ") <img src=\"" . $pathInc . "imagens/diversos/" . (($trazMatriculas->concluido == "S")?"S":(($trazMatriculas->reprovado == "S")?"X":"N")) . ".png\">");?></legend>
											<table border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td>
														<?php
														// Inconsistências
														$inconsistencia = inconsistencias($dadosAluno, $trazMatriculas->id, $dadosCurso->id);
														
														// Exibe Inconsistências
														print ($inconsistencia[1]);
														?>
													</td>
												</tr>
											</table>
										</fieldset>
										<?php
									}
									
								}else{
													
									// Exibe Mensagem
									print("Nenhum aluno encontrado.");
									
								}
								?>
							</form>
						</td>
					</tr>
					<?php
				
			}
			?>
			<tr>
				<td align='left'>
				</td>
			</tr>
		</table>
	</body>
</html>