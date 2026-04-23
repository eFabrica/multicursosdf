<?php require_once("php7_mysql_shim.php");

  ##---------------------------------------------------
  ##  Conexao ao banco de dados MySQL usando PHP
  ##---------------------------------------------------

  # Credenciais vem OBRIGATORIAMENTE de variaveis de ambiente (docker-compose ou servidor).
  # Sem fallback hardcoded - configure DB_HOST/DB_USER/DB_PASS/DB_NAME no ambiente.

  $servidor = getenv('DB_HOST');
  $usuario  = getenv('DB_USER');
  $senha    = getenv('DB_PASS');
  $banco    = getenv('DB_NAME');

  foreach (['DB_HOST' => $servidor, 'DB_USER' => $usuario, 'DB_PASS' => $senha, 'DB_NAME' => $banco] as $name => $value) {
      if ($value === false || $value === '') {
          http_response_code(500);
          error_log("conexao.php: variavel de ambiente $name nao definida");
          die('Erro de configuracao do servidor. Contate o administrador.');
      }
  }

  $link = mysql_connect($servidor, $usuario, $senha)
      or die('Nao foi possivel conectar ao banco de dados.');

  mysql_select_db($banco) or die('Nao foi possivel selecionar o banco de dados.');

?>
