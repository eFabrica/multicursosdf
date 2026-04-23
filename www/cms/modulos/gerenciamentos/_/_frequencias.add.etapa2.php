<?php require_once("php7_mysql_shim.php");
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica se foi informado o Id da Grade Horária
if($_REQUEST["idGrade"] > 0){
	
	// Adiciona Grade Horária na Sessão
	$_SESSION["consultaFrequencias"]["idGrade"] = $_REQUEST["idGrade"];
	
}

// Verifica se foi informado o Id da Grade Horária
if($_SESSION["consultaFrequencias"]["idGrade"] > 0){
	
	// Dados da Grade Horária
	$dadosGrade = $_ClassRn->getDadosTable("gradehoraria", "*", "id = '" . $_SESSION["consultaFrequencias"]["idGrade"] . "'");
	
	// Dados da Turma
	$dadosTurma = $_ClassRn->getDadosTable("turmas", "curso, numero", "id = '" . $dadosGrade->turma . "'");
	
	// Dados do Curso
	$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");

	// Dados do Turno
	$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosGrade->turno . "'");

	// Dados da Matéria
	$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $dadosGrade->materia . "'");
	
	// Dados do Instrutor
	$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $dadosGrade->instrutor . "'");
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td align="right" width="10%"><b>Curso/Turma:</b></td>
					<td width='90%' align='left'><?php print ($dadosCurso->sigla . $dadosTurma->numero); ?></td>
				</tr>
				<tr>
					<td align="right"><b>Turno:</b></td>
					<td align='left'><?php print ($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
				</tr>
				<tr>
					<td align="right"><b>Matéria:</b></td>
					<td align='left'><?php print ($dadosMateria->materia . " (" . $dadosMateria->sigla . ")"); ?></td>
				</tr>
				<tr>
					<td align="right"><b>Instrutor:</b></td>
					<td align='left'><?php print ($dadosInstrutor->nome . " (" . $_ClassUtilitarios->formataCPF($dadosInstrutor->cpf) . ")"); ?></td>
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
	// Verifica Ação
	if($_REQUEST["act"] == "salvar"){
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);

		// Verifica o total de registros
		if(count($_REQUEST["registros"]) > 0){
			
			// Lê Registros
			for($i = 0; $i < count($_REQUEST["registros"]); $i++){
				
				// Busca Matrícula nas frequências
				$buscaMatriculaFrequencia = $_ClassMysql->query("SELECT * FROM `frequencias` WHERE matricula = '" . $_REQUEST["registros"][$i] . "' AND gradehoraria = '" . $dadosGrade->id . "' AND deletado = 'N'");
				
				// Verifica o total achado
				if(mysql_num_rows($buscaMatriculaFrequencia) > 0){
					
					// Deleta Presença
					$_ClassMysql->query("UPDATE `frequencias` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id. "', datahorad = NOW() WHERE matricula = '" . $_REQUEST["registros"][$i] . "' AND gradehoraria = '" . $dadosGrade->id . "'");
					
				}else{
					
					// Cadastra Presença
					$_ClassMysql->query("INSERT INTO `frequencias` SET matricula = '" . $_REQUEST["registros"][$i] . "',
																	   gradehoraria = '" . $dadosGrade->id . "',
																	   quemcriou = '" . $_dadosLogado->id . "',
																	   datahorac = NOW();");
					
				}
				
			}
			
			// Redieciona
			print($_ClassUtilitarios->redirecionarJS("?sessao=frequencias&ref=novo&etapa=3", 0));
			
		}else{
			
			// Redieciona
			print($_ClassUtilitarios->redirecionarJS("?sessao=frequencias&ref=novo&etapa=3", 0));
			
		}
		?>
		<tr>
			<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<?php
		
	}
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formFrequencias">
				<input type="hidden" name="act" value="salvar">
				<table class="consulta" cellspacing="1" align="center">
					<thead>
						<tr>
							<th width="1%">#</th>
							<th width="1%" align="center"><input type="checkbox" onclick="select_all('formFrequencias', 'registros[]')"></th>
							<th width="40%">Aluno</th>
							<th width="25%">Curso/Turma</th>
							<th width="20%">Turno</th>
							<th width="5%">Presente</th>
						</tr>
					</thead>
					<tbody>
						<?php	
						/* Construindo sql */
						$sql = "SELECT * FROM `matriculas`";
						$sql .= " WHERE unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $dadosGrade->turma . "' AND deletado = 'N'";
	
						/* Fim da construção */
						
						// Paginação
						require_once($pathInc . "lib/Paginacao.class.php");
						
						// Configurações da paginacao
						$_ClassPaginacao->setQuery($sql);
						$_ClassPaginacao->setUrl("?sessao=frequencias&ref=novo&etapa=" . $_REQUEST["etapa"]);
						$_ClassPaginacao->setRegistrosPorPagina("45");
						$_ClassPaginacao->setPaginaAtual((($_REQUEST["pg"] == 0)?"1":$_REQUEST["pg"]));
						$_ClassPaginacao->paginando();
												
						// Verifica total achado
						if($_ClassPaginacao->getTotalAchadoQuery() == 0){
							?>
							<tr>
								<td align="center" colspan="9"><b>Nenhum resultado encontrado.</b></td>
							</tr>
							<?
						}else{
							
							// Traz resultados
							while($trazResultados = mysql_fetch_object($_ClassPaginacao->getBusca())){
							
								// Dados da Turma
								$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $trazResultados->turma . "'");
								
								// Dados do Curso
								$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
			
								// Dados do Turno
								$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
			
								// Dados da Matéria
								$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazResultados->materia . "'");
								
								// Dados do Aluno
								$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazResultados->aluno . "'");
								
								// Busca Matrícula nas frequências
								$buscaMatriculaFrequencia = $_ClassMysql->query("SELECT * FROM `frequencias` WHERE matricula = '" . $trazResultados->id . "' AND gradehoraria = '" . $dadosGrade->id . "' AND deletado = 'N'");
								?>
								<tr class=row0>
									<td align='left'><?php print($trazResultados->numero); ?></td>
									<td align="center"><?php if($trazResultados->concluido == "N" && $trazResultados->reprovado == "N" ){?><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"><?php }?></td>
									<td align="center"><a name="<?=$trazResultados->id?>"></a><?php print($dadosAluno->nome);?></td>
									<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
									<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
									<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print(((mysql_num_rows($buscaMatriculaFrequencia) > 0)?"S":"N"));?>.png"></td>
								</tr>
								<?php
							}
							
						}
						?>
					</tbody>
					<tfoot>
						<td colspan="9"><?php echo $_ClassPaginacao->showPaginacao();?></td>
					</tfoot>
				</table>
			</form>
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