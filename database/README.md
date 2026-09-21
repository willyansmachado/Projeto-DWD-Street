# Banco de dados

Use `schema.sql` para uma instalação nova. O arquivo cria o banco `dwd_street`, as tabelas da aplicação, índices e dados mínimos de categorias, tamanhos e administrador de desenvolvimento.

Antes de importar em um ambiente que já contém dados, faça backup:

```sql
mysqldump -u root -p dwd_street > backup-dwd-street.sql
```

O conteúdo de `legacy/schema-original.sql` foi mantido somente para consulta. Ele reúne alterações antigas e não deve ser executado em uma base nova.

## Integridade adotada

- `email`, `cpf`, `google_id`, SKU, slug e código de pedido possuem unicidade quando aplicável.
- Chaves estrangeiras impedem itens órfãos e removem dependências em cascata quando o registro principal é apagado.
- Índices atendem consultas frequentes de catálogo, carrinho, pedidos, imagens e estoque.
- Valores monetários usam `DECIMAL(10,2)`; não use `FLOAT` para preços.
