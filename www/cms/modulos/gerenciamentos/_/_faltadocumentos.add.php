<tr>
	<td align='left'><div id="border-top"><div><div></div></div></div></td>
</tr>
<tr>
	<td class="table_main">
		<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
			<tr>
				<td align='left'>
					<font class="menu_topico">Etapas [ </font>
					<?php //print((($_REQUEST["etapa"] == "")?"<b></b>":"")); ?>
					<?php print((($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == "")?"<b>Localizando Matrícula</b>":"Localizando Matrícula")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "2")?"<b>Documentos em Falta</b>":"Documentos em Falta")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "3")?"<b>Sucesso</b>":"Sucesso")); ?>
					<font class="menu_topico"> ]</font>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
</tr>
<?php
// Verifica Etapa
if($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == ""){
	
	// Inclui Etapa 1
	require_once($pathInc . "modulos/gerenciamentos/_/_faltadocumentos.add.etapa1.php");
	
}elseif($_REQUEST["etapa"] == "2"){
	
	// Inclui Etapa 2
	require_once($pathInc . "modulos/gerenciamentos/_/_faltadocumentos.add.etapa2.php");
	
}elseif($_REQUEST["etapa"] == "3"){
	
	// Inclui Etapa $
	require_once($pathInc . "modulos/gerenciamentos/_/_faltadocumentos.add.etapa3.php");
	
}
?>