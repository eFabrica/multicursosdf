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

// Dados da Unidade
$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N' AND acesso = 'L'");

// Mêses
$meses[1]  = "Janeiro";
$meses[2]  = "Fevereiro";
$meses[3]  = "Março";
$meses[4]  = "Abril";
$meses[5]  = "Maio";
$meses[6]  = "Junho";
$meses[7]  = "Julho";
$meses[8]  = "Agosto";
$meses[9]  = "Setembro";
$meses[10] = "Outubro";
$meses[11] = "Novembro";
$meses[12] = "Dezembro";

// Verifica se foi informado algum id separadamente
if($_REQUEST["idMatricula"] > 0){
	
	// Cadastra ele na lista
	$_REQUEST["registros"][] = $_REQUEST["idMatricula"];
	
}

// Verifica se foi encontrado algo
if(count($_REQUEST["registros"]) > 0){
	?>
	<html>
		<head>
			<title>Declaração de Matrícula</title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">		
			<style>
				
				input{
	
					font-family:"Times New Roman", Times, serif;
					color:#00000;
					border:0px;
					text-align:center;
					width:250px;
				
				}
				
				h1, h2, h3, h4, p {margin:0px;}
			</style>
		</head>
		
		<body style="margin:0px;">
			<?php
			// Lê Matrículas
			for($i = 0; $i < count($_REQUEST["registros"]); $i++){
				
				// Dados da Matrícula
				$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_REQUEST["registros"][$i] . "' AND turma > 0 AND reprovado = 'N' AND deletado = 'N'");
				
				// Dados do Aluno
				$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");
				
				// Dados da Turma
				$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "'");
				
				// Dados do Curso
				$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
				
				// Dados do Turno
				$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno ."'");
				
				// Separa data de Início da Turma
				list($anoi, $mesi, $diai) = explode("-", $dadosTurma->datainicio);
				
				// Separa data de Término da Turma
				list($anot, $mest, $diat) = explode("-", $dadosTurma->datatermino);
				
				// Separa data atual
				list($anoa, $mesa, $diaa) = explode("-", date("Y-m-d"));
				?>
				<table width="650" border="0" cellspacing="0" cellpadding="0" style="margin-top:250px;" align="center">
					<tr>
						<td align="center"><b><?php print(strtoupper($dadosUnidade->razaosocial));?></b></td>
					</tr> 
					<tr>
						<td align="center"><b><?php print("CNPJ Nº " . $_ClassUtilitarios->formataCNPJ($dadosUnidade->cnpj));?></b></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td style="border:2px solid #000000;" align="center"><h2><?php print("DECLARAÇÃO DE MATRÍCULA");?></h2></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'>
							<div align="justify" style="line-height:200%;">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								Declaramos para os devidos fins que o Senhor(a) <strong><?php print(strtoupper($dadosAluno->nome));?></strong>,
								está matriculado(a) no curso de <strong> <?php print(strtoupper($dadosCurso->nome));?> </strong>
								que será realizado no período de <strong><?php print($diai . " de " . $meses[(($mesi < 10)?str_replace("0", "", $mesi):$mesi)] . " de " . $anoi);?> </strong>
								a<strong> <?php print($diat . " de " . $meses[(($mest < 10)?str_replace("0", "", $mest):$mest)] . " de " . $anot);?></strong> 
								de segunda-feira à sexta-feira das <?php print($dadosTurno->horarioi . " Hrs às " . $dadosTurno->horariof . " Hrs.");?>
							</div>
						</td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align="center">Brasília – DF, <?php print($diaa . " de " . $meses[(($mesa < 10)?str_replace("0", "", $mesa):$mesa)] . " de " . $anoa);?>.</td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align='left'><br /></td>
					</tr>
					<tr>
						<td align="center"><input type="text" value="<?php print($_dadosLogado->nome);?>"><br /><input type="text" value="<?php print($_dadosLogado->cargo);?>"></td>
					</tr>
				</table>
				<div style='page-break-after: always;'><span style='display: none;'>&nbsp;</span></div> 
				<?php
			}
			?>
		</body>
	</html>
	<?php
}
?>