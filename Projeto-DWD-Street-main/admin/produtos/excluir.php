<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

/*
|--------------------------------------------------------------------------
| BUSCA A IMAGEM
|--------------------------------------------------------------------------
*/

$sql = "SELECT imagem FROM produtos WHERE id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) == 0) {

    header("Location: index.php");
    exit();

}

$produto = mysqli_fetch_assoc($resultado);

/*
|--------------------------------------------------------------------------
| REMOVE A IMAGEM
|--------------------------------------------------------------------------
*/

if (!empty($produto['imagem'])) {

    $arquivo = "../../" . $produto['imagem'];

    if (file_exists($arquivo)) {

        unlink($arquivo);

    }

}

/*
|--------------------------------------------------------------------------
| REMOVE DO BANCO
|--------------------------------------------------------------------------
*/

$sql = "DELETE FROM produtos WHERE id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    header("Location: index.php?excluido=1");
    exit();

} else {

    echo "Erro ao excluir produto.";

}