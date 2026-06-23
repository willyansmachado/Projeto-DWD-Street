<?php

include("../../config/conexao.php");
include("../includes/verifica_login.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location:index.php");
    exit();
}

$id = (int)$_POST['id'];

$nome = trim($_POST['nome']);
$sobrenome = trim($_POST['sobrenome']);
$email = trim($_POST['email']);
$cpf = trim($_POST['cpf']);
$nivel = $_POST['nivel'];

$sql = "UPDATE usuarios
        SET
            nome=?,
            sobrenome=?,
            email=?,
            cpf=?,
            nivel=?
        WHERE id=?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssssi",
    $nome,
    $sobrenome,
    $email,
    $cpf,
    $nivel,
    $id
);

if (mysqli_stmt_execute($stmt)) {

    header("Location:index.php?sucesso=1");
    exit();

} else {

    echo "Erro ao atualizar cliente.";

}