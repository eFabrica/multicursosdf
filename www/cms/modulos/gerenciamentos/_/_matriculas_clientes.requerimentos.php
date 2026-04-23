<?php require_once("php7_mysql_shim.php");
// Verifica se foi informada alguma empresa
if($_REQUEST["empresa"] == ""){
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formRequerimentos">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
					<tr>
						<td align="right" width="15%"><b>Filtrar Empresas:</b></td>
						<td width='85%' align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formRequerimentos.empresa);"></td>
					</tr>
					<tr>
						<td align="right"><b>Empresa:</b></td>
						<td align='left'>
							<select name="empresa">
								<option value=""></option>
								<?php
								// Busca Empresas
								$buscaEmpresas = $_ClassMysql->query("SELECT * FROM `clientes` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
								
								// Traz Empresas
								while($trazEmpresas = mysql_fetch_object($buscaEmpresas)){
									
									?>
									<option value="<?php print($trazEmpresas->id);?>" <?php print((($_REQUEST["empresa"] == $trazEmpresas->id)?"selected":""));?>><?php print($trazEmpresas->razaosocial);?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align='left'></td>
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
}

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Contador
	$cont = 0;
	
	// Lê Matrículas
	for($i = 0; $i < count($_REQUEST["matriculas"]); $i++){
		
		// Verifica turma escolhida
		if($_REQUEST["turma"][$i] != "a"){
			
			// Incrementa contador
			$i++;
			
			// Atribui turma para matrícula
			$_ClassMysql->query("UPDATE `matriculas` SET turma = '" . $_REQUEST["turma"][$i] . "' WHERE id = '" . $_REQUEST["matriculas"][$i] . "'");
			
		}
		
	}
	
	// Mensagem de sucesso
	$_ClassMensagens->setMensagem_sucesso("<b>" . $cont . "</b> matrícula(s) foi(ram) incluída(s) em uma turma.<br>[ <a href='?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=requerimentos&empresa=" . $_REQUEST["empresa"] . "'>Atualizar</a> ]<br>");
	
	?>
	<tr>
		<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}

// Verifica se foi informada alguma empresa
if($_REQUEST["empresa"] > 0){
	
	// Dados da Empresa
	$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "razaosocial", "id = '" . $_REQUEST["empresa"] . "'");
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
				<tr>
					<td align="right" width="15%"><b>Empresa:</b></td>
					<td width='85%' align='left'><?php print($dadosEmpresa->razaosocial);?></td>
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
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td align='left'>
						<form action="?sessao=matriculas&subsessao=<?php print($_REQUEST["subsessao"]);?>&ref=requerimentos&empresa=<?php print($_REQUEST["empresa"]);?>" method="POST" name="formRequerimentos">
							<input type="hidden" name="act" value="salvar">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%">#</th>
										<th width="40%">Aluno</th>
										<th width="20%">CPF</th>
										<th width="20%">Curso</th>
										<th width="20%">Turma</th>
									</tr>
								</thead>
								<tbody>
									<?php	
									/* Construindo sql */
									$sql = "SELECT * FROM `matriculas`";
									$sql .= " WHERE ";
									$sql .= " unidade = '" . $_dadosUnidade->id . "' AND empresa = '" . $_REQUEST["empresa"] . "' AND turma = '' AND concluido = 'N' AND deletado = 'N'";
									/* Fim da construção */
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
																				
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=requerimentos&empresa=" . $_REQUEST["empresa"]);
									$_ClassPaginacao->setRegistrosPorPagina("10");
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
											$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $trazResultados->turma . "'");
											
											// Dados do Curso
											$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazResultados->curso . "'");
											
											// Dados do Aluno
											$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazResultados->aluno . "'");
											?>
											<tr class=row0>
												<td align='left'><input type="hidden" name="matriculas[]" value="<?php print($trazResultados->id); ?>"><?php print($trazResultados->id); ?></td>
												<td align='left'><?php print($dadosAluno->nome);?></td>
												<td align="center"><?php print($_ClassUtilitarios->formataCPF($dadosAluno->cpf));?></td>
												<td align="center"><?php print($dadosCurso->sigla);?></td>
												<td align="center">
													<select name="turma[]">
														<option value="a">Aguardando...</option>
														<?php
														// Busca Turmas Ativas
														$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND
																														 curso = '" . $trazResultados->curso . "' AND
																														 concluido = 'N' AND
																														 deletado = 'N'");
														
														// Traz Turmas
														while($trazTurmas = mysql_fetch_object($buscaTurmas)){
															
															// Dados do Curso
															$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazTurmas->curso . "'");
															?>
															<option value="<?php print($trazTurmas->id);?>"><?php print($dadosCurso->sigla);?><?php print($trazTurmas->numero);?></option>
															<?php
														}
														?>
													</select>
												</td>
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