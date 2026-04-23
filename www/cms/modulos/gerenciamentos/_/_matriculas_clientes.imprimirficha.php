<?php
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
		$_dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "master")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N'");
	
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
			<title>Fichas</title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">		
			<style>
				body {
					font-family: Verdana, Arial, Helvetica, sans-serif;
					font-size: 12px;
					color: #333333;
				}
				
				td {
					font-family: Verdana, Arial, Helvetica, sans-serif;
					font-size: 12px;
					color: #333333;
				}
				
				h1, h2, h3, h4, p {margin:0px;}
				
				div#certificado {border:1px solid 2px;width:100%;height:100%;}
			</style>
		</head>
		
		<body style="margin:50px;">
			<?php
			// Lê Matrículas
			for($i = 0; $i < count($_REQUEST["registros"]); $i++){
				
				// Dados da Matrícula
				$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_REQUEST["registros"][$i] . "' AND empresa > 0");
				
				// Dados do Aluno
				$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");
				
				// Dados da Cidade
				$dadosCidade = $_ClassRn->getDadosTable("cidades", "*", "id = '" . $dadosAluno->cidade . "'");
				
				// Dados da Empresa
				$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $dadosMatricula->empresa . "'");
				
				// Dados da Turma
				$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "'");
				
				// Dados do curso
				$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
				
				// Dados do Turno
				$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
				?>
				<table border="0" cellpadding="2" cellspacing="2" width="100%">
					<tr>
						<td align="center" colspan="2"><img src="<?php print($pathInc);?>imagens/diversos/logo.jpg"></td>
					</tr>
					<tr>
						<td colspan="2" style="border:1px solid #000000;" align="center"><font style="font-size:14px;"><b>FICHA DE MATRÍCULA - EMPRESA</b></font></td>
					</tr>
					<tr>
						<td align="right" width="15%"><b>Curso Solicidade: </b></td>
						<td width='85%' align='left'><?php print($dadosCurso->nome);?></td>
					</tr>
					<tr>
						<td align="right"><b>Turma: </b></td>
						<td align='left'><?php print($dadosCurso->sigla . $dadosTurma->numero . "&nbsp;<b>Data Início: </b>" . $_ClassData->transformaData($dadosTurma->datainicio, 2));?></td>
					</tr>
					<tr>
						<td align="right"><b>Turno: </b></td>
						<td align='left'><?php print($dadosTurno->horarioi . " às " . $dadosTurno->horariof);?></td>
					</tr>
					<tr>
						<td align="right"><b>Aluno(a): </b></td>
						<td align='left'><?php print($dadosAluno->nome);?></td>
					</tr>
					<tr>
						<td align="right"><b>Dt. Nasc.: </b></td>
						<td align='left'><?php print($_ClassData->transformaData($dadosAluno->datanascimento, 2) . "&nbsp;<b>CPF:</b> " . $_ClassUtilitarios->formataCPF($dadosAluno->cpf));?></td>
					</tr>
					<tr>
						<td align="right"><b>Endereço: </b></td>
						<td align='left'><?php print($dadosAluno->endereco);?></td>
					</tr>
					<tr>
						<td align="right"><b>Cidade/UF: </b></td>
						<td align='left'><?php print($dadosCidade->cidade . "/" . $dadosCidade->estado . "&nbsp;<b>CEP:</b> " . $dadosAluno->cep . "&nbsp;<b>Telefone: </b>" . $dadosAluno->telefone);?></td>
					</tr>
					<tr>
						<td align="right"><b>Empresa: </b></td>
						<td align='left'><?php print($dadosEmpresa->razaosocial . " <b>CNPJ: </b> " . $_ClassUtilitarios->formataCNPJ($dadosEmpresa->cnpj));?></td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" style="background-image:url(<?php print($pathInc . "imagens/diversos/linha.png");?>);background-repeat:repeat-x;">&nbsp;</td>
					</tr>
				</table>
				<?php
				// Verifica contador
				if(++$cont%2 == 0){
				?>
				<div style='page-break-after: always;'><span style='display: none;'>&nbsp;</span></div>
				<?php
				}
			
			}
			?>
		</body>
	</html>
	<?php
}
?>