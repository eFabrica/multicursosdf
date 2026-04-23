<?php require_once("php7_mysql_shim.php");
// Class de data
require_once($pathInc . "lib/Data.class.php");

// Class de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");
?>
<table border="0" cellpadding="0" cellspacing="0" width="98%" style="margin:10px;">
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<table width="99%" border="0" cellpadding="0" cellspacing="0" align="center">
				<tr>
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00037.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Relatórios [Recibo] <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == "buscar"){							
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=rel_recibo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
								<td align="center"><div class="caixaIcone"><a href="<?php print($pathInc);?>modulos/relatorios/_rel.recibo.emitir.php<?php print("?ordem=" . $_REQUEST["ordem"] . "&campo=" . $_REQUEST["campo"]);?>" target="_blank"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Emitir</a></div></td>
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
	<tr>
		<td align='left'><div id="border-top"><div><div></div></div></div></td>
	</tr>
	<tr>
		<td class="table_main">
			<form action="<?php print($pathInc . "modulos/relatorios/_rel.recibo.emitir.php");?>" target="_blank" method="POST" name="formRelrecibo">
				<input type="hidden" name="a" value="S">
				<table width="400" border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td width="15%" align="right"><strong>Instrutor:</strong></td>
						<td width='85%' align='left'>
							<select name="instrutor">
								<option value="todos">Todos</option>
								<?php
								// Busca Instrutores
								$buscaInstrutores = $_ClassMysql->query("SELECT * FROM `usuarios` WHERE unidade = '" . $_dadosUnidade->id . "' AND nivel = '95' AND deletado = 'N' ORDER BY nome");
								
								// Traz Instrutores
								while($trazInstrutores = mysql_fetch_object($buscaInstrutores)){
									
									?>
									<option value="<?php print($trazInstrutores->id);?>"><?php print($trazInstrutores->nome);?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right"><strong>Data:</strong></td>
						<td align='left'>
							De <input type="text" id="dataI" name="dataI" size="12" onKeyUp="maskData(this, document.formRelrecibo.dataF)">
					  		até <input type="text" id="dataF" name="dataF" size="12" onKeyUp="maskData(this, document.formRelrecibo.dataF)">
						</td>
					</tr>
					<tr>
						<td align="right"><b>Valor:</b></td>
						<td align='left'><input type="text" name="valor" onKeydown="Formata(this,20,event,2)" size="20" style="text-align:right;"></td>
					</tr>
					<tr>
						<td align="right"><b>Parcela:</b></td>
						<td align='left'>
							<select name="parcela">
								<option value="1">Parcela 1</option>
								<option value="2">Parcela 2</option>
								<option value="3">Percela Única</option>
							</select>
						</td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
						<td align='left'><?php print($_ClassUtilitarios->criaMenu("Gerar", "#", "document.formRelrecibo.submit();", "esq", "007", $pathInc)); ?></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
</table>