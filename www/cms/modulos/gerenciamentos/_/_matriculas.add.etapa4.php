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
		
		// Verifica se tem vaga na turma
		if($dadosTurma->vagasocupadas < $dadosTurma->vagas){
			
			// Dados do Aluno Da matrícula
			$dadosAlunoMat = $_ClassRn->getDadosTable("alunos", "cpf", "id = '" . $_SESSION["matricula"]["idAluno"] . "'");
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
					print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=novo&etapa=4&curso=" . $_REQUEST["curso"], 1, array("Este aluno já está nesta turma.")));
				
				}
				
			}
			
			*/
			
			// Verifica permissão
			if($permissao){
			
				// Sucesso
				$sucesso = true;
				
				// Salva na sessão a turma escolhida
				$_SESSION["matricula"]["idTurma"] = $_REQUEST["registros"];
				
				// Redireciona
				print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=novo&etapa=5"));
					
			}
						
		}else{
			
			// Redieciona
			print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=novo&etapa=4", 1, array("Turma selecionada não tem vagas.")));
			
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
			<form action="?sessao=matriculas&ref=novo&etapa=4&submenu=buscar" method="POST" name="formMatricula_Busca">
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
					$_ClassConsulta->setQuery("SELECT * FROM `turmas` WHERE " . (($_SESSION["matricula"]["idTurma"] > 0)?"id = '" . $_SESSION["matricula"]["idTurma"] . "' AND ":"unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $_REQUEST["curso"] . "' AND vagasocupadas < vagas AND") . " concluido = 'N' AND deletado = 'N' ORDER BY id ASC");
					
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
	print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=novo&etapa=1", 1, array("É preciso selecionar um(a) aluno(a).")));
	
}
?>