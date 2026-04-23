<?php //require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = '../../';

// Arquivo de Configurações
require_once($pathInc . "inc/config.inc.php");

# Dados de Logado
	
	// Verifica se está logado
	if($_SESSION["dadosLogin"]["idLogado"] > 0){

		// Dados do Logado
		$_dadosLogado = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Dados da Unidade
		$_dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . $_SESSION["idUnidade"] . "' AND deletado = 'N'");

		//var_dump($_dadosUnidade);

		$_dadosCidade = $_ClassRn->getDadosTable("cidades", "*", "id = '" . $_dadosUnidade->cidade . "'");

		//var_dump($_dadosCidade);

		//var_dump($_dadosUnidade->cnpj);

		$cnpj_mask = mask($_dadosUnidade->cnpj,'##.###.###/####-##');

		//var_dump($cnpj_mask);
		
		$crd = "EMP-F/107-06";

	
	}

// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");


function mask($val, $mask)
{
 $maskared = '';
 $k = 0;
 for($i = 0; $i<=strlen($mask)-1; $i++)
 {
 if($mask[$i] == '#')
 {
 if(isset($val[$k]))
 $maskared .= $val[$k++];
 }
 else
 {
 if(isset($mask[$i]))
 $maskared .= $mask[$i];
 }
 }
 return $maskared;
}


// Dados da Unidade
$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N' AND acesso = 'L'");

// Mêses
$meses[1]  = "Janeiro";
$meses[2]  = "Fevereiro";
$meses[3]  = "Mar&ccedil;o";
$meses[4]  = "Abril";
$meses[5]  = "Maio";
$meses[6]  = "Junho";
$meses[7]  = "Julho";
$meses[8]  = "Agosto";
$meses[9]  = "Setembro";
$meses[10] = "Outubro";
$meses[11] = "Novembro";
$meses[12] = "Dezembro";

// Verifica se foi informado algum id separadamente
if($_REQUEST["idMatricula"] > 0){
	
	// Cadastra ele na lista
	$_REQUEST["registros"][] = $_REQUEST["idMatricula"];
	
}

// Verifica se foi encontrado algo
if(count($_REQUEST["registros"]) > 0){
	?>
	<html>
		<head>
			<title>Certificados</title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">		
			<style>
				
				input{
	
					font-family:"Times New Roman", Times, serif;
					color:#00000;
					border:0px;
					text-align:center;
					width:250px;
				
				}
				
				h1, h2, h3, h4, p {margin:0px;}
				
				div#certificado {border:1px solid 2px;width:100%;height:100%;}
			</style>
		</head>
		
		<body style="margin:0px;">
			<?php
			// Lê Matriculas
			for($i = 0; $i < count($_REQUEST["registros"]); $i++){
				
				// Dados da Matricula
				$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_REQUEST["registros"][$i] . "' AND turma > 0 AND reprovado = 'N' AND deletado = 'N'");
				
				// Verifica o total achado
				if($dadosMatricula->concluido == 'S'){
				
					// Dados do Aluno
					$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");
					
					// Dados da Turma
					$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosMatricula->turma . "'");
					
					// Dados do Curso
					$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");

					if($dadosCurso->sigla == 'CC' || $dadosCurso->sigla == 'B'){
						$tamanhoTabela = 521;
					}else{
						$tamanhoTabela = 920;
					}
					
					// Separa data de Início da Turma
					list($anoi, $mesi, $diai) = explode("-", $dadosTurma->datainicio);
					
					// Separa data de Término da Turma
					list($anot, $mest, $diat) = explode("-", $dadosTurma->datatermino);
					
					// Separa data atual
					list($anoa, $mesa, $diaa) = explode("-", date("Y-m-d"));
				
					// Verifica Curso
					if(substr(strtolower($dadosCurso->sigla), 0, 2) != "re"){
						
						// Verifica qual lado do certificado
						if($_REQUEST["tipo"] == "frente" || $_REQUEST["idMatricula"] > 0){
							?>
							<table width="850" height="142" border="0" cellspacing="0" cellpadding="0" style="margin-top:500px;margin-left:85px;">
								<tr>
									<td>
										<div align="justify"> Certificamos que o(a) Senhor(a) <strong><?php print($dadosAluno->nome);?></strong>,
										 RG n&ordm; <?php print($dadosAluno->rg . "-" .strtoupper($dadosAluno->orgexp));?> e CPF n&ordm; <?php print($_ClassUtilitarios->formataCPF($dadosAluno->cpf));?>, frequentou e concluiu com aproveitamento o curso de 
										<strong><?php print(strtoupper($dadosCurso->nome));?> (</strong>Turma: <strong><?php print($dadosCurso->sigla . $dadosTurma->numero);?></strong><strong>),</strong> 
										 ministrado no per&iacute;odo de<strong> 
										<?php print($diai . " de " . $meses[(($mesi < 10)?str_replace("0", "", $mesi):$mesi)] . " de " . $anoi);?> </strong>a<strong> <?php print($diat . " de " . $meses[(($mest < 10)?str_replace("0", "", $mest):$mest)] . " de " . $anot);?> </strong> 
										<?php 
											if($dadosCurso->sigla=="CC"){
												print(", com a carga hor&aacute;ria de 75 horas aula, de acordo com Norma Norma T&eacute;cnica n&ordm; 007/2011 do CBMDF");
											}
											
											if($dadosCurso->sigla=="B"){
												print(", com a carga hor&aacute;ria de 151 horas aula, de acordo com Norma T&eacute;cnica n&ordm; 007/2011 do CBMDF");
											}
											
											if($dadosCurso->sigla=="Bvol"){
												print(", de acordo com Norma Norma T&eacute;cnica n&ordm; 007/2011 do CBMDF");
											}
										?>.
                                        </br></br>
										<div align="center"><?php print($_dadosCidade->cidade . " - " . $_dadosCidade->estado );?>, <?php print($diat . " de " . $meses[(($mest < 10)?str_replace("0", "", $mest):$mest)] . " de " . $anot);?>.</div> <br></div>
										<table border="0" cellspacing="0" cellpadding="0" align="center">
											<tr>
                                            	<td><br>&nbsp;</td>
												<td width="286" valign="top" align="center"> ______________________________________<br />Aluno </td>
												<td width="286" valign="top" align="center"> &nbsp;<br /></td>
												<td width="282" valign="top" align="center"> ______________________________________<br /></td>
											</tr>
											<tr>
												<td colspan="4">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="4">&nbsp;</td>
											</tr>
											<tr>
												<td colspan="4" align="center">
													<p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px;">
														<strong>
															Multicursos Cursos Profissionalizantes CNPJ: <?php print($cnpj_mask);?> CRD <?php print($crd);?>
														</strong>	
													</p>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
							<?php if($i < count($_REQUEST["registros"])-1){?><div style='page-break-after: always;'><span style='display: none;'>&nbsp;</span></div> <?php }?>
							<?php
						}
						
						// Verifica qual lado do certificado
						if ($_REQUEST["tipo"] == "verso" || $_REQUEST["idMatricula"] > 0){
							?>
							<table width="920" border="0" cellspacing="0" cellpadding="0" style="margin-top:50px;margin-left:55px;">
								<tr>
									<td width="<?php print($tamanhoTabela);?>" align="center">
										<table width="<?php print($tamanhoTabela);?>" cellpadding="0" cellspacing="0" border="0" style="border:2px solid #333333;">
											<tr>
												<td colspan="3" align="center" style="border-bottom:2px solid #333333;"><h3 style="margin:10px;">PROGRAMA</h3></td>
											</tr>
											<tr>
												<td height="20" width="419" align="center" style="border-bottom:2px solid #333333;"><h3>MAT&Eacute;RIAS</h3></td>
												<td width="43" align="center" style="border-left:2px solid #333333;border-bottom:2px solid #333333;"><h3>CH</h3></td>
												<td width="43" align="center" style="border-left:2px solid #333333;border-bottom:2px solid #333333;"><h3>NT</h3></td>
											</tr>
											<?php
											// Total de notas inteiras
											$totNota = 0;
											
											// Total de atividades curriculares
											$totATCU = 0;
											
											// Total de Carga Horária
											$totCargaHoraria = 0;
											
											// Busca Matérias do curso
											$buscaMaterias = $_ClassMysql->query("SELECT * FROM `materias` WHERE unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $dadosCurso->id . "' AND sigla != 'AA' AND deletado = 'N'");
											
											// Traz matérias
											while ($trazMaterias = mysql_fetch_object($buscaMaterias)){
												
												// Nota do Aluno nesta matéria
												$notaAluno = $_ClassRn->getDadosTable("notas", "*", "matricula = '" . $dadosMatricula->id . "' AND materia = '" . $trazMaterias->id . "'");
												?>
												<tr>
													<td height="20" style="border-bottom:2px solid #333333;">&nbsp;<?php print($trazMaterias->materia . " (" . $trazMaterias->sigla . ") <br>" . nl2br($trazMaterias->descricao));?></td>
													<td align="center" style="border-left:2px solid #333333;border-bottom:2px solid #333333;">&nbsp;<strong><?php print($trazMaterias->cargahoraria);?></strong></td>
													<td align="center" style="border-left:2px solid #333333;border-bottom:2px solid #333333;">&nbsp;<strong><?php print($notaAluno->nota);?></strong></td>
												</tr>
												<?php
												// Verifica se a nota é inteira
												if(ctype_digit(preg_replace("/[,.]/", "", $notaAluno->nota))){
													
													// Nota
													$nota = str_replace(",", ".", $notaAluno->nota);
													
													// Incrementa total de notas inteiras
													$totNota++;
													
													// Totaliza o total de atividades curriculares
													$totATCU += $nota;
													
												}
												
												// Total de Carga Horária
												$totCargaHoraria +=$trazMaterias->cargahoraria;
												
											}
											?>
											<tr>
												<td height="20" style="border-bottom:2px solid #333333;"><h3>ATIVIDADES CURRICULARES</h3></td>
												<td align="center" style="border-left:2px solid #333333;border-bottom:2px solid #333333;">&nbsp;<b><?php print($totCargaHoraria);?></b></td>
												<td align="center" style="border-left:2px solid #333333;border-bottom:2px solid #333333;">---</td>
											</tr>
											<?php
											// Avaliaçao de Aprendizagem
											$AA = $_ClassRn->getDadosTable("materias", "cargahoraria", "unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $dadosCurso->id . "' AND sigla = 'AA'");
											?>
											<tr>
												<td height="20" style="border-bottom:2px solid #333333;"><h3>AVALIA&Ccedil;&Atilde;O DE APRENDIZAGEM</h3></td>
												<td align="center" style="border-left:2px solid #333333;border-bottom:2px solid #333333;">&nbsp;<b><?php print($AA->cargahoraria);?></b></td>
												<td align="center" style="border-left:2px solid #333333;border-bottom:2px solid #333333;">---</td>
											</tr>
											<tr>
												<td height="20" style="border-bottom:2px solid #333333;"><h3>TOTAL CH/M&Eacute;DIA FINAL</h3></td>
												<td align="center" style="border-left:2px solid #333333;border-bottom:2px solid #333333;">&nbsp;<b><?php print(($totCargaHoraria+$AA->cargahoraria));?></b></td>
												<td align="center" style="border-left:2px solid #333333;border-bottom:2px solid #333333;">&nbsp;<b><?php
													// Media Final: usa valor editavel salvo na matricula; se vazio, cai no calculo automatico
													$mediaAutomatica = number_format(round($totATCU/(($totNota <= 0)?1:$totNota), 2), 1, ",", ".");
													print(($dadosMatricula->mediafinal != "") ? $dadosMatricula->mediafinal : $mediaAutomatica);
												?></b></td>
											</tr>
											<tr>
												<td colspan="3">
													<table width="<?php print($tamanhoTabela);?>" cellpadding="0" cellspacing="0" border="0">
														<tr>
															<td align="center" valign="top" width="331">
																<?php
																// Verifica qual curso
																if(substr(strtolower($dadosCurso->sigla), 0, 2) == "ex"){
																	
																	// Exibe texto
																	print("REG. DE FORMA&Ccedil;&Atilde;O NO DPF - <BR> N&ordm; <b>" . $dadosAluno->numerorg . "</b>, em <b>" . $_ClassData->transformaData($dadosAluno->dataform, 2) . ".</b><br><br>");
																	
																}
																?>
																<b>OBSERVA&Ccedil;&Otilde;ES</b><br /><br />
																<?php print($dadosUnidade->razaosocial);?><br><Br> 
																<strong><?php print($dadosAluno->nome);?></strong><br />
																CPF n&ordm; <?php print($_ClassUtilitarios->formataCPF($dadosAluno->cpf));?> / Registro n&ordm; <strong><?php print($dadosMatricula->id);?></strong>
																<div style="margin-top:50px;">&nbsp;</div>
															</td>
															<td valign="top" width="190" style="border-left:2px solid #333333; margin-left: 10px">
																<b>&nbsp;&nbsp;LEGENDA DE NOTAS</b> <br />
																<br />
																<strong>&nbsp;I</strong> - Insuficiente (Reprovado)<br />
																<strong>&nbsp;R </strong>- Regular (Aprovado)<br />
																<strong>&nbsp;B </strong>- Bom (Aprovado)<br />
																<strong>&nbsp;M</strong> - Muito Bom (Aprovado)<br />
																<strong>&nbsp;E </strong>- Excelente (Aprovado)
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
																										
									<?php 
										
										if($dadosCurso->sigla == 'CC' || $dadosCurso->sigla == 'B'){ 
											print("<td width='399' style='border:2px solid #333333;border-left:0px;' align='center'><img src='carimboSECRE.png' width='92%'></td>");
										}									
									?>									
										
								</tr>														
							</table>
							<br>
							<table width="920" border="0" cellspacing="0" cellpadding="0" style="margin-top:10px;margin-left:55px;">
								<tr>
									<td>
										<p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 15px;">
										  <strong>
											Multicursos - Cursos Profissionalizantes - <?php print($_dadosUnidade->endereco);?><br>
											<?php print($_dadosCidade->cidade . " / " . $_dadosCidade->estado );?> - Fone: (61) <?php print($_dadosUnidade->telefonefixo);?>
											</strong>	
										</p>
										</td>
									</tr>
							</table>
							
							

							<?php if($i < count($_REQUEST["registros"])-1){?><div style='page-break-after: always;'><span style='display: none;'>&nbsp;</span></div> <?php }?>
							<?php
						}
						
					}else{
						
						?>
						<table width="650" border="0" cellspacing="0" cellpadding="0" style="margin-top:250px;" align="center">
							<tr>
								<td align="center"><b>Autorizada a funcionar pela Portaria  MJ-DPF 690 de 16/07/02</b></td>
							</tr>
							<tr>
								<td style="border:2px solid #000000;" align="center"><h2><?php print(strtoupper("DECLARA&Ccedil;&Atilde;O de " . $dadosCurso->nome));?></h2></td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr>
								<td>
									<div align="justify" style="line-height:200%;">
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										Declaramos para os devidos fins que o Senhor(a) <strong><?php print(strtoupper($dadosAluno->nome));?></strong>,
										 filho (a) de <?php print(strtoupper($dadosAluno->pai . " e " . $dadosAluno->mae));?>, 
										nascido(a) em <?php print($_ClassData->transformaData($dadosAluno->datanascimento, 2));?>, 
										natural de <?php print(strtoupper($dadosAluno->naturalidade) . "-" . $dadosAluno->ufnaturalidade);?>, portador (a) do 
										CPF n&ordm; <?php print($_ClassUtilitarios->formataCPF($dadosAluno->cpf));?>, concluiu com 
										aproveitamento o curso de <strong> <?php print(strtoupper($dadosCurso->nome));?> 
										(</strong><u>Turma: <?php print($dadosCurso->sigla . $dadosTurma->numero);?></u><strong>) </strong>, 
										neste estabelecimento de ensino no per&iacute;odo de 
										<strong><?php print($diai . " de " . $meses[(($mesi < 10)?str_replace("0", "", $mesi):$mesi)] . " de " . $anoi);?> </strong>
										a<strong> <?php print($diat . " de " . $meses[(($mest < 10)?str_replace("0", "", $mest):$mest)] . " de " . $anot);?></strong>, 
										conforme programa de mat&eacute;rias estabelecido pela Portaria n&ordm; 387/2006-DG/DPF.
									</div>
								</td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr>
								<td>
									<table border="0" cellspacing="0" cellpadding="0" width="100%">
										<tr>
											<td width="70%" valign="top" align="center" style="border:2px solid #000000;"><strong>MAT&Eacute;RIAS</strong></td>
											<td width="15%" valign="top" align="center" style="border:2px solid #000000;border-left:0px;"><strong>Carga Hor&aacute;ria</strong></td>
											<td width="15%" valign="top" align="center" style="border:2px solid #000000;border-left:0px;"><strong>NT</strong></td>
										</tr>
										<?php
										// Contador de Matérias
										$contMat = 1;
										
										// Total de Carga Horária
										$totCargaHoraria = 0;
										
										// Busca Matérias do curso
										$buscaMaterias = $_ClassMysql->query("SELECT * FROM `materias` WHERE unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $dadosCurso->id . "' AND sigla != 'AA' AND deletado = 'N'");
										
										// Traz matérias
										while ($trazMaterias = mysql_fetch_object($buscaMaterias)){
											
											// Nota do Aluno nesta matéria
											$notaAluno = $_ClassRn->getDadosTable("notas", "*", "matricula = '" . $dadosMatricula->id . "' AND materia = '" . $trazMaterias->id . "'");
											?>
											<tr>
												<td valign="top" style="border:2px solid #000000;border-top:0px;"><h4><?php print($contMat++);?>-)&nbsp;<em><?php print($trazMaterias->materia . "<br>" . $trazMaterias->descricao);?></em></h4></td>
												<td valign="top" align="center" style="border:2px solid #000000;border-top:0px;border-left:0px;">&nbsp;<strong><?php print($trazMaterias->cargahoraria);?></strong></td>
												<td valign="top" align="center" style="border:2px solid #000000;border-top:0px;border-left:0px;">&nbsp;<strong><?php print($notaAluno->nota);?></strong></td>
											</tr>
											<?php
											// Total de Carga Horária
											$totCargaHoraria +=$trazMaterias->cargahoraria;
											
										}
										?>
										<tr>
											<td valign="top"style="border:2px solid #000000;border-top:0px;">Atividades Curriculares</td>
											<td valign="top" align="center" style="border:2px solid #000000;border-top:0px;border-left:0px;">&nbsp;<strong><?php print($totCargaHoraria);?></strong></td>
											<td valign="top" align="center" style="border:2px solid #000000;border-top:0px;border-left:0px;"><strong>----</strong></td>
										</tr>
										<?php
										// Avaliaçao de Aprendizagem
										$AA = $_ClassRn->getDadosTable("materias", "cargahoraria", "unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $dadosCurso->id . "' AND sigla = 'AA'");
										?>
										<tr>
											<td valign="top"style="border:2px solid #000000;border-top:0px;">Avalia&ccedil;&atilde;o de Aprendizagem</td>
											<td valign="top" align="center" style="border:2px solid #000000;border-top:0px;border-left:0px;">&nbsp;<strong><?php print($AA->cargahoraria);?></strong></td>
											<td valign="top" align="center" style="border:2px solid #000000;border-top:0px;border-left:0px;"><strong>----</strong></td>
										</tr>
										<tr>
											<td valign="top"style="border:2px solid #000000;border-top:0px;"><h4>Total Carga Hor&aacute;ria</h4></td>
											<td valign="top" align="center" style="border:2px solid #000000;border-top:0px;border-left:0px;">&nbsp;<strong><?php print($totCargaHoraria+$AA->cargahoraria);?></strong></td>
											<td valign="top" align="center" style="border:2px solid #000000;border-top:0px;border-left:0px;"><strong>----</strong></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td style="border:2px solid #000000;border-top:0px;">
									<b><em>Registro do Certificado do Curso de Forma&ccedil;&atilde;o de Vigilantes no SR/DPF/<?php print($dadosAluno->orgao);?><br>
									n&ordm; <?php print($dadosAluno->numerorg);?> Livro <?php print($dadosAluno->livro);?> - Folha <?php print($dadosAluno->folha);?>
									em <?php print($_ClassData->transformaData($dadosAluno->dataform, 2));?><br>
									na Academia <?php print(strtoupper($dadosAluno->academiaform));?></em></b>
								</td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr>
								<td align="center"><input type="text" value="Bras&iacute;lia - DF, <?php print($diat . " de " . $meses[(($mest < 10)?str_replace("0", "", $mest):$mest)] . " de " . $anot);?>">.</td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr>
								<td><br /></td>
							</tr>
							<tr>
								<td align="center"><input type="text" value="Gelbis de Souza Junior"><br /><input type="text" value="Diretor"></td>
							</tr>
						</table>
						<div style='page-break-after: always;'><span style='display: none;'>&nbsp;</span></div> 
						<?php
						
					}
					
				}
			
			}
			?>
		</body>
	</html>
	<?php
}
?>