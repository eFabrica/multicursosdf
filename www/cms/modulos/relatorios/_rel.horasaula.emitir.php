<?php require_once("php7_mysql_shim.php");
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

// Dados da Unidade
$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N' AND acesso = 'L'");

// Cidade Unidade
$cidadeUnidade = $_ClassRn->getDadosTable("cidades", "*", "id = '" . $dadosUnidade->cidade . "'");
	
// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica tipo de relatório
//if($_SESSION["consultaHorasAulas"]["tipo"] == "1"){

	/* Construindo sql */
	$sql = "SELECT * FROM `diarioclasse`";
	$sql .= " WHERE ";
	if($_SESSION["consultaHorasAulas"]["todas"] != "sim"){
		
		$sql .= (($_SESSION["consultaHorasAulas"]["habilitarData"] == "sim")?" data >= '" . $_ClassData->transformaData($_SESSION["consultaHorasAulas"]["dataI"]) . "' AND data <= '" . $_ClassData->transformaData($_SESSION["consultaHorasAulas"]["dataF"]) . "' AND":"");
		$sql .= (($_SESSION["consultaHorasAulas"]["habilitarTurma"] == "sim")?" turma = '" . $_SESSION["consultaHorasAulas"]["turma"] . "' AND":"");
		$sql .= (($_SESSION["consultaHorasAulas"]["habilitarTurno"] == "sim")?" turno = '" . $_SESSION["consultaHorasAulas"]["turno"] . "' AND":"");
		$sql .= (($_SESSION["consultaHorasAulas"]["habilitarMateria"] == "sim")?" materia = '" . $_SESSION["consultaHorasAulas"]["materia"] . "' AND":"");
		// Verifica Nível
		if($_dadosLogado->nivel != "95"){
			$sql .= (($_SESSION["consultaHorasAulas"]["habilitarInstrutor"] == "sim")?" instrutor = '" . $_SESSION["consultaHorasAulas"]["instrutor"] . "' AND":"");
		}else{
			$sql .= " instrutor = '" . $_dadosLogado->id . "' AND";
		}
		$sql .= (($_SESSION["consultaHorasAulas"]["habilitarSala"] == "sim")?" sala = '" . $_SESSION["consultaHorasAulas"]["sala"] . "' AND":"");
		
		//$sql .= (($_POST["habilitar"] == "sim")?"":"");
	}else{
		if($_dadosLogado->nivel == "95"){
			$sql .= " instrutor = '" . $_dadosLogado->id . "' AND";
		}
	}
	
	$sql .= " deletado = 'N' ORDER BY " . (($_REQUEST['campo'] == '')?'id':$_REQUEST['campo']) . " " . (($_REQUEST['ordem'] == '')?"ASC":$_REQUEST['ordem']);
	
	// Busca Horas Aula
	$buscaHorasAula = $_ClassMysql->query($sql);
	
	// Calcula Número de Paginas
	$totPag = ceil(mysql_num_rows($buscaHorasAula)/35);
	?>
	<html>
		<head>
			<title>Relatório de Horas Aula</title>
			<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
		</head>
		
		<body>
			<?php
			// Lê Número de Página
			for($i = 1; $i <= $totPag; $i++){
				?>
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
							<h2><u>Relatório de Horas Aula</u></h2>
							<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
							Página <b><?php print($i);?></b> de <b><?php print($totPag);?></b>
						</td>
					</tr>
					<tr>
						<td align='left'><h2>Filtrando por:</h2></td>
					</tr>
					<?php
					// Verifica se a busca é por todas as notas fiscais
					if($_SESSION["consultaHorasAulas"]["todas"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Todas as Horas Aulas</strong></ol></td>
						</tr>
						<?php
					}
					 
					// Verifica se foi habilitado o campo de data
					if($_SESSION["consultaHorasAulas"]["habilitarData"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaHorasAulas"]["dataI"]?> até <?php echo $_SESSION["consultaHorasAulas"]["dataF"]?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de turma
					if($_SESSION["consultaHorasAulas"]["habilitarTurma"] == "sim"){
						
						// Dados da Turma
						$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaHorasAulas"]["turma"] . "'");
						
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de turno
					if($_SESSION["consultaHorasAulas"]["habilitarTurno"] == "sim"){
						
						// Dados do Turno
						$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $_SESSION["consultaHorasAulas"]["turno"] . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Turno:</strong>&nbsp;<?php print($dadosTurno->turno . " (" . $dadosTurno->horarioi . " - " . $dadosTurno->horariof . ")"); ?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de matéria
					if($_SESSION["consultaHorasAulas"]["habilitarMateria"] == "sim"){
					
						// Dados da Matéria
						$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $_SESSION["consultaHorasAulas"]["materia"] . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Matéria:</strong>&nbsp;<?php print($dadosMateria->materia);?></ol></td>
						</tr>
						<?php
						
					}
					
					//Verifica se foi habilitado o campo de Instrutores
					if($_SESSION["consultaHorasAulas"]["habilitarInstrutor"] == "sim"){
						
						// Dados do Instrutor
						$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaHorasAulas"]["instrutor"] . "'");
						?>
						<tr>
							<td align='left'><ol><strong>Instrutor:</strong>&nbsp;<?php print($dadosInstrutor->nome);?> (<?php print($_ClassUtilitarios->formataCPF($dadosInstrutor->cpf));?>)</ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de sala
					if($_SESSION["consultaHorasAulas"]["habilitarSala"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Sala:</strong>&nbsp;<?php echo $_SESSION["consultaHorasAulas"]["sala"]?></ol></td>
						</tr>
						<?php
					}			
					?>
				</table>
				<table width="100%" border="0" cellspacing="2" cellpadding="2">
					<tr>
						<td align="center" width="1%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>#</b></td>
						<td align="center" width="15%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Data</b></td>
						<td align="center" width="15%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Turma</b></td>
						<td align="center" width="15%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Turno</b></td>
						<td align="center" width="15%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Matéria</b></td>
						<td align="center" width="30%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Instrutor</b></td>
						<td align="center" width="10%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Horas</b></td>
					</tr>
					<?php
					//Limite inicial
					$inicioLimit = ( $i - 1 ) * 35;
					
					// Busca Horas Aula
					$buscaHorasAula = $_ClassMysql->query($sql . " LIMIT " . $inicioLimit . "," . 35);
					
					// Traz Horas Aula
					while($trazHorasAula = mysql_fetch_object($buscaHorasAula)){
						
						// Dados da Turma
						$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $trazHorasAula->turma . "'");
						
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
	
						// Dados do Turno
						$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $trazHorasAula->turno . "'");
	
						// Dados da Matéria
						$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazHorasAula->materia . "'");
						
						// Dados do Instrutor
						$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $trazHorasAula->instrutor . "'");
						?>
						<tr class=row0>
							<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($trazHorasAula->id); ?></td>
							<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($_ClassData->transformaData($trazHorasAula->data, 2));?></td>
							<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
							<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
							<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosMateria->sigla); ?></td>
							<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($_ClassUtilitarios->abreviaNome1($dadosInstrutor->nome)); ?></td>
							<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($trazHorasAula->horasaula); ?></td>
						</tr>
						<?php
						// Total de Horas Aula da Página
						$totHorasPg += $trazHorasAula->horasaula;
					}
					
					// Total de Horas Aula do Relatório
					$totHorasTot += $totHorasPg;
					?>
					<tr>
						<td align="right" colspan="8"><h2 style="margin:0px;"><b>Total de Horas Aula da Página:</b> <?php print($totHorasPg);?></h2></td>
					</tr>
				</table>
				<?php if($i < $totPag){?>
					<p><div style='page-break-after: always;'><span style='display: none;'>&nbsp;</span></div></p>
				<?php }else{ ?>
					<div align="right"><h2 style="margin:0px;">Total de Horas Aula do Relatório: <?php print($totHorasTot);?></h2></div>
				<?php
				}
			}
			?>
		</body>
	</html>
	<?php
	/*
}elseif ($_SESSION["consultaHorasAulas"]["tipo"] == 2){
	
	?>
	<html>
		<head>
			<title>Relatório de Horas Aula</title>
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
						<h2><u>Relatório de Horas Aula</u></h2>
						<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>						
					</td>
				</tr>
				<tr>
					<td align='left'><h2>Filtrando por:</h2></td>
				</tr>
				<?php
				// Verifica se a busca é por todas as notas fiscais
				if($_SESSION["consultaHorasAulas"]["todas"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Todas as Horas Aulas</strong></ol></td>
					</tr>
					<?php
				}
				 
				// Verifica se foi habilitado o campo de data
				if($_SESSION["consultaHorasAulas"]["habilitarData"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaHorasAulas"]["dataI"]?> até <?php echo $_SESSION["consultaHorasAulas"]["dataF"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de turma
				if($_SESSION["consultaHorasAulas"]["habilitarTurma"] == "sim"){
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "curso, numero", "id = '" . $_SESSION["consultaHorasAulas"]["turma"] . "'");
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de turno
				if($_SESSION["consultaHorasAulas"]["habilitarTurno"] == "sim"){
					
					// Dados do Turno
					$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $_SESSION["consultaHorasAulas"]["turno"] . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Turno:</strong>&nbsp;<?php print($dadosTurno->turno . " (" . $dadosTurno->horarioi . " - " . $dadosTurno->horariof . ")"); ?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de matéria
				if($_SESSION["consultaHorasAulas"]["habilitarMateria"] == "sim"){
				
					// Dados da Matéria
					$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $_SESSION["consultaHorasAulas"]["materia"] . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Matéria:</strong>&nbsp;<?php print($dadosMateria->materia);?></ol></td>
					</tr>
					<?php
					
				}
				
				//Verifica se foi habilitado o campo de Instrutores
				if($_SESSION["consultaHorasAulas"]["habilitarInstrutor"] == "sim"){
					
					// Dados do Instrutor
					$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaHorasAulas"]["instrutor"] . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Instrutor:</strong>&nbsp;<?php print($dadosInstrutor->nome);?> (<?php print($_ClassUtilitarios->formataCPF($dadosInstrutor->cpf));?>)</ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de sala
				if($_SESSION["consultaHorasAulas"]["habilitarSala"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Sala:</strong>&nbsp;<?php echo $_SESSION["consultaHorasAulas"]["sala"]?></ol></td>
					</tr>
					<?php
				}			
				?>
			</table>
			<table width="100%" border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td align="center" width="1%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>#</b></td>
					<td align="center" width="15%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Data</b></td>
					<td align="center" width="15%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Turma</b></td>
					<td align="center" width="15%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Turno</b></td>
					<td align="center" width="15%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Matéria</b></td>
					<td align="center" width="30%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Instrutor</b></td>
					<td align="center" width="5%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Sala</b></td>
					<td align="center" width="5%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Horas</b></td>
				</tr>
				<?php
				//Limite inicial
				$inicioLimit = ( $i - 1 ) * 35;
				
				// Busca Horas Aula
				$buscaHorasAula = $_ClassMysql->query($sql . " LIMIT " . $inicioLimit . "," . 35);
				
				// Traz Horas Aula
				while($trazHorasAula = mysql_fetch_object($buscaHorasAula)){
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "curso, numero", "id = '" . $trazHorasAula->turma . "'");
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");

					// Dados do Turno
					$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $trazHorasAula->turno . "'");

					// Dados da Matéria
					$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazHorasAula->materia . "'");
					
					// Dados do Instrutor
					$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $trazHorasAula->instrutor . "'");
					?>
					<tr class=row0>
						<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($trazHorasAula->id); ?></td>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($_ClassData->transformaData($trazHorasAula->data, 2));?></td>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosMateria->sigla); ?></td>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($_ClassUtilitarios->abreviaNome1($dadosInstrutor->nome)); ?></td>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($trazHorasAula->sala); ?></td>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($trazHorasAula->horasaula); ?></td>
					</tr>
					<?php
					// Total de Horas Aula da Página
					$totHorasPg += $trazHorasAula->horasaula;
				}
				
				// Total de Horas Aula do Relatório
				$totHorasTot += $totHorasPg;
				?>
				<tr>
					<td align="right" colspan="8"><h2 style="margin:0px;"><b>Total de Horas Aula da Página:</b> <?php print($totHorasPg);?></h2></td>
				</tr>
			</table>
		</body>
	</html>
	<?php
	
}
*/
?>