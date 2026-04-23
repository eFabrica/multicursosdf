<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["numero"], "É preciso selecionar um Número."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["curso"], "É preciso selecionar um Curso."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["turno"], "É preciso selecionar um Turno."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["duracao"], "É preciso informar a duração."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["vagas"], "É preciso informar a quantidade de vagas."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["datainicio"], "É preciso informar a data de início."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["datatermino"], "É preciso informar a data de término."));
		
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Classe de Data
		require_once($pathInc . "lib/Data.class.php");
		
		// Verifica se tem erro
		if($_ClassMensagens->getMensagem_erro() == ""){
			
			// Verifica se a duração é um valor numério
			if(!ctype_digit($_REQUEST["duracao"])){
				
				// Seta erro
				$_ClassMensagens->setMensagem_erro("Utilize somente número para informar a duração.<br>");
				
			}
			
		}
		
		// Verifica se o número só contém Números
		if(!is_int((int)$_REQUEST["numero"])){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("O número da Matrícula só pode conter Números.<br>");
			
		}
		
		// Verifica Data de Início
		if(!$_ClassData->validaData($_REQUEST["datainicio"])){
			
			// Seta erro
			$_ClassMensagens->setMensagem_erro("Data de Início Inválida.<br>");
			
		}
		
		// Verifica Data de Término
		if(!$_ClassData->validaData($_REQUEST["datatermino"])){
			
			// Seta erro
			$_ClassMensagens->setMensagem_erro("Data de Término Inválida.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica se já existe esta turma
		$_ClassRn->getDadosTable("turmas", "id", "unidade = '" . $_dadosUnidade->id . "' AND numero = '" . $_REQUEST["numero"] . "' AND curso = '" . $_REQUEST["curso"] . "' AND deletado = 'N'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Turma já exite.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Cadastra Turma
		$cadastraTurma = $_ClassMysql->query("INSERT INTO `turmas` SET numero = '" . $_REQUEST["numero"] . "',
																	   unidade = '" . $_dadosUnidade->id . "',
																	   curso = '" . $_REQUEST["curso"] . "',
																	   turno = '" . $_REQUEST["turno"] . "',
																	   duracao = '" . $_REQUEST["duracao"] . "',
																	   tipoduracao = '" . $_REQUEST["tipoduracao"] . "',
																	   vagas = '" . $_REQUEST["vagas"] . "',
																	   datainicio = '" . $_ClassData->transformaData($_REQUEST["datainicio"]) . "',
																	   datatermino = '" . $_ClassData->transformaData($_REQUEST["datatermino"]) . "',
																	   quemcriou = '" . $_dadosLogado->id . "',
																	   datahorac = now()");
		
		// Verifica se Cadastrou
		if($cadastraTurma){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Turma gravada com sucesso!<br><br>[ <a href='?sessao=turmasativas&submenu=" . $_REQUEST["submenu"] . "&ref=novo'>Atualizar</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar esta Turma.<br>");
			
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
	
	// Dados da Turma
	$dadosTurma = $_ClassRn->getDadosTable("turmas", "numero", (($_REQUEST["curso"] > 0)?"curso = '" . $_REQUEST["curso"] . "'":"1") . " ORDER BY id DESC LIMIT 0,1");
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formTurma">
				<input type="hidden" name="act" value="salvar">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td align="right" width="10%"><b><font class="obrig">(*)</font> Curso:</b></td>
						<td width='90%' align='left'>
							<select name="curso" onchange="carrega('numeroTurma&curso='+this.options[this.selectedIndex].value)">
								<option></option>>
								<?php
								// Busca Cursos
								$buscaCursos = $_ClassMysql->query("SELECT * FROM `cursos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
								
								// Traz Cursos
								while($trazCursos = mysql_fetch_object($buscaCursos)){
									
									?>
									<option value="<?php print($trazCursos->id); ?>" <?php print((($_REQUEST["curso"] == $trazCursos->id)?"selected":""));?>><?php print($trazCursos->nome); ?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Número:</b></td>
						<td align='left'>
							<div id="main">
								<input type="text" name="numero" size="5" value="<?php if($_REQUEST["act"] == "salvar") echo (($_REQUEST["numero"] != "")?$_REQUEST["numero"]:($dadosTurma->numero+1));?>">
							</div>
							<div id="loading"></div>
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
						<td align="right"><b><font class="obrig">(*)</font> Duração:</b></td>
						<td align='left'>
							<input type="text" name="duracao" size="10" value="<?php echo $_REQUEST["duracao"]?>">
							<select name="tipoduracao">
								<option value="Horas" <?php print((($_REQUEST["tipoduracao"] == "Horas")?"selected":""));?>>Horas</option>
								<option value="Dias Úteis" <?php print((($_REQUEST["tipoduracao"] == "Dias Úteis")?"selected":""));?>>Dias Úteis</option>
								<option value="Dias Corridos" <?php print((($_REQUEST["tipoduracao"] == "Dias Corridos")?"selected":""));?>>Dias Corridos</option>
								<option value="Semanas" <?php print((($_REQUEST["tipoduracao"] == "Semanas")?"selected":""));?>>Semanas</option>
								<option value="Meses" <?php print((($_REQUEST["tipoduracao"] == "Meses")?"selected":""));?>>Meses</option>
								<option value="Anos" <?php print((($_REQUEST["tipoduracao"] == "Anos")?"selected":""));?>>Anos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Vagas:</b></td>
						<td align='left'><input type="text" name="vagas" size="5" value="<?php echo $_REQUEST["vagas"]?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Data Início:</b></td>
						<td align='left'>
							<input type="text" id="datainicio" name="datainicio" size="12" maxlength="10" onKeyUp="maskData(this, document.formTurma.datatermino)" value="<?php echo $_REQUEST["datainicio"]?>">
							<img src="<?=$pathInc?>imagens/icones/calendar.png" border="0" onClick="popup('CalendarioI', '<?=$pathInc?>includes/calendario.php?mes=<?=date("m")?>&ano=<?=date("Y")?>&idCampo=datainicio', 310, 140, 'no')" style="cursor:pointer;">
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Data Término:</b></td>
						<td align='left'>
							<input type="text" id="datatermino" name="datatermino" size="12" maxlength="10" onKeyUp="maskData(this, this)" value="<?php echo $_REQUEST["datatermino"]?>">
							<img src="<?=$pathInc?>imagens/icones/calendar.png" border="0" onClick="popup('CalendarioT', '<?=$pathInc?>includes/calendario.php?mes=<?=date("m")?>&ano=<?=date("Y")?>&idCampo=datatermino', 310, 140, 'no')" style="cursor:pointer;">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios
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