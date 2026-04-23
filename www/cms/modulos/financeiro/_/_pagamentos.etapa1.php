<?php require_once("php7_mysql_shim.php");
// Verifica ação
if($_REQUEST["act"] == "salvar"){
	
	// Cadastra na sessão o id da matrícula
	$_SESSION["consultaPagamentos"]["idMatricula"] = $_REQUEST["registros"];
	
	// Redireciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=pagamentos&etapa=2"));
	
}
?>
<tr>
	<td align="left"><div id="border-top"><div><div></div></div></div></td>
</tr>
<tr>
	<td class="table_main">
		<form action="?sessao=pagamentos&etapa=1&submenu=buscar" method="POST" name="formPagamentos_Busca">
			<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td align="right" width="10%"><b>Palavra-Chave:</b></td>
					<td width='90%' align='left'><input type="text" name="texto" size="50"></td>
				</tr>
				<tr>
					<td align="left"></td>
					<td align="left"><?php print($_ClassUtilitarios->criaMenu("Buscar", "#", "document.formPagamentos_Busca.submit();", "esq", "007"));?></td>
				</tr>
			</table>
		</form>
	</td>
</tr>
<tr>
	<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
</tr>
<?php
// Verifica Ação
if($_REQUEST["texto"] != ""){$_SESSION["consultaPagamentos"]["texto"] = $_REQUEST["texto"];}

// Verifica Texto
if($_SESSION["consultaPagamentos"]["texto"] !=  ""){
	
	// Classe de Dinheiro
	require_once($pathInc . "lib/Dinheiro.class.php");
	
	// Classe de Data
	require_once($pathInc . "lib/Data.class.php");
	?>
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
					<td align="left">
						<form action="" method="POST" name="formPagamentos">
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
									/* Construindo sql */
									
										$sql = "SELECT alunos.id AS idAluno,
													   matriculas.aluno,
													   matriculas.turma,
													   matriculas.numero,
													   matriculas.id AS idMatricula FROM `alunos`, 
															  							 `matriculas` WHERE alunos.id = matriculas.aluno AND matriculas.concluido = 'N' AND matriculas.deletado = 'N' AND alunos.rg LIKE '%" . $_SESSION["consultaPagamentos"]["texto"] . "%' AND alunos.deletado = 'N' OR
																										    alunos.id = matriculas.aluno AND matriculas.concluido = 'N' AND matriculas.deletado = 'N' AND alunos.cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_SESSION["consultaPagamentos"]["texto"]) . "%' AND alunos.deletado = 'N' OR
																										 	alunos.id = matriculas.aluno AND matriculas.concluido = 'N' AND matriculas.deletado = 'N' AND alunos.nome LIKE '%" . $_SESSION["consultaPagamentos"]["texto"] . "%' AND alunos.deletado = 'N' OR
																										 	alunos.id = matriculas.aluno AND matriculas.concluido = 'N' AND matriculas.deletado = 'N' AND alunos.email LIKE '%" . $_SESSION["consultaPagamentos"]["texto"] . "%' AND alunos.deletado = 'N' OR
																									 		alunos.id = matriculas.aluno AND matriculas.concluido = 'N' AND matriculas.deletado = 'N' AND matriculas.numero LIKE '%" . $_SESSION["consultaPagamentos"]["texto"] . "%' GROUP BY alunos.id,matriculas.id ORDER BY alunos.nome";
									
									/* Fim da construção */
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=pagamentos&etapa=1");
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
											
											// Dados do Aluno
											$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazResultados->aluno . "'");
											?>
											<tr class=row0>
												<td align="left"><?php print($trazResultados->numero); ?></td>
												<td align="center"><input type="radio" name="registros" value="<?=$trazResultados->idMatricula?>" <?php print((($cont++ == 0)?"checked":""));?>></td>
												<td align="center"><a name="<?=$trazResultados->idMatricula?>"></a><?php print($dadosAluno->nome);?></td>
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
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}
?>