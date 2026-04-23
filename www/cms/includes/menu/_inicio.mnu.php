<div id="menu_inicio" style="display:none;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr valign="top">
				<?php
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98", "97", "96", "95"))){
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
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98", "97", "96", "95"))){
					?>
					<td class="cdchumidl" width="1"><div></div></td>
					<td class="cdchumidc" onmouseover="this.className='cdchumidcover'" onmouseout="this.className='cdchumidc'">
						<table align="center" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr style="padding-top: 3px;">
									<?php
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98", "97", "96", "95"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" align="center">
												<tr>
													<td align='left'><a href="?sessao=inicial"><img src="<?php print("imagens/icones/00016_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=inicial">Inicial</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" align="center">
												<tr>
													<td align='left'><a href="mainMaster.php?sessao=inicial"><img src="<?php print("imagens/icones/00034_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="mainMaster.php?sessao=inicial">Mudar de<br>Unidade</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									?>
									<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
										<table border="0" cellpadding="0" cellspacing="0" align="center">
											<tr>
												<td align='left'><a href="modulos/sistema/sair.php"><img src="<?php print("imagens/icones/00027_.gif");?>" border="0"></a></td>
											</tr>
											<tr>
												<td align="center"><a href="modulos/sistema/sair.php">Sair</a></td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan="8" style="height: 15px; text-align: center;"><b>Início</b></td>
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
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98", "97", "96", "95"))){
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