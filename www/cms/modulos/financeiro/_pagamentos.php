<?php
// Verifica submenu
if(($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == "") && $_REQUEST["submenu"] != "buscar"){
	
	// Limpa sessão
	unset($_SESSION["consultaPagamentos"]["texto"]);
	
}
?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00020.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">
						Pagamentos <?php print($_ClassUtilitarios->refTopico()); ?>
						<?php
							// Verifica etapas
							switch ($_REQUEST["etapa"]){
								
								// Caso for etapa 2
								case "2": print(" - Parcelas"); break;
								
								// Default
								default: print(" - Localiza Matrícula");
								
							}
							?>
					</td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica etapas
							switch ($_REQUEST["etapa"]){
								
								// Caso for etapa 2
								case "2":
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=pagamentos&etapa=1&submenu=buscar"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="?sessao=pagamentos"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a><div></td>
									<?php
								break;
								
								// Default
								default:
									
									if($_REQUEST["submenu"] == "buscar" || $_SESSION["consultaPagamentos"]["texto"] !=  ""){
										?>
										<td align="center"><div class="caixaIcone"><a href="?sessao=pagamentos"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Busca</a></div></td>
										<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formPagamentos.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
										<?php
										
									}
								
							}
							?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td align="left">
						<font class="menu_topico">Etapas [ </font>
						<?php print((($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == "")?"<b>Localiza Matrícula</b>":"Localiza Matrícula")); ?>
						|
						<?php print((($_REQUEST["etapa"] == "2")?"<b>Parcelas</b>":"Parcelas")); ?>						
						<font class="menu_topico"> ]</font>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	// Verifica Etapas
	switch ($_REQUEST["etapa"]){
		
		// Etapa 2
		case "2": require_once($pathInc . "modulos/financeiro/_/_pagamentos.etapa2.php"); break;
		
		// Etapa 1
		default: require_once($pathInc . "modulos/financeiro/_/_pagamentos.etapa1.php");
		
	}
	?>
</table>