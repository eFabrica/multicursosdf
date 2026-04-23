<?php require_once("php7_mysql_shim.php");
// Verifica se foi selecionado algum aluno
if($dadosMatricula->aluno > 0){
			
	// Verifica se foi selecionado uma turma
	if($dadosMatricula->turma > 0){
		
		// Dados do Aluno
		$dadosAluno = $_ClassRn->getDadosTable("alunos", "numerorg, academiaform", "id = '" . $dadosMatricula->aluno . "'");
		
		// Dados da Turma
		$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "' AND concluido = 'N' AND deletado = 'N'");
		
		// Dados do Curso
		$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
		
		// Verifica se tem vaga na turma
		if($dadosTurma->vagasocupadas < $dadosTurma->vagas || $dadosMatricula->turma == $dadosTurma->id){
			?>
			<tr>
				<td style='height:5px';>&nbsp;</td>
			</tr>
			<tr>
				<td align='left'>
					<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
					<?php
					
					// Classe de Data
					require_once($pathInc . "lib/Data.class.php");
					
					// Classe de Dinheiro
					require_once($pathInc . "lib/Dinheiro.class.php");
					
					// Importa Consulta
					require_once("lib/Consulta.class.php");
					
					// Tira Ações
					$_ClassConsulta->setPacoes(false);
					
					// Tira Filtro
					$_ClassConsulta->setFiltro(false);
					
					// Tira Link do Campo
					$_ClassConsulta->setPcampoLinkEdit(false);
					
					// Muda marcador
					$_ClassConsulta->setMarcador("radio");
					
					// Tira Ordenação dos Tópicos
					$_ClassConsulta->setTordenacao(false);
					
					// Seta Campos do Topico
					$_ClassConsulta->setCamposTopico(array("Sigla/Turma", "Turno", "Horário I", "Horario F", "Vagas", "Vagas&nbsp;Restantes", "Data&nbsp;Início", "Data&nbsp;Término"));
					
					// Tira Ordenação dos Tópicos
					$_ClassConsulta->setTordenacao(false);
					
					// Seta o Tamanho dos Campos
					$_ClassConsulta->setCamposTopicoTamanho(array("20%", "10%", "15%", "15%", "10%", "10%", "10%", "10%"));
					
					// Seta Dados dos Campos
					$_ClassConsulta->setCamposDados(array("siglaturma","turno", "horarioi", "horariof", "vagas", "vagasocupadas", "datainicio", "datatermino"));
					
					// Seta Posição dos Dados dos Campos
					$_ClassConsulta->setPosicaoCamposDados(array("center", "center", "center", "center", "center", "center", "center", "center"));
					
					# Constrói Modificações no Dados
						
						// Modificações
						$modificacoes["modificacoes"] = array(
															  "numero" 			=> array("tipo" => "10"),
															  							 
															  "siglaturma"		=> array("tipo" => "11",
																					     "campos1" => "sigla",
																					     "tabela1" => "cursos",
																					     "campoP1" => "curso",
																					     "condicao1" => "",
																					     "exibirCampo1" => "sigla",
																					     "campos2" => "numero",
																					     "tabela2" => "turmas",
																					     "campoP2" => "id",
																					     "condicao2" => "",
																					     "exibirCampo2" => "numero"),
																			   
															  "turno"   		=> array("tipo" => "1",
																					     "campos" => "turno",
																					     "tabela" => "turnos",
																					     "condicao" => "",
																					     "exibirCampo" => "turno"),
																					     
															  "horarioi"   		=> array("tipo" => "9",
																					     "campos" => "horarioi",
																					     "tabela" => "turnos",
																					     "campoP" => "turno",
																					     "condicao" => "",
																					     "exibirCampo" => "horarioi"),
																					     
															  "horariof"   		=> array("tipo" => "9",
																					     "campos" => "horariof",
																					     "tabela" => "turnos",
																					     "campoP" => "turno",
																					     "condicao" => "",
																					     "exibirCampo" => "horariof"),
																					     
															  "vagasocupadas" 	=> array("tipo" => "6",
																					     "campos" => "(vagas-vagasocupadas)",
																					     "tabela" => "turmas",
																					     "condicao" => "",
																					     "exibirCampo" => "(vagas-vagasocupadas)"),
																			   
															  "datainicio" 		=> array("tipo" => "4",
															  							 "tipot" => "2"),
															  						
															  "datatermino" 	=> array("tipo" => "4",
															  							 "tipot" => "2"));
					
					// Seta Modificações no Dados
					$_ClassConsulta->setModificarDados($modificacoes);
					
					// Seta Query
					$_ClassConsulta->setQuery("SELECT * FROM `turmas` WHERE id = '" . $dadosMatricula->turma . "' AND concluido = 'N' AND deletado = 'N' ORDER BY id ASC");
					
					// Tira a Paginação
					$_ClassConsulta->setPpaginacao(false);
					
					// Seta Total Pagina
					$_ClassConsulta->setTotalPagina(1);
				
					// GeraConsulta
					$_ClassConsulta->geraConsulta();	
					
					// Exibe a Pesquisa
					print($_ClassConsulta->getHtml());
					?>
					</table>
				</td>
			</tr>
			<?php
			
			// Verifica Ação
			if($_REQUEST["act"] == "salvar"){
				
				// Seta largura das mensagens
				$_ClassMensagens->setLargura(100);
				
				// Verifica campos
				if($dadosMatricula->online != "S") $_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["numero"], "É necessário informar o número da matrícula."));
				
				// Verifica se tem erro
				if($_ClassMensagens->getMensagem_erro() == ""){
					
					// Verifica se só contém número
					if(!ctype_digit($_REQUEST["numero"]) && $dadosMatricula->online != "S"){
						
						// Seta erro
						$_ClassMensagens->setMensagem_erro("Número da matrícula inválido. Só pode conter números.<br>");
						
					}
					
				}

                // Verifica se tem erro
                if($_ClassMensagens->getMensagem_erro() == ""){

                    // Dados da Faixa de Matrícula
                    $dadosFaixa = $_ClassRn->getDadosTable("faixamatricula", "inicio, termino", "unidade = '" . $_dadosUnidade->id . "'");

                    // Verifica se o número da matrícula está dentro da faixa permitida
                    if (!($_REQUEST["numero"] >= $dadosFaixa->inicio && $_REQUEST["numero"] <= $dadosFaixa->termino)) {

                        // Seta erro
                        $_ClassMensagens->setMensagem_erro("Número de matrícula inválido.<br>");

                    }

                }
				
				// Verifica se tem erro
				if($_ClassMensagens->getMensagem_erro() == ""){
				
					// Verifica forma de pagamento
					if(count($_REQUEST["formapagamento"]) == 0){
						
						// Seta Erro
						$_ClassMensagens->setMensagem_erro("É preciso selecionar pelo menos uma forma de pagamento.<br>");
						
					}else{
						
						// Lê Formas de Pagamento
						for($i =0; $i < count($_REQUEST["formapagamento"]); $i++){
							
							// Verifica Forma de Pagamento
							switch($_REQUEST["formapagamento"][$i]){
								
								// Caso for Adicional
								case "adicional":
									
									// Verifica Campo
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["vl_adicional"], "É necessário informar o valor do Adicional."));
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Verifica se o valor só contém número
										if(!ctype_digit(preg_replace("/[,.]/", "", $_REQUEST["vl_adicional"]))){
											
											// Seta Erro
											$_ClassMensagens->setMensagem_erro("O valor do Adicional está inválido.<br>");
											
										}
										
									}
									
								break;
								
								// Caso for Desconto
								case "desconto":
									
									// Verifica Campo
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["vl_desconto"], "É necessário informar o valor do Desconto."));
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Verifica se o valor só contém número
										if(!ctype_digit(preg_replace("/[,.]/", "", $_REQUEST["vl_desconto"]))){
											
											// Seta Erro
											$_ClassMensagens->setMensagem_erro("O valor do Desconto está inválido.<br>");
											
										}
										
									}
									
								break;
								
								// Caso for Dinheiro
								case "dinheiro":
									
									// Verifica Campo
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["vl_dinheiro"], "É necessário informar o valor pago em Dinheiro."));
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Verifica se o valor só contém número
										if(!ctype_digit(preg_replace("/[,.]/", "", $_REQUEST["vl_dinheiro"]))){
											
											// Seta Erro
											$_ClassMensagens->setMensagem_erro("O valor do Dinheiro inválido.<br>");
											
										}
										
									}
									
								break;
								
								// Caso for Cartão de Crédito
								case "cc":
									
									// Verifica Campo
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["vl_cc"], "É necessário informar o valor pago no Cartão de Crédito."));
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Verifica se o valor só contém número
										if(!ctype_digit(preg_replace("/[,.]/", "", $_REQUEST["vl_cc"]))){
											
											// Seta Erro
											$_ClassMensagens->setMensagem_erro("O valor do Cartão de Crédito inválido.<br>");
											
										}
										
									}
									
								break;
								
								// Caso for Cartão de Débito
								case "cd":
									
									// Verifica Campo
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["vl_cd"], "É necessário informar o valor pago no Cartão de Débito."));
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Verifica se o valor só contém número
										if(!ctype_digit(preg_replace("/[,.]/", "", $_REQUEST["vl_cd"]))){
											
											// Seta Erro
											$_ClassMensagens->setMensagem_erro("O valor do Cartão de Débito inválido.<br>");
											
										}
										
									}
									
								break;
								
								// Caso for Boleto Bancário
								case "bb":
									
									// Verifica Campo
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["vl_bb"], "É necessário informar o valor pago no Boleto Bancário."));
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["parcelas_bb"], "É necessário informar o número de parcelas do Boleto Bancário."));
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Verifica se o valor só contém número
										if(!ctype_digit(preg_replace("/[,.]/", "", $_REQUEST["vl_bb"]))){
											
											// Seta Erro
											$_ClassMensagens->setMensagem_erro("O valor do Boleto Bancário inválido.<br>");
											
										}
										
									}
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Verifica se foi validado
										if($_REQUEST["valor_bb1"] == ""){
											
											// Seta Erro
											$_ClassMensagens->setMensagem_erro("É preciso efetuar a validação do pagamento.<br>");
											
										}
										
									}
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Lê Parcelas
										for($p_v = 1; $p_v <= $_REQUEST["parcelas_bb"]; $p_v++){
											
											// Verifica se o valor só contém número
											if(!ctype_digit(preg_replace("/[,.]/", "", $_REQUEST["valor_bb" . $p_v]))){
												
												// Seta Erro
												$_ClassMensagens->setMensagem_erro("O valor da parcela <b>" . $p_v . "</b> do Boleto Bancário está inválido.<br>");
												
											}
											
											// Verifica se a data é válida
											if(!$_ClassData->validaData($_REQUEST["data_bb" . $p_v])){
												
												// Seta Erro
												$_ClassMensagens->setMensagem_erro("A data da parcela <b>" . $p_v . "</b> do Boleto Bancário está inválida.<br>");
												
											}
											
										}
										
									}
									
								break;
								
								// Caso for Boleto Bancário
								case "ch":
									
									// Verifica Campo
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["vl_ch"], "É necessário informar o Valor pago no Cheque-Pré."));
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["parcelas_ch"], "É necessário informar o número de Parcelas do Cheque-Pré."));
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["bco"], "É necessário informar o Banco do Cheque-Pré."));
									$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["nch"], "É necessário informar o Número do Cheque-Pré."));
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Verifica se o valor só contém número
										if(!ctype_digit(preg_replace("/[,.]/", "", $_REQUEST["vl_ch"]))){
											
											// Seta Erro
											$_ClassMensagens->setMensagem_erro("O valor do Cheque-Pré inválido.<br>");
											
										}
										
									}
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Verifica se foi validado
										if($_REQUEST["valor_ch1"] == ""){
											
											// Seta Erro
											$_ClassMensagens->setMensagem_erro("É preciso efetuar a validação do pagamento.<br>");
											
										}
										
									}
									
									// Verifica se tem erro
									if($_ClassMensagens->getMensagem_erro() == ""){
										
										// Lê Parcelas
										for($p_v = 1; $p_v <= $_REQUEST["parcelas_ch"]; $p_v++){
											
											// Verifica se o valor só contém número
											if(!ctype_digit(preg_replace("/[,.]/", "", $_REQUEST["valor_ch" . $p_v]))){
												
												// Seta Erro
												$_ClassMensagens->setMensagem_erro("O valor da parcela <b>" . $p_v . "</b> do Cheque-Pré está inválido.<br>");
												
											}
											
											// Verifica se a data é válida
											if(!$_ClassData->validaData($_REQUEST["data_ch" . $p_v])){
												
												// Seta Erro
												$_ClassMensagens->setMensagem_erro("A data da parcela <b>" . $p_v . "</b> do Cheque-Pré está inválida.<br>");
												
											}
											
											// Verifica se o número do cheque só contém número
											if(!ctype_digit($_REQUEST["nch_ch" . $p_v])){
												
												// Seta Erro
												$_ClassMensagens->setMensagem_erro("O Número do Cheque da parcela <b>" . $p_v . "</b> do Cheque-Pré está inválido.<br>");
												
											}
											
										}
										
									}
									
								break;
								
							}
							
							// Verifica se tem erro
							if($_ClassMensagens->getMensagem_erro() == ""){
								
								// Valor Pago
								$valorPago = $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_dinheiro"])+
											 $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_cc"])+
											 $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_cd"])+
											 $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_bb"])+
											 $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_ch"]);
								
								// Verifica se o valor pago é igual ao valor do curso
								if($valorPago != (($dadosCurso->valor+$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_adicional"]))-$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_desconto"]))){
									
									// Seta Erro
									$_ClassMensagens->setMensagem_erro("O Valor pago é " . (($valorPago < (($dadosCurso->valor+$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_adicional"]))-$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_desconto"])))?"menor que o valor do curso" . (($_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_adicional"]) != "")?" e adicionais":"") . ".":"maior que o valor do curso" . (($_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_adicional"]) != "")?" e adicionais":"") . ".") ." <br>");
									
								}
								
							}
							
							// Verifica se tem erro
							if($_ClassMensagens->getMensagem_erro() == ""){
								
								// Busca Número da Matrícula
								$buscaNumeroMatricula = $_ClassMysql->query("SELECT id FROM `matriculas` WHERE id != '" . $dadosMatricula->id . "' AND unidade = '" . $_dadosUnidade->id . "' AND numero = '" . $_REQUEST["numero"] . "' AND deletado = 'N'");
								
								// Verifica o total achado 
								if(mysql_num_rows($buscaNumeroMatricula) > 0){
									
									// Redieciona
									print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=edit&etapa=3", 1, array("O Número desta matrícula já está sendo usado. Por Favor, escolha outro.")));
									
									// Seta Erro
									$_ClassMensagens->setMensagem_erro("O Número desta matrícula já está sendo usado. Por Favor, escolha outro.<br>");
									
								}
								
							}
							
							// Verifica se tem erro
							if($_ClassMensagens->getMensagem_erro() == ""){
								
								// Edita a Matrícula
								$editaMatricula = $_ClassMysql->query("UPDATE `matriculas` SET numero = '" . $_REQUEST["numero"] . "', " 
																								 . ((is_array($_REQUEST["formapagamento"]) && array_search("adicional", $_REQUEST["formapagamento"]) !== false)?"pg_adicional = 'S', valor_adicional = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_adicional"]) . "', ":"pg_adicional = 'N', ")
																								 . ((is_array($_REQUEST["formapagamento"]) && array_search("desconto", $_REQUEST["formapagamento"]) !== false)?"pg_desconto = 'S', valor_desconto = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_desconto"]) . "', ":"pg_desconto = 'N', ")
																								 . ((is_array($_REQUEST["formapagamento"]) && array_search("dinheiro", $_REQUEST["formapagamento"]) !== false)?"pg_dinheiro = 'S', valor_dinheiro = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_dinheiro"]) . "', ":"pg_dinheiro = 'N', valor_dinheiro = '', ")
																							     . ((is_array($_REQUEST["formapagamento"]) && array_search("ch", $_REQUEST["formapagamento"]) !== false)?"pg_cheque = 'S', cheque_parcelas = '" . $_REQUEST["parcelas_ch"] . "', valor_cheque = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_ch"]) . "', ":"pg_cheque = 'N',  valor_cheque = '', cheque_parcelas = '', ")
																							     . ((is_array($_REQUEST["formapagamento"]) && array_search("cc", $_REQUEST["formapagamento"]) !== false)?"pg_cartaocredito = 'S', valor_cartaocredito = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_cc"]) . "', ":"pg_cartaocredito = 'N',  valor_cartaocredito = '', ")
																							     . ((is_array($_REQUEST["formapagamento"]) && array_search("cd", $_REQUEST["formapagamento"]) !== false)?"pg_cartaodebito = 'S', valor_cartaodebito = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_cd"]) . "', ":"pg_cartaodebito = 'N',  valor_cartaodebito = '', ")
																							     . ((is_array($_REQUEST["formapagamento"]) && array_search("bb", $_REQUEST["formapagamento"]) !== false)?"pg_boleto = 'S', boleto_parcelas = '" . $_REQUEST["parcelas_bb"] . "', valor_boleto = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_bb"]) . "', ":"pg_boleto = 'N',  valor_boleto = '', boleto_parcelas = '', ")
																							     . "ultimoeditou = '" . $_dadosLogado->id . "',
																							     datahorae = NOW() WHERE id = '" . $dadosMatricula->id . "'");
								
								// Verifica se Editou
								if($editaMatricula){
									
									# Parcelas
									
										// Verifica se teve pagamento com boleto
										if(is_array($_REQUEST["formapagamento"]) && array_search("bb", $_REQUEST["formapagamento"]) !== false){
											
											// Verifica número de parcelas
											if($dadosMatricula->boleto_parcelas != $_REQUEST["parcelas_bb"]){
												
												// Deleta Parcelas
												$deletaParcelas = $_ClassMysql->query("UPDATE `parcelas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id ."', datahorad = NOW() WHERE matricula = '" . $dadosMatricula->id . "' AND tipo = 'B'");
												
												// Lê Parcelas
												for($p = 1; $p <= $_REQUEST["parcelas_bb"]; $p++){
													
													// Cadastra Parcelas
													$cadastraParcelasBB = $_ClassMysql->query("INSERT INTO `parcelas` SET matricula = '" . $dadosMatricula->id . "',
																														  numero = '" . $p . "',
																														  tipo = 'B',
																														  valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor_bb" . $p]) . "',
																														  data = '" . $_ClassData->transformaData($_REQUEST["data_bb" . $p]) . "',
																														  paga = 'S',
																														  quemcriou = '" . $_dadosLogado->id . "',
																					   							  	      datahorac = now()");
													
												}
												
											}else{
												
												// Lê Parcelas
												for($p = 1; $p <= $_REQUEST["parcelas_bb"]; $p++){
													
													// Busca Parcela
													$buscaParcela = $_ClassMysql->query("SELECT * FROM `parcelas` WHERE matricula = '" . $dadosMatricula->id . "' AND
																														numero = '" . $p . "' AND
																													    tipo = 'B' AND
																													    valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor_bb" . $p]) . "' AND
																													    data = '" . $_ClassData->transformaData($_REQUEST["data_bb" . $p]) . "'");
													// Verifica o total achado
													if(mysql_num_rows($buscaParcela) == 0){
														
														// Busca Parcela
														$buscaParcela = $_ClassMysql->query("SELECT * FROM `parcelas` WHERE matricula = '" . $dadosMatricula->id . "' AND
																															numero = '" . $p . "' AND tipo = 'B'");
														
														// Verifica o total achado
														if(mysql_num_rows($buscaParcela) > 0){
														
															// Deleta Parcela pesquisa caso exista
															$deletaParcelas = $_ClassMysql->query("UPDATE `parcelas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id ."', datahorad = NOW() WHERE matricula = '" . $dadosMatricula->id . "' AND numero = '" . $p . "' AND tipo = 'B'");
																
														}
														
														// Cadastra Parcelas
														$cadastraParcelasBB = $_ClassMysql->query("INSERT INTO `parcelas` SET matricula = '" . $dadosMatricula->id . "',
																															  numero = '" . $p . "',
																															  tipo = 'B',
																															  valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor_bb" . $p]) . "',
																															  data = '" . $_ClassData->transformaData($_REQUEST["data_bb" . $p]) . "',
																															  paga = 'S',
																															  quemcriou = '" . $_dadosLogado->id . "',
																						   							  	      datahorac = now()");
														
													}
													
												}
												
											}
											
										}
										
										// Verifica se teve pagamento com cheque
										if(is_array($_REQUEST["formapagamento"]) && array_search("ch", $_REQUEST["formapagamento"]) !== false){
											
											// Verifica número de parcelas
											if($dadosMatricula->cheque_parcelas != $_REQUEST["parcelas_ch"]){
												
												// Deleta Parcelas
												$deletaParcelas = $_ClassMysql->query("UPDATE `parcelas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id ."', datahorad = NOW() WHERE matricula = '" . $dadosMatricula->id . "' AND tipo = 'C'");
												
												// Lê Parcelas
												for($p = 1; $p <= $_REQUEST["parcelas_ch"]; $p++){
													
													// Cadastra Parcelas
													$cadastraParcelasCH = $_ClassMysql->query("INSERT INTO `parcelas` SET matricula = '" . $dadosMatricula->id . "',
																														  numero = '" . $p . "',
																														  tipo = 'C',
																														  valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor_ch" . $p]) . "',
																														  data = '" . $_ClassData->transformaData($_REQUEST["data_ch" . $p]) . "',
																														  bco = '" . $_REQUEST["bco_ch" . $p] . "',
																														  numeroch = '" . $_REQUEST["nch_ch" . $p] . "',
																														  paga = 'S',
																														  quemcriou = '" . $_dadosLogado->id . "',
																					   							  	      datahorac = now()");
													
												}
												
											}else{
												
												// Lê Parcelas
												for($p = 1; $p <= $_REQUEST["parcelas_ch"]; $p++){
													
													// Busca Parcela
													$buscaParcela = $_ClassMysql->query("SELECT * FROM `parcelas` WHERE matricula = '" . $dadosMatricula->id . "' AND
																														numero = '" . $p . "' AND
																													    tipo = 'C' AND
																													    valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor_ch" . $p]) . "' AND
																													    data = '" . $_ClassData->transformaData($_REQUEST["bco_ch" . $p]) . "' AND
																													    bco = '" . $_REQUEST["bco_ch" . $p] . "' AND
																													    numeroch = '" . $_REQUEST["nch_ch" . $p] . "'");
													// Verifica o total achado
													if(mysql_num_rows($buscaParcela) == 0){
														
														// Busca Parcela
														$buscaParcela = $_ClassMysql->query("SELECT * FROM `parcelas` WHERE matricula = '" . $dadosMatricula->id . "' AND
																															numero = '" . $p . "' AND tipo = 'C'");
														
														// Verifica o total achado
														if(mysql_num_rows($buscaParcela) > 0){
														
															// Deleta Parcela pesquisa caso exista
															$deletaParcelas = $_ClassMysql->query("UPDATE `parcelas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id ."', datahorad = NOW() WHERE matricula = '" . $dadosMatricula->id . "' AND numero = '" . $p . "' AND tipo = 'C'");
																
														}
													
														// Cadastra Parcelas
														$cadastraParcelasCH = $_ClassMysql->query("INSERT INTO `parcelas` SET matricula = '" . $dadosMatricula->id . "',
																															  numero = '" . $p . "',
																															  tipo = 'C',
																															  valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor_ch" . $p]) . "',
																															  data = '" . $_ClassData->transformaData($_REQUEST["data_ch" . $p]) . "',
																															  bco = '" . $_REQUEST["bco_ch" . $p] . "',
																															  numeroch = '" . $_REQUEST["nch_ch" . $p] . "',
																															  paga = 'S',
																															  quemcriou = '" . $_dadosLogado->id . "',
																						   							  	      datahorac = now()");
													}
													
												}
												
											}
											
										}
										
									# Sucesso
										
										// Redireciona
										print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=edit&etapa=4"));
									
								}
								
							}
							
						}
						
					}
					
				}
				?>
				<tr>
					<td style='height:5px';>&nbsp;</td>
				</tr>
				<tr>
					<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
				</tr>
				<?php
				
			}
			?>
			<tr>
				<td style='height:5px';>&nbsp;</td>
			</tr>
			<tr>
				<td align='left'><div id="border-top"><div><div></div></div></div></td>
			</tr>
			<tr>
				<td class="table_main">
					<a name="form"></a>
					<form action="#form" method="POST" name="formMatricula">
						<input type="hidden" name="act" value="salvar">
						<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
							<tr>
								<td colspan="10" align="right">
									Criado por:
									<?php
									// Dados do Criador
									$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosMatricula->quemcriou . "'");
									
									// Mostra
									print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosMatricula->datahorac, 3) . "</b>");
									
									// Verifica se alguem edtou
									if($dadosMatricula->ultimoeditou > 0){
										
										?>
										<br>Última edição feita por:
										<?php
										// Dados do Alterador
										$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosMatricula->ultimoeditou . "'");
										
										// Mostra
										print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosMatricula->datahorae, 3) . "</b>");
										
									}
									?>
								</td>
							</tr>
							<tr>
								<td align="right" valign="top" width="15%"><b><font class="obrig">(*)</font> Número Ficha:</b></td>
								<td width="85%" colspan="2"><input type="text" name="numero" size="5" value="<?php print((($_REQUEST["numero"] != "")?$_REQUEST["numero"]:$dadosMatricula->numero));?>""></td>
							</tr>
							<tr>
								<td align="right" valign="top"><b>Valor Curso:</b></td>
								<td colspan="2">R$ <?php print($_ClassDinheiro->formataMoeda($dadosCurso->valor));?></td>
							</tr>
							<tr>
								<td align="right" valign="top" width="15%"><b>Adicional:</b></td>
								<td align='left'><input type="checkbox" name="formapagamento[]" value="adicional" onclick="disen(document.formMatricula.vl_adicional)" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("adicional", $_REQUEST["formapagamento"]) !== false)?"checked":(($dadosMatricula->pg_adicional == "S" && $_REQUEST["act"] == "")?"checked":"")));?>></td>
								<td width='85%' align='left'>Valor:&nbsp;<input type="text" name="vl_adicional" onKeydown="Formata(this,20,event,2)" size="20" value="<?php print((($_REQUEST["vl_adicional"] != "")?$_REQUEST["vl_adicional"]:$_ClassDinheiro->formataMoeda($dadosMatricula->valor_adicional))); ?>" style="text-align:right;" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("adicional", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_adicional == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>></td>
							</tr>
							<tr>
								<td align="right" valign="top" width="15%"><b>Desconto:</b></td>
								<td align='left'><input type="checkbox" name="formapagamento[]" value="desconto" onclick="disen(document.formMatricula.vl_desconto)" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("desconto", $_REQUEST["formapagamento"]) !== false)?"checked":(($dadosMatricula->pg_desconto == "S" && $_REQUEST["act"] == "")?"checked":"")));?>></td>
								<td width='85%' align='left'>Valor:&nbsp;<input type="text" name="vl_desconto" onKeydown="Formata(this,20,event,2)" size="20" value="<?php print((($_REQUEST["vl_desconto"] != "")?$_REQUEST["vl_desconto"]:$_ClassDinheiro->formataMoeda($dadosMatricula->valor_desconto))); ?>" style="text-align:right;" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("desconto", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_desconto == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>></td>
							</tr>
							<tr>
								<td align="right" valign="top" width="15%"><b>Dinheiro:</b></td>
								<td align='left'><input type="checkbox" name="formapagamento[]" value="dinheiro" onclick="disen(document.formMatricula.vl_dinheiro)" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("dinheiro", $_REQUEST["formapagamento"]) !== false)?"checked":(($dadosMatricula->pg_dinheiro == "S" && $_REQUEST["act"] == "")?"checked":"")));?>></td>
								<td width='85%' align='left'>Valor:&nbsp;<input type="text" name="vl_dinheiro" onKeydown="Formata(this,20,event,2)" size="20" value="<?php print((($_REQUEST["vl_dinheiro"] != "")?$_REQUEST["vl_dinheiro"]:$_ClassDinheiro->formataMoeda($dadosMatricula->valor_dinheiro)));?>" style="text-align:right;" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("dinheiro", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_dinheiro == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>></td>
							</tr>
							<tr>
								<td align="right" valign="top"><b>Cartão Crédito:</b></td>
								<td align='left'><input type="checkbox" name="formapagamento[]" value="cc" onclick="disen(document.formMatricula.vl_cc)" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("cc", $_REQUEST["formapagamento"]) !== false)?"checked":(($dadosMatricula->pg_cartaocredito == "S" && $_REQUEST["act"] == "")?"checked":"")));?>></td>
								<td align='left'>Valor:&nbsp;<input type="text" name="vl_cc" onKeydown="Formata(this,20,event,2)" size="20" value="<?php print((($_REQUEST["vl_cc"] != "")?$_REQUEST["vl_cc"]:$_ClassDinheiro->formataMoeda($dadosMatricula->valor_cartaocredito)));?>" style="text-align:right;" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("cc", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_cartaocredito == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>></td>
							</tr>
							<tr>
								<td align="right" valign="top"><b>Cartão Débito:</b></td>
								<td align='left'><input type="checkbox" name="formapagamento[]" value="cd" onclick="disen(document.formMatricula.vl_cd)" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("cd", $_REQUEST["formapagamento"]) !== false)?"checked":(($dadosMatricula->pg_cartaodebito == "S" && $_REQUEST["act"] == "")?"checked":"")));?>></td>
								<td align='left'>Valor:&nbsp;<input type="text" name="vl_cd" onKeydown="Formata(this,20,event,2)" size="20" value="<?php print((($_REQUEST["vl_cd"] != "")?$_REQUEST["vl_cd"]:$_ClassDinheiro->formataMoeda($dadosMatricula->valor_cartaodebito)));?>" style="text-align:right;" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("cd", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_cartaodebito == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>></td>
							</tr>
							<tr>
								<td align="right" valign="top"><b>Boleto Bancário:</b></td>
								<td align='left'><input type="checkbox" name="formapagamento[]" value="bb" onclick="disen(document.formMatricula.vl_bb);
																									   disen(document.formMatricula.parcelas_bb);" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("bb", $_REQUEST["formapagamento"]) !== false)?"checked":(($dadosMatricula->pg_boleto == "S" && $_REQUEST["act"] == "")?"checked":"")));?>></td>
								<td align='left'>
									Valor:&nbsp;<input type="text" name="vl_bb" onKeydown="Formata(this,20,event,2)" size="20" value="<?php print((($_REQUEST["vl_bb"] != "")?$_REQUEST["vl_bb"]:$_ClassDinheiro->formataMoeda($dadosMatricula->valor_boleto)));?>" style="text-align:right;" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("bb", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_boleto == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>>
									Parcelas:&nbsp;
									<select name="parcelas_bb" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("bb", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_boleto == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>>
										<option value="1" <?php print((((($_REQUEST["parcelas_bb"] != "")?$_REQUEST["parcelas_bb"]:$dadosMatricula->boleto_parcelas) == "1")?"selected":""));?>>1</option>
										<option value="2" <?php print((((($_REQUEST["parcelas_bb"] != "")?$_REQUEST["parcelas_bb"]:$dadosMatricula->boleto_parcelas) == "2")?"selected":""));?>>2</option>
										<option value="3" <?php print((((($_REQUEST["parcelas_bb"] != "")?$_REQUEST["parcelas_bb"]:$dadosMatricula->boleto_parcelas) == "3")?"selected":""));?>>3</option>
										<option value="4" <?php print((((($_REQUEST["parcelas_bb"] != "")?$_REQUEST["parcelas_bb"]:$dadosMatricula->boleto_parcelas) == "4")?"selected":""));?>>4</option>
										<option value="5" <?php print((((($_REQUEST["parcelas_bb"] != "")?$_REQUEST["parcelas_bb"]:$dadosMatricula->boleto_parcelas) == "5")?"selected":""));?>>5</option>
									</select>
								</td>
							</tr>
							<?php
							// Verifica Acão
							if($_REQUEST["act"] != ""){
								
								// Verifica se é array
								if(is_array($_REQUEST["formapagamento"])){
									
									// Verifica forma de Pagamento
									if(array_search("bb", $_REQUEST["formapagamento"]) !== false){
										?>
										<tr>
											<td align="right" valign="top"></td>
											<td align='left'></td>
											<td align='left'>
												<table border="0" cellpadding="2" cellspacing="2" align="left">
													<tr bgcolor="#EEEEEE">
														<td align='left'></td>
														<td align="center"><b>Valor</b></td>
														<td align="center"><b>Data</b></td>
													</tr>
													<?php
													// Valor da Parcela
													$valorparcela = (((($_REQUEST["vl_bb"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_bb"]):$dadosMatricula->valor_boleto) > 0)?((($_REQUEST["vl_bb"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_bb"]):$dadosMatricula->valor_boleto) / (($_REQUEST["parcelas_bb"] != "")?$_REQUEST["parcelas_bb"]:$dadosMatricula->boleto_parcelas)):"");
													
													// Explode valor
													list($int, $dec) = explode(".", $valorparcela);
													
													// Decimais
													$decimais = substr($dec, 0, 2);
													
													// Valor
													$valorparcela = $int . (($decimais > 0)?"." . $decimais:"");
													
													// Mes
													$mes = (date("m")+1);
																											
													// Ano
													$ano = date("Y");
													
													// Lê Parcelas
													for($p = 1; $p <= (($_REQUEST["parcelas_bb"] != "")?$_REQUEST["parcelas_bb"]:$dadosMatricula->boleto_parcelas); $p++){
														
														// Verifica Data
														if($mes > 12){$ano++;$mes="1";}
														?>
														<tr>
															<td align="right"><b>Parcela <?php print($p);?>:</b></td>
															<td align='left'><input type="text" name="valor_bb<?php print($p);?>" onKeydown="Formata(this,20,event,2)" size="15" value="<?php print((($_REQUEST["valor_bb" . $p] != "" && $_REQUEST["act"] != "validar")?$_REQUEST["valor_bb" . $p]:$_ClassDinheiro->formataMoeda($valorparcela)));?>" style="text-align:right;"></td>
															<td align='left'><input type="text" name="data_bb<?php print($p);?>" size="12" maxlength="10" onKeyUp="maskData(this, this)" value="<?php print((($_REQUEST["data_bb" . $p] != "" && $_REQUEST["act"] != "validar")?$_REQUEST["data_bb" . $p]:date("d") . "/" . (($mes < 10 && substr($mes, 0, 1) != "0")?"0".$mes:$mes) . "/" . $ano));?>" style="text-align:center;"></td>
														</tr>
														<?php
														// Incrementa mes
														$mes++;
													}
													?>
												</table>
											</td>
										</tr>
										<?php
										
									}
									
								}
								
							}elseif($dadosMatricula->boleto_parcelas > 0){
								?>
								<tr>
									<td align="right" valign="top"></td>
									<td align='left'></td>
									<td align='left'>
										<table border="0" cellpadding="2" cellspacing="2" align="left">
											<tr bgcolor="#EEEEEE">
												<td align='left'></td>
												<td align="center"><b>Valor</b></td>
												<td align="center"><b>Data</b></td>
											</tr>
											<?php
											// Busca Parcelas
											$buscaParcelas = $_ClassMysql->query("SELECT * FROM `parcelas` WHERE matricula = '" . $dadosMatricula->id . "' AND tipo = 'B' AND deletado = 'N'");
											
											// Traz Parcelas
											while($trazParcelas = mysql_fetch_object($buscaParcelas)){
												
												?>
												<tr>
													<td align="right"><b>Parcela <?php print($trazParcelas->numero);?>:</b></td>
													<td align='left'><input type="text" name="valor_bb<?php print($trazParcelas->numero);?>" onKeydown="Formata(this,20,event,2)" size="15" value="<?php print($_ClassDinheiro->formataMoeda($trazParcelas->valor));?>" style="text-align:right;"></td>
													<td align='left'><input type="text" name="data_bb<?php print($trazParcelas->numero);?>" size="12" maxlength="10" onKeyUp="maskData(this, this)" value="<?php print($_ClassData->transformaData($trazParcelas->data, 2));?>" style="text-align:center;"></td>
												</tr>
												<?php
												
											}
											?>
										</table>
									</td>
								</tr>
								<?php
								
							}
							
							// Verifica se tem parcelas
							if($dadosMatricula->cheque_parcelas > 0){
							
								// Dados da Parcela Número 1
								$dadosParcela1_ch = $_ClassRn->getDadosTable("parcelas", "*", "matricula = '" . $dadosMatricula->id . "' AND numero = '1' AND tipo = 'C' AND deletado = 'N'");
								
							}
							?>
							<tr>
								<td align="right" valign="top"><b>Cheque-Pré:</b></td>
								<td align='left'><input type="checkbox" name="formapagamento[]" value="ch" onclick="disen(document.formMatricula.vl_ch);
																									   disen(document.formMatricula.parcelas_ch);
																									   disen(document.formMatricula.bco);
																									   disen(document.formMatricula.nch);" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("ch", $_REQUEST["formapagamento"]) !== false)?"checked":(($dadosMatricula->pg_cheque == "S" && $_REQUEST["act"] == "")?"checked":"")));?>></td>
								<td align='left'>
									Valor:&nbsp;<input type="text" name="vl_ch" onKeydown="Formata(this,20,event,2)" size="20" value="<?php print((($_REQUEST["vl_ch"] != "")?$_REQUEST["vl_ch"]:$_ClassDinheiro->formataMoeda($dadosMatricula->valor_cheque)));?>" style="text-align:right;" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("ch", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_cheque == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>>
									Parcelas:&nbsp;
									<select name="parcelas_ch" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("ch", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_cheque == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>>
										<option value="1" <?php print((((($_REQUEST["parcelas_ch"] != "")?$_REQUEST["parcelas_ch"]:$dadosMatricula->cheque_parcelas) == "1")?"selected":""));?>>1</option>
										<option value="2" <?php print((((($_REQUEST["parcelas_ch"] != "")?$_REQUEST["parcelas_ch"]:$dadosMatricula->cheque_parcelas) == "2")?"selected":""));?>>2</option>
										<option value="3" <?php print((((($_REQUEST["parcelas_ch"] != "")?$_REQUEST["parcelas_ch"]:$dadosMatricula->cheque_parcelas) == "3")?"selected":""));?>>3</option>
										<option value="4" <?php print((((($_REQUEST["parcelas_ch"] != "")?$_REQUEST["parcelas_ch"]:$dadosMatricula->cheque_parcelas) == "4")?"selected":""));?>>4</option>
										<option value="5" <?php print((((($_REQUEST["parcelas_ch"] != "")?$_REQUEST["parcelas_ch"]:$dadosMatricula->cheque_parcelas) == "5")?"selected":""));?>>5</option>
									</select>
									Bco.:&nbsp;
									<input type="text" size="15" name="bco" value="<?php print((($_REQUEST["bco"] != "")?$_REQUEST["bco"]:$dadosParcela1_ch->bco));?>" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("ch", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_cheque == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>>
									N. Ch.:&nbsp;
									<input type="text" size="15" name="nch" value="<?php print((($_REQUEST["nch"] != "")?$_REQUEST["nch"]:$dadosParcela1_ch->numeroch));?>" <?php print(((is_array($_REQUEST["formapagamento"]) && array_search("ch", $_REQUEST["formapagamento"]) !== false || $dadosMatricula->pg_cheque == "S" && $_REQUEST["act"] == "")?"":"disabled"));?>>
								</td>
							</tr>
							<?php
							// Verifica Acão
							if($_REQUEST["act"] != ""){
								
								// Verifica se é array
								if(is_array($_REQUEST["formapagamento"])){
									
									// Verifica forma de Pagamento
									if(array_search("ch", $_REQUEST["formapagamento"]) !== false){
										?>
										<tr>
											<td align="right" valign="top"></td>
											<td align='left'></td>
											<td align='left'>
												<table border="0" cellpadding="2" cellspacing="2" align="left">
													<tr bgcolor="#EEEEEE">
														<td align='left'></td>
														<td align="center"><b>Valor</b></td>
														<td align="center"><b>Data</b></td>
														<td align="center"><b>BCO</b></td>
														<td align="center"><b>N. CH.</b></td>
													</tr>
													<?php
													// Valor da Parcela
													$valorparcela = (((($_REQUEST["vl_ch"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_ch"]):$dadosMatricula->valor_cheque) > 0)?((($_REQUEST["vl_ch"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_ch"]):$dadosMatricula->valor_cheque) / (($_REQUEST["parcelas_ch"] != "")?$_REQUEST["parcelas_ch"]:$dadosMatricula->cheque_parcelas)):"");
													
													// Explode valor
													list($int, $dec) = explode(".", $valorparcela);
													
													// Decimais
													$decimais = substr($dec, 0, 2);
													
													// Valor
													$valorparcela = $int . (($decimais > 0)?"." . $decimais:"");
													
													// Mes
													$mes = (date("m")+1);
																											
													// Ano
													$ano = date("Y");
													
													// Número Cheque
													$nch = $_REQUEST["nch"];
													
													// Lê Parcelas
													for($pp = 1; $pp <= (($_REQUEST["parcelas_ch"] != "")?$_REQUEST["parcelas_ch"]:$dadosMatricula->cheque_parcelas); $pp++){
														
														// Verifica Data
														if($mes > 12){$ano++;$mes="1";}
														?>
														<tr>
															<td align="right"><b>Parcela <?php print($pp);?>:</b></td>
															<td align='left'><input type="text" name="valor_ch<?php print($pp);?>" onKeydown="Formata(this,20,event,2)" size="15" value="<?php print((($_REQUEST["valor_ch" . $pp] != "" && $_REQUEST["act"] != "validar")?$_REQUEST["valor_ch" . $pp]:$_ClassDinheiro->formataMoeda($valorparcela)));?>" style="text-align:right;"></td>
															<td align='left'><input type="text" name="data_ch<?php print($pp);?>" size="12" maxlength="10" onKeyUp="maskData(this, this)" value="<?php print((($_REQUEST["data_ch" . $pp] != "" && $_REQUEST["act"] != "validar")?$_REQUEST["data_ch" . $pp]:date("d") . "/" . (($mes < 10 && substr($mes, 0, 1) != "0")?"0".$mes:$mes) . "/" . $ano));?>" style="text-align:center;"></td>
															<td align='left'><input type="text" name="bco_ch<?php print($pp);?>" size="5" value="<?php print((($_REQUEST["bco_ch" . $pp] != "" && $_REQUEST["act"] != "validar")?$_REQUEST["bco_ch" . $pp]:$_REQUEST["bco"]));?>" style="text-align:center;"></td>
															<td align='left'><input type="text" name="nch_ch<?php print($pp);?>" size="5" value="<?php print((($_REQUEST["nch_ch" . $pp] != "" && $_REQUEST["act"] != "validar")?$_REQUEST["nch_ch" . $pp]:$nch));?>" style="text-align:center;"></td>
														</tr>
														<?php
														// Incrementa mes
														$mes++;
														
														// Incrementa número do cheque
														$nch++;
													}
													?>
												</table>
											</td>
										</tr>
										<?php
										
									}
									
								}
								
							}elseif($dadosMatricula->cheque_parcelas > 0){
								?>
								<tr>
									<td align="right" valign="top"></td>
									<td align='left'></td>
									<td align='left'>
										<table border="0" cellpadding="2" cellspacing="2" align="left">
											<tr bgcolor="#EEEEEE">
												<td align='left'></td>
												<td align="center"><b>Valor</b></td>
												<td align="center"><b>Data</b></td>
												<td align="center"><b>BCO</b></td>
												<td align="center"><b>N. CH.</b></td>
											</tr>
											<?php
											// Busca Parcelas
											$buscaParcelas = $_ClassMysql->query("SELECT * FROM `parcelas` WHERE matricula = '" . $dadosMatricula->id . "' AND tipo = 'C' AND deletado = 'N'");
											
											// Traz Parcelas
											while($trazParcelas = mysql_fetch_object($buscaParcelas)){
												?>
												<tr>
													<td align="right"><b>Parcela <?php print($trazParcelas->numero);?>:</b></td>
													<td align='left'><input type="text" name="valor_ch<?php print($trazParcelas->numero);?>" onKeydown="Formata(this,20,event,2)" size="15" value="<?php print($_ClassDinheiro->formataMoeda($trazParcelas->valor));?>" style="text-align:right;"></td>
													<td align='left'><input type="text" name="data_ch<?php print($trazParcelas->numero);?>" size="12" maxlength="10" onKeyUp="maskData(this, this)" value="<?php print($_ClassData->transformaData($trazParcelas->data, 2));?>" style="text-align:center;"></td>
													<td align='left'><input type="text" name="bco_ch<?php print($trazParcelas->numero);?>" size="5" value="<?php print($trazParcelas->bco);?>" style="text-align:center;"></td>
													<td align='left'><input type="text" name="nch_ch<?php print($trazParcelas->numero);?>" size="5" value="<?php print($trazParcelas->numeroch);?>" style="text-align:center;"></td>
												</tr>
												<?php
											}
											?>
										</table>
									</td>
								</tr>
								<?php
								
							}
							?>
							<tr>
								<td align="right"><?php print($_ClassUtilitarios->criaMenu("Validar", "#", "document.formMatricula.act.value = 'validar';document.formMatricula.submit();", "esq", "007"));?></td>
								<td colspan="2"><b>Total Pago:</b>&nbsp;R$ <?php print($_ClassDinheiro->formataMoeda((($_REQUEST["vl_dinheiro"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_dinheiro"]):$dadosMatricula->valor_dinheiro)+
																				  								 	 (($_REQUEST["vl_cc"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_cc"]):$dadosMatricula->valor_cartaocredito)+
																				  								  	 (($_REQUEST["vl_cd"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_cd"]):$dadosMatricula->valor_cartaodebito)+
																				  								  	 (($_REQUEST["vl_bb"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_bb"]):$dadosMatricula->valor_boleto)+
																				  								     (($_REQUEST["vl_ch"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_ch"]):$dadosMatricula->valor_cheque)));?></td>
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

			// Redieciona
			print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=edit&etapa=2", 1, array("Turma selecionada não tem vagas.")));
		
		}
		
	}else{

		// Redieciona
		print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=edit&etapa=2", 1, array("É preciso escolher uma turma.")));
	
	}
	
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas" . $_SESSION["consultaMatricula"]["urlPesquisa"], 1, array("É preciso selecionar uma matrícula.")));
	
}
?>