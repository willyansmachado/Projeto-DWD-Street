<?php
session_start(); // Inicia a sessão logo de cara

if(!isset($_SESSION['nome'])) {
    // Se não tiver sessão (não estiver logado), manda pro login
    header("Location: ../login.php");
    exit;
}

if ($_SESSION["nivel"] != "admin") {
    header("Location: ../index.php");
    exit();
}