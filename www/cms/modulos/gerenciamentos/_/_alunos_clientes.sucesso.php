<?php
// Verifica se foi selecionado algum aluno
if($_REQUEST["idAluno"] > 0){
	
	// Sucesso
	if(!$sucesso){
		?>
		<tr>
			<td align="left"><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td colspan="3" class="menu_topico" align="center">Aluno&nbsp;gravado&nbsp;com&nbsp;sucesso!</td>
					</tr>
					<tr>
						<td align="center"><div class="caixaIcone"><a href="?sessao=alunos_clientes<?php print($_SESSION["urlPesquisa"]);?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></div></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
	}
	
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=alunos_clientes" . $_SESSION["urlPesquisa"], 1, array("É preciso selecionar um(a) aluno(a).")));
	
}
?>