<?php
require_once(__DIR__ . '/inc/security.php');
$page_title = 'Multicursos DF - Bombeiro Civil em 1 mês | Formação Profissional';
$page_description = 'Há 20 anos o curso de Bombeiro Civil com o diploma mais respeitado do DF. Credenciada CBMDF (CRD EMP-F/107-06). 12× sem juros. Matricule-se pelo WhatsApp.';
include 'partials/head.php';
?>
<body>
<?php include 'partials/header.php'; ?>

<!-- 1. HERO — "Há 20 anos o curso de Bombeiro Civil com o diploma mais respeitado do DF" -->
<section class="hero hero-v3">
  <video class="hero-bg-video" autoplay muted loop playsinline preload="metadata" disablepictureinpicture poster="fotos/Cursos/foto7.jpg" aria-hidden="true">
    <source src="assets/video/hero-bg.mp4" type="video/mp4">
  </video>
  <div class="container hero-inner">
    <div class="hero-text">
      <span class="badge">Credenciada CBMDF &middot; CRD EMP-F/107-06</span>
      <h1>Há 20 anos o curso de <span>Bombeiro Civil</span> com o diploma mais respeitado do DF</h1>
      <p class="lead">
        Aqui você <strong>APRENDE E PRATICA de verdade!</strong>
        Há mais de 20 anos formando os bombeiros civis mais desejados pelos empregadores no DF.
      </p>
      <div class="hero-ctas">
        <a href="https://wa.me/message/NJRITG3XTPCUD1" target="_blank" rel="noopener" class="btn btn-primary">
          Matricule-se agora
        </a>
        <a href="#oferta" class="btn btn-ghost">Conheça a formação</a>
      </div>
      <ul class="hero-stats">
        <li><strong>20+ anos</strong><span>formando no DF</span></li>
        <li><strong>100%</strong><span>presencial em Brasília</span></li>
        <li><strong>CBMDF</strong><span>credenciamento oficial</span></li>
      </ul>
    </div>
  </div>
</section>

<!-- 2. OFERTA PRINCIPAL — "Bombeiro Civil em 1 MÊS" -->
<section class="oferta-main" id="oferta">
  <div class="container oferta-grid">
    <div class="oferta-text">
      <span class="eyebrow-light">Por que Multicursos?</span>
      <h2>Conquiste sua certificação de <br><span class="destaque">Bombeiro Civil</span> em <span class="destaque">1 mês</span> e conquiste seu novo emprego!</h2>
      <div class="oferta-badge-presencial">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        100% Presencial em Brasília
      </div>
      <ul class="beneficios-list">
        <li>Mais de 20 anos e diploma respeitado no mercado</li>
        <li>Instrutores qualificados e experientes</li>
        <li>Centro de treinamento próprio e bem equipado</li>
        <li>Dividimos em até <strong>12× sem juros</strong> no cartão</li>
        <li>Parcelas de <strong>menos de R$ 50,00</strong></li>
        <li>Ótima localização e muito mais</li>
      </ul>
      <div class="oferta-ctas">
        <a href="https://wa.me/message/NJRITG3XTPCUD1" target="_blank" rel="noopener" class="btn-white">
          Clique e matricule-se
        </a>
        <a href="#contato" class="btn-outline-white">Fale com a equipe</a>
      </div>
    </div>
    <div class="oferta-media">
      <img src="fotos/Cursos/foto7.jpg" alt="Bombeiro Civil em treinamento real de combate a incêndio" loading="lazy">
      <span class="media-badge">🔥 Treinamento real com fogo</span>
    </div>
  </div>
</section>

<!-- 3. FAIXA SALARIAL — impacto emocional -->
<section class="salario-banner">
  <div class="container">
    <h2>Os salários de um Bombeiro Civil no DF hoje variam de</h2>
    <span class="destaque-grande">R$ 3.238 – R$ 5.500</span>
    <p>A profissão de <strong>BOMBEIRO CIVIL</strong> é uma das que mais abre novas vagas no Brasil! Cada vez mais as empresas e a sociedade vêm percebendo a importância da profissão e criando mais vagas.</p>
  </div>
</section>

<!-- 4. MOMENTOS REAIS — galeria mosaico -->
<section class="section" id="momentos">
  <div class="container">
    <header class="section-head">
      <span class="eyebrow">Veja na prática</span>
      <h2>Nossos alunos em ação</h2>
      <p>Imagens reais dos treinamentos. Fogo, prática e equipamentos reais &mdash; o que você vai aprender aqui.</p>
    </header>
    <div class="momentos-grid">
      <a href="fotos/Cursos/foto7.jpg" class="momento momento-1" data-label="Combate a incêndio com jato d'água" target="_blank"><img src="fotos/Cursos/foto7.jpg" alt="Combate a incêndio" loading="lazy"></a>
      <a href="fotos/Cursos/foto9.jpg" class="momento momento-2" data-label="Prática com extintor" target="_blank"><img src="fotos/Cursos/foto9.jpg" alt="Extintor" loading="lazy"></a>
      <a href="fotos/Cursos/foto5.jpg" class="momento momento-3" data-label="Equipamento de combate" target="_blank"><img src="fotos/Cursos/foto5.jpg" alt="Equipamento" loading="lazy"></a>
      <a href="fotos/Brigada/foto1.JPG" class="momento momento-4" data-label="Aula prática de primeiros socorros" target="_blank"><img src="fotos/Brigada/foto1.JPG" alt="Primeiros socorros" loading="lazy"></a>
      <a href="fotos/Socorrista/foto1.jpg" class="momento momento-5" data-label="RCP com EPI" target="_blank"><img src="fotos/Socorrista/foto1.jpg" alt="RCP" loading="lazy"></a>
      <a href="fotos/Dea/dea1.jpg" class="momento momento-6" data-label="Treinamento DEA" target="_blank"><img src="fotos/Dea/dea1.jpg" alt="DEA" loading="lazy"></a>
      <a href="fotos/Brigada/brig_vonluntario1.jpg" class="momento momento-7" data-label="Sala de aula" target="_blank"><img src="fotos/Brigada/brig_vonluntario1.jpg" alt="Aula" loading="lazy"></a>
      <a href="fotos/Brigada/foto2.JPG" class="momento momento-8" data-label="Turma em treinamento" target="_blank"><img src="fotos/Brigada/foto2.JPG" alt="Turma" loading="lazy"></a>
    </div>
    <p class="clientes-note" style="margin-top:2rem"><a href="fotos.php">Ver galeria completa &rarr;</a></p>
  </div>
</section>

<!-- 5. ÁREAS DE ATUAÇÃO — 4 nichos -->
<section class="section section-alt" id="areas">
  <div class="container">
    <header class="section-head">
      <span class="eyebrow">Onde nossos alunos atuam</span>
      <h2>Grandes eventos e oportunidades no DF</h2>
      <p>Formamos profissionais que atuam em eventos esportivos, musicais, corporativos e políticos.</p>
    </header>

    <div class="areas-grid">
      <div class="area-card area-esportivos">
        <h3>Eventos esportivos</h3>
        <p>Copa do Mundo de Futebol Feminino, Jogos de Futebol, Corridas de rua e muito mais.</p>
      </div>
      <div class="area-card area-musicais">
        <h3>Eventos musicais</h3>
        <p>Grandes eventos de música, shows internacionais e a cena cultural da Capital Federal cada vez maior.</p>
      </div>
      <div class="area-card area-politicos">
        <h3>Atividades políticas</h3>
        <p>Convenções partidárias, encontros de classes, campanhas eleitorais e vários outros.</p>
      </div>
      <div class="area-card area-empresas">
        <h3>Conscientização empresarial</h3>
        <p>Brigadas internas, equipes de resgate e treinamentos customizados para grupos conforme a necessidade.</p>
      </div>
    </div>
  </div>
</section>

<!-- 6. DEPOIMENTOS — com textos completos do Canva -->
<section class="section" id="depoimentos">
  <div class="container">
    <header class="section-head">
      <span class="eyebrow">Depoimentos</span>
      <h2>O que estão falando sobre a Multicursos</h2>
      <p>Histórias reais de quem saiu daqui pronto para o mercado.</p>
    </header>

    <div class="depoimentos-grid">
      <article class="depoimento-card">
        <blockquote>
          Passando para agradecer todo o conhecimento a mim passado por vocês da Multicursos.
          Em especial aos professores <strong>Renan, Roney e Josino</strong>. Com menos de 2 meses de formado
          já estou contratado e atuando na área. Meu muito obrigado a vocês!
        </blockquote>
        <cite>
          <span class="avatar">DS</span>
          <span class="depoimento-meta">
            <span class="nome">Daniel C. Silva</span>
            <span class="cargo">Bombeiro Civil &middot; formado na Multicursos</span>
          </span>
        </cite>
      </article>

      <article class="depoimento-card">
        <blockquote>
          Professores nota 10! Vou levar os ensinamentos pra vida com certeza, sou muito grata
          a todos os instrutores por tanta dedicação. Com certeza uma das melhores escolas de
          curso de Brigadista, dia do campo de treinamento vai ficar pra sempre na minha memória,
          por tantos desafios superados. Indico muito!
        </blockquote>
        <cite>
          <span class="avatar avatar-blue">AP</span>
          <span class="depoimento-meta">
            <span class="nome">Aluna Multicursos</span>
            <span class="cargo">Formada em Brigadista</span>
          </span>
        </cite>
      </article>

      <article class="depoimento-card">
        <blockquote>
          Na Multicursos eu encontrei muito mais do que um curso. Me surpreendi com a estrutura,
          os equipamentos e os treinamentos que parecem situações reais de emergência. Resolvi
          mudar de profissão e posso dizer que me redescobri como profissional.
        </blockquote>
        <cite>
          <span class="avatar avatar-green">EA</span>
          <span class="depoimento-meta">
            <span class="nome">Ex-aluno Multicursos</span>
            <span class="cargo">Bombeiro Civil &middot; nova carreira</span>
          </span>
        </cite>
      </article>
    </div>
  </div>
</section>

<!-- 7. CLIQUE E VEJA — CTA estilo Canva -->
<section class="clique-cta">
  <div class="container">
    <h2><span class="strong-orange">CLIQUE</span> e veja como é fácil ter a sua certificação!</h2>
    <a href="https://wa.me/message/NJRITG3XTPCUD1" target="_blank" rel="noopener" class="btn btn-primary" style="padding:1.1rem 2.2rem;font-size:1.05rem;border-radius:999px">
      Falar no WhatsApp agora
    </a>
  </div>
</section>

<!-- 8. OUTROS CURSOS — catálogo com fotos reais -->
<section class="section section-alt" id="cursos">
  <div class="container">
    <header class="section-head">
      <span class="eyebrow">Catálogo</span>
      <h2>Outros cursos que você encontra na Multicursos</h2>
      <p>Segurança, qualidade e experiência em cada detalhe.</p>
    </header>

    <div class="cursos-grid">
      <article class="curso-card curso-card-v3">
        <img src="fotos/Brigada/brig_vonluntario1.jpg" alt="Capacitação continuada" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>Capacitação Continuada (Reciclagem)</h3>
          <p>A cada 2 anos, o Brigadista precisa fazer o curso de atualização para seguir na profissão. Exigência da NT 007/2011 do CBMDF e NBR 14.276.</p>
          <dl class="curso-meta"><dt>Validade</dt><dd>2 anos</dd></dl>
          <a class="curso-link" href="capacitacao.php">Ver detalhes &rarr;</a>
        </div>
      </article>

      <article class="curso-card curso-card-v3">
        <img src="fotos/Brigada/foto1.JPG" alt="Brigadista voluntário" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>Brigadista Voluntário</h3>
          <p>A Brigada Voluntária é formada por colaboradores treinados para agir em emergências como incêndios e evacuações. Exigida pela NR 23 e NT 007/2011 do CBMDF &mdash; obrigatória em empresas com mais de 20 funcionários.</p>
          <dl class="curso-meta"><dt>Obrigatório</dt><dd>NR 23</dd></dl>
          <a class="curso-link" href="voluntario.php">Ver detalhes &rarr;</a>
        </div>
      </article>

      <article class="curso-card curso-card-v3" style="border-color:var(--brand);box-shadow:var(--shadow-md)">
        <img src="fotos/Cursos/foto5.jpg" alt="Combo NR33 NR35" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>COMBO NR-33 + NR-35 <span style="background:var(--brand);color:#fff;padding:.1rem .5rem;border-radius:999px;font-size:.7rem;font-weight:700;margin-left:.3rem;vertical-align:middle">NOVO</span></h3>
          <p>As normas NR-33 e NR-35 definem regras para trabalho em espaço confinado e em altura. São exigidas para quem atua com resgate, socorro, manutenção e segurança &mdash; brigadistas, socorristas, eletricistas e bombeiros.</p>
          <dl class="curso-meta"><dt>Público</dt><dd>Brigadistas, eletricistas</dd></dl>
          <a class="curso-link" href="#contato">Peça informações &rarr;</a>
        </div>
      </article>

      <article class="curso-card curso-card-v3">
        <img src="fotos/Dea/dea1.jpg" alt="Curso do DEA" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>Curso do DEA (Desfibrilador)</h3>
          <p>O curso de DEA capacita para o uso do desfibrilador em emergências. O equipamento é portátil e pode ser usado por qualquer pessoa treinada, aumentando as chances de sobrevivência em casos de parada cardíaca.</p>
          <dl class="curso-meta"><dt>Carga</dt><dd>20h/aula</dd></dl>
          <a class="curso-link" href="dea.php">Ver detalhes &rarr;</a>
        </div>
      </article>

      <article class="curso-card curso-card-v3">
        <img src="fotos/Socorrista/foto1.jpg" alt="Socorrista" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>Socorrista</h3>
          <p>Atendimento pré-hospitalar completo, suporte básico de vida e técnicas de resgate. Nível avançado de primeiros socorros.</p>
          <dl class="curso-meta"><dt>Carga</dt><dd>40h/aula</dd></dl>
          <a class="curso-link" href="socorrista.php">Ver detalhes &rarr;</a>
        </div>
      </article>

      <article class="curso-card curso-card-v3">
        <img src="fotos/Brigada/brig_vonluntario2.jpg" alt="Conscientização empresarial" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>Conscientização Empresarial</h3>
          <p>Programa sob medida para empresas: brigada de incêndio, primeiros socorros e cultura de segurança. Também montamos turmas específicas para grupos conforme a necessidade.</p>
          <dl class="curso-meta"><dt>Formato</dt><dd>In-company</dd></dl>
          <a class="curso-link" href="#contato">Peça uma proposta &rarr;</a>
        </div>
      </article>

      <article class="curso-card curso-card-v3">
        <img src="fotos/Socorrista/foto5.jpg" alt="Primeiros socorros" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>Primeiros Socorros (Básico)</h3>
          <p>Noções básicas de atendimento emergencial para leigos e profissionais de diversas áreas.</p>
          <dl class="curso-meta"><dt>Carga</dt><dd>20h/aula</dd></dl>
          <a class="curso-link" href="socorros.php">Ver detalhes &rarr;</a>
        </div>
      </article>

      <article class="curso-card curso-card-v3">
        <img src="fotos/Cursos/foto1.jpg" alt="Salvamento aquático" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>Salvamento Aquático</h3>
          <p>Formação de salva-vidas para piscinas, clubes, parques aquáticos e áreas de lazer.</p>
          <dl class="curso-meta"><dt>Carga</dt><dd>40h/aula</dd></dl>
          <a class="curso-link" href="aquatico.php">Ver detalhes &rarr;</a>
        </div>
      </article>

      <article class="curso-card curso-card-v3">
        <img src="fotos/Brigada/foto3.JPG" alt="CIPA" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>CIPA &middot; NR-05</h3>
          <p>Comissão Interna de Prevenção de Acidentes, conforme a Norma Regulamentadora 5.</p>
          <dl class="curso-meta"><dt>Carga</dt><dd>20h/aula</dd></dl>
          <a class="curso-link" href="cipa.php">Ver detalhes &rarr;</a>
        </div>
      </article>

      <article class="curso-card curso-card-v3">
        <img src="fotos/Brigada/foto4.JPG" alt="EPI" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>EPI &middot; NR-06</h3>
          <p>Equipamentos de Proteção Individual: uso, manutenção, obrigatoriedade e fiscalização.</p>
          <dl class="curso-meta"><dt>Carga</dt><dd>4h/aula</dd></dl>
          <a class="curso-link" href="protecao.php">Ver detalhes &rarr;</a>
        </div>
      </article>

      <article class="curso-card curso-card-v3">
        <img src="fotos/Brigada/foto6.JPG" alt="NR-10 Eletricidade" class="curso-foto" loading="lazy">
        <div class="curso-body">
          <h3>NR-10 Eletricidade</h3>
          <p>Segurança em instalações e serviços em eletricidade (nível básico).</p>
          <dl class="curso-meta"><dt>Carga</dt><dd>40h/aula</dd></dl>
          <a class="curso-link" href="eletricidade.php">Ver detalhes &rarr;</a>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- 9. CLIENTES — logos reais (extraídos da demanda6) -->
<section class="section" id="clientes">
  <div class="container">
    <header class="section-head">
      <span class="eyebrow">Clientes e parceiros</span>
      <h2>Alguns de <strong>NOSSOS CLIENTES</strong></h2>
      <p>Empresas que nos escolhem para cursos de Reciclagem e cursos Complementares.</p>
    </header>

    <div class="clientes-grid-v3">
      <div class="cliente-logo-card" title="Pier 21"><img src="img/clientes/pier21.png" alt="Pier 21" loading="lazy"></div>
      <div class="cliente-logo-card" title="Terraço Shopping"><img src="img/clientes/terraco.png" alt="Terraço Shopping" loading="lazy"></div>
      <div class="cliente-logo-card" title="SegurPro"><img src="img/clientes/segurpro.png" alt="SegurPro" loading="lazy"></div>
      <div class="cliente-logo-card" title="Unieuro"><img src="img/clientes/unieuro.png" alt="Unieuro" loading="lazy"></div>
      <div class="cliente-logo-card" title="La Salle"><img src="img/clientes/lasalle.png" alt="La Salle" loading="lazy"></div>
      <div class="cliente-logo-card" title="Brasília Shopping"><img src="img/clientes/brasilia.png" alt="Brasília Shopping" loading="lazy"></div>
      <div class="cliente-logo-card" title="Grupo Sefix"><img src="img/clientes/sefix.png" alt="Grupo Sefix" loading="lazy"></div>
      <div class="cliente-logo-card" title="Confederal"><img src="img/clientes/confederal.png" alt="Confederal" loading="lazy"></div>
      <div class="cliente-logo-card" title="Paulo Octavio"><img src="img/clientes/paulooctavio.png" alt="Paulo Octavio" loading="lazy"></div>
      <div class="cliente-logo-card" title="JK Shopping"><img src="img/clientes/jk.png" alt="JK Shopping" loading="lazy"></div>
      <div class="cliente-logo-card" title="Esparta"><img src="img/clientes/esparta.png" alt="Esparta" loading="lazy"></div>
      <div class="cliente-logo-card" title="Grupo Ágil"><img src="img/clientes/agil.png" alt="Grupo Ágil" loading="lazy"></div>
    </div>
    <p class="clientes-note" style="margin-top:2rem">E dezenas de outras empresas do DF que confiam em nossa formação. <a href="#contato">Quer ver a sua aqui? Peça uma proposta</a>.</p>
  </div>
</section>

<!-- 10. SOBRE + CREDENCIAMENTO -->
<section class="section section-alt sobre-v3" id="sobre-multicursos">
  <div class="container sobre-grid">
    <div class="sobre-text">
      <span class="eyebrow">Sobre nós</span>
      <h2>Há mais de 20 anos formando quem protege vidas</h2>
      <p>
        A <strong>Multicursos</strong> iniciou suas atividades em <strong>2004</strong> com o objetivo de
        formar e treinar profissionais capacitados para atuar na área de segurança contra incêndio e pânico,
        prevenção e combate a incêndios, e em ações de emergência.
      </p>
      <p style="padding:1rem 1.25rem;background:var(--brand-soft);border-left:4px solid var(--brand);border-radius:var(--radius-sm);font-weight:600;color:var(--brand-dark)">
        🏅 Credenciamento no CBMDF sob o nº <strong>CRD EMP-F/107-06</strong>
      </p>
      <ul class="sobre-list">
        <li><span aria-hidden="true">&check;</span> Conformidade com NBR 14.276 e NT 007/2011</li>
        <li><span aria-hidden="true">&check;</span> Instrutores com experiência operacional</li>
        <li><span aria-hidden="true">&check;</span> Infraestrutura para práticas reais</li>
        <li><span aria-hidden="true">&check;</span> Turmas matutinas e noturnas iniciando em breve</li>
        <li><span aria-hidden="true">&check;</span> Turmas específicas para grupos conforme a necessidade</li>
      </ul>
    </div>
    <div class="sobre-media">
      <img src="fotos/Cursos/foto9.jpg" alt="Instrutor da Multicursos com extintor em treinamento real" loading="lazy">
    </div>
  </div>
</section>

<!-- 11. CTA WHATSAPP — "Converse com a nossa equipe" -->
<section class="cta-whatsapp">
  <div class="container">
    <h2>Mude sua vida com um clique!</h2>
    <p>Faça sua matrícula agora e ganhe um <strong>desconto especial</strong>. Converse com a nossa equipe direto no WhatsApp.</p>
    <a href="https://wa.me/message/NJRITG3XTPCUD1" target="_blank" rel="noopener" class="btn-wa-big">
      <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
      (61) 98131-6969
    </a>
  </div>
</section>

<!-- 12. LOCALIZAÇÃO + INFORMAÇÕES -->
<section class="section" id="localizacao">
  <div class="container loc-grid">
    <div class="loc-info">
      <span class="eyebrow">Informações e matrículas</span>
      <h2>Estamos no Setor Comercial Sul</h2>
      <address>
        <strong>Multicursos &middot; Formação Profissional</strong><br>
        SCS Qd. 02 Bl. C &middot; Ed. Jamel Cecílio<br>
        Salas 203 a 205 &middot; Brasília &middot; DF
      </address>
      <ul class="loc-contacts">
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.37 1.9.72 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.35 1.85.59 2.81.72A2 2 0 0 1 22 16.92z"/></svg>
          <a href="tel:+556139677270"><strong>Fone:</strong> (61) 3967-7270</a>
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
          <a href="https://wa.me/message/NJRITG3XTPCUD1" target="_blank" rel="noopener"><strong>WhatsApp:</strong> (61) 98131-6969</a>
        </li>
        <li>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
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

<!-- 13. CONTATO -->
<section class="section section-alt" id="contato">
  <div class="container">
    <header class="section-head">
      <span class="eyebrow">Fale conosco</span>
      <h2>Converse com a nossa equipe</h2>
      <p>Preencha o formulário ou fale direto no WhatsApp (61) 98131-6969.</p>
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
        <input type="text" name="assunto" maxlength="100" required placeholder="Ex: Matrícula no curso de Bombeiro Civil">
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
