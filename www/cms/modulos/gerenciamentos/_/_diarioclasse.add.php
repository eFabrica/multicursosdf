<tr>
	<td align="left"><div id="border-top"><div><div></div></div></div></td>
</tr>
<tr>
	<td class="table_main">
		<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
			<tr>
				<td align="left">
					<font class="menu_topico">Etapas [ </font>
					<?php //print((($_REQUEST["etapa"] == "")?"<b></b>":"")); ?>
					<?php print((($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == "")?"<b>Localiza Aula</b>":"Localiza Aula")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "2")?"<b>Define do Conteúdo</b>":"Define do Conteúdo")); ?>
					|
					<?php print((($_REQUEST["etapa"] == "3")?"<b>Sucesso</b>":"Sucesso")); ?>
					<font class="menu_topico"> ]</font>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
</tr>
<tr>
	<td style='height:5px';>&nbsp;</td>
</tr>
<?php
// Verifica Etapas
switch ($_REQUEST["etapa"]){
	
	// Etapa 2
	case "2": 
	
		// Limpa Sessão
		unset($_SESSION["idDiarioClasse"]);
		
		// Adiciona Etapa 2
		require_once($pathInc . "modulos/gerenciamentos/_/_diarioclasse.add.etapa2.php"); 
		
	break;
	
	// Etapa 3
	case "3": require_once($pathInc . "modulos/gerenciamentos/_/_diarioclasse.add.etapa3.php"); break;
	
	// Etapa 1
	default: 
		
		// Limpa Sessão
		unset($_SESSION["idGrade"]);
		unset($_SESSION["idDiarioClasse"]);
		
		// Adiciona Etapa 1
		require_once($pathInc . "modulos/gerenciamentos/_/_diarioclasse.add.etapa1.php");
	
}
?>