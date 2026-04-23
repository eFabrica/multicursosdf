# Multicursos DF · v2 (site público)

Versão modernizada do site público da Multicursos, criada a partir de `www/` com:

- Layout moderno (ex-`modelo1`) como home
- Correções de segurança aplicáveis sem quebrar funcionalidade
- **Sem CMS, sem WordPress, sem dumps SQL** — só o site institucional

Escopo e débito técnico referentes a `melhorias/melhorias1.md`.

---

## Como rodar

```bash
cp .env.example .env
# edite .env com as credenciais reais
docker-compose up --build
```

Acesse: <http://localhost:8082/>

> O `www/` original continua rodando na porta 8081 em paralelo — os dois ambientes são independentes.

---

## Estrutura

```
v2/
├── index.php              # home nova (layout modelo1 inline com PHP)
├── assets/styles.css      # CSS moderno (único, 14 KB)
├── inc/security.php       # helper CSRF + XSS + session hardening
├── conexao.php            # sem fallback de credenciais
├── contatoEnvia.php       # CSRF + XSS escape + anti header injection
├── .htaccess              # security headers (CSP, X-Frame, nosniff, etc)
├── .env.example           # template para credenciais
├── .gitignore
├── Dockerfile             # Apache 7.4 + mod_headers + cookies httponly/samesite
├── docker-compose.yml     # porta 8082 (não conflita com www/)
├── <10 páginas de curso PHP>  # brigadista.php, aquatico.php, etc
├── <arquivos institucionais>  # quemsomos, contato, agenda, localizacao, etc
├── css/                   # lightbox.css (usado em localizacao/fotos)
├── img/                   # logos + fotos institucionais (~40 arquivos)
├── images/                # assets do lightbox (close, label gifs)
├── js/                    # 6 libs legadas: jquery, prototype, scriptaculous, lightbox, easySlider, util
├── fotos/                 # galeria (Brigada, Cursos, Socorrista, Dea)
└── marketing/             # landing secundária standalone
```

**184 arquivos** (vs. 537 copiados inicialmente de `www/` sem cms/lp/initdb — redução de 66%).

---

## Melhorias aplicadas (de `melhorias/melhorias1.md`)

### Totais

| # | Item | Como foi aplicado |
|---|---|---|
| **2** | Credenciais fallback | `conexao.php` exige env vars; falha explícita se ausentes |
| **6** | XSS pontual | `contatoEnvia.php` escapa tudo com `htmlspecialchars` via helper `h()`; remove `\r\n` de campos usados em headers (anti header injection) |
| **7** | CSRF tokens | Novo helper `inc/security.php` com `csrf_token()`, `csrf_field()`, `csrf_check()`; aplicado ao form da home |
| **10** | Security headers HTTP | `.htaccess` com CSP, X-Frame-Options: DENY, X-Content-Type-Options: nosniff, Referrer-Policy, Permissions-Policy |
| **11** | Cookies seguros (parte) | Session com `httponly`, `samesite=Lax`, `secure` quando HTTPS |
| **13** | Código morto removido | `adm.php`, `manut.php`, `manutacesso.php`, `manutagenda.php`, `manutencao.php`, `conexao_hugopolitec.php`, `conexao_script.php`, `copia1_contato.php`, `contatoEnvia2.php`, `*_ag.php` (12), `reciclagem_agenda.php`, além de 46 imagens órfãs, JS duplicado em `js/<curso>.php`, pasta `marketing/back/`, cópias " - Copia.*", PDFs e ZIPs perdidos |
| **18** | `sr-latn.js` corrompido | Ficou no CMS, fora do escopo de v2 |

### Parciais

| # | Item | Estado |
|---|---|---|
| **1** | SQL injection | Eliminado nos endpoints administrativos (que foram **removidos**). Páginas institucionais restantes (`agenda.php`, `*_agenda.php`) ainda contêm queries legadas com `mysql_*` e concatenação — precisam de refactor por módulo |

---

## Débito técnico (fora do escopo desta entrega)

Itens do `melhorias1.md` que **não** foram aplicados em v2 por exigirem decisão/infra externa:

| # | Item | Por quê ficou fora |
|---|---|---|
| **3** | PHP 7.4 → 8.1 | Exige rebuild do Docker e teste funcional completo; `mysql_*` via shim precisa revisão para 8.x |
| **4** | FCKeditor → CKEditor 5 | Aplicável só ao CMS; v2 não tem CMS |
| **5** | Password hash (BCrypt) | Exige script de migração com acesso ao banco de produção |
| **8** | Remover shim `mysql_*` | Aplicável junto com item 3 |
| **9** | UTF-8 unificado | Aplicável só ao CMS; v2 já é UTF-8 |
| **11** | HTTPS real | Exige certificado e configuração Apache de produção (Let's Encrypt) |
| **12** | Versionamento Git | Exige decisão sobre repositório remoto (GitHub/GitLab/Bitbucket?) |
| **14** | Inconsistência Docker `html`/`www` | Validar em `docker-compose.yml` original |
| **15** | Logging estruturado (Monolog) | Exige escolha arquitetural |
| **16** | Testes automatizados | Exige definição de módulos críticos + escrita de casos |
| **17** | Layout moderno nas páginas internas | Só a home foi modernizada nesta entrega; cursos/contato ainda usam `<table>` e `style.css` antigo |

---

## Próximos passos sugeridos

1. **Rodar e validar**: subir o Docker, testar home + todas as páginas de cursos + envio do formulário.
2. **Ativar HTTPS** antes de qualquer deploy real (CSP + HSTS só fazem sentido com SSL).
3. **Modernizar páginas internas**: aplicar o mesmo tratamento do `index.php` aos 10 PHPs de curso (reusa `assets/styles.css`).
4. **Eliminar os `mysql_*` restantes**: `agenda.php` e `*_agenda.php` ainda fazem queries legadas.
5. **Git init + CI**: versionar e publicar no remoto escolhido.

---

## Diferenças principais em relação ao `www/` original

| | www/ | v2/ |
|---|---|---|
| Home | Tabelas HTML, 20+ imagens recortadas, form de login CMS exposto | HTML5 semântico, CSS puro, login discreto no rodapé |
| Charset home | ISO-8859-1 (com bug de `�`) | UTF-8 consistente |
| JS | jQuery 1.x + easySlider | **Zero JS framework** (20 linhas inline) |
| Credenciais DB | Hardcoded em `conexao.php` | Exigem env vars |
| CSRF | Ausente | Token por sessão + validação |
| XSS no e-mail | Injeção de HTML livre | `htmlspecialchars` em todos os campos |
| Header injection | Possível via campos do form | Bloqueada (remove `\r\n`) |
| Security headers | Nenhum | CSP, X-Frame, nosniff, Referrer, Permissions |
| Cookies de sessão | Padrão (inseguros) | httponly + samesite=Lax + secure com HTTPS |
| Arquivos | 537 iniciais | 184 (redução 66%) |
| CMS / WordPress | Incluídos | **Fora** |
