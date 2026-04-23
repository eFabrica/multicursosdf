<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Verifica se foi selecionado algum aluno
if($_SESSION["matricula"]["idAluno"] > 0){

	// Verifica Ação
	if($_REQUEST["act"] == "salvar"){
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);
		
		// Verifica Documentos
		if(count($_REQUEST["documentos"]) > 0){
			
			// Lê Documentos
			for($d = 0; $d < count($_REQUEST["documentos"]); $d++){
			
				// Cadastra na Sessão
				$_SESSION["matricula"]["documentos"][$d] = $_REQUEST["documentos"][$d];
				
			}
			
		}
		
		// Redireciona
		print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=novo&etapa=4"));
		
	}
	
	// Verifica Sucesso
	if(!$sucesso){
		
		// Dados do Aluno
		$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $_SESSION["matricula"]["idAluno"] . "'");
		?>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align='left'><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
					<tr>
						<td align="right" width="15%"><b>Aluno:</b></td>
						<td width='85%' align='left'><?php print($dadosAluno->nome . " (" . $_ClassUtilitarios->formataCPF($dadosAluno->cpf) . ")");?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align='left'><div id="border-top"><div><div></div></div></div></td>
		</tr>
		<tr>
			<td class="table_main">
				<form action="" method="POST" name="formMatricula">
					<input type="hidden" name="act" value="salvar">
					<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
						<tr>
							<td align="right" valign="top" width="15%"><b><font class="obrig">(*)</font> Documentos em falta:</b></td>
							<td width='85%' align='left'>
								<input type="checkbox" onclick="select_all('formMatricula', 'documentos[]')" checked> Selecionar Tudo/Nada<br>
								<?php
								// Busca Documentos
								$buscaDocumentos = $_ClassMysql->query("SELECT * FROM `documentos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
								
								// Traz Documentos
								while($trazDocumentos = mysql_fetch_object($buscaDocumentos)){
									
									?>
									<input type="checkbox" name="documentos[]" value="<?php print($trazDocumentos->id);?>" checked>&nbsp;<?php print($trazDocumentos->documento);?><br>
									<?php
									
								}
								?>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<br>
								<font class="obrig"><b>(*)</b></font> - Campos Obrigatórios<Br>
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
	
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&ref=novo&etapa=1", 1, array("É preciso selecionar um(a) aluno(a).")));
	
}
?>