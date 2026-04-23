<tr>
	<td align='left'><div id="border-top"><div><div></div></div></div></td>
</tr>
<tr>
	<td class="table_main">
		<table border="0" width="100%" cellpadding="2" cellspacing="2" align="center">
			<tr>
				<td width="15%" align="right"><strong>Palavra-Chave:</strong></td>
				<td align='left'><input type="text" id="palavraChave" value="<?php require_once("php7_mysql_shim.php"); print($_REQUEST["pc"]);?>" size="50" onkeyup="consulta('consultaCobrancas', 'consulta', 'consultaLoading', this.value, 'consultaTable', '<?php print("modulo=" . $_REQUEST["modulo"] . "&sessao=" . $_REQUEST["sessao"] . "&pg=" . $_REQUEST["pg"]);?>', '<?php print($pathInc);?>')"></td>
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
<?php
// Verifica Ação
if($_REQUEST["act"] == "baixar"){
	
	// Lê Registros
	for($y = 0; $y < count($_REQUEST["registros"]); $y++){
		
		// Baixa Registro
		$_ClassMysql->query("UPDATE `cobranca` SET pago = 'S' WHERE id = '" . $_REQUEST["registros"][$y] . "'");
		
	}
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Seta Mensagem de Sucesso
	$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " Cobrança(s) foi(ram) baixada(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
	
	?>
	<tr>
		<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}elseif($_REQUEST["act"] == "estornar"){
	
	// Lê Registros
	for($y = 0; $y < count($_REQUEST["registros"]); $y++){
		
		// Baixa Registro
		$_ClassMysql->query("UPDATE `cobranca` SET pago = 'N' WHERE id = '" . $_REQUEST["registros"][$y] . "'");
		
	}
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Seta Mensagem de Sucesso
	$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " Cobrança(s) foi(ram) estornada(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
	
	?>
	<tr>
		<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}elseif($_REQUEST["act"] == "deletar"){
	
	// Lê Registros
	for($y = 0; $y < count($_REQUEST["registros"]); $y++){
		
		// Deleta Registro
		$_ClassMysql->query("DELETE FROM `cobranca` WHERE id = '" . $_REQUEST["registros"][$y] . "'");
		
	}
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Seta Mensagem de Sucesso
	$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " Cobrança(s) foi(ram) deletada(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
	
	?>
	<tr>
		<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}
?>
<tr>
	<td align='left'><div id="border-top"><div><div></div></div></div></td>
</tr>
<tr>
	<td class="table_main">
		<table width="99%" border="0" cellpadding="2" cellspacing="2">
			<tr>
				<td width="15%" align="right">Com Selecionados:</td>
				<td width='85%' align='left'>
					<select onchange="if(confirm('Deseja mesmo '+this.options[this.selectedIndex].value+' este(s) registro(s)?')){document.formRegistros.act.value = '' + this.options[this.selectedIndex].value; document.formRegistros.submit();}">
						<option value=""></option>
						<option value="baixar">Baixar</option>
						<option value="estornar">Estornar</option>
						<option value="deletar">Deletar</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan='2' align='left'>
					<form action='' method="POST" name="formRegistros">
						<input type="hidden" name="act" value="">
						<input type="hidden" name="pc" value="<?php print($_REQUEST["pc"]);?>">
						<div id="consulta" style="display:block;">
							<table id="consultaTable" class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%">#</th>
										<th width="1%" align="center"><input type="checkbox" onclick="select_all(this, 'formRegistros', 'registros[]')"></th>
										<th width="35%">Nome</th>
										<th width="10%">Empresa</th>
										<th width="10%">Vencimento</th>
										<th width="15%">Valor</th>
										<th width="5%">Tipo</th>
										<th width="5%">Doc</th>
										<th width="10%">Turma</th>
										<th width="5%">SPC</th>
										<th width="5%">PAGO</th>
									</tr>
								</thead>
								<tbody>
									<?php	
									/* Construindo sql */
									$sql = "SELECT cobranca.id,
												   cobranca.nome,
												   cobranca.empresa,
												   cobranca.vencimento,
												   cobranca.valor,
												   cobranca.tipo,
												   cobranca.doc,
												   cobranca.turma,
												   cobranca.spc,
												   cobranca.pago FROM `cobranca` ";
									
									// Verifica se tem palavra chave
									if ($_REQUEST["pc"] != ""){
										
										// QUERY - Nome
										$sql .= " WHERE cobranca.nome LIKE '%" . $_REQUEST["pc"] . "%' OR ";
										
										// QUERY - Endereço
										$sql .= " cobranca.endereco LIKE '%" . $_REQUEST["pc"] . "%' OR ";
										
										// QUERY - Telefone
										$sql .= " cobranca.telefone LIKE '%" . $_REQUEST["pc"] . "%' OR ";
										
										// QUERY - CPF
										$sql .= " cobranca.cpf LIKE '%" . $_ClassUtilitarios->tiraMask($_REQUEST["pc"]) . "%' OR ";
										
										// QUERY - Empresa
										$sql .= " cobranca.empresa LIKE '%" . $_REQUEST["pc"] . "%' OR ";
										
										// QUERY - Turma
										$sql .= " cobranca.turma LIKE '%" . $_REQUEST["pc"] . "%' OR ";
										
										// QUERY - Vencimento
										$sql .= " cobranca.vencimento LIKE '%" . $_ClassData->transformaData($_REQUEST["pc"]) . "%' OR ";
										
										// QUERY - Valor
										$sql .= " cobranca.valor LIKE '%" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["pc"]) . "%' OR ";
										
										// QUERY - Tipo
										$sql .= " cobranca.tipo LIKE '%" . $_REQUEST["pc"] . "%' OR ";
										
										// QUERY - Doc
										$sql .= " cobranca.doc LIKE '%" . str_replace("@doc", "", $_REQUEST["pc"]) . "%' OR ";
										
										// QUERY - SPC
										$sql .= " cobranca.spc = '" . str_replace("@spc", "", $_REQUEST["pc"]) . "' OR ";
										
										// QUERY - Histórico
										$sql .= " cobranca.historico LIKE '%" . $_REQUEST["pc"] . "%' OR ";
										
										// QUERY - Pago
										$sql .= " cobranca.pago = '" . str_replace("@pago", "", $_REQUEST["pc"]) . "%'";
										
									}
									
									// Agrupa Resultados
									$sql .= " ORDER BY nome, empresa ASC";
									
									/* Fim da construção */
									//print($sql);
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?modulo=" . $_REQUEST["modulo"] . "&sessao=" . $_REQUEST["sessao"] . "&pc=" . $_REQUEST["pc"]);
									$_ClassPaginacao->setRegistrosPorPagina("20");
									$_ClassPaginacao->setPaginaAtual((($_REQUEST["pg"] == 0)?"1":$_REQUEST["pg"]));
									$_ClassPaginacao->paginando();
															
									// Verifica total achado
									if($_ClassPaginacao->getTotalAchadoQuery() == 0){
										?>
										<tr>
											<td align="center" colspan="11"><b>Nenhum resultado encontrado.</b></td>
										</tr>
										<?
									}else{
										
										// Traz resultados
										while($trazResultados = mysql_fetch_object($_ClassPaginacao->getBusca())){
											
											?>
											<tr class=row0>
												<td align='left'><?php print($trazResultados->id); ?></td>
												<td align="center"><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"></td>
												<td align="left"><a href="<?php print("?modulo=" . $_REQUEST["modulo"] . "&sessao=" . $_REQUEST["sessao"] . "&pc=" . $_REQUEST['pc'] . "&pg=" . $_REQUEST['pg'] . "&ref=edit&idRegistro=" . $trazResultados->id); ?>"><b><?php print($trazResultados->nome);?></b></a></td>
												<td align='center'><?php print($trazResultados->empresa);?></td>
												<td align='center'><?php print($_ClassData->transformaData($trazResultados->vencimento, 2));?></td>
												<td align='right'>R$&nbsp;<?php print($_ClassDinheiro->formataMoeda($trazResultados->valor));?></td>
												<td align='center'><?php print($trazResultados->tipo);?></td>
												<td align='center'><?php print($trazResultados->doc);?></td>
												<td align='center'><?php print($trazResultados->turma);?></td>
												<td align='center'><img src="<?php print($pathInc . "imagens/diversos/" . $trazResultados->spc . ".png");?>"></td>
												<td align='center'><img src="<?php print($pathInc . "imagens/diversos/" . $trazResultados->pago . ".png");?>"></td>
											</tr>
											<?php
										}
										
									}
									?>
								</tbody>
								<tfoot>
									<td colspan="11"><?php echo $_ClassPaginacao->showPaginacao();?></td>
								</tfoot>
							</table>
						</div>
						<div id="consultaLoading" align="center" style="display:none;"></div>
					</form>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
</tr>