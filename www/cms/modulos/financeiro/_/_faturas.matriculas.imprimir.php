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

// Dados da Unidade
$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N' AND acesso = 'L'");

// Cidade Unidade
$cidadeUnidade = $_ClassRn->getDadosTable("cidades", "*", "id = '" . $dadosUnidade->cidade . "'");
	
// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica se tem o id da fatura
if($_REQUEST["idFatura"] > 0){
	
	// Dados da Fatura
	$dadosFatura = $_ClassRn->getDadosTable("faturas", "*", "id = '" . $_REQUEST["idFatura"] . "'");
	
	// Id da Empresa
	$idEmpresa = $dadosFatura->empresa;
	
	// Data Inicial
	$dataI = $_ClassData->transformaData($dadosFatura->datai, 2);
	
	// Data Final
	$dataF = $_ClassData->transformaData($dadosFatura->dataf, 2);
	
}else{
	
	// Id da Empresa
	$idEmpresa = $_REQUEST["empresa"];
	
	// Data Inicial
	$dataI = $_REQUEST["datai"];
	
	// Data Final
	$dataF = $_REQUEST["dataf"];
	
}

// Dados da Empresa
$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $idEmpresa . "'");
?>
<html>
	<head>
		<title>Relatório de Matrículas da Fatura</title>
		<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
		<table width="700" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td align="left"><img src="<?php print($pathInc);?>imagens/diversos/logo.jpg"></td>
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
				<td align="center" colspan="2">
					<h2><u>Relatório de Matrículas da Fatura</u></h2>
					<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
				</td>
			</tr>
			<tr>
				<td colspan="2"><h2>Filtrando por:</h2></td>
			</tr>
			<tr>
				<td align="right" width="15%"><strong>Data:</strong></td>
				<td width='85%' align='left'>
					De <?php print($dataI);?>
			  		até <?php print($dataF);?>
				</td>
			</tr>
			<tr>
				<td align="right"><b>Empresa:</b></td>
				<td align="left">
					<?php
					// Dados da Empresa
					$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $idEmpresa . "'");
					
					// Exibe nome da empresa
					print($dadosEmpresa->razaosocial . " (" . $_ClassUtilitarios->formataCNPJ($dadosEmpresa->cnpj) . ")");
					?>
				</td>
			</tr>
		</table><br />
		<table width="100%" cellspacing="1" align="center">
			<tr>
				<td width="1%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;" align="center"><b>#</b></td>
				<td width="40%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;" align="center"><b>Aluno</b></td>
				<td width="25%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;" align="center"><b>Curso/Turma</b></td>
				<td width="15%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;" align="center"><b>Turno</b></td>
				<td width="15%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;" align="center"><b>Valor</b></td>
				<td width="5%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;" align="center"><b>Concluído</b></td>
			</tr>
			<?php	
			// Verifica se tem o id da fatura
			if($_REQUEST["idFatura"] == ""){
				
				// Busca Turmas
				$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND datainicio >= '" . $_ClassData->transformaData($dataI) . "' AND datainicio <= '" . $_ClassData->transformaData($dataF) . "' AND deletado = 'N'");
				
				// Verifica o total achado
				if(mysql_num_rows($buscaTurmas) > 0){
					
					// Contador
					$cont = 0;
					
					// Traz Turmas
					while($trazTurmas = mysql_fetch_object($buscaTurmas)){
					
						// Busca Matrículas
						$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE unidade = '" . $_dadosUnidade->id . "' AND empresa = '" . $idEmpresa . "' AND turma = '" . $trazTurmas->id . "' AND fatura = '0' AND deletado = 'N'");
						
						// Verifica o total achado
						if(mysql_num_rows($buscaMatriculas) > 0){
							
							// Traz Matrículas
							while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
							
								// Dados da Turma
								$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $trazMatriculas->turma . "'");
								
								// Dados do Curso
								$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
			
								// Dados do Turno
								$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
			
								// Dados da Matéria
								$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazMatriculas->materia . "'");
								
								// Dados do Aluno
								$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");
								
								// Total De matrículas
								$totMatriculas += $trazMatriculas->valor_dinheiro;
								?>
								<tr>
									<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($trazMatriculas->id); ?>.</td>
									<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><a name="<?=$trazMatriculas->id?>"></a><?php print($dadosAluno->nome);?></td>
									<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
									<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
									<td align="right" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">R$ <?php print($_ClassDinheiro->formataMoeda($trazMatriculas->valor_dinheiro)); ?></td>
									<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print((($trazMatriculas->concluido == "S")?"SIM":(($trazMatriculas->reprovado == "S")?"REPROV.":"NÃO")));?></td>
								</tr>
								<?php
								// Contador
								$cont++;
								
							}
							
						}
						
					}
					
				}elseif(mysql_num_rows($buscaTurmas) <= 0 || $cont = 0){
					
					?>
					<tr>
						<td align="center" colspan="7" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Nenhum resultado encontradob.</b></td>
					</tr>
					<?php
					
				}
			
			}else{
				
				// Busca Matrículas
				$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE fatura = '" . $_REQUEST["idFatura"] . "'");
				
				// Verifica o total achado
				if(mysql_num_rows($buscaMatriculas) > 0){
					
					// Traz Matrículas
					while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
					
						// Dados da Turma
						$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $trazMatriculas->turma . "'");
						
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
	
						// Dados do Turno
						$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
	
						// Dados da Matéria
						$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazMatriculas->materia . "'");
						
						// Dados do Aluno
						$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");
						
						// Total De matrículas
						$totMatriculas += $trazMatriculas->valor_dinheiro;
						?>
						<tr>
							<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($trazMatriculas->id); ?>.</td>
							<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><a name="<?=$trazMatriculas->id?>"></a><?php print($dadosAluno->nome);?></td>
							<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
							<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
							<td align="right" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">R$ <?php print($_ClassDinheiro->formataMoeda($trazMatriculas->valor_dinheiro)); ?></td>
							<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print((($trazMatriculas->concluido == "S")?"SIM":(($trazMatriculas->reprovado == "S")?"REPROV.":"NÃO")));?></td>
						</tr>
						<?php
						// Contador
						$cont++;
						
					}
					
				}
				
			}
			?>
		</table>
	</body>
</html>