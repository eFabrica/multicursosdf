<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
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
?>
<html>
	<head>
		<title>Relatório de Horas Aula Geral</title>
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
					<h2><u>Relatório de Horas Aula Geral</u></h2>
					<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
				</td>
			</tr>
			<tr>
				<td align='left'><h2>Filtrando por:</h2></td>
			</tr>
			<tr>
				<td align='left'><ol><strong>Data:</strong>&nbsp;De <?php print($_REQUEST["dataI"]);?> até <?php print($_REQUEST["dataF"])?></ol></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
			<tr>				
				<td align="center" width="150" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><font style="font-size:7px;"><b>Instrutor</b></font></td>
				<?php
				// Busca Turmas neste período
				$buscaTurmas = $_ClassMysql->query("SELECT turmas.curso,
														   turmas.numero FROM `turmas`, `diarioclasse` WHERE diarioclasse.turma = turmas.id AND
																											 turmas.unidade = '" . $_dadosUnidade->id . "' AND 
																											 turmas.deletado = 'N' AND
																											 diarioclasse.unidade = '" . $_dadosUnidade->id . "' AND
																											 diarioclasse.deletado = 'N' AND 
																											 diarioclasse.data >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND diarioclasse.data <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' GROUP BY turmas.id ORDER BY curso, numero ASC");
				
				// Total de Turmas
				$totTurmas = mysql_num_rows($buscaTurmas);
				
				// Traz Turmas
				while($trazTurmas = mysql_fetch_object($buscaTurmas)){
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazTurmas->curso . "'");
					?>
					<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><font style="font-size:7px;"><b><?php print($dadosCurso->sigla . $trazTurmas->numero);?></b></font></td>
					<?php
				}
				?>
				<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><font style="font-size:7px;"><b>Total</b></font></td>
				<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><font style="font-size:7px;"><b>Valor&nbsp;Total</b></font></td>
			</tr>
			<?php
			// Busca Instrutores
			$buscaInstrutores = $_ClassMysql->query("SELECT * FROM `usuarios` WHERE unidade = '" . $_dadosUnidade->id . "' AND nivel = '95' AND deletado = 'N'");
			
			// Traz Instrutores
			while($trazInstrutores = mysql_fetch_object($buscaInstrutores)){
				
				?>
				<tr>
					<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><font style="font-size:7px;"><?php print($_ClassUtilitarios->abreviaNome1($trazInstrutores->nome));?></font></td>
					<?php
					// Busca Turmas neste período
					$buscaTurmas = $_ClassMysql->query("SELECT turmas.id FROM `turmas`, `diarioclasse` WHERE diarioclasse.turma = turmas.id AND
																											 turmas.unidade = '" . $_dadosUnidade->id . "' AND 
																											 turmas.deletado = 'N' AND
																											 diarioclasse.unidade = '" . $_dadosUnidade->id . "' AND
																											 diarioclasse.deletado = 'N' AND 
																											 diarioclasse.data >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND diarioclasse.data <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' GROUP BY turmas.id ORDER BY curso, numero ASC");
						
					// Traz Turmas
					while($trazTurmas = mysql_fetch_object($buscaTurmas)){
						
						// Busca Diários de Classe neste período
						$buscaDiariosClasse = $_ClassMysql->query("SELECT SUM(horasaula) as totDiariosClasse FROM `diarioclasse` WHERE unidade = '" . $_dadosUnidade->id . "' AND data >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND data <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' AND instrutor = '" . $trazInstrutores->id . "' AND turma = '" . $trazTurmas->id . "' AND deletado = 'N'");
						
						// Total de Diários de Classe neste período
						$totDiariosClasse = mysql_result($buscaDiariosClasse, 0, "totDiariosClasse");
						
						// Total de Horas Aula por Turma
						$totHAPTurma[$trazTurmas->id] += $totDiariosClasse;
						
						// Total de Horas Aula por Instrutor
						$totHAInstrutor[$trazInstrutores->id] += $totDiariosClasse;
						?>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;<font style="font-size:7px;"><b><?php print($totDiariosClasse);?></b></font></td>
						<?php
					}
					?>
					<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;<font style="font-size:7px;"><b><?php print($totHAInstrutor[$trazInstrutores->id]);?></b></font></td>
					<td align="right" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><font style="font-size:7px;">R$&nbsp;<b><?php print($_ClassDinheiro->formataMoeda($totHAInstrutor[$trazInstrutores->id]*$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor"])));?></b></font></td>
				</tr>
				<?php
				
			}
			?>
			<tr>
				<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;" align="right"><font style="font-size:7px;"><b>Total:</b></font></td>
				<?php
				// Busca Turmas neste período
				$buscaTurmas = $_ClassMysql->query("SELECT turmas.id FROM `turmas`, `diarioclasse` WHERE diarioclasse.turma = turmas.id AND
																										 turmas.unidade = '" . $_dadosUnidade->id . "' AND 
																										 turmas.deletado = 'N' AND
																										 diarioclasse.unidade = '" . $_dadosUnidade->id . "' AND
																										 diarioclasse.deletado = 'N' AND 
																										 diarioclasse.data >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND diarioclasse.data <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' GROUP BY turmas.id ORDER BY curso, numero ASC");
				
				// Traz Turmas
				while($trazTurmas = mysql_fetch_object($buscaTurmas)){
					
					// Total Geral
					$totGeral += $totHAPTurma[$trazTurmas->id];
					?>
					<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><font style="font-size:7px;">&nbsp;<b><?php print($totHAPTurma[$trazTurmas->id]);?></b></font></td>
					<?php
					
				}
				?>
				<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;<font style="font-size:7px;"><b><?php print($totGeral);?></b></font></td>
				<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;" align="right"><font style="font-size:7px;">R$ <?php print($_ClassDinheiro->formataMoeda($totGeral*$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor"])));?></font></td>
			</tr>
		</table>
	</body>
</html>