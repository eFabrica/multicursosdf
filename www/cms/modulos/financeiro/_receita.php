<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00022.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Receitas <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == ""){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=receita&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova Receita</a></div></td>
								<?php
								
							}elseif($_REQUEST["ref"] == "buscar"){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=receita&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova Receita</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=receita&ref="><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Busca</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="<?php print($pathInc);?>modulos/financeiro/_/_receita.imprimir.php?<?php print("&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"]);?>" target="_blank"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Imprimir</a></div></td>
								<?php
								
							}elseif($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formReceitas.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=receita<?php print((($_REQUEST["ref"] == "novo")?"&ref=":"&ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"]));?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></div></td>
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
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	// Verifica referência
	if($_REQUEST["ref"] == "novo"){
		
		// Inclui Novo
		require_once($pathInc . "modulos/financeiro/_/_receita.add.php");
		
	}elseif($_REQUEST["ref"] == "edit"){
		
		// Inclui Edit
		require_once($pathInc . "modulos/financeiro/_/_receita.edit.php");
		
	}else{
		
		// Inclui Consulta
		require_once($pathInc . "modulos/financeiro/_/_receita.consulta.php");
		
	}
	?>
</table>