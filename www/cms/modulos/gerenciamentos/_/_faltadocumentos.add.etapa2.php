<?php require_once("php7_mysql_shim.php");
// Verifica se foi selecionado alguma matrícula
if($_SESSION["consultaFaltaDocumentos"]["idMatricula"] > 0){

	// Verifica Ação
	if($_REQUEST["act"] == "salvar"){
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);
		
		// Verifica Documentos
		if(count($_REQUEST["documentos"]) > 0){
			
			// Lê Documentos
			for($d = 0; $d < count($_REQUEST["documentos"]); $d++){
			
				// Cadastra Falta de Documento
				$_ClassMysql->query("INSERT INTO `faltadocumentos` SET matricula = '" . $_SESSION["consultaFaltaDocumentos"]["idMatricula"] . "',
																	   documento = '" . $_REQUEST["documentos"][$d] . "',
																	   quemcriou = '" . $_dadosLogado->id . "',
									   							  	   datahorac = now()");
				
			}
			
			// Redireciona
			print($_ClassUtilitarios->redirecionarJS("?sessao=faltadocumentos&ref=novo&etapa=3"));
			
		}else{
			
			// Erro
			$_ClassMensagens->setMensagem_erro("É preciso selecionar um documento da lista.<br>Caso não tenha nenhum, pode ser porque já estão cadastrados ou não existe documento.");
			
		}
		
		?>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td align='left'><?php echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<?php
		
	}
	
	// Dados da Matrícula
	$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "aluno", "id = '" . $_SESSION["consultaFaltaDocumentos"]["idMatricula"] . "'");
	
	// Dados do Aluno
	$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $dadosMatricula->aluno . "'");
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
			<form action="" method="POST" name="formFaltaDocumentos">
				<input type="hidden" name="act" value="salvar">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
					<tr>
						<td align="right" valign="top" width="15%"><b><font class="obrig">(*)</font> Documentos em falta:</b></td>
						<td width='85%' align='left'>
							<?php
							// Busca Documentos Em Falta
							$buscaDocumentosFalta = $_ClassMysql->query("SELECT id, documento FROM `faltadocumentos` WHERE matricula = '" . $_SESSION["consultaFaltaDocumentos"]["idMatricula"] . "' AND deletado = 'N'");
							
							// Traz Documentos em Falta
							while ($trazDocumentosFalta = mysql_fetch_object($buscaDocumentosFalta)) {
								
								// Query
								$query .= " AND id != '" . $trazDocumentosFalta->documento . "'";
								
							}
							
							// Busca Documentos
							$buscaDocumentos = $_ClassMysql->query("SELECT * FROM `documentos` WHERE unidade = '" . $_dadosUnidade->id . "' " . $query . " AND deletado = 'N'");
							
							// Traz Documentos
							while($trazDocumentos = mysql_fetch_object($buscaDocumentos)){
								
								?>
								<input type="checkbox" name="documentos[]" value="<?php print($trazDocumentos->id);?>" <?php for($y = 0; $y < count($_REQUEST["documentos"]); $y++){print((($_REQUEST["documentos"][$y] == $trazDocumentos->id)?"checked":""));}?>><?php print($trazDocumentos->documento);?><br/>
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
	
}else{
	
	// Redieciona
	print($_ClassUtilitarios->redirecionarJS("?sessao=faltadocumentos&ref=novo&etapa=1", 1, array("É preciso selecionar uma matrícula.")));
	
}
?>