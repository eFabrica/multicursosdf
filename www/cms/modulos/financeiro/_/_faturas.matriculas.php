<?php require_once("php7_mysql_shim.php");
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

// Verifica se tem o id da fatura
if($_REQUEST["idFatura"] > 0){
	
	// Dados da Fatura
	$dadosFatura = $_ClassRn->getDadosTable("faturas", "*", "id = '" . $_REQUEST["idFatura"] . "'");
	
	// Id da Empresa
	$idEmpresa = $dadosFatura->empresa;
	
	// Data Inicial
	$dataI = $_ClassData->transformaData($dadosFatura->datai, 2);
	
	// Data Final
	$dataF = $_ClassData->transformaData($dadosFatura->dataf, 2);
	
}else{
	
	// Id da Empresa
	$idEmpresa = $_REQUEST["empresa"];
	
	// Data Inicial
	$dataI = $_REQUEST["datai"];
	
	// Data Final
	$dataF = $_REQUEST["dataf"];
	
}

// Dados da Empresa
$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $idEmpresa . "'");
?>
<html>
	<head>
		<?php require_once($pathInc . "includes/head.php"); ?>
	</head>
	
	<body>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="menu_topico">Dados da Fatura - Matrículas</td>
				<td align="center" rowspan="3" align="right"><div class="caixaIcone"><a href="<?php print($pathInc . "modulos/financeiro/_/_faturas.matriculas.imprimir.php?idFatura=" . $_REQUEST["idFatura"] . "&empresa=" . $_REQUEST["empresa"] . "&datai=" . $_REQUEST["datai"] . "&dataf=" . $_REQUEST["dataf"]);?>" target="_blank"><img src="<?php print($pathInc);?>modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Imprimir</a></div></td>
			</tr>
			<tr>
				<td style='height:5px';>&nbsp;</td>
			</tr>
			<tr>
				<td align="left">
					<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
						<tr>
							<td width="15%" align="right"><strong>Data:</strong></td>
							<td width='85%' align='left'>
								De <?php print($dataI);?>
						  		até <?php print($dataF);?>
							</td>
						</tr>
						<tr>
							<td align="right"><b>Empresa:</b></td>
							<td align="left">
								<?php
								// Dados da Empresa
								$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $idEmpresa . "'");
								
								// Exibe nome da empresa
								print($dadosEmpresa->razaosocial . " (" . $_ClassUtilitarios->formataCNPJ($dadosEmpresa->cnpj) . ")");
								?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style='height:5px';>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2">
					<table class="consulta" cellspacing="1" align="center">
						<thead>
							<tr>
								<th width="1%">#</th>
								<th width="40%">Aluno</th>
								<th width="25%">Curso/Turma</th>
								<th width="15%">Turno</th>
								<th width="15%">Valor</th>
								<th width="5%">Concluído</th>
							</tr>
						</thead>
						<tbody>
							<?php	
							// Verifica se tem o id da fatura
							if($_REQUEST["idFatura"] == ""){
								
								// Busca Turmas
								$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND datainicio >= '" . $_ClassData->transformaData($dataI) . "' AND datainicio <= '" . $_ClassData->transformaData($dataF) . "' AND deletado = 'N'");
								
								// Verifica o total achado
								if(mysql_num_rows($buscaTurmas) > 0){
									
									// Contador
									$cont = 0;
									
									// Traz Turmas
									while($trazTurmas = mysql_fetch_object($buscaTurmas)){
									
										// Busca Matrículas
										$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE unidade = '" . $_dadosUnidade->id . "' AND empresa = '" . $idEmpresa . "' AND turma = '" . $trazTurmas->id . "' AND fatura = '0' AND deletado = 'N'");
										
										// Verifica o total achado
										if(mysql_num_rows($buscaMatriculas) > 0){
											
											// Traz Matrículas
											while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
											
												// Dados da Turma
												$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $trazMatriculas->turma . "'");
												
												// Dados do Curso
												$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
							
												// Dados do Turno
												$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
							
												// Dados da Matéria
												$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazMatriculas->materia . "'");
												
												// Dados do Aluno
												$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");
												
												// Total De matrículas
												$totMatriculas += $trazMatriculas->valor_dinheiro;
												?>
												<tr class=row0>
													<td align="left"><?php print($trazMatriculas->id); ?>.</td>
													<td align="center"><a name="<?=$trazMatriculas->id?>"></a><?php print($dadosAluno->nome);?></td>
													<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
													<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
													<td align="right">R$ <?php print($_ClassDinheiro->formataMoeda($trazMatriculas->valor_dinheiro)); ?></td>
													<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print((($trazMatriculas->concluido == "S")?"S":(($trazMatriculas->reprovado == "S")?"X":"N")));?>.png"></td>
												</tr>
												<?php
												// Contador
												$cont++;
												
											}
											
										}
										
									}
									
								}elseif(mysql_num_rows($buscaTurmas) <= 0 || $cont = 0){
									
									?>
									<tr>
										<td align="center" colspan="7"><b>Nenhum resultado encontrado.</b></td>
									</tr>
									<?php
									
								}
							
							}else{
								
								// Busca Matrículas
								$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE fatura = '" . $_REQUEST["idFatura"] . "'");
								
								// Verifica o total achado
								if(mysql_num_rows($buscaMatriculas) > 0){
									
									// Traz Matrículas
									while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
									
										// Dados da Turma
										$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $trazMatriculas->turma . "'");
										
										// Dados do Curso
										$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
					
										// Dados do Turno
										$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
					
										// Dados da Matéria
										$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazMatriculas->materia . "'");
										
										// Dados do Aluno
										$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");
										
										// Total De matrículas
										$totMatriculas += $trazMatriculas->valor_dinheiro;
										?>
										<tr class=row0>
											<td align="left"><?php print($trazMatriculas->id); ?>.</td>
											<td align="center"><a name="<?=$trazMatriculas->id?>"></a><?php print($dadosAluno->nome);?></td>
											<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
											<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
											<td align="right">R$ <?php print($_ClassDinheiro->formataMoeda($trazMatriculas->valor_dinheiro)); ?></td>
											<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print((($trazMatriculas->concluido == "S")?"S":(($trazMatriculas->reprovado == "S")?"X":"N")));?>.png"></td>
										</tr>
										<?php
										// Contador
										$cont++;
										
									}
									
								}
								
							}
							?>
						</tbody>
						<tfoot>
							<td colspan="7" align="right"><h3 style="margin:0px;">Total: R$ <?php print($_ClassDinheiro->formataMoeda($totMatriculas));?></h3></td>
						</tfoot>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>