<?php
// Verifica se está logado
if($_dadosLogado->logado == "S" && $_dadosUnidade->acesso == "L"){
	
	// Cod Js
	$_codJs .= "";
	
	$_codJs .= "<script language='javascript' type='text/javascript'>";
	$_codJs .= "function mmLoadMenus() {";
	$_codJs .= "if (window.mm_menu_0712010718_1) return;";
			
		// Gerenciamentos - Rh - Matrículas - Privados
		$_codJs .= "window.mm_menu_0712010718_1_5 = new Menu(\"Privados\",120,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_5.addMenuItem(\"Ex-Aluno\",\"location='?sessao=matriculas&ref=novo'\");\r\n", array("99", "89", "98"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_5.addMenuItem(\"Novo Aluno\",\"location='?sessao=alunos&ref=novo'\");\r\n", array("99", "89", "98"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_5.addMenuItem(\"Consulta\",\"location='?sessao=matriculas'\");\r\n", array("99", "89", "98"));
		$_codJs .= "mm_menu_0712010718_1_5.hideOnMouseOut=true;";
		$_codJs .= "mm_menu_0712010718_1_5.menuBorder=1;";
		$_codJs .= "mm_menu_0712010718_1_5.menuLiteBgColor='#ffffff';";
		$_codJs .= "mm_menu_0712010718_1_5.menuBorderBgColor='#d8d8d8';";
		$_codJs .= "mm_menu_0712010718_1_5.bgColor='#ffffff';";
		
		// Gerenciamentos - Rh - Matrículas - Empresas
		$_codJs .= "window.mm_menu_0712010718_1_4 = new Menu(\"Empresas\",120,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);";
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_4.addMenuItem(\"Ex-Aluno\",\"location='?sessao=matriculas&subsessao=empresas&ref=novo'\");\r\n", array("99", "89", "98"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_4.addMenuItem(\"Novo Aluno\",\"location='?sessao=alunos&ref=novo'\");\r\n", array("99", "89", "98"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_4.addMenuItem(\"Consulta\",\"location='?sessao=matriculas&subsessao=empresas'\");\r\n", array("99", "89", "98"));
		$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1_4.addMenuItem(\"Requerimentos\",\"location='?sessao=matriculas&subsessao=empresas&ref=requerimentos'\");\r\n", array("99", "89", "98"));
		$_codJs .= "mm_menu_0712010718_1_4.hideOnMouseOut=true;";
		$_codJs .= "mm_menu_0712010718_1_4.menuBorder=1;";
		$_codJs .= "mm_menu_0712010718_1_4.menuLiteBgColor='#ffffff';";
		$_codJs .= "mm_menu_0712010718_1_4.menuBorderBgColor='#d8d8d8';";
		$_codJs .= "mm_menu_0712010718_1_4.bgColor='#ffffff';";
	
	// Gerenciamentos
	$_codJs .= "window.mm_menu_0712010718_1 = new Menu(\"root\",126,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);\r\n";
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1.addMenuItem(mm_menu_0712010718_1_5,\"location='#'\");\r\n", array("99", "89", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1.addMenuItem(mm_menu_0712010718_1_4,\"location='#'\");\r\n", array("99", "89", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712010718_1.addMenuItem(\"Consulta Geral\",\"location='?sessao=matriculas&subsessao=consultageral'\");\r\n", array("99", "89", "98"));
	$_codJs .= "mm_menu_0712010718_1.hideOnMouseOut=true;\r\n";
	$_codJs .= "mm_menu_0712010718_1.childMenuIcon=\"imagens/diversos/arrow.gif\";\r\n";
	$_codJs .= "mm_menu_0712010718_1.menuBorder=1;\r\n";
	$_codJs .= "mm_menu_0712010718_1.menuLiteBgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_0712010718_1.menuBorderBgColor='#d8d8d8';\r\n";
	$_codJs .= "mm_menu_0712010718_1.bgColor='#ffffff';\r\n";
	
	// Manutenção
	$_codJs .= "window.mm_menu_0712011423_3 = new Menu(\"root\",80,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);\r\n";
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3.addMenuItem(\"Ativas\",\"location='?sessao=turmasativas'\");\r\n", array("99", "89", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011423_3.addMenuItem(\"Concluídas\",\"location='?sessao=turmasconcluidas'\");\r\n", array("99", "89", "98"));
	$_codJs .= "mm_menu_0712011423_3.hideOnMouseOut=true;\r\n";
	$_codJs .= "mm_menu_0712011423_3.childMenuIcon=\"" . $pathInc . "imagens/diversos/arrow.gif\";";
	$_codJs .= "mm_menu_0712011423_3.menuBorder=1;\r\n";
	$_codJs .= "mm_menu_0712011423_3.menuLiteBgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_0712011423_3.menuBorderBgColor='#d8d8d8';\r\n";
	$_codJs .= "mm_menu_0712011423_3.bgColor='#ffffff';\r\n";
	
	// Relatórios
	$_codJs .= "window.mm_menu_0712011614_4 = new Menu(\"root\",100,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);\r\n";
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Detalhada\",\"location='?sessao=rel_horasaula'\");\r\n", array("99", "89"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Geral\",\"location='?sessao=rel_horasaulageral'\");\r\n", array("99", "89"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_4.addMenuItem(\"Recibo\",\"location='?sessao=rel_recibo'\");\r\n", array("99", "89"));
	$_codJs .= "mm_menu_0712011614_4.hideOnMouseOut=true;\r\n";
	$_codJs .= "mm_menu_0712011614_4.childMenuIcon=\"" . $pathInc . "imagens/diversos/arrow.gif\";";
	$_codJs .= "mm_menu_0712011614_4.menuBorder=1;\r\n";
	$_codJs .= "mm_menu_0712011614_4.menuLiteBgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_0712011614_4.menuBorderBgColor='#d8d8d8';\r\n";
	$_codJs .= "mm_menu_0712011614_4.bgColor='#ffffff';\r\n";
	
	// Relatórios
	$_codJs .= "window.mm_menu_0712011614_5 = new Menu(\"root\",100,16,\"Verdana, Arial, Helvetica, sans-serif\",10,\"#333333\",\"#333333\",\"#f6f6f6\",\"#e7eddf\",\"left\",\"middle\",3,0,1000,3,0,true,true,true,0,true,true);\r\n";
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_5.addMenuItem(\"Provisória\",\"location='?sessao=rel_declaracaoprovisoria'\");\r\n", array("99", "89", "98"));
	$_codJs .= $_ClassPermissao->validaPermissaoSee("mm_menu_0712011614_5.addMenuItem(\"Matrícula\",\"location='?sessao=rel_declaracaomatricula'\");\r\n", array("99", "89", "98"));
	$_codJs .= "mm_menu_0712011614_5.hideOnMouseOut=true;\r\n";
	$_codJs .= "mm_menu_0712011614_5.childMenuIcon=\"" . $pathInc . "imagens/diversos/arrow.gif\";";
	$_codJs .= "mm_menu_0712011614_5.menuBorder=1;\r\n";
	$_codJs .= "mm_menu_0712011614_5.menuLiteBgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_0712011614_5.menuBorderBgColor='#d8d8d8';\r\n";
	$_codJs .= "mm_menu_0712011614_5.bgColor='#ffffff';\r\n";
	$_codJs .= "mm_menu_0712011614_5.writeMenus();\r\n";
	$_codJs .= "}\r\n";
	
	$_codJs .= "	mmLoadMenus();\r\n";
	$_codJs .= "</script>\r\n";
	
	// Exibe Código Js
	print($_codJs);
	?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table_main">
		<tbody>
			<tr style="padding-bottom: 10px;" align="center"> 
				<td align='left'> 
					<div class="cdBodyDiv">
						<div class="cdcontainermaster">
							<div class="cdcontainer">
								<div id="cdnavcontainer">
									<div id="cdnavcont">
										<div id="cdnavheader">
											<ul>
												<?php if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98", "97", "96", "95", "94"))) {?><li id="inicio" <?=(($_modulo == "inicio")?"class=\"current\"":"")?>><a accesskey="1" onmouseover="selecionaAba('inicio')" style="cursor:pointer;"><span>Início</span></a></li><?php }?>
												<?php if ($_ClassPermissao->validaPermissaoSeeReturn(array("95", "98", "99", "89", "94"))) {?><li id="gerenciamentos" <?=(($_modulo == "gerenciamentos")?"class=\"current\"":"")?>><a accesskey="2" onmouseover="selecionaAba('gerenciamentos')" style="cursor:pointer;"><span>Gerenciamentos</span></a></li><?php }?>
												<?php if ($_ClassPermissao->validaPermissaoSeeReturn(array("89", "99", "98", "90"))) {?><li id="financeiro" <?=(($_modulo == "financeiro")?"class=\"current\"":"")?>><a accesskey="3" onmouseover="selecionaAba('financeiro')" style="cursor:pointer;"><span>Financeiro</span></a></li><?php }?>
												<?php if ($_ClassPermissao->validaPermissaoSeeReturn(array("99", "89", "98"))) {?><li id="manutencao" <?=(($_modulo == "manutencao")?"class=\"current\"":"")?>><a accesskey="4" onmouseover="selecionaAba('manutencao')" style="cursor:pointer;"><span>Manutenção</span></a></li><?php }?>
												<?php if ($_ClassPermissao->validaPermissaoSeeReturn(array("95", "99", "89", "98", "94"))) {?><li id="relatorios" <?=(($_modulo == "relatorios")?"class=\"current\"":"")?>><a accesskey="5" onmouseover="selecionaAba('relatorios')" style="cursor:pointer;"><span>Relatórios</span></a></li><?php }?>
											</ul>
										</div>
										<br style="clear: both;">
									</div>
									<div id="cdribbon" class="cdSubwebBgColor">
										<table border="0" cellpadding="0" cellspacing="0" width="100%">
											<tbody>
												<tr valign="top">
													<td class="cdribtopl" width="2">&nbsp;</td>
													<td class="cdribtopc"><div></div></td>
													<td class="cdribtopr" width="2"></td>
												</tr>
												<tr height="79" valign="middle">
													<td class="cdribmidl" width="1"><div></div></td>
													<td class="cdribmidc">
														<div style="padding-top: 1px;">
															<table class="cdribbontext" border="0" cellpadding="0" cellspacing="0">
																<tbody>
																	<tr valign="top">
																		<td width="2"> </td>
																		<td align='left'>
																			<div style="border: 1px solid rgb(219, 230, 244);">
																				<?php
																				// Menus
																				include_once($pathInc . "includes/menu/_inicio.mnu.php");
																				include_once($pathInc . "includes/menu/_gerenciamentos.mnu.php");
																				include_once($pathInc . "includes/menu/_financeiro.mnu.php");
																				include_once($pathInc . "includes/menu/_manutencao.mnu.php");
																				include_once($pathInc . "includes/menu/_relatorios.mnu.php");
																				?>

																			</div>
																			<script>window.setTimeout("selecionaAba('<?=$_modulo?>')", 1);</script>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</td>
													<td class="cdribmidr" width="1"><div></div></td>
												</tr>
												<tr valign="top">
													<td class="cdribbotl" width="2">&nbsp;</td>
													<td class="cdribbotc"></td>
													<td class="cdribbotr" width="2"></td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}
?>