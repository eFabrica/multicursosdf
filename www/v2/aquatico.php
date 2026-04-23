<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external     = true;
$page_title       = 'Salvamento Aquático (Salva-Vidas)';
$page_description = 'Formação de salva-vidas para piscinas, clubes e parques aquáticos. 40h/aula com práticas aquáticas.';

$curso_nome  = 'Salvamento Aquático (Salva-Vidas)';
$curso_slug  = 'salva_vidas';
$curso_lead  = 'Formação de salva-vidas profissionais para atuar em piscinas, lagos, rios e parques aquáticos. 40 horas/aula com práticas supervisionadas.';
$curso_blocos = [
  'Objetivo' => 'Capacitar e atualizar profissionais que irão atuar na segurança em piscinas e águas.',
  'Carga horária' => '40 horas/aula',
  'Requisitos' => 'Idade mínima de 18 anos, boas condições físicas, saber nadar.',
  'Conteúdo programático' => 'Identificação do meio aquoso; abordagem e retirada do afogado; técnicas de entrada em lagos, rios e piscinas; mergulho pranchado; nado de aproximação e reboque; técnicas de segurança com vítimas; equipamentos de salvamento aquático; reboque com prancha longa; retirada de vítimas do meio aquoso; chave de Rautec e técnicas de judô aquático; tratamento do afogado (classificação, administração de oxigênio).',
  'Instruções metodológicas' => 'Curso teórico-prático, com realização de práticas em piscina.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
