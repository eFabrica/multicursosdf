<?php require_once("php7_mysql_shim.php");
// Verifica nível
if($_dadosLogado->nivel == 100){

	// Verifica Ação
	if($_REQUEST["act"] == "deletar"){
		
		// Lê Registros
		for($y = 0; $y < count($_REQUEST["registros"]); $y++){
			
			// Deleta Registros
			$_ClassMysql->query("UPDATE `alunos` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $_REQUEST["registros"][$y] . "'");
			
			// Busca Matrículas
			$buscaMatriculas = $_ClassMysql->query("SELECT * FROM `matriculas` WHERE aluno = '" . $_REQUEST["registros"][$y] . "'");
			
			// Traz Matrículas
			while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
				
				// Deleta Notas
				$_ClassMysql->query("UPDATE `notas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE matricula = '" . $trazMatriculas->id . "'");
				
				// Deleta Falta de Documentos
				$_ClassMysql->query("UPDATE `faltadocumentos` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE matricula = '" . $trazMatriculas->id . "'");
				
				// Deleta Frequências
				$_ClassMysql->query("UPDATE `frequencias` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE matricula = '" . $trazMatriculas->id . "'");
				
				// Deleta Parcelas
				$_ClassMysql->query("UPDATE `parcelas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE matricula = '" . $trazMatriculas->id . "'");
				
				// Deleta Matrícula
				$_ClassMysql->query("UPDATE `matriculas` SET deletado = 'S', quemdeletou = '" . $_dadosLogado->id . "', datahorad = now() WHERE id = '" . $trazMatriculas->id . "'");
				
			}
			
		}
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(100);
		
		// Seta Mensagem de Sucesso
		$_ClassMensagens->setMensagem_sucesso(count($_REQUEST["registros"]) . " aluno(s) foi(ram) deletado(s) com sucesso!<br><br>[ <a href='?" . str_replace("&act=deletar", "", $_SERVER['QUERY_STRING']) . "'>Atualizar</a> ]");
		
		?>
		<tr>
			<td align="left"><?php echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<?php
		
	}
	
}

// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Importa Consulta
require_once("lib/Consulta.class.php");

// Verifica nível
if($_dadosLogado->nivel == 100){

	// Seta Ações
	$_ClassConsulta->setAcoes(array("Deletar"));
	
	// Seta OnChange
	$_ClassConsulta->setOnChange("if(confirm('Deseja mesmo deletar este(s) registro(s)?')){document.consulta.action = '' + this.options[this.selectedIndex].value; document.consulta.submit();}");
	
	// Seta Links das Ações
	$_ClassConsulta->setLinksAcoes(array("?sessao=alunos&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"] . "&act=deletar"));
	
}else{
	
	// Seta Ações
	$_ClassConsulta->setPacoes(false);
	
}

?>
<tr>
	<td align='left'><div id="border-top"><div><div></div></div></div></td>
</tr>
<tr>
	<td class="table_main">
		<table width="99%" border="0" cellpadding="2" cellspacing="2">
			<?php
			// Verifica Nível
			if($_dadosLogado->nivel != "95"){
				?>
				<tr>
					<td width="70%" align="left">
						<table border="0" cellpadding="1" cellspacing="1" width="100%">
							<tr>
								<td width="15%" align="right">Com Selecionados:</td>
								<td width='85%' align='left'>
									<select onchange="if(confirm('Deseja mesmo deletar este(s) registro(s)? Lembre-se que irá deletar também o diário de classe e as frequências!')){document.formAluno.act.value = '' + this.options[this.selectedIndex].value; document.formAluno.submit();}">
										<option value=""></option>
										<option value="deletar">Deletar</option>
									</select>
								</td>
							</tr>
						</table>
					</td>
					<td width="30%" align="right">
						<form action="" method="POST" name="formconsulta">
							<table border="0" cellpadding="1" cellspacing="1" width="100%">
								<tr>
									<td align="right" width="65%"><b>Palavra:</b></td>
									<td width="30%"><input type="text" name="text" value="<?=$_REQUEST["text"]?>"></td>
									<td width="5%"><?=$_ClassUtilitarios->criaMenu("Filtrar", "#", "document.formconsulta.submit();", "esq", "007")?></td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
				<?php 
			}
			?>
			<tr>
				<td align='left' colspan="2">
					<form action="" method="POST" name="formAluno">
						<input type="hidden" name="act" value="">
						<table class="consulta" cellspacing="1" align="center">
							<thead>
								<tr>
									<th width="1%">#</th>	
									<th width="1%" align="center"><input type="checkbox" onclick="select_all('formAluno', 'registros[]')"></th>									
									<th width="35%">Nome</th>
									<th width="10%">Data&nbsp;Nasc.</th>
									<th width="10%">R.G</th>
									<th width="10%">Org.&nbsp;Exp</th>
									<th width="15%">CPF</th>
									<th width="20%">Telefone</th>
								</tr>
							</thead>
							<tbody>
								<?php				
								/* Construindo sql */
								$sql = "SELECT * FROM `alunos` WHERE " . (($_REQUEST["text"] != "")?"deletado = 'N' AND nome LIKE '%" . $_REQUEST["text"] . "%' OR deletado = 'N' AND cpf LIKE '%" . $_REQUEST["text"] . "%'" :"deletado = 'N'");
								
								// Paginação
								require_once($pathInc . "lib/Paginacao.class.php");
								
								// Configurações da paginacao
								$_ClassPaginacao->setQuery($sql);
								$_ClassPaginacao->setUrl("?sessao=" . $_REQUEST["sessao"]);
								$_ClassPaginacao->setRegistrosPorPagina("45");
								$_ClassPaginacao->setPaginaAtual((($_REQUEST["pg"] == 0)?"1":$_REQUEST["pg"]));
								$_ClassPaginacao->paginando();
														
								// Verifica total achado
								if($_ClassPaginacao->getTotalAchadoQuery() == 0){
									?>
									<tr>
										<td align="center" colspan="9"><b>Nenhum resultado encontrado.</b></td>
									</tr>
									<?
								}else{
									
									// Contador
									$cont = 0;
									
									// Traz resultados
									while($trazResultados = mysql_fetch_object($_ClassPaginacao->getBusca())){
									
										?>
										<tr class=row0>
											<td align='left'><?php print($trazResultados->id); ?></td>
											<td align="center"><input type="checkbox" name="registros[]" value="<?=$trazResultados->id?>"></td>
											<td align="left"><a href="<?="?sessao=" . $_REQUEST["sessao"]."&pg=" . $_REQUEST['pg'] . "&text=" . $_REQUEST['text'] . "&ref=edit&idRegistro=" . $trazResultados->id?>"><b><?php print($trazResultados->nome);?></b></a></td>
											<td align="center"><?php print($_ClassData->transformaData($trazResultados->datanascimento, 2));?></td>
											<td align="center"><?php print($trazResultados->rg); ?></td>
											<td align="center"><?php print($trazResultados->orgexp); ?></td>
											<td align="center"><?php print($_ClassUtilitarios->formataCPF($trazResultados->cpf)); ?></td>
											<td align="center"><?php print($trazResultados->telefone); ?></td>
										</tr>
										<?php
									}
									
								}
								?>
							</tbody>
							<tfoot>
								<td colspan="9"><?php echo $_ClassPaginacao->showPaginacao();?></td>
							</tfoot>
						</table>
					</form>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
</tr>