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
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00038.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico" align="left">
						Falta de Documentos <?php print($_ClassUtilitarios->refTopico()); ?>
						<?php
						// Verifica Referência
						if($_REQUEST["ref"] == "novo"){
							
							// Verifica Etapas
							switch($_REQUEST["etapa"]){
								
								// Caso 2
								case "2": print(" - Documentos em Falta"); break;
								
								// Caso 3
								case "3": print(" - Sucesso!"); break;
								
								// Default
								default: print(" - Localizando Matrícula");
								
							}
							
						}elseif($_REQUEST["ref"] == "edit"){
							
							// Verifica Etapas
							switch($_REQUEST["etapa"]){
								
								// Caso 2
								case "2": print(" - Sucesso!"); break;
								
								// Default
								default: print(" - Documentos em Falta");
								
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
								<td align="center"><div class="caixaIcone"><a href="?sessao=faltadocumentos&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova</a><div></td>
								<?php
							}elseif($_REQUEST["ref"] == "novo"){
								
								if($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == ""){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=faltadocumentos&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00007.png&l=50&a=50" border="0"><br>Novo Aluno</a><div></td>
									<?php
									// Verifica SubMenu
									if($_REQUEST["submenu"] == "buscar" || $_SESSION["consultaFaltaDocumentos"]["idMatricula"] > 0){
										?>
										<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formFaltaDocumentos.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
										<?php
									}
									
								}elseif($_REQUEST["etapa"] == "2"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=faltadocumentos&ref=novo&etapa=1"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formFaltaDocumentos.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a><div></td>
									<?php
								}elseif($_REQUEST["etapa"] == "3"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=faltadocumentos&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></td>
									<?php
								}
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=faltadocumentos<?php print((($_REQUEST["ref"] == "novo")?"&ref=":"&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"]));?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></td>
								<?php
							}elseif($_REQUEST["ref"] == "buscar"){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="<?php print($pathInc);?>modulos/gerenciamentos/_/_faltadocumentos.imprimir.php?<?php print("&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"]);?>" target="_blank"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Imprimir</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=faltadocumentos&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova Falta</a><div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=faltadocumentos"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
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
		require_once($pathInc . "modulos/gerenciamentos/_/_faltadocumentos.add.php");
		
	}elseif($_REQUEST["ref"] == "edit"){
		
		// Inclui Edit
		require_once($pathInc . "modulos/gerenciamentos/_/_faltadocumentos.edit.php");
		
	}else{
		
		// Limpa Valores da sessão
		unset($_SESSION["idRegistro"]);
		unset($_SESSION["urlPesquisa"]);
		unset($_SESSION["idAluno"]);
		unset($_SESSION["consultaFaltaDocumentos"]["texto"]);
		unset($_SESSION["consultaFaltaDocumentos"]["idMatricula"]);
		
		// Inclui Consulta
		require_once($pathInc . "modulos/gerenciamentos/_/_faltadocumentos.consulta.php");
		
	}
	?>
</table>