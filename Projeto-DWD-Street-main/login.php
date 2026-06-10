<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("config/conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario["senha"])) {

            $_SESSION["id"] = $usuario["id"];
            $_SESSION["nome"] = $usuario["nome"];
            $_SESSION["email"] = $usuario["email"];
            $_SESSION["nivel"] = $usuario["nivel"];

            header("Location: index.php");
            exit();

        } else {

            echo "<script>
                    alert('Senha incorreta!');
                    window.location='login.php';
                  </script>";
        }

    } else {

        echo "<script>
                alert('Usuário não encontrado!');
                window.location='login.php';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | DWD Street</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="auth-body">

    <div class="auth-container">
        <h1 style="font-weight: 900; margin-bottom: 20px;">DWD<span style="color: #e31e24;">STREET</span></h1>
        <h2>Entrar na Conta</h2>
        
        <form class="auth-form" action="login.php" method="POST">
            <input type="email" name="email" placeholder="Seu e-mail" class="auth-input" required>
            <input type="password" name="senha" placeholder="Sua senha" class="auth-input" required>
            <button type="submit" class="auth-btn">Entrar</button>
        </form>
        
        <div class="auth-link">
            Não tem uma conta? <a href="cadastro.php">Crie aqui</a>
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