<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td width="5%" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;" align="center">
				<tr>
					<td align='left'><div id="border-top"><div><div></div></div></div></td>
				</tr>
				<tr>
					<td class="table_main">
						<table border="0" cellpadding="2" cellspacing="2" style="margin-left:5px;margin-right:5px;" align="center">
							<tr>
								<td align='left'><div class="caixaIcone" <?=$_ClassUtilitarios->criaLegenda("Listagem de todas as unidades, possibilitando dentre elas, escolher uma para gerenciar.");?>><a href="?sessao=inicial"><img src="imagens/icones/00034.png" border="0"><br>Escolher Unidade</a></div></td>
							</tr>
							<tr>
								<td align='left'><div class="caixaIcone" <?=$_ClassUtilitarios->criaLegenda("Gerenciamento de Unidades, possibilitando cadastrar, editar, suspender acesso e excluir.");?>><a href="?sessao=unidades"><img src="imagens/icones/00013.png" border="0"><br>Unidades</a></div></td>
							</tr>
							<tr>
								<td align='left'><div class="caixaIcone" <?=$_ClassUtilitarios->criaLegenda("Gerenciamento de Usuários, possibilitando cadastrar, editar, suspender acesso e excluir.");?>><a href="?sessao=usuarios"><img src="imagens/icones/00025.png" border="0"><br>Usuários</a></div></td>
							</tr>
							<tr>
								<td align='left'><div class="caixaIcone" <?=$_ClassUtilitarios->criaLegenda("Efetua Logout do sistema, assim excluindo sua sessão atual acarretando um novo Login.");?>><a href="<?php print($pathInc);?>modulos/sistema/sair.php"><img src="imagens/icones/00027.png" border="0"><br>Sair</a></div></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
				</tr>
			</table>
		</td>
		<td width="95%" valign="top"><?php require_once($pathInc . "modulos/sistema/master/main.php");?><br></td>
	</tr>
</table>