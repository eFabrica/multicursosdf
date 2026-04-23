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

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_REQUEST["turma"] . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");

// Contador
$cont = 1;
?>
<html>
	<head>
		<title>Ficha Cadastral - Turma: <?php print($dadosCurso->sigla . $dadosTurma->numero);?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
					<h2><u>Relatório de Ficha Cadastral (<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?>)</u></h2>
					<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
				</td>
			</tr>
		</table>
		<?php
		// Busca Matrículas
		$buscaMatriculas = $_ClassMysql->query("SELECT matriculas.aluno,
													   alunos.cidade,
													   matriculas.empresa,
													   alunos.nome FROM `matriculas`,`alunos` WHERE matriculas.turma = '" . $dadosTurma->id . "' AND 
																								    alunos.id = matriculas.aluno AND
																								    alunos.deletado = 'N' AND
											   													    matriculas.deletado = 'N' ORDER BY alunos.nome");
	
		// Verifica o total achado
		if(mysql_num_rows($buscaMatriculas) > 0){
			
			// Traz Matrículas
			while($trazMatricula = mysql_fetch_object($buscaMatriculas)){
				
				// Dados do Aluno
				$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatricula->aluno . "'");
				
				// Dados da cidade
				$dadosCidade = $_ClassRn->getDadosTable("cidades", "cidade", "id = '" . $trazMatricula->cidade . "'");
				
				// Verifica se tem empresa
				if($trazMatricula->empresa > 0){
					
					// Dados da Empresa
					$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $trazMatricula->empresa . "'");
					
				}
				?>
				<hr noshade />
				<table border=0 cellspacing=0 cellpadding=0 >
					<tr height=20 >
						<td width=3>&nbsp;</td>
						<td width=714><?php print($cont++);?> - <b>Turma:</b>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
					</tr>
				</table>
				<table border=0 cellspacing=0 cellpadding=0 >
					<tr height=15 >
						<td width=6>&nbsp;</td>
						<td width=352><b>Nome:</b>&nbsp;<?php print($dadosAluno->nome);?></td>
						<td width=339><b>Data nasc:</b>&nbsp;<?php print($_ClassData->transformaData($dadosAluno->datanascimento, 2));?></td>
					</tr>
				</table>
				<table border=0 cellspacing=0 cellpadding=0 >
					<tr height=15>
						<td width=6><br></td>
						<td width=711><b>Filia&ccedil;&atilde;o:</b>&nbsp;<?php print($dadosAluno->pai . " & " . $dadosAluno->mae);?></td>
					</tr>
				</table>
				<table border=0 cellspacing=0 cellpadding=0 >
					<tr height=15 >
						<td width=6> <br></td>
						<td width=140><b>Cpf:</b>&nbsp;<?php print($_ClassUtilitarios->formataCPF($dadosAluno->cpf));?></td>
						<td width=64><b>Sexo:</b>&nbsp;<?php print($dadosAluno->sexo);?></td>
						<td width=237><b>Naturalidade:</b>&nbsp;<?php print($dadosAluno->naturalidade);?></td>
						<td width=270><b>UF:</b>&nbsp;<?php print($dadosAluno->ufnaturalidade);?></td>
					</tr>
				</table>
				<table border=0 cellspacing=0 cellpadding=0 >
					<tr height=15 >
						<td width=6> <br></td>
						<td width=129><b>RG:</b>&nbsp;<?php print($dadosAluno->rg);?></td>
						<td width=126><b>&Oacute;rg&atilde;o Exp:</b>&nbsp;<?php print($dadosAluno->orgexp);?></td>
						<td width=456><b>Dt expedi&ccedil;&atilde;o:</b>&nbsp;<?php print($_ClassData->transformaData($dadosAluno->dataexp, 2));?></td>
					</tr>
				</table>
				<table border=0 cellspacing=0 cellpadding=0 >
					<tr height=15 >
						<td width=6> <br></td>
						<td width=489><b>End:</b>&nbsp;<?php print($dadosAluno->endereco);?></td>
						<td width=222><b>Cep:</b>&nbsp;<?php print($_ClassUtilitarios->formataCEP($dadosAluno->cep));?></td>
					</tr>
				</table>
				<table border=0 cellspacing=0 cellpadding=0 >
					<tr height=16 >
						<td width=6> <br></td>
						<td width=198><b>Cidade:</b>&nbsp;<?php print($dadosCidade->cidade);?></td>
						<td width=89><b>UF:</b>&nbsp;<?php print($dadosAluno->estado);?></td>
						<td width=424><b>Fone:</b>&nbsp;<?php print($dadosAluno->telefone);?></td>
					</tr>
				</table>
				<table border=0 cellspacing=0 cellpadding=0 >
					<tr height=15 >
						<td width=6> <br></td>
						<td width=332><b>Academia:</b>&nbsp;<?php print($dadosAluno->academiaform);?></td>
						<td width=144><b>Nr reg:</b>&nbsp;<?php print($dadosAluno->numerorg);?></td>
						<td width=80><b>Livro:</b>&nbsp;<?php print($dadosAluno->livro);?></td>
						<td width=155><b>Folha:</b>&nbsp;<?php print($dadosAluno->folha);?></td>
					</tr>
				</table>
				<table border=0 cellspacing=0 cellpadding=0 >
					<tr height=16 >
						<td width=7> <br></td>
						<td width=195><b>Dt. reg:</b>&nbsp;<?php print($_ClassData->transformaData($dadosAluno->dataform,2));?></td>
						<td width=176><b>&Oacute;rg&atilde;o:</b>&nbsp;SR/DPF/<?php print($dadosAluno->orgao);?></td>
						<td width=338><?php if($trazMatricula->empresa > 0){?><font style="font-size:13px;"><b>Empresa:</b>&nbsp;<?php print($dadosEmpresa->nomefantasia);?></font><?php }?></td>
					</tr>
				</table>
			    <?php
			}
			
		}
		?>
	</body>
</html>