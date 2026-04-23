<div id="menu_site" style="display:none;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr valign="top">
				<?php
				if ($_ClassPermissao->validaPermissaoSeeReturn(array(""))){
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
				if ($_ClassPermissao->validaPermissaoSeeReturn(array(""))){
					?>
					<td class="cdchumidl" width="1"><div></div></td>
					<td class="cdchumidc" onmouseover="this.className='cdchumidcover'" onmouseout="this.className='cdchumidc'">
						<table align="center" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr style="padding-top: 3px;">
									<?php
									if ($_ClassPermissao->validaPermissaoSeeReturn(array(""))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=site_escolheratlas"><img src="<?php print("imagens/icones/00042_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=site_escolheratlas">Escolher a <br>Atlas?</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array(""))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=site_institucional"><img src="<?php print("imagens/icones/00042_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=site_institucional">Institucional</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array(""))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=site_galeriafotos"><img src="<?php print("imagens/icones/00044_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=site_galeriafotos">Galeria de <br>Fotos</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array(""))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=site_galeriavideos"><img src="<?php print("imagens/icones/00048_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=site_galeriavideos">Galeria de <br>Vídeos</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array(""))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=site_contato"><img src="<?php print("imagens/icones/00043_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=site_contato">Contato</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									?>
								</tr>
								<tr>
									<td colspan="8" style="height: 15px; text-align: center;"><b>Sistema</b></td>
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
				if ($_ClassPermissao->validaPermissaoSeeReturn(array(""))){
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