<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Class de data
require_once($pathInc . "lib/Data.class.php");

// Class de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Verifica referência
if($_REQUEST["ref"] == ""){
	?>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="?sessao=faturas&ref=buscar" method="POST" name="formFatura">
				<input type="hidden" name="a" value="S">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td width="15%" align="right"><strong>Data:</strong></td>
						<td align="left">
							De <input type="text" id="dataI" name="dataI" size="12" onKeyUp="maskData(this, document.formFatura.dataF)" disabled>
					  		até <input type="text" id="dataF" name="dataF" size="12" onKeyUp="maskData(this, document.formFatura.dataF)" disabled>
						</td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitarData" value="sim" onClick="disen(document.formFatura.dataI);disen(document.formFatura.dataF);" ></td>
					</tr>
					<?php
					// Verifica nível
					if($_dadosLogado->nivel != "94"){
						?>
						<tr>
							<td align="right"><strong>Empresa:</strong></td>
							<td align="left">
								<select name="empresa" disabled>
									<?php
									// Busca Empresas
									$buscaEmpresas = $_ClassMysql->query("SELECT * FROM `clientes` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
									
									// Traz Empresas
									while($trazEmpresas = mysql_fetch_object($buscaEmpresas)){
										
										?>
										<option value="<?php print($trazEmpresas->id);?>"><?php print($trazEmpresas->razaosocial);?></option>
										<?php
										
									}
									?>
								</select>
							</td>
						 	<td align="center"><input type="checkbox" name="habilitarEmpresa" value="sim" onClick="disen(document.formFatura.empresa);" ></td>
						</tr>
						<?php
					}
					?>
					<tr>
						<td align="right"><strong>Situação:</strong></td>
						<td align="left">
							<select name="situacao" disabled>
								<option value="S">Paga</option>
								<option value="N">Não Paga</option>
							</select>
						</td>
					 	<td align="center"><input type="checkbox" name="habilitarSituacao" value="sim" onClick="disen(document.formFatura.situacao);" ></td>
					</tr>
					<tr>
						<td align="left">&nbsp;</td>
						<td align="right"><strong>Todas</strong></td>
						<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formFatura.habilitarData);checkedDisable(document.formFatura.habilitarData);
																									 <?php if($_dadosLogado->nivel != "94"){?>disen(document.formFatura.habilitarEmpresa);checkedDisable(document.formFatura.habilitarEmpresa);<?php }?>
																									 disen(document.formFatura.habilitarSituacao);checkedDisable(document.formFatura.habilitarSituacao);
																									 disable(document.formFatura.dataI);
																									 disable(document.formFatura.dataF);
																									 disable(document.formFatura.situacao);
																									 <?php if($_dadosLogado->nivel != "94"){?>disable(document.formFatura.empresa);<?php }?>" ></td>
					</tr>
					<tr>
						<td align="left">&nbsp;</td>
						<td align="left"><input type="submit" value="Consultar"></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}elseif($_REQUEST["ref"] == "buscar"){
	
	/* Gravando dados da pesquisa na sessão */
	if($_REQUEST["a"] == "S"){
	
		// Consulta
		$_SESSION["consultaFaturas"] = $_POST;
		
	}
	
	?>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2">
				<tr>
					<td class="menu_topico">Buscando por: </td>
				</tr>
				<?php
				// Verifica se a busca é por todas as notas fiscais
				if($_SESSION["consultaFaturas"]["todas"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Todas as Faturas</strong></ol></td>
					</tr>
					<?php
				}
				 
				// Verifica se foi habilitado o campo de data
				if($_SESSION["consultaFaturas"]["habilitarData"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaFaturas"]["dataI"]?> até <?php echo $_SESSION["consultaFaturas"]["dataF"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de Empresa
				if($_SESSION["consultaFaturas"]["habilitarEmpresa"] == "sim"){
					
					// Dados da Empresa
					$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $_SESSION["consultaFaturas"]["empresa"] . "'");
					?>
					<tr>
						<td align="left"><ol><strong>Empresa:</strong>&nbsp;<?php print($dadosEmpresa->razaosocial . " (" . $_ClassUtilitarios->formataCNPJ($dadosEmpresa->cnpj) . ")");?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de Situação
				if($_SESSION["consultaFaturas"]["habilitarSituacao"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Situação:</strong>&nbsp;<?php print((($_SESSION["consultaFaturas"]["situacao"] == "S")?"Paga":"Não Paga"));?></ol></td>
					</tr>
					<?php
				}
				?>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
	// Verifica nível
	if($_dadosLogado->nivel != "94"){
	
		// Verifica Ação
		if($_REQUEST["act"] == "pagar"){
		
			// Lê Registros
			for($y = 0; $y < count($_REQUEST["registros"]); $y++){
				
				// Paga Faturas
				$_ClassMysql->query("UPDATE `faturas` SET paga = 'S', quempagou = '" . $_dadosLogado->id . "', datahorap = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
				
			}
			
			// Seta largura das mensagens
			$_ClassMensagens->setLargura(100);
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("<b>" . count($_REQUEST["registros"]) . "</b> Fatura(s) foi(ram) paga(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=cancelar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
			
			?>
			<tr>
				<td style='height:5px';>&nbsp;</td>
			</tr>
			<tr>
				<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
			</tr>
			<?php
		}elseif($_REQUEST["act"] == "tpagar"){
		
			// Lê Registros
			for($y = 0; $y < count($_REQUEST["registros"]); $y++){
				
				// Tira Pagamento das Faturas
				$_ClassMysql->query("UPDATE `faturas` SET paga = 'N', quempagou = '', datahorap = '', ultimoeditou = '" . $_dadosLogado->id . "', datahorae = NOW() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
				
			}
			
			// Seta largura das mensagens
			$_ClassMensagens->setLargura(100);
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Foi(ram) retirado(s) o(s) pagamento(s) de <b>" . count($_REQUEST["registros"]) . "</b> Fatura(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=cancelar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
			
			?>
			<tr>
				<td style='height:5px';>&nbsp;</td>
			</tr>
			<tr>
				<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
			</tr>
			<?php
		}elseif($_REQUEST["act"] == "deletar"){
		
			// Lê Registros
			for($y = 0; $y < count($_REQUEST["registros"]); $y++){
				
				// Altera matrículas
				$_ClassMysql->query("UPDATE `matriculas` SET fatura = '' WHERE fatura = '" . $_REQUEST["registros"][$y] . "'");
				
				// Deleta Faturas
				$_ClassMysql->query("UPDATE `faturas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
				
			}
			
			// Seta largura das mensagens
			$_ClassMensagens->setLargura(100);
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("<b>" . count($_REQUEST["registros"]) . "</b> Fatura(s) foi(ram) deletada(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=cancelar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
			
			?>
			<tr>
				<td style='height:5px';>&nbsp;</td>
			</tr>
			<tr>
				<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
			</tr>
			<?php
		}
		
	}
	?>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2">
				<?php
				// Verifica Nível
				if($_dadosLogado->nivel != "94"){
					?>
					<tr>
						<td width="15%" align="right">Com Selecionados:</td>
						<td width='85%' align='left'>
							<select onchange="if(confirm('Deseja mesmo deletar este(s) registro(s)?')){document.formFatura.act.value = '' + this.options[this.selectedIndex].value; document.formFatura.submit();}">
								<option value=""></option>
								<option value="deletar">Deletar</option>
								<option value="pagar">Efetuar Pagamento</option>
								<option value="tpagar">Tirar Pagamento</option>
							</select>
						</td>
					</tr>
					<?php 
				}
				?>
				<tr>
					<td colspan="2">
						<form <?php print((($_dadosLogado->nivel != "94")?"action=''":"action = '" . $path . "modulos/relatorios/_rel.faturas.emitir.php' target='_blank'"));?>method="POST" name="formFatura">
							<input type="hidden" name="act" value="">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%"><?php print($_ClassUtilitarios->OrdemControl("#", "?sessao=faturas&ref=buscar&pg=" . $_REQUEST["pg"], "id", $pathInc)); ?></th>
										<?php if($_dadosLogado->nivel != "94"){?><th width="1%" align="center"><input type="checkbox" onclick="select_all('formFatura', 'registros[]')"></th><?php }?>
										<th width="40%">Empresa</th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Data", "?sessao=faturas&ref=buscar&pg=" . $_REQUEST["pg"], "datai", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Data Venc.", "?sessao=faturas&ref=buscar&pg=" . $_REQUEST["pg"], "data", $pathInc)); ?></th>
										<th width="25%"><?php print($_ClassUtilitarios->OrdemControl("Valor", "?sessao=faturas&ref=buscar&pg=" . $_REQUEST["pg"], "valor", $pathInc)); ?></th>
										<th width="5%">Paga</th>
										<?php if($_dadosLogado->nivel != "94"){?><th width="5%">Turmas</th><?php }?>
										<th width="5%">Matrículas</th>
									</tr>
								</thead>
								<tbody>
									<?php	
									/* Construindo sql */
									$sql = "SELECT * FROM `faturas`";
									$sql .= " WHERE ";
									if($_SESSION["consultaFaturas"]["todas"] != "sim"){
										
										$sql .= (($_SESSION["consultaFaturas"]["habilitarData"] == "sim")?" datai >= '" . $_ClassData->transformaData($_SESSION["consultaFaturas"]["dataI"]) . "' AND datai <= '" . $_ClassData->transformaData($_SESSION["consultaFaturas"]["dataF"]) . "' AND":"");
										$sql .= (($_SESSION["consultaFaturas"]["habilitarSituacao"] == "sim")?" paga = '" . $_SESSION["consultaFaturas"]["situacao"] . "' AND":"");
										
										// Verifica o Nível
										if($_dadosLogado->nivel != "94"){
											
											// SQL
											$sql .= (($_SESSION["consultaFaturas"]["habilitarEmpresa"] == "sim")?" empresa = '" . $_SESSION["consultaFaturas"]["empresa"] . "' AND":"");
											
										}else{
											
											// SQL
											$sql .= " empresa = '" . $_dadosLogado->empresa . "' AND";
											
										}
										//$sql .= (($_POST["habilitar"] == "sim")?"":"");
									}
									
									$sql .= " deletado = 'N' ORDER BY " . (($_REQUEST['campo'] == '')?'id':$_REQUEST['campo']) . " " . (($_REQUEST['ordem'] == '')?"ASC":$_REQUEST['ordem']);
				
									/* Fim da construção */
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=faturas&ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&filtro=" . $_REQUEST["filtro"]);
									$_ClassPaginacao->setRegistrosPorPagina("10");
									$_ClassPaginacao->setPaginaAtual((($_REQUEST["pg"] == 0)?"1":$_REQUEST["pg"]));
									$_ClassPaginacao->paginando();
															
									// Verifica total achado
									if($_ClassPaginacao->getTotalAchadoQuery() == 0){
										?>
										<tr>
											<td align="center" colspan="9"><b>Nenhum resultado encontrado.</b></td>
										</tr>
										<?
									}else{
										
										// Traz resultados
										while($trazResultados = mysql_fetch_object($_ClassPaginacao->getBusca())){
										
											// Dados da Empresa
											$dadosEmpresa = $_ClassRn->getDadosTable("clientes", "*", "id = '" . $trazResultados->empresa . "'");
											?>
											<tr class=row0>
												<td align="left"><?php print($trazResultados->id); ?></td>
												<?php if($_dadosLogado->nivel != "94"){?><td align="center"><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"></td><?php }?>
												<td align="left"><?php print($dadosEmpresa->razaosocial);?></td>
												<td align="center"><?php print($_ClassData->transformaData($trazResultados->datai, 2)); ?></td>
												<td align="center"><?php print($_ClassData->transformaData($trazResultados->datavenc, 2)); ?></td>
												<td align="right">R$ <?php print($_ClassDinheiro->formataMoeda($trazResultados->valor)); ?></td>
												<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($trazResultados->paga);?>.png"></td>
												<?php if($_dadosLogado->nivel != "94"){?><td align="center"><a href="#" onclick="popup('fatura_turmas', '<?php print($pathInc);?>modulos/financeiro/_/_faturas.turmas.php?idFatura=<?php print($trazResultados->id);?>', 730, 400, 'yes')"><img src="<?php print($pathInc);?>imagens/icones/sh.png" border="0"></a></td><?php }?>
												<td align="center"><a href="#" onclick="popup('fatura_matriculas', '<?php print($pathInc);?>modulos/financeiro/_/_faturas.matriculas.php?idFatura=<?php print($trazResultados->id);?>', 730, 400, 'yes')"><img src="<?php print($pathInc);?>imagens/icones/sh.png" border="0"></a></td>
											</tr>
											<?php
										}
										
									}
									?>
								</tbody>
								<tfoot>
									<td colspan="9"><?php echo $_ClassPaginacao->showPaginacao();?></td>
								</tfoot>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}
?>