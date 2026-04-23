<?php
// Verifica se foi selecionado algum aluno
if($dadosMatricula->aluno > 0){
			
	// Verifica se foi selecionado uma turma
	if($dadosMatricula->turma > 0){
		
		// Dados do Aluno
		$dadosAluno = $_ClassRn->getDadosTable("alunos", "numerorg, academiaform", "id = '" . $dadosMatricula->aluno . "'");
		
		// Dados da Turma
		$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "' AND concluido = 'N' AND deletado = 'N'");
		
		// Dados do Curso
		$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
		
		// Verifica se tem o id da Matrícula
		if($dadosMatricula->id > 0){
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
							<td align="center" width="33%"><div class="caixaIcone"><a href="?sessao=matriculas<?php print((($_SESSION["consultaMatricula"]["y"] != "n")?"":"&subsessao=consultageral"));?><?php print($_SESSION["consultaMatricula"]["urlPesquisa"]);?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></div></td>
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
			print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=edit&etapa=3", 1, array("É preciso definir os valores desta matrícula.")));
		
		}
	
	}else{

		// Redieciona
		print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=edit&etapa=2", 1, array("É preciso escolher uma turma.")));
	
	}
	
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas" . $_SESSION["consultaMatricula"]["urlPesquisa"], 1, array("É preciso selecionar uma matrícula.")));
	
}
?>