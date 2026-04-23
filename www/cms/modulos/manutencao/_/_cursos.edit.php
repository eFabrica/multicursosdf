<?php
// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Verifica Ação
if($_REQUEST["act"] == "salvar"){
	
	// Seta largura das mensagens
	$_ClassMensagens->setLargura(100);
	
	// Verifica Campo
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["ndpf"], "É preciso informar o Número do DPF."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["sigladpf"], "É preciso informar a sigla do DPF."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["sigla"], "É preciso informar a sigla."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["nome"], "É preciso informar o nome."));
	$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["valor"], "É preciso informar o valor."));	
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Verifica se já existe este curso
		$_ClassRn->getDadosTable("cursos", "id", "id != '" . $_REQUEST["idRegistro"] . "' AND unidade = '" . $_dadosUnidade->id . "' AND sigla = '" . $_REQUEST["sigla"] . "' AND deletado = 'N'");
		
		// Verifica o total achado
		if($_ClassRn->getTot() > 0){
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Curso já exite.<br>");
			
		}
		
	}
	
	// Verifica se tem erro
	if($_ClassMensagens->getMensagem_erro() == ""){
		
		// Edita Curso
		$editaCurso = $_ClassMysql->query("UPDATE `cursos` SET unidade = '" . $_dadosUnidade->id . "',
															   ndpf = '" . $_REQUEST["ndpf"] . "',
															   sigladpf = '" . $_REQUEST["sigladpf"] . "',
															   sigla = '" . $_REQUEST["sigla"] . "',
															   nome = '" . $_REQUEST["nome"] . "',
															   valor = '" . $_ClassDinheiro->limpaFormatacaoMoeda($_REQUEST["valor"]) . "',
															   descricao = '" . $_ClassString->filtraTexto($_REQUEST["texto"]) . "',
															   ultimoeditou = '" . $_dadosLogado->id . "',
															   datahorae = now() WHERE id = '" . $_REQUEST["idRegistro"] . "'");
		
		// Verifica se Editou
		if($editaCurso){
			
			// Sucesso
			$sucesso = true;
			
			// Seta Mensagem de Sucesso
			$_ClassMensagens->setMensagem_sucesso("Curso gravado com sucesso!<br><br>[ <a href='?sessao=cursos&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "'>Voltar para a Listagem</a> ]");
			
		}else{
			
			// Seta Erro
			$_ClassMensagens->setMensagem_erro("Não foi possível gravar este Curso.<br>");
			
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
	
	// Dados do Curso
	$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $_REQUEST["idRegistro"] . "' AND deletado = 'N'");
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formCurso">
				<input type="hidden" name="act" value="salvar">
				<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td colspan="2" align="right">
							Criado por:
							<?php
							// Dados do Criador
							$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosCurso->quemcriou . "'");
							
							// Mostra
							print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosCurso->datahorac, 3) . "</b>");
							
							// Verifica se alguem edtou
							if($dadosCurso->ultimoeditou > 0){
								
								?>
								<br>Última edição feita por:
								<?php
								// Dados do Alterador
								$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosCurso->ultimoeditou . "'");
								
								// Mostra
								print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosCurso->datahorae, 3) . "</b>");
								
							}
							?>
						</td>
					</tr>
					<tr>
						<td align="right" width="10%"><b><font class="obrig">(*)</font>N. DPF:</b></td>
						<td width='90%' align='left'><input type="text" name="ndpf" size="1" value="<?php echo (($_REQUEST["ndpf"] != "")?$_REQUEST["ndpf"]:$dadosCurso->ndpf)?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font>Sigla DPF:</b></td>
						<td align='left'><input type="text" name="sigladpf" size="10" value="<?php echo (($_REQUEST["sigladpf"] != "")?$_REQUEST["sigladpf"]:$dadosCurso->sigladpf)?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font>Sigla:</b></td>
						<td align='left'><input type="text" name="sigla" size="10" value="<?php echo (($_REQUEST["sigla"] != "")?$_REQUEST["sigla"]:$dadosCurso->sigla)?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font>Nome:</b></td>
						<td align='left'><input type="text" name="nome" size="50" value="<?php echo (($_REQUEST["nome"] != "")?$_REQUEST["nome"]:$dadosCurso->nome)?>"></td>
					</tr>
					<tr>
						<td align="right"><b><font class="obrig">(*)</font>Valor:</b></td>
						<td align='left'><input type="text" name="valor" onKeydown="Formata(this,20,event,2)" size="30" value="<?php echo $_ClassDinheiro->formataMoeda((($_REQUEST["valor"] != "")?$_REQUEST["valor"]:$dadosCurso->valor))?>" style="text-align:right;"></td>
					</tr>
					<tr>
						<td align="right" valign="top"><b><font class="obrig">(**)</font>Descrição:</b></td>
						<td align='left'>
							<?php
							// Importa FCK Editor
							require_once($pathInc . "includes/fckeditor/fckeditor.php");
							
							// Cria Campo do FCK EDITOR
							$oFCKeditor = new FCKeditor('texto') ;
							$oFCKeditor->BasePath = 'includes/fckeditor/';
							$oFCKeditor->Value = (($_REQUEST["textp"])?$_REQUEST["texto"]:$dadosCurso->descricao);
							$oFCKeditor->Height = '200' ;
							$oFCKeditor->Create() ;		
							?>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<br>
							<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios.<br />
							<font class="obrig"><b>(**)</b></font> - Campos não obrigatórios mas necessários para exbir no site.
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