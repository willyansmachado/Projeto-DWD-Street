<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "dwd_street",
    3306
);

if (!$conn) {
    die("Erro: " . mysqli_connect_error());
}