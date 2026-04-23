<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external     = true;
$page_title       = 'Brigadista Voluntário';
$page_description = 'Formação de brigadistas voluntários para escolas, condomínios e pequenas empresas. 16h/aula.';

$curso_nome  = 'Brigadista Voluntário';
$curso_slug  = 'voluntario';
$curso_lead  = 'Formação acessível de brigadistas voluntários para escolas, condomínios e pequenas empresas, conforme NBR 14.276 e NT 007/2011 do CBM-DF. 16h/aula.';
$curso_blocos = [
  'Objetivo' => 'Capacitar, atualizar e certificar profissionais em conformidade com a NBR-14276 e NT 007/2011 do CBM-DF, nas ações de prevenção e combate a princípios de incêndios. Proporciona conhecimentos básicos sobre prevenção, isolamento e extinção, abandono de área e primeiros socorros.',
  'Carga horária' => '16 horas/aula',
  'Público alvo' => 'Escolas, condomínios, pequenas empresas e qualquer interessado em formar brigada voluntária sem pré-requisitos.',
  'Conteúdo programático' => 'O que é fogo; triângulo do fogo; teoria da combustão; propagação; classes de incêndio; métodos de extinção; agentes extintores; extintores; combate com mangueiras e hidrantes; procedimentos em locais de incêndio; sistemas de detecção e alarme; pessoas com mobilidade reduzida; plano de emergência; abandono de área e controle de pânico.',
  'Instruções metodológicas' => 'Curso teórico-prático: utilização de extintores; maneabilidade com mangueiras; combate a princípios de incêndios; abandono de área e controle de pânico.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
