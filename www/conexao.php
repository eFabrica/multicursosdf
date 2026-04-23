<?php
require_once(__DIR__ . '/php7_mysql_shim.php');
require_once(__DIR__ . '/cms/inc/db-loader.php');

// Credenciais vem de:
//   1) Arquivo local cms/inc/db-config.php (producao)
//   2) Ou variaveis de ambiente (dev Docker)
$_db = db_credentials();

$link = mysql_connect($_db['host'], $_db['user'], $_db['pass']);
if (!$link) {
    http_response_code(500);
    error_log('conexao.php: ' . mysql_error());
    die('Nao foi possivel conectar ao banco de dados.');
}

if (!mysql_select_db($_db['name'])) {
    http_response_code(500);
    error_log('conexao.php: selecao de banco falhou');
    die('Nao foi possivel selecionar o banco de dados.');
}
