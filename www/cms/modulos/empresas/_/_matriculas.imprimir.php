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
		<title>Relatório de Matrículas</title>
		<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
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
					<h2><u>Relatório de Matrículas</u></h2>
					<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
				</td>
			</tr>
			<tr>
				<td align="left"><h2>Filtrando por:</h2></td>
			</tr>
			<?php
			// Verifica se foi habilitado o campo de Período
			if($_SESSION["consultaMatriculasPrivadas"]["dataI"] != ""){
				?>
				<tr>
					<td align="left"><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaMatriculasPrivadas"]["dataI"]?> até <?php echo $_SESSION["consultaMatriculasPrivadas"]["dataF"]?></ol></td>
				</tr>
				<?php
			}
			
			// Verifica se foi habilitado o campo de curso
			if($_SESSION["consultaMatriculasPrivadas"]["curso"] > 0){
				
				// Dados do Curso
				$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $_SESSION["consultaMatriculasPrivadas"]["curso"] . "'");
				?>
				<tr>
					<td align="left"><ol><strong>Curso:</strong>&nbsp;<?php print($dadosCurso->sigla . " - " . $dadosCurso->nome);?></ol></td>
				</tr>
				<?php
			}
			?>
		</table>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td width="1%" align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>#</b></th>
				<td width="50%" align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Nome</b></th>
				<td width="20%" align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>CPF</b></th>
				<td width="15%" align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Nascimento</b></th>
				<td width="15%" align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Turma</b></th>
			</tr>
			<?php
			/* Construindo sql */
			$sql = "SELECT matriculas.id,
						   alunos.nome,
						   alunos.datanascimento,
						   alunos.cpf,
						   turmas.datainicio FROM `alunos`, `matriculas`, `turmas`";
			$sql .= " WHERE ";
			$sql .= (($_SESSION["consultaMatriculasPrivadas"]["dataI"] != "")?" turmas.datainicio >= '" . $_ClassData->transformaData($_SESSION["consultaMatriculasPrivadas"]["dataI"]) . "' AND turmas.datainicio <= '" . $_ClassData->transformaData($_SESSION["consultaMatriculasPrivadas"]["dataF"]) . "' AND":"");
			$sql .= (($_SESSION["consultaMatriculasPrivadas"]["curso"] > 0)?" turmas.curso = '" . $_SESSION["consultaMatriculasPrivadas"]["curso"] . "' AND":"");
				
			$sql .= " matriculas.deletado = 'N' AND
					  turmas.deletado = 'N' AND
					  alunos.deletado = 'N' AND
					  matriculas.aluno = alunos.id AND
					  turmas.id = matriculas.turma AND 
					  matriculas.empresa = '" . $_dadosLogado->empresa . "' ORDER BY alunos.nome ASC";

			/* Fim da construção */
			
			// Busca matrículas
			$buscaMatriculas = mysql_query($sql);
			
			// Traz Matrículas
			while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
				
				// Total
				++$total;
				?>
				<tr>
					<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;<?php print($trazMatriculas->id); ?></td>
					<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;<?php print($trazMatriculas->nome);?></td>
					<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;<?php print($_ClassUtilitarios->formataCPF($trazMatriculas->cpf));?></td>
					<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;<?php print($_ClassData->transformaData($trazMatriculas->datanascimento, 2)); ?></td>
					<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;<?php print($_ClassData->transformaData($trazMatriculas->datainicio, 2)); ?></td>
				</tr>
				<?php
				
			}
			?>
			<tr>
				<td colspan="4" align="right" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Total&nbsp;de&nbsp;Matrículas: </b></td>
				<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;">&nbsp;<?php print($total);?></td>
			</tr>
		</table>
	</body>
</html>