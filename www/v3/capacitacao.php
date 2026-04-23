<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external     = true;
$page_title       = 'Capacitação Continuada';
$page_description = 'Reciclagem de brigadistas conforme NT 007/2011 do CBM-DF e NBR 14.276. 75h/aula.';

$curso_nome  = 'Capacitação Continuada';
$curso_slug  = 'reciclagem_brigadista';
$curso_lead  = 'Reciclagem obrigatória para brigadistas já formados. 75h/aula que mantém sua certificação válida e atualiza suas técnicas.';
$curso_blocos = [
  'Objetivo' => 'Elaborado segundo a norma técnica 007/2011 do <strong>CBM-DF</strong> e <strong>NBR 14.276</strong>, estabelece a capacitação de brigadistas a cada 24 meses.',
  'Carga horária' => '75 horas/aula',
  'Público alvo' => 'Brigadistas, socorristas e profissionais com formação em segurança contra incêndio e pânico.',
  'Conteúdo programático' => 'Relações Humanas; legislação de segurança contra incêndio e pânico do DF; Primeiros Socorros; Prevenção e Combate a Incêndios; Salvamento; Abandono de área; Sistemas de segurança contra incêndio e pânico.',
  'Instruções metodológicas' => 'Curso teórico-prático; prática de combate a incêndios; técnicas dos módulos de análise de vítimas, vias aéreas, RCP e transporte de vítimas.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
