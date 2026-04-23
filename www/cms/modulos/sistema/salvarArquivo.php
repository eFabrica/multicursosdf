<?
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

//Muda o diretório
chdir($_GET["path"]); 

//headers
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Content-Type: application/force-download"); 
header("Content-Type: application/octetstream"); 
header("Content-Type: application/download"); 
header("Content-Disposition: attachment; filename=" . (($_GET["modo"] == "2")?"Comprovante.txt":((substr($_GET["file"], 0, 2) == "FO")?"Curso.txt":"recicla.txt"))); 
header("Content-Transfer-Encoding: binary"); 

//Lê e exibe o conteúdo de um arquivo
readfile($_GET["file"]); 
?>