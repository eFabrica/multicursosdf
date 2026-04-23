<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = '../../../';

// Arquivo de Configurações
require_once($pathInc . "inc/config.inc.php");

# Dados de Logado
	
	// Verifica se está logado
	if($_SESSION["dadosLogin"]["idLogado"] > 0){

		// Dados do Logado
		$_dadosLogado = $_ClassRn->getDadosTable("usuarios", "*", "id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");
		
		// Dados da Unidade
		$_dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N'");
		
	
	}

// Classe de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Classe de Data
require_once($pathInc . "lib/Data.class.php");

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "turno, curso, numero", "id = '" . $_REQUEST["idTurma"] . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $dadosTurma->curso . "'");

// Dados do Turno
$dadosTurno = $_ClassRn->getDadosTable("turnos", "*", "id = '" . $dadosTurma->turno . "'");
?>
<html>
	<head>
		<?php require_once($pathInc . "includes/head.php"); ?>
	</head>
	
	<body>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td colspan="2" class="menu_topico">Dados da Turma Concluída</td>
			</tr>
			<tr>
				<td align='left'>
					<table width="100%" border="0" cellpadding="2" cellspacing="2" align="left">
						<tr>
							<td width="15%" align="right"><b>Turma:</b></td>
							<td width='85%' align='left'><?php print($dadosCurso->sigla . $dadosTurma->numero);?></td>
						</tr>
						<tr>
							<td align="right"><b>Turno:</b></td>
							<td align='left'><?php print($dadosTurno->horarioi . "/" . $dadosTurno->horariof);?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="menu_topico">Listagem dos Alunos</td>
			</tr>
			<tr>
				<td align='left'><br /></td>
			</tr>
			<tr>
				<td align='left'><br /></td>
			</tr>
			<tr>
				<td align='left'>
					<?php
					// Busca Matrículas
					$buscaMatriculas = $_ClassMysql->query("SELECT 
																m.* 
															FROM 
																`matriculas` m, 
																`alunos` a 
															WHERE 
																m.unidade = '" . $_dadosUnidade->id . "' AND 
																m.turma = '" . $_REQUEST["idTurma"] . "' AND 
																m.deletado = 'N'  AND
																a.deletado = 'N' AND
																a.unidade = '" . $_dadosUnidade->id . "' AND 
																a.id = m.aluno
															GROUP BY 
																a.nome");
					
					// Verifica o total encontrado
					if(mysql_num_rows($buscaMatriculas) > 0) {
						
						?>
						<table class="consulta" cellspacing="1" align="center">
							<thead>
								<tr>
									<th width="1%">#</th>										
									<th width="40%">Aluno</th>
									<th width="20%">CPF</th>
									<th width="5%">Concl.</th>
									<th width="5%">Reprov.</th>
									<th width="10%">Ft. Docs.</th>
									<th width="5%">Freq.</th>
									<th width="5%">Notas</th>
									<th width="5%">Cert.</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// Traz Matrículas
								while ($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
									
									// Dados do Aluno
									$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");
									
									// Busca Falta de Documentos
									$buscaFaltaDocumentos = $_ClassMysql->query("SELECT * FROM `faltadocumentos` WHERE matricula = '" . $trazMatriculas->id . "' AND deletado = 'N'");
									
									// Total de falta de Documentos
									$totalFaltaDocumentos = mysql_num_rows($buscaFaltaDocumentos);
									
									// Busca Frequências
									$buscaFrequencias = $_ClassMysql->query("SELECT * FROM `frequencias` WHERE matricula = '" . $trazMatriculas->id . "' AND deletado = 'N'");
									
									// Total de Frequências
									$totalFrequencias = mysql_num_rows($buscaFrequencias);
									
									// Busca Notas
									$buscaNotas = $_ClassMysql->query("SELECT * FROM `notas` WHERE matricula = '" . $trazMatriculas->id . "' AND deletado = 'N'");
									
									// Total de Notas
									$totalNotas = mysql_num_rows($buscaNotas);
									?>
									<tr class=row0>
										<td align='left'><?php print((($trazMatriculas->numero <= 0)?$trazMatriculas->id . ".":$trazMatriculas->numero)); ?></td>
										<td align="left"><a name="<?=$trazResultados->id?>"></a><?php print($dadosAluno->nome);?></td>
										<td align="center"><?php print($_ClassUtilitarios->formataCPF($dadosAluno->cpf));?></td>
										<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($trazMatriculas->concluido);?>.png" border="0"></td>
										<td align="center"><img src="<?php print($pathInc);?>imagens/diversos/<?php print($trazMatriculas->reprovado);?>.png" border="0"></td>
										<td align="center">
											<?php
											// Verifica Dados
											if($totalFaltaDocumentos > 0){
												?>
												<a href="#" onclick="popup('documentos<?=$trazMatriculas->id?>', '<?php print($pathInc);?>modulos/gerenciamentos/_/_faltadocumentos.listagem.php?idMatricula=<?php print($trazMatriculas->id);?>', 730, 400, 'yes')">
													<img src="<?php print($pathInc);?>imagens/icones/sh.png" border="0">
												</a>
												<?php
											}else{
												?>
												<img src="<?php print($pathInc);?>imagens/diversos/N.png" border="0">
												<?php
											}
											?>
										</td>
										<td align="center">
											<?php
											// Verifica Dados
											if($totalFrequencias > 0){
												?>
												<a href="#" onclick="popup('frequencias<?=$trazMatriculas->id?>', '<?php print($pathInc);?>modulos/gerenciamentos/_/_frequencias.listagem.php?idMatricula=<?php print($trazMatriculas->id);?>', 730, 400, 'yes')">
													<img src="<?php print($pathInc);?>imagens/icones/sh.png" border="0">
												</a>
												<?php
											}else{
												?>
												<img src="<?php print($pathInc);?>imagens/diversos/N.png" border="0">
												<?php
											}
											?>
										</td>
										<td align="center">
											<?php
											// Verifica Dados
											if($totalNotas > 0){
												?>
												<a href="#" onclick="popup('notas<?=$trazMatriculas->id?>', '<?php print($pathInc);?>modulos/gerenciamentos/_/_notas.listagem.php?idMatricula=<?php print($trazMatriculas->id);?>', 730, 400, 'yes')">
													<img src="<?php print($pathInc);?>imagens/icones/sh.png" border="0">
												</a>
												<?php
											}else{
												?>
												<img src="<?php print($pathInc);?>imagens/diversos/N.png" border="0">
												<?php
											}
											?>
										</td>
										<td align="center">
											<?php 
											// Verifica Dados
											if($trazMatriculas->concluido == "S" && 
											   $totalFaltaDocumentos <= 0 && 
											   $totalFrequencias > 0 && 
											   $totalNotas > 0){
												?>
												<a href="<?php print($pathInc);?>modulos/relatorios/_rel.certificados.emitir.php?idMatricula=<?php print($trazMatriculas->id);?>" target="_blank">
													<img src="<?php print($pathInc);?>imagens/icones/printer.gif" border="0">
												</a>
												<?php 
											}else{
												?>
												<img src="<?php print($pathInc);?>imagens/diversos/N.png" border="0">
												<?php 
											}
											?>
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
						<?php
						
					}else{
						
						// Exibe Mensagem
						print("Nenhum aluno encontrado.");
						
					}
					?>
				</td>
			</tr>
			<tr>
				<td align='left'>
				</td>
			</tr>
		</table>
	</body>
</html>