# DWD Street

E-commerce de moda urbana em PHP e MySQL, organizado com MVC para separar interface, regras de negócio e acesso ao banco.

## Recursos

- Catálogo por categoria, estoque e imagens de produto.
- Cadastro, login, sessão e carrinho persistente.
- Pedidos, itens, pagamento e rastreamento.
- Layout responsivo para desktop e celular.

## Requisitos

| Tecnologia | Versão recomendada |
| --- | --- |
| PHP | 8.1+ |
| MySQL | 8.0+ |
| MariaDB | 10.5+ |
| Apache | 2.4+ com `mod_rewrite` |
| Extensões PHP | `pdo_mysql`, `mysqli` |

## Instalação

1. Coloque o projeto em `C:\xampp\htdocs\Projeto-DWD-Street`.
2. Inicie Apache e MySQL pelo XAMPP.
3. Importe [database/schema.sql](database/schema.sql) no phpMyAdmin ou MySQL.
4. Configure [config/database.php](config/database.php), ou use `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`.
5. Abra `http://localhost/Projeto-DWD-Street/`.

O schema cria uma conta de desenvolvimento: `admin@dwdstreet.com` / `admin123`. Altere ou remova essa conta antes de publicar.

## Rotas MVC

Com `mod_rewrite` ativo, use as URLs abaixo. Sem ele, use `index.php?rota=<rota>`.

| Rota | Descrição |
| --- | --- |
| `/` | Home e produtos em destaque |
| `/catalogo` | Catálogo e categorias |
| `/login`, `/cadastro` | Autenticação |
| `/carrinho` | Carrinho do cliente |
| `/pedidos` | Histórico de pedidos |
| `/sobre`, `/privacidade` | Páginas institucionais |

As antigas URLs PHP de catálogo, login, cadastro, carrinho e pedidos são redirecionadas para MVC. Pagamento, recuperação de senha, montador e Google OAuth continuam em compatibilidade enquanto são migrados.

## Estrutura

- `app/`: Controllers, Models, Views e Core.
- `assets/`: CSS, JavaScript e imagens estáticas.
- `config/`: configuração local.
- `database/`: schema atual e histórico legado.
- `docs/`: arquitetura, casos de uso e diagramas.
- `admin/`: administração em migração.
- `uploads/`: arquivos enviados.

## Banco de dados

O [schema atual](database/schema.sql) foi normalizado e pode ser importado em uma base vazia. Ele inclui chaves estrangeiras, índices para catálogo/carrinho/pedidos, unicidade de e-mail, SKU, slug e itens do carrinho, além de restrições básicas de integridade.

Relações principais: `usuarios → enderecos`, `categorias → produtos`, `usuarios → carrinho`, `usuarios → pedidos`, `pedidos → itens_pedido` e `pedidos → pagamentos`.

O schema anterior está preservado em `database/legacy/schema-original.sql` como referência histórica. Não o use em uma instalação nova, pois contém duplicações e alterações conflitantes.

## Convenções

- Controllers não executam SQL diretamente.
- Models MVC usam PDO e prepared statements.
- Views escapam conteúdo dinâmico com `View::escape()`.
- Novos estilos ficam em `assets/css/<pagina>.css`.
- Todos os arquivos usam UTF-8 sem BOM.

## Documentação

- [Arquitetura](docs/ARQUITETURA.md)
- [Casos de uso](docs/CASOS_DE_USO.md)
- [Diagrama de casos de uso](docs/DIAGRAMA_CASOS_DE_USO.puml)
- [Diagrama de classes](docs/DIAGRAMA_DE_CLASSES.puml)

## Próximos passos

1. Migrar pagamento, recuperação de senha, OAuth e admin para controllers próprios.
2. Adicionar token CSRF em formulários POST.
3. Criar testes automatizados para Models e checkout.
4. Configurar logs e variáveis de ambiente para produção.
