<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external = true;
$page_title = 'Quem Somos';
$page_description = 'A Multicursos DF iniciou suas atividades em 2004. Formação de brigadistas, socorristas e profissionais de segurança em Brasília.';
include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>

<section class="page-hero">
  <div class="container">
    <nav class="breadcrumb"><a href="index.php">Início</a> &rarr; <span>Quem somos</span></nav>
    <h1>Quem somos</h1>
    <p class="page-lead">Duas décadas formando profissionais que salvam vidas.</p>
  </div>
</section>

<section class="page-body">
  <div class="container sobre-grid">
    <div class="sobre-text">
      <p>
        A <strong>Multicursos</strong> iniciou suas atividades em <strong>2004</strong> com o objetivo
        de formar e treinar profissionais capacitados para atuar na área de segurança contra incêndio e
        pânico, prevenção e combate a incêndios, e em ações de emergências, além de desenvolver cursos,
        instruções e palestras voltadas para a segurança e prevenção.
      </p>
      <p>
        Nossa empresa atende esses objetivos através de um quadro de funcionários e instrutores altamente
        qualificados, visando fornecer o que há de melhor no mercado de treinamentos técnicos, cursos e
        formação de brigadistas, bombeiros, socorristas, salva-vidas e cursos na área de segurança do trabalho.
      </p>
      <p>
        Possuímos excelentes instalações e materiais didáticos atualizados, além de
        <strong>credenciamento e autorização pelos órgãos ambientais e CBM-DF</strong>,
        possibilitando práticas reais para situações de pânico, sinistro e emergências.
      </p>
      <p>
        Pensando sempre em atender o mercado, a <strong>Multicursos</strong> está sempre inovando e
        atualizando os seus cursos profissionalizantes.
      </p>
      <ul class="sobre-list">
        <li><span aria-hidden="true">&check;</span> Credenciamento CBM-DF</li>
        <li><span aria-hidden="true">&check;</span> Conformidade com NBR 14.276</li>
        <li><span aria-hidden="true">&check;</span> Instrutores com experiência operacional</li>
        <li><span aria-hidden="true">&check;</span> Infraestrutura para práticas reais</li>
      </ul>
    </div>
    <div class="sobre-media">
      <img src="img/fachada1.jpg" alt="Fachada da sede da Multicursos em Brasília" loading="lazy">
    </div>
  </div>

  <div class="container" style="margin-top:3rem">
    <h2 style="text-align:center;margin-bottom:2rem">Nossos cursos</h2>
    <div class="cursos-grid">
      <a class="curso-card" href="brigadista.php"><h3>Brigadista</h3><p>Bombeiro civil, conforme CBM-DF e NBR 14.276</p><span class="curso-link">Ver detalhes &rarr;</span></a>
      <a class="curso-card" href="capacitacao.php"><h3>Capacitação Continuada</h3><p>Reciclagem de brigadistas</p><span class="curso-link">Ver detalhes &rarr;</span></a>
      <a class="curso-card" href="socorrista.php"><h3>Socorrista</h3><p>Atendimento pré-hospitalar avançado</p><span class="curso-link">Ver detalhes &rarr;</span></a>
      <a class="curso-card" href="dea.php"><h3>DEA</h3><p>Desfibrilador externo automático</p><span class="curso-link">Ver detalhes &rarr;</span></a>
      <a class="curso-card" href="voluntario.php"><h3>Brigadista Voluntário</h3><p>Para escolas, condomínios e pequenas empresas</p><span class="curso-link">Ver detalhes &rarr;</span></a>
      <a class="curso-card" href="socorros.php"><h3>Primeiros Socorros</h3><p>Nível básico</p><span class="curso-link">Ver detalhes &rarr;</span></a>
      <a class="curso-card" href="aquatico.php"><h3>Salvamento Aquático</h3><p>Salva-vidas</p><span class="curso-link">Ver detalhes &rarr;</span></a>
      <a class="curso-card" href="cipa.php"><h3>CIPA &middot; NR-05</h3><p>Comissão interna de prevenção de acidentes</p><span class="curso-link">Ver detalhes &rarr;</span></a>
      <a class="curso-card" href="protecao.php"><h3>EPI &middot; NR-06</h3><p>Equipamentos de proteção individual</p><span class="curso-link">Ver detalhes &rarr;</span></a>
      <a class="curso-card" href="eletricidade.php"><h3>NR-10 Eletricidade</h3><p>Segurança em instalações elétricas</p><span class="curso-link">Ver detalhes &rarr;</span></a>
    </div>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
