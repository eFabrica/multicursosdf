<?php require_once("php7_mysql_shim.php");

  # Conexao ao banco MySQL via variaveis de ambiente.
  # Arquivo legado preservado por compatibilidade; sem credenciais hardcoded.

  $servidor = getenv('DB_HOST_HUGOPOLITEC') ?: getenv('DB_HOST');
  $usuario  = getenv('DB_USER_HUGOPOLITEC') ?: getenv('DB_USER');
  $senha    = getenv('DB_PASS_HUGOPOLITEC') ?: getenv('DB_PASS');
  $banco    = getenv('DB_NAME_HUGOPOLITEC') ?: getenv('DB_NAME');

  foreach (['DB_HOST' => $servidor, 'DB_USER' => $usuario, 'DB_PASS' => $senha, 'DB_NAME' => $banco] as $name => $value) {
      if ($value === false || $value === '') {
          http_response_code(500);
          die("Erro de configuracao: defina $name (ou *_HUGOPOLITEC) no ambiente.");
      }
  }

  $link = mysql_connect($servidor, $usuario, $senha)
      or die('Nao foi possivel conectar ao banco de dados.');

  mysql_select_db($banco) or die('Nao foi possivel selecionar o banco de dados.');

?>
