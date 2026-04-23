<?php
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
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00041.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">
						Frequências <?php print($_ClassUtilitarios->refTopico()); ?>
						<?php
						// Verifica Referência
						if($_REQUEST["ref"] == "novo"){
							
							// Verifica Etapas
							switch($_REQUEST["etapa"]){
								
								// Caso 2
								case "2": print(" - Define Presença"); break;
								
								// Caso 3
								case "3": print(" - Sucesso!"); break;
								
								// Default
								default: print(" - Localizando Aula");
								
							}
							
						}elseif($_REQUEST["ref"] == "buscar"){
							
							print("[Consulta] - Localizando Matrícula");
							
						}
						?>
					</td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == ""){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=frequencias&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova</a><div></td>
								<?php
							}elseif($_REQUEST["ref"] == "novo"){
								
								if($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == ""){
									
									// Verifica SubMenu
									if($_REQUEST["subref"] == "buscar" || $_SESSION["consultaFrequencias"]["idMatricula"] > 0){
										?>
										<td align="center"><div class="caixaIcone"><a href="?sessao=frequencias&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Localizar Aula</a></div></td>
										<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formFrequencias.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
										<?php
									}
									
								}elseif($_REQUEST["etapa"] == "2"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=frequencias&ref=novo&etapa=1&subref=buscar"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formFrequencias.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a><div></td>
									<?php
								}elseif($_REQUEST["etapa"] == "3"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=frequencias&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></td>
									<?php
								}
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=frequencias<?php print((($_REQUEST["ref"] == "novo")?"&ref=":"&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"]));?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></td>
								<?php
							}elseif($_REQUEST["ref"] == "buscar"){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=frequencias&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova Frequência</a><div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=frequencias"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
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
	// Verifica Referência
	if($_REQUEST["ref"] == "novo"){
		
		// Inclui Novo
		require_once($pathInc . "modulos/gerenciamentos/_/_frequencias.add.php");
		
	}elseif($_REQUEST["ref"] == "edit"){
		
		// Inclui Edit
		require_once($pathInc . "modulos/gerenciamentos/_/_frequencias.edit.php");
		
	}else{
		
		// Limpa Valores da sessão
		unset($_SESSION["consultaFrequencias"]["idRegistro"]);
		unset($_SESSION["consultaFrequencias"]["urlPesquisa"]);
		unset($_SESSION["consultaFrequencias"]["idAluno"]);
		unset($_SESSION["consultaFrequencias"]["texto"]);
		unset($_SESSION["consultaFrequencias"]["idMatricula"]);
		
		// Inclui Consulta
		require_once($pathInc . "modulos/gerenciamentos/_/_frequencias.consulta.php");
		
	}
	?>
</table>