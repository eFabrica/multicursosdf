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
			<form action="?sessao=faltadocumentos&ref=buscar" method="POST" name="formFaltaDocumentos">
				<input type="hidden" name="a" value="S">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr bgcolor="#F9F9F9">
						<td width="15%" align="right"><strong>Palavra-chave:</strong></td>
						<td align='left'><input type="text" name="texto" size="50" disabled></td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitarPalavraChave" value="sim" onClick="disen(document.formFaltaDocumentos.texto);" ></td>
					</tr>
					<tr>
						<td align="right"><b>Filtrar Turmas:</b></td>
						<td align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formFaltaDocumentos.turma);" disabled></td>
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
					 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formFaltaDocumentos.turma);disen(document.formFaltaDocumentos.procura);" ></td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
						<td align="right"><strong>Todas</strong></td>
						<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formFaltaDocumentos.habilitarPalavraChave);checkedDisable(document.formFaltaDocumentos.habilitarPalavraChave);
																									 disen(document.formFaltaDocumentos.habilitarTurma);checkedDisable(document.formFaltaDocumentos.habilitarTurma);
																									 disable(document.formFaltaDocumentos.texto);
																									 disable(document.formFaltaDocumentos.turma);
																									 disen(document.formFaltaDocumentos.procura);
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
		$_SESSION["consultaFaltaDocumentos"] = $_POST;
		
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
				// Verifica Todas
				if($_REQUEST["todas"] != ""){$_SESSION["consultaFaltaDocumentos"]["todas"] = $_REQUEST["todas"];}
				
				// Verifica se a busca é por todas as notas fiscais
				if($_SESSION["consultaFaltaDocumentos"]["todas"] == "sim"){
					?>
					<tr>
						<td align='left'><ol><strong>Todas as Faltas de Documentos</strong></ol></td>
					</tr>
					<?php
				}
				
				// Verifica Palavra Chave
				if($_REQUEST["habilitarPalavraChave"] != ""){$_SESSION["consultaFaltaDocumentos"]["habilitarPalavraChave"] = $_REQUEST["habilitarPalavraChave"];}
				
				// Verifica se foi habilitado o campo de Palavra-Chave
				if($_SESSION["consultaFaltaDocumentos"]["habilitarPalavraChave"] == "sim"){
					
					// Verifica Texto
					if($_REQUEST["texto"] != ""){$_SESSION["consultaFaltaDocumentos"]["texto"] = $_REQUEST["texto"];}
					?>
					<tr>
						<td align='left'><ol><strong>Palavra-Chave:</strong>&nbsp;<?php print($_SESSION["consultaFaltaDocumentos"]["texto"]); ?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica Turma
				if($_REQUEST["habilitarTurma"] != ""){$_SESSION["consultaFaltaDocumentos"]["habilitarTurma"] = $_REQUEST["habilitarTurma"];}
				
				// Verifica se foi habilitado o campo de turma
				if($_SESSION["consultaFaltaDocumentos"]["habilitarTurma"] == "sim"){
					
					// Verifica Turma
					if($_REQUEST["turma"] != ""){$_SESSION["consultaFaltaDocumentos"]["turma"] = $_REQUEST["turma"];}
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaFaltaDocumentos"]["turma"] . "'");
					
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
						<form action="" method="POST" name="formFaltaDocumentos">
							<input type="hidden" name="act" value="">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%">#</th>										
										<th width="55%">Aluno</th>
										<th width="40%">Curso/Turma</th>
										<th width="5%">Concluído</th>
									</tr>
								</thead>
								<tbody>
									<?php
									// SQL
									$sql = "SELECT matriculas.turma, 
												   matriculas.id,
												   matriculas.numero,
												   matriculas.concluido,
												   alunos.nome FROM `matriculas`,`faltadocumentos`,`alunos` WHERE ";
									
									// Where
									$where =  " faltadocumentos.matricula = matriculas.id AND 
												alunos.id = matriculas.aluno AND
											    faltadocumentos.deletado = 'N' AND 
											    matriculas.deletado = 'N' AND
											    alunos.deletado = 'N' AND 
											    matriculas.unidade = '" . $_dadosUnidade->id . "' AND ";
									
									// Verifica se a pesquisa foi por todas as faltas
									if($_SESSION["consultaFaltaDocumentos"]["todas"] != "sim"){
										
										// Verifica se foi habilitado o campo de Turma
										if($_SESSION["consultaFaltaDocumentos"]["habilitarTurma"] == "sim"){
											
											// WHERE
											$where .= " matriculas.turma = '" . $_SESSION["consultaFaltaDocumentos"]["turma"] . "' AND ";
											
										}
										
										// Verifica se foi habilitado o campo de palavra-chave
										if($_SESSION["consultaFaltaDocumentos"]["habilitarPalavraChave"] == "sim"){
											
											// SQL
											$sql .= $where . " alunos.rg LIKE '%" . $_SESSION["consultaFaltaDocumentos"]["texto"] . "%' OR ";
											$sql .= $where . " alunos.cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_SESSION["consultaFaltaDocumentos"]["texto"]) . "%' OR ";
											$sql .= $where . " alunos.nome LIKE '%" . $_SESSION["consultaFaltaDocumentos"]["texto"] . "%' OR ";
											$sql .= $where . " alunos.email LIKE '%" . $_SESSION["consultaFaltaDocumentos"]["texto"] . "%' OR ";
											$sql .= $where . " matriculas.numero LIKE '%" . $_SESSION["consultaFaltaDocumentos"]["texto"] . "%' OR ";
											
										}else{
											
											// SQL
											$sql .= $where;
											
										}
										
										// SQL
										$sql .= "{aqui}";
										$sql = str_replace("OR {aqui}", "", $sql);
										$sql = str_replace("AND {aqui}", "", $sql);
										
									}else{
										
										// SQL
										$sql .= $where;
										
										// SQL
										$sql .= "{aqui}";
										$sql = str_replace("OR {aqui}", "", $sql);
										$sql = str_replace("AND {aqui}", "", $sql);
										
									}
									
									// SQL
									$sql .= " GROUP BY matriculas.id ORDER BY alunos.nome ASC";
									
									/* Fim da construção */
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=faltadocumentos&ref=buscar");
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
											
											// Dados do Aluno
											//$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazResultados->aluno . "'");
											?>
											<tr class=row0>
												<td align='left'><?php print($trazResultados->numero); ?></td>
												<td align="center"><a name="<?=$trazResultados->id?>"></a><a href="#" onclick="popup('documentos<?=$trazResultados->id?>', '<?php print($pathInc);?>modulos/gerenciamentos/_/_faltadocumentos.listagem.php?idMatricula=<?php print($trazResultados->id);?>', 730, 400, 'yes')"><?php print($trazResultados->nome);?></a></td>
												<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
												<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print((($trazResultados->concluido == "S")?"S":(($trazResultados->reprovado == "S")?"X":"N")));?>.png"></td>
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