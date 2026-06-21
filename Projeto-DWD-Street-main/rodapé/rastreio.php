<?php
include("../config/conexao.php");

$pedido = null;

if(isset($_POST["codigo"])){

    $codigo = $_POST["codigo"];

    $sql = "SELECT * FROM pedidos
            WHERE codigo_rastreio = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0){
        $pedido = $resultado->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rastrear Pedido | DWD Street</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<section class="pagina-banner">
    <h1>ACOMPANHE SEU PEDIDO</h1>
    <p>Consulte o andamento da sua compra.</p>
</section>

<section class="pagina-interna">

    <h1>Acompanhe seu Pedido</h1>

    <p>
        Digite o código do seu pedido para acompanhar todas as etapas da entrega.
    </p>

    <form method="POST">

        <div class="rastreio-box">

            <input
                type="text"
                name="codigo"
                placeholder="Ex: DWD20260001"
                required
            >

            <button type="submit">
                Consultar Pedido
            </button>

        </div>

    </form>

<?php
if($pedido){

$status = $pedido["status_pedido"];
?>

<div class="pedido-status">

<h2>Status Atual</h2>

<div class="etapa <?php echo ($status=="Pedido Recebido" || $status=="Pagamento Aprovado" || $status=="Produto em Transporte" || $status=="Entregue") ? "concluida" : ""; ?>">
✓ Pedido Recebido
</div>

<div class="etapa <?php echo ($status=="Pagamento Aprovado" || $status=="Produto em Transporte" || $status=="Entregue") ? "concluida" : ""; ?>">
✓ Pagamento Aprovado
</div>

<div class="etapa <?php echo ($status=="Produto em Transporte") ? "ativa" : ""; ?> <?php echo ($status=="Entregue") ? "concluida" : ""; ?>">
🚚 Produto em Transporte
</div>

<div class="etapa <?php echo ($status=="Entregue") ? "ativa" : ""; ?>">
📦 Entrega Concluída
</div>

<div style="margin-top:20px;">

<p>
<strong>Código:</strong>
<?php echo $pedido["codigo_rastreio"]; ?>
</p>

<p>
<strong>Status:</strong>
<?php echo $pedido["status_pedido"]; ?>
</p>

<p>
<strong>Data:</strong>
<?php echo date("d/m/Y H:i", strtotime($pedido["data_pedido"])); ?>
</p>

</div>

</div>

<?php
}elseif(isset($_POST["codigo"])){
?>

<div class="pedido-status">
    <h2>Pedido não encontrado</h2>
</div>

<?php } ?>

</section>

</body>
</html>