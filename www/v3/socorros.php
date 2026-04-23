<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external     = true;
$page_title       = 'Primeiros Socorros (Básico)';
$page_description = 'Primeiros socorros em nível básico. 20h/aula. Ideal para leigos e profissionais de diversas áreas.';

$curso_nome  = 'Primeiros Socorros (Básico)';
$curso_slug  = 'primeiros_socorros';
$curso_lead  = 'Noções básicas de atendimento emergencial para leigos e profissionais. 20 horas/aula cobrindo avaliação da cena, RCP, queimaduras e emergências clínicas.';
$curso_blocos = [
  'Objetivo' => 'Capacitar pessoas para prestar um primeiro atendimento a alguém acidentado enquanto as equipes especializadas não chegam, garantindo segurança da vítima e do patrimônio.',
  'Carga horária' => '20 horas/aula',
  'Público alvo' => 'Profissionais da segurança, funcionários de condomínio, babás, secretárias do lar, prestadores de serviços e pessoas interessadas em estar preparadas para emergências.',
  'Conteúdo programático' => 'Suporte básico de vida; responsabilidade legal; corrente da vida; acionamento do serviço de emergência; EPI; biossegurança; avaliação da cena e do acidentado; RCP; posição lateral de segurança; desobstrução de vias aéreas; hemorragias; fraturas; desmaio; emergências clínicas (infarto, AVC, crise convulsiva); queimaduras; choque elétrico; afogamento.',
  'Instruções metodológicas' => 'Curso teórico-prático: avaliação primária; RCP; posição lateral de segurança; manobra de Heimlich.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
