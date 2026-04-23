<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external = true;
$page_title = 'Agenda de cursos';
$page_description = 'Veja a agenda de todos os cursos da Multicursos DF.';

$cursos_map = [
  'brigadista'     => ['Brigadista (bombeiro)', 'formacao_brigadista'],
  'capacitacao'    => ['Capacitação continuada', 'reciclagem_brigadista'],
  'socorrista'     => ['Socorrista', 'socorrista'],
  'dea'            => ['D.E.A', 'dea'],
  'voluntario'     => ['Brigadista voluntário', 'voluntario'],
  'socorros'       => ['Primeiros socorros', 'primeiros_socorros'],
  'aquatico'       => ['Salvamento aquático', 'salva_vidas'],
  'cipa'           => ['CIPA - NR-05', 'cipa'],
  'protecao'       => ['EPI - NR-06', 'epi'],
  'eletricidade'   => ['NR-10 Eletricidade', 'nr10'],
];

$selected = $_GET['c'] ?? '';
$curso_slug = null;
$curso_titulo = null;
if (isset($cursos_map[$selected])) {
    [$curso_titulo, $curso_slug] = $cursos_map[$selected];
}

include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>

<section class="page-hero">
  <div class="container">
    <nav class="breadcrumb"><a href="index.php">Início</a> &rarr; <span>Agenda</span></nav>
    <h1>Agenda de cursos</h1>
    <p class="page-lead">Escolha um curso para ver as próximas turmas. Não achou a data ideal? Pergunte sobre turma in-company.</p>
  </div>
</section>

<section class="page-body">
  <div class="container">
    <div class="cursos-grid" style="margin-bottom:3rem">
      <?php foreach ($cursos_map as $key => [$nome, $_slug]):
        $is_active = $key === $selected;
      ?>
        <a class="curso-card" href="agenda.php?c=<?= h($key) ?>#agenda-selecionada"
           style="<?= $is_active ? 'border-color:var(--brand);box-shadow:var(--shadow-md)' : '' ?>">
          <h3><?= h($nome) ?></h3>
          <span class="curso-link">Ver turmas &rarr;</span>
        </a>
      <?php endforeach; ?>
    </div>

    <?php if ($curso_slug): ?>
      <div id="agenda-selecionada">
        <h2 style="text-align:center"><?= h($curso_titulo) ?></h2>
        <?php include 'partials/curso_agenda.php'; ?>
      </div>
    <?php else: ?>
      <div class="agenda-empty" style="margin-top:2rem">
        Selecione um curso acima para ver as turmas disponíveis.
      </div>
    <?php endif; ?>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
