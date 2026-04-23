<div id="menu_relatorios" style="display:none;">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>
			<tr valign="top">
				<?php
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98", "94", "95"))){
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
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98", "94", "95"))){
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
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_gradehoraria"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_gradehoraria">Grade Horária</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_frequencias"><img src="<?php print("imagens/icones/00039_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_frequencias">Frequências</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_listachamada"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_listachamada">Lista de <br>Chamada</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89"))){
										?>
										<td valign="middle" onmouseover="this.className='fundoOffOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
												<tr>
													<td align="center"><a href="?sessao=rel_horasaula"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
											</table>
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" onmouseover="this.className='fundoOnIconeInvert'" onmouseout="this.className='semFundo'">
												<tr>
													<td align="center" style="cursor:pointer;">
														<a href="#" onMouseOut="MM_startTimeout();" onMouseOver="MM_showMenu(window.mm_menu_0712011614_4,0,5,null,'horasaula');">Horas Aula<br>
														<img id="horasaula" name="horasaula" src="<?php print("imagens/icones/setaDown.gif");?>" border="0"></a>
													</td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_fichacadastral"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_fichacadastral">Ficha Cadastral</a></td>
												</tr>
											</table>
										</td>
									<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_documentacao"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_documentacao">Documentação</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_alunosmatriculados"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_alunosmatriculados">Alunos<br>Matriculados</a></td>
												</tr>
											</table>
										</td>
									<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_alunosconcluidos"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_alunosconcluidos">Alunos<br>Concluídos</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_certificados"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_certificados">Certificados</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_carteirinhas"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_carteirinhas">Carteirinhas</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="middle" onmouseover="this.className='fundoOffOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
												<tr>
													<td align="center"><a href="?sessao=rel_declaracaoprovisoria"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
											</table>
											<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" onmouseover="this.className='fundoOnIconeInvert'" onmouseout="this.className='semFundo'">
												<tr>
													<td align="center" style="cursor:pointer;">
														<a href="#" onMouseOut="MM_startTimeout();" onMouseOver="MM_showMenu(window.mm_menu_0712011614_5,0,5,null,'declaracoes');">Declarações<br>
														<img id="declaracoes" name="declaracoes" src="<?php print("imagens/icones/setaDown.gif");?>" border="0"></a>
													</td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_dpf"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_dpf">DPF</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("95"), true)){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?sessao=rel_horasaula"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?sessao=rel_horasaula">Horas Aula</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									
									if ($_ClassPermissao->validaPermissaoSeeReturn(array("94"), true)){
										?>
										<td valign="top" onmouseover="this.className='fundoOnIcone'" onmouseout="this.className='semFundo'">
											<table border="0" cellpadding="2" cellspacing="0" width="100%" align="center">
												<tr>
													<td align="center"><a href="?modulo=empresa&sessao=matriculas"><img src="<?php print("imagens/icones/00037_.gif");?>" border="0"></a></td>
												</tr>
												<tr>
													<td align="center"><a href="?modulo=empresa&sessao=matriculas">Matrículas</a></td>
												</tr>
											</table>
										</td>
										<?php
									}
									?>
								</tr>
								<tr>
									<td colspan="12" style="height: 15px; text-align: center;"><b>Relatórios</b></td>
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
				if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98", "94", "95"))){
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