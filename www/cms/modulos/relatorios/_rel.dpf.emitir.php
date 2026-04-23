<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/php7_mysql_shim.php");
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = '../../';

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

// Biblioteca de Dinheiro
require_once($pathInc . "lib/Dinheiro.class.php");

// Biblioteca de Data
require_once($pathInc . "lib/Data.class.php");

// Biblioteca de Files
require_once($pathInc . "lib/Files.class.php");

// Dados da Unidade
$dadosUnidade = $_ClassRn->getDadosTable("unidades", "*", "id = '" . (($_dadosLogado->nivel == "100")?$_SESSION["idUnidade"]:$_dadosLogado->unidade) . "' AND deletado = 'N' AND acesso = 'L'");

// Dados da Turma
$dadosTurma = $_ClassRn->getDadosTable("turmas", "*", "id = '" . $_REQUEST["turma"] . "'");

// Dados do Curso
$dadosCurso = $_ClassRn->getDadosTable("cursos", "*", "id = '" . $dadosTurma->curso . "'");

// Código do Arquivo
$codFile = "";
exit();
// Busca Matrículas Conclúidas
$buscaMatriculas = $_ClassMysql->query("SELECT alunos.id, alunos.nome FROM `maasdastriculas`,`alunos` WHERE matriculas.unidade = '" . $_dadosUnidade->id . "' AND matriculas.turma = '" . $dadosTurma->id . "' AND matriculas.concluido = 'S' AND matriculas.reprovado = 'N' AND matriculas.deletado = 'N' ORDER BY alunos.nome DESC");

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
		$codFile .= $_ClassUtilitarios->completaEB($_ClassString->acentos(substr($dadosAluno->naturalidade), 0, 40), 40);
		
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

// Deleta algum arquivo que tenha o mesmo nome
unlink($pathInc . "dpf/", strtoupper($dadosCurso->sigla . $dadosTurma->numero) . ".txt", strtoupper($codFile));

// Escrevendo no arquivo
$_ClassFiles->writeFile($pathInc . "dpf/", strtoupper($dadosCurso->sigla . $dadosTurma->numero) . ".txt", strtoupper($codFile));

// Redireciona para o Arquivo de Salvamento
print($_ClassUtilitarios->redirecionarJS("?", 8, array("Arquivo gerado com sucesso!", $pathInc . "modulos/sistema/salvarArquivo.php?")));
?>
<html>
	<head>
		<title>Emissão de DPF - Turma: <?php print($dadosCurso->sigla . $dadosTurma->numero);?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link href="<?php print($pathInc);?>css/estilos.css" rel="stylesheet" type="text/css">
	</head>
	
	<body>
		
	</body>
</html>