<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external     = true;
$page_title       = 'Socorrista';
$page_description = 'Atendimento pré-hospitalar, suporte básico de vida e resgate. 40h/aula.';

$curso_nome  = 'Socorrista';
$curso_slug  = 'socorrista';
$curso_lead  = 'Atendimento pré-hospitalar completo, suporte básico de vida e técnicas de resgate, com 40 horas/aula em nível avançado de primeiros socorros.';
$curso_blocos = [
  'Objetivo' => 'Capacitar pessoas para prestar um primeiro atendimento a alguém acidentado enquanto as equipes especializadas não chegam, garantindo a própria segurança, das vítimas e do patrimônio.',
  'Carga horária' => '40 horas/aula (nível mais elevado de primeiros socorros)',
  'Público alvo' => 'Brigadistas, Bombeiros Civis, profissionais da área de segurança, funcionários de condomínio, prestadores de serviços e pessoas interessadas em estar preparadas para emergências.',
  'Conteúdo programático' => 'Atribuições e responsabilidades do socorrista; avaliação do paciente; suporte básico de vida; hemorragias e choques; ferimentos; trauma em extremidades; lesões de crânio, coluna e tórax; queimaduras; intoxicações; emergências clínicas; parto; manipulação e transporte de acidentados.',
  'Instruções metodológicas' => 'Curso teórico-prático. Avaliação primária; RCP; posição lateral de segurança; desobstrução de vias aéreas (manobra de Heimlich); manipulação e transporte de acidentados.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
