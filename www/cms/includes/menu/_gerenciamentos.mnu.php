<div id="menu_gerenciamentos" style="display:none;">
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
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
					?>
					<td class="cdchutopl" width="2">&nbsp;</td>
					<td class="cdchutopc"><div></div></td>
					<td class="cdchutopr" width="2"></td>
					<?php
				}
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "95"))){
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
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=alunos"><img src="<?php print("imagens/icones/00007_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=alunos">Alunos</a></td>
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
													<td align="center"><a href="?sessao=matriculas&subsessao=consultageral"><img src="<?php print("imagens/icones/00018_.gif");?>" border="0"></a></td>
												</tr>
											</table>
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" onmouseover="this.className='fundoOnIconeInvert'" onmouseout="this.className='semFundo'">
												<tr>
													<td align="center" style="cursor:pointer;">
														<a href="#" onMouseOut="MM_startTimeout();" onMouseOver="MM_showMenu(window.mm_menu_0712010718_1,0,5,null,'matriculas');">Matrículas<br>
														<img id="matriculas" name="matriculas" src="<?php print("imagens/icones/setaDown.gif");?>" border="0"></a>
													</td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=faltadocumentos"><img src="<?php print("imagens/icones/00038_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=faltadocumentos">Falta de<br>Documentos</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									?>
								</tr>
								<tr>
									<td colspan="8" style="height: 15px; text-align: center;"><b>Recursos&nbsp;Humanos</b></td>
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
													<td align="center"><a href="?sessao=clientes"><img src="<?php print("imagens/icones/00008_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=clientes">Clientes<br><br></a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									?>
								</tr>
								<tr>
									<td colspan="8" style="height: 15px; text-align: center;"><b>Institucional</b></td>
								</tr>
							</tbody>
						</table>
					</td>
					<td class="cdchumidr" width="1"><div></div></td>
					<?php
				}
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "95"))){
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
													<td align="center"><a href="?sessao=frequenciadiario"><img src="<?php print("imagens/icones/00039_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=frequenciadiario">Frequência <br>e Dirário</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "95"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=gradehoraria"><img src="<?php print("imagens/icones/00017_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=gradehoraria">Grade Horária</a></td>
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
													<td align="center"><a href="?sessao=notas"><img src="<?php print("imagens/icones/00019_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=notas">Notas</a></td>
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
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
					?>
					<td class="cdchubotl" width="2">&nbsp;</td>
					<td class="cdchubotc"><div></div></td>
					<td class="cdchubotr" width="2"></td>
					<?php
				}
				
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "95"))){
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