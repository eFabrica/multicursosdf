<?php
// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Classe de CPF
require_once($pathInc . "lib/Cpf.class.php");

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
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Limpa CPF
		$_REQUEST["cpf"] = preg_replace("/[\.-]/", "", $_REQUEST["cpf"]);
		
		// Limpa CEP
		$_REQUEST["cep"] = preg_replace("/[\.-]/", "", $_REQUEST["cep"]);
		
		// Verifica se já existe este aluno
		$dadosAluno = $_ClassRn->getDadosTable("alunos", "id", "id != '" . $_REQUEST["idRegistro"] . "' AND cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpf"]) . "' AND empresa != '" . $_dadosLogado->empresa . "' AND deletado = 'N'");
	
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			$dataNascimento = $_REQUEST["datanascimento"] == "" ? '0000-00-00' : $_ClassData->transformaData($_REQUEST["datanascimento"]);

			// Edita Dados do Aluno
			$_ClassMysql->query("UPDATE `alunos` SET empresa = '" . $_dadosLogado->empresa . "',
												  	 nome = '" . strtoupper($_REQUEST["nome"]) . "',
												  	 datanascimento = '" . $dataNascimento . "',
												  	 cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpf"]) . "',
												  	 rg = '" . $_REQUEST["rg"] . "',
												  	 ultimoeditou = '" . $_dadosLogado->id . "',
					   							  	 datahorae = now() WHERE id = '" . $dadosAluno->id . "'");
			
			// Sucesso
			$sucesso = true;
			
			// Redireciona
			print($_ClassUtilitarios->redirecionarJS("?sessao=alunos_clientes&ref=sucesso&idAluno=" . $_REQUEST["idRegistro"]));
			
		}else{
		
			// Verifica se já existe este aluno
			$_ClassRn->getDadosTable("alunos", "id", "id != '" . $_REQUEST["idRegistro"] . "' AND cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpf"]) . "' AND empresa = '" . $_dadosLogado->empresa . "' AND deletado = 'N'");
		
			// Verifica o total achado
			if($_ClassRn->getTot() > 0){
				
				// Seta Erro
				$_ClassMensagens->setMensagem_erro("Aluno já exite.<br>");
				
			}else{

				$dataNascimento = $_REQUEST["datanascimento"] == "" ? '0000-00-00' : $_ClassData->transformaData($_REQUEST["datanascimento"]);
				
				// Edita Dados do Aluno
				$_ClassMysql->query("UPDATE `alunos` SET empresa = '" . $_dadosLogado->empresa . "',
													  	 nome = '" . strtoupper($_REQUEST["nome"]) . "',
													  	 datanascimento = '" . $dataNascimento . "',
													  	 cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpf"]) . "',
													  	 rg = '" . $_REQUEST["rg"] . "',
													  	 ultimoeditou = '" . $_dadosLogado->id . "',
						   							  	 datahorae = now() WHERE id = '" . $_REQUEST["idRegistro"] . "'");
				
				// Sucesso
				$sucesso = true;
				
				// Redireciona
				print($_ClassUtilitarios->redirecionarJS("?sessao=alunos_clientes&ref=sucesso&idAluno=" . $_REQUEST["idRegistro"]));
				
			}
			
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
	
	// Dados do Aluno
	$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $_REQUEST["idRegistro"] . "' AND empresa = '" . $_dadosLogado->empresa . "'");
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
						<td colspan="2" align="right">
							Criado por:
							<?php
							// Dados do Criador
							$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosAluno->quemcriou . "'");
							
							// Mostra
							print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosAluno->datahorac, 3) . "</b>");
							
							// Verifica se alguem edtou
							if($dadosAluno->ultimoeditou > 0){
								
								?>
								<br>última edição feita por:
								<?php
								// Dados do Alterador
								$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosAluno->ultimoeditou . "'");
								
								// Mostra
								print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosAluno->datahorae, 3) . "</b>");
								
							}
							?>
						</td>
					</tr>
					<tr>
						<td align="right" width="15%"><b><font class="obrig">(*)</font> Nome:</b></td>
						<td width='85%' align='left'><input type="text" name="nome" size="50" value="<?php print((($_REQUEST["nome"] != "")?$_REQUEST["nome"]:$dadosAluno->nome));?>"></td>
				 	</tr>
					<tr>
						<td align="right"><b> Data Nascimento:</b></td>
						<td align="left"><input type="text" name="datanascimento" size="12" maxlength="10" onKeyUp="maskData(this, document.formAluno.rg)" value="<?php print(print((($_REQUEST["datanascimento"] != "")?$_REQUEST["datanascimento"]:$_ClassData->transformaData($dadosAluno->datanascimento, 2))));?>"></td>
					</tr>
					<tr>
						<td align="right"><b> R.G:</b></td>
						<td align="left"><input type="text" name="rg" size="15" value="<?php print((($_REQUEST["rg"] != "")?$_REQUEST["rg"]:$dadosAluno->rg))?>"></td>
					</tr>
					<tr>
						<td align="right"><b> CPF:</b></td>
						<td align="left"><input type="text" name="cpf" size="18" maxlength="14" onKeyUp="maskCPF(this, this)" value="<?php print((($_REQUEST["cpf"] != "")?$_REQUEST["cpf"]:$_ClassUtilitarios->formataCPF($dadosAluno->cpf)));?>"></td>
					</tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigat&oacute;rios<br />							
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