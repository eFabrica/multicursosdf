<?php require_once("php7_mysql_shim.php");
// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["nome"], "É preciso informar o Nome."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["datanascimento"], "É preciso informar a Data de Nascimento."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["endereco"], "É preciso informar o Endereço."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["estado"], "É preciso informar o Estado."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cidades"], "É preciso informar a Cidade."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cep"], "É preciso informar o CEP."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["rg"], "É preciso informar o R.G."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["orgexp"], "É preciso informar o Orgão Expeditor."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["dataexp"], "É preciso informar a Data da Expedição."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cpf"], "É preciso informar o CPF."));
	if($_REQUEST["telefonefixo"] == "" && $_REQUEST["telefonealternativo"] == ""){$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["telefonealternativo"], "É preciso informar um Telefone."));}// Verifica Telefones
	
	//$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST[""], "É preciso informar ."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Classe de E-mail
		require_once($pathInc . "lib/Email.class.php");
		
		// Classe de CPF
		require_once($pathInc . "lib/Cpf.class.php");
		
		// Limpa CPF
		$_REQUEST["cpf"] = preg_replace("/[\.-]/", "", $_REQUEST["cpf"]);
		
		// Limpa CEP
		$_REQUEST["cep"] = preg_replace("/[-]/", "", $_REQUEST["cep"]);
		
		// Verifica E-mail
		if($_REQUEST["email"] != "" && !$_ClassEmail->validaEmail($_REQUEST["email"])){$_ClassMensagens->setMensagem_erro("E-mail inválido.<br>");}
		
		// Verifica Data de Nascimento
		if(!$_ClassData->validaData($_REQUEST["datanascimento"])){$_ClassMensagens->setMensagem_erro("Data de Nascimento Inválida.<br>");}
		
		// Verifica Data de Expedição
		if(!$_ClassData->validaData($_REQUEST["dataexp"])){$_ClassMensagens->setMensagem_erro("Data de Expedição Inválida.<br>");}
		
		// Verifica CPF do Responsável
		if(!$_ClassCpf->validaCPF($_REQUEST["cpf"])){$_ClassMensagens->setMensagem_erro("CPF inválido.<br>");}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica senha
		if($_REQUEST["senha"] != $_REQUEST["csenha"]){
			
			// Seta erro
			$_ClassMensagens->setMensagem_erro("Senhas diferente.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica se já existe este usuário
		$_ClassRn->getDadosTable("usuarios", "id", "id != '" . $_REQUEST["idRegistro"] . "' AND unidade = '" . $_REQUEST["unidade"] . "' AND cpf = '" . $_REQUEST["cpf"] . "' AND deletado = 'N'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Usuário já exite.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Edita o Usuário
		$editaUsuario = $_ClassMysql->query("UPDATE `usuarios` SET unidade = '" . $_REQUEST["unidade"] . "',
																   nome = '" . strtoupper($_REQUEST["nome"]) . "',
																   datanascimento = '" . $_ClassData->transformaData($_REQUEST["datanascimento"]) . "',
																   endereco = '" . strtoupper($_REQUEST["endereco"]) . "',
																   cidade = '" . $_REQUEST["cidades"] . "',
																   estado = '" . $_REQUEST["estado"] . "',
																   cep = '" . $_REQUEST["cep"] . "',
																   rg = '" . $_REQUEST["rg"] . "',
																   orgexp = '" . $_REQUEST["orgexp"] . "',
																   dataexp = '" . $_ClassData->transformaData($_REQUEST["dataexp"]) . "',
																   cpf = '" . $_REQUEST["cpf"] . "',
																   email = '" . $_REQUEST["email"] . "',
																   telefonefixo = '" . $_REQUEST["telefonefixo"] . "',
																   telefonealternativo = '" . $_REQUEST["telefonealternativo"] . "',
																   nivel = '" . $_REQUEST["nivel"] . "',
																   senha = '" . (($_REQUEST["senha"] != "")?md5($_REQUEST["senha"]):$_REQUEST["senhaOri"]) . "',
																   ultimoeditou = '" . $_dadosLogado->id . "',
									   							   datahorae = now() WHERE id = '" . $_REQUEST["idRegistro"] . "'");
		
		// Verifica se Editou
		if($editaUsuario){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Usuário gravado com sucesso!<br><br>[ <a href='?sessao=usuarios&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "'>Voltar para a Listagem</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar este Usuário.<br>");
			
		}
		
	}
	
	?>
	<tr>
		<td align='left'><?php echo $_ClassMensagens->exibirMensagem();?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}

// Verifica Sucesso
if(!$sucesso){
	
	// Dados do Usuário
	$dadosUsuario = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_REQUEST["idRegistro"] . "'");
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formUsuario">
				<input type="hidden" name="act" value="salvar">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
					<tr>
						<td width="15%" align="right"><b><font class="obrig">(*)</font> Unidade:</b></td>
						<td width='85%' align='left'>
							<select name="unidade">
								<?php
								// Busca Unidades
								$buscaUnidades = $_ClassMysql->query("SELECT * FROM `unidades` WHERE deletado = 'N' AND acesso = 'L'");
								
								// Traz Unidades
								while($trazUnidades = mysql_fetch_object($buscaUnidades)){
									
									?>
									<option value="<?php print($trazUnidades->id); ?>" <?php print((((($_REQUEST["unidade"] != "")?$_REQUEST["unidade"]:$dadosUsuario->unidade) == $trazUnidades->id)?"selected":""));?>><?php print($trazUnidades->razaosocial); ?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Nome:</b></td>
						<td align='left'><input type="text" name="nome" size="50" value="<?php echo (($_REQUEST["nome"] != "")?$_REQUEST["nome"]:$dadosUsuario->nome);?>"></td>
				 	</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Data Nascimento:</b></td>
						<td align='left'><input type="text" name="datanascimento" size="12" maxlength="10" onKeyUp="maskData(this, document.formUsuario.endereco)" value="<?php echo (($_REQUEST["datanascimento"] != "")?$_REQUEST["datanascimento"]:$_ClassData->transformaData($dadosUsuario->datanascimento, 2));?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Endereço:</b></td>
						<td align='left'><input type="text" name="endereco" size="50" value="<?php echo (($_REQUEST["endereco"] != "")?$_REQUEST["endereco"]:$dadosUsuario->endereco);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Estado</b></td>
						<td align='left'>
							<select name="estado" onChange="carrega('cidades&uf='+this.options[this.selectedIndex].value)">
								<option value=""></option>
								<option value="AC" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "AC")?"selected":""?>>AC</option>
								<option value="AL" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "AL")?"selected":""?>>AL</option>
								<option value="AM" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "AM")?"selected":""?>>AM</option>
								<option value="AP" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "AP")?"selected":""?>>AP</option>
								<option value="BA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "BA")?"selected":""?>>BA</option>
								<option value="CE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "CE")?"selected":""?>>CE</option>
								<option value="DF" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "DF")?"selected":""?>>DF</option>
								<option value="ES" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "ES")?"selected":""?>>ES</option>
								<option value="GO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "GO")?"selected":""?>>GO</option>
								<option value="MA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "MA")?"selected":""?>>MA</option>
								<option value="MG" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "MG")?"selected":""?>>MG</option>
								<option value="MS" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "MS")?"selected":""?>>MS</option>
								<option value="MT" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "MT")?"selected":""?>>MT</option>
								<option value="PA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "PA")?"selected":""?>>PA</option>
								<option value="PB" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "PB")?"selected":""?>>PB</option>
								<option value="PE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "PE")?"selected":""?>>PE</option>
								<option value="PI" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "PI")?"selected":""?>>PI</option>
								<option value="PR" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "PR")?"selected":""?>>PR</option>
								<option value="RJ" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "RJ")?"selected":""?>>RJ</option>
								<option value="RO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "RO")?"selected":""?>>RO</option>
								<option value="RR" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "RR")?"selected":""?>>RR</option>
								<option value="RN" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "RN")?"selected":""?>>RN</option>
								<option value="RS" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "RS")?"selected":""?>>RS</option>
								<option value="SC" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "SC")?"selected":""?>>SC</option>
								<option value="SE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "SE")?"selected":""?>>SE</option>
								<option value="SP" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "SP")?"selected":""?>>SP</option>
								<option value="TO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) == "TO")?"selected":""?>>TO</option>
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
									$buscaCidades = mysql_query("SELECT * FROM `cidades` WHERE estado = '" . (($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosUsuario->estado) . "' AND deletado  = 'N' ORDER BY cidade ASC");
									
									// Traz Cidades
									while($trazCidades = mysql_fetch_object($buscaCidades)){
										
										?>
										<option value="<?php print($trazCidades->id); ?>" <?php print((((($_REQUEST["cidade"] != "")?$_REQUEST["cidade"]:$dadosUsuario->cidade) == $trazCidades->id)?"selected":""));?>><?php print($trazCidades->cidade); ?></option>
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
						<td align='left'><input type="text" name="cep" size="12" maxlength="9" onKeyUp="maskCEP(this, document.formUsuario.rg)" value="<?php echo (($_REQUEST["cep"] != "")?$_REQUEST["cep"]:$_ClassUtilitarios->formataCEP($dadosUsuario->cep))?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> R.G:</b></td>
						<td align='left'><input type="text" name="rg" size="15" value="<?php echo (($_REQUEST["rg"] != "")?$_REQUEST["rg"]:$dadosUsuario->rg)?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Orgão Expedidor:</b></td>
						<td align='left'><input type="text" name="orgexp" size="10" value="<?php echo (($_REQUEST["orgexp"] != "")?$_REQUEST["orgexp"]:$dadosUsuario->orgexp);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Data Expedição:</b></td>
						<td align='left'><input type="text" name="dataexp" size="12" maxlength="10" onKeyUp="maskData(this, document.formUsuario.cpf)" value="<?php echo (($_REQUEST["dataexp"] != "")?$_REQUEST["dataexp"]:$_ClassData->transformaData($dadosUsuario->dataexp, 2));?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> CPF:</b></td>
						<td align='left'><input type="text" name="cpf" size="18" maxlength="14" onKeyUp="maskCPF(this, document.formUsuario.telefonefixo)" value="<?php echo (($_REQUEST["cpf"] != "")?$_REQUEST["cpf"]:$_ClassUtilitarios->formataCPF($dadosUsuario->cpf))?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(**)</font> Telefone Fixo:</b></td>
						<td align='left'><input type="text" name="telefonefixo" size="25" value="<?php echo (($_REQUEST["telefonefixo"] != "")?$_REQUEST["telefonefixo"]:$dadosUsuario->telefonefixo);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(**)</font> Telefone Alternativo:</b></td>
						<td align='left'><input type="text" name="telefonealternativo" size="25" value="<?php echo (($_REQUEST["telefonealternativo"] != "")?$_REQUEST["telefonealternativo"]:$dadosUsuario->telefonealternativo);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> E-mail:</b></td>
						<td align='left'><input type="text" name="email" size="45" value="<?php echo (($_REQUEST["email"] != "")?$_REQUEST["email"]:$dadosUsuario->email);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Nível:</b></td>
						<td align='left'>
							<select name="nivel">
								<option value="95" <?php print((((($_REQUEST["nivel"] != "")?$_REQUEST["nivel"]:$dadosUsuario->nivel) == "95")?"selected":""));?>>Instrutor</option>							
								<option value="96" <?php print((((($_REQUEST["nivel"] != "")?$_REQUEST["nivel"]:$dadosUsuario->nivel) == "96")?"selected":""));?>>Secretária</option>
								<option value="97" <?php print((((($_REQUEST["nivel"] != "")?$_REQUEST["nivel"]:$dadosUsuario->nivel) == "97")?"selected":""));?>>Orientador</option>
								<option value="98" <?php print((((($_REQUEST["nivel"] != "")?$_REQUEST["nivel"]:$dadosUsuario->nivel) == "98")?"selected":""));?>>Coorenador</option>
								<option value="99" <?php print((((($_REQUEST["nivel"] != "")?$_REQUEST["nivel"]:$dadosUsuario->nivel) == "99")?"selected":""));?>>Administrador</option>
								<option value="100" <?php print((((($_REQUEST["nivel"] != "")?$_REQUEST["nivel"]:$dadosUsuario->nivel) == "100")?"selected":""));?>>Master</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(***)</font> Senha:</b></td>
						<td align='left'><input type="password" name="senha" size="15"><input type="hidden" name="senhaOri" value="<?php print($dadosUsuario->senha);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(***)</font> Confirmar Senha:</b></td>
						<td align='left'><input type="password" name="csenha" size="15"></td>
					</tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios<br>
							<font class="obrig"><b>(**)</b></font> - Campos Obrigatórios ou Optativos (Dependem de outros campos)<br>
							<font class="obrig"><b>(***)</b></font> - Utilize somente se quiser alterar
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