<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external = true;
$page_title = 'Formação de Instrutor de CIPA';
$page_description = 'Curso de formação para atuar como instrutor de CIPA. 20h/aula.';

$curso_nome = 'Formação de Instrutor de CIPA';
$curso_slug = '';
$curso_lead = 'Desenvolver atividades voltadas para a prevenção de acidentes do trabalho e proteção da saúde dos trabalhadores.';
$curso_blocos = [
  'Objetivo' => 'Desenvolver atividades voltadas não apenas para a prevenção de acidentes do trabalho, mas também à proteção da saúde dos trabalhadores, diante dos riscos existentes nos locais de trabalho.',
  'Carga horária' => '20 horas/aula',
  'Público alvo' => 'Profissionais da área de saúde e segurança do trabalho: técnicos de segurança, auxiliares de enfermagem do trabalho, brigadistas, gerentes de recursos humanos e demais interessados.',
  'Conteúdo programático' => 'NR-05 (CIPA): constituição e atribuições; implantação passo a passo; documentação necessária para registro; principais dúvidas. Acidentes do trabalho: definição, causas, CAT, auxílio doença/acidente, aposentadoria por invalidez. Noções de primeiros socorros. Princípios de combate e prevenção. Técnicas de didática e planejamento de aula. Métodos de avaliação de ensino. Dinâmicas de grupo. Psicologia da motivação em sala de aula.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
