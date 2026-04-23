<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external = true;
$page_title = 'Localização';
$page_description = 'Onde estamos: Setor Comercial Sul, Ed. Jamel Cecílio, Brasília DF.';
include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>

<section class="page-hero">
  <div class="container">
    <nav class="breadcrumb"><a href="index.php">Início</a> &rarr; <span>Localização</span></nav>
    <h1>Venha nos visitar</h1>
    <p class="page-lead">Estamos no centro de Brasília, com acesso fácil por transporte público e estacionamento próximo.</p>
  </div>
</section>

<section class="page-body">
  <div class="container loc-grid">
    <div class="loc-info">
      <h2 style="font-size:1.3rem">Endereço</h2>
      <address>
        <strong>Multicursos &middot; Formação Profissional</strong><br>
        Setor Comercial Sul, Quadra 02, Bloco C<br>
        Ed. Jamel Cecílio &middot; Salas 203 a 205<br>
        Brasília &middot; DF
      </address>
      <ul class="loc-contacts">
        <li><a href="tel:+556132255411">(61) 3225-5411</a></li>
        <li><a href="tel:+556139677270">(61) 3967-7270</a></li>
        <li><a href="mailto:multicursosdf@gmail.com">multicursosdf@gmail.com</a></li>
      </ul>
      <div style="margin-top:1.5rem">
        <a href="img/edificilJamelCecilio.JPG" class="btn btn-ghost" target="_blank" rel="noopener">Ver fachada do edifício</a>
      </div>
      <div style="margin-top:2rem">
        <img src="img/loja-recepcao.jpg" alt="Recepção da Multicursos" loading="lazy" style="border-radius:var(--radius);box-shadow:var(--shadow-md);width:100%">
      </div>
    </div>
    <div class="loc-map">
      <iframe
        title="Mapa da sede da Multicursos em Brasília"
        src="https://www.google.com/maps?q=Ed.+Jamel+Ceci%CC%81lio+Setor+Comercial+Sul+Bras%C3%ADlia&output=embed"
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        allowfullscreen></iframe>
    </div>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
