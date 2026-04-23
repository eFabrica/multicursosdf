<?php
// Partial: HEAD da página.
// Variáveis disponíveis (todas opcionais):
//   $page_title       - título dentro da tag <title>
//   $page_description - meta description
$default_title = 'Multicursos DF - Formação Profissional em Brasília';
$default_desc  = 'Multicursos DF - Formação profissional em brigadista, socorrista, CIPA, DEA, EPI, NR-10, salvamento aquático e primeiros socorros. Desde 2004 em Brasília.';
$t = isset($page_title) && $page_title !== '' ? ($page_title . ' | Multicursos DF') : $default_title;
$d = isset($page_description) && $page_description !== '' ? $page_description : $default_desc;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?= h($d) ?>">
<title><?= h($t) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/styles.css?v=<?= @filemtime(__DIR__ . '/../assets/styles.css') ?: time() ?>">
</head>
