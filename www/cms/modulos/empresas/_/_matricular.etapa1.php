<tr>
	<td align="left"><div id="border-top"><div><div></div></div></div></td>
</tr>
<tr>
	<td class="table_main">
		<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
			<tr>
				<td align="left">
					<table width="99%" border="0" cellpadding="2" cellspacing="2" align="center">
						<tr>
							<td class="menu_topico_s">Próximas Turmas</td>
						</tr>
						<?php require_once("php7_mysql_shim.php");
						// Busca Cursos
						$buscaCursos = $_ClassMysql->query("SELECT * FROM `cursos` WHERE deletado = 'N' AND unidade = '" . $_dadosLogado->unidade . "' AND id = '2'");
						
						// Traz Cursos
						while($trazCursos = mysql_fetch_object($buscaCursos)){
							?>
							<tr>
								<td align="left"><img src="<?php print($pathInc . "imagens/diversos/setaG.jpg");?>"><b><?php print($trazCursos->nome);?></b></td>
							</tr>
							<?php
							// Busca Turmas
							$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosLogado->unidade . "' AND deletado = 'N' AND curso = '" . $trazCursos->id . "' AND datainicio > now() AND concluido = 'N' ORDER BY datainicio ASC");
							
							// Traz Curss
							while($trazTurmas = mysql_fetch_object($buscaTurmas)){
								
								// Dados do Turno
								$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $trazTurmas->turno . "'");
								?>
								<tr>
									<td align="left"><ol><img src="<?php print($pathInc . "imagens/diversos/setaGi.jpg");?>"><?php if(($trazTurmas->vagas-$trazTurmas->vagasocupadas) > 0){ ?><a href="?modulo=empresa&sessao=matricular&etapa=2&turma=<?php print($trazTurmas->id);?>"><?php print($_ClassData->transformaData($trazTurmas->datainicio, 2) . " - " . $dadosTurno->turno);?></a><?php }else{ ?><font color="Red"><b><?php print($_ClassData->transformaData($trazTurmas->datainicio, 2) . " - " . $dadosTurno->turno);?> (Lotado)</b></font><?php };?></ol></td>
								</tr>
								<?php
							}
							
						}
						?>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="left"><div id="border-bottom"><div><div></div></div></div></td>
</tr>