<?php
// Classe de Boleto
class Boleto {
	
	// Atributos
	protected $localpagamento;
	protected $cedente;
	protected $instrucoes;
	protected $vencimento;
	protected $nossonumero;
	protected $valordocumento;
	protected $descontosabatimentos;
	protected $moramulta;
	protected $outrosacrescimos;
	protected $valorcobrado;
	protected $responsavel;
	protected $aluno;
	protected $telefone;
	protected $html;
	protected $boleto;
	
	/* Construtor */
	public function __construct(){
		
		
		
	}
	
	/* Constrói Boleto */
	public function constroiBoleto ($quebraPag = ""){
		
		// HTML
		$this->setBoleto("		<table width='640'>
									<tr>
										<td align='left'>
											<TABLE width=100% border=0>
												<TBODY>
													<TR>
														<TD>
															<IMG src='../../imagens/diversos/logo_proginfo.png' width=133 height=26 align='left'>
															<DIV align=right><FONT face=Arial size=2><B>RECIBO DO SACADO</B></FONT></DIV>
														</TD>
													</TR>
												</TBODY>
											</TABLE>
										</td>
										<td align='left'>
											<TABLE cellSpacing=0 cellPadding=0 width=100% border=0>
												<TBODY>
													<TR>
														<TD>
															<img src='../../imagens/diversos/logo_proginfo.png' width=133 height=26 align='left'>
															<DIV align=right><FONT face=Arial size=2><B>RECIBO DE ENTREGA</B></FONT></DIV>
														</TD>
													</TR>
												</TBODY>
											</TABLE>
										</td>
									</tr>
									<tr>
										<td width='320' valign='top' style='BORDER-TOP: 0px dashed; BORDER-LEFT: 0px dashed;BORDER-RIGHT: 0px dashed; BORDER-TOP-STYLE: dashed; BORDER-BOTTOM: 1px dashed'>
											<TABLE style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' cellSpacing=0 cellPadding=1 border=1>
												<TBODY>
													<TR>
														<TD width='200' vAlign=top style='BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px'>
															<TABLE cellSpacing=0 cellPadding=1 width='100%' border=0>
																<TBODY>
																	<TR>
																		<TD vAlign=top height='9'><span class='titulo'>Local de Pagamento:</span></TD>
																	</TR>
																	<TR>
																		<TD vAlign=top height='9'><span class='valor'>" . $this->localpagamento . "</span></TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
														<TD width='120' style='BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px'>
															<TABLE height='100%' cellSpacing=0 cellPadding=1 width='100%' border=0>
																<TBODY>
																	<TR>
																		<TD height='9'><span class='titulo'>Vencimento</span></TD>
																	</TR>
																	<TR>
																		<TD height='9'><span class='valor'>" . $this->vencimento . "</span></TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
													</TR>
													<TR>
														<TD style='BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' vAlign=top>
															<TABLE cellSpacing=0 cellPadding=0 width='100%' border=0>
																<TBODY>
																	<TR>
																		<TD vAlign=top><span class='titulo'>Cedente</span><br /></TD>
																	</TR>
																	<TR>
																		<TD vAlign=top><span class='valor'>" . $this->cedente . "</span><br /></TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
														<TD style='BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px'>
															<TABLE cellSpacing=0 cellPadding=1 width='100%' border=0>
																<TBODY>
																	<TR>
																		<TD><span class='titulo'>Nosso N&uacute;mero</span><br /></TD>
																	</TR>
																	<TR>
																		<TD><span class='valor'>" . $this->nossonumero . "</span><br /></TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
													</TR>
													<TR>
														<TD style='BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' vAlign=top>
															<TABLE cellSpacing=0 cellPadding=0 width='100%' border=0>
																<TBODY>
																	<TR vAlign=center>
																		<TD vAlign=top height=20><span class='titulo'>Instru&ccedil;&otilde;es</span><br /></TD>
																	</TR>
																	<TR vAlign=top>
																		<TD>
																			<span class='titulo'>
																			" . $this->instrucoes . "
																			</span>
																		</TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
														<TD valign='top' style='BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px'>
															<TABLE style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' cellSpacing=0 cellPadding=1 width='100%' border=1>
																<TBODY>
																	<TR vAlign=top>
																		<TD style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' height=20>
																			<span class='titulo'>(=) Valor do Documento <br /></span>
																			<span class='valor'>" . $this->valordocumento . "</span>
																		</TD>
																	</TR>
																	<TR vAlign=top>
																		<TD style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' height=20>
																			<span class='titulo'>(-) Descontos/Abatimento <br /></span> 
																			<span class='valor'>" . $this->descontosabatimentos . "</span>
																		</TD>
																	</TR>
																	<TR vAlign=top>
																		<TD style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' height=20>
																			<span class='titulo'>(+) Mora/Multa </span><br />
																			<span class='valor'>" . $this->moramulta . "</span>
																		</TD>
																	</TR>
																	<TR vAlign=top>
																		<TD style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' height=20>
																			<span class='titulo'>(+) Outros Acr&eacute;scimos </span><br />
																			<span class='valor'>" . $this->outrosacrescimos . "</span><br />
																		</TD>
																	</TR>
																	<TR vAlign=top>
																		<TD style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' height=20>
																			<span class='titulo'>(=) Valor Cobrado </span><br />
																			<span class='valor'>" . $this->valorcobrado . "</span><br />
																		</TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
													</TR>
													<TR>
														<TD style='BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' colSpan=2>
															<TABLE cellSpacing=0 cellPadding=0 width='100%' border=0>
																<TBODY>
																	<TR>
																	<TD vAlign=top style='BORDER-TOP-WIDTH: 0px'>
																		<span class='sacado'>
																			Resp: " . $this->responsavel . "<br />
																			Alun: " . $this->aluno . "<br />
																			Fone: " . $this->telefone . "
																		</span><br />
																	</TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
													</TR>
												</TBODY>
											</TABLE>
										</td>
										<td width='320' valign='top' style='BORDER-TOP: 0px dashed; BORDER-LEFT: 1px dashed;BORDER-RIGHT: 0px dashed; BORDER-TOP-STYLE: dashed; BORDER-BOTTOM: 1px dashed'>
											<TABLE style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' cellSpacing=0 cellPadding=1 border=1>
												<TBODY>
													<TR>
														<TD width='200' vAlign=top style='BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px'>
															<TABLE cellSpacing=0 cellPadding=1 width='100%' border=0>
																<TBODY>
																	<TR>
																		<TD vAlign=top height='9'><span class='titulo'>Local de Pagamento:</span></TD>
																	</TR>
																	<TR>
																		<TD vAlign=top height='9'><span class='valor'>" . $this->localpagamento . "</span></TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
														<TD width='120' style='BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px'>
															<TABLE height='100%' cellSpacing=0 cellPadding=1 width='100%' border=0>
																<TBODY>
																	<TR>
																		<TD height='9'><span class='titulo'>Vencimento</span></TD>
																	</TR>
																	<TR>
																		<TD height='9'><span class='valor'>" . $this->vencimento . "</span></TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
													</TR>
													<TR>
														<TD style='BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' vAlign=top>
															<TABLE cellSpacing=0 cellPadding=0 width='100%' border=0>
																<TBODY>
																	<TR>
																		<TD vAlign=top><span class='titulo'>Cedente</span><br /></TD>
																	</TR>
																	<TR>
																		<TD vAlign=top><span class='valor'>" . $this->cedente . "</span><br /></TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
														<TD style='BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px'>
															<TABLE cellSpacing=0 cellPadding=1 width='100%' border=0>
																<TBODY>
																	<TR>
																		<TD><span class='titulo'>Nosso N&uacute;mero</span><br /></TD>
																	</TR>
																	<TR>
																		<TD><span class='valor'>" . $this->nossonumero . "</span><br /></TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
													</TR>
													<TR>
														<TD style='BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' vAlign=top>
															<TABLE cellSpacing=0 cellPadding=0 width='100%' border=0>
																<TBODY>
																	<TR vAlign=center>
																		<TD vAlign=top height=20><span class='titulo'>Instru&ccedil;&otilde;es</span><br /></TD>
																	</TR>
																	<TR vAlign=top>
																		<TD>
																			<span class='titulo'>
																			" . $this->instrucoes . "
																			</span>
																		</TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
														<TD valign='top' style='BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px'>
															<TABLE style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' cellSpacing=0 cellPadding=1 width='100%' border=1>
																<TBODY>
																	<TR vAlign=top>
																		<TD style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' height=20>
																			<span class='titulo'>(=) Valor do Documento <br /></span>
																			<span class='valor'>" . $this->valordocumento . "</span>
																		</TD>
																	</TR>
																	<TR vAlign=top>
																		<TD style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' height=20>
																			<span class='titulo'>(-) Descontos/Abatimento <br /></span> 
																			<span class='valor'>" . $this->descontosabatimentos . "</span>
																		</TD>
																	</TR>
																	<TR vAlign=top>
																		<TD style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' height=20>
																			<span class='titulo'>(+) Mora/Multa </span><br />
																			<span class='valor'>" . $this->moramulta . "</span>
																		</TD>
																	</TR>
																	<TR vAlign=top>
																		<TD style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' height=20>
																			<span class='titulo'>(+) Outros Acr&eacute;scimos </span><br />
																			<span class='valor'>" . $this->outrosacrescimos . "</span><br />
																		</TD>
																	</TR>
																	<TR vAlign=top>
																		<TD style='BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' height=20>
																			<span class='titulo'>(=) Valor Cobrado </span><br />
																			<span class='valor'>" . $this->valorcobrado . "</span><br />
																		</TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
													</TR>
													<TR>
														<TD style='BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px' colSpan=2>
															<TABLE cellSpacing=0 cellPadding=0 width='100%' border=0>
																<TBODY>
																	<TR>
																	<TD vAlign=top style='BORDER-TOP-WIDTH: 0px'>
																		<span class='sacado'>
																			Resp: " . $this->responsavel . "<br />
																			Alun: " . $this->aluno . "<br />
																			Fone: " . $this->telefone . "
																		</span><br />
																	</TD>
																	</TR>
																</TBODY>
															</TABLE>
														</TD>
													</TR>
												</TBODY>
											</TABLE>
										</td>
									</tr>
								</table>" . $quebraPag);
		
	}
	
	/* Gera Boleto */
	public function geraBoleto (){
		
		// HTML
		$this->setHtml("<HTML>
							<HEAD>
								<TITLE>Boleto Prog-Info</TITLE>
								<style type='text/css'>
									.todos { BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px }
									.fundolateral { BORDER-LEFT-WIDTH: 0px; BORDER-BOTTOM-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px }
									.altolateral { BORDER-TOP-WIDTH: 0px; BORDER-LEFT-WIDTH: 0px; BORDER-RIGHT-WIDTH: 0px }
									.titulo { font-family: Arial, Helvetica, sans-serif; font-size: 9px; font-weight: normal; }
									.valor { font-family: Arial, Helvetica, sans-serif; font-size: 9px; font-weight: bold; text-align: center; }
									.sacado { font-family: Arial, Helvetica, sans-serif; font-size: 9px; font-weight: bold; }
									body { margin: 0px; padding: 0px; }
								</style>
							</HEAD>
							<BODY>
								" . $this->boleto . "
							</BODY>
						</HTML>");
		
		// Exibe Boleto
		print($this->html);
		
	}
	
	/* Sets */
	
		public function setLocalPagamento 		($valor){$this->localpagamento = $valor;}
		public function setCedente 				($valor){$this->cedente = $valor;}
		public function setInstrucoes 			($valor){$this->instrucoes = $valor;}
		public function setVencimento 			($valor){$this->vencimento = $valor;}
		public function setNossoNumero 			($valor){$this->nossonumero = $valor;}
		public function setValorDocumento 		($valor){$this->valordocumento = $valor;}
		public function setDescontosAbatimentos ($valor){$this->descontosabatimentos = $valor;}
		public function setMoraMulta 			($valor){$this->moramulta = $valor;}
		public function setOutrosAcrescimos 	($valor){$this->outrosacrescimos = $valor;}
		public function setValorCobrado 		($valor){$this->valorcobrado = $valor;}
		public function setResponsavel 			($valor){$this->responsavel = $valor;}
		public function setAluno 				($valor){$this->aluno = $valor;}
		public function setTelefone 			($valor){$this->telefone = $valor;}
		public function setBoleto 				($valor){$this->boleto .= $valor;}
		public function setHtml 				($valor){$this->html .= $valor;}
	
}

// Instância a Classe
$_ClassBoleto = new Boleto();
?>

