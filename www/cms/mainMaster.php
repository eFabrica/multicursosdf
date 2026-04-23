<?php
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = './';

// Arquivo de Configurações
require_once($pathInc . "inc/config.inc.php");

// Verifica se está logado
	if($_SESSION["dadosLogin"]["idLogado"] > 0){

		// Dados do Logado
		$_dadosLogado = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
	}

// Arquivo de Proteção
require_once($pathInc . "inc/protec.inc.php");
?>
<html>
	<head>

		<?php require_once($pathInc . "includes/head.php"); ?>
		<!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"> -->
	</head>
	
	<body <?php require_once($pathInc . "includes/actionBody.php");?>>
		
		<DIV ID="legendaLink" STYLE="position:absolute; visibility:hidden;"></DIV> 
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align='left'><?php require_once($pathInc . "includes/topo.php"); ?>

</td>
			</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_main">
			<tr>
				<td align='left'><br></td>
			</tr>
			<tr>
				<td align="center"><?php include_once($pathInc . "modulos/sistema/master/inicial.php"); ?></td>
			</tr>
		</table>
		<div id="border-bottom"><div><div></div></div></div>
		<script language="javascript" type="text/javascript" src="js/legenda2.js"></script>
	</body>
</html>
