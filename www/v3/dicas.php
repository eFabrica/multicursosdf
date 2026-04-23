<?php
require_once(__DIR__ . '/inc/security.php');
$nav_external = true;
$page_title = 'Dicas de Segurança';
$page_description = 'Dicas de segurança da Multicursos e do Corpo de Bombeiros: incêndio, choque elétrico, crianças, envenenamento, florestal, lixo e praia.';
include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php'; ?>

<section class="page-hero">
  <div class="container">
    <nav class="breadcrumb"><a href="index.php">Início</a> &rarr; <span>Dicas</span></nav>
    <h1>Dicas de segurança</h1>
    <p class="page-lead">Saber como agir em emergências é importante — mas mais importante ainda é saber como evitá-las. Orientações da Multicursos e do Corpo de Bombeiros.</p>
  </div>
</section>

<section class="page-body">
  <div class="container">
    <div class="dicas-list">

    <details class="dica-detail" id="incendio-residencial">
      <summary>
        <span class="dica-titulo">Incêndio residencial</span>
        <span class="dica-resumo">GLP, cigarros, ferro elétrico e aparelhos sem supervisão.</span>
      </summary>
      <div class="dica-corpo">
<h4>GLP — gás de cozinha</h4>
<ul>
  <li>Ao sentir cheiro de gás, <strong>não acenda</strong> as luzes.</li>
  <li>Abra imediatamente todas as portas e janelas para ventilar o ambiente.</li>
  <li>Procure o local de vazamento passando espuma de sabão. <strong>Nunca</strong> procure vazamentos com um fósforo.</li>
</ul>
<h4>Pontas de cigarros</h4>
<p>Não jogue pontas de cigarros ou fósforos no assoalho, cestos de papéis, jardins ou pela janela. Evite fumar na cama, principalmente se estiver sonolento.</p>
<h4>Ferro elétrico</h4>
<p>Sempre desligue o ferro ao afastar-se do local onde estiver passando roupas. Jamais deixe com a base ainda quente sobre tecidos.</p>
<h4>Aparelhos elétricos</h4>
<p>Ao sair de casa, desligue os aparelhos elétricos. Se for viajar, tire-os da tomada.</p>
      </div>
    </details>

    <details class="dica-detail" id="choque-eletrico">
      <summary>
        <span class="dica-titulo">Choque elétrico</span>
        <span class="dica-resumo">Um choque elétrico pode matar. Saiba como evitar.</span>
      </summary>
      <div class="dica-corpo">
<ol>
  <li>Nunca mexa na parte interna das tomadas, seja com os dedos ou com objetos.</li>
  <li>Nunca deixe crianças brincarem com tomadas. Use protetores.</li>
  <li>Ao trocar lâmpadas, toque somente na parte de porcelana ou plástico. Desligue a chave geral antes.</li>
  <li>Nunca toque em aparelhos elétricos com as mãos ou corpo úmidos.</li>
  <li>Não mude a chave de temperatura do chuveiro com o corpo molhado e o chuveiro ligado.</li>
  <li>Mantenha aparelhos elétricos em bom estado. Procure oficina especializada para reparos.</li>
  <li>Verifique fios à vista. Nunca deixe fio descoberto.</li>
  <li>Instale fio terra em chuveiros.</li>
  <li>Cuidado ao manusear objetos metálicos próximos a cabos elétricos aéreos.</li>
  <li>Nunca pise em fios caídos no chão, principalmente após tempestades.</li>
  <li>Não sobrecarregue a rede elétrica. Evite T (benjamim) em tomadas.</li>
  <li>Revise a rede elétrica ao menos uma vez por ano.</li>
  <li>Não deixe crianças empinar pipas próximo a cabos elétricos.</li>
</ol>
      </div>
    </details>

    <details class="dica-detail" id="criancas">
      <summary>
        <span class="dica-titulo">Crianças</span>
        <span class="dica-resumo">Crianças não têm noção de perigo. Você precisa proteger.</span>
      </summary>
      <div class="dica-corpo">
<h4>Atropelamento</h4>
<p>Todo cuidado é pouco quando a criança está brincando com bola. Ensine-a a olhar para os dois lados antes de atravessar.</p>
<h4>Queda</h4>
<p>Jamais deixe bebês desacompanhados sobre móveis, cama ou sofá. Só berço e cercado são seguros. Escadas cercadas e portas travadas.</p>
<h4>Automóvel</h4>
<p>Use sempre a cadeirinha apropriada para idade e peso. Nunca deixe a criança no banco dianteiro.</p>
<h4>Afogamento</h4>
<p>Não permita que a criança brinque sozinha no banheiro ou próximo de baldes, bacias e banheira. Em piscinas e praias, jamais deixe sozinha. Para quem não sabe nadar, a água não deve ultrapassar a linha do umbigo.</p>
<h4>Queimadura</h4>
<p>Verifique a temperatura da água do banho do bebê. Panelas sempre com cabos para o interior do fogão. Fósforos, líquidos inflamáveis e velas fora do alcance.</p>
<h4>Intoxicação</h4>
<p>Remédios, produtos químicos e venenos em armário alto e trancado. Em caso de ingestão, procure médico com o frasco do produto.</p>
<h4>E ainda…</h4>
<p>Nada de objetos cortantes, pontiagudos ou pequenos (moedas, botões) ao alcance. Sacos plásticos são fatais: podem sufocar.</p>
      </div>
    </details>

    <details class="dica-detail" id="envenenamento-domestico">
      <summary>
        <span class="dica-titulo">Envenenamento doméstico</span>
        <span class="dica-resumo">Remédios são a principal causa em crianças até 5 anos.</span>
      </summary>
      <div class="dica-corpo">
<p>Crianças até cinco anos são as maiores vítimas de intoxicação acidental. Guarde cuidadosamente remédios, produtos de limpeza e inseticidas em locais fechados com chave ou elevados.</p>
<h4>Em caso de ingestão</h4>
<ul>
  <li>Identifique o produto ingerido.</li>
  <li>Verifique a embalagem por informações sobre procedimentos.</li>
  <li>Provoque o vômito somente quando for recomendado. Uma técnica: café com sal.</li>
  <li><strong>Jamais</strong> provoque vômito em pessoa desmaiada, em convulsão ou quando o produto for soda cáustica, inseticida, detergente, querosene, gasolina, ácido ou corrosivo.</li>
  <li>Nunca dê bebida alcoólica a um intoxicado.</li>
  <li>Guarde a embalagem e o material vomitado para identificação médica.</li>
  <li>Em contato com pele ou olhos, lave com água corrente.</li>
  <li>Procure ajuda médica levando a vítima e a embalagem.</li>
</ul>
      </div>
    </details>

    <details class="dica-detail" id="incendio-florestal">
      <summary>
        <span class="dica-titulo">Incêndio florestal</span>
        <span class="dica-resumo">Prevenção e combate em áreas rurais e agrícolas.</span>
      </summary>
      <div class="dica-corpo">
<h4>Prevenção</h4>
<ul>
  <li>Jamais jogue tocos de cigarro acesos em margens de estradas ou rodovias.</li>
  <li>Evite fogo em áreas agrícolas, inclusive para limpar terra.</li>
  <li>Se for inevitável, use apenas queimada controlada, dentro das recomendações dos órgãos ambientais.</li>
  <li>Faça aceiros ao redor da propriedade para impedir a propagação do fogo.</li>
</ul>
<h4>Combate</h4>
<p>Inicie o combate assim que o foco for detectado. Brigadas civis e defesas civis são fundamentais. Máquinas, enxadas e motosserras podem ser usadas para abertura de aceiros. A <strong>Multicursos</strong> oferece treinamento de combate a incêndio para empresas privadas.</p>
      </div>
    </details>

    <details class="dica-detail" id="queima-lixo">
      <summary>
        <span class="dica-titulo">Queima de lixo urbano</span>
        <span class="dica-resumo">Queimar lixo é proibido, agrava a poluição e pode causar acidentes.</span>
      </summary>
      <div class="dica-corpo">
<p>Não queime lixo ou resíduos. Além de ser proibido por lei, agrava a poluição e causa doenças respiratórias.</p>
<p>Essas queimadas podem tomar grandes proporções e atingir construções vizinhas — imagine se atingem um botijão de gás ou a rede elétrica.</p>
<p>Armazene o lixo adequadamente para ser recolhido pelos garis. Lixo em local impróprio causa proliferação de pragas, sujeira, entupimento de bueiros e doenças.</p>
<p><strong>Dica:</strong> separe o material reciclável do lixo doméstico para diminuir o acúmulo em aterros.</p>
      </div>
    </details>

    <details class="dica-detail" id="temporada-praia">
      <summary>
        <span class="dica-titulo">Temporada de praia</span>
        <span class="dica-resumo">Banhistas, embarcações e acampamentos.</span>
      </summary>
      <div class="dica-corpo">
<h4>Banhistas</h4>
<ul>
  <li>Só tome banho em local seguro, de preferência conhecido.</li>
  <li>Evite mergulho profundo e jamais mergulhe sozinho.</li>
  <li>Nunca entre na água depois de comer ou beber muito.</li>
  <li>Respeite a sinalização do Corpo de Bombeiros.</li>
  <li>Pare quando a água atingir a linha do umbigo.</li>
  <li>Evite rios com correnteza e pedras.</li>
  <li>Use protetor solar, boné e beba muito líquido.</li>
  <li>Se alguém estiver se afogando, chame o Corpo de Bombeiros. Só entre na água se souber nadar, tiver resistência e conhecer o local.</li>
  <li>Mantenha as crianças próximas, com alguma identificação.</li>
</ul>
<h4>Embarcações</h4>
<ul>
  <li>Só podem ser pilotadas por maiores de 18 anos com habilitação da Marinha.</li>
  <li>Mantenha motor revisado e casco intacto.</li>
  <li>Celular protegido da água é obrigatório.</li>
  <li>Usuários de jet ski devem respeitar áreas reservadas a banhistas.</li>
  <li>Coletes são obrigatórios para todos, inclusive jet ski.</li>
  <li>Roupas leves facilitam a locomoção em caso de acidente.</li>
</ul>
<h4>Acampamentos</h4>
<ul>
  <li>Evite fazer fogueiras.</li>
  <li>Recolha todo o lixo em sacos plásticos.</li>
  <li>Evite locais com animais peçonhentos.</li>
  <li>Jamais esteja sozinho.</li>
</ul>
      </div>
    </details>
    </div>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
