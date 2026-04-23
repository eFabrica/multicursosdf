<?php
// Template de página de curso. Espera as variáveis:
//   $curso_nome       - ex.: 'Brigadista Particular'
//   $curso_slug       - slug na tabela agenda
//   $curso_lead       - texto descritivo curto
//   $curso_blocos     - array associativo de [título => conteúdo HTML]
?>
<section class="page-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Trilha de navegação">
      <a href="index.php">Início</a> &rarr;
      <a href="index.php#cursos">Cursos</a> &rarr;
      <span><?= h($curso_nome) ?></span>
    </nav>
    <h1><?= h($curso_nome) ?></h1>
    <?php if (!empty($curso_lead)): ?>
      <p class="page-lead"><?= $curso_lead ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="page-body">
  <div class="container">
    <dl class="curso-detail">
      <?php foreach ($curso_blocos as $titulo => $html):
        $isLong = (stripos($titulo, 'Conteúdo') === 0) || (stripos($titulo, 'Instruções') === 0) || (stripos($titulo, 'Instrucoes') === 0);
      ?>
        <div class="curso-bloco<?= $isLong ? ' full' : '' ?>">
          <dt><?= h($titulo) ?></dt>
          <dd><?= $html ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>

    <div class="agenda-cta" style="margin-top:3rem">
      <a href="index.php#contato" class="btn btn-primary">Quero me matricular</a>
      <a href="index.php#cursos" class="btn btn-ghost">Ver outros cursos</a>
    </div>
  </div>
</section>
