<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

if(!isset($_GET['id'])){
    header("Location:index.php");
    exit();
}

$id = (int)$_GET['id'];

$sql = "SELECT * FROM usuarios WHERE id=?";

$stmt = mysqli_prepare($conn,$sql);

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado)==0){
    die("Cliente não encontrado.");
}

$cliente = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Editar Cliente</title>

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

<h1>Editar Cliente</h1>

<a href="index.php" class="btnVoltar">

<i class="fa-solid fa-arrow-left"></i>

Voltar

</a>

</div>

<form
action="atualizar.php"
method="POST"
class="formulario">

<input
type="hidden"
name="id"
value="<?= $cliente['id']; ?>">

<div class="grupo">

<label>Nome</label>

<input
type="text"
name="nome"
value="<?= htmlspecialchars($cliente['nome']); ?>"
required>

</div>

<div class="grupo">

<label>Sobrenome</label>

<input
type="text"
name="sobrenome"
value="<?= htmlspecialchars($cliente['sobrenome']); ?>"
required>

</div>

<div class="grupo">

<label>Email</label>

<input
type="email"
name="email"
value="<?= htmlspecialchars($cliente['email']); ?>"
required>

</div>

<div class="grupo">

<label>CPF</label>

<input
type="text"
name="cpf"
value="<?= htmlspecialchars($cliente['cpf']); ?>"
required>

</div>

<div class="grupo">

<label>Nível</label>

<select name="nivel">

<option value="cliente"
<?= $cliente['nivel']=="cliente" ? "selected" : ""; ?>>

Cliente

</option>

<option value="admin"
<?= $cliente['nivel']=="admin" ? "selected" : ""; ?>>

Administrador

</option>

</select>

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

</body>

</html>