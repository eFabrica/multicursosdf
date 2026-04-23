<?php
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");
?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00019.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">
						Notas <?php print($_ClassUtilitarios->refTopico()); ?>
					</td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica SubMenu
							if($_REQUEST["submenu"] == "buscar" || $_SESSION["consultaNotas"]["idMatricula"] > 0){
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=notas&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>									
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
	require_once($pathInc . "modulos/gerenciamentos/_/_notas.consulta.php");
	?>
</table>