<?php
// Verifica se foi selecionado algum aluno
if($_REQUEST["idAluno"] > 0){
	
	// Coloca Aluno na sessão
	$_SESSION["matricula"]["idAluno"] = $_REQUEST["idAluno"];
	
	// Dados do Aluno
	$dadosAluno = $_ClassRn->getDadosTable("alunos", "empresa", "id = '" . $_REQUEST["idAluno"] . "'");
	?>
	<tr>
		<td align="left">align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td align="left" class="table_main">
			<table border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td align="left" colspan="3" class="menu_topico" align="center">Aluno&nbsp;gravado&nbsp;com&nbsp;sucesso!</td>
				</tr>
				<tr>
					<td align="center" width="50%"><div class="caixaIcone"><a href="<?php print((($_SESSION["aluno"]["tipo"] == "E")?"?sessao=matriculas&subsessao=empresas&ref=novo&etapa=3":"?sessao=matriculas&ref=novo&etapa=3"));?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00018.png&l=50&a=50" border="0"><br>Fazer Matrícula</a></div></td>
					<td align="center" width="50%"><div class="caixaIcone"><a href="?sessao=alunos<?php print($_SESSION["urlPesquisa"]);?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></div></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
	
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=alunos", 1, array("É preciso selecionar um(a) aluno(a).")));
	
}
?>