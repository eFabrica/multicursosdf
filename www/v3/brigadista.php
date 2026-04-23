<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external     = true;
$page_title       = 'Brigadista Particular';
$page_description = 'Curso de Brigadista Particular conforme NT 007/2011 do CBM-DF e NBR 14.276. 151h/aula.';

$curso_nome  = 'Brigadista Particular';
$curso_slug  = 'formacao_brigadista';
$curso_lead  = 'Formação completa para atuar em brigadas de incêndio, conforme CBM-DF e NBR 14.276. 151h/aula com práticas reais de combate, resgate e abandono de área.';
$curso_blocos = [
  'Objetivo' => 'Elaborado segundo a norma técnica 007/2011 do <strong>Corpo de Bombeiro Militar - DF</strong> e a <strong>NBR 14.276</strong>, estabelece critérios mínimos para formação de Brigadistas que atuarão em Brigadas de Incêndio, visando proteger a vida, o patrimônio e reduzir as consequências sociais do sinistro.',
  'Carga horária' => '151 horas/aula',
  'Público alvo' => 'Qualquer pessoa interessada em atuar na área de segurança contra incêndio e pânico: técnicos e alunos de Segurança do Trabalho, profissionais do SESMT e áreas operacionais.',
  'Conteúdo programático' => 'Relações Humanas; legislação de segurança contra incêndio e pânico do DF; primeiros socorros; Prevenção e Combate a Incêndios; Salvamento; Abandono de área; Sistemas de segurança contra incêndio e pânico.',
  'Instruções metodológicas' => 'Curso teórico-prático. Prática de combate a incêndios, técnicas de análise de vítimas, vias aéreas, RCP, transporte de vítimas e abandono de área.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
