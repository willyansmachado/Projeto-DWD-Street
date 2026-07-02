<?php
session_start();
include("config/conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

// Verifica se o ID do produto no carrinho foi enviado pela URL
if (isset($_GET['id'])) {
    $id_carrinho = $_GET['id'];
    $usuario_id = $_SESSION["id"];

    // Deleta o item do carrinho garantindo que ele pertence ao usuário logado (segurança)
    $sql = "DELETE FROM carrinho WHERE id = ? AND usuario_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ii", $id_carrinho, $usuario_id);
        $stmt->execute();
    }
}

// Redireciona de volta para o carrinho
header("Location: carrinho.php");
exit();
?>