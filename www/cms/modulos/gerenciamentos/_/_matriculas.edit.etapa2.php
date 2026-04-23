<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Verifica se foi selecionado algum aluno
if($dadosMatricula->aluno > 0){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Ação
	if($_REQUEST["act"] == "salvar"){
		
		// Permissão
		$permissao = true;
		
		// Verifica turma escolhida
		if($_REQUEST["registros"] != $dadosMatricula->turma){
		
			// Dados da Turma
			$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_REQUEST["registros"] . "' AND concluido = 'N' AND deletado = 'N'");
			
			// Verifica se tem vaga na turma
			if($dadosTurma->vagasocupadas < $dadosTurma->vagas || $dadosMatricula->turma == $dadosTurma->id){
				
				// Dados do Aluno Da matrícula
				$dadosAlunoMat = $_ClassRn->getDadosTable("alunos", "cpf", "id = '" . $dadosMatricula->aluno . "'");
				/*
				// Busca Matrículas nesta Turma
				$buscaMatriculas = $_ClassMysql->query("SELECT aluno FROM `matriculas` WHERE id != '" . $dadosMatricula->id . "' AND unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $dadosTurma->id . "' AND concluido = 'N' AND deletado = 'N'");
				
				// Traz Matrículas
				while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
					
					// Dados do Aluno
					$dadosAluno = $_ClassRn->getDadosTable("alunos", "cpf", "id = '" . $trazMatriculas->aluno . "'");
					
					// Verifica com o cpf informado
					if($dadosAluno->cpf == $dadosAlunoMat->cpf && $permissao == true){
						
						// Permissão
						$permissao = false;
						
						// Redieciona
						print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=edit&etapa=2&curso=" . $_REQUEST["curso"], 1, array("Este aluno já está nesta turma.")));
					
					}
					
				}
				*/
				// Permissão
				if($permissao){
				
					// Dados da Turma Atual
					$dadosTurmaAtual = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "'");
					
					// Dados da Nova Turma
					$dadosNovaTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_REQUEST["registros"] . "'");
					
					// Sucesso
					$sucesso = true;
					
					// Edita Dados
					$editaDados = $_ClassMysql->query("UPDATE `matriculas` SET turma = '" . $_REQUEST["registros"] . "',
																			   " . (($dadosNovaTurma->curso == $dadosTurmaAtual->curso)?"":"pg_dinheiro = 'N',
																																		    pg_cheque = 'N',
																																		    pg_cartaocredito = 'N',
																																		    pg_cartaodebito = 'N',
																																		    pg_boleto = 'N',
																																		    valor_cheque = '',
																																		    valor_boleto = '',
																																		    valor_cartaocredito = '',
																																		    valor_cartaodebito = '',
																																		    valor_dinheiro = '',
																																		    cheque_parcelas = '',
																																		    boleto_parcelas = '',") . "
																			   ultimoeditou = '" . $_dadosLogado->id . "',
																			   datahorae = NOW() WHERE id = '" . $dadosMatricula->id . "'");
					
					// Deleta Parcelas
					$deletaParcelas = $_ClassMysql->query("UPDATE `parcelas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id ."', datahorad = NOW() WHERE matricula = '" . $dadosMatricula->id . "'");
					
					// Desocupa Vaga na Turma
					$desocupaVaga = $_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = (vagasocupadas-1) WHERE id= '" . $dadosMatricula->turma . "'");
					
					// Ocupa Vaga na Turma
					$ocupaVaga = $_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = (vagasocupadas+1) WHERE id= '" . $_REQUEST["registros"] . "'");
					
					// Redireciona
					print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=edit&etapa=3"));
				
				}
							
			}else{
				
				// Redieciona
				print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=edit&etapa=2", 1, array("Turma selecionada não tem vagas.")));
				
			}
			
		}else{
			
			// Redireciona
			print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=edit&etapa=3"));
			
		}
		
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
			<form action="?sessao=matriculas&ref=edit&etapa=2&submenu=buscar" method="POST" name="formMatricula_Busca">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td colspan="2" align="right">
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
					</tr>
					<tr>
						<td align='left'></td>
						<td align='left'><?php print($_ClassUtilitarios->criaMenu("Buscar", "#", "document.formMatricula_Busca.submit();", "esq", "007"));?></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
	// Verifica Id Turma
	if($_REQUEST["submenu"] == "buscar" || $dadosMatricula->turma > 0){
		?>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align='left'>
				<form action="" method="POST" name="formMatricula">
					<input type="hidden" name="act" value="salvar">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
					<?php
					// Classe de Data
					require_once($pathInc . "lib/Data.class.php");
					
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
					$_ClassConsulta->setCamposTopico(array("Sigla/Turma", "Data&nbsp;Início", "Data&nbsp;Término", "Turno", "Vagas", "Vagas&nbsp;Restantes"));
					
					// Tira Ordenação dos Tópicos
					$_ClassConsulta->setTordenacao(false);
					
					// Seta o Tamanho dos Campos
					$_ClassConsulta->setCamposTopicoTamanho(array("16%", "16%", "16%", "16%", "16%", "16%"));
					
					// Seta Dados dos Campos
					$_ClassConsulta->setCamposDados(array("siglaturma", "datainicio", "datatermino", "turno", "vagas", "vagasocupadas"));
					
					// Seta Campo Link Edição
					$_ClassConsulta->setCampoLinkEdit("siglaturma");
					
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
					$_ClassConsulta->setQuery("SELECT * FROM `turmas` WHERE " . (($_REQUEST["curso"] != "")?"unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $_REQUEST["curso"] . "' AND vagasocupadas < vagas AND":"id = '" . $dadosMatricula->turma . "' AND ") . " concluido = 'N' AND deletado = 'N' ORDER BY id ASC");
					
					// Seta Url da Paginação
					$_ClassConsulta->setUrlPaginacao("?sessao=" . $_REQUEST["sessao"] . 
													 "&ref=" . $_REQUEST["ref"] . 
											 		 "&submenu=" . $_REQUEST["submenu"] .
											 		 "&etapa=" . $_REQUEST["etapa"] .  
											 		 "&curso=" . $_REQUEST["curso"]);
					
					// Seta Total Pagina
					$_ClassConsulta->setTotalPagina(45);
				
					// GeraConsulta
					$_ClassConsulta->geraConsulta();	
					
					// Exibe a Pesquisa
					print($_ClassConsulta->getHtml());
					?>
					</table>
				</form>
			</td>
		</tr>
		<?php
	}
	
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas" . $_SESSION["consultaMatricula"]["urlPesquisa"], 1, array("É preciso selecionar uma matrícula.")));
	
}
?>