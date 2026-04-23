<?php
// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["documento"], "É preciso informar o Documento."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica se já existe este Documento
		$_ClassRn->getDadosTable("documentos", "id", "documento = '" . $_REQUEST["documento"] . "' AND deletado = 'N'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Documento já exite.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Cadastra Documento
		$cadastraDocumento = $_ClassMysql->query("INSERT INTO `documentos` SET unidade = '" . $_dadosUnidade->id . "',
																			   documento = '" . $_REQUEST["documento"] . "',
																		  	   quemcriou = '" . $_dadosLogado->id . "',
																		  	   datahorac = now()");
		
		// Verifica se Cadastrou
		if($cadastraDocumento){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Documento gravado com sucesso!<br><br>[ <a href='?sessao=documentos&ref=novo'>Atualizar</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar este Documento.<br>");
			
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
			<form action="" method="POST" name="formDocumento">
				<input type="hidden" name="act" value="salvar">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td align="right" width="10%"><b><font class="obrig">(*)</font> Documento:</b></td>
						<td width='90%' align='left'>
							<span id="cidade">
								<input type="text" name="documento" size="25" value="<?php echo $_REQUEST["documento"]?>">
							</span>
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