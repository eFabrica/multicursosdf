<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00023.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Turmas [Ativas] <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == "" || $_REQUEST["ref"] == "buscar"){
								
								// Verifica Referência
								if($_REQUEST["ref"] == "buscar"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=turmasativas"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
									<?php
								}
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=turmasativas&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova</a></div></td>
								<?php
								
							}elseif($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formTurma.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=turmasativas<?php print((($_REQUEST["ref"] == "novo")?"&ref=":"&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"]));?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></div></td>
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
	// Verifica referência
	if($_REQUEST["ref"] == "novo"){
		
		// Inclui Novo
		require_once($pathInc . "modulos/manutencao/_/_turmasativas.add.php");
		
	}elseif($_REQUEST["ref"] == "edit"){
		
		// Inclui Edit
		require_once($pathInc . "modulos/manutencao/_/_turmasativas.edit.php");
		
	}else{
		
		// Inclui Consulta
		require_once($pathInc . "modulos/manutencao/_/_turmasativas.consulta.php");
		
	}
	?>
</table>