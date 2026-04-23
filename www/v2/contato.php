<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external = true;
$page_title = 'Contato';
$page_description = 'Fale com a Multicursos DF. Setor Comercial Sul, Brasília. (61) 3967-7270.';
include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>

<section class="page-hero">
  <div class="container">
    <nav class="breadcrumb"><a href="index.php">Início</a> &rarr; <span>Contato</span></nav>
    <h1>Fale conosco</h1>
    <p class="page-lead">Tire dúvidas, solicite sua matrícula ou peça turma in-company. Respondemos em até 1 dia útil.</p>
  </div>
</section>

<section class="page-body">
  <div class="container loc-grid">
    <div class="loc-info">
      <h2 style="font-size:1.3rem">Canais diretos</h2>
      <address>
        <strong>Multicursos &middot; Formação Profissional</strong><br>
        Setor Comercial Sul, Quadra 02, Bloco C<br>
        Ed. Jamel Cecílio &middot; Salas 203 a 205<br>
        Brasília &middot; DF
      </address>
      <ul class="loc-contacts">
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>
          <a href="tel:+556139677270">(61) 3967-7270</a>
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>
          <a href="tel:+556132255411">(61) 3225-5411</a>
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          <a href="mailto:multicursosdf@gmail.com">multicursosdf@gmail.com</a>
        </li>
      </ul>
    </div>

    <form class="form-contato" action="contatoEnvia.php" method="post" novalidate>
      <?= csrf_field() ?>
      <div class="form-row">
        <label><span>Nome completo</span><input type="text" name="nome" maxlength="100" required autocomplete="name"></label>
        <label><span>E-mail</span><input type="email" name="email" maxlength="100" required autocomplete="email"></label>
      </div>
      <label><span>Assunto</span><input type="text" name="assunto" maxlength="100" required></label>
      <label><span>Mensagem</span><textarea name="mensagem" rows="7" maxlength="5000" required></textarea></label>
      <button type="submit" class="btn btn-primary btn-block">Enviar mensagem</button>
    </form>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
