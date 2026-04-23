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
	
	// Total de Páginas
	$totPag = (count($_REQUEST["registros"])/6);
	?>
	<html>
		<head>
			<title>Carteirinhas</title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">		
			<style>
				
				body {
					font-family: Verdana, Arial, Helvetica, sans-serif;
					font-size: xx-small;
					color: #333333;
				}
				
				td {
					font-family: Verdana, Arial, Helvetica, sans-serif;
					font-size: xx-small;
					color: #333333;
				}
			</style>
		</head>
		
		<body style="margin:0px;">
			<?php
			// Lê Páginas
			for($k = 0; $k < $totPag; $k++){
				?>
				<table border="0" cellpadding="2" cellspacing="2" width="750" align="center">
					<?php
					// Lê Matrículas
					for($i = ($k*6); $i < (($k+1)*6); $i++){
						
						// Dados da Matrícula
						$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_REQUEST["registros"][$i] . "' AND turma > 0 AND reprovado = 'N' AND deletado = 'N'");
						
						// Dados do Aluno
						$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");
						
						// Dados da Turma
						$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "'");
						
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
						
						// Verifica coluna
						if($i%2==0){print("</tr><tr>");}
						?>
						<td align='left'>
							<table border="0" cellpadding="2" cellspacing="2" width="375" style="border:2px solid #000000;">
								<tr>
									<td colspan="2" align="center"><b>CONTROLE DE DOCUMENTOS</b></td>
								</tr>
								<tr>
									<td width="15%" align="right"><b>Nome: </b></td>
									<td width='85%' align='left'><?php print($dadosAluno->nome);?></td>
								</tr>
								<tr>
									<td align="right"><b>Turma: </b></td>
									<td align='left'><?php print($dadosCurso->sigla . $dadosTurma->numero . " - <b>Período:</b>&nbsp;(" . $_ClassData->transformaData($dadosTurma->datainicio, 2) . " - " . $_ClassData->transformaData($dadosTurma->datatermino, 2) . ")");?></td>
								</tr>
								<tr>
									<td colspan="2" align="center">
										<table border="0" cellpadding="2" cellspacing="2" width="375" style="border:1px solid #000000;">
											<?php
											// Busca Documentos
											$buscaDocumentos = $_ClassMysql->query("SELECT * FROM `documentos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
											
											// Traz Documentos
											while($trazDocumentos = mysql_fetch_object($buscaDocumentos)){
												
												// Verifica colunas
												if($cont++%4==0){print("</tr><tr>");}
												?>
												<td height="60" valign="top" align="center" style="border-bottom:1px solid #000000;border-right:1px solid #000000;"><font style="font-size:8px"><?php print($trazDocumentos->documento);?></font></td>
												<?php
											}
											
											// Zera Contador
											$cont = 0;
											?>
										</table>
									</td>
								</tr>
							</table>
						</td>
						<?php
						
					}
					?>
				</table>
				<?php if($k < $totPag){?><div style='page-break-after: always;'><span style='display: none;'>&nbsp;</span></div> <?php }?>
				<?php
			}
			?>
		</body>
	</html>
	<?php
}
?>