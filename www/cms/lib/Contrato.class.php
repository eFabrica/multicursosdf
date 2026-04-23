<?php
// Classe de Contratos
Class Contrato {
	
	// Atributos
	//protected $;
	protected $idUnidade;
	protected $idAluno;
	protected $idTurma;
	protected $html;
	protected $mysql;
	protected $rn;
	
	/* Construtor */
	
		public function __construct(){
			
			$this->mysql = new Mysql();
			$this->rn = new Rn();
			
		}
		
	/* Métodos */
	
		// Gera Contrato
		public function geraContrato (){
			
			// Dados de Configuração do Contrato
			$dadosConfig = $this->rn->getDadosTable("contratos", "*", "unidade = '" . $this->idUnidade . "' AND tipo = 'A'");
			
			var_dump($dadosConfig);
			
			// Html
			$this->setHtml("<html>
								<head>
									<title>Contrato</title>
									<style type=\"text/css\">
									<!--
									body, td { font-family: \"Times New Roman\", Times, serif; font-size: 11px; }
									h2 { font-family: \"Times New Roman\", Times, serif; font-size: 12px; }
									h3 { font-family: \"Times New Roman\", Times, serif; font-size: 12px; }
									
									.clausulas { font-family: Arial, Helvetica, sans-serif; font-size: 10px; }
									-->
									</style>
								</head>
								
								<body>
									<table width=\"640\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
										<tr>
											<td align='left'>
												<h3>
												World inform&aacute;tica - Cursos e treinamentos<br />
												C 9 Lote 01 Sala 102 - Taguatinga Centro<br />
												Fone: (61) 3562-2747 - CNPJ: 01.477.706/0001-01
												</h3>
												<h2>Dados do Aluno (contratante) </h2>
												<table width=\"640\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\">
													<tr>
														<td colspan=\"4\">
															<table width=\"640\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
																<tr>
																	<td colspan=\"4\"><strong>Nome</strong>: ABIGAIL PEREIRA DO PRADO</td>
																	<td align='left'><strong>Mat/N&deg;Contrato</strong> 0002016</td>
																</tr>
																<tr>
																	<td align='left'> <strong>RG</strong>: 2468020 </td>
																	<td align='left'><strong>UF</strong>: DF</td>
																	<td align='left'>&nbsp;</td>
																	<td align='left'> <strong>CPF</strong>: 214.478.701-82 </td>
																	<td align='left'><strong>Data de Nasc</strong>.: 07/04/1995</td>
																</tr>
																<tr>
																	<td colspan=\"4\"><strong>Endere&ccedil;o</strong>: COL. AGRI. VICENTE PIRES CH 138 LOTE 33</td>
																	<td align='left'><strong>CEP</strong>: 72800-110 </td>
																</tr>
																<tr>
																	<td align='left'><strong>Cidade</strong>: TAGUATIGA </td>
																	<td align='left'><strong>UF</strong>: DF</td>
																	<td align='left'>&nbsp;</td>
																	<td align='left'><strong>Fone Res</strong>: 3039 5990 </td>
																	<td align='left'><strong>Fone Com</strong>: 4544 5445 <strong>Cel</strong>: 9988 7744</td>
																</tr>
																<tr>
																	<td colspan=\"4\"><strong>Escola</strong>: CENTRO EDUCACIONAL 04 DE TAGUATINGA</td>
																	<td align='left'> <strong>Email</strong>: aluno@hotmail.com</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
												<h2>        Dados do Respons&aacute;vel (contratante)      </h2>
												<table width=\"640\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
													<tr>
														<td colspan=\"4\"><strong>Nome</strong>: ABIGAIL PEREIRA DO PRADO</td>
														<td align='left'>&nbsp;</td>
													</tr>
													<tr>
														<td align='left'> <strong>RG</strong>: 2468020 </td>
														<td align='left'><strong>UF</strong>: DF</td>
														<td align='left'>&nbsp;</td>
														<td align='left'> <strong>CPF</strong>: 214.478.701-82 </td>
														<td align='left'><strong>Data de Nasc</strong>.: 07/04/1995</td>
													</tr>
													<tr>
														<td colspan=\"4\"><strong>Endere&ccedil;o</strong>: COL. AGRI. VICENTE PIRES CH 138 LOTE 33</td>
														<td align='left'><strong>CEP</strong>: 72800-110 </td>
													</tr>
													<tr>
														<td align='left'><strong>Cidade</strong>: TAGUATIGA </td>
														<td align='left'><strong>UF</strong>: DF</td>
														<td align='left'>&nbsp;</td>
														<td align='left'><strong>Fone Res</strong>: 3039 5990 </td>
														<td align='left'><strong>Fone Com</strong>: 4544 5445 Cel: 9988 7744</td>
													</tr>
													<tr>
														<td colspan=\"4\"><strong>Email</strong>: responsavel@hotmail.com</td>
														<td align='left'>&nbsp;</td>
													</tr>
												</table>
												<h2>Curso(s) a ser(em) ministrado(s)</h2>
												<table width=\"640\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">
													<tr>
														<td align='left'><strong>Curso</strong>: OPERADOR DE MICRO </td>
														<td align='left'><strong>Valor total do curso</strong>: R$ 243,00 </td>
														<td align='left'><strong>Dura&ccedil;&atilde;o</strong>: 2 Meses</td>
													</tr>
													<tr>
														<td colspan=\"3\"><strong>Conte&uacute;do</strong>: Digita&ccedil;&atilde;o - Windows XP - Word XP - Excel XP - Internet - Power Point</td>
													</tr>
													<tr>
														<td align='left'><strong>Hor&aacute;rio</strong>: 09:30 - 11:00 Dia(s): S/Q</td>
														<td align='left'><strong>Data de In&iacute;cio</strong>: 11/08/2005 </td>
														<td align='left'><strong>Data T&eacute;rmino</strong>: 13/04/2006</td>
													</tr>
													<tr>
														<td align='left'><strong>Vencimento</strong>: 10 </td>
														<td align='left'><strong>Valor Mat</strong>: R$ 10,00</td>
														<td align='left'><strong>N&ordm; de parcelas</strong>: 9 Valor das parcelas: R$ 27,00</td>
													</tr>
												</table>
												<p>  <strong>OBS</strong>:</p>
												<hr style=\"border:#999999 1px solid\" />
												<p><span class=\"clausulas\"></span><br /></p>
												<table width=\"640\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">
													<tr>
														<td align='left'><strong>Data de Assinatura</strong>: 7/7/2007 </td>
														<td align='left'><strong>Funcion&aacute;rio</strong>: wendel </td>
														<td align='left'><strong>Assinat. Funcion&aacute;rio</strong>: __________________________</td>
													</tr>
													
													<tr>
														<td colspan=\"2\"><strong>Assinat. Aluno</strong>: _______________________________ </td>
														<td align='left'><strong>Assinat. Resp</strong>: _______________________________________</td>
													</tr>
													<tr>
														<td colspan=\"2\">Recebemos o valor de referente a matricula do referido contrato:</td>
														<td align='left'>___/____/____ Assint. ______________</td>
													</tr>
													<tr>
														<td colspan=\"2\">Recebemos o valor de referente a 1&ordf; parcela do referido contrato: <br /></td>
														<td align='left'>___/____/____ Assint. ______________</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</body>
							</html>");
			
		}
	
	/* Sets */ 
	
		public function setUnidade ($valor){
			
			$this->unidade = $valor;
			
		}
		
		public function setAluno ($valor){
			
			$this->aluno = $valor;
			
		}
		
		public function setTurma ($valor){
			
			$this->turma = $valor;
			
		}
		
		public function setHtml ($valor){
			
			$this->html .= $valor;
			
		}
		
		/*
		public function set ($valor){
			
			$this-> = $valor;
			
		}
		*/
	
}

// Instancia Objeto
$_ClassContrato = new Contrato();
?>
