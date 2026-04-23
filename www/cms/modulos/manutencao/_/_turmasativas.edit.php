<?php require_once("php7_mysql_shim.php");
// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
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
		
		// Edita Turma
		$editaTurma = $_ClassMysql->query("UPDATE `turmas` SET unidade = '" . $_dadosUnidade->id . "',
															   turno = '" . $_REQUEST["turno"] . "',
															   duracao = '" . $_REQUEST["duracao"] . "',
															   tipoduracao = '" . $_REQUEST["tipoduracao"] . "',
															   vagas = '" . $_REQUEST["vagas"] . "',
															   datainicio = '" . $_ClassData->transformaData($_REQUEST["datainicio"]) . "',
															   datatermino = '" . $_ClassData->transformaData($_REQUEST["datatermino"]) . "',
															   ultimoeditou = '" . $_dadosLogado->id . "',
															   datahorae = now() WHERE id = '" . $_REQUEST["idRegistro"] . "'");
		
		// Verifica se Editou
		if($editaTurma){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Turma gravada com sucesso!<br><br>[ <a href='?sessao=turmasativas&submenu=" . $_REQUEST["submenu"] . "&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "'>Voltar para a Listagem</a> ]");
			
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
	$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_REQUEST["idRegistro"] . "'");
	
	// Dados do Curso
	$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
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
						<td colspan="2" align="right">
							Criado por:
							<?php
							// Dados do Criador
							$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosTurma->quemcriou . "'");
							
							// Mostra
							print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosTurma->datahorac, 3) . "</b>");
							
							// Verifica se alguem edtou
							if($dadosAluno->ultimoeditou > 0){
								
								?>
								<br>Última edição feita por:
								<?php
								// Dados do Alterador
								$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosTurma->ultimoeditou . "'");
								
								// Mostra
								print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosTurma->datahorae, 3) . "</b>");
								
							}
							?>
						</td>
					</tr>
					<tr>
						<td align="right" width="10%"><b>Número:</b></td>
						<td width='90%' align='left'><?php print($dadosTurma->numero);?></td>
					</tr>
					<tr>
						<td align="right"><b>Curso:</b></td>
						<td width='90%' align='left'><?php print($dadosCurso->nome); ?></td>
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
									<option value="<?php print($trazTurnos->id); ?>" <?php print((((($_REQUEST["turno"] != "")?$_REQUEST["turno"]:$dadosTurma->turno) == $trazTurnos->id)?"selected":""));?>><?php print($trazTurnos->turno . " (" . $trazTurnos->horarioi . " - " . $trazTurnos->horariof . ")"); ?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Duração:</b></td>
						<td align='left'>
							<input type="text" name="duracao" size="10" value="<?php echo (($_REQUEST["duracao"] != "")?$_REQUEST["duracao"]:$dadosTurma->duracao)?>">
							<select name="tipoduracao">
								<option value="Horas" <?php print((((($_REQUEST["tipoduracao"] != "")?$_REQUEST["tipoduracaogas"]:$dadosTurma->tipoduracao) == "Horas")?"selected":""));?>>Horas</option>
								<option value="Dias Úteis" <?php print((((($_REQUEST["tipoduracao"] != "")?$_REQUEST["tipoduracaogas"]:$dadosTurma->tipoduracao) == "Dias Úteis")?"selected":""));?>>Dias Úteis</option>
								<option value="Dias Corridos" <?php print((((($_REQUEST["tipoduracao"] != "")?$_REQUEST["tipoduracaogas"]:$dadosTurma->tipoduracao) == "Dias Corridos")?"selected":""));?>>Dias Corridos</option>
								<option value="Semanas" <?php print((((($_REQUEST["tipoduracao"] != "")?$_REQUEST["tipoduracaogas"]:$dadosTurma->tipoduracao) == "Semanas")?"selected":""));?>>Semanas</option>
								<option value="Meses" <?php print((((($_REQUEST["tipoduracao"] != "")?$_REQUEST["tipoduracaogas"]:$dadosTurma->tipoduracao) == "Meses")?"selected":""));?>>Meses</option>
								<option value="Anos" <?php print((((($_REQUEST["tipoduracao"] != "")?$_REQUEST["tipoduracaogas"]:$dadosTurma->tipoduracao) == "Anos")?"selected":""));?>>Anos</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Vagas:</b></td>
						<td align='left'><input type="text" name="vagas" size="5" value="<?php echo (($_REQUEST["vagas"] != "")?$_REQUEST["vagas"]:$dadosTurma->vagas);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Data Início:</b></td>
						<td align='left'>
							<input type="text" id="datainicio" name="datainicio" size="12" maxlength="10" onKeyUp="maskData(this, document.formTurma.datatermino)" value="<?php echo (($_REQUEST["datainicio"] != "")?$_REQUEST["datainicio"]:$_ClassData->transformaData($dadosTurma->datainicio, 2));?>">
							<img src="<?=$pathInc?>imagens/icones/calendar.png" border="0" onClick="popup('CalendarioI', '<?=$pathInc?>includes/calendario.php?mes=<?=date("m")?>&ano=<?=date("Y")?>&idCampo=datainicio', 310, 140, 'no')" style="cursor:pointer;">
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Data Término:</b></td>
						<td align='left'>
							<input type="text" id="datatermino" name="datatermino" size="12" maxlength="10" onKeyUp="maskData(this, this)" value="<?php echo (($_REQUEST["datatermino"] != "")?$_REQUEST["datatermino"]:$_ClassData->transformaData($dadosTurma->datatermino, 2));?>">
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