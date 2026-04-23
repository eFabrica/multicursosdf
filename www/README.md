# Multicursos DF · v3 (mescla v2 + Canva)

Terceira iteração do site público, combinando:

- Base técnica do **v2** (HTML5, CSS moderno, partials PHP, security headers, CSRF, zero JS framework)
- Conteúdo e posicionamento do site do **Canva** ([multicursosdf.my.canva.site](https://multicursosdf.my.canva.site/))
- **Sem** a funcionalidade de agenda de turmas (removida nesta versão)

## Acesso

- URL: `http://localhost:8081/v3/`
- Container: mesmo do www (`php-multicursos` na porta 8081)

## Diferenças em relação ao v2

### Removido
- `agenda.php` (home e página dedicada)
- `partials/curso_agenda.php`
- Link "Agenda" na navegação do header e no footer
- Include de `curso_agenda.php` no `curso_template.php`

### Adicionado / atualizado (mesclado do Canva)

| Seção | Conteúdo |
|---|---|
| **Hero** | "Há 20 anos formando o Bombeiro Civil mais desejado do DF" + CBMDF CRD EMP-F/107-06 |
| **Stats-strip** | 20+ anos · R$ 3.238 – 5.500 · 12× sem juros · Credencial CBMDF |
| **Por que Multicursos?** | 6 cards: credenciada, diploma reconhecido, aprende e pratica, 12× sem juros, matutino/noturno, profissão em alta |
| **Catálogo** | Novo curso **COMBO NR-33 + NR-35** e **Conscientização Empresarial** |
| **Áreas de atuação** | 4 nichos: eventos esportivos, musicais, políticos, empresas/indústrias |
| **Sobre** | Texto reforçado com credencial CBMDF e diferenciais |
| **Depoimentos** | Daniel C. Silva (com menção aos professores Renan, Roney, Josino), Alberto Pinheiro, e terceiro genérico |
| **CTA WhatsApp** | Banner gradiente verde com botão grande "Falar no WhatsApp" |
| **Clientes** | 4 placeholders (Delta Fox, Atlas, Samurai, + outros) |
| **Vídeos** | 3 slots preparados para embed YouTube quando o cliente enviar |
| **Banner matrícula** | Faixa laranja destacando parcelamento |

## Paleta de cores (nova)

| Variável | Valor | Uso |
|---|---|---|
| `--brand` | `#e86a10` | cor principal (CTAs, destaques) |
| `--brand-dark` | `#b24f08` | hover do primário |
| `--accent` | `#0b5394` | azul corporativo (eventos esportivos) |
| `--success` | `#25D366` | WhatsApp |
| Gradientes nas áreas | `#8e2de2→#4a00e0` (musicais), `#14b8a6→#0f766e` (empresas) |

## Conteúdo não aproveitado do Canva

Algumas coisas do site Canva **não** puderam ser baixadas:

- **Imagens**: todas servidas via Canva com marca d'água (`Canva`), sem licença para download ou uso direto
- **Vídeos**: embebidos internamente no Canva (não YouTube/Vimeo), inacessíveis
- **Screenshots de clientes**: não disponíveis nos HTML/assets públicos

Placeholders foram usados onde havia imagem/vídeo do Canva. Para publicar de produção:

1. Enviar imagens próprias de alunos em treinamento → substituir placeholders em `.video-placeholder` e `.cliente-placeholder`
2. Criar canal YouTube ou upload próprio → embed em `<iframe>` nos slots de vídeo
3. Solicitar autorização de clientes para logo na seção "Clientes"

## Estrutura

```
v3/
├── index.php              # home mesclada (Canva + v2)
├── assets/styles.css      # CSS com novos componentes (~900 linhas)
├── inc/security.php       # CSRF + h() + session hardening (v2)
├── partials/
│   ├── head.php
│   ├── header.php         # nav sem Agenda
│   ├── footer.php         # sem link Agenda
│   └── curso_template.php # sem include de agenda
├── contatoEnvia.php       # igual v2 (CSRF, XSS escape, anti-injection)
├── <10 páginas de curso>  # iguais v2
├── <institucionais>       # quemsomos, contato, localizacao, parceiros, fotos, dicas, instrutor
└── img/, fotos/           # iguais v2
```

## Contatos preservados

- Tel: (61) 3967-7270 / (61) 3225-5411
- Email: multicursosdf@gmail.com
- WhatsApp: [wa.me/message/NJRITG3XTPCUD1](https://wa.me/message/NJRITG3XTPCUD1)
- Instagram: [@multicursosdf](https://www.instagram.com/multicursosdf/)
- Endereço: Setor Comercial Sul, Quadra 02, Bloco C, Ed. Jamel Cecílio, Salas 203-205, Brasília-DF

## Débito técnico herdado do v2

Ver `www/v2/README.md` — mesmos itens (upgrade PHP 8.1, CKEditor, hash bcrypt, etc.) continuam pendentes.
