<?php
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["descricao"], "É preciso informar a Descrição."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["valor"], "É preciso informar o Valor."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Cadastra Despesa
		$cadastraDespesa = $_ClassMysql->query("INSERT INTO `despesas` SET  unidade = '" . $_dadosUnidade->id . "',
																			descricao = '" . $_ClassString->filtraTexto($_REQUEST["descricao"]) . "',
																			valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor"]) . "',
																			quemcriou = '" . $_dadosLogado->id . "',
																			datahorac = now(),
																			ultimoeditou = '" . $_dadosLogado->id . "',
																    		datahorae = now()");
		
		// Verifica se Cadastrou
		if($cadastraDespesa){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Despesa gravada com sucesso!<br><br>[ <a href='?sessao=despesas&ref=novo'>Atualizar</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar esta Despesa.<br>");
			
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
			<form action="" method="POST" name="formDespesas">
				<input type="hidden" name="act" value="salvar">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">				
					<tr>
						<td align="right" width="10%"><b>Descrição:</b></td>
						<td width='90%' align='left'><textarea rows="5" cols="60" name="descricao"><?php print($_REQUEST["descricao"]);?></textarea></td>
					</tr>
					<tr>
						<td align="right"><b>Valor:</b></td>
						<td align="left"><input type="text" name="valor" onKeydown="Formata(this,20,event,2)" value="<?php print($_REQUEST["valor"]);?>" style="text-align:right;"></td>
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