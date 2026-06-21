<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "dwd_street";

$conn = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

?>