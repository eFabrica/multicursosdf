<?php require_once("php7_mysql_shim.php");
// Verifica sub-referência
if($_REQUEST["submenu"] == ""){
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="?sessao=notas&submenu=buscar" method="POST" name="formNotas">
				<input type="hidden" name="a" value="S">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr bgcolor="#F9F9F9">
						<td width="15%" align="right"><strong>Palavra-chave:</strong></td>
						<td align='left'><input type="text" name="texto" size="50" disabled></td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitartexto" value="sim" onClick="disen(document.formNotas.texto);" ></td>
					</tr>
					<tr>
						<td align="right"><b>Filtrar Turmas:</b></td>
						<td align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formNotas.turma);" disabled></td>
						<td align='left'></td>
					</tr>
					<tr>
						<td align="right"><strong>Turma:</strong></td>
						<td align='left'>
							<select name="turma" disabled>
								<?php
								// Busca Turmas
								$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'" . (($_dadosLogado->nivel == "95")?" AND concluido = 'N'":""));
								
								// Traz Turmas
								while($trazTurmas = mysql_fetch_object($buscaTurmas)){
									
									// Verifica nível
									if($_dadosLogado->nivel != "95"){
										
										// Dados do Curso
										$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazTurmas->curso . "'");
										?>
										<option value="<?php print($trazTurmas->id);?>"><?php print($dadosCurso->sigla . $trazTurmas->numero . " (" . $_ClassData->transformaData($trazTurmas->datainicio, 2) . ")");?></option>
										<?php
										
									}else{
									
										// Busca grade horária
										$buscaGradeHoraria = $_ClassMysql->query("SELECT id FROM `gradehoraria` WHERE unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $trazTurmas->id . "' AND instrutor = '" . $_dadosLogado->id . "' AND deletado = 'N'");
										
										// Verifica o total achado
										if(mysql_num_rows($buscaGradeHoraria) > 0){
										
											// Dados do Curso
											$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazTurmas->curso . "'");
											?>
											<option value="<?php print($trazTurmas->id);?>"><?php print($dadosCurso->sigla . $trazTurmas->numero . " (" . $_ClassData->transformaData($trazTurmas->datainicio, 2) . ")");?></option>
											<?php
										}

									}
															
								}
								?>
							</select>
						</td>
					 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formNotas.turma);disen(document.formNotas.procura);" ></td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
						<td align="right"><strong>Todas</strong></td>
						<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formNotas.habilitartexto);checkedDisable(document.formNotas.habilitartexto);
																									 disen(document.formNotas.habilitarTurma);checkedDisable(document.formNotas.habilitarTurma);
																									 disable(document.formNotas.texto);
																									 disable(document.formNotas.procura);
																									 disable(document.formNotas.turma);
																									 this.disabled = false;" ></td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
						<td align="left"><input type="submit" value="Consultar"></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}elseif($_REQUEST["submenu"] == "buscar"){
	
	/* Gravando dados da pesquisa na sessão */
	if($_REQUEST["a"] == "S"){
	
		unset($_SESSION["consultaNotas"]);
		
		// Consulta
		$_SESSION["consultaNotas"] = $_POST;
		
	}
	//print_r($_SESSION["consultaNotas"]);
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td class="menu_topico">Buscando por: </td>
				</tr>
				<?php
				// Verifica se a busca é por todas as notas fiscais
				if($_SESSION["consultaNotas"]["todas"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Todas as Matrículas</strong></ol></td>
					</tr>
					<?php
				}
				 
				// Verifica se foi habilitado o campo de Palavra-Chave
				if($_SESSION["consultaNotas"]["habilitartexto"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Palavra-Chave:</strong>&nbsp;<?php echo $_SESSION["consultaNotas"]["texto"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de turma
				if($_SESSION["consultaNotas"]["habilitarTurma"] == "sim"){
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaNotas"]["turma"] . "'");
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Turma:</strong>&nbsp;<?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></ol></td>
					</tr>
					<?php
				}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td align='left'>
						<form action="" method="POST" name="formNotas">
							<input type="hidden" name="act" value="">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%">#</th>										
										<th width="40%">Aluno</th>
										<th width="25%">Curso/Turma</th>
										<th width="20%">Turno</th>
										<th width="5%">Concluído</th>
									</tr>
								</thead>
								<tbody>
									<?php	
									/*			
									/* Construindo sql
									$sql = "SELECT matriculas.turma,
												   matriculas.aluno,
												   matriculas.numero,
												   matriculas.id,
												   matriculas.concluido FROM `matriculas`,`alunos`";
									$sql .= " WHERE matriculas.aluno = alunos.id AND ";
									
									// Verifica se a pesquisa foi por todas as faltas
									if($_SESSION["consultaNotas"]["todas"] != "sim"){
										
										// Verifica se foi habilitado o campo de palavra-chave
										if($_SESSION["consultaNotas"]["habilitartexto"] == "sim"){
											
											// Verifica nível
											if($_dadosLogado->nivel != "95"){
											
												// Busca Alunos
												$buscaAlunos = $_ClassMysql->query("SELECT * FROM `alunos` WHERE rg LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND deletado = 'N' OR
																											     cpf LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND deletado = 'N' OR
																											 	 nome LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND deletado = 'N' OR
																											 	 email LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND deletado = 'N'");
												
												// Traz Alunos
												while($trazAlunos = mysql_fetch_object($buscaAlunos)){
												
													// SQL
													$sql .= " matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.aluno = '" . $trazAlunos->id . "' AND matriculas.deletado = 'N' OR";
												
												}
												 
												// SQl
												$sql .= " matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.numero = '" . $_SESSION["consultaNotas"]["texto"] . "' AND matriculas.deletado = 'N' OR";
												
											}else{
												
												// Busca Alunos
												$buscaAlunos = $_ClassMysql->query("SELECT * FROM `alunos` WHERE rg LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND deletado = 'N' OR
																											     cpf LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND deletado = 'N' OR
																											 	 nome LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND deletado = 'N' OR
																											 	 email LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND deletado = 'N'");
												
												// Traz Alunos
												while($trazAlunos = mysql_fetch_object($buscaAlunos)){
													
													// Busca Matrícula
													$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE unidade = '" . $_dadosUnidade->id . "' AND aluno = '" . $trazAlunos->id . "' AND concluido = 'N' AND deletado = 'N'");
													
													// Traz Matrículas
													while ($trazMatriculas = mysql_fetch_object($buscaMatriculas)) {
														
														// Busca grade horária
														$buscaGradeHoraria = $_ClassMysql->query("SELECT id FROM `gradehoraria` WHERE unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $trazMatriculas->turma . "' AND instrutor = '" . $_dadosLogado->id . "' AND deletado = 'N'");
														
														// Verifica o total achado
														if(mysql_num_rows($buscaGradeHoraria) > 0){
															
															// SQL
															$sql .= " matriculas.id = '" . $trazMatriculas->id . "' AND matriculas.deletado = 'N' OR";
															
														}
														
													}
												
												}
												
											}
											
										}elseif($_SESSION["consultaNotas"]["habilitarTurma"] == "sim"){
											
											// SQl
											$sql .= " matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.turma = '" . $_SESSION["consultaNotas"]["turma"] . "' AND matriculas.deletado = 'N' OR";
											
										}
										
										// SQL
										$sql .= "{aqui}";
										$sql = str_replace("OR{aqui}", "", $sql);
										
									}else{
										
										// Verifica nível
										if($_dadosLogado->nivel != "95"){
											
											// SQL
											$sql .= "matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.deletado = 'N'";
											
										}else{
										
											// Busca Turmas
											$buscaTurmas = $_ClassMysql->query("SELECT id FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'" . (($_dadosLogado->nivel == "95")?" AND concluido = 'N'":""));
											
											// Traz Turmas
											while($trazTurmas = mysql_fetch_object($buscaTurmas)){
											
												// Busca grade horária
												$buscaGradeHoraria = $_ClassMysql->query("SELECT id FROM `gradehoraria` WHERE unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $trazTurmas->id . "' AND instrutor = '" . $_dadosLogado->id . "' AND deletado = 'N'");
												
												// Verifica o total achado
												if(mysql_num_rows($buscaGradeHoraria) > 0){
													
													// SQL
													$sql .= "matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.turma = '" . $trazTurmas->id . "' AND matriculas.deletado = 'N' OR";
													
												}
												
											}
											
											// SQL
											$sql .= "{aqui}";
											$sql = str_replace("OR{aqui}", "", $sql);
											
										}
										
									}
									
									*/
									/* Construindo sql */
									$sql = "SELECT matriculas.id,
											   matriculas.turma,
											   matriculas.aluno,
											   matriculas.concluido,
											   matriculas.reprovado,
											   matriculas.empresa,
											   matriculas.numero FROM `matriculas`,`alunos`" . (($_dadosLogado->nivel == "95")?", `gradehoraria`":"");
									$sql .= " WHERE ";
									if($_SESSION["consultaNotas"]["todas"] != "sim"){
										
										$sql1 = (($_SESSION["consultaNotas"]["habilitarTurma"] == "sim")?(($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . " alunos.id = matriculas.aluno AND alunos.deletado = 'N' AND matriculas.deletado = 'N' AND matriculas.turma = '" . $_SESSION["consultaNotas"]["turma"] . "' AND":"");
										$sql2 = (($_SESSION["consultaNotas"]["habilitartexto"] == "sim")? $sql1 . (($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . " alunos.id = matriculas.aluno AND alunos.rg LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND alunos.deletado = 'N' AND matriculas.deletado = 'N' OR
																										    " . $sql1 . (($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . " alunos.id = matriculas.aluno AND alunos.cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_SESSION["consultaNotas"]["texto"]) . "%' AND alunos.deletado = 'N' AND matriculas.deletado = 'N' OR
																										 	" . $sql1 . (($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . " alunos.id = matriculas.aluno AND alunos.nome LIKE '%" . $_SESSION["consultaNotas"]["texto"] . "%' AND alunos.deletado = 'N' AND matriculas.deletado = 'N'  
																										 	" . (($_SESSION["consultaNotas"]["texto"] > 0)?" OR " . $sql1 . (($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . " alunos.id = matriculas.aluno AND alunos.deletado = 'N' AND matriculas.numero = '" . $_SESSION["consultaNotas"]["texto"] . "' AND matriculas.deletado = 'N' AND ":" AND "):"");
										
										//$sql .= (($_POST["habilitar"] == "sim")?"":"");
									}else{
										
										$sql .= (($_dadosLogado->nivel == "95")?"gradehoraria.turma = turmas.id AND gradehoraria.deletado = 'N' AND gradehoraria.instrutor = '" . $_dadosLogado->id . "'":"") . "alunos.id = matriculas.aluno AND alunos.deletado = 'N' AND matriculas.deletado = 'N' AND ";
										
									}
									$sql .= (($sql1 != "" && $sql2 != "")?$sql2:(($sql1 != "" && $sql2 == "")?$sql1:(($sql1 == "" && $sql2 != "")?$sql2:"")));
									$sql .= "{aqui}";
									$sql = str_replace("AND {aqui}", "", $sql);
									$sql = str_replace("AND{aqui}", "", $sql);
									$sql = str_replace("{aqui}", "", $sql);
									$sql .= " ORDER BY alunos.nome";
									
									/* Fim da construção */
									
									//print($sql);
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=notas&subref=buscar&submenu=buscar&cont=" . $_REQUEST["cont"]);
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
										
										// Contador
										$cont = 0;
										
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
											?>
											<tr class=row0>
												<td align='left'><?php print($trazResultados->numero); ?></td>
												<td align="center"><a name="<?=$trazResultados->id?>"></a><a href="#" onclick="popup('notas<?=$trazResultados->id?>', '<?php print($pathInc);?>modulos/gerenciamentos/_/_notas.listagem.php?idMatricula=<?php print($trazResultados->id);?>', 730, 400, 'yes')"><?php print($dadosAluno->nome);?></a></td>
												<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
												<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
												<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print((($trazResultados->reprovado == "S")?"X":$trazResultados->concluido));?>.png"></td>
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
			</table>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}
?>