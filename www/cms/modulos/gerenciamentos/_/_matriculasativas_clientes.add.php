<?php require_once("php7_mysql_shim.php");
// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Importa Consulta
require_once("lib/Consulta.class.php");

// Seta Largura
$_ClassMensagens->setLargura(100);

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Verifica quantidade de alunos selecionados
	if(count($_REQUEST["registros"]) <= 0){
		
		// Seta erro
		$_ClassMensagens->setMensagem_erro("É preciso selecionar ao menos um aluno.<br>");
		
	}else{
		
		// Dados do Curso
		$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $_REQUEST["curso"] . "'");
		
		// Lê registros
		for($i = 0; $i < count($_REQUEST["registros"]); $i++){
			
			// Busca Aluno
			$buscaAluno = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE unidade = '" . $_dadosUnidade->id . "' AND
																				aluno = '" . $_REQUEST["registros"][$i] . "' AND
																				turma = '' AND
																				curso = '" . $_REQUEST["curso"] . "' AND
																				deletado = 'N'");
			
			// Verifica o total achado
			if(mysql_num_rows($buscaAluno) <= 0){
			
				// Cadastra Matrículas dos Clientes
				$_ClassMysql->query("INSERT INTO `matriculas` SET unidade = '" . $_dadosUnidade->id . "',
																  empresa = '" . $_dadosLogado->empresa . "',
																  curso = '" . $_REQUEST["curso"] . "',
																  aluno = '" . $_REQUEST["registros"][$i] . "',
																  pg_dinheiro = 'S',
																  valor_dinheiro = '" . $dadosCurso->valor . "',
																  quemcriou = '" . $_dadosLogado->id . "',
																  datahorac = NOW()");
			}
			
		}
		
		// Sucesso
		$sucesso = true;
		
		// Mensagem de sucesso
		$_ClassMensagens->setMensagem_sucesso("Seu pedido de matrícula foi enviado com sucesso.<br><br>[ <a href=\"?sessao=matriculasativas_clientes\">Atualizar</a> ]");
		
	}
	?>
	<tr>
		<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}

// Verifica sucesso
if(!$sucesso){
	?>
	<tr>
		<td align='left'>
			<form action="" method="POST" name="formMatricula">
				<input type="hidden" name="act" value="salvar">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
						<td align='left'><div id="border-top"><div><div></div></div></div></td>
					</tr>
					<tr>
						<td class="table_main">
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
					// Seta Ações
					$_ClassConsulta->setPacoes(false);
					
					// Seta Texto do Filtro
					$_ClassConsulta->setFiltro(false);
					
					// Seta Campos do Topico
					$_ClassConsulta->setCamposTopico(array("Nome", "Data&nbsp;Nasc.", "R.G",  "CPF"));
					
					// Seta o Tamanho dos Campos
					$_ClassConsulta->setCamposTopicoTamanho(array("45%", "15%", "20%", "20%"));
					
					// Seta Dados dos Campos
					$_ClassConsulta->setCamposDados(array("nome", "datanascimento", "rg", "cpf"));
					
					// Seta Campo Link Edição
					$_ClassConsulta->setPcampoLinkEdit(false);
					
					// Seta Posição dos Dados dos Campos
					$_ClassConsulta->setPosicaoCamposDados(array("left", "center", "center", "center"));
					
					# Constrói Modificações no Dados
						
						// Modificações
						$modificacoes["modificacoes"] = array("datanascimento" => array("tipo" => "4",
																						"tipot" => "2"),
																						
															  "cpf" => array("tipo" => "12",
															  				 "campos" => "cpf"));
					
					// Seta Modificações no Dados
					$_ClassConsulta->setModificarDados($modificacoes);		
					
					// Seta Query
					$_ClassConsulta->setQuery("SELECT * FROM `alunos` WHERE empresa = '" . $_dadosLogado->empresa . "' AND deletado = 'N'");
					
					// Seta Url da Paginação
					$_ClassConsulta->setUrlPaginacao("?sessao=" . $_REQUEST["sessao"]);
					
					// Seta Total Pagina
					$_ClassConsulta->setTotalPagina(1000);
					
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
?>