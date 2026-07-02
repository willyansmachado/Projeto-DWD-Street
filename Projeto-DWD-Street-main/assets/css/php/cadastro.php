<?php
// Configurações iniciais de tratamento de dados (Simulação de recebimento)
$mensagem = "";
$tipo_mensagem = ""; // 'sucesso' ou 'erro'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário de forma segura
    $nome = strip_tags(trim($_POST['nome']));
    $sobrenome = strip_tags(trim($_POST['sobrenome']));
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']); // Remove tudo que não for número do CPF
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    $confirme_senha = $_POST['confirme_senha'];

    // Validações básicas antes de enviar pro banco
    if (empty($nome) || empty($sobrenome) || empty($cpf) || empty($email) || empty($senha)) {
        $mensagem = "Preencha todos os campos obrigatórios.";
        $tipo_mensagem = "erro";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "E-mail inválido.";
        $tipo_mensagem = "erro";
    } elseif ($senha !== $confirme_senha) {
        $mensagem = "As senhas não coincidem.";
        $tipo_mensagem = "erro";
    } else {
        // --- SEU CODIGO DE BANCO DE DADOS ENTRA AQUI (Exemplo com PDO) ---
        // $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);
        // $stmt = $pdo->prepare("INSERT INTO usuarios (...) VALUES (...)");
        
        $mensagem = "Conta criada com sucesso! Seja bem-vindo à DWD Street.";
        $tipo_mensagem = "sucesso";
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
    <style>
        /* Estilos rápidos para as mensagens de feedback do PHP */
        .alert-msg {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
        }
        .alert-msg.erro { background-color: #ff3333; color: white; }
        .alert-msg.sucesso { background-color: #2baf2b; color: white; }
    </style>
</head>
<body class="auth-body">

    <div class="auth-container">
        <h2>Criar Conta</h2>
        
        <?php if (!empty($mensagem)): ?>
            <div class="alert-msg <?php echo $tipo_mensagem; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
        
        <form class="auth-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            
            <div class="auth-row">
                <input type="text" name="nome" placeholder="Nome" class="auth-input" value="<?php echo isset($nome) ? $nome : ''; ?>" required>
                <input type="text" name="sobrenome" placeholder="Sobrenome" class="auth-input" value="<?php echo isset($sobrenome) ? $sobrenome : ''; ?>" required>
            </div>
            
            <input type="text" name="cpf" placeholder="CPF (Somente números)" class="auth-input" value="<?php echo isset($cpf) ? $cpf : ''; ?>" required>
            <input type="email" name="email" placeholder="Seu melhor e-mail" class="auth-input" value="<?php echo isset($email) ? $email : ''; ?>" required>
            <input type="password" name="senha" placeholder="Crie uma senha" class="auth-input" required>
            <input type="password" name="confirme_senha" placeholder="Confirme a senha" class="auth-input" required>
            
            <button type="submit" class="auth-btn">Cadastrar e Continuar</button>
        </form>
        
        <div class="auth-link">
            Já tem conta? <a href="login.php">Faça login</a>
        </div>
    </div>

    <button id="theme-toggle" class="theme-toggle">🌙</button>

    <script>
        // MODO ESCURO - VERIFICAÇÃO IMEDIATA (Mantive seu script rodando perfeitamente)
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
</body>
</html>