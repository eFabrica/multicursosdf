<?php require_once("php7_mysql_shim.php");
// Class de data
require_once($pathInc . "lib/Data.class.php");

// Class de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Verifica referência
if($_REQUEST["ref"] == ""){
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="?sessao=frequencias&ref=buscar" method="POST" name="formFrequencias">
				<input type="hidden" name="a" value="S">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td width="15%" align="right"><strong>Palavra-chave:</strong></td>
						<td align='left'><input type="text" name="texto" size="50" disabled></td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitarPalavraChave" value="sim" onClick="disen(document.formFrequencias.texto);" ></td>
					</tr>
					<tr>
						<td align="right"><b>Filtrar Turmas:</b></td>
						<td align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formFrequencias.turma);" disabled></td>
						<td align='left'></td>
					</tr>
					<tr>
						<td align="right"><strong>Turma:</strong></td>
						<td align='left'>
							<select name="turma" disabled>
								<?php
								// Busca Turmas
								$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND concluido = 'N' AND deletado = 'N'");
								
								// Traz Turmas
								while($trazTurmas = mysql_fetch_object($buscaTurmas)){
									
									// Dados do Curso
									$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazTurmas->curso . "'");
									?>
									<option value="<?php print($trazTurmas->id);?>"><?php print($dadosCurso->sigla . $trazTurmas->numero . " (" . $_ClassData->transformaData($trazTurmas->datainicio, 2) . ")");?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formFrequencias.turma);disen(document.formFrequencias.procura);" ></td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
						<td align="right"><strong>Todas</strong></td>
						<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formFrequencias.habilitarPalavraChave);checkedDisable(document.formFrequencias.habilitarPalavraChave);
																									 disen(document.formFrequencias.habilitarTurma);checkedDisable(document.formFrequencias.habilitarTurma);
																									 disable(document.formFrequencias.texto);
																									 disable(document.formFrequencias.turma);
																									 disable(document.formFrequencias.procura);
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
}elseif($_REQUEST["ref"] == "buscar"){
	
	/* Gravando dados da pesquisa na sessão */
	if($_REQUEST["a"] == "S"){
	
		// Consulta
		$_SESSION["consultaFrequencias"] = $_POST;
		
	}
	
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
				if($_SESSION["consultaFrequencias"]["todas"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Todas as Matrículas</strong></ol></td>
					</tr>
					<?php
				}
				 
				// Verifica se foi habilitado o campo de Palavra-Chave
				if($_SESSION["consultaFrequencias"]["habilitarPalavraChave"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Palavra-Chave:</strong>&nbsp;<?php echo $_SESSION["consultaFrequencias"]["texto"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de turma
				if($_SESSION["consultaFrequencias"]["habilitarTurma"] == "sim"){
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaFrequencias"]["turma"] . "'");
					
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
						<form action="" method="POST" name="formFrequencias">
							<input type="hidden" name="act" value="">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%">#</th>										
										<th width="40%">Aluno</th>
										<th width="25%">Curso/Turma</th>
										<th width="20%">Turno</th>
										<th width="5%">Concluído</th>
										<th width="5%">Freq.</th>
									</tr>
								</thead>
								<tbody>
									<?php				
									/* Construindo sql */
									$sql = "SELECT * FROM `matriculas`";
									$sql .= " WHERE ";
									
									// Verifica se a pesquisa foi por todas as faltas
									if($_SESSION["consultaFrequencias"]["todas"] != "sim"){
										
										// Verifica se foi habilitado o campo de palavra-chave
										if($_SESSION["consultaFrequencias"]["habilitarPalavraChave"] == "sim"){
											
											// Busca Alunos
											$buscaAlunos = $_ClassMysql->query("SELECT * FROM `alunos` WHERE rg LIKE '%" . $_SESSION["consultaFrequencias"]["texto"] . "%' AND deletado = 'N' OR
																										     cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_SESSION["consultaFrequencias"]["texto"]) . "%' AND deletado = 'N' OR
																										 	 nome LIKE '%" . $_SESSION["consultaFrequencias"]["texto"] . "%' AND deletado = 'N' OR
																										 	 email LIKE '%" . $_SESSION["consultaFrequencias"]["texto"] . "%' AND deletado = 'N'");
											
											// Traz Alunos
											while($trazAlunos = mysql_fetch_object($buscaAlunos)){
											
												// SQL
												$sql .= "unidade = '" . $_dadosUnidade->id . "' AND aluno = '" . $trazAlunos->id . "' AND deletado = 'N' OR";
											
											}
											 
											// SQl
											$sql .= " unidade = '" . $_dadosUnidade->id . "' AND numero = '" . $_SESSION["consultaFrequencias"]["texto"] . "' AND deletado = 'N' OR";
											
										}elseif($_SESSION["consultaFrequencias"]["habilitarTurma"] == "sim"){
											
											// SQl
											$sql .= " unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $_SESSION["consultaFrequencias"]["turma"] . "' AND deletado = 'N' OR";
											
										}
										
										// SQL
										$sql .= "{aqui}";
										$sql = str_replace("OR{aqui}", "", $sql);
										
									}else{
										
										// SQL
										$sql .= "unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'";
										
									}
				
									/* Fim da construção */
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=frequencias&ref=buscar");
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
												<td align="center"><a name="<?=$trazResultados->id?>"></a><?php print($dadosAluno->nome);?></td>
												<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
												<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
												<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print((($trazResultados->reprovado == "S")?"X":$trazResultados->concluido));?>.png"></td>
												<td align="center"><a href="#" onclick="popup('frequencias<?=$trazResultados->id?>', '<?php print($pathInc);?>modulos/gerenciamentos/_/_frequencias.listagem.php?idMatricula=<?php print($trazResultados->id);?>', 730, 400, 'yes')"><img src="<?php print($pathInc);?>imagens/icones/sh.png" border="0"></a></td>
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