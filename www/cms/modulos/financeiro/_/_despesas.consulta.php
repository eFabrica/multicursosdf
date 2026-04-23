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
			<form action="?sessao=despesas&ref=buscar" method="POST" name="formDespesa">
				<input type="hidden" name="a" value="S">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td width="15%"><strong>Data:</strong></td>
						<td align="left">
							De <input type="text" id="dataI" name="dataI" size="12" onKeyUp="maskData(this, document.formDespesa.dataF)" disabled>
					  		até <input type="text" id="dataF" name="dataF" size="12" onKeyUp="maskData(this, document.formDespesa.dataF)" disabled>
						</td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitarData" value="sim" onClick="disen(document.formDespesa.dataI);disen(document.formDespesa.dataF);" ></td>
					</tr>
					<tr>
						<td width="15%"><strong>Valor:</strong></td>
						<td align="left">
							De <input type="text" id="valorI" name="valorI" size="12" onKeydown="Formata(this,20,event,2)" style="text-align:right;" disabled>
					  		até <input type="text" id="valorF" name="valorF" size="12" onKeydown="Formata(this,20,event,2)" style="text-align:right;" disabled>
						</td>
					 	<td width="5%" align="center"><input type="checkbox" name="habilitarValor" value="sim" onClick="disen(document.formDespesa.valorI);disen(document.formDespesa.valorF);" ></td>
					</tr>
					<tr>
						<td valign="top"><strong>Descrição:</strong></td>
					  	<td align="left"><textarea name="descricao" id="descricao" rows="1" cols="50" onfocus="this.rows=5" onblur="this.rows=1" disabled></textarea></td>
					  	<td align="center"><input type="checkbox" name="habilitarDescricao" value="sim" onClick="disen(document.formDespesa.descricao);" ></td>
					</tr>
					<tr>
						<td align="left"><strong>Usuário:</strong></td>
					  	<td align="left">
					  		<select name="usuario" disabled>
								<?php								
								// Busca Usuários
								$buscaUsuarios = $_ClassMysql->query("SELECT * FROM `usuarios` WHERE unidade = '" . $_dadosUnidade->id . "' AND nivel != 'aluno' AND nivel != 'instrutor'");
								
								// Traz Usuários
								while($trazUsuarios = mysql_fetch_object($buscaUsuarios)){
									?>
									<option value="<?php print($trazUsuarios->id);?>"><?php print($trazUsuarios->nome);?> (<?php print($trazUsuarios->cpf);?>)</option>
									<?php
									
								}
								
								?>
							</select>
					  	</td>
					  	<td align="center"><input type="checkbox" name="habilitarUsuario" value="sim" onClick="disen(document.formDespesa.usuario);" ></td>
					</tr>
					<tr>
						<td align="left">&nbsp;</td>
						<td align="right"><strong>Todas</strong></td>
						<td align="center"><input type="checkbox" name="todas" value="sim" onClick=" disen(document.formDespesa.habilitarData);checkedDisable(document.formDespesa.habilitarData);
																									 disen(document.formDespesa.habilitarValor);checkedDisable(document.formDespesa.habilitarValor);
																									 disen(document.formDespesa.habilitarUsuario);checkedDisable(document.formDespesa.habilitarUsuario);
																									 disen(document.formDespesa.habilitarDescricao);checkedDisable(document.formDespesa.habilitarDescricao);
																									 disable(document.formDespesa.dataI);
																									 disable(document.formDespesa.dataF);
																									 disable(document.formDespesa.valorI);
																									 disable(document.formDespesa.valorF);
																									 disable(document.formDespesa.usuario);
																									 disable(document.formDespesa.descricao);" ></td>
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
		$_SESSION["consultaDespesas"] = $_POST;
		
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
				if($_SESSION["consultaDespesas"]["todas"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Todas as Despesas</strong></ol></td>
					</tr>
					<?php
				}
				 
				// Verifica se foi habilitado o campo de data
				if($_SESSION["consultaDespesas"]["habilitarData"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Data:</strong>&nbsp;De <?php echo $_SESSION["consultaDespesas"]["dataI"]?> até <?php echo $_SESSION["consultaDespesas"]["dataF"]?></ol></td>
					</tr>
					<?php
				}
				
				// Verifica se foi habilitado o campo de valor
				if($_SESSION["consultaDespesas"]["habilitarValor"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Valor:</strong>&nbsp;De R$ <?php echo $_SESSION["consultaDespesas"]["valorI"]?> até R$ <?php echo $_SESSION["consultaDespesas"]["valorF"]?></ol></td>
					</tr>
					<?php
				}
				
				//Verifica se foi habilitado o campo de Usuários
				if($_SESSION["consultaDespesas"]["habilitarUsuario"] == "sim"){
					
					// Dados do Usuário
					$dadosUsuario = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["consultaDespesas"]["usuario"] . "'");
					?>
					<tr>
						<td align="left"><ol><strong>Usuário:</strong>&nbsp;<?php print($dadosUsuario->nome);?> (<?php print($dadosUsuario->cpf);?>)</ol></td>
					</tr>
					<?php
				}
				
				//Verifica se foi habilitado o campo de Descrição
				if($_SESSION["consultaDespesas"]["habilitarDescricao"] == "sim"){
					?>
					<tr>
						<td align="left"><ol><strong>Descricao:</strong>&nbsp;<?php echo nl2br($_SESSION["consultaDespesas"]["descricao"]);?></ol></td>
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
	// Verifica Ação
	if($_REQUEST["act"] == "deletar"){
	
		// Lê Registros
		for($y = 0; $y < count($_REQUEST["registros"]); $y++){
			
			// Deleta Grades
			$_ClassMysql->query("UPDATE `despesas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
			
		}
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);
		
		// Seta Mensagem de Sucesso
		$_ClassMensagens->setMensagem_sucesso("<b>" . count($_REQUEST["registros"]) . "</b> Despesa(s) foi(ram) deletada(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=cancelar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
		
		?>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<?php
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
				<tr>
					<td width="15%" align="right">Com Selecionados:</td>
					<td width='85%' align='left'>
						<select onchange="if(confirm('Deseja mesmo deletar este(s) registro(s)?')){document.formDespesa.act.value = '' + this.options[this.selectedIndex].value; document.formDespesa.submit();}">
							<option value=""></option>
							<option value="deletar">Deletar</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<form action="" method="POST" name="formDespesa">
							<input type="hidden" name="act" value="">
							<table class="consulta" cellspacing="1" align="center">
								<thead>
									<tr>
										<th width="1%"><?php print($_ClassUtilitarios->OrdemControl("#", "?sessao=despesas&ref=buscar&pg=" . $_REQUEST["pg"], "id", $pathInc)); ?></th>
										<th width="1%" align="center"><input type="checkbox" onclick="select_all('formDespesa', 'registros[]')"></th>
										<th width="30%"><?php print($_ClassUtilitarios->OrdemControl("Descrição", "?sessao=despesas&ref=buscar&pg=" . $_REQUEST["pg"], "descricao", $pathInc)); ?></th>
										<th width="20%"><?php print($_ClassUtilitarios->OrdemControl("Valor", "?sessao=despesas&ref=buscar&pg=" . $_REQUEST["pg"], "valor", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Data", "?sessao=despesas&ref=buscar&pg=" . $_REQUEST["pg"], "datahorae", $pathInc)); ?></th>
										<th width="15%"><?php print($_ClassUtilitarios->OrdemControl("Hora", "?sessao=despesas&ref=buscar&pg=" . $_REQUEST["pg"], "datahorae", $pathInc)); ?></th>
										<th width="20%"><?php print($_ClassUtilitarios->OrdemControl("Usuário", "?sessao=despesas&ref=buscar&pg=" . $_REQUEST["pg"], "ultimoeditou", $pathInc)); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php	
									/* Construindo sql */
									$sql = "SELECT * FROM `despesas`";
									$sql .= " WHERE unidade = '" . $_dadosUnidade->id . "' AND ";
									if($_SESSION["consultaDespesas"]["todas"] != "sim"){
										
										$sql .= (($_SESSION["consultaDespesas"]["habilitarData"] == "sim")?" datahorae >= '" . $_ClassData->transformaData($_SESSION["consultaDespesas"]["dataI"]) . " 00:00:00' AND datahorae <= '" . $_ClassData->transformaData($_SESSION["consultaDespesas"]["dataF"]) . " 23:59:49' AND":"");
										$sql .= (($_SESSION["consultaDespesas"]["habilitarValor"] == "sim")?" valor BETWEEN '" . $_ClassDinheiro->limpaFormatacaoMoeda($_SESSION["consultaDespesas"]["valorI"]) . "' AND '" . $_ClassDinheiro->limpaFormatacaoMoeda($_SESSION["consultaDespesas"]["valorF"]) . "' AND":"");
										$sql .= (($_SESSION["consultaDespesas"]["habilitarUsuario"] == "sim")?" ultimoeditou = '" . $_SESSION["consultaDespesas"]["usuario"] . "' AND":"");
										$sql .= (($_SESSION["consultaDespesas"]["habilitarDescricao"] == "sim")?" descricao LIKE '%" . $_SESSION["consultaDespesas"]["descricao"] . "%' AND":"");
										
										//$sql .= (($_POST["habilitar"] == "sim")?"":"");
									}
									
									$sql .= " deletado = 'N' ORDER BY " . (($_REQUEST['campo'] == '')?'id':$_REQUEST['campo']) . " " . (($_REQUEST['ordem'] == '')?"ASC":$_REQUEST['ordem']);
				
									/* Fim da construção */
									
									// Paginação
									require_once($pathInc . "lib/Paginacao.class.php");
									
									// Configurações da paginacao
									$_ClassPaginacao->setQuery($sql);
									$_ClassPaginacao->setUrl("?sessao=despesas&ref=buscar&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&filtro=" . $_REQUEST["filtro"]);
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
											
											// Dados do Usuário
											$dadosUsuario = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $trazResultados->ultimoeditou . "'");
											?>
											<tr class=row0>
												<td align="left"><?php print($trazResultados->id); ?></td>
												<td align="center"><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"></td>
												<td align="left">
													<div <?php print($_ClassUtilitarios->criaLegenda($trazResultados->descricao, 1)); ?>>
														<a name="<?=$trazResultados->id?>"></a>
														<a href="<?php print("?sessao=despesas&ref=edit&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&idRegistro=" . $trazResultados->id);?>"><b><?php print(substr($trazResultados->descricao, 0, 50) . ((strlen($trazResultados->descricao) > 50)?" ...":""));?></b></a>
													</div>
													</td>
												<td align="center">R$ <?php print($_ClassDinheiro->formataMoeda($trazResultados->valor)); ?></td>
												<td align="center"><?php print(substr($_ClassData->transformaData($trazResultados->datahorae, 3), 0, 10)); ?></td>
												<td align="center"><?php print(substr($_ClassData->transformaData($trazResultados->datahorae, 3), 11, 8)); ?></td>
												<td align="center"><?php print($_ClassUtilitarios->abreviaNome($dadosUsuario->nome)); ?></td>												
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