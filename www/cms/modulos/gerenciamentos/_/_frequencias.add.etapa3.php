<?php
// Verifica se foi informado o Id da Grade Horária
if($_SESSION["consultaFrequencias"]["idGrade"] > 0){

	?>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td colspan="2" class="menu_topico" align="center">Frequências&nbsp;gravadas&nbsp;com&nbsp;sucesso!</td>
				</tr>
				<tr>
					<td align="center"><div class="caixaIcone"><a href="?sessao=frequencias&ref=novo&subref=buscar"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Voltar para a Pesquisa</a></div></td>
					<td align="center"><div class="caixaIcone"><a href="?sessao=frequencias&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></div></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=frequencias&ref=novo" . (($_SESSION["consultaFrequencias"]["consultaFrequencias"] != "")?"&subref=buscar":""), 1, array("É preciso selecionar uma Aula.")));
	
}
?>