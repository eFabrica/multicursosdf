<?php
require_once(__DIR__ . '/inc/security.php');
include 'partials/head.php';
?>
<body>
<?php include 'partials/header.php'; ?>

<section class="hero">
  <div class="container hero-inner">
    <div class="hero-text">
      <span class="badge">Desde 2004 &middot; Credenciada CBM-DF</span>
      <h1>Formação profissional <span>que salva vidas</span></h1>
      <p class="lead">
        Cursos técnicos em segurança contra incêndio, primeiros socorros e saúde ocupacional,
        ministrados por instrutores qualificados com infraestrutura completa para práticas reais.
      </p>
      <div class="hero-ctas">
        <a href="#cursos" class="btn btn-primary">Conheça os cursos</a>
        <a href="#contato" class="btn btn-ghost">Fale conosco</a>
      </div>
      <ul class="hero-stats">
        <li><strong>20+</strong><span>anos no mercado</span></li>
        <li><strong>10</strong><span>cursos profissionalizantes</span></li>
        <li><strong>CBM-DF</strong><span>credenciamento oficial</span></li>
      </ul>
    </div>
    <div class="hero-art" aria-hidden="true">
      <div class="hero-card hero-card-1">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2c1 4 4 6 4 10a4 4 0 1 1-8 0c0-4 3-6 4-10z"/></svg>
        <span>Brigadista</span>
      </div>
      <div class="hero-card hero-card-2">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11V7a2 2 0 0 0-2-2h-3l-2-2h-2L9 5H6a2 2 0 0 0-2 2v4"/><path d="M2 11h20v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2z"/><path d="M12 15v-3"/><path d="M10.5 13.5h3"/></svg>
        <span>Primeiros Socorros</span>
      </div>
      <div class="hero-card hero-card-3">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M9 12l2 2 4-4"/></svg>
        <span>Certificação</span>
      </div>
    </div>
  </div>
</section>

<section class="section" id="cursos">
  <div class="container">
    <header class="section-head">
      <span class="eyebrow">Catálogo</span>
      <h2>Nossos cursos</h2>
      <p>Formação técnica conforme as normas vigentes (NBR 14.276, NR-05, NR-06, NR-10 e Normas Técnicas do CBM-DF).</p>
    </header>

    <div class="cursos-grid">
      <article class="curso-card">
        <div class="curso-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2c1 4 4 6 4 10a4 4 0 1 1-8 0c0-4 3-6 4-10z"/></svg></div>
        <h3>Brigadista Particular</h3>
        <p>Formação de brigadistas conforme NT nº 007/2011 do CBM-DF e NBR 14.276.</p>
        <dl class="curso-meta"><dt>Carga</dt><dd>151h/aula</dd></dl>
        <a class="curso-link" href="brigadista.php">Ver detalhes &rarr;</a>
      </article>

      <article class="curso-card">
        <div class="curso-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-9-9"/><polyline points="21 3 21 9 15 9"/></svg></div>
        <h3>Capacitação Continuada</h3>
        <p>Reciclagem anual para brigadistas já formados, mantendo a certificação válida.</p>
        <dl class="curso-meta"><dt>Requisito</dt><dd>Brigadista ativo</dd></dl>
        <a class="curso-link" href="capacitacao.php">Ver detalhes &rarr;</a>
      </article>

      <article class="curso-card">
        <div class="curso-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11V7a2 2 0 0 0-2-2h-3l-2-2h-2L9 5H6a2 2 0 0 0-2 2v4"/><path d="M2 11h20v8a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2z"/><path d="M12 15v-3"/><path d="M10.5 13.5h3"/></svg></div>
        <h3>Socorrista</h3>
        <p>Atendimento pré-hospitalar completo, suporte básico de vida e resgate.</p>
        <dl class="curso-meta"><dt>Público</dt><dd>Profissionais da saúde e segurança</dd></dl>
        <a class="curso-link" href="socorrista.php">Ver detalhes &rarr;</a>
      </article>

      <article class="curso-card">
        <div class="curso-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        <h3>DEA</h3>
        <p>Utilização do Desfibrilador Externo Automático em situações de parada cardíaca.</p>
        <dl class="curso-meta"><dt>Modalidade</dt><dd>Teórico + prático</dd></dl>
        <a class="curso-link" href="dea.php">Ver detalhes &rarr;</a>
      </article>

      <article class="curso-card">
        <div class="curso-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        <h3>Brigadista Voluntário</h3>
        <p>Formação de brigadistas voluntários para escolas, condomínios e pequenas empresas.</p>
        <dl class="curso-meta"><dt>Acessível</dt><dd>Sem pré-requisitos</dd></dl>
        <a class="curso-link" href="voluntario.php">Ver detalhes &rarr;</a>
      </article>

      <article class="curso-card">
        <div class="curso-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"/></svg></div>
        <h3>Primeiros Socorros</h3>
        <p>Noções básicas de atendimento emergencial para leigos e profissionais.</p>
        <dl class="curso-meta"><dt>Nível</dt><dd>Básico</dd></dl>
        <a class="curso-link" href="socorros.php">Ver detalhes &rarr;</a>
      </article>

      <article class="curso-card">
        <div class="curso-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><path d="M12 17c.5-3 3-5 6-5"/><path d="M12 17c-.5-3-3-5-6-5"/></svg></div>
        <h3>Salvamento Aquático</h3>
        <p>Formação de salva-vidas para piscinas, clubes, parques aquáticos e áreas de lazer.</p>
        <dl class="curso-meta"><dt>Prática</dt><dd>Em ambiente aquático</dd></dl>
        <a class="curso-link" href="aquatico.php">Ver detalhes &rarr;</a>
      </article>

      <article class="curso-card">
        <div class="curso-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        <h3>CIPA &middot; NR-05</h3>
        <p>Comissão Interna de Prevenção de Acidentes, conforme a Norma Regulamentadora 5.</p>
        <dl class="curso-meta"><dt>Obrigatório</dt><dd>Empresas com 20+ funcionários</dd></dl>
        <a class="curso-link" href="cipa.php">Ver detalhes &rarr;</a>
      </article>

      <article class="curso-card">
        <div class="curso-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <h3>EPI &middot; NR-06</h3>
        <p>Equipamentos de Proteção Individual: uso, manutenção, obrigatoriedade e fiscalização.</p>
        <dl class="curso-meta"><dt>Aplicação</dt><dd>Todos os setores</dd></dl>
        <a class="curso-link" href="protecao.php">Ver detalhes &rarr;</a>
      </article>

      <article class="curso-card">
        <div class="curso-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg></div>
        <h3>NR-10 Eletricidade</h3>
        <p>Segurança em instalações e serviços em eletricidade (nível básico).</p>
        <dl class="curso-meta"><dt>Carga</dt><dd>40h</dd></dl>
        <a class="curso-link" href="eletricidade.php">Ver detalhes &rarr;</a>
      </article>
    </div>
  </div>
</section>

<section class="section section-alt" id="sobre">
  <div class="container sobre-grid">
    <div class="sobre-text">
      <span class="eyebrow">Sobre nós</span>
      <h2>Duas décadas formando quem protege vidas</h2>
      <p>
        A <strong>Multicursos</strong> iniciou suas atividades em <strong>2004</strong> com o objetivo de
        formar e treinar profissionais capacitados para atuar na área de segurança contra incêndio e pânico,
        prevenção e combate a incêndios, e em ações de emergência.
      </p>
      <p>
        Contamos com quadro de instrutores altamente qualificados, excelentes instalações e materiais didáticos
        atualizados, além de <strong>credenciamento e autorização pelos órgãos ambientais e CBM-DF</strong>,
        possibilitando práticas reais para situações de pânico, sinistro e emergências.
      </p>
      <ul class="sobre-list">
        <li><span aria-hidden="true">&check;</span> Credenciamento CBM-DF</li>
        <li><span aria-hidden="true">&check;</span> Conformidade com NBR 14.276</li>
        <li><span aria-hidden="true">&check;</span> Instrutores com experiência operacional</li>
        <li><span aria-hidden="true">&check;</span> Infraestrutura para práticas reais</li>
      </ul>
    </div>
    <div class="sobre-media">
      <img src="img/fachada1.jpg" alt="Fachada da sede da Multicursos no Setor Comercial Sul, Brasília" loading="lazy">
    </div>
  </div>
</section>

<section class="section" id="agenda">
  <div class="container">
    <header class="section-head">
      <span class="eyebrow">Próximas turmas</span>
      <h2>Agenda de cursos</h2>
      <p>Consulte as datas disponíveis e reserve sua vaga. Turmas novas a cada mês.</p>
    </header>
    <div class="agenda-cta">
      <a href="agenda.php" class="btn btn-primary">Ver agenda completa</a>
      <a href="#contato" class="btn btn-ghost">Turma in-company</a>
    </div>
  </div>
</section>

<section class="section section-alt" id="localizacao">
  <div class="container loc-grid">
    <div class="loc-info">
      <span class="eyebrow">Localização</span>
      <h2>Venha nos visitar</h2>
      <address>
        <strong>Multicursos &middot; Formação Profissional</strong><br>
        Setor Comercial Sul, Quadra 02, Bloco C<br>
        Ed. Jamel Cecílio &middot; Salas 203 a 205<br>
        Brasília &middot; DF
      </address>
      <ul class="loc-contacts">
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>
          <a href="tel:+556139677270">(61) 3967-7270</a>
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>
          <a href="tel:+556132255411">(61) 3225-5411</a>
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          <a href="mailto:multicursosdf@gmail.com">multicursosdf@gmail.com</a>
        </li>
      </ul>
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

<section class="section" id="contato">
  <div class="container">
    <header class="section-head">
      <span class="eyebrow">Fale conosco</span>
      <h2>Tire dúvidas ou solicite sua matrícula</h2>
      <p>Preencha o formulário abaixo e nossa equipe retorna em até 1 dia útil.</p>
    </header>

    <form class="form-contato" action="contatoEnvia.php" method="post" novalidate>
      <?= csrf_field() ?>
      <div class="form-row">
        <label>
          <span>Nome completo</span>
          <input type="text" name="nome" maxlength="100" required autocomplete="name">
        </label>
        <label>
          <span>E-mail</span>
          <input type="email" name="email" maxlength="100" required autocomplete="email">
        </label>
      </div>
      <label>
        <span>Assunto</span>
        <input type="text" name="assunto" maxlength="100" required>
      </label>
      <label>
        <span>Mensagem</span>
        <textarea name="mensagem" rows="6" maxlength="5000" required></textarea>
      </label>
      <button type="submit" class="btn btn-primary btn-block">Enviar mensagem</button>
    </form>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
