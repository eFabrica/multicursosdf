<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["nome"], "Informe o Nome."));		

	//$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["datanascimento"], "é preciso informar a Data de Nascimento."));
	//$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["rg"], "é preciso informar o R.G."));
	//$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cpf"], "é preciso informar o CPF."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
	
		// Verifica se foi informado a data de nascimento
		if($_REQUEST["datanascimento"] != ""){
		
			// Explode data e atribui as variáveis.
			list($dia, $mes, $ano) = explode("/", $_REQUEST["datanascimento"]);
			
			// Novo formato da data
			$data = $ano . "-" . $mes . "-" . $dia;
			
			// Verifica Data de Nascimento
			if(((strtotime("now")-strtotime($data))/31536000) <= 18){
				
				// Seta Erro
				$_ClassMensagens->setMensagem_erro("É preciso ter idade maior que 18 anos.<br>");
				
			}
			
		}
	
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Classe de Data
		require_once($pathInc . "lib/Data.class.php");
		
		// Classe de CPF
		require_once($pathInc . "lib/Cpf.class.php");
		
		// Classe de E-mail
		require_once($pathInc . "lib/Email.class.php");
		
		// Verifica Data de Nascimento
		if($_REQUEST["datanascimento"] != "" && !$_ClassData->validaData($_REQUEST["datanascimento"])){$_ClassMensagens->setMensagem_erro("Data de Nascimento inválida.<br>");}
		
		// Valida CPF do aluno
		if($_REQUEST["cpf"] != "" && !$_ClassCpf->validaCPF($_REQUEST["cpf"])){$_ClassMensagens->setMensagem_erro("CPF do Aluno inválido.<br>");}
		
		// Valida E-mail do Aluno
		if($_REQUEST["email"] != "" && !$_ClassEmail->validaEmail($_REQUEST["email"])){$_ClassMensagens->setMensagem_erro("E-mail inválido.<br>");}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica se informou algum cpf
		if($_REQUEST["cpf"] != ""){
			
			// Busca Cpf no banco
			$buscaAlunos = $_ClassMysql->query("SELECT * FROM `alunos` WHERE deletado = 'N' AND cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpf"]) . "'");
			
			// Verifica o total achado
			if(mysql_num_rows($buscaAlunos) > 0){
				
				// Seta Erro
				$_ClassMensagens->setMensagem_erro("O cpf inforamdo já consta no sistema.<br>");
				
			}
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Grava na Sessão o tipo
		$_SESSION["aluno"]["tipo"] = $_REQUEST["tipo"];

		$dataNascimento = $_REQUEST["datanascimento"] == "" ? '0000-00-00' : $_ClassData->transformaData($_REQUEST["datanascimento"]);
		$sexo = $_REQUEST["sexo"] == "" ? 'M' : $_REQUEST["sexo"];
		$dataExepdicao = $_REQUEST["dataexp"] == "" ? '0000-00-00' : $_ClassData->transformaData($_REQUEST["dataexp"]);
		$cidade = $_REQUEST["cidades"] == "" ? '0' : $_REQUEST["cidades"];
		
		// Cadastra Aluno
		$cadastraAluno = $_ClassMysql->query("INSERT INTO `alunos` SET   unidade = '" . $_dadosUnidade->id . "',
																		 numerorg = '" . $_REQUEST["numerorg"] . "',
																	  	 academiaform = '" . strtoupper($_REQUEST["academiaform"]) . "',
																	  	 dataform = '0000-00-00',
																	  	 livro = '" . strtoupper($_REQUEST["livro"]) . "',
																	  	 folha = '" . strtoupper($_REQUEST["folha"]) . "',
																	  	 orgao = '" . strtoupper($_REQUEST["orgao"]) . "',
																	  	 nome = '" . strtoupper($_REQUEST["nome"]) . "',
																	  	 datanascimento = '" . $dataNascimento . "',
																	  	 pai = '" . strtoupper($_REQUEST["pai"]) . "',
																  	 	 mae = '" . strtoupper($_REQUEST["mae"]) . "',
																	  	 cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpf"]) . "',
																	  	 sexo = '" . $sexo . "',
																	  	 naturalidade = '" . $_REQUEST["naturalidade"] . "',
																	  	 ufnaturalidade = '" . $_REQUEST["ufnaturalidade"] . "',
																	  	 rg = '" . $_ClassUtilitarios->deixaN($_REQUEST["rg"]) . "',
																	  	 orgexp = '" . $_REQUEST["orgexp"] . "',
																		 dataexp = '0000-00-00',
																	  	 endereco = '" . strtoupper($_REQUEST["endereco"]) . "',
																	  	 bairro = '" . strtoupper($_REQUEST["bairro"]) . "',
																	  	 cidade = '" . $cidade . "',
																	  	 estado = '" . $_REQUEST["estado"] . "',
																	  	 cep = '" . $_ClassUtilitarios->deixaN($_REQUEST["cep"]) . "',
																	  	 telefone = '" . $_REQUEST["telefone"] . "',
																	  	 email = '" . $_REQUEST["email"] . "',
																	  	 quemcriou = '" . $_dadosLogado->id . "',
										   							  	 datahorac = now()");
			
		// Verifica se Cadastrou
		if($cadastraAluno){
			
			// Id do Aluno
			$idAluno = mysql_insert_id();
			
			// Sucesso
			$sucesso = true;
			
			// Redireciona
			print($_ClassUtilitarios->redirecionarJS("?sessao=alunos&ref=sucesso&idAluno=" . $idAluno));
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("não foi poss�vel gravar este Aluno.<br>");
			
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
	?>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formAluno">
				<input type="hidden" name="act" value="salvar">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
					<tr>
						<td align="right" width="15%"><b><font class="obrig">(*)</font> Tipo:</b></td>
						<td width='85%' align='left'>
							<input type="radio" name="tipo" value="P" <?php print((($_REQUEST["tipo"] == "P")?"checked":(($_REQUEST["tipo"] == "")?"checked":"")));?>>Privado
							<input type="radio" name="tipo" value="E" <?php print((($_REQUEST["tipo"] == "E")?"checked":""));?>>Empresa
						</td>
				 	</tr>
					<tr>
						<td align="right" width="15%"><b><font class="obrig">(*)</font> Nome:</b></td>
						<td width='85%' align='left'><input type="text" name="nome" size="50" value="<?php echo $_REQUEST["nome"]?>"></td>
				 	</tr>
				 	<tr>
						<td align="right"><b>Data Nascimento:</b></td>
						<td align="left"><input type="text" id="datanascimento" name="datanascimento" size="12" onKeyUp="maskData(this, document.formAluno.cpf)" value="<?php echo $_REQUEST["datanascimento"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b>CPF:</b></td>
						<td align="left"><input type="text" id="cpf" name="cpf" size="18" maxlength="14" onKeyUp="maskCPF(this, document.formAluno.rg)" value="<?php echo $_REQUEST["cpf"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b>R.G:</b></td>
						<td align="left"><input type="text" id="rg" name="rg" size="15" value="<?php echo $_REQUEST["rg"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Org&atilde;o Expedidor:</b></td>
						<td align="left"><input type="text" name="orgexp" size="10" value="<?php echo $_REQUEST["orgexp"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Data Expedi&ccedil;&atilde;o:</b></td>
						<td align="left"><input type="text" id="dataexp" name="dataexp" size="12" onKeyUp="maskData(this, document.formAluno.sexo)" value="<?php echo $_REQUEST["dataexp"]?>"></td>
					</tr>
				 	<tr>
				 		<td align="right"><b>Sexo:</b></td>
				 		<td align="left">
				 			<select name="sexo">
				 				<option></option>
				 				<option value="M" <?php print((($_REQUEST["sexo"] == "M")?"selected":""));?>>Masculino</option>
				 				<option value="F" <?php print((($_REQUEST["sexo"] == "F")?"selected":""));?>>Feminino</option>
				 			</select>
				 		</td>
				 	</tr>
					<tr>
						<td align="right"><b>Naturalidade:</b></td>
						<td align="left">
							<input type="text" name="naturalidade" size="40" value="<?php echo $_REQUEST["naturalidade"]?>">
							<select name="ufnaturalidade">
								<option value=""></option>
								<option value="AC" <?php echo ($_REQUEST["ufnaturalidade"] == "AC")?"selected":""?>>AC</option>
								<option value="AL" <?php echo ($_REQUEST["ufnaturalidade"] == "AL")?"selected":""?>>AL</option>
								<option value="AM" <?php echo ($_REQUEST["ufnaturalidade"] == "AM")?"selected":""?>>AM</option>
								<option value="AP" <?php echo ($_REQUEST["ufnaturalidade"] == "AP")?"selected":""?>>AP</option>
								<option value="BA" <?php echo ($_REQUEST["ufnaturalidade"] == "BA")?"selected":""?>>BA</option>
								<option value="CE" <?php echo ($_REQUEST["ufnaturalidade"] == "CE")?"selected":""?>>CE</option>
								<option value="DF" <?php echo ($_REQUEST["ufnaturalidade"] == "DF")?"selected":""?>>DF</option>
								<option value="ES" <?php echo ($_REQUEST["ufnaturalidade"] == "ES")?"selected":""?>>ES</option>
								<option value="GO" <?php echo ($_REQUEST["ufnaturalidade"] == "GO")?"selected":""?>>GO</option>
								<option value="MA" <?php echo ($_REQUEST["ufnaturalidade"] == "MA")?"selected":""?>>MA</option>
								<option value="MG" <?php echo ($_REQUEST["ufnaturalidade"] == "MG")?"selected":""?>>MG</option>
								<option value="MS" <?php echo ($_REQUEST["ufnaturalidade"] == "MS")?"selected":""?>>MS</option>
								<option value="MT" <?php echo ($_REQUEST["ufnaturalidade"] == "MT")?"selected":""?>>MT</option>
								<option value="PA" <?php echo ($_REQUEST["ufnaturalidade"] == "PA")?"selected":""?>>PA</option>
								<option value="PB" <?php echo ($_REQUEST["ufnaturalidade"] == "PB")?"selected":""?>>PB</option>
								<option value="PE" <?php echo ($_REQUEST["ufnaturalidade"] == "PE")?"selected":""?>>PE</option>
								<option value="PI" <?php echo ($_REQUEST["ufnaturalidade"] == "PI")?"selected":""?>>PI</option>
								<option value="PR" <?php echo ($_REQUEST["ufnaturalidade"] == "PR")?"selected":""?>>PR</option>
								<option value="RJ" <?php echo ($_REQUEST["ufnaturalidade"] == "RJ")?"selected":""?>>RJ</option>
								<option value="RO" <?php echo ($_REQUEST["ufnaturalidade"] == "RO")?"selected":""?>>RO</option>
								<option value="RR" <?php echo ($_REQUEST["ufnaturalidade"] == "RR")?"selected":""?>>RR</option>
								<option value="RN" <?php echo ($_REQUEST["ufnaturalidade"] == "RN")?"selected":""?>>RN</option>
								<option value="RS" <?php echo ($_REQUEST["ufnaturalidade"] == "RS")?"selected":""?>>RS</option>
								<option value="SC" <?php echo ($_REQUEST["ufnaturalidade"] == "SC")?"selected":""?>>SC</option>
								<option value="SE" <?php echo ($_REQUEST["ufnaturalidade"] == "SE")?"selected":""?>>SE</option>
								<option value="SP" <?php echo ($_REQUEST["ufnaturalidade"] == "SP")?"selected":""?>>SP</option>
								<option value="TO" <?php echo ($_REQUEST["ufnaturalidade"] == "TO")?"selected":""?>>TO</option>
							</select>	
						</td>
					</tr>
					<tr>
						<td align="right"><b>Pai:</b></td>
						<td align="left"><input type="text" name="pai" size="50" value="<?php echo $_REQUEST["pai"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b>M&atilde;e:</b></td>
						<td align="left"><input type="text" name="mae" size="50" value="<?php echo $_REQUEST["mae"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b>E-mail:</b></td>
						<td align="left"><input type="text" name="email" size="45" value="<?php echo $_REQUEST["email"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Telefone:</b></td>
						<td align="left"><input type="text" name="telefone" size="25" value="<?php echo $_REQUEST["telefone"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Endere&ccedil;o:</b></td>
						<td align="left"><input type="text" name="endereco" size="50" value="<?php echo $_REQUEST["endereco"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Bairro:</b></td>
						<td align="left"><input type="text" name="bairro" size="30" value="<?php echo $_REQUEST["bairro"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Estado</b></td>
						<td align="left">
							<select name="estado" onChange="carrega('cidades&uf='+this.options[this.selectedIndex].value)">
								<option value=""></option>
								<option value="AC" <?php echo ($_REQUEST["estado"] == "AC")?"selected":""?>>AC</option>
								<option value="AL" <?php echo ($_REQUEST["estado"] == "AL")?"selected":""?>>AL</option>
								<option value="AM" <?php echo ($_REQUEST["estado"] == "AM")?"selected":""?>>AM</option>
								<option value="AP" <?php echo ($_REQUEST["estado"] == "AP")?"selected":""?>>AP</option>
								<option value="BA" <?php echo ($_REQUEST["estado"] == "BA")?"selected":""?>>BA</option>
								<option value="CE" <?php echo ($_REQUEST["estado"] == "CE")?"selected":""?>>CE</option>
								<option value="DF" <?php echo ($_REQUEST["estado"] == "DF")?"selected":""?>>DF</option>
								<option value="ES" <?php echo ($_REQUEST["estado"] == "ES")?"selected":""?>>ES</option>
								<option value="GO" <?php echo ($_REQUEST["estado"] == "GO")?"selected":""?>>GO</option>
								<option value="MA" <?php echo ($_REQUEST["estado"] == "MA")?"selected":""?>>MA</option>
								<option value="MG" <?php echo ($_REQUEST["estado"] == "MG")?"selected":""?>>MG</option>
								<option value="MS" <?php echo ($_REQUEST["estado"] == "MS")?"selected":""?>>MS</option>
								<option value="MT" <?php echo ($_REQUEST["estado"] == "MT")?"selected":""?>>MT</option>
								<option value="PA" <?php echo ($_REQUEST["estado"] == "PA")?"selected":""?>>PA</option>
								<option value="PB" <?php echo ($_REQUEST["estado"] == "PB")?"selected":""?>>PB</option>
								<option value="PE" <?php echo ($_REQUEST["estado"] == "PE")?"selected":""?>>PE</option>
								<option value="PI" <?php echo ($_REQUEST["estado"] == "PI")?"selected":""?>>PI</option>
								<option value="PR" <?php echo ($_REQUEST["estado"] == "PR")?"selected":""?>>PR</option>
								<option value="RJ" <?php echo ($_REQUEST["estado"] == "RJ")?"selected":""?>>RJ</option>
								<option value="RO" <?php echo ($_REQUEST["estado"] == "RO")?"selected":""?>>RO</option>
								<option value="RR" <?php echo ($_REQUEST["estado"] == "RR")?"selected":""?>>RR</option>
								<option value="RN" <?php echo ($_REQUEST["estado"] == "RN")?"selected":""?>>RN</option>
								<option value="RS" <?php echo ($_REQUEST["estado"] == "RS")?"selected":""?>>RS</option>
								<option value="SC" <?php echo ($_REQUEST["estado"] == "SC")?"selected":""?>>SC</option>
								<option value="SE" <?php echo ($_REQUEST["estado"] == "SE")?"selected":""?>>SE</option>
								<option value="SP" <?php echo ($_REQUEST["estado"] == "SP")?"selected":""?>>SP</option>
								<option value="TO" <?php echo ($_REQUEST["estado"] == "TO")?"selected":""?>>TO</option>
							</select>								
						</td>
					</tr>
					<tr>
						<td align="right"><b>Cidade:</b></td>
						<td align="left">
							<div id="main">
								<select name="cidades">
									<option value="">&nbsp;</option>
									<?php
									// Verifica Ação
									if($_REQUEST["act"] == "salvar"){
									
										// Busca Cidades
										$buscaCidades = mysql_query("SELECT * FROM `cidades` WHERE estado = '" . $_REQUEST["estado"] . "' AND deletado  = 'N' ORDER BY cidade ASC");
										
										// Traz Cidades
										while($trazCidades = mysql_fetch_object($buscaCidades)){
											
											?>
											<option value="<?php print($trazCidades->id); ?>" <?php print((($_REQUEST["cidades"] == $trazCidades->id)?"selected":""));?>><?php print($trazCidades->cidade); ?></option>
											<?php
											
										}
										
									}
									?>
								</select>
							</div>
							<div id="loading"></div>
						</td>
					</tr>					
					<tr>
						<td align="right"><b>CEP:</b></td>
						<td align="left"><input type="text" id="cep" name="cep" size="12" maxlength="9" value="<?php echo $_REQUEST["cep"]?>"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><b><font class="obrig">(***)</font> Academia&nbsp;Forma&ccedil;&atilde;o:</b></td>
						<td align="left"><input type="text" size="50" name="academiaform" value="<?php print($_REQUEST["academiaform"]);?>"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><b><font class="obrig">(***)</font> N&uacute;mero&nbsp;Registro:</b></td>
						<td align="left"><input type="text" size="15" name="numerorg" value="<?php print($_REQUEST["numerorg"]);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(***)</font> Data Forma&ccedil;&atilde;o:</b></td>
						<td align="left"><input type="text" id="dataform" name="dataform" size="12" onKeyUp="maskData(this, document.formAluno.livro)" maxlength="10" value="<?php echo $_REQUEST["dataform"]?>"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><b><font class="obrig">(***)</font> Livro:</b></td>
						<td align="left"><input type="text" size="20" name="livro" value="<?php print($_REQUEST["livro"]);?>"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><b><font class="obrig">(***)</font> Folha:</b></td>
						<td align="left"><input type="text" size="5" name="folha" value="<?php print($_REQUEST["folha"]);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(***)</font> Org&atilde;o</b></td>
						<td align="left">
							<select name="orgao">
								<option value=""></option>
								<option value="AC" <?php echo ($_REQUEST["orgao"] == "AC")?"selected":""?>>AC</option>
								<option value="AL" <?php echo ($_REQUEST["orgao"] == "AL")?"selected":""?>>AL</option>
								<option value="AM" <?php echo ($_REQUEST["orgao"] == "AM")?"selected":""?>>AM</option>
								<option value="AP" <?php echo ($_REQUEST["orgao"] == "AP")?"selected":""?>>AP</option>
								<option value="BA" <?php echo ($_REQUEST["orgao"] == "BA")?"selected":""?>>BA</option>
								<option value="CE" <?php echo ($_REQUEST["orgao"] == "CE")?"selected":""?>>CE</option>
								<option value="DF" <?php echo ($_REQUEST["orgao"] == "DF")?"selected":""?>>DF</option>
								<option value="ES" <?php echo ($_REQUEST["orgao"] == "ES")?"selected":""?>>ES</option>
								<option value="GO" <?php echo ($_REQUEST["orgao"] == "GO")?"selected":""?>>GO</option>
								<option value="MA" <?php echo ($_REQUEST["orgao"] == "MA")?"selected":""?>>MA</option>
								<option value="MG" <?php echo ($_REQUEST["orgao"] == "MG")?"selected":""?>>MG</option>
								<option value="MS" <?php echo ($_REQUEST["orgao"] == "MS")?"selected":""?>>MS</option>
								<option value="MT" <?php echo ($_REQUEST["orgao"] == "MT")?"selected":""?>>MT</option>
								<option value="PA" <?php echo ($_REQUEST["orgao"] == "PA")?"selected":""?>>PA</option>
								<option value="PB" <?php echo ($_REQUEST["orgao"] == "PB")?"selected":""?>>PB</option>
								<option value="PE" <?php echo ($_REQUEST["orgao"] == "PE")?"selected":""?>>PE</option>
								<option value="PI" <?php echo ($_REQUEST["orgao"] == "PI")?"selected":""?>>PI</option>
								<option value="PR" <?php echo ($_REQUEST["orgao"] == "PR")?"selected":""?>>PR</option>
								<option value="RJ" <?php echo ($_REQUEST["orgao"] == "RJ")?"selected":""?>>RJ</option>
                                <option value="RN" <?php echo ($_REQUEST["orgao"] == "RN")?"selected":""?>>RN</option>
								<option value="RO" <?php echo ($_REQUEST["orgao"] == "RO")?"selected":""?>>RO</option>
								<option value="RR" <?php echo ($_REQUEST["orgao"] == "RR")?"selected":""?>>RR</option>
								<option value="RS" <?php echo ($_REQUEST["orgao"] == "RS")?"selected":""?>>RS</option>
								<option value="SC" <?php echo ($_REQUEST["orgao"] == "SC")?"selected":""?>>SC</option>
								<option value="SE" <?php echo ($_REQUEST["orgao"] == "SE")?"selected":""?>>SE</option>
								<option value="SP" <?php echo ($_REQUEST["orgao"] == "SP")?"selected":""?>>SP</option>
								<option value="TO" <?php echo ($_REQUEST["orgao"] == "TO")?"selected":""?>>TO</option>
							</select>								
						</td>
					</tr>
					<tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigat&oacute;rios<Br>
							<font class="obrig"><b>(**)</b></font> - Caso este aluno esteja associado � alguma empresa.<Br>
							<font class="obrig"><b>(***)</b></font> - Dados complementares. Preencher somente se forem informados pelo aluno.<Br>
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