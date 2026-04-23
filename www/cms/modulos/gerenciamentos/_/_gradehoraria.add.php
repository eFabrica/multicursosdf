<?php require_once("php7_mysql_shim.php");
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["turma"], "É preciso informar a Turma."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["data"], "É preciso informar a Data."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["turno"], "É preciso informar o Turno."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["materia"], "É preciso informar a Matéria."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["instrutor"], "É preciso informar o Instrutor."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["sala"], "É preciso informar a Sala."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Classe de Data
		require_once($pathInc . "lib/Data.class.php");
			
		// Verifica Data de Nascimento
		if(!$_ClassData->validaData($_REQUEST["data"])){$_ClassMensagens->setMensagem_erro("Data Inválida.<br>");}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Cadastra Grade Horária
		$cadastraGradeHoraria = $_ClassMysql->query("INSERT INTO `gradehoraria` SET  unidade = '" . $_dadosUnidade->id . "',
																					 turma = '" . $_REQUEST["turma"] . "',
																				  	 data = '" . $_ClassData->transformaData($_REQUEST["data"]) . "',
																				  	 turno = '" . $_REQUEST["turno"] . "',
																				  	 materia = '" . $_REQUEST["materia"] . "',
																				  	 instrutor = '" . $_REQUEST["instrutor"] . "',
																				  	 sala = '" . $_REQUEST["sala"] . "',
																				  	 quemcriou = '" . $_dadosLogado->id . "',
													   							  	 datahorac = now()");
		
		// Verifica se Cadastrou
		if($cadastraGradeHoraria){
			
			// Verifica se Marcou como fixo a turma
			if($_REQUEST["fixaturma"] == "true"){
				
				// Adiciona na Sessão
				$_SESSION["turmaGradeHoraria"] = $_REQUEST["turma"];
				
			}
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Grade Horária gravada com sucesso!<br><br>[ <a href='?sessao=gradehoraria&submenu=" . $_REQUEST["submenu"] . "&ref=novo'>Atualizar</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar esta Grade Horária.<br>");
			
		}
		
	}
	
	?>
	<tr>
		<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
	</tr>
	<tr>
		<td style='height:5px';>&nbsp;</td>
	</tr>
	<?php
	
}

// Verifica Sucesso
if(!$sucesso){
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formGrade">
				<input type="hidden" name="act" value="salvar">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
					<tr>
						<td align="right" width="15%"><b>Filtrar Turmas:</b></td>
						<td width='85%' align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formGrade.turma);carrega('materias&turma='+document.formGrade.turma.options[document.formGrade.turma.selectedIndex].value)"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Turmas:</b></td>
						<td align='left'>
							<select name="turma" onChange="carrega('materias&turma='+this.options[this.selectedIndex].value)">
								<option value=""></option>
								<?php
								// Busca Turmas
								$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND concluido = 'N' AND deletado = 'N'");
								
								// Traz Turmas
								while($trazTurmas = mysql_fetch_object($buscaTurmas)){
									
									// Dados do Curso
									$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazTurmas->curso . "'");
									?>
									<option value="<?php print($trazTurmas->id);?>" <?php print((((($_REQUEST["turma"] != "")?$_REQUEST["turma"]:$_SESSION["turmaGradeHoraria"]) == $trazTurmas->id)?"selected":""));?>><?php print($dadosCurso->sigla);?><?php print($trazTurmas->numero);?></option>
									<?php
									
								}
								?>
							</select>
							<input type="checkbox" name="fixaturma" value="true" <?php print((((($_REQUEST["fixaturma"] != "")?$_REQUEST["fixaturma"]:$_SESSION["turmaGradeHoraria"]) != "")?"checked":""));?>>Fixar para outros registros.
						</td>
					</tr>
					<tr>
						<td align="right" width="15%"><b><font class="obrig">(*)</font> Data:</b></td>
						<td width='85%' align='left'>
							<input type="text" id="data" name="data" size="12" maxlength="10" onKeyUp="maskData(this, document.formGrade.naturalidade)" value="<?php echo $_REQUEST["data"]?>">
							<img src="<?=$pathInc?>imagens/icones/calendar.png" border="0" onClick="popup('CalendarioI', '<?=$pathInc?>includes/calendario.php?mes=<?=date("m")?>&ano=<?=date("Y")?>&idCampo=data', 310, 140, 'no')" style="cursor:pointer;">
						</td>
					</tr>
					<tr>
						<td align="right" valign="top"><b><font class="obrig">(*)</font> Turno:</b></td>
						<td align='left'>
							<select name="turno">
								<?php
								// Busca Turnos
								$buscaTurnos = $_ClassMysql->query("SELECT * FROM `turnos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N' ORDER BY turno ASC");
								
								// Traz Turnos
								while($trazTurnos = mysql_fetch_object($buscaTurnos)){
									
									?>
									<option value="<?php print($trazTurnos->id); ?>" <?php print((($_REQUEST["turno"] == $trazTurnos->id)?"selected":""));?>><?php print($trazTurnos->turno . " (" . $trazTurnos->horarioi . " - " . $trazTurnos->horariof . ")"); ?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Matéria:</b></td>
						<td align='left'>
							<div id="main">
								<select name="materia">
									<option value=""></option>
									<?php
									// Verifica se tem turma
									if($_REQUEST["turma"]  > 0 || $_SESSION["turmaGradeHoraria"] > 0){
									
										// Dados da Turma
										$dadosTurma = $_ClassRn->getDadosTable("turmas", "curso", "id = '" . (($_REQUEST["turma"] != "")?$_REQUEST["turma"]:$_SESSION["turmaGradeHoraria"]) . "'");
											
										// Busca Matérias
										$buscaMaterias = $_ClassMysql->query("SELECT * FROM `materias` WHERE unidade = '" . $_dadosUnidade->id . "' AND curso = '" . $dadosTurma->curso . "' AND deletado = 'N'");
										
										// Traz Matérias
										while($trazMaterias = mysql_fetch_object($buscaMaterias)){
											?>
											<option value="<?php print($trazMaterias->id);?>" <?php print((($_REQUEST["materia"] == $trazMaterias->id)?"selected":""));?>><?php print($trazMaterias->materia);?></option>
											<?php
											
										}
										
									}
									?>
								</select>
							</div>
							<div id="loading"></div>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Instrutores:</b></td>
						<td align='left'>
							<select name="instrutor">
								<option value=""></option>
								<?php								
								// Busca Instrutores
								$buscaInstrutores = $_ClassMysql->query("SELECT * FROM `usuarios` WHERE unidade = '" . $_dadosUnidade->id . "' AND nivel = '95' AND suspenso = 'N' AND deletado = 'N'");
								
								// Traz Instrutores
								while($trazInstrutores = mysql_fetch_object($buscaInstrutores)){
									?>
									<option value="<?php print($trazInstrutores->id);?>" <?php print((($_REQUEST["instrutor"] == $trazInstrutores->id)?"selected":""));?>><?php print($trazInstrutores->nome);?> (<?php print($trazInstrutores->cpf);?>)</option>
									<?php
									
								}
								
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Sala:</b></td>
						<td align='left'><input type="text" name="sala" size="5" value="<?php echo $_REQUEST["sala"]?>"></td>
					</tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios<br />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}
?>