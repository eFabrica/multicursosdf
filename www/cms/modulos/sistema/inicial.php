<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
	// Verifica sem permissão
	if($_REQUEST["sempermissao"] == "true"){
		
		// Seta largura das mensagens
		$_ClassMensagens->setLargura(98);
		
		// Mensgem de erro
		$_ClassMensagens->setMensagem_erro("Desculpe. Você não tem nível para acessar esta sessão.");
		?>
		<tr>
			<td style='height:5px';>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><? echo $_ClassMensagens->exibirMensagem()?></td>
		</tr>
		<?php
	}
	?>
	<tr>
		<?php
		// Nivel
		if($_dadosLogado->nivel == "100" || $_dadosLogado->nivel == "89"){
			?>
			<td valign="top">
				<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
					<tr>
						<td align='left'><div id="border-top"><div><div></div></div></div></td>
					</tr>
					<tr>
						<td class="table_main"><?php require_once($pathInc . "includes/menuRapido.php");?></td>
					</tr>
					<tr>
						<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
					</tr>
				</table>
			</td>
			<?php
		}
		
		// Nivel
		if($_dadosLogado->nivel == "100" || $_dadosLogado->nivel == "99" || $_dadosLogado->nivel == "98" || $_dadosLogado->nivel == "89"){
			?>
			<td width="100%" valign="top">
				<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
					<tr>
						<td align='left'><div id="border-top"><div><div></div></div></div></td>
					</tr>
					<tr>
						<td class="table_main">
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td align='left'><img src="modulos/sistema/img.php?img=../../imagens/icones/00049.png&l=50&a=50"></td>
									<td class="menu_topico">Estatísticas</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
					</tr>
					<tr>
						<td align='left'><br></td>
					</tr>
					<tr>
						<td align='left'><div id="border-top"><div><div></div></div></div></td>
					</tr>
					<tr>
						<td class="table_main">
							<table border="0" cellpadding="2" cellspacing="2" width="100%">
								<?php
								// Busca Clientes
								$buscaClientes = $_ClassMysql->query("SELECT id FROM `clientes` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
								
								// Busca Alunos
								$buscaAlunos = $_ClassMysql->query("SELECT id FROM `alunos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
								
								// Busca Turmas Abertas
								$buscaTurmasAbertas = $_ClassMysql->query("SELECT id FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND concluido = 'N' AND deletado = 'N'");
								
								// Busca Turmas Concluídas
								$buscaTurmasConcluidas = $_ClassMysql->query("SELECT id FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND concluido = 'S' AND deletado = 'N'");
								
								// Busca Cursos
								$buscaCursos = $_ClassMysql->query("SELECT id FROM `cursos` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
								
								// Busca Instrutores
								$buscaInstrutores = $_ClassMysql->query("SELECT id FROM `usuarios` WHERE unidade = '" . $_dadosUnidade->id . "' AND nivel = '95' AND deletado = 'N'");
								
								/*
								// Busca
								$busca = $_ClassMysql->query("SELECT id FROM `` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
								*/
								?>
								<tr>
									<td width="15%" align="right"><b>Clientes:</b></td>
									<td width='85%' align='left'><?php print(mysql_num_rows($buscaClientes));?></td>
								</tr>
								<tr>
									<td align="right"><b>Alunos:</b></td>
									<td align='left'><?php print(mysql_num_rows($buscaAlunos));?></td>
								</tr>
								<tr>
									<td align="right"><b>Instrutores:</b></td>
									<td align='left'><?php print(mysql_num_rows($buscaInstrutores));?></td>
								</tr>
								<tr>
									<td align="right"><b>Cursos:</b></td>
									<td align='left'><?php print(mysql_num_rows($buscaCursos));?></td>
								</tr>
								<tr>
									<td align="right"><b>Turmas Abertas:</b></td>
									<td align='left'><?php print(mysql_num_rows($buscaTurmasAbertas));?></td>
								</tr>
								<tr>
									<td align="right"><b>Turmas Concluídas:</b></td>
									<td align='left'><?php print(mysql_num_rows($buscaTurmasConcluidas));?></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
					</tr>
				</table>
			</td>
			<?php
		}
		?>
	</tr>
</table>