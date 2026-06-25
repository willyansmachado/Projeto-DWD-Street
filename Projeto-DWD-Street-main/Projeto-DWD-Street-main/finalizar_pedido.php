<?php
session_start();
include("config/conexao.php");

if(!isset($_SESSION["id"])){
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["id"];

$cep = $_POST["cep"] ?? "";
$numero = $_POST["numero"] ?? "";
$endereco = $_POST["endereco"] ?? "";
$bairro = $_POST["bairro"] ?? "";
$pagamento = $_POST["payment"] ?? "";

// Busca produtos do carrinho
$sqlCarrinho = "SELECT * FROM carrinho WHERE usuario_id = ?";
$stmt = $conn->prepare($sqlCarrinho);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$carrinho = $stmt->get_result();

$total = 0;

while($item = $carrinho->fetch_assoc()){
    $total += ($item["preco"] * $item["quantidade"]);
}

$frete = 0;

$codigo_rastreio = "DWD" . rand(100000,999999);

// Salva pedido
$sqlPedido = "INSERT INTO pedidos
(
usuario_id,
codigo_rastreio,
cep,
numero,
endereco,
bairro,
forma_pagamento,
subtotal,
frete,
total
)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmtPedido = $conn->prepare($sqlPedido);

$stmtPedido->bind_param(
    "issssssddd",
    $usuario_id,
    $codigo_rastreio,
    $cep,
    $numero,
    $endereco,
    $bairro,
    $pagamento,
    $total,
    $frete,
    $total
);

if(!$stmtPedido->execute()){
    die("ERRO PEDIDO: " . $stmtPedido->error);
}

$pedido_id = $conn->insert_id;

// Busca novamente os itens do carrinho
$stmt = $conn->prepare($sqlCarrinho);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$carrinho = $stmt->get_result();

// Salva itens do pedido
while($item = $carrinho->fetch_assoc()){

    $sqlItem = "INSERT INTO itens_pedido
    (
    pedido_id,
    produto_nome,
    preco,
    quantidade
    )
    VALUES (?, ?, ?, ?)";

    $stmtItem = $conn->prepare($sqlItem);

    $stmtItem->bind_param(
        "isdi",
        $pedido_id,
        $item["produto_nome"],
        $item["preco"],
        $item["quantidade"]
    );

    if(!$stmtItem->execute()){
        die("ERRO ITEM: " . $stmtItem->error);
    }
}

// Limpa carrinho
$sqlLimpar = "DELETE FROM carrinho WHERE usuario_id = ?";
$stmtLimpar = $conn->prepare($sqlLimpar);
$stmtLimpar->bind_param("i", $usuario_id);
$stmtLimpar->execute();

// Redireciona
echo "
<script>
alert('Pedido realizado com sucesso!');
window.location='index.php';
</script>
";
?>