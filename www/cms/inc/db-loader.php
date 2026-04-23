<?php
// Helper: carrega credenciais de banco de db-config.php OU de env vars.
// Em producao: crie o arquivo db-config.php neste diretorio (veja db-config.sample.php).
// Em dev Docker: as env vars DB_HOST/DB_USER/DB_PASS/DB_NAME sao injetadas pelo docker-compose.

if (!function_exists('db_credentials')) {
    function db_credentials() {
        // 1) tenta ler arquivo local
        $local = __DIR__ . '/db-config.php';
        if (file_exists($local)) {
            require_once $local;
        }

        $host = defined('DB_HOST') ? DB_HOST : getenv('DB_HOST');
        $user = defined('DB_USER') ? DB_USER : getenv('DB_USER');
        $pass = defined('DB_PASS') ? DB_PASS : getenv('DB_PASS');
        $name = defined('DB_NAME') ? DB_NAME : getenv('DB_NAME');

        foreach (['DB_HOST' => $host, 'DB_USER' => $user, 'DB_PASS' => $pass, 'DB_NAME' => $name] as $k => $v) {
            if ($v === false || $v === '' || $v === null) {
                http_response_code(500);
                error_log("db-loader: $k nao definida. Crie cms/inc/db-config.php ou defina via env vars.");
                die('Erro de configuracao do servidor. Contate o administrador.');
            }
        }

        return ['host' => $host, 'user' => $user, 'pass' => $pass, 'name' => $name];
    }
}
