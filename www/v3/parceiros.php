<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external = true;
$page_title = 'Parceiros';
$page_description = 'Empresas parceiras da Multicursos DF.';
include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>

<section class="page-hero">
  <div class="container">
    <nav class="breadcrumb"><a href="index.php">Início</a> &rarr; <span>Parceiros</span></nav>
    <h1>Nossos parceiros</h1>
    <p class="page-lead">Empresas que confiam na Multicursos para capacitar suas equipes.</p>
  </div>
</section>

<section class="page-body">
  <div class="container">
    <div class="parceiros-grid">
      <a href="http://www.deltafoxseguros.com.br" target="_blank" rel="noopener" title="Delta Fox Seguros">
        <img src="img/logo_deltafox.jpg" alt="Delta Fox Seguros" loading="lazy">
      </a>
      <a href="http://www.academiaatlas.com.br" target="_blank" rel="noopener" title="Academia Atlas">
        <img src="img/logo_atlas.jpg" alt="Academia Atlas" loading="lazy">
      </a>
      <a href="http://www.samuraitreinamentos.com.br" target="_blank" rel="noopener" title="Samurai Treinamentos">
        <img src="img/logo_samurai.jpg" alt="Samurai Treinamentos" loading="lazy">
      </a>
    </div>

    <div style="margin-top:3rem;text-align:center">
      <h2 style="font-size:1.4rem">Quer ser nosso parceiro?</h2>
      <p>Oferecemos descontos progressivos para empresas que treinam equipes recorrentemente.</p>
      <a href="contato.php" class="btn btn-primary">Fale com a gente</a>
    </div>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
