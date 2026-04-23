<?php
// Verifica se foi selecionado algum aluno
if($_SESSION["matricula"]["idAluno"] > 0){
	
	// Verifica se foi selecionado uma turma
	if($_SESSION["matricula"]["idDTurma"] > 0){
		
		// Dados do Aluno
		$dadosAluno = $_ClassRn->getDadosTable("alunos", "numerorg, academiaform", "id = '" . $_SESSION["matricula"]["idAluno"] . "'");
		
		// Dados da Turma
		$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["matricula"]["idDTurma"] . "' AND concluido = 'N' AND deletado = 'N'");
		
		// Dados do Curso
		$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
		
		// Verifica se tem o id da Matrícula
		if($_SESSION["matricula"]["idMatricula"] > 0){
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
							<td colspan="3" class="menu_topico" align="center">Matrícula&nbsp;efetuada&nbsp;com&nbsp;sucesso!</td>
						</tr>
						<tr>
							<td align="center" width="33%"><div class="caixaIcone"><a href="?sessao=matriculas&subsessao=<?php print($_REQUEST["subsessao"]);?>&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></div></td>
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
			print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=novo&etapa=5", 1, array("É preciso escolher uma turma.")));
		
		}
		
	}else{

		// Redieciona
		print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=novo&etapa=5", 1, array("É preciso escolher uma turma.")));
	
	}				
	
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=novo&etapa=1", 1, array("É preciso selecionar um(a) aluno(a).")));
	
}
?>