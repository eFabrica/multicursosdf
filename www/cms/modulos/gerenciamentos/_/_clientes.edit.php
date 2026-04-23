<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["razaosocial"], "É preciso informar a Razão Social."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["endereco"], "É preciso informar o Endereço."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["estado"], "É preciso informar o Estado."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cidades"], "É preciso informar a Cidae."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cnpj"], "É preciso informar o CNPJ."));
	if($_REQUEST["telefonefixo"] == "" && $_REQUEST["telefonealternativo"] == ""){$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["telefonealternativo"], "É preciso informar um Telefone."));}// Verifica Telefones
	
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
		
		// Verifica E-mail
		if($_REQUEST["email"] != "" && !$_ClassEmail->validaEmail($_REQUEST["email"])){$_ClassMensagens->setMensagem_erro("E-mail inválido.<br>");}
		
		// Verifica E-mail do Responsável
		if($_REQUEST["emailresponsavel"] != "" && !$_ClassEmail->validaEmail($_REQUEST["emailresponsavel"])){$_ClassMensagens->setMensagem_erro("E-mail do Responsável inválido.<br>");}
		
		// Verifica CPF do Responsável
		if($_REQUEST["cpf"] != "" && !$_ClassCpf->validaCPF($_REQUEST["cpf"])){$_ClassMensagens->setMensagem_erro("CPF do Responsável inválido.<br>");}
		
		// Verifica senha
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
	
		// Verifica se já existe este Cliente
		$_ClassRn->getDadosTable("clientes", "id", "id != '" . $_REQUEST["idRegistro"] . "' AND unidade = '" . $_dadosUnidade->id . "' AND cnpj = '" . $_REQUEST["cnpj"] . "'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Cliente já exite.<br>");
			
		}
			
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){		
		
		// Edita Clientes
		$editaCliente = $_ClassMysql->query("UPDATE `clientes` SET unidade = '" . $_dadosUnidade->id . "',
																   razaosocial = '" . $_REQUEST["razaosocial"] . "',
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
																   ultimoeditou = '" . $_dadosLogado->id . "',
															  	   datahorae = now() WHERE id = '" . $_REQUEST["idRegistro"] . "'");
		
		// Verifica se Editou
		if($editaCliente){
			
			// Sucesso
			$sucesso = true;
			
			// Verifica campos
			if($_REQUEST["responsavel"] != "" && $_REQUEST["cpf"] != "" && $_REQUEST["senha"] != ""){
				
				// Dados Usuário
				$dadosUsuario = $_ClassRn->getDadosTable("usuarios", "*", "unidade = '" . $_dadosUnidade->id . "' AND empresa = '" . $_REQUEST["idRegistro"] . "' AND deletado = 'N'");
				
				// Verifica total achado
				if($_ClassRn->getTot() <= 0){
				
					// Cadastra Usuário deste cliente
					$_ClassMysql->query("INSERT INTO `usuarios` SET unidade = '" . $_dadosUnidade->id . "',
																	empresa = '" . $_REQUEST["idRegistro"] . "',
																	nome = '" . $_REQUEST["responsavel"] . "',
																	cpf = '" . $_REQUEST["cpf"] . "',
																	senha = '" . md5($_REQUEST["senha"]) . "',
																	nivel = '94',
																	quemcriou = '" . $_dadosLogado->id . "',
															  	    datahorac = now()");
				}else{
					
					// Edita Usuário deste cliente
					$_ClassMysql->query("UPDATE `usuarios` SET nome = '" . $_REQUEST["responsavel"] . "',
															   cpf = '" . $_REQUEST["cpf"] . "',
															   " . (($_REQUEST["senha"] != "")?"senha = '" . md5($_REQUEST["senha"]) . "',":"") . "
															   ultimoeditou = '" . $_dadosLogado->id . "',
														  	   datahorae = now() WHERE id = '" . $dadosUsuario->id . "'");	
					
				}
					
			}
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Cliente gravado com sucesso!<br><br>[ <a href='?sessao=clientes&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "'>Voltar para a Listagem</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar este Cliente.<br>");
			
		}
		
	}
	
	?>
	<tr>
		<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}

// Verifica Sucesso
if(!$sucesso){
	
	// Dados do Cliente
	$dadosCliente = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $_REQUEST["idRegistro"] . "'");
	?>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formCliente">
				<input type="hidden" name="act" value="salvar">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td colspan="2" align="right">
							Criado por:
							<?php
							// Dados do Criador
							$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosCliente->quemcriou . "'");
							
							// Mostra
							print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosCliente->datahorac, 3) . "</b>");
							
							// Verifica se alguem edtou
							if($dadosCliente->ultimoeditou > 0){
								
								?>
								<br>Última edição feita por:
								<?php
								// Dados do Alterador
								$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosCliente->ultimoeditou . "'");
								
								// Mostra
								print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosCliente->datahorae, 3) . "</b>");
								
							}
							?>
						</td>
					</tr>
					<tr>
						<td align="right" width="15%"><b><font class="obrig">(*)</font> Razão Social:</b></td>
						<td width='85%' align='left'><input type="text" name="razaosocial" size="60" value="<?php echo (($_REQUEST["razaosocial"] != "")?$_REQUEST["razaosocial"]:$dadosCliente->razaosocial);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Nome Fantasia:</b></td>
						<td align="left"><input type="text" name="nomefantasia" size="40" value="<?php echo (($_REQUEST["nomefantasia"] != "")?$_REQUEST["nomefantasia"]:$dadosCliente->nomefantasia);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Endereço:</b></td>
						<td align="left"><input type="text" name="endereco" size="60" value="<?php echo (($_REQUEST["endereco"] != "")?$_REQUEST["endereco"]:$dadosCliente->endereco);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Estado</b></td>
						<td align="left">
							<select name="estado" onchange="carrega('cidades&uf='+this.options[this.selectedIndex].value)">
								<option value=""></option>
								<option value="AC" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "AC")?"selected":""?>>AC</option>
								<option value="AL" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "AL")?"selected":""?>>AL</option>
								<option value="AM" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "AM")?"selected":""?>>AM</option>
								<option value="AP" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "AP")?"selected":""?>>AP</option>
								<option value="BA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "BA")?"selected":""?>>BA</option>
								<option value="CE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "CE")?"selected":""?>>CE</option>
								<option value="DF" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "DF")?"selected":""?>>DF</option>
								<option value="ES" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "ES")?"selected":""?>>ES</option>
								<option value="GO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "GO")?"selected":""?>>GO</option>
								<option value="MA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "MA")?"selected":""?>>MA</option>
								<option value="MG" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "MG")?"selected":""?>>MG</option>
								<option value="MS" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "MS")?"selected":""?>>MS</option>
								<option value="MT" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "MT")?"selected":""?>>MT</option>
								<option value="PA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "PA")?"selected":""?>>PA</option>
								<option value="PB" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "PB")?"selected":""?>>PB</option>
								<option value="PE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "PE")?"selected":""?>>PE</option>
								<option value="PI" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "PI")?"selected":""?>>PI</option>
								<option value="PR" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "PR")?"selected":""?>>PR</option>
								<option value="RJ" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "RJ")?"selected":""?>>RJ</option>
								<option value="RO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "RO")?"selected":""?>>RO</option>
								<option value="RR" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "RR")?"selected":""?>>RR</option>
								<option value="RN" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "RN")?"selected":""?>>RN</option>
								<option value="RS" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "RS")?"selected":""?>>RS</option>
								<option value="SC" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "SC")?"selected":""?>>SC</option>
								<option value="SE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "SE")?"selected":""?>>SE</option>
								<option value="SP" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "SP")?"selected":""?>>SP</option>
								<option value="TO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) == "TO")?"selected":""?>>TO</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Cidade:</b></td>
						<td align="left">
							<div id="main">
								<select name="cidades">
									<option value="">&nbsp;</option>
									<?php
									// Busca Cidades
									$buscaCidades = mysql_query("SELECT * FROM `cidades` WHERE estado = '" . (($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCliente->estado) . "' AND deletado = 'N' ORDER BY cidade ASC");
									
									// Traz Cidades
									while($trazCidades = mysql_fetch_object($buscaCidades)){
										
										?>
										<option value="<?php print($trazCidades->id); ?>" <?php print((((($_REQUEST["cidade"] != "")?$_REQUEST["cidade"]:$dadosCliente->cidade) == $trazCidades->id)?"selected":""));?>><?php print($trazCidades->cidade); ?></option>
										<?php
										
									}												
									?>
								</select>
							</div>
							<div id="loading"></div>
						</td>
					</tr>
					<tr>
						<td align="right"><b>CEP:</b></td>
						<td align="left"><input type="text" name="cep" size="12" maxlength="9" onKeyUp="maskCEP(this, document.formCliente.cnpj)" value="<?php echo (($_REQUEST["cep"] != "")?$_REQUEST["cep"]:$_ClassUtilitarios->formataCEP($dadosCliente->cep)); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> CNPJ:</b></td>
						<td align="left"><input type="text" name="cnpj" size="22" maxlength="18" onKeyUp="maskCNPJ(this, document.formCliente.ie)" value="<?php echo (($_REQUEST["cnpj"] != "")?$_REQUEST["cnpj"]:$_ClassUtilitarios->formataCNPJ($dadosCliente->cnpj)); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b>I.E:</b></td>
						<td align="left"><input type="text" name="ie" size="30" value="<?php echo (($_REQUEST["ie"] != "")?$_REQUEST["ie"]:$dadosCliente->ie); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(**)</font> Telefone Fixo:</b></td>
						<td align="left"><input type="text" name="telefonefixo" size="25" value="<?php echo (($_REQUEST["telefonefixo"] != "")?$_REQUEST["telefonefixo"]:$dadosCliente->telefonefixo); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(**)</font> Telefone Alternativo:</b></td>
						<td align="left"><input type="text" name="telefonealternativo" size="25" value="<?php echo (($_REQUEST["telefonealternativo"] != "")?$_REQUEST["telefonealternativo"]:$dadosCliente->telefonealternativo); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b>FAX:</b></td>
						<td align="left"><input type="text" name="fax" size="25" value="<?php echo (($_REQUEST["fax"] != "")?$_REQUEST["fax"]:$dadosCliente->fax); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b>E-mail:</b></td>
						<td align="left"><input type="text" name="email" size="50" value="<?php echo (($_REQUEST["email"] != "")?$_REQUEST["email"]:$dadosCliente->email); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(***)</font> Responsável:</b></td>
						<td align="left"><input type="text" name="responsavel" size="45" value="<?php echo (($_REQUEST["responsavel"] != "")?$_REQUEST["responsavel"]:$dadosCliente->responsavel); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(***)</font> CPF:</b></td>
						<td align="left"><input type="text" name="cpf" size="18" maxlength="14" onKeyUp="maskCPF(this, document.formCliente.senha)" value="<?php echo (($_REQUEST["cpf"] != "")?$_REQUEST["cpf"]:$_ClassUtilitarios->formataCPF($dadosCliente->cpfresponsavel)); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(***)</font>Nova Senha:</b></td>
						<td align="left"><input type="password" name="senha" size="20">Utilize somente se for alterar.</td>
					</tr>
					<tr>
						<td align="right"><b>E-mail Resp.:</b></td>
						<td align="left"><input type="text" name="emailresponsavel" size="60" value="<?php echo (($_REQUEST["emailresponsavel"] != "")?$_REQUEST["emailresponsavel"]:$dadosCliente->emailresponsavel); ?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Telefone Resp.:</b></td>
						<td align="left"><input type="text" name="telefoneresponsavel" size="25" value="<?php echo (($_REQUEST["telefoneresponsavel"] != "")?$_REQUEST["telefoneresponsavel"]:$dadosCliente->telefoneresponsavel); ?>"></td>
					</tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios<br>
							<font class="obrig"><b>(**)</b></font> - Campos Obrigatórios ou Optativos (Dependem de outros campos)<br>
							<font class="obrig"><b>(***)</b></font> - Campos necessário para que seja criado o login deste cliente, para que ele acesse seu painel de controle. (não obrigatórios)
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
?>