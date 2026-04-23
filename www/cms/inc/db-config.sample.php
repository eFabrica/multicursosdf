<?php
// Template de configuracao do banco.
// Para usar em producao:
//   1) Copie este arquivo para db-config.php no mesmo diretorio
//   2) Preencha com as credenciais reais de producao
//   3) NAO commite o db-config.php (esta no .gitignore)
//
// Em desenvolvimento (Docker), as mesmas variaveis sao injetadas via env vars
// pelo docker-compose.yml, entao este arquivo nao e necessario em dev.

define('DB_HOST', 'mysql.exemplo.com.br');
define('DB_USER', 'usuario_mysql');
define('DB_PASS', 'senha_mysql');
define('DB_NAME', 'nome_do_banco');
