<?php require_once("php7_mysql_shim.php");
//
 	#$servidor = 'mysql.multicursosdf.com.br';
 	$servidor = 'localhost';
	$usuario = 'multicursosdf';
	$senha = 'multi';
	$banco = 'multicursosdf';

	mysql_connect($servidor,$usuario, $senha) OR DIE ("Unable to connect to database! Please try again later.");
	mysql_select_db($banco);

?>
