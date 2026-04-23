<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["matricular"]["idTurma"] . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");

// Dados da empresa
$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $_dadosLogado->empresa . "'");

// Verifica se está deletado
if($dadosTurma->deletado == "N"){
	
	// Verifica se está concluido
	if($dadosTurma->concluido == "N"){
		
		// Dados da Reserva
		$dadosReserva = $_ClassRn->getDadosTable("clientes_reservas_matriculas", "*", "id = '" . $_SESSION["matricular"]["idReserva"] . "'");
		
		// File
		$file .= "Reserva: " . $dadosReserva->id . " | " . md5($dadosReserva->id) . "\r\n";
		$file .= "Turma: " . $_ClassData->transformaData($dadosTurma->datainicio, 2) . " | " . md5($dadosTurma->id) . "\r\n";
		$file .= "Autor: " . $_dadosLogado->nome . " | " . md5($_dadosLogado->id) . "\r\n";
		$file .= "Empresa: " . $dadosEmpresa->razaosocial . " | " . md5($_dadosLogado->empresa) . "\r\n\r\nMatriculados:\r\n\r\n";
		
		// Busca Matrículas
		$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE reserva = '" . $dadosReserva->id . "' AND deletado = 'N'");
		
		// Traz Matriculas
		while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
			
			// Dados do ALunos
			$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");
			
			// File
			$file .= $dadosAluno->nome . " <-> " . $_ClassUtilitarios->formataCPF($dadosAluno->cpf) . " <-> " . $_ClassData->transformaData($dadosAluno->datanascimento, 2) . " | " . md5($trazMatriculas->aluno) . "\r\n";
			
			// Total
			++$total;
			
		}
		
		// File
		$file .= "\r\nTotal: " . $total . "\r\n";
		
		// Lib de Files
		require_once ($pathInc . "lib/Files.class.php");
		
		// Escreve Arquivo
		$_ClassFiles->writeFile($pathInc . "comprovantes/", rawurlencode($_SESSION["matricular"]["idReserva"] . ".txt"), $file);
		?>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align="left"><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td colspan="3" class="menu_topico" align="center">Os alunos foram matriculados com sucesso!</td>
					</tr>
					<tr>
						<td align="center" width="33%"><div class="caixaIcone"><a href="<?php print($pathInc . "modulos/sistema/salvarArquivo.php?modo=2&path=../../comprovantes/&file=" . $_SESSION["matricular"]["idReserva"]);?>.txt"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Comprovante</a></div></td>
						<td align="center" width="33%"><div class="caixaIcone"><a href="?modulo=empresa&sessao=matricular"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></div></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
		
	}else{print($_ClassUtilitarios->redirecionarJS("?modulo=empresa&sessao=matricular&etapa=1", 1, array("Esta turma está concluída. Por favor, seleciona outra.")));}
	
}else{print($_ClassUtilitarios->redirecionarJS("?modulo=empresa&sessao=matricular&etapa=1", 1, array("Esta turma foi deletada.  Por favor, seleciona outra.")));}
?>