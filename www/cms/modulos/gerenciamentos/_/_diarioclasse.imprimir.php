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

// Dados da Unidade
$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N' AND acesso = 'L'");

// Cidade Unidade
$cidadeUnidade = $_ClassRn->getDadosTable("cidades", "*", "id = '" . $dadosUnidade->cidade . "'");
	
// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");

/* Construindo sql */
$sql = "SELECT * FROM `diarioclasse`";
$sql .= " WHERE ";
if($_SESSION["consultaDiarioClasse"]["todas"] != "sim"){
	
	$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarData"] == "sim")?" data BETWEEN '" . $_ClassData->transformaData($_SESSION["consultaDiarioClasse"]["dataI"]) . "' AND '" . $_ClassData->transformaData($_SESSION["consultaDiarioClasse"]["dataF"]) . "' AND":"");
	$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarTurma"] == "sim")?" turma = '" . $_SESSION["consultaDiarioClasse"]["turma"] . "' AND":"");
	$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarTurno"] == "sim")?" turno = '" . $_SESSION["consultaDiarioClasse"]["turno"] . "' AND":"");
	$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarMateria"] == "sim")?" materia = '" . $_SESSION["consultaDiarioClasse"]["materia"] . "' AND":"");
	$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarInstrutor"] == "sim")?" instrutor = '" . $_SESSION["consultaDiarioClasse"]["instrutor"] . "' AND":"");
	$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarSala"] == "sim")?" sala = '" . $_SESSION["consultaDiarioClasse"]["sala"] . "' AND":"");
	$sql .= (($_SESSION["consultaDiarioClasse"]["habilitarConteudo"] == "sim")?" conteudo LIKE '" . $_SESSION["consultaDiarioClasse"]["conteudo"] . "' AND":"");
	
	//$sql .= (($_POST["habilitar"] == "sim")?"":"");
}

$sql .= " deletado = 'N' ORDER BY " . (($_REQUEST['campo'] == '')?'id':$_REQUEST['campo']) . " " . (($_REQUEST['ordem'] == '')?"ASC":$_REQUEST['ordem']);

/* Fim da construção */

// Busca Diário de Classe
$buscaDiarioClasse = $_ClassMysql->query($sql);
?>
<html>
	<head>
		<title>Relatório de Diário de Classe</title>
		<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
		<table width="700" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td align='left'><img src="<?php print($pathInc);?>imagens/diversos/logo.jpg"></td>
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
					<h2><u>Relatório de Diário de Classe</u></h2>
					<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
				</td>
			</tr>
			<tr>
				<td align='left'><h2>Filtrando por:</h2></td>
			</tr>
			<?php
			// Verifica se a busca é por todas as notas fiscais
			if($_SESSION["consultaDiarioClasse"]["todas"] == "sim"){
				?>
				<tr>
					<td align='left'><ol><strong>Todas os Diários de Classe</strong></ol></td>
				</tr>
				<?php
			}
			 
			// Verifica se foi habilitado o campo de data
			if($_SESSION["consultaDiarioClasse"]["habilitarData"] == "sim"){
				?>
				<tr>
					<td align='left'><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaDiarioClasse"]["dataI"]?> até <?php echo $_SESSION["consultaDiarioClasse"]["dataF"]?></ol></td>
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
					<td align='left'><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></td>
				</tr>
				<?php
			}
			
			// Verifica se foi habilitado o campo de turno
			if($_SESSION["consultaDiarioClasse"]["habilitarTurno"] == "sim"){
				
				// Dados do Turno
				$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $_SESSION["consultaDiarioClasse"]["turno"] . "'");
				?>
				<tr>
					<td align='left'><ol><strong>Turno:</strong>&nbsp;<?php print($dadosTurno->turno . " (" . $dadosTurno->horarioi . " - " . $dadosTurno->horariof . ")"); ?></ol></td>
				</tr>
				<?php
			}
			
			// Verifica se foi habilitado o campo de matéria
			if($_SESSION["consultaDiarioClasse"]["habilitarMateria"] == "sim"){
			
				// Dados da Matéria
				$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $_SESSION["consultaDiarioClasse"]["materia"] . "'");
				?>
				<tr>
					<td align='left'><ol><strong>Matéria:</strong>&nbsp;<?php print($dadosMateria->materia);?></ol></td>
				</tr>
				<?php
				
			}
			
			//Verifica se foi habilitado o campo de Instrutores
			if($_SESSION["consultaDiarioClasse"]["habilitarInstrutor"] == "sim"){
				
				// Dados do Instrutor
				$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaDiarioClasse"]["instrutor"] . "'");
				?>
				<tr>
					<td align='left'><ol><strong>Instrutor:</strong>&nbsp;<?php print($dadosInstrutor->nome);?> (<?php print($dadosInstrutor->cpf);?>)</ol></td>
				</tr>
				<?php
			}
			
			// Verifica se foi habilitado o campo de sala
			if($_SESSION["consultaDiarioClasse"]["habilitarSala"] == "sim"){
				?>
				<tr>
					<td align='left'><ol><strong>Sala:</strong>&nbsp;<?php echo $_SESSION["consultaDiarioClasse"]["sala"]?></ol></td>
				</tr>
				<?php
			}
			
			// Verifica se foi habilitado o campo de conteúdo
			if($_SESSION["consultaDiarioClasse"]["habilitarConteudo"] == "sim"){
				?>
				<tr>
					<td align='left'><ol><strong>Conteúdo:</strong>&nbsp;<?php echo $_SESSION["consultaDiarioClasse"]["conteudo"]?></ol></td>
				</tr>
				<?php
			}
			?>
		</table>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td align='left'>
					<?php			
					// Traz Diário de Classe
					while($trazDiarioClasse = mysql_fetch_object($buscaDiarioClasse)){
						
						// Dados da Turma
						$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $trazDiarioClasse->turma . "'");
						
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
						
						// Dados Turno
						$dadosTurno = $_ClassRn->getDadosTable("turnos", "horarioi, horariof", "id = '" . $trazDiarioClasse->turno . "'");
						
						// Dados da Matéria
						$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazDiarioClasse->materia . "'");
						
						// Dados do Instrutor
						$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $trazDiarioClasse->instrutor . "'");
						
						// Dia da Semana
						switch (date("w", strtotime($trazDiarioClasse->data))) {
							
							case 0: $diaSemana = "Domingo"; break;
							case 1: $diaSemana = "Segunda-Feira"; break;
							case 2: $diaSemana = "Terça-Feira"; break;
							case 3: $diaSemana = "Quarta-Feira"; break;
							case 4: $diaSemana = "Quinta-Feira"; break;
							case 5: $diaSemana = "Sexta-Feira"; break;
							case 6: $diaSemana = "Sábado"; break;
						}
						?>
						<table width="100%" border="0" cellspacing="2" cellpadding="0">
						    <tr>
						        <td colspan="4" align="center"><h2><u>Assuntos Ministrados</u></h2></td>
						        <td width="155" align="center"><h2><?php print($dadosCurso->sigla . $dadosTurma->numero);?></h2></td>
						    </tr>
						   <tr>
						        <td width="259" align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b><?php print($diaSemana . " - " . $_ClassData->transformaData($trazDiarioClasse->data, 2));?></b></td>
						        <td width="129" align="left" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Turno:</b> <?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof);?></td>
						        <td width="108" align="left" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Matéria:</b> <?php print($dadosMateria->sigla);?></td>
						        <td colspan="2" align="left" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Professor:</b> <?php print($_ClassUtilitarios->abreviaNome1($dadosInstrutor->nome));?></td>
						    </tr>
						    <tr>
						    	<td colspan="5" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><h2>Conteúdo:</h2><?php print(nl2br($trazDiarioClasse->conteudo));?> <br>(<b>Horas/Aula: </b><?php print($trazDiarioClasse->horasaula);?>)</td>
						    </tr>
						</table>
						<?php
					}
					?>	
				</td>
			</tr>
		</table>
	</body>
</html>