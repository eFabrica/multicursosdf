<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00039.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Relatório [Frequências]</td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == ""){
								
								// Verifica Etapa
								if($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == ""){
									
									// Verifica submenu
									if($_REQUEST["submenu"] == "buscar"){
										?>
										<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formFrequenciasAlunos.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
										<td align="center"><div class="caixaIcone"><a href="?sessao=frequenciasalunos"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></div></td>
										<?php
									}
									
								}elseif($_REQUEST["etapa"] == "2"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=frequenciasalunos&etapa=1"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<?php
									// Verifica se foi informado uma matéria e uma data
									if($_REQUEST["materias"] > 0 && $_REQUEST["horario"] > 0 && $_REQUEST["data"] != "" || $_SESSION["frequenciasalunos"]["materia"] > 0 && $_SESSION["frequenciasalunos"]["horario"] > 0 && $_SESSION["frequenciasalunos"]["data"] != ""){
										?>
										<td align="center"><div class="caixaIcone"><a href="?sessao=frequenciasalunos&etapa=3"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
										<?php
									}
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=frequenciasalunos"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></div></td>
									<?php
								}elseif ($_REQUEST["etapa"] == "3"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=frequenciasAlunos&etapa=2"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formFrequenciasAlunos.submit();"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></div></td>
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
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td align='left'>
						<font class="menu_topico">Etapas [ </font>
						<?php //print((($_REQUEST["etapa"] == "")?"<b></b>":"")); ?>
						<?php print((($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == "")?"<b>Escolhendo Turma</b>":"Escolhendo Turma")); ?>
						|
						<?php print((($_REQUEST["etapa"] == "2")?"<b>Opções de Impressão</b>":"Opções de Impressão")); ?>
						<font class="menu_topico"> ]</font>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
	// Verifica Etapa
	if($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == ""){
		
		// Inclui Etapa 1
		require_once($pathInc . "modulos/relatorios/_/_rel.frequencias.etapa1.php");
		
	}elseif($_REQUEST["etapa"] == "2"){
		
		// Inclui Etapa 2
		require_once($pathInc . "modulos/relatorios/_/_rel.frequencias.etapa2.php");
		
	}
	?>
</table>