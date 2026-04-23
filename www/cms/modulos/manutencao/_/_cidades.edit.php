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
		$_ClassRn->getDadosTable("cidades", "id", "id != '" . $_REQUEST["idRegistro"] . "' AND cidade = '" . $_REQUEST["cidade"] . "' AND estado = '" . $_REQUEST["estado"] . "' AND deletado = 'N'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Cidade já exite.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Edita Cidade
		$editaCidade = $_ClassMysql->query("UPDATE `cidades` SET  cidade = '" . $_REQUEST["cidade"] . "',
																  estado = '" . $_REQUEST["estado"] . "',
																  ultimoeditou = '" . $_dadosLogado->id . "',
																  datahorae = now() WHERE id = '" . $_REQUEST["idRegistro"] . "'");
		
		// Verifica se Editou
		if($editaCidade){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Cidade gravada com sucesso!<br><br>[ <a href='?sessao=cidades&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "'>Voltar para a Listagem</a> ]");
			
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
	
	// Dados da Cidade
	$dadosCidade = $_ClassRn->getDadosTable("cidades", "*", "id = '" . $_REQUEST["idRegistro"] . "' AND deletado = 'N'");
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
						<td colspan="2" align="right">
							Criado por:
							<?php
							// Dados do Criador
							$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosCidade->quemcriou . "'");
							
							// Mostra
							print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosCidade->datahorac, 3) . "</b>");
							
							// Verifica se alguem edtou
							if($dadosAluno->ultimoeditou > 0){
								
								?>
								<br>Última edição feita por:
								<?php
								// Dados do Alterador
								$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosCidade->ultimoeditou . "'");
								
								// Mostra
								print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosCidade->datahorae, 3) . "</b>");
								
							}
							?>
						</td>
					</tr>
					<tr>
						<td align="right" width="10%"><b><font class="obrig">(*)</font> Cidade:</b></td>
						<td width='90%' align='left'><input type="text" name="cidade" size="25" value="<?php echo (($_REQUEST["cidade"] != "")?$_REQUEST["cidade"]:$dadosCidade->cidade)?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Estado</b></td>
						<td align='left'>
							<select name="estado">
								<option value="AC" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "AC")?"selected":""?>>AC</option>
								<option value="AL" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "AL")?"selected":""?>>AL</option>
								<option value="AM" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "AM")?"selected":""?>>AM</option>
								<option value="AP" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "AP")?"selected":""?>>AP</option>
								<option value="BA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "BA")?"selected":""?>>BA</option>
								<option value="CE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "CE")?"selected":""?>>CE</option>
								<option value="DF" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "DF")?"selected":""?>>DF</option>
								<option value="ES" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "ES")?"selected":""?>>ES</option>
								<option value="GO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "GO")?"selected":""?>>GO</option>
								<option value="MA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "MA")?"selected":""?>>MA</option>
								<option value="MG" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "MG")?"selected":""?>>MG</option>
								<option value="MS" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "MS")?"selected":""?>>MS</option>
								<option value="MT" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "MT")?"selected":""?>>MT</option>
								<option value="PA" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "PA")?"selected":""?>>PA</option>
								<option value="PB" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "PB")?"selected":""?>>PB</option>
								<option value="PE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "PE")?"selected":""?>>PE</option>
								<option value="PI" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "PI")?"selected":""?>>PI</option>
								<option value="PR" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "PR")?"selected":""?>>PR</option>
								<option value="RJ" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "RJ")?"selected":""?>>RJ</option>
								<option value="RO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "RO")?"selected":""?>>RO</option>
								<option value="RR" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "RR")?"selected":""?>>RR</option>
								<option value="RN" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "RN")?"selected":""?>>RN</option>
								<option value="RS" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "RS")?"selected":""?>>RS</option>
								<option value="SC" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "SC")?"selected":""?>>SC</option>
								<option value="SE" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "SE")?"selected":""?>>SE</option>
								<option value="SP" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "SP")?"selected":""?>>SP</option>
								<option value="TO" <?php echo ((($_REQUEST["estado"] != "")?$_REQUEST["estado"]:$dadosCidade->estado) == "TO")?"selected":""?>>TO</option>
							</select>
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