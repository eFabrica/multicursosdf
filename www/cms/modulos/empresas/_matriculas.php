<?php require_once("php7_mysql_shim.php");
// Classe de Data
require_once($pathInc . "lib/Data.class.php");

?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00018.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico"> Matrículas [Relatório] </td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<tr>
								<?php if($_REQUEST["ref"] == "buscar"){?>
									<td align="center"><div class="caixaIcone"><a href="<?php print($pathInc . "modulos/empresas/_/_matriculas.imprimir.php");?>" target="_blank"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Imprimir</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="?modulo=empresa&sessao=matriculas"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
								<?php }?>
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
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	// Verifica referência
	if($_REQUEST["ref"] == ""){
		?>
		<tr>
			<td align="left"><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td align="left">
							<form action="?modulo=empresa&sessao=matriculas&ref=buscar" method="POST" name="formMatricula">
								<input type="hidden" name="a" value="S">
								<table border="0" cellpadding="2" cellspacing="2" align="center">
									<tr>
										<td width="15%" align="right"><strong>Período:</strong></td>
										<td align="left">
											De <input type="text" id="dataI" name="dataI" size="12" onKeyUp="maskData(this, document.formMatricula.dataF)">
						  					até <input type="text" id="dataF" name="dataF" size="12" onKeyUp="maskData(this, document.formMatricula.dataF)">
										</td>
									</tr>
									<tr>
										<td align="right"><strong>Cursos:</strong></td>
										<td align="left">
											<select name="curso">
												<?php
												// Busca Cursos
												$buscaCursos = $_ClassMysql->query("SELECT * FROM `cursos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N' AND id = '2' ORDER BY nome");
												
												// Traz Cursos
												while($trazCursos = mysql_fetch_object($buscaCursos)){
													?>
													<option value="<?php print($trazCursos->id);?>"><?php print($trazCursos->sigla . " - " . $trazCursos->nome);?></option>
													<?php
													
												}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td align="left">&nbsp;</td>
										<td align="left"><input type="submit" value="Consultar"></td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
	}elseif($_REQUEST["ref"] == "buscar"){
		
		/* Gravando dados da pesquisa na sessão */
		if($_REQUEST["a"] == "S"){
		
			// Consulta
			$_SESSION["consultaMatriculasPrivadas"] = $_POST;
			
		}
		?>
		<tr>
			<td align="left"><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table width="99%" border="0" cellpadding="2" cellspacing="2">
					<tr>
						<td class="menu_topico">Buscando por: </td>
					</tr>
					<?php
					// Verifica se foi habilitado o campo de Período
					if($_SESSION["consultaMatriculasPrivadas"]["dataI"] != ""){
						?>
						<tr>
							<td align="left"><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaMatriculasPrivadas"]["dataI"]?> até <?php echo $_SESSION["consultaMatriculasPrivadas"]["dataF"]?></ol></td>
						</tr>
						<?php
					}
					
					// Verifica se foi habilitado o campo de curso
					if($_SESSION["consultaMatriculasPrivadas"]["curso"] > 0){
						
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $_SESSION["consultaMatriculasPrivadas"]["curso"] . "'");
						?>
						<tr>
							<td align="left"><ol><strong>Curso:</strong>&nbsp;<?php print($dadosCurso->sigla . " - " . $dadosCurso->nome);?></ol></td>
						</tr>
						<?php
					}
					?>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align="left"><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table width="99%" border="0" cellpadding="2" cellspacing="2">
					<tr>
						<td colspan="2">
							<form action="" method="POST" name="formGrade">
								<input type="hidden" name="act" value="">
								<table class="consulta" cellspacing="1" align="center">
									<thead>
										<tr>
											<th width="1%">#</th>
											<th width="50%">Nome</th>
											<th width="20%">CPF</th>
											<th width="15%">Nascimento</th>
											<th width="15%">Turma</th>
										</tr>
									</thead>
									<tbody>
										<?php	
										/* Construindo sql */
										$sql = "SELECT matriculas.id,
													   alunos.nome,
													   alunos.datanascimento,
													   alunos.cpf,
													   turmas.datainicio FROM `alunos`, `matriculas`, `turmas`";
										$sql .= " WHERE ";
										$sql .= (($_SESSION["consultaMatriculasPrivadas"]["dataI"] != "")?" turmas.datainicio >= '" . $_ClassData->transformaData($_SESSION["consultaMatriculasPrivadas"]["dataI"]) . "' AND turmas.datainicio <= '" . $_ClassData->transformaData($_SESSION["consultaMatriculasPrivadas"]["dataF"]) . "' AND":"");
										$sql .= (($_SESSION["consultaMatriculasPrivadas"]["curso"] > 0)?" turmas.curso = '" . $_SESSION["consultaMatriculasPrivadas"]["curso"] . "' AND":"");
											
										$sql .= " matriculas.deletado = 'N' AND
												  turmas.deletado = 'N' AND
												  alunos.deletado = 'N' AND
												  matriculas.aluno = alunos.id AND
												  turmas.id = matriculas.turma AND 
												  matriculas.empresa = '" . $_dadosLogado->empresa . "' ORDER BY alunos.nome ASC";
					
										/* Fim da construção */
										
										// Paginação
										require_once($pathInc . "lib/Paginacao.class.php");
										
										// Configurações da paginacao
										$_ClassPaginacao->setQuery($sql);
										$_ClassPaginacao->setUrl("modulo=empresa&sessao=matriculas&ref=buscar");
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
											
											// Traz resultados
											while($trazResultados = mysql_fetch_object($_ClassPaginacao->getBusca())){
												
												// Total
												++$total;
												?>
												<tr class=row0>
													<td align="left"><?php print($trazResultados->id); ?></td>
													<td align="center"><?php print($trazResultados->nome);?></td>
													<td align="center"><?php print($_ClassUtilitarios->formataCPF($trazResultados->cpf));?></td>
													<td align="center"><?php print($_ClassData->transformaData($trazResultados->datanascimento, 2)); ?></td>
													<td align="center"><?php print($_ClassData->transformaData($trazResultados->datainicio, 2)); ?></td>
												</tr>
												<?php
											}
											
										}
										?>
									</tbody>
									<tfoot>
										<td colspan="9"><?php print("<div align='right'><b>Total&nbsp;de&nbsp;Matrículas:</b> " . $total . "</div>" . $_ClassPaginacao->showPaginacao());?></td>
									</tfoot>
								</table>
							</form>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
	}
	?>
</table>