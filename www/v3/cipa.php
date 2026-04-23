<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external     = true;
$page_title       = 'CIPA - NR-05';
$page_description = 'Comissão Interna de Prevenção de Acidentes conforme NR-05. 20h/aula.';

$curso_nome  = 'CIPA - NR-05';
$curso_slug  = 'cipa';
$curso_lead  = 'Capacitação em conformidade com a NR-05 para formação e manutenção da Comissão Interna de Prevenção de Acidentes. 20 horas/aula.';
$curso_blocos = [
  'Objetivo' => 'Capacitar, atualizar e certificar profissionais em conformidade com a NR-05, nas ações de formação e manutenção da CIPA, com foco na melhoria contínua das condições de trabalho para prevenção de acidentes e doenças ocupacionais.',
  'Carga horária' => '20 horas/aula',
  'Público alvo' => 'Engenharia, técnicos e alunos de Segurança do Trabalho, profissionais do SESMT e de áreas operacionais.',
  'Conteúdo programático' => 'História da segurança e saúde no trabalho; origem das NRs; apresentação das 33 NRs; organização da CIPA; estudo do ambiente de trabalho; higiene ocupacional e controle de riscos; inspeção de segurança; mapa de riscos ambientais; acidentes e doenças do trabalho (conceitos, classificação, causas); metodologia de investigação; comunicação de acidentes; legislação trabalhista e previdenciária; noções sobre AIDS e medidas de prevenção.',
  'Conteúdo complementar' => 'EPIs; ergonomia em escritórios; doenças sexualmente transmissíveis; dengue; tabagismo; prevenção e combate a incêndio; abandono de área; primeiros socorros.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
