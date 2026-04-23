<?php
// Helpers de segurança do site público v2.
// Incluir no topo de qualquer arquivo que processe formulários, session ou saída HTML.

if (!defined('V2_SECURITY_LOADED')) {
    define('V2_SECURITY_LOADED', 1);

    // Session hardening: httponly, samesite, secure (quando HTTPS).
    if (session_status() === PHP_SESSION_NONE) {
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'secure'   => $https,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        session_start();
    }

    // Escape para saida HTML. Uso em template: echo h($var);
    function h($value) {
        if ($value === null) return '';
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    // Gera (ou reaproveita) o CSRF token da sessão.
    function csrf_token() {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }

    // Campo oculto pronto para colocar em qualquer <form>.
    function csrf_field() {
        return '<input type="hidden" name="_csrf" value="' . h(csrf_token()) . '">';
    }

    // Valida o token recebido no POST. Se inválido, interrompe com 403.
    function csrf_check() {
        $sent = $_POST['_csrf'] ?? '';
        $kept = $_SESSION['_csrf'] ?? '';
        if (!is_string($sent) || $sent === '' || !hash_equals($kept, $sent)) {
            http_response_code(403);
            header('Content-Type: text/html; charset=UTF-8');
            echo '<!doctype html><meta charset="utf-8"><title>Sessão inválida</title>';
            echo '<h1>Sessão inválida ou expirada</h1>';
            echo '<p>Volte à página anterior, atualize e envie novamente.</p>';
            exit;
        }
    }
}
