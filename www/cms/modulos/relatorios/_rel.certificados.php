<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Class de data
require_once($pathInc . "lib/Data.class.php");

// Class de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");
	
// Verifica se tem id do registro
if($_REQUEST["idRegistro"] > 0){
	
	// Adiciona na sessão
	$_SESSION["idGrade"] = $_REQUEST["idRegistro"];
	$_SESSION["urlPesquisa"] = "&ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"];
	
}
?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00037.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Relatórios [Certificados] <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica SubMenu
							if($_REQUEST["submenu"] == "buscar" || $_SESSION["consultaCertificados"]["idMatricula"] > 0){
								?>
								<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formCertificados.submit();"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Imprimir</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=rel_certificados"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
								<?php
							}
							?>
						</table>
					</td>
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
	// Verifica sub-referência
	if($_REQUEST["submenu"] == ""){
		?>
		<tr>
			<td align='left'><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<form action="?sessao=rel_certificados&submenu=buscar" method="POST" name="formCertificados">
					<input type="hidden" name="a" value="S">
					<table border="0" cellpadding="2" cellspacing="2" align="center">
						<tr bgcolor="#F9F9F9">
							<td width="15%" align="right"><strong>Palavra-chave:</strong></td>
							<td align='left'><input type="text" name="texto" size="50" disabled></td>
						 	<td width="5%" align="center"><input type="checkbox" name="habilitarPalavraChave" value="sim" onClick="disen(document.formCertificados.texto);" ></td>
						</tr>
						<tr>
							<td align="right"><b>Filtrar Turmas:</b></td>
							<td align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formCertificados.turma);" disabled></td>
							<td align='left'></td>
						</tr>
						<tr>
							<td align="right"><strong>Turma:</strong></td>
							<td align='left'>
								<select name="turma" disabled>
									<?php
									// Busca Turmas
									$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
									
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
						 	<td align="center"><input type="checkbox" name="habilitarTurma" value="sim" onClick="disen(document.formCertificados.turma);disen(document.formCertificados.procura);" ></td>
						</tr>
						<tr>
							<td align='left'>&nbsp;</td>
							<td align="right"><strong>Todas</strong></td>
							<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formCertificados.habilitarPalavraChave);checkedDisable(document.formCertificados.habilitarPalavraChave);
																										 disen(document.formCertificados.habilitarTurma);checkedDisable(document.formCertificados.habilitarTurma);
																										 disable(document.formCertificados.texto);
																										 disable(document.formCertificados.procura);
																										 disable(document.formCertificados.turma);
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
		
			// Consulta
			$_SESSION["consultaCertificados"] = $_POST;
			
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
					// Verifica se a busca é por todas as certificados fiscais
					if($_SESSION["consultaCertificados"]["todas"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Todas as Matrículas</strong></ol></td>
						</tr>
						<?php
					}
					 
					// Verifica se foi habilitado o campo de Palavra-Chave
					if($_SESSION["consultaCertificados"]["habilitarPalavraChave"] == "sim"){
						?>
						<tr>
							<td align='left'><ol><strong>Palavra-Chave:</strong>&nbsp;<?php echo $_SESSION["consultaCertificados"]["texto"]?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de turma
					if($_SESSION["consultaCertificados"]["habilitarTurma"] == "sim"){
						
						// Dados da Turma
						$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["consultaCertificados"]["turma"] . "'");
						
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
				<form action="<?php print($pathInc);?>modulos/relatorios/_rel.certificados.emitir.php" method="POST" name="formCertificados" target="_blank">
					<table width="99%" border="0" cellpadding="2" cellspacing="2">
						<tr>
							<td width="10%" align="right"><b>Tipo:</b></td>
							<td width='90%' align='left'>
								<select name="tipo">
									<option value="frente">Frente</option>
									<option value="verso">Verso</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="hidden" name="act" value="">
								<table class="consulta" cellspacing="1" align="center">
									<thead>
										<tr>
											<th width="1%">#</th>
											<th width="1%" align="center"><input type="checkbox" onclick="select_all('formCertificados', 'registros[]')" checked></th>
											<th width="40%">Aluno</th>
											<th width="25%">Curso/Turma</th>
											<th width="25%">Turno</th>
										</tr>
									</thead>
									<tbody>
										<?php				
										/* Construindo sql */
										$sql = "SELECT matriculas.id,
													   matriculas.turma,
													   matriculas.aluno,
													   matriculas.concluido,
													   matriculas.empresa,
													   matriculas.numero,
													   alunos.nome FROM `matriculas`,`alunos`";
										$sql .= " WHERE ";
										if($_SESSION["consultaCertificados"]["todas"] != "sim"){
											
											$sql1 = (($_SESSION["consultaCertificados"]["habilitarTurma"] == "sim")?" alunos.id = matriculas.aluno AND matriculas.turma > 0 AND matriculas.reprovado = 'N' AND matriculas.turma = '" . $_SESSION["consultaCertificados"]["turma"] . "' AND":"");
											$sql2 = (($_SESSION["consultaCertificados"]["habilitarPalavraChave"] == "sim")? $sql1. " alunos.id = matriculas.aluno AND matriculas.turma > 0 AND matriculas.reprovado = 'N' AND alunos.rg LIKE '%" . $_SESSION["consultaCertificados"]["texto"] . "%' AND alunos.deletado = 'N' OR
																														    " . $sql1 . " alunos.id = matriculas.aluno AND matriculas.turma > 0 AND matriculas.reprovado = 'N' AND alunos.cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_SESSION["consultaCertificados"]["texto"]) . "%' AND alunos.deletado = 'N' OR
																														 	" . $sql1 . " alunos.id = matriculas.aluno AND matriculas.turma > 0 AND matriculas.reprovado = 'N' AND alunos.nome LIKE '%" . $_SESSION["consultaCertificados"]["texto"] . "%' AND alunos.deletado = 'N'  
																														 	" . (($_SESSION["consultaCertificados"]["texto"] > 0)?" OR " . $sql1 . " alunos.id = matriculas.aluno AND matriculas.turma > 0 AND matriculas.reprovado = 'N' AND matriculas.numero = '" . $_SESSION["consultaCertificados"]["texto"] . "' AND ":" AND "):"");
											
											//$sql .= (($_POST["habilitar"] == "sim")?"":"");
										}else{
											
											$sql .= "alunos.id = matriculas.aluno AND matriculas.turma > 0 AND matriculas.reprovado = 'N' AND ";
											
										}
										$sql .= (($sql1 != "" && $sql2 != "")?$sql2:(($sql1 != "" && $sql2 == "")?$sql1:(($sql1 == "" && $sql2 != "")?$sql2:""))) . " matriculas.deletado = 'N' ORDER BY alunos.nome";
										//print($sql);
										/* Construindo sql 
										$sql = "SELECT matriculas.turma,
													   matriculas.aluno,
													   matriculas.id,
													   matriculas.numero,
													   matriculas.concluido,
													   alunos.nome FROM `matriculas`,`alunos`";
										$sql .= " WHERE ";
										
										// Verifica se a pesquisa foi por todas as faltas
										if($_SESSION["consultaCertificados"]["todas"] != "sim"){
											
											// Verifica se foi habilitado o campo de palavra-chave
											if($_SESSION["consultaCertificados"]["habilitarPalavraChave"] == "sim"){
												
												// Busca Alunos
												$buscaAlunos = $_ClassMysql->query("SELECT * FROM `alunos` WHERE rg LIKE '%" . $_SESSION["consultaCertificados"]["texto"] . "%' AND deletado = 'N' OR
																											     cpf LIKE '%" . $_SESSION["consultaCertificados"]["texto"] . "%' AND deletado = 'N' OR
																											 	 nome LIKE '%" . $_SESSION["consultaCertificados"]["texto"] . "%' AND deletado = 'N' OR
																											 	 email LIKE '%" . $_SESSION["consultaCertificados"]["texto"] . "%' AND deletado = 'N'");
												
												// Traz Alunos
												while($trazAlunos = mysql_fetch_object($buscaAlunos)){
												
													// SQL
													$sql .= " alunos.id = matriculas.aluno AND matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.aluno = '" . $trazAlunos->id . "' AND matriculas.turma > 0 AND matriculas.reprovado = 'N' AND matriculas.deletado = 'N' OR";
												
												}
												 
												// SQl
												$sql .= " alunos.id = matriculas.aluno AND matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.numero = '" . $_SESSION["consultaCertificados"]["texto"] . "' AND matriculas.turma > 0 AND matriculas.reprovado = 'N' AND matriculas.deletado = 'N' OR";
												
											}elseif($_SESSION["consultaCertificados"]["habilitarTurma"] == "sim"){
												
												// SQl
												$sql .= " alunos.id = matriculas.aluno AND matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.turma = '" . $_SESSION["consultaCertificados"]["turma"] . "' AND matriculas.turma > 0 AND matriculas.reprovado = 'N' AND matriculas.deletado = 'N' OR";
												
											}
											
											// SQL
											$sql .= "{aqui}";
											$sql = str_replace("OR{aqui}", "", $sql);
											
										}else{
											
											// SQL
											$sql .= "matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.turma > 0 AND matriculas.reprovado = 'N' AND matriculas.deletado = 'N'";
											
										}
										
										// SQL
										$sql .= "GROUP BY matriculas.id ORDER BY alunos.nome ASC";
										*/
										
										/* Fim da construção */
										
										// Paginação
										require_once($pathInc . "lib/Paginacao.class.php");
										
										// Configurações da paginacao
										$_ClassPaginacao->setQuery($sql);
										$_ClassPaginacao->setUrl("?sessao=rel_certificados&subref=buscar&submenu=buscar");
										$_ClassPaginacao->setRegistrosPorPagina("50");
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
												
												// Dados do Aluno
												//$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazResultados->aluno . "'");
												?>
												<tr class=row0>
													<td align='left'><?php print((($trazResultados->numero <= 0)?$trazResultados->id . ".":$trazResultados->numero)); ?></td>
													<td align="center"><?php if($trazResultados->concluido == 'S'){?><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>" checked><?php }?></td>
													<td align="left"><a name="<?=$trazResultados->id?>"></a><?php print($trazResultados->nome);?></td>
													<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
													<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
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
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
		<tr>
			<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
	}
	?>
</table>