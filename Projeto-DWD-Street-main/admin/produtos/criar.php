<?php
session_start();

include("../../config/conexao.php");
include("../includes/verifica_login.php");

$categorias = mysqli_query($conn, "SELECT id, nome FROM categorias WHERE ativo = 1 ORDER BY nome");

$marcas = mysqli_query($conn, "SELECT id, nome FROM marcas WHERE ativo = 1 ORDER BY nome");
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

<h1>Novo Produto</h1>

<form action="salvar.php" method="POST">

<label>Nome</label>

<input
type="text"
name="nome"
required>

<label>Categoria</label>

<select
name="categoria_id"
required>

<option value="">Selecione...</option>

<?php while($categoria = mysqli_fetch_assoc($categorias)){ ?>

<option value="<?= $categoria['id'] ?>">

<?= htmlspecialchars($categoria['nome']) ?>

</option>

<?php } ?>

</select>

<label>Marca</label>

<select
name="marca_id">

<option value="">Sem marca</option>

<?php while($marca = mysqli_fetch_assoc($marcas)){ ?>

<option value="<?= $marca['id'] ?>">

<?= htmlspecialchars($marca['nome']) ?>

</option>

<?php } ?>

</select>

<label>SKU</label>

<input
type="text"
name="sku">

<label>Código de Barras</label>

<input
type="text"
name="codigo_barras">

<label>Preço</label>

<input
type="number"
step="0.01"
name="preco"
required>

<label>Preço Promocional</label>

<input
type="number"
step="0.01"
name="preco_promocional">

<label>Descrição Curta</label>

<textarea
name="descricao_curta"></textarea>

<label>Descrição Completa</label>

<textarea
name="descricao"></textarea>

<label>Status</label>

<select
name="ativo">

<option value="1">Ativo</option>

<option value="0">Inativo</option>

</select>

<br>

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

</form>

</div>

</div>

</div>

</body>

</html>