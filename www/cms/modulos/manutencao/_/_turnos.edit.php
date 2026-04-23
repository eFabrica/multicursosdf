<?php
// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["turno"], "É preciso informar o Turno."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["horarioi"], "É preciso informar o Horário de Início."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["horariof"], "É preciso informar o Horário de Término."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica se já existe este turno
		$_ClassRn->getDadosTable("turnos", "id", "unidade = '" . $_dadosUnidade->id . "' AND id != '" . $_REQUEST["idRegistro"] . "' AND turno = '" . $_REQUEST["turno"] . "' AND deletado = 'N'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Turno já exite.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Edita turno
		$editaTurno = $_ClassMysql->query("UPDATE `turnos` SET turno = '" . $_REQUEST["turno"] . "',
															   horarioi = '" . $_REQUEST["horarioi"] . "',
													   		   horariof = '" . $_REQUEST["horariof"] . "',
													   		   ultimoeditou = '" . $_dadosLogado->id . "',
													   		   datahorae = now() WHERE id = '" . $_REQUEST["idRegistro"] . "'");
		
		// Verifica se Editou
		if($editaTurno){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Turno gravado com sucesso!<br><br>[ <a href='?sessao=turnos&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "'>Voltar para a Listagem</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar este Turno.<br>");
			
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
	
	// Dados do turno
	$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $_REQUEST["idRegistro"] . "' AND deletado = 'N'");
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formTurno">
				<input type="hidden" name="act" value="salvar">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td colspan="2" align="right">
							Criado por:
							<?php
							// Dados do Criador
							$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosTurno->quemcriou . "'");
							
							// Mostra
							print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosTurno->datahorac, 3) . "</b>");
							
							// Verifica se alguem edtou
							if($dadosTurno->ultimoeditou > 0){
								
								?>
								<br>Última edição feita por:
								<?php
								// Dados do Alterador
								$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosTurno->ultimoeditou . "'");
								
								// Mostra
								print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosTurno->datahorae, 3) . "</b>");
								
							}
							?>
						</td>
					</tr>
					<tr>
						<td align="right" width="15%"><b><font class="obrig">(*)</font> Turno:</b></td>
						<td width='85%' align='left'><input type="text" name="turno" size="25" value="<?php echo (($_REQUEST["turno"] != "")?$_REQUEST["turno"]:$dadosTurno->turno)?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Horário de Início:</b></td>
						<td align='left'><input type="text" name="horarioi" maxlength="5" size="10" value="<?php echo (($_REQUEST["horarioi"] != "")?$_REQUEST["horarioi"]:$dadosTurno->horarioi)?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Horário de Término:</b></td>
						<td align='left'><input type="text" name="horariof" maxlength="5" size="10" value="<?php echo (($_REQUEST["horariof"] != "")?$_REQUEST["horariof"]:$dadosTurno->horariof)?>"></td>
					</tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios<br>
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