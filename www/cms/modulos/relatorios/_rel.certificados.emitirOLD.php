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
			<title>Certificados</title>
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
				
				div#certificado {border:1px solid 2px;width:100%;height:100%;}
			</style>
		</head>
		
		<body style="margin:0px;">
			<?php
			// Lê Matrículas
			for($i = 0; $i < count($_REQUEST["registros"]); $i++){
				
				// Dados da Matrícula
				$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_REQUEST["registros"][$i] . "' AND turma > 0 AND reprovado = 'N' AND deletado = 'N'");
				
				// Verifica o total achado
				if($dadosMatricula->concluido == 'S'){
				
					// Dados do Aluno
					$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "'");
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
					
					// Separa data de Início da Turma
					list($anoi, $mesi, $diai) = explode("-", $dadosTurma->datainicio);
					
					// Separa data de Término da Turma
					list($anot, $mest, $diat) = explode("-", $dadosTurma->datatermino);
					
					// Separa data atual
					list($anoa, $mesa, $diaa) = explode("-", date("Y-m-d"));
				
					// Verifica Curso
					if(substr(strtolower($dadosCurso->sigla), 0, 2) != "re"){
						
						// Verifica qual lado do certificado
						if($_REQUEST["tipo"] == "frente" || $_REQUEST["idMatricula"] > 0){
							?>
							<table width="850" height="142" border="0" cellspacing="0" cellpadding="0" style="margin-top:500px;margin-left:85px;">
								<tr>
									<td align="left">
										<div align="justify"> Certificamos que o(a) Senhor(a) <strong><?php print($dadosAluno->nome);?></strong>,
										 RG nº <?php print($dadosAluno->rg)?>/<?php print($dadosAluno->orgexp)?> e CPF nº <?php print($_ClassUtilitarios->formataCPF($dadosAluno->cpf));?>, frequentou e concluiu com aproveitamento o curso de 
										<strong><?php print(strtoupper($dadosCurso->nome));?> (</strong>Turma:<strong><?php print($dadosCurso->sigla . $dadosTurma->numero);?></strong><strong>),</strong> 
										 ministrado no período de<strong> 
										<?php print($diai . " de " . $meses[(($mesi < 10)?str_replace("0", "", $mesi):$mesi)] . " de " . $anoi);?> </strong>a<strong> <?php print($diat . " de " . $meses[(($mest < 10)?str_replace("0", "", $mest):$mest)] . " de " . $anot);?> </strong>
						