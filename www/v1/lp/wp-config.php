<?php
define('WP_CACHE', false); // Added by WP Rocket
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// Instalador Automatico - Obtem os dados do config_instalador.php //
include(dirname(__FILE__) . '/wp_config_instalador.php');

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', DB_NOME);

/** Usuário do banco de dados MySQL */
define('DB_USER', DB_USUARIO);

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', DB_SENHA);

/** nome do host do MySQL */
define('DB_HOST', DB_SERVIDOR);

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '@ :g5T:F{Ea;PK,ebmUo?u=I%RVT$W:=H$3yz xKX]]^48F5.KBG+U2t^QiV|!ja');
define('SECURE_AUTH_KEY',  'f.z/pEKG!l%R[}`:i+4Gg9W_xpW5LnRq8$/`ey96J-YIIH,D~0f!l&ky~ST{n2{~');
define('LOGGED_IN_KEY',    '6>4#ce7WB<bxN(Kf~853ZMH;x:*|4csUW#n=AX|/e}pl5#qfbM~npo}23255Tzf2');
define('NONCE_KEY',        '=U./`>=w1 Hu?bEziKmSFu>=eF+B4A[/T~MTFA~gEfChSerz/MD,k|AFepcP!|?]');
define('AUTH_SALT',        'V@:Bs0qWZqhD<p2<jzyOL$K($iB*sn_.FO7zj:}#^_ym*Mj>m|l]!uP>u9>{HUnS');
define('SECURE_AUTH_SALT', 'C>CW~}QL?M+Pou*sbkr#fav9BUo3=uJk3B%Y>mcSuCsqhh*CNs/*)qgK>7IHU(-Q');
define('LOGGED_IN_SALT',   'i}w9HynPL:}C3jlYr;7V$,5A%v*.Ur%]x;Fu{5ORW=U}Dy`{I@P}{u+Vi1n>>KBz');
define('NONCE_SALT',       'wToxMz(z,/L{R%Vwq|$C(J3tHD4!|^rt*.o|u*,<!m#z/Hm[*$$52!cyc?^UcV?n');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix  = PREFIXO.'__';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
define('CONCATENATE_SCRIPTS', false);
require_once(ABSPATH . 'wp-settings.php');

/**
 * Configuracao do phpmailer
 *
 * Previne o plugin wp-mail-smtp de atualizar a conexão smtp caso o servidor suporte SSL
 */
add_action( 'phpmailer_init', 'mail_relay' );
function mail_relay( $phpmailer ) {
	if ( empty( $phpmailer->SMTPSecure ) ) $phpmailer->SMTPAutoTLS = false;
}
