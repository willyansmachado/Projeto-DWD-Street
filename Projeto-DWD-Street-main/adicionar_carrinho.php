<?php
session_start();
include("config/conexao.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["id"];

if (!isset($_POST["produto_nome"]) || !isset($_POST["preco"]) || !isset($_POST["imagem"])) {
    die("Erro: Dados do produto não foram enviados corretamente pelo formulário.");
}

$produto_nome = $_POST["produto_nome"];
$preco = str_replace(',', '.', $_POST["preco"]); 
$imagem = $_POST["imagem"];

// --- NOVA LÓGICA: Busca o peso do produto real na tabela de produtos ---
// (Estou assumindo que você busca pelo nome do produto, baseado no seu formulário)
$peso_produto = 0.300; // Valor padrão de segurança
$sql_peso = "SELECT peso FROM produtos WHERE nome = ? LIMIT 1";
$stmt_peso = $conn->prepare($sql_peso);
if ($stmt_peso) {
    $stmt_peso->bind_param("s", $produto_nome);
    $stmt_peso->execute();
    $res_peso = $stmt_peso->get_result();
    if ($row_peso = $res_peso->fetch_assoc()) {
        $peso_produto = $row_peso['peso'];
    }
}
// ---------------------------------------------------------------------

// 1. Verifica se esse produto já está no carrinho do usuário
$sql_check = "SELECT id, quantidade FROM carrinho WHERE usuario_id = ? AND produto_nome = ?";
$stmt_check = $conn->prepare($sql_check);

if (!$stmt_check) {
    die("Erro no banco de dados (Select): " . $conn->error);
}

$stmt_check->bind_param("is", $usuario_id, $produto_nome);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // 2A. O produto já existe! Vamos apenas somar +1 na quantidade
    $row = $result_check->fetch_assoc();
    $nova_quantidade = $row['quantidade'] + 1;
    $carrinho_id = $row['id'];

    $sql_update = "UPDATE carrinho SET quantidade = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $nova_quantidade, $carrinho_id);
    $stmt_update->execute();

} else {
    // 2B. O produto não existe no carrinho. Vamos inserir uma nova linha incluindo o PESO.
    $sql_insert = "INSERT INTO carrinho (usuario_id, produto_nome, preco, imagem, quantidade, peso) VALUES (?, ?, ?, ?, 1, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    
    if (!$stmt_insert) {
        die("Erro no banco de dados (Insert): " . $conn->error);
    }

    $stmt_insert->bind_param("isdsd", $usuario_id, $produto_nome, $preco, $imagem, $peso_produto);
    $stmt_insert->execute();
}

header("Location: carrinho.php");
exit();
?>