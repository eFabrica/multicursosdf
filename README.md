# Multicursos DF

Repositório do site [multicursosdf.com.br](https://www.multicursosdf.com.br) — Multicursos, Formação Profissional.
Cursos de brigadista, socorrista, CIPA, DEA, EPI, NR-10, salvamento aquático e primeiros socorros.

## Estrutura

```
www/
├── v2/              # site público modernizado (HTML5/CSS/PHP 7.4) — em http://localhost:8081/v2/
├── cms/             # CMS administrativo legado (SGE)
├── lp/              # WordPress (landing pages secundárias)
├── (site antigo)    # páginas PHP legadas na raiz de www/
├── Dockerfile
└── docker-compose.yml
```

## Stack

- **PHP 7.4 Apache** (container Docker)
- **MySQL 5.7** (container Docker)
- Shim `php7_mysql_shim.php` para compatibilidade das páginas legadas com `mysql_*`

## Rodar localmente

```bash
cd www
cp .env.example .env     # edite com credenciais reais
docker-compose up --build
```

| URL | O que é |
|---|---|
| `http://localhost:8081/` | Site antigo (layout legado) |
| `http://localhost:8081/v2/` | **Site moderno** (layout novo, responsivo, seguro) |
| `http://localhost:8081/cms/` | Painel administrativo (SGE) |
| `http://localhost:8081/lp/` | WordPress |

## v2 — site público modernizado

Versão reescrita do site público com:

- HTML5 semântico, CSS puro mobile-first, **zero dependências JS**
- Security headers (CSP, X-Frame-Options, nosniff, Referrer-Policy, Permissions-Policy)
- Cookies `HttpOnly`/`SameSite=Lax`
- CSRF tokens nos formulários + escape XSS com helper `h()`
- Prepared statements (mysqli) na agenda dinâmica
- Credenciais exclusivamente via env vars (sem fallback hardcoded)
- Botões flutuantes para WhatsApp e Instagram
- Lightbox CSS-only (sem jQuery)
- Encoding UTF-8 consistente

Detalhes e débito técnico: `www/v2/README.md`.

## Débito técnico conhecido

Ver `www/v2/README.md` e documentos em `melhorias/` (uso interno, fora do repo).

Resumo: upgrade PHP 8.1, substituição do FCKeditor, hash de senhas bcrypt,
CSRF global no CMS, XSS cleanup, HTTPS em produção.

## Licença

Proprietário — Multicursos DF.
