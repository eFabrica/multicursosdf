<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00005.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Carta de Cobrança</td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formCarta.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a></div></td>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php require_once("php7_mysql_shim.php");
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
			
	// Verifica ação
	if($_REQUEST["act"] == "gravaCarta"){
		
		// Busca Carta de Cobrança
		$buscaCarta = $_ClassMysql->query("SELECT ultimoeditou FROM `cartacobranca`");
		
		// Verifica o total achado
		if(mysql_num_rows($buscaCarta) > 0){
		
			// Grava Carta
			$gravaCarta = $_ClassMysql->query("UPDATE `cartacobranca` SET texto = '" . $_ClassString->filtraTexto($_REQUEST["texto"]) . "',
																	      ultimoeditou = '" . $_dadosLogado->id . "',
																	      datahorae = now()");	
			
		}else{
			
			// Grava Carta
			$gravaCarta = $_ClassMysql->query("INSERT INTO `cartacobranca` SET texto = '" . $_ClassString->filtraTexto($_REQUEST["texto"]) . "',
																		       ultimoeditou = '" . $_dadosLogado->id . "',
																		       datahorae = now()");	
			
		}
		
		// Verifica se gravou a carta
		if($gravaCarta){
			
			// Seta mensagem de sucesso
			$_ClassMensagens->setMensagem_sucesso("Carta de Cobrança atualizada com sucesso!");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar a Carta de Cabrança.");
			
		}
		
		?>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align='left'><? echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<?php
		
	}
	
	// Dados da Carta
	$dadosCarta = $_ClassRn->getDadosTable("cartacobranca", "*", "1");
	
	// Verifica se já foi editou
	if($dadosCarta->ultimoeditou > 0){
	
		// Dados do último a editar
		$dadosEditor = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosCarta->ultimoeditou . "'");
	
	}
	?>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formCarta">
				<input type="hidden" name="act" value="gravaCarta">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td align='left'>
							<?php
							
							// Importa FCK Editor
							require_once($pathInc . "includes/fckeditor/fckeditor.php");
							
							// Cria Campo do FCK EDITOR
							$oFCKeditor = new FCKeditor('texto') ;
							$oFCKeditor->BasePath = 'includes/fckeditor/';
							$oFCKeditor->Value = $dadosCarta->texto;
							$oFCKeditor->Height = '300' ;
							$oFCKeditor->Create() ;		
							?>
						</td>
					</tr>
					<?php
					// Verifica se já foi editou
					if($dadosCarta->ultimoeditou > 0){
						?>
						<tr>
							<td align='left'><b>Última Edição:&nbsp;</b><em><?php print($dadosCarta->datahorae);?></em>&nbsp;<b>por </b><em><?php print($dadosEditor->nome);?></em></td>
						</tr>
						<?php
					}
					?>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
</table>