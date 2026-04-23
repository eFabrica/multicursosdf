<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Verifica se tem id do registro
if($_REQUEST["idRegistro"] > 0){
	
	// Adiciona na sessão
	$_SESSION["idDiario"] = $_REQUEST["idRegistro"];
	$_SESSION["urlPesquisa"] = "&ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"];
	
}
?>
<form action="" method="POST" name="formFrequenciaDiario">
	<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
		<tr>
			<td align='left'><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
					<tr>
						<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00039.png&l=50&a=50"></td>
						<td align="left" width="" class="menu_topico">
							Frequência/Diário de Classe <?php print($_ClassUtilitarios->refTopico()); ?>
						</td>
						<td align="right">
							<table border="0" cellpadding="2" cellspacing="0">
								<?php
								if($_REQUEST["grade"] > 0){
									
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=frequenciadiario&mes=<?php print($_REQUEST["mes"] . "&ano=" . $_REQUEST["ano"]);?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Voltar</a></div></td>
									<?php if ($_dadosLogado->nivel == 100){?><td align="center"><div class="caixaIcone"><a href="#" onclick="if (confirm('Deseja mesmo limpar os dados de diário de classe e frequência?')) location.href = '?sessao=frequenciadiario&act=limpardados&grade=<?=$_REQUEST["grade"]?>';"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Limpar&nbsp;Dados</a></div></td><?php }?>
									<td align="center"><div class="caixaIcone"><a href="#" onClick="document.formFrequenciaDiario.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a></div></td>
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
		// Verifica se foi informado alguma grade
		if ($_REQUEST["grade"] > 0){
			
			?>
			<tr>
				<td align='left'><div id="border-top"><div><div></div></div></div></td>
			</tr>
			<tr>
				<td class="table_main">
					<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
						<?php
						// Dados da Grade Horária
						$dadosGrade = $_ClassRn->getDadosTable("gradehoraria", "*", "id = '" . $_REQUEST["grade"] . "' AND deletado = 'N'");
						
						// Verifica data da Grade
						if (strtotime(date("Y-m-d")) > strtotime($dadosGrade->data)){
						
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
							if($_REQUEST["act"] == "salvar") {
								
								// Seta largura das mensagens
								$_ClassMensagens->setLargura(100);
								
								// Verifica Campo
								$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["conteudo"], "É preciso informar o Conteúdo."));
								$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["horasaula"], "É preciso informar a Quantidade de Horas Aula."));
						
								// Verifica se tem erro
								if($_ClassMensagens->getMensagem_erro() == ""){
									
									// Verifica se tem somente número no campo de horas aulas
									if(!ctype_digit($_REQUEST["horasaula"])){
										
										// Seta erro
										$_ClassMensagens->setMensagem_erro("Horas Aula só pode conter números.<br>");
										
									}
									
								}
								
								// Verifica se tem erro
								if($_ClassMensagens->getMensagem_erro() == ""){
									
									// Busca Diários
									$buscaDiarioClasse = $_ClassMysql->query("SELECT * FROM `diarioclasse` WHERE deletado = 'N' AND gradehoraria = '" . $_REQUEST["grade"] . "' ORDER BY id DESC LIMIT 0,1");
									
									// Verifica o total achado
									if (mysql_num_rows($buscaDiarioClasse) > 0){
										
										// Traz Diario Classe
										$trazDiarioClasse = mysql_fetch_object($buscaDiarioClasse);
										
										// Edita Diário de Classe
										$editaDiarioClasse = $_ClassMysql->query("UPDATE `diarioclasse` SET conteudo = '" . $_ClassString->filtraTexto($_REQUEST["conteudo"]) . "',
																											horasaula = '" . $_REQUEST["horasaula"] . "',
																											gradehoraria = '" . $_REQUEST["grade"] . "',
																											ultimoeditou = '" . $_dadosLogado->id . "',
																					   						datahorae = now() WHERE id = '" . $trazDiarioClasse->id . "'");
										
									}else{
										
										// Edita Diário de Classe
										$insereDiarioClasse = $_ClassMysql->query("INSERT INTO `diarioclasse` SET unidade = '" . $_dadosUnidade->id . "',
																												  turma = '" . $dadosGrade->turma . "',
																											  	  data = '" . $dadosGrade->data . "',
																											  	  turno = '" . $dadosGrade->turno . "',
																											  	  materia = '" . $dadosGrade->materia . "',
																											  	  instrutor = '" . $dadosGrade->instrutor . "',
																											  	  sala = '" . $dadosGrade->sala . "',
																												  conteudo = '" . $_ClassString->filtraTexto($_REQUEST["conteudo"]) . "',
																												  horasaula = '" . $_REQUEST["horasaula"] . "',
																												  gradehoraria = '" . $_REQUEST["grade"] . "',
																												  quemcriou = '" . $_dadosLogado->id . "',
																						   						  datahorac = now()");
										
									}
									
								}
								
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
									
								}
								
								// Redieciona
								print($_ClassUtilitarios->redirecionarJS("?sessao=frequenciadiario&mes=" . $_REQUEST["mes"] . "&ano=" . $_REQUEST["ano"] . "&grade=" . $_REQUEST["grade"], 0));
								
							}elseif($_REQUEST["act"] == "limpardados") {
								
								// Deleta Diários de Classe
								$_ClassMysql->query("UPDATE `diarioclasse` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE gradehoraria = '" . $_REQUEST["grade"] . "'");
								
								// Deleta Frequências
								$_ClassMysql->query("UPDATE `frequencias` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE gradehoraria = '" . $_REQUEST["grade"] . "'");
								
								// Redieciona
								print($_ClassUtilitarios->redirecionarJS("?sessao=frequenciadiario&mes=" . $_REQUEST["mes"] . "&ano=" . $_REQUEST["ano"] . "&grade=" . $_REQUEST["grade"], 1, array("Dados Limpos com sucesso!")));
								
							}
							
							// Dados do Diário de Classe
							$dadosDiarioClasse = $_ClassRn->getDadosTable("diarioclasse", "*", "gradehoraria = '" . $_REQUEST["grade"] . "' AND deletado = 'N'");
							?>
							<tr>
								<td align='left'><div id="border-top"><div><div></div></div></div></td>
							</tr>
							<tr>
								<td class="table_main">
									<input type="hidden" name="act" value="salvar">
									<table class="consulta" cellspacing="1" align="center">
										<thead>
											<tr>
												<th width="1%">#</th>
												<th width="1%" align="center"><input type="checkbox" onclick="select_all('formFrequenciaDiario', 'registros[]')"></th>
												<th width="40%">Aluno</th>
												<th width="25%">Curso/Turma</th>
												<th width="20%">Turno</th>
												<th width="5%">Presente</th>
											</tr>
										</thead>
										<tbody>
											<?php	
											/* Construindo sql */
											$sql = "SELECT matriculas.* FROM `matriculas`,`alunos` ";
											$sql .= " WHERE alunos.id = matriculas.aluno AND matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.turma = '" . $dadosGrade->turma . "' AND matriculas.deletado = 'N' ORDER BY alunos.nome ASC";
						
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
														<td align="left"><a name="<?=$trazResultados->id?>"></a><?php print($dadosAluno->nome);?></td>
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
									<form action="" method="POST" name="formDiarioClasse">
										<input type="hidden" name="act" value="salvar">
										<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
											<tr>
												<td valign="top" align="right" width="10%"><b><font class="obrig">(*)</font>Conteúdo:</b></td>
												<td width='90%' align='left'><textarea rows="15" style="width:100%;" name="conteudo"><?php print((($_REQUEST["conteudo"] != "")?$_REQUEST["conteudo"]:nl2br($dadosDiarioClasse->conteudo))); ?></textarea></td>
											</tr>
											<tr>
												<td align="right"><b><font class="obrig">(*)</font>Horas Aula:</td>
												<td align='left'><input type="text" name="horasaula" size="5" value="<?php print((($_REQUEST["horasaula"] != "")?$_REQUEST["horasaula"]:$dadosDiarioClasse->horasaula));?>"> Somente números</td>
											</tr>
											<tr>
												<td colspan="2">
													<br>
													<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios
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
						}else{
							
							?>
							<tr>
								<td align="center"><b>Não é possível lançar Frequência/Diário no mesmo dia da execução dos mesmos.</b></td>
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
			<?php
			
		}else{
			?>
			<tr>
				<td align='left'><div id="border-top"><div><div></div></div></div></td>
			</tr>
			<tr>
				<td class="table_main">
					<?php
					// Verifica Argumentos
					$_GET["mes"] = (($_REQUEST["mes"] != "")?$_REQUEST["mes"]:date("m"));
					$_GET["ano"] = (($_REQUEST["ano"] != "")?$_REQUEST["ano"]:date("Y"));
					
					// Mes get
					$_GET["mes"] = (($_GET["mes"] < 10) ? "0".$_GET["mes"] : $_GET["mes"] );
					
					// Nome completo dos meses
					$mesCompleto =  array("1" => "Janeiro", 
										  "2" => "Fevereiro",
										  "3" => "Março",
										  "4" => "Abril",
										  "5" => "Maio",
										  "6" => "Junho",
										  "7" => "Julho",
										  "8" => "Agosto",
										  "9" => "Setembro",
										  "10" => "Outubro",
										  "11" => "Novembro",
										  "12" => "Dezembro");
					
					// Verifica datas
					if($_GET["mes"] > 12){
						
						// Verifica ano
						$ano = $_GET["ano"] + 1;
						
						// Verifica mes
						$mes = 1;
						
					}elseif($_GET["mes"] == 0){
					
						// Verifica ano
						$ano = $_GET["ano"] - 1;
						
						// Verifica mes
						$mes = 12;
						
					}else{
					
						// Verifica se foi indicado o mes e ano
						$mes = (($_GET["mes"] == "")? date("m") : $_GET["mes"] );
						$mes = (($mes < 10)? str_replace("0", "", $mes) : $mes );
						$ano = (($_GET["ano"] == "")? date("Y") : $_GET["ano"] );
						
					}
					?>
					<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
						<tr>
							<td align='left'>
								<table border="0" cellpadding="1" cellspacing="1" width="100%" align="center">
									<tr bgcolor="#5668D1">
										<td align="center">
											<a href="?<?php print("sessao=" . $_REQUEST["sessao"] . "&");?>mes=<?=$mes-1?>&ano=<?=$ano?>"><img src="<?=$pathInc?>imagens/icones/b_anterior.png" border="0"></a>
										</td>
										<td colspan="5" align="center">
											<strong><?=$mesCompleto[$mes]?></strong><br>
											<?=$ano?>
										</td>
										<td align="center">
											<a href="?<?php print("sessao=" . $_REQUEST["sessao"] . "&");?>mes=<?=$mes+1?>&ano=<?=$ano?>"><img src="<?=$pathInc?>imagens/icones/b_proximo.png" border="0"></a>
										</td>
									</tr>
									<tr bgcolor="#5668D1">
										<td align="center" width="43"><strong>Dom.</strong></td>
										<td align="center" width="43"><strong>Seg.</strong></td>
										<td align="center" width="43"><strong>Ter.</strong></td>
										<td align="center" width="43"><strong>Qua.</strong></td>
										<td align="center" width="43"><strong>Qui.</strong></td>
										<td align="center" width="43"><strong>Sex.</strong></td>
										<td align="center" width="43"><strong>Sab.</strong></td>
									</tr>
									<?
									// Interruptor
									$inter = true;
									
									// Início do mês
									$dia = 1;
									
									// Traz dias do mês
									while($dia <= cal_days_in_month(1, $mes, $ano)){
									
										// Parte da tabela
										print("<tr bgcolor=\"#808DDB\">");
										
										// Semanas
										for($i=0; $i <= 6;$i++){
											
											// Dias da semana
											if($dia <= cal_days_in_month(1, $mes, $ano)){
											
												// Verifica data
												if(date("w", mktime(0,0,0, $mes, $dia, $ano)) == $i){
												
													// Dia
													 $dia = strlen($dia) <= 1 ? 0 . $dia : $dia;
													 
													 // Mês
													 $mes = strlen($mes) <= 1 ? 0 . $mes : $mes;
													 
													 // data
													 $data = $dia . "/" . $mes . "/" . $ano;
													 ?>
													 <td valign="top" <?=($dia == date("d") && $mes == date("m") && $ano == date("Y"))?"bgcolor=\"#00CCCC\"":" bgcolor=\"" . (($inter)?"#818EDC":"#A6AFE6") . "\""?>>
													 	<center><?php print($dia . "/" . $mes . "/" . $ano);?>
													 	<br>-----</center><br>
													 	<?php
													 	// Busca Turnos
													 	$buscaTurnos = $_ClassMysql->query("SELECT turnos.id,
													 											   turnos.turno FROM `turnos`,`gradehoraria` WHERE turnos.deletado = 'N' AND
													 											   												   gradehoraria.deletado = 'N' AND
													 											   												   gradehoraria.turno = turnos.id AND
													 											   												   gradehoraria.data = '" . $ano . "-" . $mes . "-" . $dia . "' GROUP BY turnos.id ORDER BY turnos.horarioi, turnos.horariof");
													 	
													 	// Traz Turnos
													 	while ($trazTurnos = mysql_fetch_object($buscaTurnos)){
													 		
													 		print("<b>" . $trazTurnos->turno . "</b><br><ol>");
													 		
													 		// Busca Turmas
													 		$buscaTurmas = $_ClassMysql->query("SELECT gradehoraria.id,
													 												   turmas.numero,
													 												   cursos.sigla FROM `gradehoraria`,
													 												   					 `turmas`,
													 												   					 `cursos` WHERE turmas.deletado = 'N' AND
													 												   					 				cursos.deletado = 'N' AND
										 											   												    gradehoraria.deletado = 'N' AND
										 											   												    turmas.id = gradehoraria.turma AND
										 											   												    cursos.id = turmas.curso AND
										 											   												    gradehoraria.turno = '" . $trazTurnos->id . "' AND
										 											   												    gradehoraria.data = '" . $ano . "-" . $mes . "-" . $dia . "' GROUP BY gradehoraria.turma");
													 		
													 		// Traz Turmas
													 		while ($trazTurmas = mysql_fetch_object($buscaTurmas)){
													 			
													 			?>
													 			- <a href="<?php print("?sessao=" . $_REQUEST["sessao"] . "&mes=" . $mes . "&ano=" . $ano . "&grade=" . $trazTurmas->id);?>"><?php print($trazTurmas->sigla . $trazTurmas->numero);?></a><br>
													 			<?php
													 			
													 		}
													 		
													 		print ("</ol>");
													 		
													 	}
													 	?>
													 </td>
													 <?
													 // Incrementa Dia
													 $dia++;
													 
												}else{
												
													print("<td align='left'>&nbsp;</td>");	
													
												}
												
											}else{
												
												print("<td align='left'>&nbsp;</td>");	
												
											}
											
											// Interruptor
											$inter = !$inter;
											
										}
										
										print("</tr>");
										
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
			<?php
		}
		?>
	</table>
</form>