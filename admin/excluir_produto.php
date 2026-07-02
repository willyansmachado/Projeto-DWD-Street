<?php
// Inicia a sessão se ainda não foi iniciada pelo "proteger.php"
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("proteger.php");

/* ==========================================================================
   CONEXÃO COM O BANCO DE DADOS
   ========================================================================== */
$host = "localhost";
$usuario_db = "root";
$senha_db = "";
$banco_db = "dwd_street";

$conn = new mysqli($host, $usuario_db, $senha_db, $banco_db);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

/* ==========================================================================
   LOGICA DE EXCLUSÃO DO PRODUTO
   ========================================================================== */
$mensagem = "";
$status = "";
$nome_produto = "";

// Verifica se o ID foi passado na URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_produto = intval($_GET['id']);
    
    // Busca o nome do produto para exibir na confirmação
    $stmt_busca = $conn->prepare("SELECT nome FROM produtos WHERE id = ?");
    $stmt_busca->bind_param("i", $id_produto);
    $stmt_busca->execute();
    $resultado_busca = $stmt_busca->get_result();
    
    if ($resultado_busca->num_rows > 0) {
        $row_produto = $resultado_busca->fetch_assoc();
        $nome_produto = $row_produto['nome'];
    } else {
        $mensagem = "Produto não encontrado no sistema.";
        $status = "erro";
    }
    $stmt_busca->close();

    // Se o usuário confirmou a exclusão via formulário POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar']) && $status !== "erro") {
        $stmt_deletar = $conn->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt_deletar->bind_param("i", $id_produto);
        
        if ($stmt_deletar->execute()) {
            $mensagem = "Produto \"<strong>" . htmlspecialchars($nome_produto) . "</strong>\" (ID #$id_produto) excluído com sucesso!";
            $status = "sucesso";
        } else {
            $mensagem = "Falha ao tentar excluir o produto: " . $conn->error;
            $status = "erro";
        }
        $stmt_deletar->close();
    }
} else {
    $mensagem = "Nenhum produto válido foi selecionado para exclusão.";
    $status = "erro";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Excluir Produto | DWD Street</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* ==========================================================================
       VARIÁVEIS DE COR DO SEU DASHBOARD
       ========================================================================== */
    :root {
        --brand-red: #ff0000;
        --brand-red-hover: #cc0000;
        
        --bg-main: #000000;
        --bg-surface: #0a0a0a;
        --bg-header: #030303;
        --border-color: #141414;
        --border-hover: #252525;
        --text-main: #ffffff;
        --text-muted: #6c6c73;
        --bg-pill: #111111;
        --accent-green: #00ff66;
    }

    body.light-mode {
        --bg-main: #f4f5f6;
        --bg-surface: #ffffff;
        --bg-header: #ffffff;
        --border-color: #e4e4e7;
        --border-hover: #d4d4d8;
        --text-main: #09090b;
        --text-muted: #71717a;
        --bg-pill: #f4f4f5;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        transition: background 0.2s cubic-bezier(0.4, 0, 0.2, 1), 
                    border-color 0.2s ease, 
                    color 0.2s ease, 
                    transform 0.2s ease;
    }

    body {
        background: var(--bg-main);
        color: var(--text-main);
        font-family: 'Montserrat', sans-serif;
        -webkit-font-smoothing: antialiased;
        border-top: 4px solid var(--brand-red);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    a { text-decoration: none; color: inherit; }

    /* ==========================================================================
       HEADER (PADRÃO DO SEU DASHBOARD)
       ========================================================================== */
    .admin-header {
        background: var(--bg-header);
        border-bottom: 1px solid var(--border-color);
        padding: 18px 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        backdrop-filter: blur(12px);
    }

    .admin-logo {
        font-size: 1.5rem;
        font-weight: 900;
        letter-spacing: -1.5px;
        font-style: italic;
    }
    .admin-logo span { color: var(--brand-red); }

    .admin-user { display: flex; align-items: center; gap: 12px; }
    .theme-btn {
        background: var(--bg-pill);
        color: var(--text-main);
        border: 1px solid var(--border-color);
        padding: 10px 16px;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        border-radius: 2px;
    }
    .theme-btn:hover { border-color: var(--text-main); }

    /* ==========================================================================
       CONTEÚDO DE CONFIRMAÇÃO CENTRALIZADO
       ========================================================================== */
    .delete-container {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 4%;
    }

    .delete-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        padding: 40px;
        max-width: 500px;
        width: 100%;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    .delete-card:hover {
        border-color: var(--brand-red);
    }

    .warning-icon {
        font-size: 3rem;
        color: var(--brand-red);
        margin-bottom: 20px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.05); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }

    .delete-card h1 {
        font-size: 1.6rem;
        font-weight: 900;
        text-transform: uppercase;
        font-style: italic;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
    }

    .delete-card p {
        color: var(--text-muted);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 30px;
        font-weight: 500;
    }

    .delete-card p strong {
        color: var(--text-main);
    }

    /* STATUS FEEDBACK */
    .alert {
        padding: 16px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        border-radius: 2px;
        margin-bottom: 25px;
        letter-spacing: 0.5px;
    }
    .alert-sucesso {
        background: rgba(0, 255, 102, 0.08);
        border: 1px solid var(--accent-green);
        color: var(--accent-green);
    }
    .alert-erro {
        background: rgba(255, 0, 0, 0.08);
        border: 1px solid var(--brand-red);
        color: var(--brand-red);
    }

    /* BOTÕES INTEGRADOS AO DESIGN */
    .btn-group {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-action {
        padding: 14px 28px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 2px;
        cursor: pointer;
        text-align: center;
        flex: 1;
    }

    .btn-confirmar {
        background: var(--brand-red);
        color: #ffffff;
        border: 1px solid var(--brand-red);
    }
    .btn-confirmar:hover {
        background: var(--brand-red-hover);
        border-color: var(--brand-red-hover);
        transform: translateY(-2px);
    }

    .btn-voltar {
        background: var(--bg-pill);
        color: var(--text-main);
        border: 1px solid var(--border-color);
    }
    .btn-voltar:hover {
        border-color: var(--text-main);
        transform: translateY(-2px);
    }

    @media (max-width: 480px) {
        .btn-group { flex-direction: column; }
    }
</style>
</head>
<body>

<header class="admin-header">
    <a href="admiin.php" class="admin-logo">
        DWD<span>STREET</span>
    </a>

    <div class="admin-user">
        <button id="theme-toggle" class="theme-btn" aria-label="Mudar Tema">🌙</button>
    </div>
</header>

<div class="delete-container">
    <div class="delete-card">
        
        <?php if ($status !== "sucesso"): ?>
            <div class="warning-icon">⚠️</div>
        <?php else: ?>
            <div class="warning-icon" style="color: var(--accent-green);">✓</div>
        <?php endif; ?>

        <h1>Remover do Sistema</h1>

        <?php if (!empty($mensagem)): ?>
            <div class="alert <?php echo ($status === 'sucesso') ? 'alert-sucesso' : 'alert-erro'; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($id_produto) && $status !== 'sucesso' && $status !== 'erro'): ?>
            <p>
                Tem certeza que deseja deletar o produto <br>
                <strong>"<?php echo htmlspecialchars($nome_produto); ?>"</strong> (ID #<?php echo $id_produto; ?>)?<br>
                <span style="color: var(--brand-red); font-size: 11px; font-weight: 700;">ESSA AÇÃO NÃO PODE SER DESFEITA.</span>
            </p>
            
            <form action="" method="POST">
                <div class="btn-group">
                    <button type="submit" name="confirmar" class="btn-action btn-confirmar">Confirmar Exclusão</button>
                    <a href="produtos.php" class="btn-action btn-voltar">Cancelar</a>
                </div>
            </form>
        <?php else: ?>
            <p>Retorne para a listagem geral para gerenciar os demais itens ativos do catálogo.</p>
            <div class="btn-group">
                <a href="produtos.php" class="btn-action btn-voltar" style="width: 100%;">Voltar para o Catálogo</a>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
    // Gerenciador do Tema (Sincronizado perfeitamente com seu script)
    const themeToggle = document.getElementById("theme-toggle");
    
    if(localStorage.getItem("theme") === "light"){
        document.body.classList.add("light-mode");
        themeToggle.innerHTML = "☀️";
    }

    themeToggle.addEventListener("click", function(){
        document.body.classList.toggle("light-mode");
        if(document.body.classList.contains("light-mode")){
            localStorage.setItem("theme", "light");
            this.innerHTML = "☀️";
        } else {
            localStorage.setItem("theme", "dark");
            this.innerHTML = "🌙";
        }
    });
</script>

</body>
</html>