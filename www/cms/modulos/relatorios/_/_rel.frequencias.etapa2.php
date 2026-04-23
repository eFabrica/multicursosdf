<?php
// Verifica se foi informado uma turma
if($_SESSION["frequenciasalunos"]["idTurma"] > 0){
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
				$_ClassConsulta->setQuery("SELECT * FROM `turmas` WHERE id = '" . $_SESSION["frequenciasalunos"]["idTurma"] . "'  AND deletado = 'N' OR id = '" . $_SESSION["idTurmaS"] . "'  AND deletado = 'N'");
				
				// Seta Total Pagina
				$_ClassConsulta->setTotalPagina(2);
			
				// GeraConsulta
				$_ClassConsulta->geraConsulta();	
				
				// Exibe a Pesquisa
				print($_ClassConsulta->getHtml());
				
				// Dados da Turma
				$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["frequenciasalunos"]["idTurma"] . "'");
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="<?php print($pathInc . "modulos/relatorios/_/_rel.frequencias.emitir.php");?>" method="POST" name="formFrequencia" target="_blank">
				<input type="hidden" name="materia" value="999">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<?php
					/*
					<tr>
						<td align="right" width="15%"><b>Matéria:</b></td>
						<td width='85%' align='left'>
							<select name="materia">
								<?php
								// Busca Matérias da Turma
								$buscaMatTurma = $_ClassMysql->query("SELECT * FROM `turmas_materias` WHERE turma = '" . $dadosTurma->id . "'");
								
								// Traz Matérias da Turma
								while($trazMatTurma = mysql_fetch_object($buscaMatTurma)){
									
									// Dados da Matéria
									$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $trazMatTurma->materia . "'");
									
									?>
									<option value="<?php print($dadosMateria->id);?>" <?php print((($_REQUEST["materias"] == $dadosMateria->id)?"selected":""));?>><?php print($dadosMateria->materia);?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					</tr>
					*/
					?>
					<tr>
						<td width="15%" align="right" valign="top"><b>Orientação:</b></td>
						<td width='85%' align='left'>
							<select name="orientacao">
								<option value="f">Frequências</option>
								<option value="d">Diário</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align='left'></td>
						<td align='left'><?php print($_ClassUtilitarios->criaMenu("Imprimir", "#", "document.formFrequencia.submit();", "esq", "007", $pathInc));?></td>
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
	
	// Redireciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=frequenciasalunos&etapa=1", 1, array("É preciso selecionar uma turma!")));
	
}
?>