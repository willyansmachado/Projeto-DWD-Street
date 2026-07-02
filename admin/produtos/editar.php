<?php
session_start();

include("../../config/conexao.php");
include("../includes/verificar_login.php");

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET["id"];

/* Buscar produto */

$sql = "SELECT * FROM produtos WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: index.php");
    exit();
}

$produto = mysqli_fetch_assoc($resultado);

/* Buscar categorias */

$categorias = mysqli_query($conn, "
SELECT id, nome
FROM categorias
WHERE ativo = 1
ORDER BY nome
");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Editar Produto</title>

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

<h1>Editar Produto</h1>

<a href="index.php" class="btnVoltar">

<i class="fa-solid fa-arrow-left"></i>

Voltar

</a>

</div>

<form
action="atualizar.php"
method="POST"
enctype="multipart/form-data"
class="formulario">

<input
type="hidden"
name="id"
value="<?= $produto['id']; ?>">

<input
type="hidden"
name="imagem_antiga"
value="<?= $produto['imagem']; ?>">

<div class="grupo">

<label>Nome</label>

<input
type="text"
name="nome"
value="<?= htmlspecialchars($produto['nome']); ?>"
required>

</div>

<div class="grupo">

<label>Categoria</label>

<select name="categoria_id" required>

<?php while($categoria = mysqli_fetch_assoc($categorias)){ ?>

<option
value="<?= $categoria['id']; ?>"
<?= $categoria['id'] == $produto['categoria_id'] ? "selected" : ""; ?>>

<?= htmlspecialchars($categoria['nome']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="grupo">

<label>Preço</label>

<input
type="number"
step="0.01"
name="preco"
value="<?= $produto['preco']; ?>"
required>

</div>

<div class="grupo">

<label>Estoque</label>

<input
type="number"
name="estoque"
value="<?= $produto['estoque']; ?>"
required>

</div>

<div class="grupo">

<label>Descrição</label>

<textarea
name="descricao"
rows="6"><?= htmlspecialchars($produto['descricao']); ?></textarea>

</div>

<div class="grupo">

<label>Nova Imagem (opcional)</label>

<input
type="file"
name="imagem"
accept="image/*"
id="imagem">

</div>

<div class="preview">

<?php if(!empty($produto['imagem'])){ ?>

<img
id="preview"
src="../../<?= $produto['imagem']; ?>"
style="max-width:250px;">

<?php } else { ?>

<img
id="preview"
src="../img/sem-imagem.png"
style="max-width:250px;">

<?php } ?>

</div>

<br>

<button
type="submit"
class="btn">

<i class="fa-solid fa-floppy-disk"></i>

Salvar Alterações

</button>

<a
href="index.php"
class="btn"
style="background:#555;margin-left:10px;">

Cancelar

</a>

</form>

</div>

</div>

</div>

<script>

const imagem = document.getElementById("imagem");
const preview = document.getElementById("preview");

imagem.addEventListener("change", function(){

    if(this.files.length){

        const reader = new FileReader();

        reader.onload = function(e){

            preview.src = e.target.result;

        }

        reader.readAsDataURL(this.files[0]);

    }

});

</script>

</body>

</html>