<?php
session_start();
include("config/conexao.php");

if(!isset($_SESSION["id"])){
    header("Location: login.php");
    exit();
}

include("config/conexao.php");

$pedido_id = $_GET["id"];

$sql = "SELECT * FROM itens_pedido
        WHERE pedido_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();

$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Detalhes do Pedido</title>

<style>

body{
    background:#111;
    color:white;
    font-family:Arial;
}

.container{
    width:90%;
    max-width:900px;
    margin:auto;
    margin-top:40px;
}

.item{
    background:#1c1c1c;
    padding:20px;
    border-radius:10px;
    margin-bottom:15px;
    border-left:4px solid #e31e24;
}

h1{
    color:#e31e24;
}

a{
    color:white;
    text-decoration:none;
}

.btn{
    background:#e31e24;
    padding:10px 20px;
    border-radius:5px;
    display:inline-block;
    margin-bottom:20px;
}

</style>
</head>
<body>

<div class="container">

<a href="meus_pedidos.php" class="btn">
← Voltar
</a>

<h1>Itens do Pedido</h1>

<?php while($item = $resultado->fetch_assoc()){ ?>

<div class="item">

<h3>
<?php echo $item["produto_nome"]; ?>
</h3>

<p>
Quantidade:
<strong><?php echo $item["quantidade"]; ?></strong>
</p>

<p>
Preço:
<strong>
R$ <?php echo number_format($item["preco"],2,",","."); ?>
</strong>
</p>

<p>
Subtotal:
<strong>
R$
<?php
echo number_format(
$item["preco"] * $item["quantidade"],
2,
",",
"."
);
?>
</strong>
</p>

</div>

<?php } ?>

</div>

</body>
</html>