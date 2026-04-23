<tr>
	<td align="left"><div id="border-top"><div><div></div></div></div></td>
</tr>
<tr>
	<td class="table_main">
		<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
			<tr>
				<td align="left">
					<?php require_once("php7_mysql_shim.php");
					// Verifica turma selecionada
					if($_REQUEST["turma"] > 0){
						
						// Joga na Sessão
						$_SESSION["matricular"]["idTurma"] = $_REQUEST["turma"];
						
					}
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["matricular"]["idTurma"] . "'");
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
					
					// Verifica se está deletado
					if($dadosTurma->deletado == "N"){
						
						// Verifica se está concluido
						if($dadosTurma->concluido == "N"){
							
							// Verifica se tem pelomenos uma vaga
							if(($dadosTurma->vagas-$dadosTurma->vagasocupadas) > 0){
								
								// Verifica Ação
								if($_REQUEST["act"] == "reservar"){
									
									// Verifica vagas necessárias
									if($_REQUEST["vagasnecessarias"] > 0){
									
										// Dados da Turma Reservada
										$dadosTurmaReservada = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_REQUEST["turmaReserva"] . "'");
										
										// Verifica se tem a quantidade de vagas selecionadas
										if(($dadosTurmaReservada->vagas-$dadosTurmaReservada->vagasocupadas) >= $_REQUEST["vagasnecessarias"]){
											
											// Reserva Vagas
											$reservaVagas = $_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = '" . ($dadosTurmaReservada->vagasocupadas+$_REQUEST["vagasnecessarias"]) . "' WHERE id = '" . $_REQUEST["turmaReserva"] . "'");
											
											// Verifica se reservou as vagas
											if($reservaVagas){
												
												// Insere registro de reserva
												$_ClassMysql->query("INSERT INTO `clientes_reservas_matriculas` SET cliente = '" . $_dadosLogado->empresa . "',
																													turma = '" . $_REQUEST["turmaReserva"] . "',
																													qtd = '" . $_REQUEST["vagasnecessarias"] . "',
																													dat_reserva = now()");
												
												// Redireciona
												print($_ClassUtilitarios->redirecionarJS("?modulo=empresa&sessao=matricular&etapa=3&idReserva=" . mysql_insert_id(), 1, array("Foi(ram) reservada(s) " . $_REQUEST["vagasnecessarias"] . " vagas! ATENÇÃO: ESSA RESERVA É VÁLIDA SOMENTE POR UMA HORA!")));
												
											}else{
												
												// Exibe mensagem
												print($_ClassUtilitarios->redirecionarJS("", 1, array("Desculpe. Não foi possível reservar as vagas requeridas. Por favor, tente novamente."), false));
												
											}
											
											
										}else{
											
											// Exibe mensagem
											print($_ClassUtilitarios->redirecionarJS("", 1, array("Desculpe. Nesta turma não possuímos " . $_REQUEST["vagasnecessarias"] . " vagas. Por favor, entre em contato conosco para consultar novas turmas."), false));
											
										}
										
									}else{print($_ClassUtilitarios->redirecionarJS("?modulo=empresa&sessao=matricular&etapa=2", 1, array("É necessário informar alguma quantidade.")));}
									
								}
								?>
								<script>
								function atualizaVagas(){
									
									// Objeto Ajax
									objAjax = new AJAX();
									
									// Obejtos
								    var vagas = document.getElementById("vagas");
								    
								    //Abre a url
								    objAjax.open("GET", "<?php print ($pathInc);?>includes/aplicacoes.php?ref=atualizaVagas&turma=<?php print($dadosTurma->id);?>",true);
									
									//evita amarzenamento em cache
									objAjax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate"); 
								    objAjax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0"); 
								    objAjax.setRequestHeader("Pragma", "no-cache");
									
								    //Executada quando o navegador obtiver o código
								    objAjax.onreadystatechange=function() {
								        if (objAjax.readyState==4){
											if (objAjax.status == 200) {
												
												// Texto
												vagas.innerHTML = url_decode(objAjax.responseText);
												
											}
											
								        }
								        
								    }
								    
								    // Limpa Cache
								    objAjax.send(null)
									
									// Loop
									window.setTimeout("atualizaVagas()", (1000*1));
									
								}
								
								// Chama a Função
								window.setTimeout("atualizaVagas()", (1000*1));
								</script>
								<form action="" method="POST" name="formMatricular">
									<input type="hidden" name="act" value="reservar">
									<input type="hidden" name="turmaReserva" value="<?php print($_SESSION["matricular"]["idTurma"]);?>">
									<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
										<tr>
											<td width="15%" align="right"><b>Curso:</b></td>
											<td align="left"><?php print($dadosCurso->nome);?></td>
										</tr>
										<tr>
											<td align="right"><b>Início:</b></td>
											<td align="left"><?php print($_ClassData->transformaData($dadosTurma->datainicio, 2));?></td>
										</tr>
										<tr>
											<td align="right"><b>Vagas Disponíveis:</b></td>
											<td align="left"><div id="vagas"><?php print($dadosTurma->vagas-$dadosTurma->vagasocupadas);?></div></td>
										</tr>
										<tr>
											<td align="right"><b>Vagas Necessárias:</b></td>
											<td align="left"><input type="text" size="10" name="vagasnecessarias"></td>
										</tr>
										<tr>
											<td align="right"><?php print($_ClassUtilitarios->criaMenu("Selecionar outra Turma", "#", "location.href='?modulo=empresa&sessao=matricular'", "dir", "001", $pathInc)); ?></td>
											<td align="left"><?php print($_ClassUtilitarios->criaMenu("Confirmar Vagas!", "#", "document.formMatricular.submit();", "esq", "007", $pathInc)); ?></td>
										</tr>
									</table>
								</form>
								<?php
							}else{print($_ClassUtilitarios->redirecionarJS("?modulo=empresa&sessao=matricular&etapa=1", 1, array("Esta turma não possui nenhuma vaga. Por favor, seleciona outra.")));}
							
						}else{print($_ClassUtilitarios->redirecionarJS("?modulo=empresa&sessao=matricular&etapa=1", 1, array("Esta turma está concluída. Por favor, seleciona outra.")));}
						
					}else{print($_ClassUtilitarios->redirecionarJS("?modulo=empresa&sessao=matricular&etapa=1", 1, array("Esta turma foi deletada.  Por favor, seleciona outra.")));}
					?>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
</tr>