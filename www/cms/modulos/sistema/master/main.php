<?php
// Verifica Sessão
switch ($_REQUEST["sessao"]){
	
	// Caso for Inicial
	case "inicial": require_once($pathInc . "modulos/sistema/master/escolheUnidade.php"); break;
	
	// Caso for Unidades
	case "unidades": require_once($pathInc . "modulos/sistema/master/_unidades.php"); break;
	
	// Caso for Usuários
	case "usuarios": require_once($pathInc . "modulos/sistema/master/_usuarios.php"); break;
	
}
?>