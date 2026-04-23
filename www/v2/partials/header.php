<?php
// Partial: header + nav.
// Variável opcional:
//   $nav_external - quando true, os links de âncora apontam para "index.php#secao"
$nav_external = !empty($nav_external);
$prefix = $nav_external ? 'index.php' : '';
?>
<header class="header" id="topo">
  <div class="container header-inner">
    <a class="brand" href="index.php" aria-label="Multicursos DF">
      <img src="img/logo.png" alt="Multicursos" class="brand-logo">
      <span class="brand-text">
        <strong>Multicursos</strong>
        <em>Formação Profissional</em>
      </span>
    </a>

    <button class="nav-toggle" id="navToggle" aria-label="Abrir menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>

    <nav class="nav" id="nav">
      <a href="<?= $prefix ?>#cursos">Cursos</a>
      <a href="<?= $prefix ?>#sobre">Sobre</a>
      <a href="<?= $prefix ?>#agenda">Agenda</a>
      <a href="<?= $prefix ?>#localizacao">Localização</a>
      <a href="<?= $prefix ?>#contato">Contato</a>
      <a href="<?= $prefix ?>#contato" class="nav-cta">Matricule-se</a>
      <a href="https://www.multicursosdf.com.br/cms/areaLogin.php" class="nav-admin" rel="nofollow">Área Restrita</a>
    </nav>
  </div>
</header>
