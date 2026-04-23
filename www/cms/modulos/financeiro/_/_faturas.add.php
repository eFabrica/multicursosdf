<?php require_once("php7_mysql_shim.php");
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["datavencimento"], "É preciso informar a Data de Vencimento."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Valida data
		if(!$_ClassData->validaData($_REQUEST["datavencimento"])){$_ClassMensagens->setMensagem_erro("Data de vencimento inválida<br>");}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica valores
		if($_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor"]) == 0){
			
			// Seta erro
			$_ClassMensagens->setMensagem_erro("É necessário ter o valor maior que zero.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){		
		
		// Cadastra Fatura
		$cadastraFatura = $_ClassMysql->query("INSERT INTO `faturas` SET  unidade = '" . $_dadosUnidade->id . "',
																		  empresa = '" . $_REQUEST["empresa"] . "',
																		  valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor"]) . "',
																		  datavenc = '" . $_ClassData->transformaData($_REQUEST["datavencimento"]) . "',
																		  datai = '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "',
																		  dataf = '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "',
																		  quemcriou = '" . $_dadosLogado->id . "',
																		  datahorac = now();");
		
		// Id da Fatura
		$idFatura = mysql_insert_id();
		
		// Verifica se Cadastrou
		if($cadastraFatura){
			
			// Busca Turmas
			$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND datainicio >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND datainicio <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' AND deletado = 'N'");
			
			// Verifica o total achado
			if(mysql_num_rows($buscaTurmas) > 0){
				
				// Traz Turmas
				while($trazTurmas = mysql_fetch_object($buscaTurmas)){
				
					// Altera Matrículas
					$alteraMatriculas = $_ClassMysql->query("UPDATE `matriculas` SET fatura = '" . $idFatura . "', ultimoeditou = '" . $_dadosLogado->id . "', datahorae = NOW() WHERE unidade = '" . $_dadosUnidade->id . "' AND empresa = '" . $_REQUEST["empresa"] . "' AND turma = '" . $trazTurmas->id . "' AND deletado = 'N'");
					
				}
				
			}
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Fatura gravada com sucesso!<br><br>[ <a href='?sessao=faturas&ref=novo'>Atualizar</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar esta Fatura.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() != "" || $_ClassMensagens->getMensagem_sucesso() != ""){
		?>
		<tr>
			<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<?php
	}
	
}elseif($_REQUEST["act"] == "gerar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica campos
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["dataI"], "É preciso informar a Data Inicial."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["dataF"], "É preciso informar a Data Final."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["empresa"], "É preciso informar a Empresa"));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Valida Data Inicial
		if(!$_ClassData->validaData($_REQUEST["dataI"])){$_ClassMensagens->setMensagem_erro("Data Inicial está inválida.<br>");}
		
		// Valida a Data Final
		if(!$_ClassData->validaData($_REQUEST["dataF"])){$_ClassMensagens->setMensagem_erro("Data Final está inválida.<br>");}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Redireciona
		print($_ClassUtilitarios->redirecionarJS("?sessao=faturas&ref=novo&subref=gerar&empresa=" . $_REQUEST["empresa"] . "&dataI=" . $_REQUEST["dataI"] . "&dataF=" . $_REQUEST["dataF"]));
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() != "" || $_ClassMensagens->getMensagem_sucesso() != ""){
		?>
		<tr>
			<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<?php
	}
	
}

// Verifica Sucesso
if(!$sucesso){
	
	// Verifica subref
	if($_REQUEST["subref"] != "gerar"){
	
		?>
		<tr>
			<td align="left"><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<form action="?sessao=faturas&ref=novo&act=gerar" method="POST" name="formFaturas">
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
				<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
					<tr>
						<td width="15%" align="right"><strong>Data:</strong></td>
						<td width='85%' align='left'>
							De <?php print($_REQUEST["dataI"]);?>
					  		até <?php print($_REQUEST["dataF"]);?>
						</td>
					</tr>
					<tr>
						<td align="right"><b>Empresa:</b></td>
						<td align="left">
							<?php
							// Dados da Empresa
							$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $_REQUEST["empresa"] . "'");
							
							// Exibe nome da empresa
							print($dadosEmpresa->razaosocial . " (" . $_ClassUtilitarios->formataCNPJ($dadosEmpresa->cnpj) . ")");
							?>
						</td>
					</tr>
					<?php
					// Busca Fatura
					$buscaFatura = $_ClassMysql->query("SELECT * FROM `faturas` WHERE unidade = '" . $_dadosUnidade->id . "' AND empresa = '" . $_REQUEST["empresa"] . "' AND datai = '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND dataf = '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "'");
					
					// Verifica o total achado
					if(mysql_num_rows($buscaFatura) > 0){
						?>
						<tr>
							<td colspan="2" align="center"><b style="color:#FF0000;">Foi encontrada uma fatura referente a este período informado. [ <a href="">Visualizar</a> ]</b></td>
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
				<?php
				// Total de Turmas
				$totTurmas = 0;
				
				// Total de Matrículas
				$totMatriculas = 0;
				
				// Valor total
				$valorTotal = 0;
				
				// Busca Turmas
				$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND datainicio >= '" . $_ClassData->transformaData($_REQUEST["dataI"]) . "' AND datainicio <= '" . $_ClassData->transformaData($_REQUEST["dataF"]) . "' AND deletado = 'N'");
				
				// Verifica o total achado
				if(mysql_num_rows($buscaTurmas) > 0){
					
					// Traz Turmas
					while($trazTurmas = mysql_fetch_object($buscaTurmas)){
					
						// Busca Matrículas
						$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE unidade = '" . $_dadosUnidade->id . "' AND empresa = '" . $_REQUEST["empresa"] . "' AND turma = '" . $trazTurmas->id . "' AND fatura = '0' AND deletado = 'N'");
						
						// Verifica o total achado
						if(mysql_num_rows($buscaMatriculas) > 0){
							
							// Incrementa turmas com alunos desta empresa
							$totTurmas++;
							
							// Traz Matrículas
							while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
								
								// Incrementa matrículas desta empresa
								$totMatriculas++;
								
								// Incrementa o Valor Total da Fatura
								$valorTotal += $trazMatriculas->valor_dinheiro;
								
							}
							
						}
						
					}
					
				}
				?>
				<form action="" method="POST" name="formFaturas">
					<input type="hidden" name="act" value="salvar">
					<input type="hidden" name="empresa" value="<?php print($_REQUEST["empresa"]);?>">
					<input type="hidden" name="dataI" value="<?php print($_REQUEST["dataI"]);?>">
					<input type="hidden" name="dataF" value="<?php print($_REQUEST["dataF"]);?>">
					<input type="hidden" name="valor" value="<?php print($valorTotal);?>">
					<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
						<tr>
							<td width="15%" align="right"><strong><font class="obrig">(*)</font> Data Venc.:</strong></td>
							<td width='85%' align='left'><input type="text" name="datavencimento" size="12" onKeyUp="maskData(this, this);"></td>
						</tr>
						<tr>
							<td align="right"><b>Tot. Turmas:</b></td>
							<td align="left">
								<?php print($totTurmas);?>
								<a href="#" onclick="popup('fatura_turmas', '<?php print($pathInc);?>modulos/financeiro/_/_faturas.turmas.php?idEmpresa=<?php print($_REQUEST["empresa"] . "&dataI=" . $_REQUEST["dataI"] . "&dataF=" . $_REQUEST["dataF"]);?>', 730, 400, 'yes')"><img src="<?php print($pathInc);?>imagens/icones/sh.png" border="0"></a>
							</td>
						</tr>
						<tr>
							<td align="right"><b>Tot. Matrículas:</b></td>
							<td align="left">
								<?php print($totMatriculas);?>
								<a href="#" onclick="popup('fatura_matriculas', '<?php print($pathInc);?>modulos/financeiro/_/_faturas.matriculas.php?idEmpresa=<?php print($_REQUEST["empresa"] . "&dataI=" . $_REQUEST["dataI"] . "&dataF=" . $_REQUEST["dataF"]);?>', 730, 400, 'yes')"><img src="<?php print($pathInc);?>imagens/icones/sh.png" border="0"></a>
							</td>
						</tr>
						<tr>
							<td align="right"><b>Valor Total:</b></td>
							<td align="left">R$ <?php print($_ClassDinheiro->formataMoeda($valorTotal));?></td>
						</tr>
						<tr>
							<td colspan="2">
								<br>
								<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios<Br>
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
		<tr>
			<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<?php
	}
	
}
?>