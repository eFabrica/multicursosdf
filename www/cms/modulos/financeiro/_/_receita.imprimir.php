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

/* Construindo sql */
$sql = "SELECT * FROM `receitas`";
$sql .= " WHERE unidade = '" . $_dadosUnidade->id . "' AND ";
if($_SESSION["consultaReceitas"]["todas"] != "sim"){
	
	$sql .= (($_SESSION["consultaReceitas"]["habilitarData"] == "sim")?" datahorae >= '" . $_ClassData->transformaData($_SESSION["consultaReceitas"]["dataI"]) . " 00:00:00' AND datahorae <= '" . $_ClassData->transformaData($_SESSION["consultaReceitas"]["dataF"]) . " 23:59:59' AND":"");
	$sql .= (($_SESSION["consultaReceitas"]["habilitarValor"] == "sim")?" valor BETWEEN '" . $_ClassDinheiro->limpaFormatacaoMoeda($_SESSION["consultaReceitas"]["valorI"]) . "' AND '" . $_ClassDinheiro->limpaFormatacaoMoeda($_SESSION["consultaReceitas"]["valorF"]) . "' AND":"");
	$sql .= (($_SESSION["consultaReceitas"]["habilitarUsuario"] == "sim")?" ultimoeditou = '" . $_SESSION["consultaReceitas"]["usuario"] . "' AND":"");
	$sql .= (($_SESSION["consultaReceitas"]["habilitarDescricao"] == "sim")?" descricao LIKE '%" . $_SESSION["consultaReceitas"]["descricao"] . "%' AND":"");
	
	//$sql .= (($_POST["habilitar"] == "sim")?"":"");
}

$sql .= " deletado = 'N' ORDER BY " . (($_REQUEST['campo'] == '')?'id':$_REQUEST['campo']) . " " . (($_REQUEST['ordem'] == '')?"ASC":$_REQUEST['ordem']);

// Busca Receitas
$buscaReceitas = $_ClassMysql->query($sql);

// Calcula Número de Paginas
$totPag = ceil(mysql_num_rows($buscaReceitas)/35);
?>
<html>
	<head>
		<title>Relatório de Receitas</title>
		<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
		<?php
		// Lê Número de Página
		for($i = 1; $i <= $totPag; $i++){
			?>
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
					<td align="center">
						<h2><u>Relatório de Receitas</u></h2>
						<b>Emissão: </b><?php print(date("d/m/Y H:i:s"));?><br>
						Página <b><?php print($i);?></b> de <b><?php print($totPag);?></b>
					</td>
				</tr>
				<tr>
					<td align="left"><h2>Filtrando por: </h2></td>
				</tr>
				<?php
				// Verifica se a busca é por todas
				if($_SESSION["consultaReceitas"]["todas"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Todas as Receitas</strong></ol></td>
					</tr>
					<?php
				}
				 
				// Verifica se foi habilitado o campo de data
				if($_SESSION["consultaReceitas"]["habilitarData"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaReceitas"]["dataI"]?> até <?php echo $_SESSION["consultaReceitas"]["dataF"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de valor
				if($_SESSION["consultaReceitas"]["habilitarValor"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Valor:</strong>&nbsp;De R$ <?php echo $_SESSION["consultaReceitas"]["valorI"]?> até R$ <?php echo $_SESSION["consultaReceitas"]["valorF"]?></ol></td>
					</tr>
					<?php
				}
				
				//Verifica se foi habilitado o campo de Usuários
				if($_SESSION["consultaReceitas"]["habilitarUsuario"] == "sim"){
					
					// Dados do Usuário
					$dadosUsuario = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaReceitas"]["usuario"] . "'");
					?>
					<tr>
						<td align="left"><ol><strong>Usuário:</strong>&nbsp;<?php print($dadosUsuario->nome);?> (<?php print($dadosUsuario->cpf);?>)</ol></td>
					</tr>
					<?php
				}
				
				//Verifica se foi habilitado o campo de Descrição
				if($_SESSION["consultaReceitas"]["habilitarDescricao"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Descricao:</strong>&nbsp;<?php echo nl2br($_SESSION["consultaReceitas"]["descricao"]);?></ol></td>
					</tr>
					<?php
				}				
				?>
			</table>
			<table width="100%" border="0" cellspacing="2" cellpadding="2">
				<tr>
					<td align="center" width="50%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Descrição</b></td>
					<td align="center" width="10%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Valor</b></td>
					<td align="center" width="10%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Data</b></td>
					<td align="center" width="10%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Hora</b></td>
					<td align="center" width="20%" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><b>Funcionário(a)</b></td>
				</tr>
				<?php
				//Limite inicial
				$inicioLimit = ( $i - 1 ) * 35;
				
				// Busca Receitas
				$buscaReceitas = $_ClassMysql->query($sql . " LIMIT " . $inicioLimit . "," . 35);
				
				// Traz Receitas
				while($trazReceitas = mysql_fetch_object($buscaReceitas)){
					
					// Total Da Página
					$totalPag += $trazReceitas->valor;
					
					// Dados do Usuário
					$dadosUsuario = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $trazReceitas->ultimoeditou . "'");
					?>
					<tr>
						<td style="border-bottom:1px solid #333333;border-right:1px solid #333333;""><?php print(strtoupper(substr($trazReceitas->descricao, 0, 50)));?></td>
						<td align="right" style="border-bottom:1px solid #333333;border-right:1px solid #333333;">R$ <?php print($_ClassDinheiro->formataMoeda($trazReceitas->valor));?></td>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print(substr($_ClassData->transformaData($trazReceitas->datahorae, 3), 0, 10));?></td>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print(substr($_ClassData->transformaData($trazReceitas->datahorae, 3), 11, 8));?></td>
						<td align="center" style="border-bottom:1px solid #333333;border-right:1px solid #333333;"><?php print($_ClassUtilitarios->abreviaNome($dadosUsuario->nome));?></td>
					</tr>
					<?php
				}
				
				// Total Geral
				$totalGeral += $totalPag;
				?>
				<tr>
					<td align="right" colspan="5"><h2 style="margin:0px;"><b>Valor Total da Página:</b> R$ <?php print($_ClassDinheiro->formataMoeda($totalPag));?></h2></td>
				</tr>
			</table>
			<?php if($i < $totPag){?>
				<p><div style='page-break-after: always;'><span style='display: none;'>&nbsp;</span></div></p>
			<?php }else{ ?>
				<div align="right"><h2 style="margin:0px;">Total do Relatório: R$ <?php print($_ClassDinheiro->formataMoeda($totalGeral));?></h2></div>
			<?php
			}
		}
		?>
	</body>
</html>