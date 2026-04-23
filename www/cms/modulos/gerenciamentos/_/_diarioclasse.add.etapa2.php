<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica se foi informado o Id da Grade Horária
if($_REQUEST["idGrade"] > 0){
	
	// Adiciona Grade Horária na Sessão
	$_SESSION["idGrade"] = $_REQUEST["idGrade"];
	
}

// Verifica se foi informado o Id da Grade Horária
if($_SESSION["idGrade"] > 0){
	
	// Dados da Grade Horária
	$dadosGrade = $_ClassRn->getDadosTable("gradehoraria", "*", "id = '" . $_SESSION["idGrade"] . "'");
	
	// Dados da Turma
	$dadosTurma = $_ClassRn->getDadosTable("turmas", "curso, numero", "id = '" . $dadosGrade->turma . "'");
	
	// Dados do Curso
	$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");

	// Dados do Turno
	$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosGrade->turno . "'");

	// Dados da Matéria
	$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $dadosGrade->materia . "'");
	
	// Dados do Instrutor
	$dadosInstrutor = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $dadosGrade->instrutor . "'");
	?>
	<tr>
		<td align="left"><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
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
			
			// Cadastra Diário de Classe
			$cadastraDiarioClasse = $_ClassMysql->query("INSERT INTO `diarioclasse` SET  unidade = '" . $_dadosUnidade->id . "',
																						 turma = '" . $dadosGrade->turma . "',
																					  	 data = '" . $dadosGrade->data . "',
																					  	 turno = '" . $dadosGrade->turno . "',
																					  	 materia = '" . $dadosGrade->materia . "',
																					  	 instrutor = '" . $dadosGrade->instrutor . "',
																					  	 sala = '" . $dadosGrade->sala . "',
																					  	 conteudo = '" . $_ClassString->filtraTexto($_REQUEST["conteudo"]) . "', 
																					  	 horasaula = '" . $_REQUEST["horasaula"] . "',
																					  	 quemcriou = '" . $_dadosLogado->id . "',
														   							  	 datahorac = now()");
			
			// Id do Diário de Classe
			$idDiarioClasse = mysql_insert_id();
			
			// Verifica se Cadastrou
			if($cadastraDiarioClasse){
				
				// Cadastra o Id do Diário de Classe na sessão
				$_SESSION["idDiarioClasse"] = $idDiarioClasse;
				
				// Redieciona
				print($_ClassUtilitarios->redirecionarJS("?sessao=diarioclasse&ref=novo&etapa=3", 0));
				
			}else{
				
				// Seta Erro
				$_ClassMensagens->setMensagem_erro("N ão foi possível gravar este Conteúdo.<br>");
				
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
						<td width='90%' align='left'><textarea rows="15" style="width:100%;" name="conteudo"><?php echo $_REQUEST["conteudo"]?></textarea></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font>Horas Aula:</td>
						<td align="left"><input type="text" name="horasaula" size="5" value="<?php print($_REQUEST["horasaula"]);?>"> Somente números</td>
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
	print($_ClassUtilitarios->redirecionarJS("?sessao=diarioclasse&ref=novo" . (($_SESSION["consultaDiarioClasse"] != "")?"&subref=buscar":""), 1, array("É preciso selecionar uma Aula.")));
	
}
?>