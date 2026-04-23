<tr>
	<td style='height:5px';>&nbsp;</td>
</tr>
<?php require_once("php7_mysql_shim.php");
// Adiciona Classe de CPF
require_once($pathInc . "lib/Cpf.class.php");

// Adiciona Classe de E-mail
require_once($pathInc . "lib/Email.class.php");

// Verifica se foi selecionado algum aluno
if($dadosMatricula->aluno > 0){
	
	// Verifica Ação
	if($_REQUEST["act"] == "salvar"){
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);
		
		// Verifica Campo
		$_ClassMensagens->setMensagem_erro($_ClassForm->cb($_REQUEST["empresa"], "É preciso informar a Empresa."));
		
		// Verifica se tem erro
		if($_ClassMensagens->getMensagem_erro() == ""){
			
			// Coloca Empresa na sessão
			$_SESSION["matricula"]["idEmpresa"] = $_REQUEST["empresa"];
			
			// Redireciona
			print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=edit&etapa=3"));
			
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
	?>
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="" method="POST" name="formMatricula">
				<input type="hidden" name="act" value="salvar">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
					<tr>
						<td colspan="2" align="right">
							Criado por:
							<?php
							// Dados do Criador
							$dadosCriador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosMatricula->quemcriou . "'");
							
							// Mostra
							print ("<b>" . $dadosCriador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosMatricula->datahorac, 3) . "</b>");
							
							// Verifica se alguem edtou
							if($dadosMatricula->ultimoeditou > 0){
								
								?>
								<br>Última edição feita por:
								<?php
								// Dados do Alterador
								$dadosAlterador = $_ClassRn->getDadosTable("usuarios", "nome", "id = '" . $dadosMatricula->ultimoeditou . "'");
								
								// Mostra
								print ("<b>" . $dadosAlterador->nome . "</b> em <b>" . $_ClassData->transformaData($dadosMatricula->datahorae, 3) . "</b>");
								
							}
							?>
						</td>
					</tr>
					<tr>
						<td align="right" width="15%"><b><font class="obrig">(*)</font>Empresa:</b></td>
						<td width='85%' align='left'>
							<select name="empresa">
								<?php
								// Busca Empresas
								$buscaEmpresas = $_ClassMysql->query("SELECT * FROM `clientes` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
								
								// Traz Empresas
								while($trazEmpresas = mysql_fetch_object($buscaEmpresas)){
									
									?>
									<option value="<?php print($trazEmpresas->id);?>" <?php print((((($_REQUEST["empresa"] != "")?$_REQUEST["empresa"]:$dadosMatricula->empresa) == $trazEmpresas->id)?"selected":""));?>><?php print($trazEmpresas->razaosocial);?></option>
									<?php
									
								}
								?>
							</select>
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
	print($_ClassUtilitarios->redirecionarJS("?sessao=matriculas&subsessao=" . $_REQUEST["subsessao"] . "&ref=edit&etapa=1", 1, array("É preciso selecionar um(a) aluno(a).")));
	
}
?>