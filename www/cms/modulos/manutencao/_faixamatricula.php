<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00042.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Faixa Matricula</td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formFaixa.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a></div></td>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
			
	// Verifica ação
	if($_REQUEST["act"] == "grava"){

        // Dados da Faixa de Matrícula
        $dadosFaixa = $_ClassRn->getDadosTable("faixamatricula", "id", "unidade = '" . $_dadosUnidade->id . "'");

        // Verifica se achou alguma coisa
        if ($_ClassRn->getTot() > 0) {

            // Grava Faixa de Matrícula
            $_ClassMysql->query("UPDATE `faixamatricula` SET inicio  = '" . $_REQUEST["inicio"] . "',
                                                             termino = '" . $_REQUEST["termino"] . "' WHERE id = '" . $dadosFaixa->id . "'");

        }else{

            // Grava Faixa de Matrícula
            $_ClassMysql->query("INSERT INTO `faixamatricula` SET unidade = '" . $_dadosUnidade->id . "',
                                                                  inicio  = '" . $_REQUEST["inicio"] . "',
                                                                  termino = '" . $_REQUEST["termino"] . "'");

        }

        // Seta mensagem de sucesso
        $_ClassMensagens->setMensagem_sucesso("Faixa de Matrícula atualizada com sucesso!");
		?>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align='left'><? echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<?php
		
	}
	
	// Dados da Faixa de Matrícula
	$dadosFaixa = $_ClassRn->getDadosTable("faixamatricula", "*", "unidade = '" . $_dadosUnidade->id . "'");
	?>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formFaixa">
				<input type="hidden" name="act" value="grava">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td align='left' width="15%"><b>Início:</b></td>
                        <td align="left" width="85%"><input type="text" size="15" name="inicio" value="<?=(($_REQUEST["inicio"] != "")?$_REQUEST["inicio"]:$dadosFaixa->inicio)?>">*Somente números</td>
					</tr>
                    <tr>
						<td align='left'><b>Término:</b></td>
                        <td align="left"><input type="text" size="15" name="termino" value="<?=(($_REQUEST["termino"] != "")?$_REQUEST["termino"]:$dadosFaixa->termino)?>">*Somente números</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
</table>