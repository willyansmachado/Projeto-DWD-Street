<?php

require_once "config/conexao.php";

$mensagem = "";
$sucesso = false;

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
            $sucesso = true;

        } else {

            $mensagem = "Erro ao cadastrar: " . mysqli_error($conn);

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
 <?php if($sucesso): ?>

<style>

#success-overlay{
    position:fixed;
    inset:0;
    z-index:999999;

    display:flex;
    justify-content:center;
    align-items:center;

    background:
    radial-gradient(circle at top left,
    rgba(227,30,36,.25),
    transparent 30%),

    radial-gradient(circle at bottom right,
    rgba(227,30,36,.15),
    transparent 30%),

    rgba(0,0,0,.95);

    backdrop-filter:blur(18px);

    animation:fadeIn .7s ease;
}

.success-card{
    text-align:center;
    animation:zoomIn 1s cubic-bezier(.17,.89,.32,1.49);
}

.logo-success{
    font-size:70px;
    font-weight:900;
    letter-spacing:4px;
    margin-bottom:25px;
    animation:glowLogo 2s infinite alternate;
}

.logo-success span{
    color:#e31e24;
}

.success-check{
    width:140px;
    height:140px;
    margin:auto;

    border-radius:50%;
    border:4px solid #22c55e;

    display:flex;
    justify-content:center;
    align-items:center;

    color:#22c55e;
    font-size:70px;

    animation:
    pop .8s ease,
    pulse 2s infinite;
}

.success-card h1{
    margin-top:30px;
    font-size:48px;
    font-weight:900;
}

.success-card p{
    margin-top:15px;
    color:#aaa;
    font-size:18px;
}

.loading-line{
    width:400px;
    max-width:90vw;

    height:6px;
    background:#222;

    border-radius:999px;
    overflow:hidden;

    margin-top:35px;
}

.loading-fill{
    height:100%;
    width:0%;

    background:linear-gradient(
        90deg,
        #e31e24,
        #ff4d4d,
        #e31e24
    );

    animation:loadBar 3.5s linear forwards;
}

@keyframes loadBar{
    to{width:100%;}
}

@keyframes zoomIn{
    from{
        opacity:0;
        transform:scale(.7);
    }
    to{
        opacity:1;
        transform:scale(1);
    }
}

@keyframes glowLogo{
    from{
        text-shadow:
        0 0 10px rgba(227,30,36,.3),
        0 0 20px rgba(227,30,36,.3);
    }
    to{
        text-shadow:
        0 0 25px rgba(227,30,36,.8),
        0 0 60px rgba(227,30,36,.8);
    }
}

@keyframes pulse{
    50%{
        transform:scale(1.08);
    }
}

@keyframes pop{
    from{
        transform:scale(0);
    }
    to{
        transform:scale(1);
    }
}

@keyframes fadeIn{
    from{opacity:0;}
    to{opacity:1;}
}

</style>

<div id="success-overlay">

    <div class="success-card">

        <div class="logo-success">
            DWD<span>STREET</span>
        </div>

        <div class="success-check">
            ✓
        </div>

        <h1>Conta criada!</h1>

        <p>
            Bem-vindo à nova geração do streetwear.
        </p>

        <div class="loading-line">
            <div class="loading-fill"></div>
        </div>

    </div>

</div>

<script>
setTimeout(() => {
    window.location.href = "index.php";
}, 3500);
</script>

<?php endif; ?>
</script>


</body>
</html>