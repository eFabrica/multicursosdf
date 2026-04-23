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

// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
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

// Busca Matrículas
$buscaMatriculas = $_ClassMysql->query($sql);

// Traz Matrículas
while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){$matriculas[] = $trazMatriculas->id;}

// Verifica Contador
if($_REQUEST["cont"] != ""){
	
	// Contador
	$contador = $_REQUEST["cont"];
	
}else{
	
	// Lê Matrículas 
	while ($lendoMatricula = current($matriculas)) { 
		
		// Verifica Atual
		if ($lendoMatricula == $_REQUEST["idMatricula"]) { $contador = key($matriculas); } 
		
		// Avança ponteiro do arrau
		next($matriculas);
		 
	} 
	
}

// Dados da Matrícula
$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . (($_REQUEST["cont"] != "")?$matriculas[$contador]:$_REQUEST["idMatricula"]) . "'");

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");

// Dados do Turno
$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");

// Dados da Matéria
$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $dadosMatricula->materia . "'");

// Dados do Aluno
$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");

// Verifica Ação
if($_REQUEST["act"] == "baixa"){
	
	// Lê registros
	for($r = 0; $r < count($_REQUEST["registros"]); $r++){
	
		// Deleta Falta de Documento
		$_ClassMysql->query("UPDATE `faltadocumentos` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = NOW() WHERE id = '" . $_REQUEST["registros"][$r] . "'");
		
	}
	
	// Redireciona
	print($_ClassUtilitarios->redirecionarJS("?idMatricula=" . $_REQUEST["idMatricula"] . "&cont=" . $_REQUEST["cont"], 1, array("Foi dada baixa em " . count($_REQUEST["registros"]) . " documentos com sucesso!")));
	
}
?>
<html>
	<head>
		<?php require_once($pathInc . "includes/head.php"); ?>
	</head>
	
	<body>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align='left'><a href="?idMatricula=<?php print($_REQUEST["idMatricula"]);?>&cont=<?php print((($matriculas[($contador-1)] > 0)?($contador-1):0)); ?>"><img src="<?php print($pathInc . "imagens/icones/b_anterior.png");?>" border="0"></a></td>
				<td width="100%"></td>
				<td align="right"><a href="?idMatricula=<?php print($_REQUEST["idMatricula"]);?>&cont=<?php print((($matriculas[($contador+1)] > 0)?($contador+1):$contador)); ?>"><img src="<?php print($pathInc . "imagens/icones/b_proximo.png");?>" border="0"></a></td>
			</tr>
			<tr>
				<td colspan="3" class="menu_topico">Dados da Matrícula</td>
			</tr>
			<tr>
				<td colspan="3">
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
				<td colspan="3" class="menu_topico">Listagem dos Documentos em Falta</td>
			</tr>
			<tr>
				<td colspan="3">
					<form action="" method="POST" name="faltaDocumentos">
						<input type="hidden" name="act" value="baixa">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td align='left'><input type="checkbox" onclick="select_all('faltaDocumentos', 'registros[]')"></td>
								<td width="100%">Todos</td>
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
										<td align='left'><?php if($dadosTurma->concluido == 'N'){?><input type="checkbox" name="registros[]" value="<?=$trazDocumentosFalta->id?>"><?php }?></td>
										<td align='left'><?php print($dadosDocumento->documento);?></td>
									</tr>
									<?php
									
								}
								
								?>
								<tr>
									<td align='left'>&nbsp;</td>
									<td align='left'><?php print($_ClassUtilitarios->criaMenu("Dar Baixa", "#", "document.faltaDocumentos.submit();", "esq", "007", $pathInc)); ?></td>
								</tr>
								<?php
								
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
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td align='left'>
				</td>
			</tr>
		</table>
	</body>
</html>