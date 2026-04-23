<?php
/*
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00002.png&l=50&a=50"></td>
					<td width="" class="menu_topico">Cobranças <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == ""){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="#" onclick="window.open('<?php print($pathInc . "modulos/financeiro/_/_cobrancas.imprimir.php?pc=");?>'+document.getElementById('palavraChave').value);"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Imprimir</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=cobrancas&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Novo</a></div></td>
								<?php
								
							}elseif($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formCobranca.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="<?php print((($_REQUEST["idRegistro"] > 0)?"?sessao=cobrancas&pc=" . $_REQUEST["pc"] . "&pg=" . $_REQUEST["pg"]:"?sessao=cobrancas"));?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></div></td>
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
		<td><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	// Verifica referência
	if($_REQUEST["ref"] != ""){
		
		// Inclui Tela de Cadastro
		require_once($pathInc . "modulos/financeiro/_/_cobrancas.form.php");
		
	}else{
		
		// Inclui Tela de Consulta
		require_once($pathInc . "modulos/financeiro/_/_cobrancas.consulta.php");
		
	}
	?>
</table>
*/
?>