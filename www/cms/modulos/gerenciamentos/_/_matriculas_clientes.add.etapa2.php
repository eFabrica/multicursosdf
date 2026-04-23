<tr>
	<td style='height:5px';>&nbsp;</td>
</tr>
<?php require_once("php7_mysql_shim.php");
// Adiciona Classe de CPF
require_once($pathInc . "lib/Cpf.class.php");

// Adiciona Classe de E-mail
require_once($pathInc . "lib/Email.class.php");

// Verifica se foi selecionado algum aluno
if($_SESSION["matricula"]["idAluno"] > 0){
	
	// Verifica Ação
	if($_REQUEST["act"] == "salvar"){
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);
		
		// Verifica Campo
		$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["nome"], "é preciso informar o Nome."));
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
				if(((strtotime("now")-strtotime($data))/31536000) <= 21){
					
					// Seta Erro
					$_ClassMensagens->setMensagem_erro("é preciso ter idade maior que 21 anos.<br>");
					
				}
				
			}
		
		}
		
		// Verifica se tem erro
		if($_ClassMensagens->getMensagem_erro() == ""){
				
			// Verifica Data de Nascimento
			if($_REQUEST["datanascimento"] != "" && !$_ClassData->validaData($_REQUEST["datanascimento"])){$_ClassMensagens->setMensagem_erro("Data de Nascimento inválida.<br>");}
			
			// Valida CPF do aluno
			if($_REQUEST["cpf"] != "" && !$_ClassCpf->validaCPF($_REQUEST["cpf"])){$_ClassMensagens->setMensagem_erro("CPF do Aluno inválido.<br>");}
			
			// Valida E-mail do Aluno
			if($_REQUEST["email"] != "" && !$_ClassEmail->validaEmail($_REQUEST["email"])){$_ClassMensagens->setMensagem_erro("E-mail inválido.<br>");}
			
		}
		
		// Verifica se tem erro
		if($_ClassMensagens->getMensagem_erro() == ""){
			
			// Limpa CPF
			$_REQUEST["cpf"] = preg_replace("/[\.-]/", "", $_REQUEST["cpf"]);
			
			// Limpa CEP
			$_REQUEST["cep"] = preg_replace("/[\.-]/", "", $_REQUEST["cep"]);
			
			// Verifica se o cpf foi informado
			if($_REQUEST["cpf"] != ""){
			
				// Verifica se já existe este aluno
				$_ClassRn->getDadosTable("alunos", "id", "id != '" . $_SESSION["matricula"]["idAluno"] . "' AND cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpf"]) . "' AND deletado = 'N'");
			
				// Verifica o total achado
				if($_ClassRn->getTot() > 0){
					
					// Seta Erro
					$_ClassMensagens->setMensagem_erro("Aluno já exite.<br>");
					
				}
				
			}
			
		}
		
		// Verifica se tem erro
		if($_ClassMensagens->getMensagem_erro() == ""){

			$cidade = $_REQUEST["cidades"] == "" ? '0' : $_REQUEST["cidades"];
			$dataNascimento = $_REQUEST["datanascimento"] == "" ? '0000-00-00' : $_ClassData->transformaData($_REQUEST["datanascimento"]);
			$sexo = $_REQUEST["sexo"] == "" ? 'M' : $_REQUEST["sexo"];
			
			// Edita Aluno
			$editaAluno = $_ClassMysql->query("UPDATE `alunos` SET numerorg = '" . $_REQUEST["numerorg"] . "',
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
															  	   rg = '" . $_REQUEST["rg"] . "',
															  	   orgexp = '" . $_REQUEST["orgexp"] . "',
															  	   dataexp = '0000-00-00',
															  	   endereco = '" . strtoupper($_REQUEST["endereco"]) . "',
															  	   bairro = '" . strtoupper($_REQUEST["bairro"]) . "',
															  	   cidade = '" . $cidade . "',
															  	   estado = '" . $_REQUEST["estado"] . "',
															  	   cep = '" . $_REQUEST["cep"] . "',
															  	   telefone = '" . $_REQUEST["telefone"] . "',
															  	   email = '" . $_REQUEST["email"] . "',
															  	   ultimoeditou = '" . $_dadosLogado->id . "',
								   							  	   datahorae = now() WHERE id = '" . $_SESSION["matricula"]["idAluno"] . "'");
			
			// Verifica se Editou
			if($editaAluno){
				
				// Redireciona
				print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=novo&etapa=3"));
				
			}else{
				
				// Seta Erro
				$_ClassMensagens->setMensagem_erro("não foi poss�vel gravar este Aluno.<br>");
				
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
	
	// Dados do Aluno
	$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $_SESSION["matricula"]["idAluno"] . "'");
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formMatricula">
				<input type="hidden" name="act" value="salvar">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
					<tr>
						<td align="right" width="15%"><b><font class="obrig">(*)</font> Nome:</b></td>
						<td width='85%' align='left'><input type="text" name="nome" size="50" value="<?php echo (($_REQUEST["nome"] != "")?$_REQUEST["nome"]:$dadosAluno->nome);?>"></td>
				 	</tr>
				 	<tr>
						<td align="right"><b> Data Nascimento:</b></td>
						<td align='left'><input type="text" name="datanascimento" size="12" maxlength="10" onKeyUp="maskData(this, document.formAluno.cpf)" value="<?php echo (($_REQUEST["datanascimento"] != "")?$_REQUEST["datanascimento"]:$_ClassData->transformaData($dadosAluno->datanascimento, 2));?>"></td>
					</tr>
					<tr>
						<td align="right"><b>CPF:</b></td>
						<td align='left'><input type="text" name="cpf" size="18" maxlength="14" onKeyUp="maskCPF(this, document.formAluno.rg)" value="<?php echo (($_REQUEST["cpf"] != "")?$_REQUEST["cpf"]:$_ClassUtilitarios->formataCPF($dadosAluno->cpf));?>"></td>
					</tr>
					<tr>
						<td align="right"><b>R.G:</b></td>
						<td align='left'><input type="text" name="rg" size="15" value="<?php echo (($_REQUEST["rg"] != "")?$_REQUEST["rg"]:$dadosAluno->rg);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Org&atilde;o Expedidor:</b></td>
						<td align='left'><input type="text" name="orgexp" size="10" value="<?php echo (($_REQUEST["orgexp"] != "")?$_REQUEST["orgexp"]:$dadosAluno->orgexp);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Data Expedi&ccedil;&atilde;o:</b></td>
						<td align='left'><input type="text" name="dataexp" size="12" maxlength="10" onKeyUp="maskData(this, document.formAluno.sexo)" value="<?php echo (($_REQUEST["dataexp"] != "")?$_REQUEST["dataexp"]:$_ClassData->transformaData($dadosAluno->dataexp, 2));?>"></td>
					</tr>
				 	<tr>
				 		<td align="right"><b>Sexo:</b></td>
				 		<td align='left'>
				 			<select name="sexo">
				 				<option></option>
				 				<option value="M" <?php print((((($_REQUEST["sexo"] != "")?$_REQUEST["sexo"]:$dadosAluno->sexo) == "M")?"selected":""));?>>Masculino</option>
				 				<option value="F" <?php print((((($_REQUEST["sexo"] != "")?$_REQUEST["sexo"]:$dadosAluno->sexo) == "F")?"selected":""));?>>Feminino</option>
				 			</select>
				 		</td>
				 	</tr>
					<tr>
						<td align="right"><b> Naturalidade:</b></td>
						<td align='left'>
							<input type="text" name="naturalidade" size="40" value="<?php echo (($_REQUEST["naturalidade"] != "")?$_REQUEST["naturalidade"]:$dadosAluno->naturalidade);?>">
							<select name="ufnaturalidade">
								<option value=""></option>
								<option value="AC" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "AC")?"selected":""?>>AC</option>
								<option value="AL" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "AL")?"selected":""?>>AL</option>
								<option value="AM" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "AM")?"selected":""?>>AM</option>
								<option value="AP" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "AP")?"selected":""?>>AP</option>
								<option value="BA" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "BA")?"selected":""?>>BA</option>
								<option value="CE" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "CE")?"selected":""?>>CE</option>
								<option value="DF" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "DF")?"selected":""?>>DF</option>
								<option value="ES" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "ES")?"selected":""?>>ES</option>
								<option value="GO" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "GO")?"selected":""?>>GO</option>
								<option value="MA" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "MA")?"selected":""?>>MA</option>
								<option value="MG" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "MG")?"selected":""?>>MG</option>
								<option value="MS" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "MS")?"selected":""?>>MS</option>
								<option value="MT" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "MT")?"selected":""?>>MT</option>
								<option value="PA" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "PA")?"selected":""?>>PA</option>
								<option value="PB" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "PB")?"selected":""?>>PB</option>
								<option value="PE" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "PE")?"selected":""?>>PE</option>
								<option value="PI" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "PI")?"selected":""?>>PI</option>
								<option value="PR" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "PR")?"selected":""?>>PR</option>
								<option value="RJ" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "RJ")?"selected":""?>>RJ</option>
								<option value="RO" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "RO")?"selected":""?>>RO</option>
								<option value="RR" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "RR")?"selected":""?>>RR</option>
								<option value="RN" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "RN")?"selected":""?>>RN</option>
								<option value="RS" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "RS")?"selected":""?>>RS</option>
								<option value="SC" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "SC")?"selected":""?>>SC</option>
								<option value="SE" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "SE")?"selected":""?>>SE</option>
								<option value="SP" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "SP")?"selected":""?>>SP</option>
								<option value="TO" <?php echo ((($_REQUEST["ufnaturalidade"] != "")?$_REQUEST["ufnaturalidade"]:$dadosAluno->ufnaturalidade) == "TO")?"selected":""?>>TO</option>
							</select>	
						</td>
					</tr>
					<tr>
						<td align="right"><b>Pai:</b></td>
						<td align='left'><input type="text" name="pai" size="50" value="<?php echo (($_REQUEST["pai"] != "")?$_REQUEST["pai"]:$dadosAluno->pai);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>M&atilde;e:</b></td>
						<td align='left'><input type="text" name="mae" size="50" value="<?php echo (($_REQUEST["mae"] != "")?$_REQUEST["mae"]:$dadosAluno->mae);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>E-mail:</b></td>
						<td align='left'><input type="text" name="email" size="45" value="<?php echo (($_REQUEST["email"] != "")?$_REQUEST["email"]:$dadosAluno->email);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Telefone:</b></td>
						<td align='left'><input type="text" name="telefone" size="25" value="<?php echo (($_REQUEST["telefone"] != "")?$_REQUEST["telefone"]:$dadosAluno->telefone);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Endere&ccedil;o:</b></td>
						<td align='left'><input type="text" name="endereco" size="50" value="<?php echo (($_REQUEST["endereco"] != "")?$_REQUEST["endereco"]:$dadosAluno->endereco);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Bairro:</b></td>
						<td align='left'><input type="text" name="bairro" size="30" value="<?php echo (($_REQUEST["bairro"] != "")?$_REQUEST["bairro"]:$dadosAluno->bairro);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Estado</b></td>
						<td align='left'>
							<select name="estado" onChange="carrega('cidades&uf='+this.options[this.selectedIndex].value)">
								<option value=""></option>
								<option value="AC" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "AC")?"selected":""?>>AC</option>
								<option value="AL" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "AL")?"selected":""?>>AL</option>
								<option value="AM" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "AM")?"selected":""?>>AM</option>
								<option value="AP" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "AP")?"selected":""?>>AP</option>
								<option value="BA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "BA")?"selected":""?>>BA</option>
								<option value="CE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "CE")?"selected":""?>>CE</option>
								<option value="DF" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "DF")?"selected":""?>>DF</option>
								<option value="ES" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "ES")?"selected":""?>>ES</option>
								<option value="GO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "GO")?"selected":""?>>GO</option>
								<option value="MA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "MA")?"selected":""?>>MA</option>
								<option value="MG" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "MG")?"selected":""?>>MG</option>
								<option value="MS" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "MS")?"selected":""?>>MS</option>
								<option value="MT" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "MT")?"selected":""?>>MT</option>
								<option value="PA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "PA")?"selected":""?>>PA</option>
								<option value="PB" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "PB")?"selected":""?>>PB</option>
								<option value="PE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "PE")?"selected":""?>>PE</option>
								<option value="PI" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "PI")?"selected":""?>>PI</option>
								<option value="PR" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "PR")?"selected":""?>>PR</option>
								<option value="RJ" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "RJ")?"selected":""?>>RJ</option>
								<option value="RO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "RO")?"selected":""?>>RO</option>
								<option value="RR" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "RR")?"selected":""?>>RR</option>
								<option value="RN" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "RN")?"selected":""?>>RN</option>
								<option value="RS" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "RS")?"selected":""?>>RS</option>
								<option value="SC" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "SC")?"selected":""?>>SC</option>
								<option value="SE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "SE")?"selected":""?>>SE</option>
								<option value="SP" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "SP")?"selected":""?>>SP</option>
								<option value="TO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) == "TO")?"selected":""?>>TO</option>
							</select>								
						</td>
					</tr>
					<tr>
						<td align="right"><b>Cidade:</b></td>
						<td align='left'>
							<div id="main">
								<select name="cidades">
									<option value="">&nbsp;</option>
									<?php
									// Busca Cidades
									$buscaCidades = mysql_query("SELECT * FROM `cidades` WHERE estado = '" . (($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosAluno->estado) . "' AND deletado  = 'N' ORDER BY cidade ASC");
									
									// Traz Cidades
									while($trazCidades = mysql_fetch_object($buscaCidades)){
										
										?>
										<option value="<?php print($trazCidades->id); ?>" <?php print((((($_REQUEST["cidades"] != "")?$_REQUEST["cidades"]:$dadosAluno->cidade) == $trazCidades->id)?"selected":""));?>><?php print($trazCidades->cidade); ?></option>
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
						<td align='left'><input type="text" name="cep" size="12" maxlength="9" onKeyUp="maskCEP(this, this)" value="<?php echo (($_REQUEST["cep"] != "")?$_REQUEST["cep"]:$_ClassUtilitarios->formataCEP($dadosAluno->cep));?>"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><b><font class="obrig">(**)</font> Academia&nbsp;Forma&ccedil;&atilde;o:</b></td>
						<td align='left'><input type="text" size="50" name="academiaform" value="<?php print((($_REQUEST["academiaform"] != "")?$_REQUEST["academiaform"]:$dadosAluno->academiaform));?>"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><b><font class="obrig">(**)</font> N&uacute;mero&nbsp;Registro:</b></td>
						<td align='left'><input type="text" size="15" name="numerorg" value="<?php print((($_REQUEST["numerorg"] != "")?$_REQUEST["numerorg"]:$dadosAluno->numerorg));?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Data Forma&ccedil;&atilde;o:</b></td>
						<td align='left'><input type="text" name="dataform" size="12" maxlength="10" onKeyUp="maskData(this, document.formMatricula.cpf)" value="<?php print((($_REQUEST["dataform"] != "")?$_REQUEST["dataform"]:$_ClassData->transformaData($dadosAluno->dataform, 2)));?>"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><b><font class="obrig">(**)</font> Livro:</b></td>
						<td align='left'><input type="text" size="20" name="livro" value="<?php print((($_REQUEST["livro"] != "")?$_REQUEST["livro"]:$dadosAluno->livro));?>"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><b><font class="obrig">(**)</font> Folha:</b></td>
						<td align='left'><input type="text" size="5" name="folha" value="<?php print((($_REQUEST["folha"] != "")?$_REQUEST["folha"]:$dadosAluno->folha));?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(**)</font> Org&atilde;o</b></td>
						<td align='left'>
							<select name="orgao">
								<option value=""></option>
								<option value="AC" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "AC")?"selected":""?>>AC</option>
								<option value="AL" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "AL")?"selected":""?>>AL</option>
								<option value="AM" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "AM")?"selected":""?>>AM</option>
								<option value="AP" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "AP")?"selected":""?>>AP</option>
								<option value="BA" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "BA")?"selected":""?>>BA</option>
								<option value="CE" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "CE")?"selected":""?>>CE</option>
								<option value="DF" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "DF")?"selected":""?>>DF</option>
								<option value="ES" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "ES")?"selected":""?>>ES</option>
								<option value="GO" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "GO")?"selected":""?>>GO</option>
								<option value="MA" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "MA")?"selected":""?>>MA</option>
								<option value="MG" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "MG")?"selected":""?>>MG</option>
								<option value="MS" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "MS")?"selected":""?>>MS</option>
								<option value="MT" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "MT")?"selected":""?>>MT</option>
								<option value="PA" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "PA")?"selected":""?>>PA</option>
								<option value="PB" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "PB")?"selected":""?>>PB</option>
								<option value="PE" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "PE")?"selected":""?>>PE</option>
								<option value="PI" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "PI")?"selected":""?>>PI</option>
								<option value="PR" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "PR")?"selected":""?>>PR</option>
								<option value="RJ" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "RJ")?"selected":""?>>RJ</option>
								<option value="RO" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "RO")?"selected":""?>>RO</option>
								<option value="RR" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "RR")?"selected":""?>>RR</option>
								<option value="RS" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "RS")?"selected":""?>>RS</option>
								<option value="SC" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "SC")?"selected":""?>>SC</option>
								<option value="SE" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "SE")?"selected":""?>>SE</option>
								<option value="SP" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "SP")?"selected":""?>>SP</option>
								<option value="TO" <?php echo ((($_REQUEST["orgao"] != "")?$_REQUEST["orgao"]:$dadosAluno->orgao) == "TO")?"selected":""?>>TO</option>
							</select>								
						</td>
					</tr>
					<tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigat&oacute;rios<Br>
							<font class="obrig"><b>(**)</b></font> - Dados complementares. Preencher somente se forem informados pelo aluno.<Br>
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
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=novo&etapa=1", 1, array("é preciso selecionar um(a) aluno(a).")));
	
}
?>