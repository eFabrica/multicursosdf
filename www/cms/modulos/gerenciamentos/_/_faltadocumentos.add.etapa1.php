<?php require_once("php7_mysql_shim.php");
unset($_SESSION["consultaFaltaDocumentos"]["texto"]);
unset($_SESSION["consultaFaltaDocumentos"]["idMatricula"]);

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Salva na sessão a matrícula escolhida
	$_SESSION["consultaFaltaDocumentos"]["idMatricula"] = $_REQUEST["registros"];
	
	// Redireciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=faltadocumentos&ref=novo&etapa=2"));
	
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
		<form action="?sessao=faltadocumentos&ref=novo&etapa=1&submenu=buscar" method="POST" name="formFaltaDocumentos_Busca">
			<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td align="right" width="10%"><b>Palavra-Chave:</b></td>
					<td width='90%' align='left'><input type="text" name="texto" size="50"></td>
				</tr>
				<tr>
					<td align='left'></td>
					<td align='left'><?php print($_ClassUtilitarios->criaMenu("Buscar", "#", "document.formFaltaDocumentos_Busca.submit();", "esq", "007"));?></td>
				</tr>
			</table>
		</form>
	</td>
</tr>
<tr>
	<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
</tr>
<?php
// Verifica Ação
if($_REQUEST["texto"] != ""){$_SESSION["consultaFaltaDocumentos"]["texto"] = $_REQUEST["texto"];}

// Verifica Texto
if($_SESSION["consultaFaltaDocumentos"]["texto"] !=  ""){
	
	// Classe de Dinheiro
	require_once($pathInc . "lib/Dinheiro.class.php");
	
	// Classe de Data
	require_once($pathInc . "lib/Data.class.php");
	?>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td align='left'>
						<form action="" method="POST" name="formFaltaDocumentos">
							<input type="hidden" name="act" value="salvar">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%">#</th>
										<th width="1%" align="center"></th>
										<th width="40%">Aluno</th>
										<th width="25%">Curso/Turma</th>
										<th width="25%">Turno</th>
									</tr>
								</thead>
								<tbody>
									<?php	
									// Busca Alunos
									$buscaAlunos = $_ClassMysql->query("SELECT * FROM `alunos` WHERE rg LIKE '%" . $_SESSION["consultaFaltaDocumentos"]["texto"] . "%' AND deletado = 'N' OR
																								     cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_SESSION["consultaFaltaDocumentos"]["texto"]) . "%' AND deletado = 'N' OR
																								 	 nome LIKE '%" . $_SESSION["consultaFaltaDocumentos"]["texto"] . "%' AND deletado = 'N'");
									
									/* Construindo sql */
									$sql = "SELECT * FROM `matriculas`";
									$sql .= " WHERE ";
									
									// Traz Alunos
									while($trazAlunos = mysql_fetch_object($buscaAlunos)){
									
										// SQL
										$sql .= "unidade = '" . $_dadosUnidade->id . "' AND aluno = '" . $trazAlunos->id . "' AND concluido = 'N' AND deletado = 'N' OR ";
									
									}
									 
									// SQl
									$sql .= "{aqui}";
									$sql = str_replace("OR {aqui}", "", $sql);
									/* Fim da construção */
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=faltadocumentos&ref=novo&etapa=1");
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
										
										// Contador
										$cont = 0;
										
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
											?>
											<tr class=row0>
												<td align='left'><?php print((($trazResultados->numero <= 0)?$trazResultados->id:$trazResultados->numero)); ?></td>
												<td align="center"><input type="radio" name="registros" value="<?=$trazResultados->id?>" <?php print((($cont++ == 0)?"checked":""));?>></td>
												<td align="center"><a name="<?=$trazResultados->id?>"></a><?php print($dadosAluno->nome);?></td>
												<td align="center"><?php print($dadosCurso->sigla);?><?php print($dadosTurma->numero . " <b>(" . $_ClassData->transformaData($dadosTurma->datainicio,2 ) . " à " . $_ClassData->transformaData($dadosTurma->datatermino,2 ) . ")</b>");?></td>
												<td align="center"><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>													
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
						</form>
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