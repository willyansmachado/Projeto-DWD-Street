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
        ( '$nome','$sobrenome','$cpf','$email','$senha')";

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

        /* Tema Escuro */
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
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .auth-container {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 40px 35px;
            border-radius: 16px;
            width: 100%;
            max-width: 480px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .auth-container h2 {
            font-size: 1.6rem;
            font-weight: 900;
            margin-bottom: 25px;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .auth-row {
            display: flex;
            gap: 14px;
            width: 100%;
        }

        .auth-row .input-group {
            flex: 1;
        }

        .input-group {
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .input-group label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
        }

        .auth-input {
            width: 100%;
            padding: 13px 16px;
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
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            margin: 20px 0;
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

        .auth-divider:not(:empty)::before { margin-right: .75em; }
        .auth-divider:not(:empty)::after { margin-left: .75em; }

        /* Botão Google */
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

        /* Botão Flutuante de Tema */
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

        .theme-toggle:hover { transform: scale(1.05); }

        /* Alerta PHP do sistema (Incorreto/Erro) */
        .php-alert {
            background-color: rgba(227, 30, 36, 0.1);
            border: 1px solid var(--brand-color);
            color: var(--brand-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }
    </style>
</head>
<body class="auth-body">

    <div class="auth-container">
        <h2>Criar Conta</h2>
        
        <?php if (!empty($mensagem) && !$sucesso): ?>
            <div class="php-alert"><?= $mensagem ?></div>
        <?php endif; ?>
        
        <form method="POST" class="auth-form">
            <div class="auth-row">
                <div class="input-group">
                    <label>Nome</label>
                    <input type="text" name="nome" placeholder="Ex: João" class="auth-input" required>
                </div>
                <div class="input-group">
                    <label>Sobrenome</label>
                    <input type="text" name="sobrenome" placeholder="Ex: Silva" class="auth-input" required>
                </div>
            </div>

            <div class="input-group">
                <label>CPF</label>
                <input type="text" name="cpf" placeholder="000.000.000-00" class="auth-input" required>
            </div>

            <div class="input-group">
                <label>E-mail</label>
                <input type="email" name="email" placeholder="seu@melhoremail.com" class="auth-input" required>
            </div>

            <div class="input-group">
                <label>Senha</label>
                <input type="password" name="senha" placeholder="Crie uma senha forte" class="auth-input" required>
            </div>

            <div class="input-group">
                <label>Confirmar Senha</label>
                <input type="password" placeholder="Repita a senha criada" class="auth-input" required>
            </div>

            <button type="submit" class="auth-btn">Cadastrar e Continuar</button>
        </form>
        
        <div class="auth-divider">ou</div>

        <a href="google_auth.php" class="google-btn">
            <svg class="google-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            Inscrever-se com o Google
        </a>

        <div class="auth-link">
            Já tem conta? <a href="login.php">Faça login</a>
        </div>
    </div>

    <button id="theme-toggle" class="theme-toggle">🌙</button>

    <script>
        // MODO ESCURO - PERSISTÊNCIA IMEDIATA
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }

        const themeToggleBtn = document.getElementById('theme-toggle');
        const body = document.body;

        if (themeToggleBtn) {
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
        #success-overlay {
            position: fixed;
            inset: 0;
            z-index: 999999;
            display: flex;
            justify-content: center;
            align-items: center;
            background: radial-gradient(circle at top left, rgba(227,30,36,.25), transparent 30%), radial-gradient(circle at bottom right, rgba(227,30,36,.15), transparent 30%), rgba(0,0,0,.95);
            backdrop-filter: blur(18px);
            animation: fadeIn .7s ease;
        }
        .success-card { text-align: center; animation: zoomIn 1s cubic-bezier(.17,.89,.32,1.49); }
        .logo-success { font-size: 70px; font-weight: 900; letter-spacing: 4px; margin-bottom: 25px; color: #fff; animation: glowLogo 2s infinite alternate; }
        .logo-success span { color: #e31e24; }
        .success-check { width: 140px; height: 140px; margin: auto; border-radius: 50%; border: 4px solid #22c55e; display: flex; justify-content: center; align-items: center; color: #22c55e; font-size: 70px; animation: pop .8s ease, pulse 2s infinite; }
        .success-card h1 { margin-top: 30px; font-size: 48px; font-weight: 900; color: #fff; }
        .success-card p { margin-top: 15px; color: #aaa; font-size: 18px; }
        .loading-line { width: 400px; max-width: 90vw; height: 6px; background: #222; border-radius: 999px; overflow: hidden; margin-top: 35px; }
        .loading-fill { height: 100%; width: 0%; background: linear-gradient(90deg, #e31e24, #ff4d4d, #e31e24); animation: loadBar 3.5s linear forwards; }
        @keyframes loadBar { to { width: 100%; } }
        @keyframes zoomIn { from { opacity: 0; transform: scale(.7); } to { opacity: 1; transform: scale(1); } }
        @keyframes glowLogo { from { text-shadow: 0 0 10px rgba(227,30,36,.3), 0 0 20px rgba(227,30,36,.3); } to { text-shadow: 0 0 25px rgba(227,30,36,.8), 0 0 60px rgba(227,30,36,.8); } }
        @keyframes pulse { 50% { transform: scale(1.08); } }
        @keyframes pop { from { transform: scale(0); } to { transform: scale(1); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>

    <div id="success-overlay">
        <div class="success-card">
            <div class="logo-success">DWD<span>STREET</span></div>
            <div class="success-check">✓</div>
            <h1>Conta criada!</h1>
            <p>Bem-vindo à nova geração do streetwear.</p>
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

</body>
</html>