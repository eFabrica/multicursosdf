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
								<th width="45%">Aluno</th>
								<th width="25%">CPF</th>
								<th width="25%">Curso/Turma</th>
								<th width="5%">Docs.</th>
							</tr>
						</thead>
						<tbody>
							<?php require_once("php7_mysql_shim.php");
							/* Construindo sql */
							$sql = "SELECT * FROM `matriculas`";
							$sql .= " WHERE ";
							$sql .= " unidade = '" . $_dadosUnidade->id . "' AND empresa = '" . $_dadosLogado->empresa. "' AND concluido = 'N' AND deletado = 'N'";
							/* Fim da construção */
							
							// Paginação
							require_once($pathInc . "lib/Paginacao.class.php");
							
							// Configurações da paginacao
							$_ClassPaginacao->setQuery($sql);
							$_ClassPaginacao->setUrl("?sessao=faltadocumentos_clientes&curso=" . $_REQUEST["curso"]);
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
									
									// Busca Falta de Documentos
									$buscaFaltaDocumentos = $_ClassMysql->query("SELECT * FROM `faltadocumentos` WHERE matricula = '" . $trazResultados->id . "' AND deletado = 'N'");
									
									// Verifica o total achado
									if(mysql_num_rows($buscaFaltaDocumentos) > 0){
									
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
											<td align="center"><?php print($dadosCurso->sigla . $dadosTurma->numero);?></td>
											<td align="center"><a href="#" onclick="popup('faltadocumentos<?=$trazResultados->id?>', '<?php print($pathInc);?>modulos/gerenciamentos/_/_faltadocumentos_clientes.listagem.php?idMatricula=<?php print($trazResultados->id);?>', 730, 400, 'yes')"><img src="<?php print($pathInc);?>imagens/icones/sh.png" border="0"></a></td>
										</tr>
										<?php
									}
									
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