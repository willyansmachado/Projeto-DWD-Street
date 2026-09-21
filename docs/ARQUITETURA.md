# Arquitetura

A home usa MVC a partir de `app/`. O `index.php` apenas inicializa a aplicação e entrega a requisição ao controller.

| Camada | Responsabilidade | Exemplo |
| --- | --- | --- |
| `app/Controllers` | Orquestra a requisição | `HomeController` |
| `app/Models` | Consulta dados | `Product` |
| `app/Views` | Apresentação HTML | `Views/home/index.php` |
| `app/Core` | Infraestrutura | `Database`, `View` |
| `assets/css` | Base, componentes e página | `base.css`, `components.css`, `home.css` |

As telas em raiz, `categorias/`, `rodapé/` e `admin/` continuam acessíveis como legado para não quebrar links. Migre cada uma criando controller, model, view e um arquivo `assets/css/<pagina>.css`; nunca adicione CSS inline às novas telas.

As páginas já substituídas (`login`, `cadastro`, catálogo, carrinho e pedidos) não ficam mais na raiz: o `.htaccess` entrega as URLs antigas ao roteador MVC. Os quatro fluxos ainda em transição ficam isolados em `app/Views/legacy/`; endpoints de ação e callback externo permanecem na raiz até que pagamento e OAuth sejam reescritos.

## Rotas MVC

| Rota | Controller | Model principal | View |
| --- | --- | --- | --- |
| `/` | `HomeController` | `Product` | `home/index` |
| `/catalogo` | `CatalogController` | `Product`, `Category` | `catalog/index` |
| `/login`, `/cadastro`, `/sair` | `AuthController` | `User` | `auth/*` |
| `/carrinho` | `CartController` | `Cart` | `cart/index` |
| `/pedidos`, `/pedido?id=` | `OrderController` | `Order` | `orders/*` |
| `/sobre`, `/privacidade` | `PageController` | — | `pages/*` |

O `.htaccess` transforma essas URLs em chamadas ao `Router`. Se `mod_rewrite` não estiver habilitado, use `index.php?rota=<nome-da-rota>`.

## Convenções

- Novos arquivos PHP usam `declare(strict_types=1)`.
- Consultas novas usam PDO e prepared statements.
- Valores no HTML passam por `View::escape()`.
- Configure credenciais por `DB_*` no ambiente ou em `config/database.php` local.
