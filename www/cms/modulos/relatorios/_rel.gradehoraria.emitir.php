<?php
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = '../../';

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

// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");
?>
<html>
	<head>
		<title>Grade Horária</title>
		<style>
		body {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 13px;
			color: #333333;
		}
		
		td {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 13px;
			color: #333333;
		}
		
		.menu_topico {
			font-family: Verdana, Arial, Helvetica, sans-serif;
			font-size: 16px;
			color: #006699;
			font-weight: bold;
		}
		</style>
	</head>
	
	<body>
		<table width="99%" border="0" cellpadding="2" cellspacing="2">
			<tr>
				<td class="menu_topico">Filtrado por: </td>
			</tr>
			<?php
			// Verifica se a busca é por todas as notas fiscais
			if($_SESSION["consultaGradeHorariaRel"]["todas"] == "sim"){
				?>
				<tr>
					<td align='left'><font style="font-size:13px;"><ol><strong>Todas as Grades Horárias</strong></ol></font></td>
				</tr>
				<?php
			}
			 
			// Verifica se foi habilitado o campo de data
			if($_SESSION["consultaGradeHorariaRel"]["habilitarData"] == "sim"){
				?>
				<tr>
					<td align='left'><font style="font-size:13px;"><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaGradeHorariaRel"]["dataI"]?> até <?php echo $_SESSION["consultaGradeHorariaRel"]["dataF"]?></ol></font></td>
				</tr>
				<?php
			}
			
			// Verifica se foi habilitado o campo de turma
			if($_SESSION["consultaGradeHorariaRel"]["habilitarTurma"] == "sim"){
				
				// Dados da Turma
				$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaGradeHorariaRel"]["turma"] . "'");
				
				// Dados do Curso
				$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
				?>
				<tr>
					<td align='left'><font style="font-size:13px;"><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></font></td>
				</tr>
				<?php
			}
			
			// Verifica se foi habilitado o campo de turno
			if($_SESSION["consultaGradeHorariaRel"]["habilitarTurno"] == "sim"){
				
				// Dados do Turno
				$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $_SESSION["consultaGradeHorariaRel"]["turno"] . "'");
				?>
				<tr>
					<td align='left'><font style="font-size:13px;"><ol><strong>Turno:</strong>&nbsp;<?php print($dadosTurno->turno . " (" . $dadosTurno->horarioi . " - " . $dadosTurno->horariof . ")"); ?></ol></font></td>
				</tr>
				<?php
			}
			
			// Verifica se foi habilitado o campo de matéria
			if($_SESSION["consultaGradeHorariaRel"]["habilitarMateria"] == "sim"){
			
				// Dados da Matéria
				$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $_SESSION["consultaGradeHorariaRel"]["materia"] . "'");
				?>
				<tr>
					<td align='left'><font style="font-size:13px;"><ol><strong>Matéria:</strong>&nbsp;<?php print($dadosMateria->materia);?></ol></font></td>
				</tr>
				<?php
				
			}
			
			//Verifica se foi habilitado o campo de Instrutores
			if($_SESSION["consultaGradeHorariaRel"]["habilitarInstrutor"] == "sim"){
				
				// Dados do Instrutor
				$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaGradeHorariaRel"]["instrutor"] . "'");
				?>
				<tr>
					<td align='left'><font style="font-size:13px;"><ol><strong>Instrutor:</strong>&nbsp;<?php print($dadosInstrutor->nome);?> (<?php print($_ClassUtilitarios->formataCPF($dadosInstrutor->cpf));?>)</ol></font></td>
				</tr>
				<?php
			}
			
			//Verifica se foi habilitado o campo de sala
			if($_SESSION["consultaGradeHorariaRel"]["habilitarSala"] == "sim"){
				?>
				<tr>
					<td align='left'><font style="font-size:13px;"><ol><strong>Sala:</strong>&nbsp;<?php echo $_SESSION["consultaGradeHorariaRel"]["sala"]?></ol></font></td>
				</tr>
				<?php
			}				
			?>
		</table>
		<table width="790" cellspacing="0" cellpadding="2" style="border:1px solid #333333;">
			<tr>
				<td width="9%" align="center" style="border:1px solid #333333;"><b>Data</b></td>
				<td width="7%" align="center" style="border:1px solid #333333;"><b>Dia Semana</b></td>
				<td width="8%" align="center" style="border:1px solid #333333;"><b>Turno</b></td>
				<td width="9%" align="center" style="border:1px solid #333333;"><b>Início</b></td>
				<td width="29%" align="center" style="border:1px solid #333333;"><b>Matéria</b></td>
				<td width="24%" align="center" style="border:1px solid #333333;"><b>Instrutor</b></td>
				<td width="11%" align="center" style="border:1px solid #333333;"><b>Sala</b></td>
			</tr>
			<?php
			// Lê Registros
			for($i = 0; $i < count($_REQUEST["registros"]); $i++){
				
				// Dados da Grade
				$dadosGradeHoraria = $_ClassRn->getDadosTable("gradehoraria", "*", "id = '" . $_REQUEST["registros"][$i] . "' AND deletado = 'N'");
				
				// Dados da Turma
				$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosGradeHoraria->turma . "' AND deletado = 'N'");
				
				// Dados do Curso
				$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosGradeHoraria->curso . "' AND deletado = 'N'");
			
				// Dados do Turno
				$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosGradeHoraria->turno . "' AND deletado = 'N'");
			
				// Dados da Matéria
				$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $dadosGradeHoraria->materia . "' AND deletado = 'N'");
				
				// Dados do Instrutor
				$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $dadosGradeHoraria->instrutor . "' AND deletado = 'N'");
				?>
				<tr>
					<td align="center" style="border:1px solid #333333;">&nbsp;<?php print($_ClassData->transformaData($dadosGradeHoraria->data, 2));?></td>
					<td align="center" style="border:1px solid #333333;">&nbsp;<?php if((date("w", strtotime($dadosGradeHoraria->data))) == 6){print("Sab");}elseif ((date("w", strtotime($dadosGradeHoraria->data))) == 0){print("Dom");}else{print(date("w", strtotime($dadosGradeHoraria->data))+1);}?>ª</td>
					<td align="center" style="border:1px solid #333333;">&nbsp;<?php $turno = explode(" ", $dadosTurno->turno);print($turno[0]);?></td>
					<td align="center" style="border:1px solid #333333;">&nbsp;<?php print($dadosTurno->horarioi);?></td>
					<td align="center" style="border:1px solid #333333;">&nbsp;<?php print($dadosMateria->materia);?></td>
					<td align="center" style="border:1px solid #333333;">&nbsp;<?php print($_ClassUtilitarios->abreviaNome1($dadosInstrutor->nome));?></td>
					<td align="center" style="border:1px solid #333333;">&nbsp;<?php print($dadosGradeHoraria->sala);?></td>
				</tr>
				<?php
				
			}
			?>
		</table>
	</body>
</html>