<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["curso"], "É preciso selecionar um Curso."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["sigla"], "É preciso informar a Sigla."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["materia"], "É preciso informar a Matéria."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["cargahoraria"], "É preciso informar a Carga Horária."));
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica se a carga horária tem somente números
		if(!ctype_digit($_REQUEST["cargahoraria"])){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("A Carga Horária só pode conter números.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica se já existe este materia
		$_ClassRn->getDadosTable("materias", "id", "unidade = '" . $_dadosUnidade->id . "' AND id != '" . $_REQUEST["idRegistro"] . "' AND materia = '" . $_REQUEST["materia"] . "' AND curso = '"  . $_REQUEST["curso"] . "' AND deletado = 'N'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Matéria já exite.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Edita materia
		$editaMateria = $_ClassMysql->query("UPDATE `materias` SET curso = '" . $_REQUEST["curso"] . "',
																   sigla = '" . $_REQUEST["sigla"] . "',
																   materia = '" . $_REQUEST["materia"] . "',
																   cargahoraria = '" . $_REQUEST["cargahoraria"] . "',
														   		   descricao = '" . $_REQUEST["descricao"] . "',
														   		   ultimoeditou = '" . $_dadosLogado->id . "',
														   		   datahorae = now() WHERE id = '" . $_REQUEST["idRegistro"] . "'");
		
		// Verifica se Editou
		if($editaMateria){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Matéria gravada com sucesso!<br><br>[ <a href='?sessao=materias&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "'>Voltar para a Listagem</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar esta Matéria.<br>");
			
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
	
	// Dados do materia
	$dadosMateria = $_ClassRn->getDadosTable("materias", "*", "id = '" . $_REQUEST["idRegistro"] . "' AND deletado = 'N'");
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formMateria">
				<input type="hidden" name="act" value="salvar">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td colspan="2" align="right">
							Criado por:
							<?php
							// Dados do Criador
							$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosMateria->quemcriou . "'");
							
							// Mostra
							print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosMateria->datahorac, 3) . "</b>");
							
							// Verifica se alguem edtou
							if($dadosAluno->ultimoeditou > 0){
								
								?>
								<br>Última edição feita por:
								<?php
								// Dados do Alterador
								$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosMateria->ultimoeditou . "'");
								
								// Mostra
								print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosMateria->datahorae, 3) . "</b>");
								
							}
							?>
						</td>
					</tr>
					<tr>
						<td align="right" width="10%"><b><font class="obrig">(*)</font> Curso:</b></td>
						<td width='90%' align='left'>
							<select name="curso">
								<option value=""></option>
								<?php
								// Busca Cursos
								$buscaCursos = $_ClassMysql->query("SELECT * FROM `cursos` WHERE unidade = '" . $_dadosUnidade->id . "'");
								
								// Traz Cursos
								while($trazCursos = mysql_fetch_object($buscaCursos)){
									
									?>
									<option value="<?php print($trazCursos->id);?>" <?php print((((($_REQUEST["curso"] != "")?$_REQUEST["curso"]:$dadosMateria->curso) == $trazCursos->id)?"selected":""));?>><?php print($trazCursos->nome);?> (<?php print($trazCursos->sigla);?>)</option>
									<?php
									
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Sigla:</b></td>
						<td align='left'><input type="text" name="sigla" size="5" value="<?php echo (($_REQUEST["sigla"] != "")?$_REQUEST["sigla"]:$dadosMateria->sigla);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Matéria:</b></td>
						<td align='left'><input type="text" name="materia" size="25" value="<?php echo (($_REQUEST["materia"] != "")?$_REQUEST["materia"]:$dadosMateria->materia);?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font> Carga Horária:</b></td>
						<td align='left'><input type="text" name="cargahoraria" size="15" value="<?php echo (($_REQUEST["cargahoraria"] != "")?$_REQUEST["cargahoraria"]:$dadosMateria->cargahoraria);?>"></td>
					</tr>
					<tr>
						<td align="right"><b>Descrição:</b></td>
						<td align='left'>
							<?php
							// Importa FCK Editor
							require_once($pathInc . "includes/fckeditor/fckeditor.php");
							
							// Cria Campo do FCK EDITOR
							$oFCKeditor = new FCKeditor('descricao') ;
							$oFCKeditor->BasePath = 'includes/fckeditor/';
							$oFCKeditor->Value =  (($_REQUEST["descricao"] != "")?$_REQUEST["descricao"]:$dadosMateria->descricao);
							$oFCKeditor->Height = '200' ;
							$oFCKeditor->Create() ;		
							?>
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