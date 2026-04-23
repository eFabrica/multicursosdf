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

// SQL
$sql = "SELECT matriculas.turma, 
			   matriculas.id,
			   matriculas.numero,
			   matriculas.concluido,
			   alunos.nome FROM `matriculas`,`faltadocumentos`,`alunos` WHERE ";

// Where
$where =  " faltadocumentos.matricula = matriculas.id AND 
			alunos.id = matriculas.aluno AND
		    faltadocumentos.deletado = 'N' AND 
		    matriculas.deletado = 'N' AND
		    alunos.deletado = 'N' AND 
		    matriculas.unidade = '" . $_dadosUnidade->id . "' AND ";

// Verifica se a pesquisa foi por todas as faltas
if($_SESSION["consultaFaltaDocumentos"]["todas"] != "sim"){
	
	// Verifica se foi habilitado o campo de Turma
	if($_SESSION["consultaFaltaDocumentos"]["habilitarTurma"] == "sim"){
		
		// WHERE
		$where .= " matriculas.turma = '" . $_SESSION["consultaFaltaDocumentos"]["turma"] . "' AND ";
		
	}
	
	// Verifica se foi habilitado o campo de palavra-chave
	if($_SESSION["consultaFaltaDocumentos"]["habilitarPalavraChave"] == "sim"){
		
		// SQL
		$sql .= $where . " alunos.rg LIKE '%" . $_SESSION["consultaFaltaDocumentos"]["texto"] . "%' OR ";
		$sql .= $where . " alunos.cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_SESSION["consultaFaltaDocumentos"]["texto"]) . "%' OR ";
		$sql .= $where . " alunos.nome LIKE '%" . $_SESSION["consultaFaltaDocumentos"]["texto"] . "%' OR ";
		$sql .= $where . " alunos.email LIKE '%" . $_SESSION["consultaFaltaDocumentos"]["texto"] . "%' OR ";
		$sql .= $where . " matriculas.numero LIKE '%" . $_SESSION["consultaFaltaDocumentos"]["texto"] . "%' OR ";
		
	}else{
		
		// SQL
		$sql .= $where;
		
	}
	
	// SQL
	$sql .= "{aqui}";
	$sql = str_replace("OR {aqui}", "", $sql);
	$sql = str_replace("AND {aqui}", "", $sql);
	
}else{
	
	// SQL
	$sql .= $where;
	
	// SQL
	$sql .= "{aqui}";
	$sql = str_replace("OR {aqui}", "", $sql);
	$sql = str_replace("AND {aqui}", "", $sql);
	
}

// SQL
$sql .= " GROUP BY matriculas.id ORDER BY alunos.nome ASC";
/* Fim da construção */

// Busca Falta de Documentos
$buscaFaltaDocumentos = $_ClassMysql->query($sql);
?>
<html>
	<head>
		<title>Relatório de Falta de Documentos</title>
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
					<h2><u>Relatório de Falta de Documentos</u></h2>
					<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
				</td>
			</tr>
			<tr>
				<td align='left'><h2>Filtrando por:</h2></td>
			</tr>
			<?php
			// Verifica se a busca é por todas as notas fiscais
			if($_SESSION["consultaFaltaDocumentos"]["todas"] == "sim"){
				?>
				<tr>
					<td align='left'><ol><strong>Todas as Faltas de Documentos</strong></ol></td>
				</tr>
				<?php
			}
			 
			// Verifica se foi habilitado o campo de Palavra-Chave
			if($_SESSION["consultaFaltaDocumentos"]["habilitarPalavraChave"] == "sim"){
				?>
				<tr>
					<td align='left'><ol><strong>Palavra-Chave:</strong>&nbsp;<?php echo $_SESSION["consultaFaltaDocumentos"]["texto"]?></ol></td>
				</tr>
				<?php
			}
			
			// Verifica se foi habilitado o campo de turma
			if($_SESSION["consultaFaltaDocumentos"]["habilitarTurma"] == "sim"){
				
				// Dados da Turma
				$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaFaltaDocumentos"]["turma"] . "'");
				
				// Dados do Curso
				$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
				?>
				<tr>
					<td align='left'><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></td>
				</tr>
				<?php
			}
			?>
		</table>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td align="center" width="30%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Aluno</b></td>
				<td align="center" width="10%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Curso/Turma</b></td>
				<td align="center" width="60%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Documentos em Falta</b></td>
			</tr>
			<?php		
			// Traz Falta de Documentos
			while($trazFaltaDocumentos = mysql_fetch_object($buscaFaltaDocumentos)){
				
				// Busca Falta de Documentos
				$buscaDocumentosEmFalta = $_ClassMysql->query("SELECT id,documento FROM `faltadocumentos` WHERE matricula = '" . $trazFaltaDocumentos->id . "' AND deletado = 'N'");
				
				// Verifica total achado
				if(mysql_num_rows($buscaDocumentosEmFalta) > 0){
				
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $trazFaltaDocumentos->turma . "'");
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
					
					// Dados do Aluno
					//$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazFaltaDocumentos->aluno . "'");
					?>
					<tr>
						<td valign="top" style="border-bottom:1px solid #333333;border-right:1px solid #333333;""><?php print($trazFaltaDocumentos->nome);?></td>
						<td align="center" valign="top" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
						<td valign="top" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">
						<?php
						// Traz Documento em Falta
						while ($trazDocumentosEmFalta = mysql_fetch_object($buscaDocumentosEmFalta)) {
							
							// Dados do documento
							$dadosDocumento = $_ClassRn->getDadosTable("documentos", "documento", "id = '" . $trazDocumentosEmFalta->documento . "'");
							
							// Mostra Documento
							print($dadosDocumento->documento . "<br>");
							
						}
						?>
						</td>
					</tr>
					<?php
				}
				
			}
			?>			
		</table>
	</body>
</html>