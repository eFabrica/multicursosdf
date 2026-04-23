<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
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
?>
<html>
	<head>
		<title>Alunos Concluídos - Turma: <?php print($dadosCurso->sigla . $dadosTurma->numero);?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
		<style>
				
			input{
				font-family:"Times New Roman", Times, serif;
				font-size:12px;
				color:#00000;
				border:0px;
				text-align:center;
				width:250px;
				height:25px;
			
			}
			
			h1, h2, h3, h4, p {margin:0px;}
		</style>
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
					<h2><u>Relatório de Alunos Concluídos</u></h2>
					<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
					<h3><b>Turma: </b>ATLA<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero);?> - 
					<?php print(date("Y"));?> - <?php print($dadosCurso->nome);?> - 
					<?php print($_ClassData->transformaData($dadosTurma->datainicio, 2) . " a " . $_ClassData->transformaData($dadosTurma->datatermino, 2));?></h3>
				</td>
			</tr>
		</table>
		<table width="99%" border="0" cellpadding="2" cellspacing="2">
			<tr>
				<td>
					<table width="100%" border="0" cellpadding="1" cellspacing="1">
						<tr>
							<td width="70%" align="center" bgcolor="#CCCCCC"><b>Nome</b></td>
							<td width="30%" align="center" bgcolor="#CCCCCC"><b>CPF</b></td>
						</tr>
					</table>
				</td>
			</tr>
			<?php
			// Contador
			$cont = 1;
			
			// Busca Matrículas
			$buscaMatriculas = $_ClassMysql->query("SELECT alunos.nome,
														   alunos.cpf FROM `matriculas`,`alunos` WHERE  alunos.id = matriculas.aluno AND 
																										matriculas.turma = '" . $dadosTurma->id . "' AND 
																										alunos.deletado = 'N' AND
																										matriculas.concluido = 'S' AND 
																										matriculas.deletado = 'N' ORDER BY alunos.nome ASC");
			
			// Verifica o total achado
			if(mysql_num_rows($buscaMatriculas) > 0){
				
				// Traz Matrículas
				while($trazMatricula = mysql_fetch_object($buscaMatriculas)){
					
					// Dados do Aluno
					//$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatricula->aluno . "'");
					
					?>
					<tr>
						<td align='left'>
							<ol>
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="70%"><?php print($cont++ . ".&nbsp;" . str_replace(" ", "&nbsp;", $trazMatricula->nome));?></td>
										<td width="30%" align="center"><?php print($_ClassUtilitarios->formataCPF($trazMatricula->cpf));?></td>
									</tr>
								</table>
							</ol>
						</td>
					</tr>
					<?php
					
				}
				
			}
			?>
		</table>
		<br><br><br>
		<br><br><br>
		<div align="center"><input type="text" value="Robson A. Nunes Diniz"><br /><input type="text" value="Diretor"></div>
	</body>
</html>