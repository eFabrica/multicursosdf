<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external     = true;
$page_title       = 'DEA - Desfibrilador Externo Automático';
$page_description = 'Ressuscitação Cardiopulmonar e uso do DEA. 20h/aula, teórico e prático.';

$curso_nome  = 'DEA - Desfibrilador Externo Automático';
$curso_slug  = 'dea';
$curso_lead  = 'Capacitação no manuseio do Desfibrilador Externo Automático (DEA) e manobras de RCP. Metodologia em 2 módulos (teórico e prático), 20h/aula.';
$curso_blocos = [
  'Objetivo' => 'Treinar e capacitar o aluno para atuar com um DEA em estabelecimentos. Ideal para brigadistas, bombeiros civis e profissionais de segurança. Inclui apostila de RCP + DEA.',
  'Carga horária' => '20 horas/aula',
  'Público alvo' => 'Bombeiros civis, brigadistas, socorristas, profissionais com formação em segurança e qualquer interessado.',
  'Conteúdo programático' => '<strong>Módulo teórico:</strong> cadeia de sobrevivência; anatomia e fisiologia; PCR e RCP; DEA; RCP em adultos, crianças e lactentes; uso do DEA em situações especiais. <strong>Módulo prático:</strong> simulações reais com manequim e equipamento DEA.',
  'Instruções metodológicas' => 'Curso teórico e prático em sala com simulações supervisionadas.',
];

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/curso_template.php'; ?>
<?php include 'partials/footer.php'; ?>
