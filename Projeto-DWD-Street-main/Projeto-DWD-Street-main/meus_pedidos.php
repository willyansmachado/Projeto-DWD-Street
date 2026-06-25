<?php
session_start();
include("config/conexao.php");

if(!isset($_SESSION["id"])){
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["id"];

$sql = "SELECT * FROM pedidos
        WHERE usuario_id = ?
        ORDER BY data_pedido DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Meus Pedidos | DWD Street</title>

<link rel="stylesheet" href="assets/css/style.css">

<style>
body{
    background:#111;
    color:#fff;
    font-family:'Montserrat',sans-serif;
    margin:0;
}

.container{
    width:95%;
    max-width:1200px;
    margin:40px auto;
}

.titulo{
    text-align:center;
    font-size:2rem;
    margin-bottom:30px;
    font-weight:900;
}

.titulo span{
    color:#e31e24;
}

.voltar{
    color:#fff;
    text-decoration:none;
    margin-bottom:20px;
    display:inline-block;
}

.tabela{
    width:100%;
    border-collapse:collapse;
    background:#1b1b1b;
    border-radius:10px;
    overflow:hidden;
}

.tabela th{
    background:#e31e24;
    color:#fff;
    padding:15px;
}

.tabela td{
    padding:15px;
    border-bottom:1px solid #333;
    color:#fff;
}

.tabela tr:hover{
    background:#252525;
}

.btn-rastrear{
    background:#e31e24;
    color:white;
    text-decoration:none;
    padding:8px 15px;
    border-radius:6px;
    font-weight:700;
}

.btn-rastrear:hover{
    background:#b9161b;
}
</style>

</head>
<body>

<div class="container">

    <h1 class="titulo">
    MEUS <span>PEDIDOS</span>
</h1>

    <br>

    <a href="index.php" class="voltar">
    ← Voltar para Loja
</a>

    <br><br>

    <table class="tabela">

        <tr>
            <th>Pedido</th>
            <th>Código</th>
            <th>Data</th>
            <th>Total</th>
            <th>Status</th>
            <th>Rastreio</th>
            <th>Ação</th>
        </tr>

        <?php
        if($resultado->num_rows > 0){

            while($pedido = $resultado->fetch_assoc()){
        ?>

        <tr>

            <td>
                <?php echo $pedido["id"]; ?>
            </td>

            <td>
                <?php echo $pedido["codigo_rastreio"]; ?>
            </td>

            <td>
                <?php echo date("d/m/Y H:i", strtotime($pedido["data_pedido"])); ?>
            </td>

            <td>
                R$ <?php echo number_format($pedido["total"],2,",","."); ?>
            </td>

            <td>
                <?php echo $pedido["status_pedido"]; ?>
            </td>

            <td>
                <a
                class="btn-rastrear"
                href="rastreio.php?codigo=<?php echo $pedido['codigo_rastreio']; ?>">
                Rastrear
                </a>
            </td>
            
            <td><a href="detalhes_pedido.php?id=<?php echo $pedido['id']; ?>"
class="btn-banner">
Ver Itens
</a>
</td>

        </tr>

        <?php
            }
        }else{
            echo "
            <tr>
                <td colspan='6'>
                    Nenhum pedido encontrado.
                </td>
            </tr>";
        }
        ?>

    </table>

</div>

</body>
</html>