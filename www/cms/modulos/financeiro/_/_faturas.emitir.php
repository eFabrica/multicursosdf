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

// Dados da Unidade
$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N' AND acesso = 'L'");

// Cidade Unidade
$cidadeUnidade = $_ClassRn->getDadosTable("cidades", "*", "id = '" . $dadosUnidade->cidade . "'");
	
// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");

?>
<html>
	<head>
		<title>Faturas</title>
		<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
		<?php
		// Verifica se foi informado algum período
		if($_ClassData->validaData($_REQUEST["dataI"]) && $_ClassData->validaData($_REQUEST["dataF"]) && $_REQUEST["empresa"] > 0){
			?>
			<table width="700" border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td align="left"><img src="<?php print($pathInc);?>imagens/diversos/logo.jpg"></td>
					<td width="100%">
						<h3>
						<?php print($dadosUnidade->razaosocial);?> - <?php print($dadosUnidade->nomefantasia);?><br />
						<?php print($dadosUnidade->endereco);?> - <?php print($cidadeUnidade->cidade);?> - <?php print($dadosUnidade->estado);?><br />
						Fone: <?php print($dadosUnidade->telefonefixo);?> - CNPJ: <?php print($_ClassUtilitarios->formataCNPJ($dadosUnidade->cnpj));?>
						</h3>	
					</td>
				</tr>
			</table>
			<table width="99%" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td align="center">
						<h2><u>Faturas</u></h2>
						<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
					</td>
				</tr>
				<tr>
					<td align="left"><h2>Filtrando por:</h2></td>
				</tr>
				<tr>
					<td align="left"><ol><strong>Data:</strong>&nbsp;De <?php echo $_REQUEST["dataI"]?> até <?php echo $_REQUEST["dataF"]?></ol></td>
				</tr>
				<tr>
					<td align="left">
					<ol><strong>Empresa:</strong>&nbsp;
					<?php
					// Dados da Empresa
					$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $_REQUEST["empresa"] . "'");
					
					// Exibe empresa
					print($dadosEmpresa->razaosocial);
					?>
					</td>
				</tr>
			</table>
			<br><br>
			<?php
			// Busca Turmas que tenham matrículas da empresa selecionada
			$buscaTurmas = $_ClassMysql->query("SELECT turmas.id,
													   turmas.numero,
													   turmas.curso,
													   turmas.datainicio,
													   turmas.datatermino FROM `turmas`, `matriculas` WHERE    turmas.deletado = 'N' AND
																											   matriculas.deletado = 'N' AND
																											   turmas.id = matriculas.turma AND
																											   matriculas.empresa = '" . $_REQUEST["empresa"] . "' AND
																											   turmas.datainicio >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND turmas.datainicio <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' GROUP BY curso,numero");
			
			// Verifica o total achado
			if(mysql_num_rows($buscaTurmas) > 0){
			
				// Traz Turmas
				while($trazTurmas = mysql_fetch_object($buscaTurmas)){
					
					// Busca Matrículas
					$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE deletado = 'N' AND
																							 empresa = '" . $_REQUEST["empresa"] . "' AND
																							 turma = '" . $trazTurmas->id . "'");
					
					// Traz Matrículas
					while($trazMatriculas = mysql_fetch_object($buscaMatriculas)) for($w = 0; $w < count($_REQUEST["registros"]); $w++) if($_REQUEST["registros"][$w] == $trazMatriculas->id) ++$totalturmaTemp[$trazTurmas->id];
					
					// Verifica o total achado
					if ($totalturmaTemp[$trazTurmas->id] > 0){
					
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $trazTurmas->curso . "'");
						?>
						<fieldset>
							<legend><b><?php print($dadosCurso->sigla . $trazTurmas->numero . " (" . $_ClassData->transformaData($trazTurmas->datainicio, 2) . " - " . $_ClassData->transformaData($trazTurmas->datatermino, 2) . ")");?></b></legend>
							<table width="100%" border="0" cellspacing="2" cellpadding="2">
								<tr>
									<td align="center" width="70%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Nome</b></td>
									<td align="center" width="30%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>CPF</b></td>
								</tr>
								<?php
								// Ordena Array
								$_REQUEST["registros"][count($_REQUEST["registros"])+1] = $_REQUEST["registros"][0];
								$_REQUEST["registros"][0] = 0;
								
								// Busca Matrículas
								$buscaMatriculas = $_ClassMysql->query("SELECT
                                                                            m.*,
                                                                            a.nome,
                                                                            a.cpf
                                                                        FROM
                                                                            `matriculas` m ,
                                                                            `alunos` a
                                                                        WHERE
                                                                            m.deletado  = 'N' AND
                                                                            m.empresa   = '" . $_REQUEST["empresa"] . "' AND
                                                                            m.turma     = '" . $trazTurmas->id . "' AND
                                                                            a.id        = m.aluno
                                                                        ORDER BY a.nome ASC");
								
								// Traz Matrículas
								while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
									
									// Verifica se a matrícula foi selecionada
									if(array_search($trazMatriculas->id, $_REQUEST["registros"]) != false){
									
										// Total Da Turma
										++$totalTurma[$trazTurmas->id];
										
										// Total do Curso
										++$totalCurso[$dadosCurso->id];
										
										// Total Geral
										++$totalGeral;

                                        // Insere faturamento
                                        $_ClassMysql->query("INSERT INTO `faturas` SET matricula = '" . $trazMatriculas->id . "', datahorac = now()");
										?>
										<tr>
											<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;"">&nbsp;<?php print($trazMatriculas->nome);?></td>
											<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;<?php print($_ClassUtilitarios->formataCPF($trazMatriculas->cpf));?></td>
										</tr>
										<?php
										
									}
									
								}
								?>
								<tr>
									<td align="right" colspan="5"><h2 style="margin:0px;"><b>Total de Alunos:</b> <?php print($totalTurma[$trazTurmas->id]);?></h2></td>
								</tr>
							</table>
						</fieldset>
						<br><Br>
						<?php
					}
					
				}
				
			}
			?>
			<table width="100%" border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td colspan="2"><h2>Total por curso: </h2></td>
				</tr>
				<?php
				// Busca Cursos
				$buscaCursos = $_ClassMysql->query("SELECT cursos.id, 
														   cursos.nome FROM `turmas`, `matriculas`, `cursos` WHERE turmas.deletado = 'N' AND
																												   matriculas.deletado = 'N' AND
																												   cursos.deletado = 'N' AND
																												   turmas.id = matriculas.turma AND
																												   cursos.id = turmas.curso AND
																												   matriculas.empresa = '" . $_REQUEST["empresa"] . "' AND
																												   turmas.datainicio >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND turmas.datainicio <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' GROUP BY cursos.id");
				
				// Traz Cursos
				while ($trazCursos = mysql_fetch_object($buscaCursos)){
					
					?>
					<tr>
						<td align="left">&nbsp;&nbsp;&nbsp;&nbsp;<b><?php print(str_replace(" ", "&nbsp;", $trazCursos->nome));?>: </b></td>
						<td width="100%"><?php print((($totalCurso[$trazCursos->id] < 10)?"0".$totalCurso[$trazCursos->id]:$totalCurso[$trazCursos->id]));?> Aluno(s)</td>
					</tr>
					<?php
					
				}
				?>
				<tr>
					<td align="right"><b>Total Geral: </b></td>
					<td align="left"><?php print($totalGeral);?> Aluno(s)</td>
				</tr>
			</table>
			<br><br>
			<center>
				Seguem Nota Fiscal nº _________ e Boleto Bancário Venc ___/___/_______<br><br>
				<br><br><br>
				_________________________________________________
				<br>
				<input type="text" value="Gelbis de Souza Junior" class="nda" style="text-align:center;"><br /><input type="text" value="Diretor" class="nda" style="text-align:center;">
			</center>
			<?php
			
		}else{
			
			// Erro
			print("É necessário informar os dados corretamente!");
			
		}
		?>
	</body>
</html>