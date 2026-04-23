<?php
// Verifica se foi selecionado alguma matrícula
if($_SESSION["consultaFaltaDocumentos"]["idMatricula"] > 0){
	
	// Sucesso
	if(!$sucesso){
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
						<td class="menu_topico" align="center">Falta&nbsp;de&nbsp;documento&nbsp;gravada&nbsp;com&nbsp;sucesso!</td>
					</tr>
					<tr>
						<td align="center"><div class="caixaIcone"><a href="?sessao=faltadocumentos&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></div></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
	}
	
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=faltadocumentos&ref=novo&etapa=1", 1, array("É preciso selecionar uma matrícula.")));
	
}
?>