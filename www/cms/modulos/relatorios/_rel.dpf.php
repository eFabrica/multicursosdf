<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Class de data
require_once($pathInc . "lib/Data.class.php");

// Class de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Files
require_once($pathInc . "lib/Files.class.php");
	
// Verifica Ação
if($_REQUEST["act"] == "gerar"){
	
	// Dados da Turma
	$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_REQUEST["turma"] . "'");
	
	// Dados do Curso
	$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");
	
	// Código do Arquivo
	$codFile = "";
	
	// Busca Matrículas Conclúidas
	$buscaMatriculas = $_ClassMysql->query("SELECT matriculas.aluno FROM `matriculas`,`alunos` WHERE alunos.id = matriculas.aluno AND matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.turma = '" . $dadosTurma->id . "' AND matriculas.concluido = 'S' AND matriculas.reprovado = 'N' AND matriculas.deletado = 'N' ORDER BY alunos.nome ASC");
	
	// Traz Martrículas
	while($trazMatriculas = mysql_fetch_object($buscaMatriculas)){
	
		// Dados do Aluno
		$dadosAluno = $_ClassRn->getDadosTable("alunos", "*", "id = '" . $trazMatriculas->aluno . "'");
		
		// Dados da Cidade
		$dadosCidade = $_ClassRn->getDadosTable("cidades", "*", "id = '" . $dadosAluno->cidade . "'");
	
		// Verifica Curso
		if(strtoupper($dadosCurso->sigla) == "FOVI"){
	
			// Código - CNPJ da Academia
			$codFile .= $_ClassUtilitarios->completaEB(substr($_ClassUtilitarios->tiraMask($_dadosUnidade->cnpj, 0, 17), 0, 14), 14);
	
			// Código - Nome do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->nome, 0, 50)), 50);
			
			// Código - Data de Nascimento
			$codFile .= str_replace("-", "", $dadosAluno->datanascimento);
			
			// Código - Nome do Pai do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->pai, 0, 40)), 40);
			
			// Código - Nome da Mãe do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->mae, 0, 40)), 40);
			
			// Código - CPF do Aluno
			$codFile .= $_ClassUtilitarios->completaEB(substr($_ClassUtilitarios->tiraMask($dadosAluno->cpf), 0, 11), 11);
			
			// Código - Sexo
			$codFile .= $_ClassUtilitarios->setZero((($dadosAluno->sexo == "M")?"1":"2"), array(2, 1));
			
			// Código - Naturalidade
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->naturalidade, 0, 40)), 40);
			
			// Código - UF Naturalidade
			$codFile .= $_ClassUtilitarios->completaEB($dadosAluno->ufnaturalidade, 2);
			
			// Código - País de Nascimento
			$codFile .= $_ClassUtilitarios->completaEB("BRASIL", 30);
			
			// Código - Identidade do Aluno
			$codFile .= $_ClassUtilitarios->completaEB(substr($dadosAluno->rg, 0, 15), 15);
			
			// Código - Orgão Expeditor da Identidade do Aluno
			$codFile .= $_ClassUtilitarios->completaEB(substr($dadosAluno->orgexp, 0, 12), 12);
			
			// Código - Endereço do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->endereco, 0, 40)), 40);
			
			// Código - Bairro do Endereço do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->bairro, 0, 30)), 30);
			
			// Código - CEP do Endereço do Aluno
			$codFile .= $_ClassUtilitarios->setZero(substr($_ClassUtilitarios->tiraMask($dadosAluno->cep), 0, 8), array(2, 8));
			
			// Código - Cidade do Endereço do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosCidade->cidade, 0, 40)), 40);
			
			// Código - UF Cidade do Endereço do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($dadosAluno->estado, 2);
			
			// Código - Espaço em Branco
			$codFile .= $_ClassUtilitarios->completaEB("", 12);
			
			// Código - Data do Último dia do Curso
			$codFile .= str_replace("-", "", $dadosTurma->datatermino);
			
			// Código - SR/DPF/DF
			$codFile .= "SR/DPF/DF";
			
			// Código - Quebra de Linha
			$codFile .= "\r\n";
	
		}else{
			
			// Código - Código do Curso
			$codFile .= $_ClassUtilitarios->setZero(substr($dadosCurso->ndpf, 0,1), array(2, 1));
			
			// Código - CNPJ da Academia
			$codFile .= $_ClassUtilitarios->completaEB(substr($_ClassUtilitarios->tiraMask($_dadosUnidade->cnpj, 0, 17), 0, 14), 14);
	
			// Código - Nome do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->nome, 0, 50)), 50);
			
			// Código - Data de Nascimento
			$codFile .= str_replace("-", "", $dadosAluno->datanascimento);
			
			// Código - Nome do Pai do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->pai, 0, 40)), 40);
			
			// Código - Nome da Mãe do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->mae, 0, 40)), 40);
			
			// Código - CPF do Aluno
			$codFile .= $_ClassUtilitarios->completaEB(substr($_ClassUtilitarios->tiraMask($dadosAluno->cpf), 0, 11), 11);
			
			// Código - Sexo
			$codFile .= $_ClassUtilitarios->setZero((($dadosAluno->sexo == "M")?"1":"2"), array(2, 1));
			
			// Código - Naturalidade
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->naturalidade, 0, 40)), 40);
			
			// Código - UF Naturalidade
			$codFile .= $_ClassUtilitarios->completaEB($dadosAluno->ufnaturalidade, 2);
			
			// Código - País de Nascimento
			$codFile .= $_ClassUtilitarios->completaEB("BRASIL", 30);
			
			// Código - Identidade do Aluno
			$codFile .= $_ClassUtilitarios->completaEB(substr($dadosAluno->rg, 0, 15), 15);
			
			// Código - Orgão Expeditor da Identidade do Aluno
			$codFile .= $_ClassUtilitarios->completaEB(substr($dadosAluno->orgexp, 0, 12), 12);
			
			// Código - Número de Registro do Curso de Formação
			$codFile .= $_ClassUtilitarios->setZero(substr($dadosAluno->numerorg, 0, 15), array(2, 15));
			
			// Código - Orgão Expeditor do Registro do Curso de Formação
			$codFile .= $_ClassUtilitarios->completaEB(substr($dadosAluno->orgao, 0, 11), 11);
			
			// Código - Endereço do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->endereco, 0, 40)), 40);
			
			// Código - Bairro do Endereço do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->bairro, 0, 30)), 30);
			
			// Código - CEP do Endereço do Aluno
			$codFile .= $_ClassUtilitarios->setZero(substr($_ClassUtilitarios->tiraMask($dadosAluno->cep), 0, 8), array(2, 8));
			
			// Código - Cidade do Endereço do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosCidade->cidade, 0, 40)), 40);
			
			// Código - UF Cidade do Endereço do Aluno
			$codFile .= $_ClassUtilitarios->completaEB($dadosAluno->estado, 2);
			
			// Código - Espaço em Branco
			$codFile .= $_ClassUtilitarios->completaEB("", 12);
			
			// Código - Data do Curso de Formação
			$codFile .= str_replace("-", "", $dadosAluno->dataform);
			
			// Código - Data do Último dia do Curso
			$codFile .= str_replace("-", "", $dadosTurma->datatermino);
			
			// Código - Sigla DPF do Curso
			$codFile .= $_ClassUtilitarios->completaEB(substr($dadosCurso->sigladpf, 0, 3), 3);
			
			// Código - Quebra de Linha
			$codFile .= "\r\n";
			
		}
	
	}
	
	// Escrevendo no arquivo
	$_ClassFiles->writeFile($pathInc . "dpf/", strtoupper($dadosCurso->sigla . $dadosTurma->numero) . ".txt", strtoupper($codFile));
	
	// Redireciona para o Arquivo de Salvamento
	print($_ClassUtilitarios->redirecionarJS("?", 8, array("Arquivo gerado com sucesso!", $pathInc . "modulos/sistema/salvarArquivo.php?path=../../dpf/&file=" . strtoupper($dadosCurso->sigla . $dadosTurma->numero) . ".txt"), false));
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
					<td width="5%"><img src="modulos/sistema/img.php?img=../../imagens/icones/00037.png&l=50&a=50"></td>
					<td align="left" width="" class="menu_topico">Relatórios [DPF] <?php print($_ClassUtilitarios->refTopico()); ?></td>
					<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
							<?php
							// Verifica Referência
							if($_REQUEST["ref"] == "buscar"){							
								?>
								<td align="center"><div class="caixaIcone"><a href="?sessao=dpf"><img src="modulos/sistema/img.php?img=../../imagens/icones/00030.png&l=50&a=50" border="0"><br>Nova Consulta</a><div></td>
								<td align="center"><div class="caixaIcone"><a href="#" onclick="document.formDPF.submit();"><img src="modulos/sistema/img.php?img=../../imagens/icones/00029.png&l=50&a=50" border="0"><br>Emitir</a></div></td>
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
			<form action="" method="POST" name="formDPF">
				<input type="hidden" name="act" value="gerar">
				<table border="0" cellpadding="2" cellspacing="2" align="center">
					<tr>
						<td align="right" width="15%"><b>Filtrar Turmas:</b></td>
						<td width='85%' align='left'><input name="procura" type="text" size="30" onKeyUp="trocaOpcao(this.value, document.formDPF.turma);"></td>
					</tr>
					<tr>
						<td width="15%" align="right"><strong>Turma:</strong></td>
						<td align='left'>
							<select name="turma">
								<?php
								// Busca Turmas
								$buscaTurmas = $_ClassMysql->query("SELECT * FROM `turmas` WHERE unidade = '" . $_dadosUnidade->id . "' AND deletado = 'N'");
								
								// Traz Turmas
								while($trazTurmas = mysql_fetch_object($buscaTurmas)){
									
									// Dados do Curso
									$dadosCurso = $_ClassRn->getDadosTable("cursos", "sigla", "id = '" . $trazTurmas->curso . "'");
									?>
									<option value="<?php print($trazTurmas->id);?>"><?php print($dadosCurso->sigla . $trazTurmas->numero . " (" . $_ClassData->transformaData($trazTurmas->datainicio, 2) . ")");?></option>
									<?php
									
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td align='left'>&nbsp;</td>
						<td align='left'><?php print($_ClassUtilitarios->criaMenu("Gerar", "#", "document.formDPF.submit();", "esq", "007", $pathInc)); ?></td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align='left'><div id="border-bottom"><div><div></div></div></div></td>
	</tr>
</table>