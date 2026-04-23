<?php
require_once(__DIR__ . '/php7_mysql_shim.php');

// Credenciais vêm OBRIGATORIAMENTE de variáveis de ambiente.
// Sem fallback hardcoded (item 2 de melhorias1.md).

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

$link = mysql_connect($servidor, $usuario, $senha);
if (!$link) {
    http_response_code(500);
    error_log('conexao.php: ' . mysql_error());
    die('Nao foi possivel conectar ao banco de dados.');
}

if (!mysql_select_db($banco)) {
    http_response_code(500);
    error_log('conexao.php: selecao de banco falhou');
    die('Nao foi possivel selecionar o banco de dados.');
}
