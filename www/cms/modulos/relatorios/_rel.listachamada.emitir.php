<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Inicia Sess„o
session_start();

// Caminho da Pasta Raiz
$pathInc = '../../';

// Arquivo de ConfiguraÁıes
require_once($pathInc . "inc/config.inc.php");

# Dados de Logado
	
	// Verifica se est· logado
	if($_SESSION["dadosLogin"]["idLogado"] > 0){

		// Dados do Logado
		$_dadosLogado = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Dados da Unidade
		$_dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N'");
	
	}

// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");

// Dados da Unidade
$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N' AND acesso = 'L'");

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_REQUEST["turma"] . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");

// Dados do Turno
$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
?>
<html>
	<head>
		<title>Lista de Chamada - Turma: <?php print($dadosCurso->sigla . $dadosTurma->numero);?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
		<?php
		// Verifica tipo
		if($_REQUEST["tipo"] == "F"){
		
			// Busca MatrÌculas
			$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE turma = '" . $dadosTurma->id . "' AND concluido = 'N' AND deletado = 'N'");
			
			// Verifica o total achado
			if(mysql_num_rows($buscaMatriculas) > 0){
				?>
				 <table cellspacing="0" cellpadding="2" style="border:2px solid #333333;border-bottom:0px;border-right:0px;">
			        <tr height="19">
			        	<td align="center" colspan="26" height="19" style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><h2 style="margin:10px;"><?php print($dadosUnidade->razaosocial);?></h2></td>
			        </tr>
			        <tr height="19">
			            <td align="center" height="19" rowspan="3" width="63" style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><b>N.</b></td>
			            <td height="19"rowspan="2" width="309" style="border-bottom:2px solid #333333;border-right:2px solid #333333;" align="center"><h3 style="margin:10px;" align="center"><?php print($_ClassData->transformaData($dadosTurma->datainicio, 2) . " a " . $_ClassData->transformaData($dadosTurma->datatermino, 2));?> - <?php print($dadosTurno->turno);?></h3></td>
			            <td height="19" colspan="24" style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><h2 style="margin:10px;" align="center">DIA / SEMANA - Turma: <?php print($dadosCurso->sigla . $dadosTurma->numero);?></h2></td>
			        </tr>
			        <tr height="17">
			            <td align="center" colspan="4" rowspan="2" height="36" style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><b>2&deg; - FEIRA _____/_____</b></td>
			            <td align="center" colspan="4" rowspan="2" style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><b>3&deg; - FEIRA _____/_____</b></td>
			            <td align="center" colspan="4" rowspan="2" style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><b>4&deg; - FEIRA    _____/_____</b></td>
			            <td align="center" colspan="4" rowspan="2" style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><b>5&deg; - FEIRA _____/_____</b></td>
			            <td align="center" colspan="4" rowspan="2" style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><b>6&deg; - FEIRA _____/_____</b></td>
						<td align="center" colspan="4" rowspan="2" style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><b>S&Aacute;BADO _____/_____</b></td>
			        </tr>
			        <tr height="17">
			        	<td height="19" width="309" style="border-bottom:2px solid #333333;border-right:2px solid #333333;" align="center"><b>NOME</b></td>
			        </tr>
			        <?php
			        // Contador
			        $cont = 1;
		
			        // Sql Alunos
			        $sqlAlunos = "SELECT alunos.nome,
			        					 matriculas.empresa FROM `alunos`,`matriculas` WHERE ";
			        
			        // Traz MatrÌculas
			        while ($trazMatriculas = mysql_fetch_object($buscaMatriculas)) {
			        
			        	// SQL
			        	$sqlAlunos .= "matriculas.aluno = alunos.id AND matriculas.deletado = 'N' AND matriculas.reprovado = 'N' AND alunos.deletado = 'N' AND alunos.id = '" . $trazMatriculas->aluno . "' OR ";
			        	
			        }
			        
			        // SQL
			        $sqlAlunos .= "{aqui}";
			        $sqlAlunos = str_replace("OR {aqui}", "", $sqlAlunos) . "GROUP BY alunos.id ORDER BY alunos.nome ASC";

			        // Busca ALunos
			        $buscaAlunos = $_ClassMysql->query($sqlAlunos);
			        
			        // Traz Alunos
			        while ($trazAlunos = mysql_fetch_object($buscaAlunos)) {
			        	
						// Dados do Cliente
						if($trazAlunos->empresa > 0){$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $trazAlunos->empresa . "'");}
						/*$buscaMatriculas = $_ClassMysql->query("SELECT matriculas.aluno,alunos.nome AS nome, matriculas.deletado, matriculas.concluido, matriculas.turma FROM matriculas,alunos WHERE matriculas.turma = '" . $dadosTurma->id . "' AND matriculas.concluido = 'N' AND matriculas.deletado = 'N' ORDER BY alunos.nome ASC");
						// Traz MatrÌculas
			        	while ($trazMatriculas = mysql_fetch_object($buscaMatriculas)) {*/
				        ?>
				        <tr height="21">
				            <td align="center" height="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><?php print($cont++);?></td>
				            <td style="border-bottom:2px solid #333333;border-right:2px solid #333333;"><?php print($trazAlunos->nome . (($trazAlunos->empresa > 0)?" <b>(" .  $dadosEmpresa->nomefantasia . ")</b>":""));?></td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
							<td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				            <td width="21" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
				        </tr>
				        <?php
			        }
			        ?>
			        <tr height="48">
			            <td colspan="2" height="48" style="border-bottom:2px solid #333333;border-right:2px solid #333333;" align="center"><h2 style="margin:10px;">Visto do Coordenador</h2></td>
			            <td height="53" colspan="4" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
			            <td colspan="4" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
			            <td colspan="4" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
			            <td colspan="4" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
			            <td colspan="4" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
						<td colspan="4" style="border-bottom:2px solid #333333;border-right:2px solid #333333;">&nbsp;</td>
			        </tr>
			    </table>
			   <?php
			}
			
		}elseif($_REQUEST["tipo"] == "V"){
			
			// Verifica se foi informado o perÌodo
			if($_REQUEST["dataI"] != "" && $_REQUEST["dataF"] != ""){
				
				// Valida perÌodo
				if($_ClassData->validaData($_REQUEST["dataI"]) && $_ClassData->validaData($_REQUEST["dataF"])){
					
					?>
					<table width="790" cellspacing="0" cellpadding="2" style="border:2px solid #333333;">
						<tr>
							<td align='left'>
								<?php
								
								// Busca Grade Hor·ria da turma
								$buscaGradeHoraria = $_ClassMysql->query("SELECT * FROM `gradehoraria` WHERE unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $_REQUEST["turma"] . "' AND deletado = 'N' AND data >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND data <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' ORDER BY data ASC");
								
								// Verifica total encontrado
								if(mysql_num_rows($buscaGradeHoraria) > 0){
									
									// Traz Grade Hor·ria
									while ($trazGradeHoraria = mysql_fetch_object($buscaGradeHoraria)) {
										
										// Dados da Turma
										$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $trazGradeHoraria->turma . "'");
										
										// Dados do Curso
										$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
										
										// Dados Turno
										$dadosTurno = $_ClassRn->getDadosTable("turnos", "horarioi, horariof", "id = '" . $trazGradeHoraria->turno . "'");
										
										// Dados da MatÈria
										$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazGradeHoraria->materia . "'");
										
										// Dados do Instrutor
										$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $trazGradeHoraria->instrutor . "'");
										
										// Dia da Semana
										switch (date("w", strtotime($trazGradeHoraria->data))) {
											
											case 0: $diaSemana = "Domingo"; break;
											case 1: $diaSemana = "Segunda-Feira"; break;
											case 2: $diaSemana = "Ter√ßa-Feira"; break;
											case 3: $diaSemana = "Quarta-Feira"; break;
											case 4: $diaSemana = "Quinta-Feira"; break;
											case 5: $diaSemana = "Sexta-Feira"; break;
											case 6: $diaSemana = "S√°bado"; break;
										}
										?>
										<table width="790" border="0" cellspacing="2" cellpadding="0">
										    <tr>
										        <td colspan="5" align="center"><h2><u>Assuntos Ministrados</u></h2></td>
										        <td width="155" align="center"><h2><?php print($dadosCurso->sigla . $dadosTurma->numero);?></h2></td>
										    </tr>
										    <tr>
										        <td width="200" align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b><?php print($diaSemana . " - " . $_ClassData->transformaData($trazGradeHoraria->data, 2));?></b></td>
										        <td width="129" align="left" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Turno:</b> <?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof);?></td>
										        <td width="108" align="left" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Mat&eacute;ria:</b> <?php print($dadosMateria->sigla);?></td>
										        <td width="59" align="left" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Sala:</b> <?php print($trazGradeHoraria->sala);?></td>
										        <td colspan="2" align="left" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Professor:</b> <?php print($_ClassUtilitarios->abreviaNome1($dadosInstrutor->nome));?></td>
										    </tr>
										    <tr>
										    	<td colspan="6" height="22" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><h2>Conte√∫do:</h2></td>
										    </tr>
										    <tr>
										    	<td colspan="6" align="center" height="21" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;</td>
										    </tr>
										    <tr>
										    	<td colspan="6" align="center" height="21" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;</td>
										    </tr>
										    <tr>
										   	 	<td colspan="6" align="center" height="21" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;</td>
										    </tr>
										    <tr>
										    	<td colspan="6" align="center" height="21" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;</td>
										    </tr>
										    <tr>
										    	<td colspan="6" align="center" height="21" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;</td>
										    </tr>
										    <tr>
										    	<td colspan="6" align="center" height="21" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;</td>
										    </tr>
										</table>
										<?php
									}
								?>
							</td>
						</tr>
					</table>
					<?php
						
					}else{
						
						// Redireciona
						print($_ClassUtilitarios->redirecionarJS("#", 1, array("Nao foi encontrada nenhuma aula para esta turma.")));
						
					}
					
				}else{
				
					// Redireciona
					print($_ClassUtilitarios->redirecionarJS("#", 1, array("Per√≠odo inv√°lido!")));
					
				}
				
			}else{
				
				// Redireciona
				print($_ClassUtilitarios->redirecionarJS("#", 1, array("√â preciso informar um per√≠odo!")));
				
			}
			
		}
		?>
	</body>
</html>