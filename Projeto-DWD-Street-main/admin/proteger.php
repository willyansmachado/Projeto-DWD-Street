<?php
session_start();

if(!isset($_SESSION["id"])){
    header("Location: ../login.php");
    exit();
}

if($_SESSION["nivel"] != "admin"){
    echo "
    <script>
    alert('Acesso negado!');
    window.location='../index.php';
    </script>
    ";
    exit();
}
?>