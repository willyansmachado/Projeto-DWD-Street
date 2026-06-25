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
            if ($usuario["nivel"] == "admin") {
                header("Location: admin/admiin.php");
            } else {
                header("Location: index.php");
            }
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        /* Configurações Globais / Tema Claro */
        :root {
            --bg-body: #f4f4f6;
            --bg-card: #ffffff;
            --text-main: #111111;
            --text-muted: #666666;
            --border-color: #dddddd;
            --input-bg: #f9f9fb;
            --brand-color: #e31e24;
            --google-bg: #ffffff;
            --google-text: #3c4043;
            --google-border: #dadce0;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        /* Tema Escuro (Ativado via Classe) */
        body.dark-mode {
            --bg-body: #0b0b0c;
            --bg-card: #141416;
            --text-main: #ffffff;
            --text-muted: #aaaaaa;
            --border-color: #2a2a2e;
            --input-bg: #1a1a1e;
            --google-bg: #1a1a1e;
            --google-text: #e8eaed;
            --google-border: #3c4043;
            --shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body.auth-body {
    background-color: var(--bg-body);
    color: var(--text-main);

    display: flex;
    flex-direction: column;

    justify-content: center;
    align-items: center;

    min-height: 100vh;

    padding: 30px 20px;
}
        .auth-container {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 45px 35px;
margin-top:90px;
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .auth-container h2{

font-size:2rem;

font-weight:800;

margin-bottom:8px;

text-align:center;

}
.login-text{

text-align:center;

color:var(--text-muted);

font-size:15px;

line-height:24px;

margin-bottom:35px;

}

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .input-group {
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-group label {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
        }

        .auth-input {
            width: 100%;
            padding: 14px 16px;
            background-color: var(--input-bg);
            border: 2px solid var(--border-color);
            color: var(--text-main);
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            outline: none;
        }

        .auth-input:focus {
            border-color: var(--brand-color);
        }

        .auth-btn {
            width: 100%;
            padding: 15px;
            background-color: var(--text-main);
            color: var(--bg-card);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .auth-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        /* Divisor "OU" */
        .auth-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 22px 0;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border-color);
        }

        .auth-divider:not(:empty)::before {
            margin-right: .75em;
        }

        .auth-divider:not(:empty)::after {
            margin-left: .75em;
        }

        /* Botão do Google */
        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            padding: 14px;
            background-color: var(--google-bg);
            color: var(--google-text);
            border: 1px solid var(--google-border);
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .google-btn:hover {
            background-color: var(--input-bg);
            border-color: var(--text-muted);
        }

        .google-icon {
            width: 18px;
            height: 18px;
        }

        .auth-link {
            margin-top: 25px;
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .auth-link a {
            color: var(--brand-color);
            text-decoration: none;
            font-weight: 700;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }

        /* Botão Flutuante do Tema */
        .theme-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background-color: var(--bg-card);
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: var(--shadow);
            z-index: 1000;
        }

        .theme-toggle:hover {
            transform: scale(1.05);
        }
        /* ================= LOGIN ================= */
        .login-logo{
    font-size:2.6rem;
    font-weight:900;
    letter-spacing:-2px;
    color:var(--text-main);
    margin-bottom:18px;
    text-align:center;
}

.login-logo span{
    color:var(--brand-color);
}

.auth-container{
    background: var(--bg-card);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    width: 100%;
    max-width: 430px;
    padding: 40px;
    box-shadow: var(--shadow);
    text-align: center;
}

.login-title{
    font-size: 1.35rem;
    font-weight: 700;
    line-height: 1.5;
    margin-bottom: 30px;
    color: var(--text-main);
}

.auth-form{
    display:flex;
    flex-direction:column;
    gap:18px;
}

.input-group{
    display:flex;
    flex-direction:column;
    align-items:flex-start;
}

.input-group label{
    font-size:.85rem;
    font-weight:700;
    margin-bottom:8px;
    color:var(--text-muted);
    text-transform:uppercase;
}

.auth-input{
    width:100%;
    height:55px;
    padding:0 18px;
    border:2px solid var(--border-color);
    background:var(--input-bg);
    color:var(--text-main);
    border-radius:10px;
    font-size:15px;
}

.auth-input:focus{
    border-color:var(--brand-color);
}

.senha-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    width:100%;
    margin-top:4px;
    margin-bottom:-10px;
}

.senha-header label{
    font-size:.85rem;
    font-weight:700;
    color:var(--text-muted);
    text-transform:uppercase;
}

.senha-header a{
    color:var(--brand-color);
    font-size:.82rem;
    text-decoration:none;
}

.auth-btn{
    margin-top:10px;
    height:55px;
    border:none;
    border-radius:10px;
    background:#fff;
    color:#111;
    font-weight:700;
    font-size:1rem;
    cursor:pointer;
    transition:.3s;
}

.auth-btn:hover{
    background:var(--brand-color);
    color:#fff;
}
    </style>
</head>
<body class="auth-body">

<div class="login-logo">
    DWD<span>STREET</span>
</div>

<div class="auth-container">

    <p class="login-text">
        Olá, para continuar, digite seu e-mail e senha.
    </p>
        
    <form class="auth-form" action="login.php" method="POST">

<div class="input-group">
    <label>E-mail</label>
    <input
        type="email"
        name="email"
        class="auth-input"
        placeholder="seu@email.com"
        required
        autocomplete="email">
</div>

<div class="senha-header">

    <label>Senha</label>

    <a href="recuperar_senha.php">
        Esqueceu a senha?
    </a>

</div>

<div class="input-group">

    <input
        type="password"
        name="senha"
        class="auth-input"
        placeholder="********"
        required
        autocomplete="current-password">

</div>

<button type="submit" class="auth-btn">
    Entrar
</button>

</form>

        <div class="auth-divider">ou</div>

        <a href="google-auth.php" class="google-btn">
            <svg class="google-icon" viewBox="0 0 24 24" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            Continuar com o Google
        </a>
        
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