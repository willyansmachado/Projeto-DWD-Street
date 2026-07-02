<?php
session_start();

include("../../config/conexao.php");
include("../includes/verificar_login.php");

$categorias = mysqli_query($conn, "
SELECT id, nome
FROM categorias
WHERE ativo = 1
ORDER BY nome
");

$form = $_SESSION["form_produto"] ?? [];
unset($_SESSION["form_produto"]);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Novo Produto</title>

    <link rel="stylesheet" href="../css/admin.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="container">

    <?php include("../includes/menu.php"); ?>

    <div class="main">

        <?php include("../includes/topbar.php"); ?>

        <div class="conteudo">

            <div class="titulo">

                <div>

                    <h1>Novo Produto</h1>

                    <p class="subtitulo">
                        Preencha as informações abaixo para cadastrar um novo produto da DWD Street.
                    </p>

                </div>

            </div>

            <form action="salvar.php" method="POST" enctype="multipart/form-data" class="formulario">

                <div class="grupo">

                    <label>Nome do Produto</label>

                    <input
type="text"
name="nome"
value="<?= htmlspecialchars($form['nome'] ?? '') ?>"
placeholder="Ex.: Camiseta DWD Essential Black"
required>

                </div>

                <div class="linha">

                    <div class="grupo">

                        <label>Categoria</label>

                        <select name="categoria_id" required>

<option value="">Selecione uma categoria</option>

<?php while($categoria = mysqli_fetch_assoc($categorias)){ ?>

<option
value="<?= $categoria['id']; ?>"
<?= (($form['categoria_id'] ?? '') == $categoria['id']) ? 'selected' : ''; ?>>

<?= htmlspecialchars($categoria['nome']); ?>

</option>

<?php } ?>

</select>

                    </div>

                    <div class="grupo">

                        <label>SKU (Opcional)</label>

                        <input
type="text"
name="sku"
value="<?= htmlspecialchars($form['sku'] ?? '') ?>"
placeholder="Ex.: DWD-CAM-001">

                    </div>

                </div>

                <div class="linha">

                    <div class="grupo">

                        <label>Preço</label>

                        <input
type="number"
step="0.01"
name="preco"
value="<?= htmlspecialchars($form['preco'] ?? '') ?>"
placeholder="Ex.: 89.90"
required>

                    </div>

                    <div class="grupo">

                        <label>Preço Promocional</label>

                        <input
type="number"
step="0.01"
name="preco_promocional"
value="<?= htmlspecialchars($form['preco_promocional'] ?? '') ?>"
placeholder="Ex.: 69.90">

                    </div>

                    <div class="grupo">

                        <label>Estoque</label>

                        <input
type="number"
name="estoque"
min="0"
value="<?= htmlspecialchars($form['estoque'] ?? '0') ?>"
required>
                    </div>

                </div>

                <div class="grupo">

                    <label>Imagem do Produto</label>

                    <input
                        type="file"
                        name="imagem"
                        accept="image/*">

                </div>

                <div class="linha">

                    <div class="grupo">

                        <label>Produto em Destaque</label>

                        <select name="destaque">

<option value="0" <?= (($form['destaque'] ?? '0') == 0) ? 'selected' : ''; ?>>Não</option>

<option value="1" <?= (($form['destaque'] ?? '') == 1) ? 'selected' : ''; ?>>Sim</option>

</select>

                    </div>

                    <div class="grupo">

                        <label>Lançamento</label>

                        <select name="lancamento">

<option value="0" <?= (($form['lancamento'] ?? '0') == 0) ? 'selected' : ''; ?>>Não</option>

<option value="1" <?= (($form['lancamento'] ?? '') == 1) ? 'selected' : ''; ?>>Sim</option>

</select>
                    </div>

                    <div class="grupo">

                        <label>Status</label>

                        <select name="ativo">

<option value="1" <?= (($form['ativo'] ?? '1') == 1) ? 'selected' : ''; ?>>Ativo</option>

<option value="0" <?= (($form['ativo'] ?? '') == 0) ? 'selected' : ''; ?>>Inativo</option>

</select>

                    </div>

                </div>

                <div class="grupo">

                    <label>Descrição Curta</label>

                    <textarea
name="descricao_curta"
rows="3"
placeholder="Breve descrição do produto."><?= htmlspecialchars($form['descricao_curta'] ?? '') ?></textarea>
                </div>

                <div class="grupo">

                    <label>Descrição Completa</label>

                    <textarea
name="descricao"
rows="6"
placeholder="Descreva o produto em detalhes."><?= htmlspecialchars($form['descricao'] ?? '') ?></textarea>

                </div>

                <div class="botoes">

                    <button
                        type="submit"
                        class="btn">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Salvar Produto

                    </button>

                    <a
                        href="index.php"
                        class="btn"
                        style="background:#555;margin-left:10px;">

                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>