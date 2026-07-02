<?php
include("../config/conexao.php");
include("includes/verificar_login.php");

$sql = "SELECT pedidos.*, usuarios.nome AS nome_cliente 
        FROM pedidos 
        INNER JOIN usuarios ON pedidos.usuario_id = usuarios.id 
        ORDER BY pedidos.id DESC";
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedidos | DWD Street</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body>
<div class="container">
    <?php include("includes/menu.php"); ?>
    
    <div class="main">
        <?php include("includes/topbar.php"); ?>
        
        <div class="conteudo">
            <div class="header-pagina" style="margin-bottom: 20px;">
                <h1>Pedidos</h1>
            </div>

            <div class="box">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>CLIENTE</th>
                        <th>TOTAL</th>
                        <th>STATUS</th>
                        <th>AÇÕES</th>
                    </tr>
                    <?php while($pedido = mysqli_fetch_assoc($resultado)){ ?>
                    <tr>
                        <td><?= $pedido['id']; ?></td>
                        <td><?= $pedido['nome_cliente']; ?></td>
                        <td>R$ <?= number_format($pedido['total'], 2, ",", "."); ?></td>
                        <td><?= $pedido['status']; ?></td>
                        <td>
                            <a href="ver_pedido.php?id=<?= $pedido['id']; ?>" class="btn-editar" style="background-color: #6c757d;">Ver</a>
                            <a href="editar_pedido.php?id=<?= $pedido['id']; ?>" class="btn-editar">Atualizar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>