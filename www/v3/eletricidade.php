<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external     = true;
$page_title       = 'NR-10 Eletricidade';
$page_description = 'Segurança em instalações e serviços em eletricidade conforme NR-10. 40h/aula.';

$curso_nome  = 'NR-10 Eletricidade';
$curso_slug  = 'nr10';
$curso_lead  = 'Requisitos e condições mínimas para garantir a segurança e saúde dos trabalhadores que atuam em instalações elétricas. Nível básico, 40 horas/aula.';
$curso_blocos = [
  'Objetivo' => 'Proporcionar os requisitos e condições mínimas exigíveis pela Norma para garantir a segurança e saúde dos trabalhadores que interajam direta ou indiretamente em instalações elétricas.',
  'Carga horária' => '40 horas/aula',
  'Público alvo' => 'Profissionais de Engenharia, técnicos e alunos de Segurança do Trabalho, profissionais do SESMT e de áreas operacionais.',
  'Conteúdo programático' => 'Introdução à segurança com eletricidade; riscos; técnicas de análise de risco; medidas de controle; NBR-5410, NBR-14039 e outras; regulamentações do MTE; EPC e EPI; rotinas e procedimentos; documentação; riscos adicionais; proteção e combate a incêndios; acidentes de origem elétrica; primeiros socorros; responsabilidades.',
  'Instruções metodológicas' => 'Curso teórico-prático; prática de combate a incêndios; técnicas de análise de vítimas, vias aéreas, RCP e transporte de vítimas.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
