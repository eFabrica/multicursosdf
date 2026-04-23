<?php
// Verifica se tem id do registro
if($_REQUEST["idRegistro"] > 0){
	
	// Adiciona na sessão
	$_SESSION["idAluno"] = $_REQUEST["idRegistro"];
	$_SESSION["urlPesquisa"] = "&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&filtro=" . $_REQUEST["filtro"] . "&pg=" . $_REQUEST["pg"];
	
}
?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00007.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Alunos <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == ""){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=alunos_clientes&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Novo</a></div></td>
								<?php
								
							}elseif($_REQUEST["ref"] == "novo" || $_REQUEST["ref"] == "edit"){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="#" onClick="document.formAluno.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a></div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=alunos_clientes<?php print((($_REQUEST["ref"] == "novo")?"&ref=":"&ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"] . "&pg=" . $_REQUEST["pg"] . "&filtro=" . $_REQUEST["filtro"]));?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></div></td>
								<?php
								
							}elseif($_REQUEST["ref"] == "sucesso"){
								
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=alunos_clientes<?php print($_SESSION["urlPesquisa"]);?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></div></td>
								<?php
								
							}
							?>
						</table>
					</td>
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
	<?php
	// Verifica referência
	if($_REQUEST["ref"] == "novo"){
		
		// Inclui Novo
		require_once($pathInc . "modulos/gerenciamentos/_/_alunos_clientes.add.php");
		
	}elseif($_REQUEST["ref"] == "edit"){
		
		// Inclui Edit
		require_once($pathInc . "modulos/gerenciamentos/_/_alunos_clientes.edit.php");
		
	}elseif($_REQUEST["ref"] == "sucesso"){
		
		// Inclui Edit
		require_once($pathInc . "modulos/gerenciamentos/_/_alunos_clientes.sucesso.php");
		
	}else{
		
		// Limpa Sessão
		unset($_SESSION["idNota"]);
		unset($_SESSION["urlPesquisa"]);
		
		// Inclui Consulta
		require_once($pathInc . "modulos/gerenciamentos/_/_alunos_clientes.consulta.php");
		
	}
	?>
</table>