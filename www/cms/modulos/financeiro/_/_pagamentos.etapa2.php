<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Verifica se foi informado o número da matrícula
if($_SESSION["consultaPagamentos"]["idMatricula"] > 0){
	
	// Classe de Dinheiro
	require_once($pathInc . "lib/Dinheiro.class.php");
	
	// Classe de Data
	require_once($pathInc . "lib/Data.class.php");
	
	// Dados dessa matrícula
	$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_SESSION["consultaPagamentos"]["idMatricula"] . "'");
	
	// Dados da Turma
	$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "'");
	
	// Dados do Curso
	$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
	?>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td align="right" valign="top" width="15%"><b>Número Matrícula:</b></td>
					<td width="85%" colspan="2"><?php print($dadosMatricula->numero);?></td>
				</tr>
				<tr>
					<td align="right" valign="top"><b>Valor Curso:</b></td>
					<td colspan="2">R$ <?php print($_ClassDinheiro->formataMoeda($dadosCurso->valor));?></td>
				</tr>
				<tr>
					<td align="right" valign="top" width="15%"><b>Desconto:</b></td>
					<td align="left"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($dadosMatricula->pg_desconto);?>.png"></td>
					<td width='85%' align='left'>Valor:&nbsp;R$ <?php print($_ClassDinheiro->formataMoeda($dadosMatricula->valor_desconto));?></td>
				</tr>
				<tr>
					<td align="right" valign="top" width="15%"><b>Dinheiro:</b></td>
					<td align="left"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($dadosMatricula->pg_dinheiro);?>.png"></td>
					<td width='85%' align='left'>Valor:&nbsp;R$ <?php print($_ClassDinheiro->formataMoeda($dadosMatricula->valor_dinheiro));?></td>
				</tr>
				<tr>
					<td align="right" valign="top" width="15%"><b>Cartão Crédito:</b></td>
					<td align="left"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($dadosMatricula->pg_cartaocredito);?>.png"></td>
					<td width='85%' align='left'>Valor:&nbsp;R$ <?php print($_ClassDinheiro->formataMoeda($dadosMatricula->valor_cartaocredito));?></td>
				</tr>
				<tr>
					<td align="right" valign="top" width="15%"><b>Cartão Débito:</b></td>
					<td align="left"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($dadosMatricula->pg_cartaodebito);?>.png"></td>
					<td width='85%' align='left'>Valor:&nbsp;R$ <?php print($_ClassDinheiro->formataMoeda($dadosMatricula->valor_cartaodebito));?></td>
				</tr>
				<tr>
					<td align="right" valign="top"><b>Boleto Bancário:</b></td>
					<td align="left"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($dadosMatricula->pg_boleto);?>.png"></td>
					<td align="left">
						Valor:&nbsp;R$ <?php print($_ClassDinheiro->formataMoeda($dadosMatricula->valor_boleto));?>
						Parcelas:&nbsp;<?php print($dadosMatricula->boleto_parcelas);?>
					</td>
				</tr>
				<?php
				// Verifica parcelas do boleto
				if($dadosMatricula->boleto_parcelas > 0){
					?>
					<tr>
						<td align="right" valign="top"></td>
						<td align="left"></td>
						<td align="left">
							<table border="0" cellpadding="2" cellspacing="2" align="left">
								<tr bgcolor="#EEEEEE">
									<td align="left"></td>
									<td align="center"><b>Valor</b></td>
									<td align="center"><b>Data</b></td>
									<td align="center"><b>Paga</b></td>
								</tr>
								<?php
								// Busca Parcelas
								$buscaParcelas = $_ClassMysql->query("SELECT * FROM `parcelas` WHERE matricula = '" . $dadosMatricula->id . "' AND tipo = 'B' AND deletado = 'N' ORDER BY numero ASC");
								
								// Traz Parcelas
								while($trazParcelas = mysql_fetch_object($buscaParcelas)){
									
									?>
									<tr>
										<td align="right"><b>Parcela <?php print($trazParcelas->numero);?>:</b></td>
										<td align="left"><?php print($_ClassDinheiro->formataMoeda($trazParcelas->valor));?></td>
										<td align="left"><?php print($_ClassData->transformaData($trazParcelas->data, 2));?></td>
										<td align="center">
											<a href="#<?php print($trazParcelas->id);?>" onclick="carregasl('pagamento&idParcela=<?php print($trazParcelas->id);?>', 'mainbb<?php print($trazParcelas->id);?>')">
												<div id="mainbb<?php print($trazParcelas->id);?>"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($trazParcelas->paga);?>.png" border="0"></div>
											</a>
										</td>
									</tr>
									<?php
									
								}
								?>
							</table>
						</td>
					</tr>
					<?php
					
				}
				
				?>
				<tr>
					<td align="right" valign="top"><b>Cheque-Pré:</b></td>
					<td align="left"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($dadosMatricula->pg_cheque);?>.png"></td>
					<td align="left">
						Valor:&nbsp;R$ <?php print($_ClassDinheiro->formataMoeda($dadosMatricula->valor_cheque));?>
						Parcelas:&nbsp;<?php print($dadosMatricula->cheque_parcelas);?>
					</td>
				</tr>
				<?php
				// Verifica parcelas em cheque
				if($dadosMatricula->cheque_parcelas > 0){
					?>
					<tr>
						<td align="right" valign="top"></td>
						<td align="left"></td>
						<td align="left">
							<table border="0" cellpadding="2" cellspacing="2" align="left">
								<tr bgcolor="#EEEEEE">
									<td align="left"></td>
									<td align="center"><b>Valor</b></td>
									<td align="center"><b>Data</b></td>
									<td align="center"><b>BCO</b></td>
									<td align="center"><b>N. CH.</b></td>
									<td align="center"><b>Paga</b></td>
								</tr>
								<?php
								// Busca Parcelas
								$buscaParcelas = $_ClassMysql->query("SELECT * FROM `parcelas` WHERE matricula = '" . $dadosMatricula->id . "' AND tipo = 'C' AND deletado = 'N' ORDER BY numero ASC");
								
								// Traz Parcelas
								while($trazParcelas = mysql_fetch_object($buscaParcelas)){
									?>
									<tr>
										<td align="right"><a name="<?php print($trazParcelas->id);?>"></a><b>Parcela <?php print($trazParcelas->numero);?>:</b></td>
										<td align="left">R$&nbsp;<?php print($_ClassDinheiro->formataMoeda($trazParcelas->valor));?></td>
										<td align="left"><?php print($_ClassData->transformaData($trazParcelas->data, 2));?></td>
										<td align="left"><?php print($trazParcelas->bco);?></td>
										<td align="left"><?php print($trazParcelas->numeroch);?></td>
										<td align="center">
											<a href="#<?php print($trazParcelas->id);?>" onclick="carregasl('pagamento&idParcela=<?php print($trazParcelas->id);?>', 'mainch<?php print($trazParcelas->id);?>')">
												<div id="mainch<?php print($trazParcelas->id);?>"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($trazParcelas->paga);?>.png" border="0"></div>
											</a>
										</td>
									</tr>
									<?php
								}
								?>
							</table>
						</td>
					</tr>
					<?php
					
				}
				?>
				<tr>
					<td align="right" colspan="2"><b>Total Pago:</b>&nbsp;R$ <?php print($_ClassDinheiro->formataMoeda((($_REQUEST["vl_dinheiro"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_dinheiro"]):$dadosMatricula->valor_dinheiro)+
																	  								 	 (($_REQUEST["vl_cc"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_cc"]):$dadosMatricula->valor_cartaocredito)+
																	  								  	 (($_REQUEST["vl_cd"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_cd"]):$dadosMatricula->valor_cartaodebito)+
																	  								  	 (($_REQUEST["vl_bb"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_bb"]):$dadosMatricula->valor_boleto)+
																	  								     (($_REQUEST["vl_ch"] != "")?$_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["vl_ch"]):$dadosMatricula->valor_cheque)));?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}else{
	
	// Redireicona
	print($_ClassUtilitarios->redirecionarJS("?sessao=pagamentos&etapa=1", 1, array("É preciso selecionar uma matrícula.")));
	
}
?>