<?php
// Verifica se tem id do registro
if($_REQUEST["idRegistro"] > 0){
	
	// Adiciona na sessão
	$_SESSION["idGrade"] = $_REQUEST["idRegistro"];
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
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00017.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Grade Horária <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica nível
							if($_dadosLogado->nivel != "95"){
							
								// Verifica Referência
								if($_REQUEST["ref"] == ""){
									
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=gradehoraria&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova</a></div></td>
									<?php
									
								}elseif($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
									
									?>
									<td align="center"><div class="caixaIcone"><a href="#" onClick="document.formGrade.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a></div></td>
									<td align="center"><div class="caixaIcone"><a href="?sessao=gradehoraria<?php print((($_REQUEST["ref"] == "novo")?"&ref=":$_SESSION["urlPesquisa"]));?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></div></td>
									<?php
									
								}elseif($_REQUEST["ref"] == "buscar"){							
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=gradehoraria"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="?sessao=gradehoraria&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova Grade Horária</a><div></td>
									<?php
									
								}
							
							}else{
								
								if($_REQUEST["ref"] == "buscar"){							
									?>
									<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formGrade.submit();"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Emitir</a></div></td>
									<td align="center"><div class="caixaIcone"><a href="?sessao=gradehoraria"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
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
	<?php
	// Verifica nível
	if($_dadosLogado->nivel != "95"){
	
		// Verifica referência
		if($_REQUEST["ref"] == "novo"){
			
			// Inclui Novo
			require_once($pathInc . "modulos/gerenciamentos/_/_gradehoraria.add.php");
			
		}elseif($_REQUEST["ref"] == "edit"){
			
			// Inclui Edit
			require_once($pathInc . "modulos/gerenciamentos/_/_gradehoraria.edit.php");
			
		}else{
			
			// Limpa Sessão
			unset($_SESSION["turmaGradeHoraria"]);
			
			// Inclui Consulta
			require_once($pathInc . "modulos/gerenciamentos/_/_gradehoraria.consulta.php");
			
		}
		
	}else{
		
		// Limpa Sessão
		unset($_SESSION["turmaGradeHoraria"]);
		
		// Inclui Consulta
		require_once($pathInc . "modulos/gerenciamentos/_/_gradehoraria.consulta.php");
		
	}
	?>
</table>