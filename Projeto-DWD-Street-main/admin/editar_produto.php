<?php
session_start();

if(
    !isset($_SESSION["nivel"])
    ||
    $_SESSION["nivel"] != "admin"
){
    die("Acesso negado");
}

include("../config/conexao.php");

$id = $_GET["id"];

$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);
$stmt->execute();

$produto = $stmt->get_result()->fetch_assoc();

if(isset($_POST["salvar"])){

    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];
    $preco = $_POST["preco"];
    $estoque = $_POST["estoque"];
    $categoria = $_POST["categoria"];

    $sql = "UPDATE produtos SET
    nome=?,
    descricao=?,
    preco=?,
    estoque=?,
    categoria=?
    WHERE id=?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssdisi",
        $nome,
        $descricao,
        $preco,
        $estoque,
        $categoria,
        $id
    );

    $stmt->execute();

    header("Location: produtos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Produto | DWD Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#0f0f0f;
    font-family:'Montserrat',sans-serif;
    color:white;
}

.container{
    max-width:800px;
    margin:50px auto;
    padding:30px;
}

.card{
    background:#1a1a1a;
    padding:30px;
    border-radius:15px;
}

h1{
    text-align:center;
    margin-bottom:25px;
    font-size:35px;
    font-weight:900;
}

span{
    color:#e31e24;
}

label{
    display:block;
    margin-bottom:8px;
    font-weight:700;
}

input,
textarea{
    width:100%;
    padding:14px;
    border:none;
    border-radius:8px;
    background:#2a2a2a;
    color:white;
    margin-bottom:20px;
}

textarea{
    min-height:120px;
    resize:vertical;
}

.btn{
    width:100%;
    padding:15px;
    background:#e31e24;
    color:white;
    border:none;
    border-radius:8px;
    font-weight:700;
    cursor:pointer;
}

.btn:hover{
    background:#c9171d;
}

.voltar{
    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;
    color:white;
    background:#252525;
    padding:10px 15px;
    border-radius:8px;
}

.voltar:hover{
    background:#333;
}

</style>
</head>
<body>

<div class="container">

<a href="produtos.php" class="voltar">
← Voltar
</a>

<div class="card">

<h1>✏️ Editar <span>Produto</span></h1>

<form method="POST">

<label>Nome do Produto</label>
<input
type="text"
name="nome"
value="<?php echo $produto['nome']; ?>"
required
>

<label>Descrição</label>
<textarea name="descricao" required><?php echo $produto['descricao']; ?></textarea>

<label>Preço</label>
<input
type="number"
step="0.01"
name="preco"
value="<?php echo $produto['preco']; ?>"
required
>

<label>Estoque</label>
<input
type="number"
name="estoque"
value="<?php echo $produto['estoque']; ?>"
required
>

<label>Categoria</label>
<input
type="text"
name="categoria"
value="<?php echo $produto['categoria']; ?>"
required
>

<button class="btn" name="salvar">
💾 Atualizar Produto
</button>

</form>

</div>

</div>

</body>
</html>