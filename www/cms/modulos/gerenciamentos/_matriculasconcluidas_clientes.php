<?php
// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica URL Pesquisa
if($_REQUEST["idRegistro"] > 0){
	
	// Cadastra id Registro na sessão
	$_SESSION["consultaMatricula"]["idRegistro"] = $_REQUEST["idRegistro"];
	
	// Cadastra URL da pesquisa na sessão
	$_SESSION["consultaMatricula"]["urlPesquisa"] = "&texto=" . $_SESSION["consultaMatricula"]["texto"] . "&pg=" . $_REQUEST["pg"] . "";
	
}
?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00018.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">
						Matrículas [Concluídas]
					</td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica referência
							if($_REQUEST["submenu"] == "buscar"){
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=matriculasconcluidas_clientes"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Busca</a></td>
								<?php
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	// Inclui Consulta
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculasconcluidas_clientes.consulta.php");
	?>
</table>