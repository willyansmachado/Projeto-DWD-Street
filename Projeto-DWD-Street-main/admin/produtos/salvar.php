<?php
session_start();

include("../../config/conexao.php");
include("../includes/verifica_login.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}

$nome = trim($_POST["nome"]);
$categoria_id = (int)$_POST["categoria_id"];

$marca_id = !empty($_POST["marca_id"])
    ? (int)$_POST["marca_id"]
    : NULL;

$sku = trim($_POST["sku"]);
$codigo_barras = trim($_POST["codigo_barras"]);

$preco = str_replace(",", ".", $_POST["preco"]);

$preco_promocional = $_POST["preco_promocional"] != ""
    ? str_replace(",", ".", $_POST["preco_promocional"])
    : NULL;

$descricao_curta = trim($_POST["descricao_curta"]);
$descricao = trim($_POST["descricao"]);

$ativo = (int)$_POST["ativo"];

/* GERAR SLUG */

$slug = strtolower($nome);

$slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);

$slug = trim($slug, '-');

/* SQL */

$sql = "INSERT INTO produtos
(
categoria_id,
marca_id,
nome,
slug,
descricao,
descricao_curta,
sku,
codigo_barras,
preco,
preco_promocional,
ativo
)

VALUES
(
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?
)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "iissssssddi",
    $categoria_id,
    $marca_id,
    $nome,
    $slug,
    $descricao,
    $descricao_curta,
    $sku,
    $codigo_barras,
    $preco,
    $preco_promocional,
    $ativo
);

if (mysqli_stmt_execute($stmt)) {

    header("Location: index.php");

} else {

    echo "Erro ao salvar: " . mysqli_error($conn);

}