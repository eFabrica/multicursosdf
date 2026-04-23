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

// Biblioteca de Geração de Boletos
require_once($pathInc . "lib/Boleto.class.php");

// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["frequenciasalunos"]["idTurma"] . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");

// Dados Turno
$dadosTurno = $_ClassRn->getDadosTable("turnos", "horarioi, horariof", "id = '" . $dadosTurma->turno . "'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="<?php print($pathInc . "css/estilos.css");?>" rel="stylesheet" type="text/css">
        <title>Lista de Frequência</title>
    </head>

    <body>
    	<?php
    	// Verifica Orientação
    	if($_REQUEST["orientacao"] == "f"){
    	
			// Busca Grade Horária
			$buscaGradeHoraria = $_ClassMysql->query("SELECT * FROM `gradehoraria` WHERE unidade = '" . $_dadosUnidade->id . "' AND
																						 turma = '" . $_SESSION["frequenciasalunos"]["idTurma"] . "' AND
																					     deletado = 'N'  ORDER BY data, turno ASC");
			// Total de Páginas
			$totPag = ceil(mysql_num_rows($buscaGradeHoraria)/22);
				
			// Lê Páginas
			for($i = 1; $i <= $totPag; $i++){
				
				// Limite inicial
				$inicioLimit = ( $i - 1 ) * 22;
				?>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td align="center" height="20" style="border:1px solid #000000;"><h2 style="margin:0px;">Frequência de Alunos</h2></td>
					</tr>
					<tr>
						<td height="20" align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;border-left:1px solid #000000;">
							<h2 style="margin:0px;"><?php print($dadosCurso->sigla . $dadosTurma->numero);?></h2>
						</td>
					</tr>
					<tr>
						<td align="center" style="border-left:1px solid #000000;">
							<table width="100%" cellpadding="2" cellspacing="0" border="0">
								<tr>
									<td colspan="2" align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><strong>Nome</strong></td>
									<?php
									// Busca Grade Horária
									$buscaGradeHorariaPG1 = $_ClassMysql->query("SELECT * FROM `gradehoraria` WHERE  unidade = '" . $_dadosUnidade->id . "' AND
																													 turma = '" . $_SESSION["frequenciasalunos"]["idTurma"] . "' AND
																												     deletado = 'N' ORDER BY data, turno ASC LIMIT " . $inicioLimit . "," . 22);
									
									// Traz Grade Horária
									while($trazGradeHorariaPG1 = mysql_fetch_object($buscaGradeHorariaPG1)){
										
										?>
										<td align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><?php print(substr($_ClassData->transformaData($trazGradeHorariaPG1->data, 2), 0, 5) . "<br>(" . $trazGradeHorariaPG1->turno . ")");?>&nbsp;</td>
										<?php
									}
									
									// Completa as colunas
									for($j = 0; $j < (22-mysql_num_rows($buscaGradeHorariaPG1)); $j++){
										
										?>
										<td align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><font color="White">__/__</font></td>
										<?php
										
									}
									
									// Verifica Contador
									if($i == $totPag){
										?>
										<!--
										<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;" align="center"><b>Nota</b></td>
										!-->
										<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;" align="center"><b>Tot.&nbsp;Faltas</b></td>
										<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;" align="center"><b>Tot.&nbsp;Presença</b></td>
										<?php
									}
									?>
								</tr>
								<?php
								// Contador
								$cont = 1;
									
								// Busca Matrículas dessa Turma
								$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $_SESSION["frequenciasalunos"]["idTurma"] . "' AND deletado = 'N' LIMIT 0, 36");
								
								// Traz Matriculas
								while ($trazMatriculas = mysql_fetch_object($buscaMatriculas)) {
									
									// Dados do Aluno
									$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");
									?>
									<tr>
										<td align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><?php print($cont++); ?>&nbsp;</td>
										<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><?php print($dadosAluno->nome);?>&nbsp;</td>
										<?php
										// Busca Grade Horária
										$buscaGradeHorariaPG2 = $_ClassMysql->query("SELECT * FROM `gradehoraria` WHERE  unidade = '" . $_dadosUnidade->id . "' AND
																														 turma = '" . $_SESSION["frequenciasalunos"]["idTurma"] . "' AND
																													     deletado = 'N'  ORDER BY data, turno ASC LIMIT " . $inicioLimit . "," . 22);
										
										// Traz Grade Horária
										while($trazGradeHorariaPG2 = mysql_fetch_object($buscaGradeHorariaPG2)){
											
											// Busca Frequência
											$buscaFrequencias = $_ClassMysql->query("SELECT * FROM `frequencias` WHERE matricula = '" . $trazMatriculas->id . "' AND
																													   gradehoraria = '" . $trazGradeHorariaPG2->id . "' AND
																													   deletado = 'N'");
											// Controle de Faltas e Presenças
											((mysql_num_rows($buscaFrequencias) > 0)?++$presencas[$trazMatriculas->id]:++$faltas[$trazMatriculas->id]);
											?>
											<td align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><?php print(((mysql_num_rows($buscaFrequencias) > 0)?"<img src='" . $pathInc . "imagens/diversos/bol.gif'>":"F"));?>&nbsp;</td>
											<?php
										}
										
										// Completa as colunas
										for($j = 0; $j < (22-mysql_num_rows($buscaGradeHorariaPG2)); $j++){
											
											?>
											<td align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;">&nbsp;</td>
											<?php
											
										}
										
										// Verifica Contador
										if($i == $totPag){
											?>
											<td align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><?php print((($faltas[$trazMatriculas->id] == "")?"0":$faltas[$trazMatriculas->id]));?>&nbsp;</td>
											<td align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><?php print((($presencas[$trazMatriculas->id] == "")?"0":$presencas[$trazMatriculas->id]));?>&nbsp;</td>
											<?php
										}
										?>
									</tr>
									<?php
								}
								
								// Completa Lista
								for($k = mysql_num_rows($buscaMatriculas); $k <= 36; $k++){
									
									?>
									<tr>
										<td align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;">&nbsp;</td>
										<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><img src="<?php print($pathInc . "imagens/diversos/empty.gif");?>" width="245" height="14"></td>
										<?php
										// Busca Grade Horária
										$buscaGradeHorariaPG3 = $_ClassMysql->query("SELECT * FROM `gradehoraria` WHERE  unidade = '" . $_dadosUnidade->id . "' AND
																														 turma = '" . $_SESSION["frequenciasalunos"]["idTurma"] . "' AND
																													     deletado = 'N'  ORDER BY data, turno ASC LIMIT " . $inicioLimit . "," . 22);
										
										// Traz Grade Horária
										while($trazGradeHorariaPG3 = mysql_fetch_object($buscaGradeHorariaPG3)){
											?>
											<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;">&nbsp;</td>
											<?php
										}
										
										// Completa as colunas
										for($j = 0; $j < (22-mysql_num_rows($buscaGradeHorariaPG3)); $j++){
											
											?>
											<td align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;">&nbsp;</td>
											<?php
											
										}
										
										// Verifica Contador
										if($i == $totPag){
											?>
											<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;">&nbsp;</td>
											<td style="border-bottom:1px solid #000000;border-right:1px solid #000000;">&nbsp;</td>
											<?php
										}
										?>
									</tr>
									<?php
									
								}
								?>
							</table>
						</td>
					</tr>
				</table>
				<p><div style='page-break-after: always;'><span style='display: none;'>&nbsp;</span></div></p>
				<?php
			}
			
    	}elseif($_REQUEST["orientacao"] == "d"){
    		
    		?>
    		<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td align="center" style="border:1px solid #000000;"><h2 style="margin:0px;">Diário de Classe</h2></td>
				</tr>
				<tr>
					<td height="20" align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;border-left:1px solid #000000;">
						<h2 style="margin:0px;"><?php print($dadosCurso->sigla . $dadosTurma->numero);?></h2>
					</td>
				</tr>
				<tr>
					<td align="center" style="border:1px solid #000000;border-top:0px;border-bottom:0px;">
						<table width="100%" cellpadding="2" cellspacing="0" border="0">
							<?php
							// Busca Grade Horária
							$buscaGradeHoraria = $_ClassMysql->query("SELECT * FROM `gradehoraria` WHERE unidade = '" . $_dadosUnidade->id . "' AND
																										 turma = '" . $_SESSION["frequenciasalunos"]["idTurma"] . "' AND
																									     deletado = 'N'  ORDER BY data, turno ASC");
							
							// Traz Grade Horária
							while($trazGradeHoraria = mysql_fetch_object($buscaGradeHoraria)){
								
								// Dados Diário
								$dadosDiario = $_ClassRn->getDadosTable("diarioclasse", "*", "unidade = '" . $_dadosUnidade->id . "' AND
																						      turma = '" . $_SESSION["frequenciasalunos"]["idTurma"] . "' AND
																						      turno = '" . $trazGradeHoraria->turno . "' AND
																						      data = '" . $trazGradeHoraria->data . "'");
								
								// Verifica se tem algum conteúdo
								if($dadosDiario->conteudo != ""){
									
									// Dados da matérias
									$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $dadosDiario->materia . "'");
									?>
									<tr>
										<td valign="top" style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><b>Data:</b><?php print($_ClassData->transformaData($dadosDiario->data, 2));?>&nbsp;</td>
										<td valign="top" style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><b>Matéria:</b><?php print($dadosMateria->sigla);?>&nbsp;</td>
										<td width="100%" style="border-bottom:1px solid #000000;">
											<b>Diário/Obs:&nbsp;</b><?php print(nl2br($dadosDiario->conteudo));?>&nbsp;
										</td>
									</tr>
									<?php
								}
								
							}
							?>
						</table>
					</td>
				</tr>
			</table>
    		<?php
    	}
		?>
    </body>
</html>
