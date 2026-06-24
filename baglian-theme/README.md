
# Baglian Advocacia — Landing Page WordPress

Tema WordPress customizado, construído do zero em PHP, para a landing page institucional de um escritório de advocacia. Projeto desenvolvido como desafio técnico.

🔗 **Site publicado:** https://baglianadvocacia.fwh.is
🔗 **Repositório:** https://github.com/joaopedrobagli/baglian-advocacia

## Stack Tecnológica

- **CMS:** WordPress
- **Linguagem:** PHP (tema construído do zero, sem frameworks de tema)
- **Camada de dados:** Advanced Custom Fields (ACF)
- **CSS:** Tailwind CSS v4 (build via npm/CLI, sem CDN)
- **Internacionalização:** Polylang (PT-BR / EN)
- **Hospedagem:** InfinityFree
- **CI/CD:** GitHub Actions com deploy automático via FTP

## Estrutura da Home

| Seção | Descrição |
|---|---|
| Header | Logo, menu de navegação, seletor de idioma, botão de Contato em destaque. Sticky e responsivo (menu hambúrguer no mobile). |
| Hero Banner | Título, subtítulo, imagem de fundo e foto em destaque, CTA configuráveis via ACF. |
| Quem Somos | Texto institucional + cards de estatísticas. |
| Advogados | Listagem dinâmica via Custom Post Type, com campos ACF (especialidade, descrição, OAB). |
| Últimas Notícias | Loop com os 3 posts mais recentes do blog, em layout de destaque + lista. |
| Contato | Dados de contato + mapa do Google incorporado. |
| Footer | Tagline e copyright, vindos de uma página de Configurações personalizada. |

## Decisões Técnicas

### Substituição da ACF Options Page

O escopo original previa usar a **Options Page do ACF** para os dados do footer. Durante o desenvolvimento, identificou-se que esse recurso foi descontinuado na versão gratuita do ACF (atualmente exclusivo do ACF PRO). Para manter a solução 100% gratuita e sem dependências pagas, os dados de contato e configurações globais do site foram implementados através da **Settings API nativa do WordPress** (`register_setting`, `add_options_page`), disponível em **Configurações > Configurações do Site** no painel administrativo. Essa abordagem entrega a mesma funcionalidade (uma página de opções centralizada, editável pelo administrador) sem depender de plugins pagos.

### Tradução de conteúdo

O conteúdo editorial (páginas, posts, Custom Post Type Advogados) é traduzido via Polylang, criando uma versão paralela de cada item. Textos fixos da interface (títulos de seção, rótulos, mensagens de estado vazio) são gerenciados através de `pll_register_string()` / `pll__()`, registrados centralmente no `functions.php` e traduzidos em **Idiomas > Traduções de Textos**.

## Estrutura de Arquivos

```
baglian-theme/
├── style.css              # Cabeçalho de metadados do tema
├── index.php               # Template de fallback (busca, 404, arquivos genéricos)
├── header.php              # Header com menu, seletor de idioma e menu mobile
├── footer.php               # Footer com dados dinâmicos
├── front-page.php           # Template da Home (todas as 6 seções)
├── single.php                # Template de post individual (com navegação anterior/próximo)
├── functions.php             # CPT Advogados, Settings API, Walker de menu, strings traduzíveis
├── package.json               # Dependências do build (Tailwind, plugin de tipografia)
├── src/
│   └── input.css              # Fonte do Tailwind CSS
└── assets/
    └── css/
        └── style.css           # CSS compilado (gerado via build, versionado)
```

## Rodando o Projeto Localmente

### Pré-requisitos

- Docker e Docker Compose
- Node.js (para compilar o Tailwind CSS)

### Passos

1. Clone este repositório
2. Crie um `docker-compose.yml` na raiz do projeto com os serviços `wordpress` e `db` (MySQL), montando a pasta `baglian-theme` em `wp-content/themes/`
3. Suba os containers:
   ```bash
   docker compose up -d
   ```
4. Acesse `http://localhost:8000` e finalize a instalação do WordPress
5. Instale e ative o plugin **Advanced Custom Fields**
6. Instale e ative o plugin **Polylang** (opcional, apenas se for testar a tradução)
7. Ative o tema **Baglian Theme** em Aparência > Temas
8. Compile o CSS:
   ```bash
   cd wp-content/themes/baglian-theme
   npm install
   npm run build:css
   ```
9. Recrie a estrutura de conteúdo necessária:
   - Field Group **"Home - Conteúdo"** (campos: `hero_titulo`, `hero_subtitulo`, `hero_imagem`, `hero_cta_texto`, `hero_cta_link`, `quem_somos_texto`), associado à página inicial
   - Field Group **"Advogado - Detalhes"** (campos: `especialidade`, `descricao`, `oab`), associado ao CPT Advogados
   - Página **Início**, definida como página inicial estática em Configurações > Leitura
   - Preencher **Configurações > Configurações do Site** (endereço, telefone, e-mail, WhatsApp, horário, copyright, embed do Google Maps)
   - Criar o menu de navegação em Aparência > Menus, associado ao local **"Menu Header"**

## CI/CD

O deploy é automatizado via GitHub Actions (`.github/workflows/deploy.yml`). A cada `push` ou `merge` na branch `main`, o workflow publica automaticamente o conteúdo da pasta `baglian-theme` no servidor de hospedagem via FTP, usando credenciais armazenadas como GitHub Secrets.

## Fluxo de Desenvolvimento

O projeto seguiu um fluxo de Git baseado em branches por funcionalidade: cada alteração foi desenvolvida em uma branch própria, testada localmente, e integrada à `main` através de Pull Requests, disparando o deploy automático após o merge.