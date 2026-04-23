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
		$_ClassRn->getDadosTable("turnos", "id", "unidade = '" . $_dadosUnidade->id . "' AND turno = '" . $_REQUEST["turno"] . "' AND deletado = 'N'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Turno já exite.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Cadastra turno
		$cadastraTurno = $_ClassMysql->query("INSERT INTO `turnos` SET unidade = '" . $_dadosUnidade->id . "',
															   		   turno = '" . $_REQUEST["turno"] . "',
															   		   horarioi = '" . $_REQUEST["horarioi"] . "',
															   		   horariof = '" . $_REQUEST["horariof"] . "',
															   	 	   quemcriou = '" . $_dadosLogado->id . "',
															  		   datahorac = now()");
		
		// Verifica se Cadastrou
		if($cadastraTurno){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Turno gravado com sucesso!<br><br>[ <a href='?sessao=turnos&ref=novo'>Atualizar</a> ]");
			
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
						<td align="right" width="15%"><b><font class="obrig">(*)</font> Turno:</b></td>
						<td width='85%' align='left'><input type="text" name="turno" size="25" value="<?php echo $_REQUEST["turno"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Horário de Início:</b></td>
						<td align='left'><input type="text" maxlength="5" name="horarioi" size="10" value="<?php echo $_REQUEST["horarioi"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Horário de Término:</b></td>
						<td align='left'><input type="text" maxlength="5" name="horariof" size="10" value="<?php echo $_REQUEST["horariof"]?>"></td>
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