<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["razaosocial"], "É preciso informar a Razão Social."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["endereco"], "É preciso informar o Endereço."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["estado"], "É preciso informar o Estado."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cidades"], "É preciso informar a Cidae."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cep"], "É preciso informar o CEP."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cnpj"], "É preciso informar o CNPJ."));
	if($_REQUEST["telefonefixo"] == "" && $_REQUEST["telefonealternativo"] == ""){$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["telefonealternativo"], "É preciso informar um Telefone."));}// Verifica Telefones
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["email"], "É preciso informar o E-mail."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["responsavel"], "É preciso informar o Responsável."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cpf"], "É preciso informar CPF do Responsável."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["emailresponsavel"], "É preciso informar o E-mail do Responsável."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["acesso"], "É preciso informar o Acesso."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Classe de E-mail
		require_once($pathInc . "lib/Email.class.php");
		
		// Classe de CPF
		require_once($pathInc . "lib/Cpf.class.php");
		
		// Classe de CNPJ
		require_once($pathInc . "lib/Cnpj.class.php");
		
		// Limpa CPF
		$_REQUEST["cpf"] = preg_replace("/[\.-]/", "", $_REQUEST["cpf"]);
		
		// Limpa CNPJ
		$_REQUEST["cnpj"] = preg_replace("/[\/.-]/", "", $_REQUEST["cnpj"]);
		
		// Limpa CEP
		$_REQUEST["cep"] = preg_replace("/[-]/", "", $_REQUEST["cep"]);
		
		// Verifica CNPJ
		if(!$_ClassCnpj->validaCnpj($_REQUEST["cnpj"])){$_ClassMensagens->setMensagem_erro("CNPJ inválido.<br>");}
		
		// Verifica E-mail
		if(!$_ClassEmail->validaEmail($_REQUEST["email"])){$_ClassMensagens->setMensagem_erro("E-mail inválido.<br>");}
		
		// Verifica E-mail do Responsável
		if(!$_ClassEmail->validaEmail($_REQUEST["emailresponsavel"])){$_ClassMensagens->setMensagem_erro("E-mail do Responsável inválido.<br>");}
		
		// Verifica CPF do Responsável
		if(!$_ClassCpf->validaCPF($_REQUEST["cpf"])){$_ClassMensagens->setMensagem_erro("CPF do Responsável inválido.<br>");}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
	
		// Verifica se já existe esta unidade
		$_ClassRn->getDadosTable("unidades", "id", "id != '" . $_REQUEST["idRegistro"] . "' AND cnpj = '" . $_REQUEST["cnpj"] . "'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Unidade já exite.<br>");
			
		}
			
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Edita Unidade
		$editaUnidade = $_ClassMysql->query("UPDATE `unidades` SET razaosocial = '" . $_REQUEST["razaosocial"] . "',
																   nomefantasia = '" . $_REQUEST["nomefantasia"] . "',
																   endereco = '" . $_REQUEST["endereco"] . "',
																   estado = '" . $_REQUEST["estado"] . "',
																   cidade = '" . $_REQUEST["cidades"] . "',
																   cep = '" . $_REQUEST["cep"] . "',
																   cnpj = '" . $_REQUEST["cnpj"] . "',
																   ie = '" . $_REQUEST["ie"] . "',
																   telefonefixo = '" . $_REQUEST["telefonefixo"] . "',
																   telefonealternativo = '" . $_REQUEST["telefonealternativo"] . "',
																   fax = '" . $_REQUEST["fax"] . "',
																   email = '" . $_REQUEST["email"] . "',
																   responsavel = '" . $_REQUEST["responsavel"] . "',
																   cpfresponsavel = '" . $_REQUEST["cpf"] . "',
																   emailresponsavel = '" . $_REQUEST["emailresponsavel"] . "',
																   telefoneresponsavel = '" . $_REQUEST["telefoneresponsavel"] . "',
																   acesso = '" . $_REQUEST["acesso"] . "',
																   ultimoeditou = '" . $_dadosLogado->id . "',
															  	   datahorae = now() WHERE id = '" . $_REQUEST["idRegistro"] . "'");
		
		// Verifica se Editou
		if($editaUnidade){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Unidade gravada com sucesso!<br><br>[ <a href='?sessao=unidades&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "'>Voltar para a Listagem</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar esta unidade.<br>");
			
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
	
	// Dados da Unidade
	$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . $_REQUEST["idRegistro"] . "'");
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formUnidade">
				<input type="hidden" name="act" value="salvar">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td align="right" width="15%"><b><font class="obrig">(*)</font> Razão Social:</b></td>
						<td width='85%' align='left'><input type="text" name="razaosocial" size="60" value="<?php echo (($_REQUEST["razaosocial"] != "")?$_REQUEST["razaosocial"]:$dadosUnidade->razaosocial);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Nome Fantasia:</b></td>
						<td align='left'><input type="text" name="nomefantasia" size="40" value="<?php echo (($_REQUEST["nomefantasia"] != "")?$_REQUEST["nomefantasia"]:$dadosUnidade->nomefantasia);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Endereço:</b></td>
						<td align='left'><input type="text" name="endereco" size="60" value="<?php echo (($_REQUEST["endereco"] != "")?$_REQUEST["endereco"]:$dadosUnidade->endereco);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Estado</b></td>
						<td align='left'>
							<select name="estado" onchange="carrega('cidades&uf='+this.options[this.selectedIndex].value)">
								<option value=""></option>
								<option value="AC" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "AC")?"selected":""?>>AC</option>
								<option value="AL" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "AL")?"selected":""?>>AL</option>
								<option value="AM" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "AM")?"selected":""?>>AM</option>
								<option value="AP" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "AP")?"selected":""?>>AP</option>
								<option value="BA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "BA")?"selected":""?>>BA</option>
								<option value="CE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "CE")?"selected":""?>>CE</option>
								<option value="DF" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "DF")?"selected":""?>>DF</option>
								<option value="ES" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "ES")?"selected":""?>>ES</option>
								<option value="GO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "GO")?"selected":""?>>GO</option>
								<option value="MA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "MA")?"selected":""?>>MA</option>
								<option value="MG" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "MG")?"selected":""?>>MG</option>
								<option value="MS" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "MS")?"selected":""?>>MS</option>
								<option value="MT" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "MT")?"selected":""?>>MT</option>
								<option value="PA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "PA")?"selected":""?>>PA</option>
								<option value="PB" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "PB")?"selected":""?>>PB</option>
								<option value="PE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "PE")?"selected":""?>>PE</option>
								<option value="PI" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "PI")?"selected":""?>>PI</option>
								<option value="PR" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "PR")?"selected":""?>>PR</option>
								<option value="RJ" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "RJ")?"selected":""?>>RJ</option>
								<option value="RO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "RO")?"selected":""?>>RO</option>
								<option value="RR" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "RR")?"selected":""?>>RR</option>
								<option value="RN" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "RN")?"selected":""?>>RN</option>
								<option value="RS" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "RS")?"selected":""?>>RS</option>
								<option value="SC" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "SC")?"selected":""?>>SC</option>
								<option value="SE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "SE")?"selected":""?>>SE</option>
								<option value="SP" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "SP")?"selected":""?>>SP</option>
								<option value="TO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) == "TO")?"selected":""?>>TO</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Cidade:</b></td>
						<td align='left'>
							<div id="main">
								<select name="cidades">
									<option value="">&nbsp;</option>
									<?php
									// Busca Cidades
									$buscaCidades = mysql_query("SELECT * FROM `cidades` WHERE estado = '" . (($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUnidade->estado) . "' AND deletado = 'N' ORDER BY cidade ASC");
									
									// Traz Cidades
									while($trazCidades = mysql_fetch_object($buscaCidades)){
										
										?>
										<option value="<?php print($trazCidades->id); ?>" <?php print((((($_REQUEST["cidade"] != "")?$_REQUEST["cidade"]:$dadosUnidade->cidade) == $trazCidades->id)?"selected":""));?>><?php print($trazCidades->cidade); ?></option>
										<?php
										
									}												
									?>
								</select>
							</div>
							<div id="loading"></div>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> CEP:</b></td>
						<td align='left'><input type="text" name="cep" size="12" maxlength="9" onKeyUp="maskCEP(this, document.formUnidade.cnpj)" value="<?php echo (($_REQUEST["cep"] != "")?$_REQUEST["cep"]:$_ClassUtilitarios->formataCEP($dadosUnidade->cep)); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> CNPJ:</b></td>
						<td align='left'><input type="text" name="cnpj" size="22" maxlength="18" onKeyUp="maskCNPJ(this, document.formUnidade.ie)" value="<?php echo (($_REQUEST["cnpj"] != "")?$_REQUEST["cnpj"]:$_ClassUtilitarios->formataCNPJ($dadosUnidade->cnpj)); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b>I.E:</b></td>
						<td align='left'><input type="text" name="ie" size="30" value="<?php echo (($_REQUEST["ie"] != "")?$_REQUEST["ie"]:$dadosUnidade->ie); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(**)</font> Telefone Fixo:</b></td>
						<td align='left'><input type="text" name="telefonefixo" size="25" value="<?php echo (($_REQUEST["telefonefixo"] != "")?$_REQUEST["telefonefixo"]:$dadosUnidade->telefonefixo); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(**)</font> Telefone Alternativo:</b></td>
						<td align='left'><input type="text" name="telefonealternativo" size="25" value="<?php echo (($_REQUEST["telefonealternativo"] != "")?$_REQUEST["telefonealternativo"]:$dadosUnidade->telefonealternativo); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b>FAX:</b></td>
						<td align='left'><input type="text" name="fax" size="25" value="<?php echo (($_REQUEST["fax"] != "")?$_REQUEST["fax"]:$dadosUnidade->fax); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> E-mail:</b></td>
						<td align='left'><input type="text" name="email" size="50" value="<?php echo (($_REQUEST["email"] != "")?$_REQUEST["email"]:$dadosUnidade->email); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Responsável:</b></td>
						<td align='left'><input type="text" name="responsavel" size="45" value="<?php echo (($_REQUEST["responsavel"] != "")?$_REQUEST["responsavel"]:$dadosUnidade->responsavel); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> CPF:</b></td>
						<td align='left'><input type="text" name="cpf" size="18" maxlength="14" onKeyUp="maskCPF(this, document.formUnidade.emailresponsavel)" value="<?php echo (($_REQUEST["cpf"] != "")?$_REQUEST["cpf"]:$_ClassUtilitarios->formataCPF($dadosUnidade->cpfresponsavel)); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> E-mail Resp.:</b></td>
						<td align='left'><input type="text" name="emailresponsavel" size="60" value="<?php echo (($_REQUEST["emailresponsavel"] != "")?$_REQUEST["emailresponsavel"]:$dadosUnidade->emailresponsavel); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Telefone Resp.:</b></td>
						<td align='left'><input type="text" name="telefoneresponsavel" size="25" value="<?php echo (($_REQUEST["telefoneresponsavel"] != "")?$_REQUEST["telefoneresponsavel"]:$dadosUnidade->telefoneresponsavel); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Acesso:</b></td>
						<td align='left'>
							<select name="acesso">
								<option value="L" <?php echo(((($_REQUEST["acesso"] != "")?$_REQUEST["acesso"]:$dadosUnidade->acesso) == "L")?"selected":"")?>>Liberado</option>
								<option value="B" <?php echo(((($_REQUEST["acesso"] != "")?$_REQUEST["acesso"]:$dadosUnidade->acesso)  == "B")?"selected":"")?>>Bloqueado</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios<br>
							<font class="obrig"><b>(**)</b></font> - Campos Obrigatórios ou Optativos (Dependem de outros campos)
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