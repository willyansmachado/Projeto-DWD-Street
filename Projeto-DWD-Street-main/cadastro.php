<?php


require_once "config/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $sobrenome = mysqli_real_escape_string($conn, $_POST["sobrenome"]);
    $cpf = mysqli_real_escape_string($conn, $_POST["cpf"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $verifica = mysqli_query(
        $conn,
        "SELECT id FROM usuarios WHERE email='$email' OR cpf='$cpf'"
    );

    if (mysqli_num_rows($verifica) > 0) {

        $mensagem = "Usuário já cadastrado!";

    } else {

        $sql = "INSERT INTO usuarios
        (nome,sobrenome,cpf,email,senha)
        VALUES
        ('$nome','$sobrenome','$cpf','$email','$senha')";

        if (mysqli_query($conn, $sql)) {

            $mensagem = "Cadastro realizado com sucesso!";

        } else {

            $mensagem = "Erro ao cadastrar.";

        }
    }
}
?><?php

require_once "config/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $sobrenome = mysqli_real_escape_string($conn, $_POST["sobrenome"]);
    $cpf = mysqli_real_escape_string($conn, $_POST["cpf"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $verifica = mysqli_query(
        $conn,
        "SELECT id FROM usuarios WHERE email='$email' OR cpf='$cpf'"
    );

    if (mysqli_num_rows($verifica) > 0) {

        $mensagem = "Usuário já cadastrado!";

    } else {

        $sql = "INSERT INTO usuarios
        (nome,sobrenome,cpf,email,senha)
        VALUES
        ('$nome','$sobrenome','$cpf','$email','$senha')";

        if (mysqli_query($conn, $sql)) {

            $mensagem = "Cadastro realizado com sucesso!";

        } else {

            $mensagem = "Erro ao cadastrar.";

        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta | DWD Street</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="auth-body">

    <div class="auth-container">
        <h2>Criar Conta</h2>
        
        <form method="POST" class="auth-form">
            <div class="auth-row">
                <input type="text" name="nome" placeholder="Nome" class="auth-input" required>
                <input type="text" name="sobrenome" placeholder="Sobrenome" class="auth-input" required>
            </div>
            <input type="text" name="cpf" placeholder="CPF" class="auth-input" required>
            <input type="email" name="email" placeholder="Seu melhor e-mail" class="auth-input" required>
            <input type="password" name="senha" placeholder="Crie uma senha" class="auth-input" required>
            <input type="password" placeholder="Confirme a senha" class="auth-input" required>
            <button type="submit" class="auth-btn">Cadastrar e Continuar</button>
        </form>
        
        <div class="auth-link">
            Já tem conta? <a href="login.php">Faça login</a>
        </div>
    </div>

    <button id="theme-toggle" class="theme-toggle">🌙</button>

    <script>
        // MODO ESCURO - VERIFICAÇÃO IMEDIATA (Faz o tema persistir entre as páginas)
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }

        const themeToggleBtn = document.getElementById('theme-toggle');
        const body = document.body;

        if (themeToggleBtn) {
            // Ajusta o emoji do botão se já iniciou em dark-mode
            if (body.classList.contains('dark-mode')) {
                themeToggleBtn.textContent = '☀️'; 
            }

            themeToggleBtn.addEventListener('click', () => {
                body.classList.toggle('dark-mode');
                
                if (body.classList.contains('dark-mode')) {
                    localStorage.setItem('theme', 'dark');
                    themeToggleBtn.textContent = '☀️';
                } else {
                    localStorage.setItem('theme', 'light');
                    themeToggleBtn.textContent = '🌙';
                }
            });
        }
    </script>
</body>
</html>