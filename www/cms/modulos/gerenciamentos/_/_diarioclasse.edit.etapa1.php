<?php
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica se foi informado o Id doi Diário de Classe
if($_SESSION["idDiario"] > 0){
	
	// Dados do Diário de Classe
	$dadosDiarioClasse = $_ClassRn->getDadosTable("diarioclasse", "*", "id = '" . $_SESSION["idDiario"] . "'");
	
	// Dados da Turma
	$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $dadosDiarioClasse->turma . "'");
	
	// Dados do Curso
	$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");

	// Dados do Turno
	$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosDiarioClasse->turno . "'");

	// Dados da Matéria
	$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $dadosDiarioClasse->materia . "'");
	
	// Dados do Instrutor
	$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $dadosDiarioClasse->instrutor . "'");
	?>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
				<tr>
					<td colspan="2" align="right">
						Criado por:
						<?php
						// Dados do Criador
						$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosDiarioClasse->quemcriou . "'");
						
						// Mostra
						print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosDiarioClasse->datahorac, 3) . "</b>");
						
						// Verifica se alguem edtou
						if($dadosDiarioClasse->ultimoeditou > 0){
							
							?>
							<br>Última edição feita por:
							<?php
							// Dados do Alterador
							$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosDiarioClasse->ultimoeditou . "'");
							
							// Mostra
							print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosDiarioClasse->datahorae, 3) . "</b>");
							
						}
						?>
					</td>
				</tr>
				<tr>
					<td align="right" width="10%"><b>Curso/Turma:</b></td>
					<td width='90%' align='left'><?php print ($dadosCurso->sigla . $dadosTurma->numero); ?></td>
				</tr>
				<tr>
					<td align="right"><b>Turno:</b></td>
					<td align="left"><?php print ($dadosTurno->horarioi . "/" . $dadosTurno->horariof); ?></td>
				</tr>
				<tr>
					<td align="right"><b>Matéria:</b></td>
					<td align="left"><?php print ($dadosMateria->materia . " (" . $dadosMateria->sigla . ")"); ?></td>
				</tr>
				<tr>
					<td align="right"><b>Instrutor:</b></td>
					<td align="left"><?php print ($dadosInstrutor->nome . " (" . $_ClassUtilitarios->formataCPF($dadosInstrutor->cpf) . ")"); ?></td>
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
	<?php
	// Verifica Ação
	if($_REQUEST["act"] == "salvar"){
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);
		
		// Verifica Campo
		$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["conteudo"], "É preciso informar o Conteúdo."));
		$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["horasaula"], "É preciso informar a Quantidade de Horas Aula."));

		// Verifica se tem erro
		if($_ClassMensagens->getMensagem_erro() == ""){
			
			// Verifica se tem somente número no campo de horas aulas
			if(!ctype_digit($_REQUEST["horasaula"])){
				
				// Seta erro
				$_ClassMensagens->setMensagem_erro("Horas Aula só pode conter números.<br>");
				
			}
			
		}
		
		// Verifica se tem erro
		if($_ClassMensagens->getMensagem_erro() == ""){
			
			// Edita Diário de Classe
			$editaDiarioClasse = $_ClassMysql->query("UPDATE `diarioclasse` SET conteudo = '" . $_ClassString->filtraTexto($_REQUEST["conteudo"]) . "',
																				horasaula = '" . $_REQUEST["horasaula"] . "',
																				ultimoeditou = '" . $_dadosLogado->id . "',
														   						datahorae = now() WHERE id = '" . $_SESSION["idDiario"] . "'");
			
			// Verifica se Editou
			if($editaDiarioClasse){
				
				// Redieciona
				print($_ClassUtilitarios->redirecionarJS("?sessao=diarioclasse&ref=edit&etapa=2", 0));
				
			}else{
				
				// Seta Erro
				$_ClassMensagens->setMensagem_erro("Não foi possível gravar este Conteúdo.<br>");
				
			}
			
		}
		
		?>
		<tr>
			<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<?php
		
	}
	?>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formDiarioClasse">
				<input type="hidden" name="act" value="salvar">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td valign="top" align="right" width="10%"><b><font class="obrig">(*)</font>Conteúdo:</b></td>
						<td width='90%' align='left'><textarea rows="15" style="width:100%;" name="conteudo"><?php print((($_REQUEST["conteudo"] != "")?$_REQUEST["conteudo"]:nl2br($dadosDiarioClasse->conteudo))); ?></textarea></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font>Horas Aula:</td>
						<td align="left"><input type="text" name="horasaula" size="5" value="<?php print((($_REQUEST["horasaula"] != "")?$_REQUEST["horasaula"]:$dadosDiarioClasse->horasaula));?>"> Somente números</td>
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
		<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
	<?php
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=diarioclasse" . (($_SESSION["urlPesquisa"] != "")?$_SESSION["urlPesquisa"]:""), 1, array("É preciso selecionar um Diário de Classe.")));
	
}
?>