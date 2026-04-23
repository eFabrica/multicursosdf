<?php
// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cidade"], "É preciso informar a cidade."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica se já existe esta cidade
		$_ClassRn->getDadosTable("cidades", "id", "cidade = '" . $_REQUEST["cidade"] . "' AND estado = '" . $_REQUEST["estado"] . "' AND deletado = 'N'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Cidade já exite.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Cadastra Cidade
		$cadastraCidade = $_ClassMysql->query("INSERT INTO `cidades` SET cidade = '" . $_REQUEST["cidade"] . "',
																	  	 estado = '" . $_REQUEST["estado"] . "',
																	  	 quemcriou = '" . $_dadosLogado->id . "',
																	  	 datahorac = now()");
		
		// Verifica se Cadastrou
		if($cadastraCidade){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Cidade gravada com sucesso!<br><br>[ <a href='?sessao=cidades&ref=novo'>Atualizar</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar esta cidade.<br>");
			
		}
		
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

// Verifica Sucesso
if(!$sucesso){
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formCidade">
				<input type="hidden" name="act" value="salvar">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td align="right" width="10%"><b><font class="obrig">(*)</font> Cidade:</b></td>
						<td width='90%' align='left'>
							<span id="cidade">
								<input type="text" name="cidade" size="25" value="<?php echo $_REQUEST["cidade"]?>">
							</span>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Estado</b></td>
						<td align='left'>
							<span id="estado">
								<select name="estado">
									<option value="AC" <?php echo ($_POST["estado"] == "AC")?"selected":""?>>AC</option>
									<option value="AL" <?php echo ($_POST["estado"] == "AL")?"selected":""?>>AL</option>
									<option value="AM" <?php echo ($_POST["estado"] == "AM")?"selected":""?>>AM</option>
									<option value="AP" <?php echo ($_POST["estado"] == "AP")?"selected":""?>>AP</option>
									<option value="BA" <?php echo ($_POST["estado"] == "BA")?"selected":""?>>BA</option>
									<option value="CE" <?php echo ($_POST["estado"] == "CE")?"selected":""?>>CE</option>
									<option value="DF" <?php echo ($_POST["estado"] == "DF")?"selected":""?>>DF</option>
									<option value="ES" <?php echo ($_POST["estado"] == "ES")?"selected":""?>>ES</option>
									<option value="GO" <?php echo ($_POST["estado"] == "GO")?"selected":""?>>GO</option>
									<option value="MA" <?php echo ($_POST["estado"] == "MA")?"selected":""?>>MA</option>
									<option value="MG" <?php echo ($_POST["estado"] == "MG")?"selected":""?>>MG</option>
									<option value="MS" <?php echo ($_POST["estado"] == "MS")?"selected":""?>>MS</option>
									<option value="MT" <?php echo ($_POST["estado"] == "MT")?"selected":""?>>MT</option>
									<option value="PA" <?php echo ($_POST["estado"] == "PA")?"selected":""?>>PA</option>
									<option value="PB" <?php echo ($_POST["estado"] == "PB")?"selected":""?>>PB</option>
									<option value="PE" <?php echo ($_POST["estado"] == "PE")?"selected":""?>>PE</option>
									<option value="PI" <?php echo ($_POST["estado"] == "PI")?"selected":""?>>PI</option>
									<option value="PR" <?php echo ($_POST["estado"] == "PR")?"selected":""?>>PR</option>
									<option value="RJ" <?php echo ($_POST["estado"] == "RJ")?"selected":""?>>RJ</option>
									<option value="RO" <?php echo ($_POST["estado"] == "RO")?"selected":""?>>RO</option>
									<option value="RR" <?php echo ($_POST["estado"] == "RR")?"selected":""?>>RR</option>
									<option value="RN" <?php echo ($_REQUEST["estado"] == "RN")?"selected":""?>>RN</option>
									<option value="RS" <?php echo ($_POST["estado"] == "RS")?"selected":""?>>RS</option>
									<option value="SC" <?php echo ($_POST["estado"] == "SC")?"selected":""?>>SC</option>
									<option value="SE" <?php echo ($_POST["estado"] == "SE")?"selected":""?>>SE</option>
									<option value="SP" <?php echo ($_POST["estado"] == "SP")?"selected":""?>>SP</option>
									<option value="TO" <?php echo ($_POST["estado"] == "TO")?"selected":""?>>TO</option>
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}
?>