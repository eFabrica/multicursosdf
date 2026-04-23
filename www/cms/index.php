<?php
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = './';

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

// Arquivo de Proteção
require_once($pathInc . "inc/protec.inc.php");

// Arquivo de Pemrissão
require_once($pathInc . "lib/Permissao.class.php");

// Verificador de Módulo
require_once($pathInc . "includes/verificaModulo.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

	<head>
		<?php require_once($pathInc . "includes/head.php"); ?>
		<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->

	</head>
	
	<body <?php require_once($pathInc . "includes/actionBody.php");?>>
		<!--
		<DIV STYLE="left:0px;top:0px;position:absolute;height:100%;width:101%;background-color:#000000;"></DIV>
		-->
		<DIV ID="legendaLink" STYLE="position:absolute; visibility:hidden;z-index:10000000;"></DIV> 
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align='left'><?php require_once($pathInc . "includes/topo.php"); ?>

</td>
			</tr>
			<tr>
				<td align='left'><?php if($_dadosLogado->nivel == "94") require_once($pathInc . "includes/menu_.php"); else require_once($pathInc . "includes/menu.php");?></td>
			</tr>
		</table>
		
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_main">
			<tr>
				<td align='left'><br></td>
			</tr>
			<tr>
				<td align="center"><?php include_once($pathInc . "modulos/sistema/main.php"); ?></td>
			</tr>
		</table>
		<div id="border-bottom"><div><div></div></div></div>
		<script language="javascript" type="text/javascript" src="js/legenda2.js"></script>
	</body>
</html>
