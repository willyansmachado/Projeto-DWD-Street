<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

if(!isset($_GET['id'])){
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado) == 0){
    header("Location: index.php");
    exit();
}

$produto = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Editar Produto</title>

<link rel="stylesheet" href="../css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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

<input type="hidden" name="id" value="<?= $produto['id']; ?>">
<input type="hidden" name="imagem_antiga" value="<?= $produto['imagem']; ?>">

<div class="grupo">

<label>Nome</label>

<input
type="text"
name="nome"
value="<?= htmlspecialchars($produto['nome']); ?>"
required>

</div>

<div class="grupo">

<label>Descrição</label>

<textarea
name="descricao"
rows="6"><?= htmlspecialchars($produto['descricao']); ?></textarea>

</div>

<div class="linha">

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

</div>

<div class="grupo">

<label>Categoria</label>

<select name="categoria">

<option <?= $produto['categoria']=="Masculino"?"selected":"" ?>>Masculino</option>

<option <?= $produto['categoria']=="Feminino"?"selected":"" ?>>Feminino</option>

<option <?= $produto['categoria']=="Acessórios"?"selected":"" ?>>Acessórios</option>

<option <?= $produto['categoria']=="Calçados"?"selected":"" ?>>Calçados</option>

</select>

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

<?php if($produto['imagem'] != ""){ ?>

<img
id="preview"
src="../../<?= $produto['imagem']; ?>">

<?php }else{ ?>

<img
id="preview"
src="../img/sem-imagem.png">

<?php } ?>

</div>

<div class="botoes">

<button
class="btnSalvar">

<i class="fa-solid fa-floppy-disk"></i>

Salvar Alterações

</button>

<a
href="index.php"
class="btnCancelar">

Cancelar

</a>

</div>

</form>

</div>

</div>

</div>

<script>

imagem.onchange=function(e){

const leitor=new FileReader();

leitor.onload=function(){

preview.src=leitor.result;

}

leitor.readAsDataURL(e.target.files[0]);

}

</script>

</body>

</html>