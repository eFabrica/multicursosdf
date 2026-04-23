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
					<?php print((($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == "")?"<b>Localizando Aluno</b>":"Localizando Aluno")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "2")?"<b>Dados do Aluno</b>":"Dados do Aluno")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "3")?"<b>Empresa</b>":"Empresa")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "4")?"<b>Falta de Documentos</b>":"Falta de Documentos")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "5")?"<b>Define Turma</b>":"Define Turma")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "6")?"<b>Sucesso</b>":"Sucesso")); ?>
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
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculas_clientes.add.etapa1.php");
	
}elseif($_REQUEST["etapa"] == "2"){
	
	// Inclui Etapa 2
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculas_clientes.add.etapa2.php");
	
}elseif($_REQUEST["etapa"] == "3"){
	
	// Inclui Etapa 3
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculas_clientes.add.etapa3.php");
	
}elseif($_REQUEST["etapa"] == "4"){
	
	// Inclui Etapa 4
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculas_clientes.add.etapa4.php");
	
}elseif($_REQUEST["etapa"] == "5"){
	
	// Inclui Etapa 5
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculas_clientes.add.etapa5.php");
	
}elseif($_REQUEST["etapa"] == "6"){
	
	// Inclui Etapa 5
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculas_clientes.add.etapa6.php");
	
}
?>