<?php require_once("php7_mysql_shim.php");

  # Credenciais via variaveis de ambiente (sem fallback hardcoded).
  $servidor = getenv('DB_HOST');
  $usuario  = getenv('DB_USER');
  $senha    = getenv('DB_PASS');
  $banco    = getenv('DB_NAME');

  foreach (['DB_HOST' => $servidor, 'DB_USER' => $usuario, 'DB_PASS' => $senha, 'DB_NAME' => $banco] as $name => $value) {
      if ($value === false || $value === '') die("Defina $name no ambiente.");
  }

  mysql_connect($servidor, $usuario, $senha) OR DIE("Unable to connect to database! Please try again later.");
  mysql_select_db($banco);
?>
