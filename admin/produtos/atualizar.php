<?php
session_start();

include("../../config/conexao.php");
include("../includes/verifica_login.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit();
}

$id = (int)$_POST["id"];

$nome = trim($_POST["nome"]);
$categoria_id = (int)$_POST["categoria_id"];
$descricao = trim($_POST["descricao"]);
$preco = str_replace(",", ".", $_POST["preco"]);
$estoque = (int)$_POST["estoque"];

$imagem = $_POST["imagem_antiga"];

/* Upload da nova imagem */

if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {

    $pasta = "../../uploads/produtos/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $extensao = strtolower(pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION));

    $novoNome = uniqid() . "." . $extensao;

    move_uploaded_file($_FILES["imagem"]["tmp_name"], $pasta . $novoNome);

    if (!empty($_POST["imagem_antiga"])) {

        $arquivoAntigo = "../../" . $_POST["imagem_antiga"];

        if (file_exists($arquivoAntigo)) {
            unlink($arquivoAntigo);
        }

    }

    $imagem = "uploads/produtos/" . $novoNome;
}

/* Atualizar produto */

$sql = "UPDATE produtos SET

nome = ?,
categoria_id = ?,
descricao = ?,
preco = ?,
estoque = ?,
imagem = ?

WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sisdisi",
    $nome,
    $categoria_id,
    $descricao,
    $preco,
    $estoque,
    $imagem,
    $id
);

if (mysqli_stmt_execute($stmt)) {

    header("Location: index.php");
    exit();

} else {

    echo "Erro ao atualizar: " . mysqli_error($conn);

}
?>