<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external     = true;
$page_title       = 'EPI - NR-06';
$page_description = 'Equipamentos de Proteção Individual conforme NR-06. 4h/aula.';

$curso_nome  = 'EPI - NR-06';
$curso_slug  = 'epi';
$curso_lead  = 'Introdução prática aos EPIs mais comuns usados para proteção contra riscos químicos, ruído e danos mecânicos. 4 horas/aula.';
$curso_blocos = [
  'Apresentação' => 'Introdução prática aos tipos mais comuns de EPI usados para proteção contra riscos comuns: químicos, ruído e danos mecânicos.',
  'Objetivo' => 'Conscientizar e instruir o funcionário sobre o uso correto, conservação e higienização dos equipamentos individuais para a finalidade destinada.',
  'Carga horária' => '4 horas/aula',
  'Público alvo' => 'Trabalhadores, gerentes e supervisores de áreas industriais, construção, demolição, mineração, floresta, membros da CIPA e interessados.',
  'Conteúdo programático' => 'Controle de risco; programa de EPI; responsabilidade; proteção para cabeça (capacetes); pés (sapatos de segurança); olho e rosto (óculos); ouvido (protetores auriculares); mãos (luvas); respiratória; roupa de alta visibilidade.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
