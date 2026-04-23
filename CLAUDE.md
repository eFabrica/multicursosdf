# Multicursos DF - Guia para Claude Code

Site institucional e sistema administrativo da **Multicursos - Formação Profissional** (brigadista, socorrista, CIPA, DEA, proteção, eletricidade, aquático, voluntariado, capacitação).

## Idioma

Sempre comunicar com o usuário em **português (pt-BR)**. Commits, PRs e comentários em código também em pt-BR (quando houver).

## Stack e estrutura

- Raiz do código público: `www/`
- `docker-compose.yml`: PHP 7.4 Apache + MySQL 5.7 — volume aponta para `./html`, mas o código real está em `./www` (inconsistência a verificar).
- Conexão MySQL em `www/conexao.php` usando `mysql_*` (API depreciada do PHP 4/5) via shim `php7_mysql_shim.php`.
- Credenciais hardcoded: servidor `mysql.multicursosdf.com.br`.
- Páginas públicas na raiz de `www/` seguindo padrão `{curso}.php`, `{curso}_ag.php`, `{curso}_agenda.php`.
- CMS próprio em `www/cms/` com módulos: `arquivo`, `empresas`, `financeiro`, `gerenciamentos`, `manutencao`, `relatorios`, `sistema`.
- Landing page WordPress em `www/lp/` (instalação completa e separada).
- HTML estático em `marketing/`.

Três áreas distintas: **site público**, **CMS**, **WordPress** — verificar em qual a edição impacta.

## Encoding dos PHPs (CRÍTICO)

Arquivos PHP do CMS (`www/cms/**/*.php`, `www/conexao*.php`) estão em **ISO-8859-1 (latin1)**. Páginas renderizam com `<meta charset="iso-8859-1">` (ver `www/cms/includes/head.php`).

Ao usar `Read`, bytes latin1 acentuados aparecem como `�` (o Read decodifica como UTF-8). Escrever de volta via `Edit`/`Write` converte esses `�` em bytes UTF-8 `\xef\xbf\xbd` (U+FFFD) — **corrompe o arquivo** e a página renderiza mojibake ("Matrï½cula" em vez de "Matrícula").

Regras ao editar PHP do CMS:

1. **Nunca** escrever texto acentuado literal (`é`, `ã`, `ç`) em `Edit`/`Write` — vira UTF-8 e quebra o arquivo.
2. **Comentários PHP**: ASCII puro, sem acentos ("Media Final editavel", não "Média Final editável").
3. **Strings visíveis no HTML**: usar entidades (`M&eacute;dia`, `A&ccedil;&atilde;o`, `Matr&iacute;cula`) — funcionam em qualquer encoding.
4. Ao editar região com acentos preexistentes, **preservar bytes originais**: no `old_string`, copiar exatamente o `�` do Read, e validar depois com `grep -c $'\xef\xbf\xbd' arquivo`.
5. Se ocorrer corrupção, restaurar com `C:\multicursosdf\fix_encoding.pl <arquivos>` (mapeia palavras PT conhecidas). Se sobrar byte corrompido, adicionar a palavra ao mapeamento.

## Boas práticas

- Priorizar correção de **vulnerabilidades**: SQL injection (uso extensivo de `mysql_*` + concatenação), XSS, credenciais expostas, senhas em texto plano. Avisar o usuário e corrigir ao identificar.
- Preferir **editar arquivos existentes** a criar novos.
- Respostas **concisas**, sem resumos redundantes.
- **Não adicionar features** além do solicitado; não refatorar ao redor do alvo.
- **Não adicionar comentários** a menos que expliquem um "porquê" não óbvio.
- **Confirmar antes** de ações destrutivas (delete, drop, reset, force push).
- Código legado é PHP 7.4 com padrões pré-PSR; não tentar modernizar em massa sem pedido explícito.

## Persistência de contexto

O usuário pediu que informações relevantes sejam gravadas tanto neste `CLAUDE.md` quanto na auto-memória (`C:\Users\yes_r\.claude\projects\C--multicursosdf\memory\`). Ao descobrir novas convenções/restrições/decisões do projeto, atualizar este arquivo; ao descobrir preferências do usuário ou contexto cross-session, gravar na auto-memória. Quando ambos se aplicam, gravar nos dois.
