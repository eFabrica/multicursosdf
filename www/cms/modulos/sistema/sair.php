<?php
// Inicia Sessão
session_start();

// Caminho da Pasta Raiz
$pathInc = '../../';

// Arquivo de Configurações
require_once($pathInc . "inc/config.inc.php");

// Desloga usuário
$_ClassMysql->query("UPDATE `usuarios` SET logado = 'N' WHERE id = '" . $_SESSION["dadosLogin"]["idLogado"] . "'");

// Limpa Sessão
session_unset();

// Destroy Sessão
session_destroy();

// Redireciona
header("Location: ../../../site/");
?>