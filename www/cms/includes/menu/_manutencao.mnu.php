<div id="menu_manutencao" style="display:none;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr valign="top">
				<?php
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
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
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
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
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
				?>
					<td class="cdchumidl" width="1"><div></div></td>
					<td class="cdchumidc" onmouseover="this.className='cdchumidcover'" onmouseout="this.className='cdchumidc'">
						<table align="center" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr style="padding-top: 3px;">
									<?php
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=cursos"><img src="<?php print("imagens/icones/00009_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=cursos">Cursos</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOffOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
												<tr>
													<td align="center"><a href="?sessao=turmasativas"><img src="<?php print("imagens/icones/00023_.gif");?>" border="0"></a></td>
												</tr>
											</table>
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" onmouseover="this.className='fundoOnIconeInvert'" onmouseout="this.className='semFundo'">
												<tr>
													<td align="center" style="cursor:pointer;">
														<a href="" onMouseOut="MM_startTimeout();" onMouseOver="MM_showMenu(window.mm_menu_0712011423_3,0,5,null,'turmas');">Turmas<br>
														<img id="turmas" name="turmas" src="<?php print("imagens/icones/setaDown.gif");?>" border="0"></a>
													</td>
												</tr>
											</table>
										</td>
										<?php
									}
									?>
								</tr>
								<tr>
									<td colspan="8" style="height: 15px; text-align: center;"><b>Escolar</b></td>
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
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=cartacobranca"><img src="<?php print("imagens/icones/00005_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=cartacobranca">Carta de <br>Cobrança<br></a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									?>
								</tr>
								<tr>
									<td colspan="8" style="height: 15px; text-align: center;"><b>Modelos</b></td>
								</tr>
							</tbody>
						</table>
					</td>
					<td class="cdchumidr" width="1"><div></div></td>
					<?php
				}
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
					?>
					<td class="cdchumidl" width="1"><div></div></td>
					<td class="cdchumidc" onmouseover="this.className='cdchumidcover'" onmouseout="this.className='cdchumidc'">
						<table align="center" border="0" cellpadding="0" cellspacing="0">
							<tbody>
								<tr style="padding-top: 3px;">
									<?php
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=unidades"><img src="<?php print("imagens/icones/00013_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=unidades">Unidades</a><br><br></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=usuarios"><img src="<?php print("imagens/icones/00025_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=usuarios">Usuários</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=escolaridade"><img src="<?php print("imagens/icones/00012_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=escolaridade">Escolaridade</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=turnos"><img src="<?php print("imagens/icones/00014_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=turnos">Turnos</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=cidades"><img src="<?php print("imagens/icones/00006_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=cidades">Cidades</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=materias"><img src="<?php print("imagens/icones/00035_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=materias">Matérias</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=documentos"><img src="<?php print("imagens/icones/00036_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=documentos">Documentos</a></td>
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
													<td align="center"><a href="?sessao=faixamatricula"><img src="<?php print("imagens/icones/00042_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=faixamatricula">Faixa de<br>Matrícula</a></td>
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
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
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
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
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