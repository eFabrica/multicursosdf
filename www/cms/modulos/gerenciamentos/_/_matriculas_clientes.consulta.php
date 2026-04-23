<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
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
			<form action="?sessao=matriculas&subsessao=<?php print($_REQUEST["subsessao"]);?>&ref=buscar" method="POST" name="formMatricula">
				<input type="hidden" name="a" value="S">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td width="15%" align="right"><strong>Palavra-Chave:</strong></td>
						<td align='left'><input type="text" name="palavraChave" size="50" disabled></td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitarPalavraChave" value="sim" onClick="disen(document.formMatricula.palavraChave);" ></td>
					</tr>
					<tr>
						<td width="15%" align="right"><strong>Data:</strong></td>
						<td align='left'>
							De <input type="text" id="dataI" name="dataI" size="12" onKeyUp="maskData(this, document.formMatricula.dataF)" disabled>
					  		até <input type="text" id="dataF" name="dataF" size="12" onKeyUp="maskData(this, document.formMatricula.dataF)" disabled>
						</td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitarData" value="sim" onClick="disen(document.formMatricula.dataI);disen(document.formMatricula.dataF);" ></td>
					</tr>
					<tr>
						<td align="right"><strong>Empresa:</strong></td>
						<td align='left'>
							<select name="empresa" disabled>
								<?php
								// Busca Empresas
								$buscaEmpresas = $_ClassMysql->query("SELECT * FROM `clientes` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N' ORDER BY nomefantasia");
								
								// Traz Empresas
								while($trazEmpresas = mysql_fetch_object($buscaEmpresas)){
									?>
									<option value="<?php print($trazEmpresas->id);?>"><?php print($trazEmpresas->nomefantasia);?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					 	<td align="center"><input type="checkbox" name="habilitarEmpresa" value="sim" onClick="disen(document.formMatricula.empresa);" ></td>
					</tr>
					<tr>
						<td align="right"><strong>Turma:</strong></td>
						<td align='left'>
							<select name="turma" disabled>
								<?php
								// Busca Turmas
								$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N' ORDER BY concluido");
								
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
					 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formMatricula.turma);" ></td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
						<td align="right"><strong>Todas</strong></td>
						<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formMatricula.habilitarPalavraChave);checkedDisable(document.formMatricula.habilitarPalavraChave);
																									 disen(document.formMatricula.habilitarTurma);checkedDisable(document.formMatricula.habilitarTurma);
																									 disen(document.formMatricula.habilitarData);checkedDisable(document.formMatricula.habilitarData);
																									 disen(document.formMatricula.habilitarEmpresa);checkedDisable(document.formMatricula.habilitarEmpresa);
																									 disable(document.formMatricula.palavraChave);
																									 disable(document.formMatricula.turma);
																									 disable(document.formMatricula.dataI);
																									 disable(document.formMatricula.dataF);
																									 disable(document.formMatricula.empresa);
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
		$_SESSION["consultaMatriculasEmpresas"] = $_POST;
		
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
				// Verifica se a busca é por todas as matriculas
				if($_SESSION["consultaMatriculasEmpresas"]["todas"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Todas as Matrículas</strong></ol></td>
					</tr>
					<?php
				}
				 
				// Verifica se foi habilitado o campo de palavra Chave
				if($_SESSION["consultaMatriculasEmpresas"]["habilitarPalavraChave"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Palavra-Chave:</strong>&nbsp;<?php echo $_SESSION["consultaMatriculasEmpresas"]["palavraChave"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de data
				if($_SESSION["consultaMatriculasEmpresas"]["habilitarData"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaMatriculasEmpresas"]["dataI"]?> até <?php echo $_SESSION["consultaMatriculasEmpresas"]["dataF"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de Empresa
				if($_SESSION["consultaMatriculasEmpresas"]["habilitarEmpresa"] == "sim"){
					
					// Dados da Empresa
					$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "nomefantasia", "id = '" . $_SESSION["consultaMatriculasEmpresas"]["empresa"] . "'");
					?>
					<tr>
						<td align='left'><ol><strong>Empresa:</strong>&nbsp;<?php print($dadosEmpresa->nomefantasia);?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de turma
				if($_SESSION["consultaMatriculasEmpresas"]["habilitarTurma"] == "sim"){
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaMatriculasEmpresas"]["turma"] . "'");
					
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
	<?php
	// Verifica Ação
	if($_REQUEST["act"] == "deletar"){
		
		// Lê Registros
		for($y = 0; $y < count($_REQUEST["registros"]); $y++){
			
			// Dados da Matricula
			$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "turma", "id= '" . $_REQUEST["registros"][$y] . "'");
			
			// Desocupa Vaga na Turma
			$desocupaVaga = $_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = (vagasocupadas-1) WHERE id= '" . $dadosMatricula->turma . "'");
			
			// Deleta Parcelas
			$deletaParcelas = $_ClassMysql->query("UPDATE `parcelas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id ."', datahorad = NOW() WHERE matricula = '" . $_REQUEST["registros"][$y] . "'");
			
			// Deleta Documentos em Falta
			$deletaFaltaDocumentos = $_ClassMysql->query("UPDATE `faltadocumentos` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id ."', datahorad = NOW() WHERE matricula = '" . $_REQUEST["registros"][$y] . "'");
			
			// Deleta Registros
			$_ClassMysql->query("UPDATE `matriculas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
			
		}
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);
		
		// Seta Mensagem de Sucesso
		$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " matrícula(s) foi(ram) deletada(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
		
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
			<table width="99%" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td width="15%" align="right">Com Selecionados:</td>
					<td width='85%' align='left'>
						<select onchange="if(confirm('Deseja mesmo deletar este(s) registro(s)?')){document.formMatricula.act.value = '' + this.options[this.selectedIndex].value; document.formMatricula.submit();}">
							<option value=""></option>
							<option value="deletar">Deletar</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<form action='' method="POST" name="formMatricula">
							<input type="hidden" name="act" value="">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%">#</th>
										<th width="1%" align="center"><input type="checkbox" onclick="select_all('formMatricula', 'registros[]')"></th>
										<th width="40%">Aluno</th>
										<th width="25%">Curso/Turma</th>
										<th width="15%">Turno</th>
										<th width="5%">Concluído</th>
									</tr>
								</thead>
								<tbody>
									<?php	
									/* Construindo sql */
									$sql = "SELECT matriculas.id,
												   matriculas.turma,
												   matriculas.aluno,
												   matriculas.reprovado,
												   matriculas.concluido,
												   matriculas.numero FROM `matriculas`,`alunos`" . (($_SESSION["consultaMatriculasEmpresas"]["habilitarData"] == "sim")?",`turmas`":"");
									$sql .= " WHERE ";
									if($_SESSION["consultaMatriculasEmpresas"]["todas"] != "sim"){
										
										$sql .= (($_SESSION["consultaMatriculasEmpresas"]["habilitarPalavraChave"] == "sim")?" alunos.id = matriculas.aluno AND matriculas.empresa > 0 AND matriculas.deletado = 'N' AND alunos.rg LIKE '%" . $_SESSION["consultaMatriculasEmpresas"]["palavraChave"] . "%' AND alunos.deletado = 'N' OR
																										     alunos.id = matriculas.aluno AND matriculas.empresa > 0 AND matriculas.deletado = 'N' AND alunos.cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_SESSION["consultaMatriculasEmpresas"]["palavraChave"]) . "%' AND alunos.deletado = 'N' OR
																										 	 alunos.id = matriculas.aluno AND matriculas.empresa > 0 AND matriculas.deletado = 'N' AND alunos.nome LIKE '%" . $_SESSION["consultaMatriculasEmpresas"]["palavraChave"] . "%' AND alunos.deletado = 'N' AND ":"");
										$sql .= (($_SESSION["consultaMatriculasEmpresas"]["habilitarTurma"] == "sim")?" alunos.id = matriculas.aluno AND matriculas.empresa > 0 AND matriculas.deletado = 'N' AND alunos.deletado = 'N' AND matriculas.turma = '" . $_SESSION["consultaMatriculasEmpresas"]["turma"] . "' AND":"");
										$sql .= (($_SESSION["consultaMatriculasEmpresas"]["habilitarEmpresa"] == "sim")?" alunos.id = matriculas.aluno AND matriculas.empresa > 0 AND matriculas.deletado = 'N' AND alunos.deletado = 'N' AND matriculas.empresa = '" . $_SESSION["consultaMatriculasEmpresas"]["empresa"] . "' AND":"");
										$sql .= (($_SESSION["consultaMatriculasEmpresas"]["habilitarData"] == "sim")?" matriculas.turma = turmas.id AND alunos.id = matriculas.aluno AND matriculas.empresa > 0 AND matriculas.deletado = 'N' AND alunos.deletado = 'N' AND turmas.datainicio >= '" . $_ClassData->transformaData($_SESSION["consultaMatriculasEmpresas"]["dataI"]) . "' AND turmas.datainicio <= '" . $_ClassData->transformaData($_SESSION["consultaMatriculasEmpresas"]["dataF"]) . "' AND":"");
										
										//$sql .= (($_POST["habilitar"] == "sim")?"":"");
									}else{
										
										$sql .= " matriculas.empresa > 0 AND alunos.id = matriculas.aluno AND alunos.deletado = 'N' AND matriculas.deletado = 'N' AND ";
										
									}
									$sql .= "{aqui}";
									$sql = str_replace("AND {aqui}", "", $sql);
									$sql = str_replace("AND{aqui}", "", $sql);
									$sql = str_replace("{aqui}", "", $sql);
									$sql .= " ORDER BY alunos.nome";
				
									/* Fim da construção */
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=matriculas&ref=buscar&subsessao=" . $_REQUEST["subsessao"] . "&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&filtro=" . $_REQUEST["filtro"]);
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
											?>
											<tr class=row0>
												<td align='left'><?php print($trazResultados->numero); ?></td>
												<td align="center"><?php if($trazResultados->concluido == "N"){?><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"><?php }?></td>
												<td align="center"><a name="<?=$trazResultados->id?>"></a><a href="?sessao=matriculas&subsessao=<?php print($_REQUEST["subsessao"]);?><?="&pg=" . $_REQUEST['pg'] . "&ref=edit&idRegistro=" . $trazResultados->id?>"><?php print($dadosAluno->nome);?></a></td>
												<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
												<td align="center"><?php print($dadosTurno->turno); ?></td>
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