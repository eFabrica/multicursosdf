<?php require_once("php7_mysql_shim.php");
//
  $servidor = 'localhost';
  $usuario = 'multicursosdf';
  $senha = 'multi';
  $banco = 'multicursosdf';

mysql_connect($servidor,$usuario, $senha) OR DIE ("Unable to connect to database! Please try again later.");
mysql_select_db($banco);

?>

<?php


											
   $query = "SELECT cpf FROM usuarios";
   #$result = mysql_query($query);
   $result = mysql_query($query)or die( mysql_error() );
  								
	while($row = mysql_fetch_array($result)){						
		$cpf = $row["cpf"];							
		echo "$cpf"." - <br>";						
	}
   
?>