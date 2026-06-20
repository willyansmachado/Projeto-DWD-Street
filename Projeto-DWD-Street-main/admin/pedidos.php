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

$sql = "SELECT * FROM pedidos
ORDER BY id DESC";

$resultado = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html>
<<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pedidos | DWD Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#0f0f0f;
    color:white;
    font-family:'Montserrat',sans-serif;
}

.container{
    width:95%;
    max-width:1400px;
    margin:auto;
    padding:30px;
}

h1{
    text-align:center;
    margin-bottom:30px;
    font-size:40px;
    font-weight:900;
}

h1 span{
    color:#e31e24;
}

.btn-voltar{
    display:inline-block;
    margin-bottom:20px;
    background:#1f1f1f;
    color:white;
    text-decoration:none;
    padding:12px 18px;
    border-radius:8px;
}

.btn-voltar:hover{
    background:#333;
}

.table-box{
    background:#1a1a1a;
    border-radius:15px;
    overflow:hidden;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#e31e24;
}

th{
    padding:16px;
    text-align:left;
}

td{
    padding:16px;
    border-bottom:1px solid #2c2c2c;
}

tr:hover{
    background:#222;
}

.status{
    padding:8px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:bold;
    display:inline-block;
}

.recebido{
    background:#0056b3;
}

.aprovado{
    background:#28a745;
}

.transporte{
    background:#ff9800;
}

.entregue{
    background:#8e44ad;
}

select{
    background:#2a2a2a;
    color:white;
    border:none;
    padding:10px;
    border-radius:8px;
}

button{
    background:#e31e24;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:8px;
    cursor:pointer;
    margin-left:5px;
    font-weight:bold;
}

button:hover{
    background:#c9171d;
}

</style>
</head>
<body>

<div class="container">

<a href="index.php" class="btn-voltar">
← Voltar ao Painel
</a>

<h1>🛒 <span>Pedidos</span></h1>

<div class="table-box">

<table>

<thead>
<tr>
<th>ID</th>
<th>Rastreio</th>
<th>Total</th>
<th>Status</th>
<th>Ação</th>
</tr>
</thead>

<tbody>

<?php while($pedido = mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td>#<?php echo $pedido["id"]; ?></td>

<td>
<?php echo $pedido["codigo_rastreio"]; ?>
</td>

<td>
R$ <?php echo number_format($pedido["total"],2,",","."); ?>
</td>

<td>

<?php

$classe = "recebido";

if($pedido["status_pedido"] == "Pagamento Aprovado"){
    $classe = "aprovado";
}

if($pedido["status_pedido"] == "Produto em Transporte"){
    $classe = "transporte";
}

if($pedido["status_pedido"] == "Entrega Concluída"){
    $classe = "entregue";
}

?>

<span class="status <?php echo $classe; ?>">
<?php echo $pedido["status_pedido"]; ?>
</span>

</td>

<td>

<form action="alterar_status.php" method="POST">

<input
type="hidden"
name="pedido"
value="<?php echo $pedido["id"]; ?>"
>

<select name="status">

<option>Pedido Recebido</option>
<option>Pagamento Aprovado</option>
<option>Produto em Transporte</option>
<option>Entrega Concluída</option>

</select>

<button>
Salvar
</button>

</form>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>
</html>