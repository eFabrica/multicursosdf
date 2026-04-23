<!-- include-me.php -->
<?php require_once("php7_mysql_shim.php");
include("conexao.php") ;
?>
<?php

	$urlManut = "//manut.php";
	$CPF = $_REQUEST["CPF"];
	$CPF1 = str_replace('.','',$_REQUEST["CPF"]);
	$CPF2 = str_replace('-','',$CPF1);
	$SENHA1 = $_REQUEST["PASS"];
	$SENHA2 = md5($_REQUEST["PASS"]);
	
	$query = "SELECT nivel, cpf  FROM `usuarios` WHERE CPF = '" . $CPF2 . "' AND SENHA = '" .$SENHA2 . "'";
	
	$result = mysql_query($query);
	
	if ( mysql_num_rows($result) == 0 ){
		echo "<script language='JavaScript'>";
		echo "	alert('Usuário não cadastrado');";	
		echo "	document.location.href ='http://www.multicursosdf.com.br';";
		echo "</script>";
	}
	else{
		$NIVEL2 = mysql_result($result, 0, "nivel");
		if ($NIVEL2=="100"){
			echo "<script language='JavaScript'>";
			echo "	document.location.href ='manutencao.php?Acesso=true&cpf=$CPF&senha=$SENHA1';";
			echo "</script>";
		}
		else{
			echo "<script language='JavaScript'>";
			echo "	document.location.href ='http://www.multicursosdf.com.br/cms/areaLogin.php?cpf=$CPF&senha=$SENHA1';";
			echo "</script>";
		}
		
	}		
	
	
?>