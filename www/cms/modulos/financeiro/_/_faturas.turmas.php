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
				<td class="menu_topico">Dados da Fatura - Turmas</td>
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
				<td align="left">
					<table class="consulta" cellspacing="1" align="center">
						<thead>
							<tr>
								<th width="1%">#</th>										
								<th width="30%">Sigla/Turma</th>
								<th width="15%">Turno</th>
								<th width="15%">Vagas</th>
								<th width="15%">Vagas&nbsp;Restantes</th>
								<th width="15%">Data&nbsp;Início</th>
								<th width="15%">Data&nbsp;Término</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// Verifica se tem o id da fatura
							if($_REQUEST["idFatura"] <= 0){
										
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
											
											// Dados do Curso
											$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazTurmas->curso . "'");
						
											// Dados do Turno
											$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $trazTurmas->turno . "'");
											?>
											<tr class=row0>
												<td align="left"><?php print($trazTurmas->id); ?></td>
												<td align="center"><?php print($dadosCurso->sigla . $trazTurmas->numero);?></td>
												<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
												<td align="center"><?php print($trazTurmas->vagas);?></td>
												<td align="center"><?php print($trazTurmas->vagas-$trazTurmas->vagasocupadas);?></td>
												<td align="center"><?php print($_ClassData->transformaData($trazTurmas->datainicio, 2));?></td>
												<td align="center"><?php print($_ClassData->transformaData($trazTurmas->datatermino, 2));?></td>
											</tr>
											<?php
											// Contador
											$cont++;
											
										}
										
									}
									
								}elseif(mysql_num_rows($buscaTurmas) <= 0 || $cont = 0){
									
									?>
									<tr>
										<td align="center" colspan="7"><b>Nenhum resultado encontradob.</b></td>
									</tr>
									<?php
									
								}
								
							}else{
								
								// Busca Matrículas
								$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE fatura = '" . $_REQUEST["idFatura"] . "' GROUP BY turma");
								
								// Verifica o total achado
								if(mysql_num_rows($buscaMatriculas) > 0){
									
									// Traz Matrículas
									while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
									
										// Dados da Turma
										$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $trazMatriculas->turma . "'");
										
										// Dados do Curso
										$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
					
										// Dados do Turno
										$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
										?>
										<tr class=row0>
											<td align="left"><?php print($dadosTurma->id); ?></td>
											<td align="center"><?php print($dadosCurso->sigla . $dadosTurma->numero);?></td>
											<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
											<td align="center"><?php print($dadosTurma->vagas);?></td>
											<td align="center"><?php print($dadosTurma->vagas-$dadosTurma->vagasocupadas);?></td>
											<td align="center"><?php print($_ClassData->transformaData($dadosTurma->datainicio, 2));?></td>
											<td align="center"><?php print($_ClassData->transformaData($dadosTurma->datatermino, 2));?></td>
										</tr>
										<?php
										// Contador
										$cont++;
										
									}
									
								}else{
									
									?>
									<tr>
										<td align="center" colspan="7"><b>Nenhum resultado encontradob.</b></td>
									</tr>
									<?php
									
								}
								
							}
							?>
						</tbody>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>