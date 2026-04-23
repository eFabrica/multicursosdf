<?php require_once("php7_mysql_shim.php");
// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Importa Consulta
require_once("lib/Consulta.class.php");

?>
<tr>
	<td align='left'>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align='left'><div id="border-top"><div><div></div></div></div></td>
			</tr>
			<tr>
				<td class="table_main">
					<form action="" method="POST" name="formMatricula">
						<input type="hidden" name="act" value="">
						<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
							<tr>
								<td align="right" width="10%"><b>Curso:</b></td>
								<td align='left'>
									<select name="curso">
										<?php
										
										// Busca Cursos
										$buscaCursos = $_ClassMysql->query("SELECT * FROM `cursos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
										
										// Traz Cursos
										while($trazCursos = mysql_fetch_object($buscaCursos)){
											
											?>
											<option value="<?php print($trazCursos->id); ?>" <?php print((($_REQUEST["curso"] == $trazCursos->id)?"selected":""));?>><?php print($trazCursos->nome); ?></option>
											<?php
											
										}
										?>
									</select>
								</td>
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
			// Verifica se foi informado algum curso
			if($_REQUEST["curso"] != ""){
				?>
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
											$sql .= " unidade = '" . $_dadosUnidade->id . "' AND empresa = '" . $_dadosLogado->empresa. "' AND curso = '" . $_REQUEST["curso"] . "' AND concluido = 'N' AND deletado = 'N'";
											/* Fim da construção */
											
											// Paginação
											require_once($pathInc . "lib/Paginacao.class.php");
																						
											// Configurações da paginacao
											$_ClassPaginacao->setQuery($sql);
											$_ClassPaginacao->setUrl("?sessao=matriculasativas_clientes&ref=novo&curso=" . $_REQUEST["curso"]);
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
														<td align='left'><?php print($trazResultados->id); ?></td>
														<td align='left'><?php print($dadosAluno->nome);?></td>
														<td align="center"><?php print($_ClassUtilitarios->formataCPF($dadosAluno->cpf));?></td>
														<td align="center"><?php print($dadosCurso->sigla);?></td>
														<td align="center"><?php print((($dadosTurma->numero <= 0)?"Aguardando...":$dadosTurma->numero));?></td>
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
					</td>
				</tr>
				<tr>
					<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
				</tr>
				<?php
			}
			?>
		</table>
	</td>
</tr>