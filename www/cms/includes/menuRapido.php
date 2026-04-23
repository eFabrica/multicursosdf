<?php
// Verifica Nível
switch($_dadosLogado->nivel){
	
	// Caso for Master
	case "100":
		
		?>
		<table border="0" cellpadding="2" cellspacing="2" style="margin-left:5px;margin-right:5px;" align="center">
			<tr>
				<td align='left'><div class="caixaIcone"><a href="?sessao=alunos"><img src="imagens/icones/00007.png" border="0"><br>Alunos</a></div></td>
				<td align='left'><div class="caixaIcone"><a href="?sessao=matriculas"><img src="imagens/icones/00018.png" border="0"><br>Matrículas</a></div></td>
				<td align='left'><div class="caixaIcone"><a href="?sessao=pretendentes"><img src="imagens/icones/00021.png" border="0"><br>Pretendentes</a></div></td>
			</tr>
			<tr>
				<td align='left'><div class="caixaIcone"><a href="?sessao=notas"><img src="imagens/icones/00019.png" border="0"><br>Notas</a></div></td>
				<td align='left'><div class="caixaIcone"><a href="?sessao=cursos"><img src="imagens/icones/00009.png" border="0"><br>Cursos</a></div></td>
				<td align='left'><div class="caixaIcone"><a href="?sessao=turmas"><img src="imagens/icones/00023.png" border="0"><br>Turmas</a></div></td>
			</tr>
		</table>
		<?php
		
	break;

    case "89":

		?>

		<table border="0" cellpadding="2" cellspacing="2" style="margin-left:5px;margin-right:5px;" align="center">
			<tr>
				<td align='left'><div class="caixaIcone"><a href="?sessao=alunos"><img src="imagens/icones/00007.png" border="0"><br>Alunos</a></div></td>
				<td align='left'><div class="caixaIcone"><a href="?sessao=matriculas"><img src="imagens/icones/00018.png" border="0"><br>Matrículas</a></div></td>
				<td align='left'><div class="caixaIcone"><a href="?sessao=pretendentes"><img src="imagens/icones/00021.png" border="0"><br>Pretendentes</a></div></td>
			</tr>
			<tr>
				<td align='left'><div class="caixaIcone"><a href="?sessao=notas"><img src="imagens/icones/00019.png" border="0"><br>Notas</a></div></td>
				<td align='left'><div class="caixaIcone"><a href="?sessao=cursos"><img src="imagens/icones/00009.png" border="0"><br>Cursos</a></div></td>
				<td align='left'><div class="caixaIcone"><a href="?sessao=turmas"><img src="imagens/icones/00023.png" border="0"><br>Turmas</a></div></td>
			</tr>
		</table>
		<?php

	break;
	
	// Caso for Instrutor
	case "95":
		
		?>
		<table border="0" cellpadding="2" cellspacing="2" style="margin-left:5px;margin-right:5px;" align="center">
			<tr>
				<td align='left'><div class="caixaIcone"><a href="?sessao=gradehoraria"><img src="imagens/icones/00017.png" border="0"><br>Grade Horária</a></div></td>
			</tr>
			<tr>
				<td align='left'><div class="caixaIcone"><a href="?sessao=rel_horasaula"><img src="imagens/icones/00037.png" border="0"><br>Horas Aula</a></div></td>
			</tr>
		</table>
		<?php
		
	break;
	
	// Caso for Cliente
	case "94":
		
		?>
		<table border="0" cellpadding="2" cellspacing="2" style="margin-left:5px;margin-right:5px;" align="center">
			<tr>
				<td align='left'><div class="caixaIcone"><a href="?sessao=alunos_clientes"><img src="imagens/icones/00007.png" border="0"><br>Alunos</a></div></td>
				<td align='left'><div class="caixaIcone"><a href="?sessao=matriculasativas_clientes"><img src="imagens/icones/00018.png" border="0"><br>Matrículas Ativas</a></div></td>
			</tr>
			<tr>
				<td align='left'><div class="caixaIcone"><a href="?sessao=matriculasconcluidas_clientes"><img src="imagens/icones/00018.png" border="0"><br>Matrículas Concluídas</a></div></td>
				<td align='left'><div class="caixaIcone"><a href="?sessao=faltadocumentos_clientes"><img src="imagens/icones/00038.png" border="0"><br>Falta de Documentos</a></div></td>
			</tr>
		</table>
		<?php
		
	break;
	
}
?>