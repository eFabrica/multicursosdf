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

// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");
	
// Dados da Matrícula
$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_REQUEST["idMatricula"] . "'");

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $dadosMatricula->turma . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");

// Dados do Turno
$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");

// Dados da Matéria
$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $dadosMatricula->materia . "'");

// Dados do Aluno
$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");

// Verifica Ação
if($_REQUEST["ref"] == "deletar"){
	
	// Deleta Falta de Documento
	$_ClassMysql->query("UPDATE `faltadocumentos` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = NOW() WHERE id = '" . $_REQUEST["idFDocumento"] . "'");
	
	// Redireciona
	print($_ClassUtilitarios->redirecionarJS("?idMatricula=" . $_REQUEST["idMatricula"], 1, array("Falta de documento deletada com sucesso!")));
	
}
?>
<html>
	<head>
		<?php require_once($pathInc . "includes/head.php"); ?>
	</head>
	
	<body>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="menu_topico">Dados da Matrícula</td>
			</tr>
			<tr>
				<td align='left'>
					<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
						<tr>
							<td align="right" width="15%"><b>Aluno:</b></td>
							<td width='85%' align='left'><?php print($dadosAluno->nome . " (" . $_ClassUtilitarios->formataCPF($dadosAluno->cpf) . ")");?></td>
						</tr>
						<tr>
							<td align="right"><b>Turma:</b></td>
							<td align='left'><?php print($dadosCurso->sigla . $dadosTurma->numero);?></td>
						</tr>
						<tr>
							<td align="right"><b>Truno:</b></td>
							<td align='left'><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof);?></td>
						</tr>
						<tr>
							<td align="right"><b>Concluído:</b></td>
							<td align='left'><img src="<?php print($pathInc);?>imagens/diversos/<?php print((($dadosMatricula->reprovado == "S")?"X.png":$dadosMatricula->concluido));?>.png"></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="menu_topico">Listagem dos Documentos em Falta</td>
			</tr>
			<?php
			// Busca Documentos Em Falta
			$buscaDocumentosFalta = $_ClassMysql->query("SELECT * FROM `faltadocumentos` WHERE matricula = '" . $dadosMatricula->id . "' AND deletado = 'N'");
			
			// Verifica total achado
			if(mysql_num_rows($buscaDocumentosFalta) > 0){
			
				// Traz Documentos em Falta
				while ($trazDocumentosFalta = mysql_fetch_object($buscaDocumentosFalta)) {
					
					// Dados do Documento
					$dadosDocumento = $_ClassRn->getDadosTable("documentos", "*", "id = '" . $trazDocumentosFalta->documento . "'");
					?>
					<tr>
						<td align='left'><li style="margin-left:50px;"><?php print($dadosDocumento->documento);?></li></td>
					</tr>
					<?php
					
				}
				
			}else{
				
				?>
				<tr>
					<td align='left'><br></td>
				</tr>
				<tr>
					<td align="center">Nenhum documento encontrado.</td>
				</tr>
				<?php
				
			}
			?>
			<tr>
				<td align='left'>
				</td>
			</tr>
		</table>
	</body>
</html>