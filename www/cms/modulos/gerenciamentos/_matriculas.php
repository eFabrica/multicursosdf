<?php
// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Verifica URL Pesquisa
if($_REQUEST["idRegistro"] > 0){
	
	// Cadastra tipo do Registro na sessão
	$_SESSION["consultaMatricula"]["tipoRegistro"] = "privado";
	
	// Cadastra id Registro na sessão
	$_SESSION["consultaMatricula"]["idRegistro"] = $_REQUEST["idRegistro"];
	
	// Cadastra URL da pesquisa na sessão
	$_SESSION["consultaMatricula"]["urlPesquisa"] = "&pg=" . $_REQUEST["pg"] . "&ref=buscar";
	
	// Cadatra Y
	$_SESSION["consultaMatricula"]["y"] = $_REQUEST["y"];
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
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00018.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">
						Matrículas [Privadas] <?php print($_ClassUtilitarios->refTopico()); ?>
						<?php
						// Verifica Referência
						if($_REQUEST["ref"] == "novo"){
							
							// Verifica Etapas
							switch($_REQUEST["etapa"]){
								
								// Caso 2
								case "2": print(" - Dados do Aluno"); break;
								
								// Caso 3
								case "3": print(" - Falta de Documentos"); break;
								
								// Caso 4
								case "4": print(" - Define Turma"); break;
								
								// Caso 5
								case "5": print(" - Define Valor"); break;
								
								// Caso 6
								case "6": print(" - Sucesso!"); break;
								
								// Default
								default: print(" - Localizando Aluno");
								
							}
							
						}elseif($_REQUEST["ref"] == "edit"){
							
							// Verifica Etapas
							switch($_REQUEST["etapa"]){
								
								// Caso 2
								case "2": print(" - Define Turma"); break;
								
								// Caso 3
								case "3": print(" - Define Valor"); break;
								
								// Caso 4
								case "4": print(" - Sucesso!"); break;
								
								// Default
								default: print(" - Dados do Aluno");
								
							}
							
						}
						?>
					</td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == ""){
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova</a><div></td>
								<?php
							}elseif($_REQUEST["ref"] == "buscar"){
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
								<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00031.png&l=50&a=50" border="0"><br>Nova</a><div></td>
								<?php
							}elseif($_REQUEST["ref"] == "novo"){
								
								if($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == ""){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=alunos&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00007.png&l=50&a=50" border="0"><br>Novo Aluno</a><div></td>
									<?php
									// Verifica SubMenu
									if($_REQUEST["submenu"] == "buscar"){
										?>
										<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formMatricula.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
										<?php
									}
									
								}elseif($_REQUEST["etapa"] == "2"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&ref=novo&etapa=1"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formMatricula.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
									<?php
								}elseif($_REQUEST["etapa"] == "3"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&ref=novo&etapa=2"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formMatricula.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
									<?php
								}elseif($_REQUEST["etapa"] == "4"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&ref=novo&etapa=3"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<?php 
									// Verifica se fez a busca
									if($_REQUEST["submenu"] == "buscar" || $_SESSION["matricula"]["idTurma"] > 0){
										?>
										<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formMatricula.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
										<?php
									}
									
								}elseif($_REQUEST["etapa"] == "5"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&ref=novo&etapa=4"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formMatricula.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a><div></td>
									<?php
								}elseif($_REQUEST["etapa"] == "6"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&ref=novo"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></td>
									<?php
								}
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&ref="><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></td>
								<?php
							}elseif($_REQUEST["ref"] == "edit"){
								
								if($_REQUEST["etapa"] == "1" || $_REQUEST["etapa"] == ""){
									?>
									<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formMatricula.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
									<?php
									
								}elseif($_REQUEST["etapa"] == "2"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&ref=edit&etapa=1"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formMatricula.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00032.png&l=50&a=50" border="0"><br>Próxima Etapa</a><div></td>
									<?php
								}elseif($_REQUEST["etapa"] == "3"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas&ref=edit&etapa=2"><img src="modulos/sistema/img.php?img=../../imagens/icones/00026.png&l=50&a=50" border="0"><br>Etapa Anterior</a><div></td>
									<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formMatricula.submit()"><img src="modulos/sistema/img.php?img=../../imagens/icones/00033.png&l=50&a=50" border="0"><br>Salvar</a><div></td>
									<?php
								}elseif($_REQUEST["etapa"] == "4"){
									?>
									<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas<?php print($_SESSION["consultaMatricula"]["urlPesquisa"]);?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00028.png&l=50&a=50" border="0"><br>Finalizar</a></td>
									<?php
								}
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=matriculas<?php print((($_SESSION["consultaMatricula"]["y"] != "n")?"":"&subsessao=consultageral"));?><?php print($_SESSION["consultaMatricula"]["urlPesquisa"]);?>"><img src="modulos/sistema/img.php?img=../../imagens/icones/00027.png&l=50&a=50" border="0"><br>Cancelar</a></td>
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
	// Verifica Referência
	if($_REQUEST["ref"] == "novo"){
		
		// Inclui Novo
		require_once($pathInc . "modulos/gerenciamentos/_/_matriculas.add.php");
		
	}elseif($_REQUEST["ref"] == "edit"){
		
		// Inclui Edit
		require_once($pathInc . "modulos/gerenciamentos/_/_matriculas.edit.php");
		
	}else{
		
		// Limpa Valores da sessão
		unset($_SESSION["matricula"]["idAluno"]);
		unset($_SESSION["matricula"]["documentos"]);
		unset($_SESSION["matricula"]["numero"]);
		unset($_SESSION["matricula"]["tipo"]);
		unset($_SESSION["matricula"]["empresa"]);
		unset($_SESSION["matricula"]["idTurma"]);
		unset($_SESSION["consultaMatricula"]["texto"]);
		
		// Inclui Consulta
		require_once($pathInc . "modulos/gerenciamentos/_/_matriculas.consulta.php");
		
	}
	?>
</table>