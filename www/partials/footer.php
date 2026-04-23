<?php
$nav_external = !empty($nav_external);
$prefix = $nav_external ? 'index.php' : '';
?>
<footer class="footer">
  <div class="container footer-inner">
    <div class="footer-col footer-brand">
      <div class="brand brand-footer">
        <img src="img/logo.png" alt="Multicursos" class="brand-logo">
        <span class="brand-text">
          <strong>Multicursos</strong>
          <em>Formação Profissional</em>
        </span>
      </div>
      <p>Credenciada CBM-DF. Formação técnica em segurança e emergência desde 2004.</p>
    </div>

    <div class="footer-col">
      <h4>Cursos</h4>
      <ul>
        <li><a href="brigadista.php">Brigadista</a></li>
        <li><a href="socorrista.php">Socorrista</a></li>
        <li><a href="dea.php">DEA</a></li>
        <li><a href="aquatico.php">Salvamento Aquático</a></li>
        <li><a href="cipa.php">CIPA &middot; NR-05</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Institucional</h4>
      <ul>
        <li><a href="quemsomos.php">Quem somos</a></li>
        <li><a href="localizacao.php">Localização</a></li>
        <li><a href="parceiros.php">Parceiros</a></li>
        <li><a href="contato.php">Contato</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h4>Acompanhe</h4>
      <ul class="social">
        <li>
          <a href="https://www.facebook.com/multicursosdf" target="_blank" rel="noopener" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg>
          </a>
        </li>
        <li>
          <a href="https://www.instagram.com/multicursosdf/" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2 0 1.8.3 2.2.5.6.2 1 .5 1.4 1s.7.8.9 1.4c.2.4.4 1 .5 2.2.1 1.2.1 1.6.1 4.8s0 3.6-.1 4.8c0 1.2-.3 1.8-.5 2.2-.2.6-.5 1-1 1.4s-.8.7-1.4.9c-.4.2-1 .4-2.2.5-1.2.1-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2 0-1.8-.3-2.2-.5-.6-.2-1-.5-1.4-1s-.7-.8-.9-1.4c-.2-.4-.4-1-.5-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.8c0-1.2.3-1.8.5-2.2.2-.6.5-1 1-1.4s.8-.7 1.4-.9c.4-.2 1-.4 2.2-.5C8.4 2.2 8.8 2.2 12 2.2zM12 0C8.7 0 8.3 0 7.1.1 5.8.1 5 .3 4.2.6c-.8.3-1.5.7-2.2 1.4-.7.7-1.1 1.4-1.4 2.2-.3.8-.5 1.6-.5 2.9C0 8.3 0 8.7 0 12s0 3.7.1 4.9c.1 1.3.2 2.1.5 2.9.3.8.7 1.5 1.4 2.2.7.7 1.4 1.1 2.2 1.4.8.3 1.6.5 2.9.5 1.2.1 1.6.1 4.9.1s3.7 0 4.9-.1c1.3-.1 2.1-.2 2.9-.5.8-.3 1.5-.7 2.2-1.4.7-.7 1.1-1.4 1.4-2.2.3-.8.5-1.6.5-2.9.1-1.2.1-1.6.1-4.9s0-3.7-.1-4.9c-.1-1.3-.2-2.1-.5-2.9-.3-.8-.7-1.5-1.4-2.2-.7-.7-1.4-1.1-2.2-1.4-.8-.3-1.6-.5-2.9-.5C15.7 0 15.3 0 12 0z"/><path d="M12 5.8c-3.4 0-6.2 2.8-6.2 6.2s2.8 6.2 6.2 6.2 6.2-2.8 6.2-6.2-2.8-6.2-6.2-6.2zm0 10.2c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4z"/><circle cx="18.4" cy="5.6" r="1.4"/></svg>
          </a>
        </li>
        <li>
          <a href="https://wa.me/message/NJRITG3XTPCUD1" target="_blank" rel="noopener" aria-label="WhatsApp">
            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
          </a>
        </li>
      </ul>
      <p class="footer-email"><a href="mailto:multicursosdf@gmail.com">multicursosdf@gmail.com</a></p>
    </div>
  </div>

  <div class="footer-bottom container">
    <small>&copy; <?= date('Y') ?> Multicursos &middot; Formação Profissional. Todos os direitos reservados.</small>
    <small>Brasília &middot; DF &middot; (61) 3967-7270</small>
  </div>
</footer>

<!-- Contatos flutuantes fixos (sempre visíveis) -->
<div class="float-contacts" aria-label="Contato rápido">
  <a class="float-btn float-wa" href="https://wa.me/message/NJRITG3XTPCUD1" target="_blank" rel="noopener" aria-label="Fale no WhatsApp">
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
    <span class="float-label">WhatsApp</span>
  </a>
  <a class="float-btn float-ig" href="https://www.instagram.com/multicursosdf/" target="_blank" rel="noopener" aria-label="Siga no Instagram">
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2 0 1.8.3 2.2.5.6.2 1 .5 1.4 1s.7.8.9 1.4c.2.4.4 1 .5 2.2.1 1.2.1 1.6.1 4.8s0 3.6-.1 4.8c0 1.2-.3 1.8-.5 2.2-.2.6-.5 1-1 1.4s-.8.7-1.4.9c-.4.2-1 .4-2.2.5-1.2.1-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2 0-1.8-.3-2.2-.5-.6-.2-1-.5-1.4-1s-.7-.8-.9-1.4c-.2-.4-.4-1-.5-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.8c0-1.2.3-1.8.5-2.2.2-.6.5-1 1-1.4s.8-.7 1.4-.9c.4-.2 1-.4 2.2-.5C8.4 2.2 8.8 2.2 12 2.2zM12 0C8.7 0 8.3 0 7.1.1 5.8.1 5 .3 4.2.6c-.8.3-1.5.7-2.2 1.4-.7.7-1.1 1.4-1.4 2.2-.3.8-.5 1.6-.5 2.9C0 8.3 0 8.7 0 12s0 3.7.1 4.9c.1 1.3.2 2.1.5 2.9.3.8.7 1.5 1.4 2.2.7.7 1.4 1.1 2.2 1.4.8.3 1.6.5 2.9.5 1.2.1 1.6.1 4.9.1s3.7 0 4.9-.1c1.3-.1 2.1-.2 2.9-.5.8-.3 1.5-.7 2.2-1.4.7-.7 1.1-1.4 1.4-2.2.3-.8.5-1.6.5-2.9.1-1.2.1-1.6.1-4.9s0-3.7-.1-4.9c-.1-1.3-.2-2.1-.5-2.9-.3-.8-.7-1.5-1.4-2.2-.7-.7-1.4-1.1-2.2-1.4-.8-.3-1.6-.5-2.9-.5C15.7 0 15.3 0 12 0z"/><path d="M12 5.8c-3.4 0-6.2 2.8-6.2 6.2s2.8 6.2 6.2 6.2 6.2-2.8 6.2-6.2-2.8-6.2-6.2-6.2zm0 10.2c-2.2 0-4-1.8-4-4s1.8-4 4-4 4 1.8 4 4-1.8 4-4 4z"/><circle cx="18.4" cy="5.6" r="1.4"/></svg>
    <span class="float-label">Instagram</span>
  </a>
</div>

<script>
(function(){
  var btn = document.getElementById('navToggle');
  var nav = document.getElementById('nav');
  if (btn && nav) {
    btn.addEventListener('click', function(){
      var open = nav.classList.toggle('open');
      btn.classList.toggle('active', open);
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    nav.querySelectorAll('a').forEach(function(a){
      a.addEventListener('click', function(){
        nav.classList.remove('open');
        btn.classList.remove('active');
        btn.setAttribute('aria-expanded', 'false');
      });
    });
  }
  var header = document.querySelector('.header');
  function onScroll(){
    if (window.scrollY > 10) header.classList.add('scrolled');
    else header.classList.remove('scrolled');
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
})();
</script>
</body>
</html>
