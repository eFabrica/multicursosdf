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

/* Construindo sql */
$sql = "SELECT matriculas.id,
		   matriculas.turma,
		   matriculas.aluno,
		   matriculas.concluido,
		   matriculas.empresa,
		   matriculas.numero FROM `matriculas`,`alunos`" . (($_dadosLogado->nivel == "95")?", `gradehoraria`":"");
$sql .= " WHERE ";
if($_SESSION["consultaNotas"]["todas"] != "sim"){
	
	$sql1 = (($_SESSION["consultaNotas"]["habilitarTurma"] == "sim")?(($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . " alunos.id = matriculas.aluno AND alunos.deletado = 'N' AND matriculas.deletado = 'N' AND matriculas.turma = '" . $_SESSION["consultaNotas"]["turma"] . "' AND":"");
	$sql2 = (($_SESSION["consultaNotas"]["habilitartexto"] == "sim")? $sql1 . (($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . " alunos.id = matriculas.aluno AND alunos.rg LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND alunos.deletado = 'N' AND matriculas.deletado = 'N' OR
																	    " . $sql1 . (($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . " alunos.id = matriculas.aluno AND alunos.cpf LIKE '%" . $_ClassUtilitarios->deixaN($_SESSION["consultaNotas"]["texto"]) . "%' AND alunos.deletado = 'N' AND matriculas.deletado = 'N' OR
																	 	" . $sql1 . (($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . " alunos.id = matriculas.aluno AND alunos.nome LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND alunos.deletado = 'N' AND matriculas.deletado = 'N'  
																	 	" . (($_SESSION["consultaNotas"]["texto"] > 0)?" OR " . $sql1 . (($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . " alunos.id = matriculas.aluno AND alunos.deletado = 'N' AND matriculas.numero = '" . $_SESSION["consultaNotas"]["texto"] . "' AND matriculas.deletado = 'N' AND ":" AND "):"");
	
	//$sql .= (($_POST["habilitar"] == "sim")?"":"");
}else{
	
	$sql .= (($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . "alunos.id = matriculas.aluno AND alunos.deletado = 'N' AND matriculas.deletado = 'N' AND ";
	
}
$sql .= (($sql1 != "" && $sql2 != "")?$sql2:(($sql1 != "" && $sql2 == "")?$sql1:(($sql1 == "" && $sql2 != "")?$sql2:"")));
$sql .= "{aqui}";
$sql = str_replace("AND {aqui}", "", $sql);
$sql = str_replace("AND{aqui}", "", $sql);
$sql = str_replace("{aqui}", "", $sql);
$sql .= " ORDER BY alunos.nome";

// Busca Matrículas
$buscaMatriculas = $_ClassMysql->query($sql);

// Traz Matrículas
while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){$matriculas[] = $trazMatriculas->id;}

// Verifica Contador
if($_REQUEST["cont"] != ""){
	
	// Contador
	$contador = $_REQUEST["cont"];
	
}else{
	
	// Lê Matrículas 
	while ($lendoMatricula = current($matriculas)) { 
		
		// Verifica Atual
		if ($lendoMatricula == $_REQUEST["idMatricula"]) { $contador = key($matriculas); } 
		
		// Avança ponteiro do arrau
		next($matriculas);
		 
	} 
	
}

// Dados da Matrícula
$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . (($_REQUEST["cont"] != "")?$matriculas[$contador]:$_REQUEST["idMatricula"]) . "'");

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "id, sigla", "id = '" . $dadosTurma->curso . "'");

// Dados do Turno
$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");

// Dados da Matéria
$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $dadosMatricula->materia . "'");

// Dados do Aluno
$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");

// Verifica Ação
if($_REQUEST["act"] == "salvar"){

	// Atualiza Media Final editavel da matricula
	$mediaFinalInput = trim($_REQUEST["mediafinal"]);
	$mediaFinalSql   = ($mediaFinalInput === "") ? "NULL" : "'" . mysql_real_escape_string($mediaFinalInput) . "'";
	$_ClassMysql->query("UPDATE `matriculas` SET mediafinal = " . $mediaFinalSql . " WHERE id = '" . $dadosMatricula->id . "'");

	// Busca Matérias
	$buscaMaterias = $_ClassMysql->query("SELECT * FROM `materias` WHERE unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $dadosCurso->id . "' AND deletado = 'N'");
	
	// Verifica total achado
	if(mysql_num_rows($buscaMaterias) > 0){
        
		// Traz Matérias
		while ($trazMaterias = mysql_fetch_object($buscaMaterias)) {			
			
			// Dados das Notas
			$dadosNotas = $_ClassRn->getDadosTable("notas", "id, nota", "matricula = '" . $dadosMatricula->id . "' AND materia = '" . $trazMaterias->id . "'");
			
			// Verifica se tem nota
			if($_ClassRn->getTot() > 0){
				
				// Edita Nota
				$_ClassMysql->query("UPDATE `notas` SET nota            = '" . $_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)] . "',
                                                        ultimoeditou    = '" . $_dadosLogado->id . "',
                                                        datahorae       = NOW() WHERE id = '" . $dadosNotas->id . "'");
				
			}else{
				
				// Verifica se foi informado algo
				if($_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)] != ""){
                    
					// Cadastra Nota
					$_ClassMysql->query("INSERT INTO `notas` SET  matricula     = '" . $dadosMatricula->id . "',
                                                                  materia       = '" . $trazMaterias->id . "',
                                                                  nota          = '" . $_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)] . "',
                                                                  quemcriou     = '" . $_dadosLogado->id . "',
                                                                  datahorac     = NOW()");
				}
				
			}
			
		}
		
		// Redireciona
		print($_ClassUtilitarios->redirecionarJS("?idMatricula=" . $_REQUEST["idMatricula"] . "&cont=" . ($_REQUEST["cont"]+1), 1, array("Notas Atualizadas com sucesso!")));
		
	}
	
}
?>
<html>
	<head>
		<?php require_once($pathInc . "includes/head.php"); ?>
	</head>
	
	<body>
		<form action="" method="POST" name="notasListagem">
			<input type="hidden" name="act" value="salvar">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align='left'><a href="?idMatricula=<?php print($_REQUEST["idMatricula"]);?>&cont=<?php print((($matriculas[($contador-1)] > 0)?($contador-1):0)); ?>"><img src="<?php print($pathInc . "imagens/icones/b_anterior.png");?>" border="0"></a></td>
					<td width="100%"></td>
					<td align="right"><a href="?idMatricula=<?php print($_REQUEST["idMatricula"]);?>&cont=<?php print((($matriculas[($contador+1)] > 0)?($contador+1):$contador)); ?>"><img src="<?php print($pathInc . "imagens/icones/b_proximo.png");?>" border="0"></a></td>
				</tr>
				<tr>
					<td colspan="3" class="menu_topico">Dados da Matrícula</td>
				</tr>
				<tr>
					<td colspan="3">
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
					<td colspan="3" class="menu_topico">Matérias</td>
				</tr>
				<?php
				// Contador
				$cont = 0;
				
				// Busca Matérias
				$buscaMaterias = $_ClassMysql->query("SELECT * FROM `materias` WHERE unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $dadosCurso->id . "' AND deletado = 'N'");
				
				// Verifica total achado
				if(mysql_num_rows($buscaMaterias) > 0){
				
					// Traz Matérias
					while ($trazMaterias = mysql_fetch_object($buscaMaterias)) {
						
						// Verifica nível
						if($_dadosLogado->nivel != "95"){
							
							// Dados das Notas
							$dadosNotas = $_ClassRn->getDadosTable("notas", "*", "matricula = '" . $dadosMatricula->id . "' AND materia = '" . $trazMaterias->id . "' AND deletado = 'N'");
							?>
							<tr>
								<td colspan="3">
									<table width="100%" border="0" cellpadding="0" cellspacing="2">
										<?php
										if($cont == 0){
											?>
											<tr>
												<td colspan="2" align="right">
													Criado por:
													<?php
													// Dados do Criador
													$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosNotas->quemcriou . "'");
													
													// Mostra
													print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosNotas->datahorac, 3) . "</b>");
													
													// Verifica se alguem edtou
													if($dadosAluno->ultimoeditou > 0){
														
														?>
														<br>última edição feita por:
														<?php
														// Dados do Alterador
														$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosNotas->ultimoeditou . "'");
														
														// Mostra
														print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosNotas->datahorae, 3) . "</b>");
														
													}
													?>
												</td>
											</tr>
											<?php
										}
										?>
										<tr>
											<td align="right" width="15%"><b>Matéria:</b></td>
											<td align='left'><?php print($trazMaterias->materia);?></td>
										</tr>
										<tr>
											<td align="right"><b>Nota:</b></td>
											<td align='left'>
												<?php
												// Verifica se a turma já foi concluida
												if($dadosTurma->concluido == 'N'){
													?>
													<input type="text" size="10" name="nota_<?php print(str_replace(" ", "_", $trazMaterias->sigla));?>" value="<?php print((($_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)] != "")?$_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)]:(($dadosNotas->nota != "")?$dadosNotas->nota:"---")));?>">
													<?php
												}else{
													print((($_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)] != "")?$_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)]:$dadosNotas->nota));
												}
												?>
											</td>
										</tr>
										<tr>
											<td colspan="2"><hr noshade style="border-bottom:0px;"></td>
										</tr>
									</table>
								</td>
							</tr>
							<?php
							// Incrementa contador
							$cont++;
							
						}else{
						
							// Busca grade horária
							$buscaGradeHoraria = $_ClassMysql->query("SELECT id FROM `gradehoraria` WHERE unidade = '" . $_dadosUnidade->id . "' AND materia = '" . $trazMaterias->id . "' AND instrutor = '" . $_dadosLogado->id . "' AND deletado = 'N'");
							
							// Verifica o total achado
							if(mysql_num_rows($buscaGradeHoraria) > 0){
							
								// Dados das Notas
								$dadosNotas = $_ClassRn->getDadosTable("notas", "nota", "matricula = '" . $dadosMatricula->id . "' AND materia = '" . $trazMaterias->id . "' AND deletado = 'N'");
								?>
								<tr>
									<td colspan="3">
										<table width="100%" border="0" cellpadding="0" cellspacing="2">
											<tr>
												<td align="right" width="15%"><b>Matéria:</b></td>
												<td align='left'><?php print($trazMaterias->materia);?></td>
											</tr>
											<tr>
												<td align="right"><b>Nota:</b></td>
												<td align='left'>
													<?php
													// Verifica se a turma já foi concluida
													if($dadosTurma->concluido == 'N'){
														?>
														<input type="text" size="10" name="nota_<?php print(str_replace(" ", "_", $trazMaterias->sigla));?>" value="<?php print((($_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)] != "")?$_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)]:$dadosNotas->nota));?>"></td>
														<?php
													}else{
														print((($_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)] != "")?$_REQUEST["nota_" . str_replace(" ", "_", $trazMaterias->sigla)]:$dadosNotas->nota));
													}
													?>
											</tr>
											<tr>
												<td colspan="2"><hr noshade style="border-bottom:0px;"></td>
											</tr>
										</table>
									</td>
								</tr>
								<?php
								// Incrementa contador
								$cont++;
								
							}
							
						}
						
					}
					
					// Verifica o contador
					if($cont > 0){

						// Media Final editavel (sobrescreve o calculo automatico quando preenchida)
						?>
						<tr>
							<td colspan="3" class="menu_topico">M&eacute;dia Final</td>
						</tr>
						<tr>
							<td colspan="3">
								<table width="100%" border="0" cellpadding="0" cellspacing="2">
									<tr>
										<td align="right" width="15%"><b>M&eacute;dia Final:</b></td>
										<td align='left'>
											<?php
											// Mostra valor salvo; se turma nao concluida, deixa editavel
											$valorMediaFinal = ($_REQUEST["mediafinal"] != "") ? $_REQUEST["mediafinal"] : $dadosMatricula->mediafinal;
											if($dadosTurma->concluido == 'N'){
												?>
												<input type="text" size="10" name="mediafinal" value="<?php print(htmlspecialchars($valorMediaFinal));?>">
												<span style="color:#666;font-size:11px;">&nbsp;Opcional. Se vazia, o certificado usa a m&eacute;dia calculada automaticamente.</span>
												<?php
											}else{
												print(($valorMediaFinal != "") ? htmlspecialchars($valorMediaFinal) : "---");
											}
											?>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<?php

						// Verifica se foi concluida
						if($dadosTurma->concluido == 'N'){
							?>
							<tr>
								<td colspan="3"><?php print($_ClassUtilitarios->criaMenu("Salvar", "#", "document.notasListagem.submit();", "esq", "007", $pathInc)); ?></td>
							</tr>
							<?php
						}
						
					}else{
						
						?>
						<tr>
							<td colspan="3"><br></td>
						</tr>
						<tr>
							<td colspan="3" align="center">Nenhuma matéria encontrada.</td>
						</tr>
						<?php
						
					}
					
				}else{
					
					?>
					<tr>
						<td colspan="3"><br></td>
					</tr>
					<tr>
						<td colspan="3" align="center">Nenhuma matéria encontrada.</td>
					</tr>
					<?php
					
				}
				?>
				<tr>
					<td align='left'>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>