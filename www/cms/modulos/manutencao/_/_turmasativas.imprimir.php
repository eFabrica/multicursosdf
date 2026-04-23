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

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $_REQUEST["idTurma"] . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");

// Dados do Turno
$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
?>
<html>
	<head>
		<title>Relatório de Inconsistências</title>
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
		<table width="100%"%" border="0" cellpadding="2" cellspacing="2">
			<tr>
				<td align="center" colspan="2">
					<h2><u>Relatório de Inconsistências</u></h2>
					<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br />					
				</td>
			</tr>
			<tr>
				<td align="center"><b>Turma: </b><?php print($dadosCurso->sigla . $dadosTurma->numero);?></td>
			</tr>
			<tr>
				<td align="center"><b>Turno: </b><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof);?></td>
			</tr>
		</table>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td align='left'>
					<?php
					// Busca Matrículas
					$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $_REQUEST["idTurma"] . "' AND deletado = 'N' GROUP BY aluno");
					
					// Traz Matrículas
					while ($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
						
						// Pemissão
						$permissao = true;
						
						// Dados do Aluno
						$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");
						?>
						<fieldset>
							<legend><?php print($dadosAluno->nome . " (" . $_ClassUtilitarios->formataCPF($dadosAluno->cpf) . ")" . (($trazMatriculas->concluido == "S")?" (Concluído)":(($trazMatriculas->reprovado == "S")?" (Reprovado)":" (Pendente)")));?></legend>
							<table border="0" cellpadding="0" cellspacing="0" width="100%">
								<?php
								// Verifica curso
								if(strtoupper(substr($dadosCurso->sigla, 0, 2)) != "FO"){
									
									// Verifica dados de formação desse aluno
									if($dadosAluno->numerorg == "" ||
									   $dadosAluno->academiaform == "" ||
									   $dadosAluno->dataform == "" ||
									   $dadosAluno->orgao == ""){
									   	
										// Exibe mensagem
										print("<b>Dados de Formação Incompletos</b><br />");
										
										// Permissão
										$permissao = false;
										
									}
									
								}
								
								// Busca Falta de Documentos
								$buscaFaltaDocumentos = $_ClassMysql->query("SELECT * FROM `faltadocumentos` WHERE matricula = '" . $trazMatriculas->id . "' AND deletado = 'N'");
								
								// Total achado
								$totalFaltaDocumentos = mysql_num_rows($buscaFaltaDocumentos);
								
								// Busca Parcelas
								$buscaParcelas = $_ClassMysql->query("SELECT * FROM `parcelas` WHERE matricula = '" . $trazMatriculas->id . "' AND paga = 'N' AND deletado = 'N'");
								
								// Total achado
								$totalParcelas = mysql_num_rows($buscaParcelas);
								
								// Verifica o total achado de falta de documentos
								if($totalFaltaDocumentos > 0){
									
									// Traz Documentos em Falta
									while($trazFaltaDocumentos = mysql_fetch_object($buscaFaltaDocumentos)){
										
										// Dados do Documento
										$dadosDocumento = $_ClassRn->getDadosTable("documentos", "*", "id = '" . $trazFaltaDocumentos->documento . "'");
										
										// Exibe mensagem
										print("<b>Falta do documento:&nbsp;</b>" . $dadosDocumento->documento . "<br />");
										
									}
									
								}
								
								// Verifica o total achado de parcelas
								if($totalParcelas > 0){
									
									// Traz Parcela pendente
									while($trazParcelas = mysql_fetch_object($buscaParcelas)){
										
										// Verifica tipo
										if($trazParcelas->tipo == "B"){
											
											// Exibe mensagem
											print("<b>Percela " . $trazParcelas->numero . " do Boleto Pendente:&nbsp;</b><b>Valor</b>:&nbsp;R$ " . $_ClassDinheiro->formataMoeda($trazParcelas->valor) . " <b>|</b> <b>Data</b>: " . $_ClassData->transformaData($trazParcelas->data, 2) . "<br />");
											
										}else{
											
											// Exibe mensagem
											print("<b>Percela " . $trazParcelas->numero . " do Cheque Pendente:&nbsp;</b><b><b>Valor</b></b>: R$ " . $_ClassDinheiro->formataMoeda($trazParcelas->valor) . " <b>|</b> <b>Data</b>: " . $_ClassData->transformaData($trazParcelas->data, 2) . " <b>|</b> <b>Bco</b>: " . $trazParcelas->bco . " <b>|</b> <b>N. CH.</b>: " . $trazParcelas->numeroch . "<br />");
											
										}
										
									}
									
								}
								
								// Verifica Inconsistências
								if(($totalFaltaDocumentos+$totalParcelas) == 0 && $permissao){
									
									// Exibe Mensagem
									print("<tr><td align='left'>Nenhuma Inconsistência.</td></tr>");
									
								}
								?>
							</table>
						</fieldset>
						<?php
						
					}
					?>
				</td>
			</tr>
		</table>
	</body>
</html>