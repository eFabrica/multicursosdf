<?php require_once("php7_mysql_shim.php");
// Verifica se foi informado alguma turma
if($_REQUEST["turma"] > 0){
	
	// Dados da Turma
	$dadosTurmaValidacao = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_REQUEST["turma"] . "' AND curso = '2' AND datainicio > now()");
	
	// Valida Turma
	if ($_ClassRn->getTot() <= 0){print("Operação Inválida");exit();}
	
}else{
	
	// Se te sessão
	if($_SESSION["matricular"]["idTurma"] > 0){
	
		// Dados da Turma
		$dadosTurmaValidacao = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_SESSION["matricular"]["idTurma"] . "' AND curso = '2' AND datainicio > now()");
		
		// Valida Turma
		if ($_ClassRn->getTot() <= 0){unset($_SESSION["matricular"]["idTurma"]);print("Operação Inválida");exit();}
	
	}
	
}
	
// Classe de Data
require_once($pathInc . "lib/Data.class.php");
?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00018.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico"> Matricular
						<?php
						// Verifica Etapas
						switch($_REQUEST["etapa"]){
							
							// Caso 2
							case "2": print(" - Confirmação de Vagas"); break;
							
							// Caso 3
							case "3": print(" - Relação de Alunos"); break;
							
							// Caso 4
							case "4": print(" - Comprovante"); break;
							
							// Default
							default: print(" - Selecionar Turma");
							
						}
						?>
					</td>
					<td align="right">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td align="left">
						<font class="menu_topico">Etapas [ </font>
						<?php //print((($_REQUEST["etapa"] == "")?"<b></b>":"")); ?>
						<?php print((($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == "")?"<b>Selecionar Turma</b>":"Selecionar Turma")); ?>
						|
						<?php print((($_REQUEST["etapa"] == "2")?"<b>Confirmação de Vagas</b>":"Confirmação de Vagas")); ?>
						|
						<?php print((($_REQUEST["etapa"] == "3")?"<b>Relação de Alunos</b>":"Relação de Alunos")); ?>
						|
						<?php print((($_REQUEST["etapa"] == "4")?"<b>Comprovante</b>":"Comprovante")); ?>
						<font class="menu_topico"> ]</font>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
	// Busca Reservas
	$buscaReservas = $_ClassMysql->query("SELECT * FROM `clientes_reservas_matriculas` WHERE cliente = '" . $_dadosLogado->id . "'");
	
	// Verifica o total achado
	if(mysql_num_rows($buscaReservas) <= 0 && $_REQUEST["etapa"] <= 1){
		?>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align="left"><div id="border-top-e"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main_e">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td class="menu_topico_e">Reservas Abertas</td>
					</tr>
					<tr>
						<td align="left">
							<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
								<?php
								// Busca Cursos
								$buscaCursos = $_ClassMysql->query("SELECT * FROM `cursos` WHERE deletado = 'N' AND unidade = '" . $_dadosLogado->unidade . "' AND id = '2'");
								
								// Traz Cursos
								while($trazCursos = mysql_fetch_object($buscaCursos)){
									?>
									<tr>
										<td align="left"><img src="<?php print($pathInc . "imagens/diversos/setaG.jpg");?>"><b><?php print($trazCursos->nome);?></b></td>
									</tr>
									<?php
									// Busca Turmas
									$buscaTurmas = $_ClassMysql->query("SELECT clientes_reservas_matriculas.id,
																			   clientes_reservas_matriculas.qtd,
																			   turmas.datainicio,
																			   turmas.turno FROM `turmas`,`clientes_reservas_matriculas` WHERE turmas.id = clientes_reservas_matriculas.turma AND 
																																			   clientes_reservas_matriculas.cliente = '" . $_dadosLogado->empresa . "' AND
																																			   clientes_reservas_matriculas.deletado = 'N' AND
																																			   turmas.curso = '" . $trazCursos->id . "' ORDER BY turmas.datainicio ASC");
									
									// Traz Curss
									while($trazTurmas = mysql_fetch_object($buscaTurmas)){
										
										// Dados do Turno
										$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $trazTurmas->turno . "'");
										?>
										<tr>
											<td align="left">
												<script>
												function atualizaTempoReserva<?php print($trazTurmas->id);?> (){
													
													// Objeto Ajax
													objAjax<?php print($trazTurmas->id);?> = new AJAX();
													
													// Obejtos
												    var vagas<?php print($trazTurmas->id);?> = document.getElementById("<?php print($trazTurmas->id);?>");
												    
												    //Abre a url
												    objAjax<?php print($trazTurmas->id);?>.open("GET", "<?php print ($pathInc);?>includes/aplicacoes.php?ref=atualizaTempoReserva&idReserva=<?php print($trazTurmas->id);?>",true);
													
													//evita amarzenamento em cache
													objAjax<?php print($trazTurmas->id);?>.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate"); 
												    objAjax<?php print($trazTurmas->id);?>.setRequestHeader("Cache-Control", "post-check=0, pre-check=0"); 
												    objAjax<?php print($trazTurmas->id);?>.setRequestHeader("Pragma", "no-cache");
													
												    //Executada quando o navegador obtiver o código
												    objAjax<?php print($trazTurmas->id);?>.onreadystatechange=function() {
												        if (objAjax<?php print($trazTurmas->id);?>.readyState==4){
															if (objAjax<?php print($trazTurmas->id);?>.status == 200) {
																
																// Texto
																texto = url_decode(objAjax<?php print($trazTurmas->id);?>.responseText);
																
																// Verifica texto
																if(texto == "nops"){
																
																	// Redireciona
																	location.href = '?modulo=empresa&sessao=matricular';
																	
																}else{
																
																	vagas<?php print($trazTurmas->id);?>.innerHTML = texto;
																
																}
																
															}
															
												        }
												        
												    }
												    
												    // Limpa Cache
												    objAjax<?php print($trazTurmas->id);?>.send(null)
													
													// Loop
													window.setTimeout("atualizaTempoReserva<?php print($trazTurmas->id);?>()", (1000*1));
													
												}
												
												// Chama a Função
												window.setTimeout("atualizaTempoReserva<?php print($trazTurmas->id);?>()", (1000*1));
												</script>
												<ol>
													<div id="<?php print($trazTurmas->id);?>">
														<img src="<?php print($pathInc . "imagens/diversos/setaGi.jpg");?>">
														<a href="?modulo=empresa&sessao=matricular&etapa=3&idReserva=<?php print($trazTurmas->id);?>">
															<?php print($_ClassData->transformaData($trazTurmas->datainicio, 2) . " - " . $dadosTurno->turno . "(" . $trazTurmas->qtd . " Vagas. <b>Tempo Restante:</b>)");?>
														</a>
													</div>
												</ol>
											</td>
										</tr>
										<?php
									}
									
								}
								?>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left"><div id="border-bottom-e"><div><div></div></div></div></td>
		</tr>
		<?php
	}
	?>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	// Verifica Etapa
	switch ($_REQUEST["etapa"]) {
		
		case "1": require_once($pathInc . "modulos/empresas/_/_matricular.etapa1.php"); break;
		case "2": require_once($pathInc . "modulos/empresas/_/_matricular.etapa2.php"); break;
		case "3": require_once($pathInc . "modulos/empresas/_/_matricular.etapa3.php"); break;
		case "4": require_once($pathInc . "modulos/empresas/_/_matricular.etapa4.php"); break;
		default: require_once($pathInc . "modulos/empresas/_/_matricular.etapa1.php");
		
	}
	?>
</table>