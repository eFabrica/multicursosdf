<div id="menu_financeiro" style="display:none;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr valign="top">
				<?php
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("89"))){
					?>
					<td class="cdchutopl" width="2">&nbsp;</td>
					<td class="cdchutopc"><div></div></td>
					<td class="cdchutopr" width="2"></td>
					<?php
				}
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("89"))){
					?>
					<td class="cdchutopl" width="2">&nbsp;</td>
					<td class="cdchutopc"><div></div></td>
					<td class="cdchutopr" width="2"></td>
					<?php
				}
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("90", "98", "99", "89"))){
					?>
					<td class="cdchutopl" width="2">&nbsp;</td>
					<td class="cdchutopc"><div></div></td>
					<td class="cdchutopr" width="2"></td>
					<?php
				}
				?>
			</tr>
			<tr height="74" valign="middle">
				<?php
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("89"))){
					?>
					<td class="cdchumidl" width="1"><div></div></td>
					<td class="cdchumidc" onmouseover="this.className='cdchumidcover'" onmouseout="this.className='cdchumidc'">
						<table align="center" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr style="padding-top: 3px;">
									<?php
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" align="center">
												<tr>
													<td align='left'><a href="?sessao=pagamentos"><img src="<?php print("imagens/icones/00020_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=pagamentos">Pagamentos</a></td>
												</tr>
												<tr>
													<td align='left'>&nbsp;</td>
												</tr>
											</table>
										</td>
										<?php
									}
									?>
								</tr>
								<tr>
									<td colspan="8" style="height: 15px; text-align: center;"><b>Instrutores</b></td>
								</tr>
							</tbody>
						</table>
					</td>
					<td class="cdchumidr" width="1"><div></div></td>
					<?php
				}
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("89"))){
					?>
					<td class="cdchumidl" width="1"><div></div></td>
					<td class="cdchumidc" onmouseover="this.className='cdchumidcover'" onmouseout="this.className='cdchumidc'">
						<table align="center" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr style="padding-top: 3px;">
									<?php
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" align="center">
												<tr>
													<td align='left'><a href="?sessao=faturas"><img src="<?php print("imagens/icones/00045_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=faturas">Faturas</a></td>
												</tr>
												<tr>
													<td align='left'>&nbsp;</td>
												</tr>
											</table>
										</td>
										<?php
									}
									?>
								</tr>
								<tr>
									<td colspan="8" style="height: 15px; text-align: center;"><b>Clientes</b></td>
								</tr>
							</tbody>
						</table>
					</td>
					<td class="cdchumidr" width="1"><div></div></td>
					<?php
				}
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("90", "98", "99", "89"))){
					?>
					<td class="cdchumidl" width="1"><div></div></td>
					<td class="cdchumidc" onmouseover="this.className='cdchumidcover'" onmouseout="this.className='cdchumidc'">
						<table align="center" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr style="padding-top: 3px;">
									<?php
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("90", "98", "99", "89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<form action="http://gerencia-atlas/sge/areaLogin.php" method="POST" target="_blank" name="cobranca">
												<input type="hidden" name="cpf" value="<?=$_dadosLogado->cpf?>">
												<input type="hidden" name="senha" value="<?=$_dadosLogado->senha?>">
												<input type="hidden" name="libera" value="sim">
												<input type="hidden" name="act" value="logar">
											</form>
											<table border="0" cellpadding="0" cellspacing="0" align="center">
												<tr>
													<td align='left'><a href="#" onclick="document.cobranca.submit();"><img src="<?php print("imagens/icones/00002_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="#" onclick="document.cobranca.submit();">Cobranças</a></td>
												</tr>
												<tr>
													<td align='left'>&nbsp;</td>
												</tr>
											</table>
										</td>
										<?php
									}
									?>
								</tr>
								<tr>
									<td colspan="8" style="height: 15px; text-align: center;"><b>Controle</b></td>
								</tr>
							</tbody>
						</table>
					</td>
					<td class="cdchumidr" width="1"><div></div></td>
					<?php
				}
				?>
			</tr>
			<tr valign="top">
				<?php
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("89"))){
					?>
					<td class="cdchubotl" width="2">&nbsp;</td>
					<td class="cdchubotc"><div></div></td>
					<td class="cdchubotr" width="2"></td>
					<?php
				}
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("89"))){
					?>
					<td class="cdchubotl" width="2">&nbsp;</td>
					<td class="cdchubotc"><div></div></td>
					<td class="cdchubotr" width="2"></td>
					<?php
				}
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("90", "98", "99", "89"))){
					?>
					<td class="cdchubotl" width="2">&nbsp;</td>
					<td class="cdchubotc"><div></div></td>
					<td class="cdchubotr" width="2"></td>
					<?php
				}
				?>
			</tr>
		</tbody>
	</table>
</div>