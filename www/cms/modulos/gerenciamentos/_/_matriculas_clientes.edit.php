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
					<?php print((($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == "")?"<b>Dados do Aluno</b>":"Dados do Aluno")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "2")?"<b>Empresa</b>":"Empresa")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "3")?"<b>Define Turma</b>":"Define Turma")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "4")?"<b>Sucesso</b>":"Sucesso")); ?>
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

// Verifica URL Pesquisa
if($_SESSION["consultaMatricula"]["idRegistro"] > 0){
	
	// Dados da Matrícula
	$dadosMatricula = $_ClassRn->getDadosTable("matriculas", "*", "id = '" . $_SESSION["consultaMatricula"]["idRegistro"] . "' AND empresa > 0");
	
}

// Verifica Etapa
if($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == ""){
	
	// Inclui Etapa 1
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculas_clientes.edit.etapa1.php");
	
}elseif($_REQUEST["etapa"] == "2"){
	
	// Inclui Etapa 2
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculas_clientes.edit.etapa2.php");
	
}elseif($_REQUEST["etapa"] == "3"){
	
	// Inclui Etapa 3
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculas_clientes.edit.etapa3.php");
	
}elseif($_REQUEST["etapa"] == "4"){
	
	// Inclui Etapa 3
	require_once($pathInc . "modulos/gerenciamentos/_/_matriculas_clientes.edit.etapa4.php");
	
}
?>