<?php
// Verifica se tem id do registro
if($_REQUEST["idRegistro"] > 0){
	
	// Adiciona na sessão
	$_SESSION["idDiario"] = $_REQUEST["idRegistro"];
	$_SESSION["urlPesquisa"] = "&ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"];
	
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
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00039.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">
						Diário de Classe <?php print($_ClassUtilitarios->refTopico()); ?>
						<?php
						// Verifica referência
						if($_REQUEST["ref"] == "novo"){
						
							// Verifica Etapas
							switch ($_REQUEST["etapa"]){
								
								// Etapa 2
								case "2": print(" - Define do Conteúdo"); break;
								
								// Etapa 3
								case "3": print(" - Sucesso!"); break;
								
								// Etapa 1
								default: print(" - Localiza Aula");
								
							}
							
						}elseif($_REQUEST["ref"] == "edit"){
							
							// Verifica Etapas
							switch ($_REQUEST["etapa"]){
								
								// Etapa 2
								case "2": print(" - Sucesso!"); break;
								
								// Etapa 1
								default: print(" - Define do Conteúdo");
								
							}
							
						}
						?>
					</td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == ""){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=diarioclasse&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Novo Diário</a></div></td>
								<?php
								
							}elseif($_REQUEST["ref"] == "novo"){
								
								// Verifica Etapas
								switch ($_REQUEST["etapa"]){
									
									// Etapa 2
									case "2":
										
										?>
										<td align="center"><div class="caixaIcone"><a href="?sessao=diarioclasse&ref=novo&subref=buscar"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a></div></td>
										<td align="center"><div class="caixaIcone"><a href="#" onClick="document.formDiarioClasse.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a></div></td>
										<?php
										
									break;
									
									// Etapa 1
									default:
										
										// Verifica se teve busca
										if($_REQUEST["subref"] == "buscar"){
											?>
											<td align="center"><div class="caixaIcone"><a href="?sessao=diarioclasse&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Localizar Aula</a></div></td>
											<td align="center"><div class="caixaIcone"><a href="#" onClick="document.formDiarioClasse.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a></div></td>
											<?php
										}
									
								}
								
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=diarioclasse"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></div></td>
								<?php
								
							}elseif($_REQUEST["ref"] == "edit"){
								
								// Verifica Etapas
								switch ($_REQUEST["etapa"]){
									
									// Etapa 1
									default:
										
										?>
										<td align="center"><div class="caixaIcone"><a href="?sessao=diarioclasse&ref=edit"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a></div></td>
										<td align="center"><div class="caixaIcone"><a href="#" onClick="document.formDiarioClasse.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a></div></td>
										<?php
									
								}
								
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=diarioclasse<?php print($_SESSION["urlPesquisa"]);?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></div></td>
								<?php
								
							}elseif($_REQUEST["ref"] == "buscar"){							
								?>
								<td align="center"><div class="caixaIcone"><a href="<?php print($pathInc);?>modulos/gerenciamentos/_/_diarioclasse.imprimir.php?<?php print("&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"]);?>" target="_blank"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Imprimir</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=diarioclasse"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=diarioclasse&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Novo Diário</a><div></td>
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
		require_once($pathInc . "modulos/gerenciamentos/_/_diarioclasse.add.php");
		
	}elseif($_REQUEST["ref"] == "edit"){
		
		// Inclui Edit
		require_once($pathInc . "modulos/gerenciamentos/_/_diarioclasse.edit.php");
		
	}else{
		
		// Limpa Sessão
		unset($_SESSION["urlPesquisa"]);
		unset($_SESSION["idDiario"]);
		
		// Inclui Consulta
		require_once($pathInc . "modulos/gerenciamentos/_/_diarioclasse.consulta.php");
		
	}
	?>
</table>