<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00045.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Faturas</td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
							// Verifica Referência
							if($_REQUEST["subref"] == "listar"){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formFaturas.submit();"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Emitir</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=faturas"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Busca</a></div></td>
								<?php
								
							}
							?>
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
	// Verifica Sub Ref
	if ($_REQUEST["subref"] != "listar"){
		?>
		<tr>
			<td align="left"><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<form action="?sessao=faturas&subref=listar" method="POST" name="formFaturas">
					<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
						<tr>
							<td width="15%" align="right"><strong>Data:</strong></td>
							<td width='85%' align='left'>
								De <input type="text" id="dataI" name="dataI" size="12" onKeyUp="maskData(this, document.formFaturas.dataF)" value="<?php print($_REQUEST["dataI"]);?>">
						  		até <input type="text" id="dataF" name="dataF" size="12" onKeyUp="maskData(this, document.formFaturas.dataF)" value="<?php print($_REQUEST["dataF"]);?>">
							</td>
						</tr>
						<tr>
							<td align="right" width="15%"><b>Filtrar Empresas:</b></td>
							<td width='85%' align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formFaturas.empresa);"></td>
						</tr>
						<tr>
							<td align="right"><b>Empresa:</b></td>
							<td align="left">
								<select name="empresa">
									<option value=""></option>
									<?php
									// Busca Empresas
									$buscaEmpresas = $_ClassMysql->query("SELECT * FROM `clientes` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
									
									// Traz Empresas
									while($trazEmpresas = mysql_fetch_object($buscaEmpresas)){
										
										?>
										<option value="<?php print($trazEmpresas->id);?>" <?php print((($_REQUEST["empresa"] == $trazEmpresas->id)?"selected":""));?>><?php print($trazEmpresas->razaosocial);?></option>
										<?php
										
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td align="left"></td>
							<td align="left"><?php print($_ClassUtilitarios->criaMenu("Gerar", "#", "document.formFaturas.submit();", "esq", "007", $pathInc)); ?></td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
		<tr>
			<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
	}else{
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
					<tr>
						<td align="left"><ol><strong>Data:</strong>&nbsp;De <?php echo $_REQUEST["dataI"]?> até <?php echo $_REQUEST["dataF"]?></ol></td>
					</tr>
					<tr>
						<td align="left">
						<ol><strong>Empresa:</strong>&nbsp;
						<?php
						// Dados da Empresa
						$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $_REQUEST["empresa"] . "'");
						
						// Exibe empresa
						print($dadosEmpresa->razaosocial);
						?>
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
		<tr>
			<td align="left"><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<form action="<?php print($pathInc . "modulos/financeiro/_/_faturas.emitir.php"); ?>" target="_blank" method="POST" name="formFaturas">
					<input type="hidden" name="dataI" value="<?php print($_REQUEST["dataI"]);?>">
					<input type="hidden" name="dataF" value="<?php print($_REQUEST["dataF"]);?>">
					<input type="hidden" name="empresa" value="<?php print($_REQUEST["empresa"]);?>">
					<?php
					// Busca Turmas que tenham matrículas da empresa selecionada
					$buscaTurmas = $_ClassMysql->query("SELECT turmas.id,
															   turmas.numero,
															   turmas.curso,
															   turmas.datainicio,
															   turmas.datatermino FROM `turmas`, `matriculas` WHERE    turmas.deletado = 'N' AND
																													   matriculas.deletado = 'N' AND
																													   turmas.id = matriculas.turma AND
																													   matriculas.empresa = '" . $_REQUEST["empresa"] . "' AND
																													   turmas.datainicio >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND turmas.datainicio <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' GROUP BY curso,numero");
					
					// Traz Turmas
					while($trazTurmas = mysql_fetch_object($buscaTurmas)){
						
						// Dados do Curso
						$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $trazTurmas->curso . "'");
						?>
						<fieldset>
							<legend><b><?php print($dadosCurso->sigla . $trazTurmas->numero . " (" . $_ClassData->transformaData($trazTurmas->datainicio, 2) . " - " . $_ClassData->transformaData($trazTurmas->datatermino, 2) . ")");?></b></legend>
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th align="center"><input type="checkbox" onclick="select_all('formFaturas', 'registros[]')" checked></th>
										<th align="center" width="70%">Nome</th>
										<th align="center" width="30%">CPF</th>
									</tr>
								</thead>
								<tbody>
									<?php
									// Busca Matrículas
									$buscaMatriculas = $_ClassMysql->query("SELECT m.* FROM `matriculas` m,
																						    `alunos` 	 a WHERE m.deletado = 'N' AND
																											     m.empresa = '" . $_REQUEST["empresa"] . "' AND
																											     m.turma = '" . $trazTurmas->id . "' AND
																											     a.id = m.aluno
																											     ORDER BY a.nome ASC");
									
									// Traz Matrículas
									while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
										
										// Dados do Aluno
										$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");

                                        // Busca Matrículas Faturas
                                        $buscaFaturamentos = $_ClassMysql->query("SELECT * FROM `faturas` WHERE matricula  = '" . $trazMatriculas->id . "' ORDER BY datahorac ASC");
										?>
										<tr class=row0>
											<td align="center"><input type="checkbox" name="registros[]" value="<?=$trazMatriculas->id?>" checked></td>
                                            <td align="left">&nbsp;<font style="color:#<?php print(((mysql_num_rows($buscaFaturamentos) > 0)?"FF0000":"00000")); ?>;"><?php print($dadosAluno->nome);?></font></td>
											<td align="center">&nbsp;<font style="color:#<?php print(((mysql_num_rows($buscaFaturamentos) > 0)?"FF0000":"00000")); ?>;"><?php print($_ClassUtilitarios->formataCPF($dadosAluno->cpf));?></font></td>
										</tr>
										<?php
                                        // Traz Faturamentos
                                        while ($trazFaturamento = mysql_fetch_object($buscaFaturamentos)) {

                                            ?>
                                            <tr>
                                                <td colspan="3" align="left"><font style="color:#FF0000;"><b>Faturado em <?php print($_ClassData->transformaData($trazFaturamento->datahora, 3)); ?></b></font></td>
                                            </tr>
                                            <?php

                                        }
                                        
									}
									?>
								</tbody>
							</table>
						</fieldset>
						<br><br>
						<?php
					}
					?>
				</form>
			</td>
		</tr>
		<tr>
			<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
	}
	?>
</table>