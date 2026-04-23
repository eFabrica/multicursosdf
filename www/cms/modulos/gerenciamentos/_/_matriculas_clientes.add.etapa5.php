<?php require_once("php7_mysql_shim.php");
// Verifica se foi selecionado algum aluno
if($_SESSION["matricula"]["idAluno"] > 0){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Ação
	if($_REQUEST["act"] == "salvar"){
		
		// Permissão
		$permissao = true;
		
		// Dados da Turma
		$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_REQUEST["registros"] . "' AND concluido = 'N' AND deletado = 'N'");
		
		// Dados do Curso
		$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
		
		// Verifica se tem vaga na turma
		if($dadosTurma->vagasocupadas < $dadosTurma->vagas){
			
			// Dados do Aluno Da matrícula
			$dadosAlunoMat = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $_SESSION["matricula"]["idAluno"] . "'");
			
			/*
			// Busca Matrículas nesta Turma
			$buscaMatriculas = $_ClassMysql->query("SELECT aluno FROM `matriculas` WHERE unidade = '" . $_dadosUnidade->id . "' AND turma = '" . $dadosTurma->id . "' AND concluido = 'N' AND deletado = 'N'");
			
			// Traz Matrículas
			while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
				
				// Dados do Aluno
				$dadosAluno = $_ClassRn->getDadosTable("alunos", "cpf", "id = '" . $trazMatriculas->aluno . "'");
				
				// Verifica com o cpf informado
				if($dadosAluno->cpf == $dadosAlunoMat->cpf && $permissao == true){
					
					// Permissão
					$permissao = false;
					
					// Redieciona
					print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=novo&etapa=4&curso=" . $_REQUEST["curso"], 1, array("Este aluno já está nesta turma.")));
				
				}
				
			}
			*/
			
			// Verifica permissão
			if($permissao){
				
				// Dados das Matrículas Pendentes
				$dadosMatriculas = $_ClassRn->getDadosTable("matriculas", "id", "unidade = '" . $_dadosUnidade->id . "' AND
																				 empresa = '" . $dadosAlunoMat->empresa . "' AND
																				 turma = '' AND
																				 curso = '" . $dadosTurma->curso . "' AND 
																				 deletado = 'N'");
				
				// Verifica o total achado
				if($_ClassRn->getTot() > 0){
					
					// Atribui turma para esta matrícula
					$editaMatricula = $_ClassMysql->query("UPDATE `matriculas` SET empresa = '" . $_SESSION["matricula"]["idEmpresa"] . "', 
																				   turma = '" . $_REQUEST["registros"] . "', 
																				   pg_dinheiro = 'S',
																				   valor_dinheiro = '" . $dadosCurso->valor . "',
																				   ultimoeditou = '" . $_dadosLogado->id . "',
																				   datahorae = NOW() WHERE id = '" . $dadosMatriculas->id . "'");
					
					// Verifica se Editou
					if($editaMatricula){
						
						# Falta de Documentos
						
							// Verifica Documentos
							if(count($_SESSION["matricula"]["documentos"]) > 0){
								
								// Lê Documentos
								for($d = 0; $d < count($_SESSION["matricula"]["documentos"]); $d++){
								
									// Cadastra Falta de Documentos
									$cadastraFaltaDocumentos = $_ClassMysql->query("INSERT INTO `faltadocumentos` SET matricula = '" . $dadosMatriculas->id . "',
																												      documento = '" . $_SESSION["matricula"]["documentos"][$d] . "',
																												      quemcriou = '" . $_dadosLogado->id . "',
																				   							  	      datahorac = now()");
									
								}
								
							}
							
						# Sucesso
						
							// Ocupa Vaga
							$ocupaVaga = $_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = (vagasocupadas+1) WHERE id= '" . $_REQUEST["registros"] . "'");
						
							// Cadastra na sessão o id da Turma
							$_SESSION["matricula"]["idDTurma"] = $_REQUEST["registros"];
							
							// Cadastra na sessão o id da Matrícula
							$_SESSION["matricula"]["idMatricula"] = $dadosMatriculas->id;
							
							// Redireciona
							print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=novo&etapa=6"));
						
					}
					
				}else{
					
					// Cadastra a Matrícula
					$cadastraMatricula = $_ClassMysql->query("INSERT INTO `matriculas` SET unidade = '" . $_dadosUnidade->id . "',
																						   empresa = '" . $_SESSION["matricula"]["idEmpresa"] . "',
																						   aluno = '" . $_SESSION["matricula"]["idAluno"] . "',
																						   turma = '" . $_REQUEST["registros"] . "',
																						   curso = '" . $dadosTurma->curso . "',
																						   pg_dinheiro = 'S',
																				   		   valor_dinheiro = '" . $dadosCurso->valor . "',
																						   quemcriou = '" . $_dadosLogado->id . "',
																						   datahorac = NOW();");
																						   
					// ID da Matrícula
					$idMatricula = mysql_insert_id();
					
					// Verifica se Cadastrou
					if($cadastraMatricula){
						
						# Falta de Documentos
						
							// Verifica Documentos
							if(count($_SESSION["matricula"]["documentos"]) > 0){
								
								// Lê Documentos
								for($d = 0; $d < count($_SESSION["matricula"]["documentos"]); $d++){
								
									// Cadastra Falta de Documentos
									$cadastraFaltaDocumentos = $_ClassMysql->query("INSERT INTO `faltadocumentos` SET matricula = '" . $idMatricula . "',
																												      documento = '" . $_SESSION["matricula"]["documentos"][$d] . "',
																												      quemcriou = '" . $_dadosLogado->id . "',
																				   							  	      datahorac = now()");
									
								}
								
							}
							
						# Sucesso
						
							// Ocupa Vaga
							$ocupaVaga = $_ClassMysql->query("UPDATE `turmas` SET vagasocupadas = (vagasocupadas+1) WHERE id= '" . $_REQUEST["registros"] . "'");
						
							// Cadastra na sessão o id da Turma
							$_SESSION["matricula"]["idDTurma"] = $_REQUEST["registros"];
							
							// Cadastra na sessão o id da Matrícula
							$_SESSION["matricula"]["idMatricula"] = $idMatricula;
							
							// Redireciona
							print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=novo&etapa=6"));
						
					}
					
				}
				
			}
			
		}else{
			
			// Redieciona
			print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=novo&etapa=5", 1, array("Turma selecionada não tem vagas.")));
			
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
			<form action="?sessao=matriculas&subsessao=<?php print($_REQUEST["subsessao"]);?>&ref=novo&etapa=5&submenu=buscar" method="POST" name="formMatricula_Busca">
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
	// Verifica Sub Referência
	if($_REQUEST["submenu"] == "buscar" && !$sucesso){unset($_SESSION["matricula"]["idTurma"]);}
	
	// Verifica Id Turma
	if($_REQUEST["submenu"] == "buscar" || $_SESSION["matricula"]["idTurma"] > 0){
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
					$_ClassConsulta->setPosicaoCamposDados(array("center", "center", "center", "center", "center", "center"));
					
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
					$_ClassConsulta->setQuery("SELECT * FROM `turmas` WHERE " . (($_SESSION["matricula"]["idTurma"] > 0)?"id = '" . $_SESSION["matricula"]["idTurma"] . "' AND ":"unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $_REQUEST["curso"] . "' AND vagasocupadas < vagas AND") . " concluido = 'N' AND deletado = 'N' ORDER BY id ASC");
					
					// Seta Url da Paginação
					$_ClassConsulta->setUrlPaginacao("?sessao=" . $_REQUEST["sessao"] . 
													 "&subsessao=" . $_REQUEST["subsessao"] .
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
	print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=novo&etapa=1", 1, array("É preciso selecionar um(a) aluno(a).")));
	
}
?>