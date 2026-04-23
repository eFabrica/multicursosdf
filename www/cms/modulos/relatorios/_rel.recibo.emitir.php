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

// Dados da Unidade
$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N' AND acesso = 'L'");

// Cidade Unidade
$cidadeUnidade = $_ClassRn->getDadosTable("cidades", "*", "id = '" . $dadosUnidade->cidade . "'");
	
// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica instrutor informado
if($_REQUEST["instrutor"] == "todos"){
	
	// Busca Instrutores
	$buscaInstrutores = $_ClassMysql->query("SELECT * FROM `usuarios` WHERE unidade = '" . $_dadosUnidade->id . "' AND nivel = '95' AND deletado = 'N' ORDER BY nome");
	
	// Traz Inscrutores
	while($trazInstrutores = mysql_fetch_object($buscaInstrutores)){
	
		// Busca Horas Aula neste período
		$buscaHorasAula = $_ClassMysql->query("SELECT SUM(horasaula) as totHorasAula FROM `diarioclasse` WHERE unidade = '" . $_dadosUnidade->id . "' AND data >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND data <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' AND instrutor = '" . $trazInstrutores->id . "' AND deletado = 'N'");
		
		// Meses
		$meses["01"] = "Janeiro";
		$meses["02"] = "Fevereiro";
		$meses["03"] = "Março";
		$meses["04"] = "Abril";
		$meses["05"] = "Maio";
		$meses["06"] = "Junho";
		$meses["07"] = "Julho";
		$meses["08"] = "Agosto";
		$meses["09"] = "Setembro";
		$meses["10"] = "Outubro";
		$meses["11"] = "Novembro";
		$meses["12"] = "Dezembro";
		
		// Parcela
		if($_REQUEST["parcela"] == "3"){
			
			// Total de Horas Aula neste período
			$totHorasAula = mysql_result($buscaHorasAula, 0, "totHorasAula");
			
			// Descrição da Parcela
			$parcela = "Única";
			
			// Serviços
			$servicos = $totHorasAula;
		
		}else{
			
			// Total de Horas Aula neste período
			$totHorasAula = (mysql_result($buscaHorasAula, 0, "totHorasAula")/2);
			
			// Descrição da Parcela
			$parcela = $_REQUEST["parcela"] . "ª";
			
			// Serviços
			$servicos = $totHorasAula*2;
		
		}
		
		// Verifica se tem horas aula
		if($totHorasAula > 0){
			?>
			<html>
				<head>
					<title>Recibo</title>
					<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
					<style>
						.cut {
							border-bottom:1px dashed navy;
							margin:0px auto;
							width:100%;
						}
					</style>
				</head>
				
				<body>
					<?php
					// Repete
					for($i = 1; $i <= 2; $i++){
						?>
						<table width="99%" style="border:1px solid #000000;" border="0" cellpadding="15" cellspacing="0">
							<tr>
								<td align="center">
									<h1 style="margin:0px;"><u>Recibo de Prestação de Serviço (<?php print($i . "ª Via");?>)</u></h1>
								</td>
							</tr>
						</table>
						<br>
						<table width="99%" border="0" cellpadding="4" cellspacing="0" style="border:1px solid #000000;">
							<tr>
								<td style="border-right:1px solid #000000;">
									<b>NOME OU RAZÃO SOCIAL DA EMPRESA</b><br>
									<?php print($_dadosUnidade->razaosocial);?>
								</td>
								<td align='left'>
									<b>CNPJ</b><br>
									<?php print($_ClassUtilitarios->formataCNPJ($_dadosUnidade->cnpj));?>
								</td>
							</tr>
						</table>
						<br>
						<table width="99%" border="0" cellpadding="4" cellspacing="0" style="border:1px solid #000000;">
							<tr>
								<td width="80%" style="border-right:1px solid #000000;" align="right"><b>VALOR TOTAL:</b></td>
								<td width="20%" align="right">R$ <?php print($_ClassDinheiro->formataMoeda($totHorasAula*$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor"])));?></td>
							</tr>
						</table>
						<br>
						<table width="99%" border="0" cellpadding="4" cellspacing="0">
							<tr>
								<td align='left'>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Recebi da empresa acima identificada, a <b><u><?php print($parcela);?> PARCELA</u></b>
									referente a prestação dos serviços de <b><?php print($servicos);?></b> 
									horas/aula no período de <b><?php print($_REQUEST["dataI"]);?></b> até <b><?php print($_REQUEST["dataF"]);?></b> 
									a importância conforme descriminado acima.
								</td>
							</tr>
						</table>
						<br>
						<table width="99%" border="0" cellpadding="4" cellspacing="0" style="border:1px solid #000000;">
							<tr>
								<td style="border-right:1px solid #000000;">
									<b>NOME DO BENEFICIÁRIO</b><br>
									<?php print($trazInstrutores->nome);?>
								</td>
								<td align='left'>
									<b>CPF</b><br>
									<?php print($_ClassUtilitarios->formataCPF($trazInstrutores->cpf));?>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="border-top:1px solid #000000;">
									<b>RG/ORGÃO</b><br>
									<?php print($trazInstrutores->rg . "/" . $trazInstrutores->orgexp);?>
								</td>
							</tr>
						</table>
						<br><br><br>
						<table width="99%" border="0" cellpadding="4" cellspacing="0">
							<tr>
								<td align="center">___________________________________________________________</td>
							</tr>
							<tr>
								<td align="center"><?php print($trazInstrutores->nome);?></td>
							</tr>
							<tr>
								<td align="right">Brasília, <?php print(date("d") . " de " . $meses[date("m").""] . " de " . date("Y") . ".")?></td>
							</tr>
						</table>
						<?php
						// Verifica se é o primeiro registro
						if($i == 1){
							?>
							<br><br>
							<div class="cut">
								<p>Corte na linha pontilhada</p>
							</div>
							<br><br>
							<?
						}
						
					}
					?>
					<?php if($j++ < (mysql_num_rows($buscaInstrutores)-1)){?><div style='page-break-after: always;'><span style='display: none;'>&nbsp;</span></div> <?php }?>
				</body>
			</html>
			<?
		}
		
	}
	
}else{

	// Dados do Instrutor
	$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_REQUEST["instrutor"] . "'");
	
	// Busca Horas Aula neste período
	$buscaHorasAula = $_ClassMysql->query("SELECT SUM(horasaula) as totHorasAula FROM `diarioclasse` WHERE unidade = '" . $_dadosUnidade->id . "' AND data >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND data <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' AND instrutor = '" . $_REQUEST["instrutor"] . "' AND deletado = 'N'");
	
	// Meses
	$meses["01"] = "Janeiro";
	$meses["02"] = "Fevereiro";
	$meses["03"] = "Março";
	$meses["04"] = "Abril";
	$meses["05"] = "Maio";
	$meses["06"] = "Junho";
	$meses["07"] = "Julho";
	$meses["08"] = "Agosto";
	$meses["09"] = "Setembro";
	$meses["10"] = "Outubro";
	$meses["11"] = "Novembro";
	$meses["12"] = "Dezembro";
	
	// Parcela
	if($_REQUEST["parcela"] == "3"){
		
		// Total de Horas Aula neste período
		$totHorasAula = mysql_result($buscaHorasAula, 0, "totHorasAula");
		
		// Descrição da Parcela
		$parcela = "Única";
		
		// Serviços
		$servicos = $totHorasAula;
	
	}else{
		
		// Total de Horas Aula neste período
		$totHorasAula = (mysql_result($buscaHorasAula, 0, "totHorasAula")/2);
		
		// Descrição da Parcela
		$parcela = $_REQUEST["parcela"] . "ª";
		
		// Serviços
		$servicos = $totHorasAula*2;
	
	}
	
	// Verifica se tem horas aula
	if($totHorasAula > 0){
		?>
		<html>
			<head>
				<title>Recibo</title>
				<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
				<style>
					.cut {
						border-bottom:1px dashed navy;
						margin:0px auto;
						width:100%;
					}
				</style>
			</head>
			
			<body>
				<?php
				// Repete
				for($i = 1; $i <= 2; $i++){
					?>
					<table width="99%" style="border:1px solid #000000;" border="0" cellpadding="15" cellspacing="0">
						<tr>
							<td align="center">
								<h1 style="margin:0px;"><u>Recibo de Prestação de Serviço (<?php print($i . "ª Via");?>)</u></h1>
							</td>
						</tr>
					</table>
					<br>
					<table width="99%" border="0" cellpadding="4" cellspacing="0" style="border:1px solid #000000;">
						<tr>
							<td style="border-right:1px solid #000000;">
								<b>NOME OU RAZÃO SOCIAL DA EMPRESA</b><br>
								<?php print($_dadosUnidade->razaosocial);?>
							</td>
							<td align='left'>
								<b>CNPJ</b><br>
								<?php print($_ClassUtilitarios->formataCNPJ($_dadosUnidade->cnpj));?>
							</td>
						</tr>
					</table>
					<br>
					<table width="99%" border="0" cellpadding="4" cellspacing="0" style="border:1px solid #000000;">
						<tr>
							<td width="80%" style="border-right:1px solid #000000;" align="right"><b>VALOR TOTAL:</b></td>
							<td width="20%" align="right">R$ <?php print($_ClassDinheiro->formataMoeda($totHorasAula*$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor"])));?></td>
						</tr>
					</table>
					<br>
					<table width="99%" border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td align='left'>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								Recebi da empresa acima identificada, a <b><u><?php print($parcela);?> PARCELA</u></b>
								referente a prestação dos serviços de <b><?php print($servicos);?></b> 
								horas/aula no período de <b><?php print($_REQUEST["dataI"]);?></b> até <b><?php print($_REQUEST["dataF"]);?></b> 
								a importância conforme descriminado acima.
							</td>
						</tr>
					</table>
					<br>
					<table width="99%" border="0" cellpadding="4" cellspacing="0" style="border:1px solid #000000;">
						<tr>
							<td style="border-right:1px solid #000000;">
								<b>NOME DO BENEFICIÁRIO</b><br>
								<?php print($dadosInstrutor->nome);?>
							</td>
							<td align='left'>
								<b>CPF</b><br>
								<?php print($_ClassUtilitarios->formataCPF($dadosInstrutor->cpf));?>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="border-top:1px solid #000000;">
								<b>RG/ORGÃO</b><br>
								<?php print($dadosInstrutor->rg . "/" . $dadosInstrutor->orgexp);?>
							</td>
						</tr>
					</table>
					<br><br><br>
					<table width="99%" border="0" cellpadding="4" cellspacing="0">
						<tr>
							<td align="center">___________________________________________________________</td>
						</tr>
						<tr>
							<td align="center"><?php print($dadosInstrutor->nome);?></td>
						</tr>
						<tr>
							<td align="right">Brasília, <?php print(date("d") . " de " . $meses[date("m").""] . " de " . date("Y") . ".")?></td>
						</tr>
					</table>
					<?php
					// Verifica se é o primeiro registro
					if($i == 1){
						?>
						<br><br>
						<div class="cut">
							<p>Corte na linha pontilhada</p>
						</div>
						<br><br>
						<?
					}
					
				}
				?>
			</body>
		</html>
		<?php
	}
}
?>