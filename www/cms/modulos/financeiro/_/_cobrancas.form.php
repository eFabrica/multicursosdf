<?php
// Classe de Cpf
require_once($pathInc . "lib/Cpf.class.php");

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cpf"], "É preciso informar o Cpf."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["nome"], "É preciso informar o Nome."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["endereco"], "É preciso informar o Endereço."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["telefone"], "É preciso informar o Telefone."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["empresa"], "É preciso informar a Emppresa."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["turma"], "É preciso informar a Turma."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["vencimento"], "É preciso informar o Vencimento."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["valor"], "É preciso informar o Valor."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["tipo"], "É preciso informar o Tipo."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["doc"], "É preciso informar o Documento."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["spc"], "É preciso informar se vai para o SPC ou não."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica validade do cpf
		if (!$_ClassCpf->validaCPF($_REQUEST["cpf"])) $_ClassMensagens->setMensagem_erro("CPF inválido.<br>");
		
		// Verifica a validade da data de vencimento
		if (!$_ClassData->validaData($_REQUEST["vencimento"])) $_ClassMensagens->setMensagem_erro("Data de Vencimento inválida.<br>"); 
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica se foi informado algum registro
		if ($_REQUEST["idRegistro"] > 0){
			
			// Edita Registro
			$editaRegistro = $_ClassMysql->query("UPDATE `cobranca` SET empresa = '" . $_REQUEST["empresa"] . "',
																		cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpf"]) . "',
																		nome = '" . $_REQUEST["nome"] . "',
																		endereco = '" . $_REQUEST["endereco"] . "',
																		telefone = '" . $_REQUEST["telefone"] . "',
																		turma = '" . $_REQUEST["turma"] . "',
																		vencimento = '" . $_ClassData->transformaData($_REQUEST["vencimento"]) . "',
																		valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor"]) . "',
																		tipo = '" . $_REQUEST["tipo"] . "',
																		doc = '" . $_REQUEST["doc"] . "',
																		spc = '" . $_REQUEST["spc"] . "',
																		historico = '" . $_REQUEST["historico"] . "',
																		pago = 'N' WHERE id = '" . $_REQUEST["idRegistro"] . "'");
			
		}else{
			
			// Insere Registro
			$insereRegistro = $_ClassMysql->query("INSERT INTO `cobranca` SET empresa = '" . $_REQUEST["empresa"] . "',
																			  cpf = '" . $_ClassUtilitarios->deixaN($_REQUEST["cpf"]) . "',
																			  nome = '" . $_REQUEST["nome"] . "',
																			  endereco = '" . $_REQUEST["endereco"] . "',
																			  telefone = '" . $_REQUEST["telefone"] . "',
																			  turma = '" . $_REQUEST["turma"] . "',
																			  vencimento = '" . $_ClassData->transformaData($_REQUEST["vencimento"]) . "',
																			  valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor"]) . "',
																			  tipo = '" . $_REQUEST["tipo"] . "',
																			  doc = '" . $_REQUEST["doc"] . "',
																			  spc = '" . $_REQUEST["spc"] . "',
																			  historico = '" . $_REQUEST["historico"] . "',
																			  pago = 'N'");
			
		}
		
		// Verifica se alguma ação ocorreu
		if ($insereRegistro || $editaRegistro){
			
			// Mensagem de sucesso
			print($_ClassUtilitarios->redirecionarJS((($_REQUEST["idRegistro"] > 0)?"?modulo=financeiro&sessao=" . $_REQUEST["sessao"] . "&pc=" . $_REQUEST["pc"] . "&pg=" . $_REQUEST["pg"]:"?modulo=financeiro&sessao=" . $_REQUEST["sessao"] . "&ref=novo" . (($_REQUEST["mantercpf"] == "sim")?"&cpf=" . $_REQUEST["cpf"]:"")), 1, array("Cobrança gravada com sucesso!")));
			
		}else{
			
			// Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar esta cobrança.<br>");
			
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

// Verifica se tem algum id
if ($_REQUEST["idRegistro"]){
	
	// Dados do Registro
	$dadosRegistro = $_ClassRn->getDadosTable("cobranca", "*", "id = '" . $_REQUEST["idRegistro"] . "'");
	
}
?>
<tr>
	<td>
		<form action="" method="POST" name="formCobranca">
			<input type="hidden" name="act" value="salvar">
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align='left'><div id="border-top"><div><div></div></div></div></td>
				</tr>
				<tr>
					<td class="table_main">
						<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
							<tr>
								<td width='10%' align='left'><b><font class="obrig">(*)</font>&nbsp;CPF:</b></td>
								<td align='left'>
									<input type="text" name="cpf" tipo="numerico" mascara="###.###.###-##" onblur="dadosCPF(this.value)" size="16" value="<?php print((($_REQUEST["cpf"] != "")?$_REQUEST["cpf"]:$_ClassUtilitarios->formataCPF($dadosRegistro->cpf)));?>">
									<input type="checkbox" name="mantercpf" value="sim">Manter Cpf?
								</td>
							</tr>
							<tr>
								<td align='left'><b>Nome:</b></td>
								<td align='left' colspan="2"><input type="text" name="nome" size="50" value="<?php print((($_REQUEST["nome"] != "")?$_REQUEST["nome"]:$dadosRegistro->nome));?>"></td>
							</tr>
							<tr>
								<td align='left'><b>Endereço:</b></td>
								<td align='left' colspan="2"><input type="text" name="endereco" size="60" value="<?php print((($_REQUEST["endereco"] != "")?$_REQUEST["endereco"]:$dadosRegistro->endereco));?>"></td>
							</tr>
							<tr>
								<td align='left'><b>Telefone:</b></td>
								<td align='left' colspan="2"><input type="text" name="telefone" size="30" value="<?php print((($_REQUEST["telefone"] != "")?$_REQUEST["telefone"]:$dadosRegistro->telefone));?>"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
				</tr>
				<tr>
					<td style='height:5px';>&nbsp;</td>
				</tr>
				<tr>
					<td align='left'><div id="border-top"><div><div></div></div></div></td>
				</tr>
				<tr>
					<td class="table_main">
						<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
							<tr>
								<td width='10%' align='left'><b><font class="obrig">(*)</font>&nbsp;Empresa:</b></td>
								<td width='90%' align='left'>
									<select name="empresa">
										<option value="atlas" <?php print((((($_REQUEST["empresa"] != "")?$_REQUEST["empresa"]:$dadosRegistro->empresa) == "atlas")?"selected":""));?>>Academia Atlas</option>
										<option value="multi" <?php print((((($_REQUEST["empresa"] != "")?$_REQUEST["empresa"]:$dadosRegistro->empresa) == "multi")?"selected":""));?>>Multi-Cursos</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align='left'><b><font class="obrig">(*)</font>&nbsp;Turma:</b></td>
								<td align='left'><input type="text" name="turma" size="20" value="<?php print((($_REQUEST["turma"] > 0)?$_REQUEST["turma"]:$dadosRegistro->turma));?>"></td>
							</tr>
							<tr>
								<td align='left'><b><font class="obrig">(*)</font>&nbsp;Vencimento:</b></td>
								<td align='left'><input type="text" name="vencimento" size="12" tipo="numerico" mascara="##/##/####" value="<?php print((($_REQUEST["vencimento"] > 0)?$_REQUEST["vencimento"]:$_ClassData->transformaData($dadosRegistro->vencimento, 2)));?>"></td>
							</tr>
							<tr>
								<td align='left'><b><font class="obrig">(*)</font>&nbsp;Valor:</b></td>
								<td align='left'><input type="text" name="valor" tipo="decimal" negativo=false casasdecimais=2 maxlength="12" size="30" value="<?php print((($_REQUEST["valor"] > 0)?$_REQUEST["valor"]:$_ClassDinheiro->formataMoeda($dadosRegistro->valor)));?>" style="text-align:right;"></td>
							</tr>
							<tr>
								<td align='left'><b><font class="obrig">(*)</font>&nbsp;Tipo:</b></td>
								<td align='left'>
									<select name="tipo">
										<option value="boleto" <?php print((((($_REQUEST["tipo"] != "")?$_REQUEST["tipo"]:$dadosRegistro->tipo) == "boleto")?"selected":""));?>>Boleto</option>
										<option value="cheque" <?php print((((($_REQUEST["tipo"] != "")?$_REQUEST["tipo"]:$dadosRegistro->tipo) == "cheque")?"selected":""));?>>Cheque</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align='left'><b><font class="obrig">(*)</font>&nbsp;Doc.:</b></td>
								<td align='left'><input type="text" name="doc" size="10" value="<?php print((($_REQUEST["doc"] > 0)?$_REQUEST["doc"]:$dadosRegistro->doc));?>"></td>
							</tr>
							<tr>
								<td align='left'><b><font class="obrig">(*)</font>&nbsp;SPC:</b></td>
								<td align='left'>
									<select name="spc">
										<option value="N" <?php print((((($_REQUEST["spc"] != "")?$_REQUEST["spc"]:$dadosRegistro->spc) == "N")?"selected":""));?>>Não</option>
										<option value="S" <?php print((((($_REQUEST["spc"] != "")?$_REQUEST["spc"]:$dadosRegistro->spc) == "S")?"selected":""));?>>Sim</option>
									</select>
								</td>
							</tr>
							<tr>
								<td align='left' valign="top"><b>Histórico:</b></td>
								<td align='left'><textarea cols="60" rows="10" name="historico"><?php print((($_REQUEST["historico"] > 0)?$_REQUEST["historico"]:$dadosRegistro->historico));?></textarea></td>
							</tr>
							<tr>
								<td colspan='2' align='left'>
									<br>
									<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios<Br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
				</tr>
			</table>
		</form>
	</td>
</tr>