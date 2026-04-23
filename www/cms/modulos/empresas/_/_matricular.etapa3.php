<?php require_once("php7_mysql_shim.php");
// Verifica turma selecionada
if($_REQUEST["idReserva"] > 0){
	
	// Dados da Reserva
	$dadosReserva = $_ClassRn->getDadosTable("clientes_reservas_matriculas", "*", "id = '" . $_REQUEST["idReserva"] . "'");
	
	// Joga na Sessão
	$_SESSION["matricular"]["idTurma"] = $dadosReserva->turma;
	$_SESSION["matricular"]["idReserva"] = $dadosReserva->id;
	
}

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["matricular"]["idTurma"] . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");

// Verifica se está deletado
if($dadosTurma->deletado == "N"){
	
	// Verifica se está concluido
	if($dadosTurma->concluido == "N"){
		
		// Dados da Reserva
		$dadosReserva = $_ClassRn->getDadosTable("clientes_reservas_matriculas", "*", "id = '" . $_SESSION["matricular"]["idReserva"] . "'");
		
		// Verifica Ação
		if($_REQUEST["act"] == "enviar"){
			
			// Seta tamanho da janela
			$_ClassMensagens->setLargura(100);
			
			// Lê quantidade de vagas
			for($y = 1; $y <= $dadosReserva->qtd; $y++){
				
				// Verifica se foi informado algum dados
				if($_REQUEST["nomes".$y] != "" || $_REQUEST["cpfs".$y] != "" || $_REQUEST["nascimentos".$y] != ""){	
				
					// Verifica Campos
					$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["nomes". $y], "<b>#VAGA " . $y . "</b> - É necessário informar o nome."));
					$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cpfs". $y], "<b>#VAGA " . $y . "</b> - É necessário informar o cpf."));
					$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["nascimentos". $y], "<b>#VAGA " . $y . "</b> - É necessário informar a data de nascimento."));
				
					// Verifica data de nascimento
					if(!$_ClassData->validaData($_REQUEST["nascimentos". $y])){$_ClassMensagens->setMensagem_erro("<b>#VAGA " . $y . "</b> - Data de Nascimento inválida.<br>");}
										
					// Busca Alunos
					$buscaAlunosTurma = $_ClassMysql->query("SELECT matriculas.id FROM `matriculas`, `alunos`,`turmas` WHERE matriculas.deletado = 'N' AND
																														     matriculas.turma = turmas.id  AND
																														     matriculas.aluno = alunos.id AND
																														     matriculas.concluido = 'N' AND
																														     alunos.cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpfs".$y]) . "' AND
																														     turmas.deletado = 'N' AND
																														     alunos.deletado = 'N'");	
					
					//exit();
					
					// Verifica o total achado
					if(mysql_num_rows($buscaAlunosTurma) > 0){
						
						// Erro
						$_ClassMensagens->setMensagem_erro("<b>#VAGA " . $y . "</b> - Este aluno está com uma matricula aberta. Entre em contato com a Academia para mais informações.<br>");
						
					}
				
				}else{++$nvagas;}
				
			}
			
			// Verifica se tem erro
			if($_ClassMensagens->getMensagem_erro() == ""){
				
				// Lê quantidade de vagas
				for($y = 1; $y <= $dadosReserva->qtd; $y++){
				
					// Verifica se foi informado algum dados
					if($_REQUEST["nomes".$y] != "" && $_REQUEST["cpfs".$y] != "" && $_REQUEST["nascimentos".$y] != ""){	
					
						// Busca Alunos
						$buscaAlunos = $_ClassMysql->query("SELECT * FROM `alunos` WHERE deletado = 'N' AND cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpfs".$y]) . "' LIMIT 0, 1");
						
						// Verifica o total achado
						if(mysql_num_rows($buscaAlunos) > 0){
							
							// Dados do Aluno
							$dadosAluno = mysql_fetch_object($buscaAlunos);
							
							// Edita os dados do aluno
							$editaDadosAluno = $_ClassMysql->query("UPDATE `alunos` SET nome = '" . $_REQUEST["nomes".$y] . "',
																						cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpfs".$y]) .  "',
																						datanascimento = '" . $_ClassData->transformaData($_REQUEST["nascimentos".$y]) . "' WHERE cpf = '" . $dadosAluno->id . "'");
							
							// ID do Aluno
							$idAluno = $dadosAluno->id;
							
						}else{
							
							// Insere Aluno
							$_ClassMysql->query("INSERT INTO `alunos` SET  nome = '" . $_REQUEST["nomes".$y] . "',
																		   cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpfs".$y]) .  "',
																		   datanascimento = '" . $_ClassData->transformaData($_REQUEST["nascimentos".$y]) . "'");
							
							// Dados do Aluno
							$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpfs".$y]) .  "'");
							
							// ID do Aluno
							$idAluno = $dadosAluno->id;
							
						}
						
						// Insere Matricula
						$_ClassMysql->query("INSERT INTO `matriculas` SET unidade = '" . $_dadosUnidade->id . "',
																		  empresa = '" . $_dadosLogado->empresa . "',
																		  aluno = '" . $idAluno . "',
																		  turma = '" . $dadosTurma->id . "',
																		  curso = '" . $dadosTurma->curso . "',
																		  pg_dinheiro = 'S',
																   		  valor_dinheiro = '" . $dadosCurso->valor . "',
																   		  reserva = '" . $dadosReserva->id . "',
																		  quemcriou = '" . $_dadosLogado->id . "',
																		  datahorac = NOW();");
						
					}
					
				}
				
			}
			
			// Verifica se tem erro
			if($_ClassMensagens->getMensagem_erro() == ""){
			
				// Edita Turma
				$_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = '" . ($dadosTurma->vagasocupadas-$nvagas) . "' WHERE id = '" . $dadosTurma->id . "'");
				
				// Deleta Reserva
				$_ClassMysql->query("UPDATE `clientes_reservas_matriculas` SET deletado = 'S' WHERE id = '" . $dadosReserva->id . "'");
				
				// Sucesso!
				print($_ClassUtilitarios->redirecionarJS("?modulo=empresa&sessao=matricular&etapa=4"));
				
			}
			
		}
		
		// Verifica Ação
		if($_REQUEST["act"] == "enviar"){
		
			?>
			<tr>
				<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
			</tr>
			<tr>
				<td style='height:5px';>&nbsp;</td>
			</tr>
			<?php
		}
		?>
		<tr>
			<td align="left"><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td align="left">
							<script>
							function atualizaTempoReserva (){
								
								// Objeto Ajax
								objAjax = new AJAX();
								
								// Obejtos
							    var vagas = document.getElementById("tempoRestante");
							    
							    //Abre a url
							    objAjax.open("GET", "<?php print ($pathInc);?>includes/aplicacoes.php?ref=atualizaTempoReserva&idReserva=<?php print($_SESSION["matricular"]["idReserva"]);?>&modo=2",true);
								
								//evita amarzenamento em cache
								objAjax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate"); 
							    objAjax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0"); 
							    objAjax.setRequestHeader("Pragma", "no-cache");
								
							    //Executada quando o navegador obtiver o código
							    objAjax.onreadystatechange=function() {
							        if (objAjax.readyState==4){
										if (objAjax.status == 200) {
											
											// Texto
											texto = url_decode(objAjax.responseText);
											
											// Verifica texto
											if(texto != "nops"){
											
												vagas.innerHTML = texto;
												
											}else{
												
												// Alerta
												alert("O tempo de reserva terminou. Por favor, realize o processo de reserva novamente.");
												
												// Redireciona
												location.href = '?modulo=empresa&sessao=matricular';
												
											}
										}
										
							        }
							        
							    }
							    
							    // Limpa Cache
							    objAjax.send(null)
								
								// Loop
								window.setTimeout("atualizaTempoReserva()", (1000*1));
								
							}
							
							function preencheDados (cpf, nomeD, nascimentoD){
								
								// Objeto Ajax
								objAjax = new AJAX();
								
								// Obejtos
							    var nome = document.getElementById(""+nomeD);
							    var nascimento = document.getElementById(""+nascimentoD);    
							    
							    //Abre a url
							    objAjax.open("GET", "<?php print ($pathInc);?>includes/aplicacoes.php?ref=preencheDados&cpf="+cpf.value+"&modo=2",true);
								
								//evita amarzenamento em cache
								objAjax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate"); 
							    objAjax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0"); 
							    objAjax.setRequestHeader("Pragma", "no-cache");
								
							    //Executada quando o navegador obtiver o código
							    objAjax.onreadystatechange=function() {
							        if (objAjax.readyState==4){
										if (objAjax.status == 200) {
											
											// Texto
											texto = url_decode(objAjax.responseText);
											
											// Separa texto
											separaTexto = texto.split("|||");
											
											// Atribui dados
											nome.value = separaTexto[0];
											nascimento.value = separaTexto[1];
											
										}
										
							        }
							        
							    }
							    
							    // Limpa Cache
							    objAjax.send(null)
								
							}
							
							function enviarDados(){
								
								// Alerta
								x = confirm("ATENÇÃO: As vagas que não tiverem nenhum dado preenchido serão perdidas!\n\rDeseja realmente enviar os dados informados?");
								
								// Verifica respostas
								if(x){
									
									// Submit o form
									document.alunos.submit();
									
								}
								
							}
							
							// Chama a Função
							window.setTimeout("atualizaTempoReserva()", (1000*1));
							</script>
							<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
								<tr>
									<td colspan="2" class="menu_topico_e">Todos os campos são obrigatórios.<div align="right" id="tempoRestante"></div></td>
								</tr>
								<tr>
									<td align="left">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="2">
										<form action="" method="POST" name="alunos">
											<input type="hidden" name="act" value="enviar">
											<table class="consulta" cellspacing="1" align="center" style="width:600px;">
												<thead>
													<tr>
														<th width="1%">#</th>										
														<th width="25%">CPF</th>
														<th width="60%">Nome</th>
														<th width="15%">Dt. Nascimento</th>
													</tr>
												</thead>
												<tbody>
													<?php
													// Gera formulário
													for($u = 1; $u <= $dadosReserva->qtd; $u++){
														?>
														<tr id="row0">
															<td align="left"><?php print($u);?></td>
															<td align="left"><input type="text" name="cpfs<?php print($u);?>" value="<?php print($_REQUEST["cpfs".$u]);?>" maxlength="14" onblur="preencheDados(this, 'nomes<?php print($u);?>', 'nascimentos<?php print($u);?>')" onKeyUp="maskCPF(this, document.alunos.nomes<?php print($u);?>)" style="width:100%;"></td>
															<td align="left"><input type="text" id="nomes<?php print($u);?>" value="<?php print($_REQUEST["nomes".$u]);?>" name="nomes<?php print($u);?>" style="width:100%;"></td>
															<td align="left"><input type="text" id="nascimentos<?php print($u);?>" value="<?php print($_REQUEST["nascimentos".$u]);?>" name="nascimentos<?php print($u);?>" onKeyUp="maskData(this, this)" style="width:100%;"></td>
														</tr>
														<?php
													}
													?>
												</tbody>
											</table>
										</form>
									</td>
								</tr>
								<tr>
									<td align="right" width="50%"><?php print($_ClassUtilitarios->criaMenu("Selecionar outra Turma", "#", "location.href='?modulo=empresa&sessao=matricular'", "dir", "001", $pathInc)); ?></td>
									<td width="50%"><?php print($_ClassUtilitarios->criaMenu("Enviar Dados!", "#", "enviarDados();", "esq", "007", $pathInc)); ?></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
		
	}else{print($_ClassUtilitarios->redirecionarJS("?modulo=empresa&sessao=matricular&etapa=1", 1, array("Esta turma está concluída. Por favor, seleciona outra.")));}
	
}else{print($_ClassUtilitarios->redirecionarJS("?modulo=empresa&sessao=matricular&etapa=1", 1, array("Esta turma foi deletada.  Por favor, seleciona outra.")));}
?>