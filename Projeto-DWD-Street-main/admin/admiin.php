<?php
// Inicia a sessão se ainda não foi iniciada pelo "proteger.php"
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("proteger.php");

/* ==========================================================================
   CONEXÃO COM O BANCO DE DADOS (Ajuste o host/user/senha se necessário)
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
   QUERIES DINÂMICAS PARA CONTADORES DO DASHBOARD
   ========================================================================== */

$query_faturamento = "SELECT SUM(valor_total) AS total FROM pedidos";
$res_faturamento = $conn->query($query_faturamento);
$row_faturamento = $res_faturamento->fetch_assoc();
$faturamento_real = $row_faturamento['total'] ?? 0;

$query_pedidos = "SELECT COUNT(id) AS total FROM pedidos";
$res_pedidos = $conn->query($query_pedidos);
$row_pedidos = $res_pedidos->fetch_assoc();
$total_pedidos_real = $row_pedidos['total'] ?? 0;

$query_clientes = "SELECT COUNT(id) AS total FROM usuarios WHERE nivel = 'cliente'";
$res_clientes = $conn->query($query_clientes);
$row_clientes = $res_clientes->fetch_assoc();
$total_clientes_real = $row_clientes['total'] ?? 0;

$query_produtos = "SELECT COUNT(id) AS total FROM produtos";
$res_produtos = $conn->query($query_produtos);
$row_produtos = $res_produtos->fetch_assoc();
$total_produtos_real = $row_produtos['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Realtime | DWD Street</title>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* ==========================================================================
       VARIÁVEIS DE COR E UI - PREMIUM STREETWEAR DESIGN
       ========================================================================== */
    :root {
        /* Paleta Dark (Padrão) */
        --brand-red: #ff0033;
        --brand-red-hover: #cc0029;
        --bg-main: #050505;
        --bg-surface: #0a0a0a;
        --bg-header: rgba(5, 5, 5, 0.85);
        --border-color: #1a1a1a;
        --border-hover: #333333;
        --text-main: #ffffff;
        --text-muted: #888891;
        --bg-pill: #121212;
        --accent-green: #00ff66;
        --shadow-card: 0 8px 24px rgba(0, 0, 0, 0.4);
        --shadow-hover: 0 12px 32px rgba(255, 0, 51, 0.15);
    }

    body.light-mode {
        /* Paleta Light */
        --brand-red: #e6002e;
        --brand-red-hover: #b30024;
        --bg-main: #f8f9fa;
        --bg-surface: #ffffff;
        --bg-header: rgba(255, 255, 255, 0.85);
        --border-color: #e5e7eb;
        --border-hover: #d1d5db;
        --text-main: #111827;
        --text-muted: #6b7280;
        --bg-pill: #f3f4f6;
        --accent-green: #10b981;
        --shadow-card: 0 4px 12px rgba(0, 0, 0, 0.03);
        --shadow-hover: 0 12px 24px rgba(0, 0, 0, 0.08);
    }

    /* Scrollbar Customizada */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: var(--bg-main); }
    ::-webkit-scrollbar-thumb { background: var(--border-hover); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: var(--bg-main);
        color: var(--text-main);
        font-family: 'Montserrat', sans-serif;
        -webkit-font-smoothing: antialiased;
        border-top: 4px solid var(--brand-red);
        min-height: 100vh;
        transition: background 0.3s ease, color 0.3s ease;
    }

    /* Previne rolagem da página enquanto a splash screen estiver ativa */
    body.no-scroll {
        overflow: hidden;
    }

    a { text-decoration: none; color: inherit; }

    /* ==========================================================================
       SPLASH SCREEN (ANIMAÇÃO DE ENTRADA)
       ========================================================================== */
    #splash-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: var(--bg-main);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.6s;
    }

    /* Classe ativada via JavaScript para sumir com a tela */
    #splash-screen.hidden {
        opacity: 0;
        visibility: hidden;
    }

    .splash-content {
        text-align: center;
        animation: splashPop 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .splash-logo {
        font-size: 3.5rem;
        margin-bottom: 20px;
        justify-content: center;
        font-weight: 900;
        letter-spacing: -1.5px;
        font-style: italic;
        display: flex;
        align-items: center;
    }
    
    .splash-logo span { 
        color: var(--brand-red); 
        text-shadow: 0 0 15px rgba(255,0,51,0.4);
    }

    .splash-welcome {
        font-size: 13px;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 2px;
        line-height: 1.6;
        opacity: 0;
        animation: fadeInText 0.5s ease forwards 0.4s; 
    }
    
    .splash-welcome strong {
        color: var(--text-main);
        font-size: 16px;
        font-weight: 900;
        letter-spacing: 1px;
    }

    /* Keyframes da Splash Screen e do Painel */
    @keyframes splashPop {
        0% { transform: scale(0.8); opacity: 0; filter: blur(10px); }
        100% { transform: scale(1); opacity: 1; filter: blur(0); }
    }

    @keyframes fadeInText {
        0% { transform: translateY(15px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ==========================================================================
       HEADER E BARRA DE NAVEGAÇÃO
       ========================================================================== */
    .admin-header {
        background: var(--bg-header);
        border-bottom: 1px solid var(--border-color);
        padding: 16px 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        transition: all 0.3s ease;
    }

    .admin-logo {
        font-size: 1.6rem;
        font-weight: 900;
        letter-spacing: -1.5px;
        font-style: italic;
        display: flex;
        align-items: center;
    }
    .admin-logo span { 
        color: var(--brand-red); 
        text-shadow: 0 0 15px rgba(255,0,51,0.4);
    }

    .admin-user { display: flex; align-items: center; gap: 16px; }
    .admin-info { text-align: right; }
    .admin-info small {
        color: var(--accent-green);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
        font-size: 9px;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .admin-info small::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        background: var(--accent-green);
        border-radius: 50%;
        box-shadow: 0 0 8px var(--accent-green);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.4; }
        100% { opacity: 1; }
    }

    .admin-info strong { font-size: 14px; font-weight: 700; margin-top: 2px; display: block; }

    .theme-btn, .btn-sair {
        background: var(--bg-pill);
        color: var(--text-main);
        border: 1px solid var(--border-color);
        padding: 10px 18px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .theme-btn:hover { border-color: var(--text-muted); transform: translateY(-2px); }
    .btn-sair:hover { 
        background: var(--brand-red); 
        color: #fff; 
        border-color: var(--brand-red); 
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255,0,51,0.3);
    }

    /* ==========================================================================
       GRID DE COMPONENTES E MÉTRICAS
       ========================================================================== */
    .admin-container {
        max-width: 1440px;
        margin: auto;
        padding: 40px 4%;
        /* O delay de 2.2s garante que a dashboard faça o fadeUp logo após a splash screen sumir */
        opacity: 0;
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards 2.2s;
    }

    .welcome-section { margin-bottom: 48px; }
    .welcome-section h1 { 
        font-size: 2.4rem; 
        font-weight: 900; 
        text-transform: uppercase; 
        font-style: italic; 
        letter-spacing: -1px;
    }
    .welcome-section p { 
        color: var(--text-muted); 
        font-size: 14px; 
        margin-top: 6px; 
        font-weight: 500; 
    }

    /* ROW DE INDICADORES QUANTITATIVOS */
    .metrics-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 24px;
        margin-bottom: 50px;
    }

    .metric-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        padding: 28px 24px;
        border-radius: 12px;
        position: relative;
        box-shadow: var(--shadow-card);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    
    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--border-color);
        transition: background 0.3s ease;
    }
    .metric-card:hover::before { background: var(--brand-red); }
    .metric-card:hover {
        transform: translateY(-5px);
        border-color: var(--border-hover);
        box-shadow: var(--shadow-hover);
    }

    .metric-card small {
        font-size: 11px;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 700;
        letter-spacing: 1.5px;
    }
    .metric-num {
        font-size: 2rem;
        font-weight: 900;
        margin-top: 12px;
        letter-spacing: -1px;
    }
    .metric-badge {
        position: absolute;
        top: 24px;
        right: 24px;
        font-size: 10px;
        font-weight: 800;
        color: var(--bg-surface);
        background: var(--text-main);
        padding: 4px 10px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    body:not(.light-mode) .metric-badge {
        color: #000;
        background: #fff;
    }

    /* GRID DAS SUB-PÁGINAS DO ARQUIVO */
    .grid-dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
        gap: 32px;
    }

    .panel-block {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 32px;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-card);
        transition: all 0.3s ease;
    }
    .panel-block:hover { 
        border-color: var(--border-hover); 
        box-shadow: var(--shadow-hover);
    }

    .panel-block h2 {
        font-size: 1.3rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -0.5px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .panel-block > p {
        color: var(--text-muted);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 30px;
        font-weight: 500;
    }

    .action-links {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: auto;
    }

    .action-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background: var(--bg-main);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .action-item span {
        transition: transform 0.2s ease;
    }

    .action-item:hover {
        border-color: var(--brand-red);
        background: var(--bg-pill);
        color: var(--brand-red);
        transform: translateX(4px);
    }
    
    .action-item:hover span:not(.icon-plus) {
        transform: translateX(4px);
    }

    .action-item span.icon-plus { 
        font-size: 16px; 
        font-weight: 900; 
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .admin-header { flex-direction: column; gap: 20px; padding: 20px 5%; }
        .admin-user { width: 100%; justify-content: space-between; }
        .admin-info { text-align: left; }
        .welcome-section h1 { font-size: 2rem; }
        .metric-card { padding: 20px; }
        .grid-dashboard { grid-template-columns: 1fr; }
    }
</style>
</head>
<body>

<div id="splash-screen">
    <div class="splash-content">
        <div class="splash-logo">
            DWD<span>STREET</span>
        </div>
        <div class="splash-welcome">
            Bem-vindo de volta, <br>
            <strong><?php echo htmlspecialchars($_SESSION["nome"] ?? "Admin"); ?></strong>
        </div>
    </div>
</div>

<header class="admin-header">
    <a href="../index.php" class="admin-logo">
        DWD<span>STREET</span>
    </a>

    <div class="admin-user">
        <div class="admin-info">
            <small>Live DB Active</small>
            <strong>👤 <?php echo htmlspecialchars($_SESSION["nome"] ?? "Admin"); ?></strong>
        </div>
        
        <div style="display: flex; gap: 10px;">
            <button id="theme-toggle" class="theme-btn" aria-label="Mudar Tema">🌙</button>
            <a href="../logout.php" class="btn-sair">Sair</a>
        </div>
    </div>
</header>

<div class="admin-container">
    
    <div class="welcome-section">
        <h1>Painel de Desempenho</h1>
        <p>Dados integrados diretamente da base MySQL local em tempo de execução</p>
    </div>

    <div class="metrics-row">
        <div class="metric-card">
            <small>Faturamento Bruto</small>
            <div class="metric-num">R$ <?php echo number_format($faturamento_real, 2, ',', '.'); ?></div>
            <div class="metric-badge">Live</div>
        </div>
        <div class="metric-card">
            <small>Pedidos Totais</small>
            <div class="metric-num"><?php echo $total_pedidos_real; ?></div>
            <div class="metric-badge">Acompanhar</div>
        </div>
        <div class="metric-card">
            <small>Clientes Ativos</small>
            <div class="metric-num"><?php echo $total_clientes_real; ?></div>
            <div class="metric-badge">Base</div>
        </div>
        <div class="metric-card">
            <small>Produtos Cadastrados</small>
            <div class="metric-num"><?php echo $total_produtos_real; ?></div>
            <div class="metric-badge">Grade</div>
        </div>
    </div>

    <div class="grid-dashboard">
        
        <div class="panel-block">
            <h2>📦 Gestão de Produtos</h2>
            <p>Controle completo do inventário da loja. Adicione drops, altere precificação e remova coleções antigas.</p>
            
            <div class="action-links">
                <a href="produtos.php" class="action-item">
                    Visualizar Catálogo <span>➔</span>
                </a>
                <a href="adicionar_produto.php" class="action-item">
                    Cadastrar Novo Produto <span class="icon-plus">+</span>
                </a>
                <a href="editar_produto.php" class="action-item">
                    Modificar Preço / Estoque <span>⚙</span>
                </a>
                <a href="excluir_produto.php" class="action-item">
                    Remover do Sistema <span>✕</span>
                </a>
            </div>
        </div>

        <div class="panel-block">
            <h2>🛒 Fluxo de Pedidos</h2>
            <p>Monitore compras realizadas pelos clientes e faça o gerenciamento logístico de despacho e transporte.</p>
            
            <div class="action-links">
                <a href="pedidos.php" class="action-item">
                    Listar Todos os Pedidos <span>➔</span>
                </a>
                <a href="alterar_status.php" class="action-item">
                    Atualizar Status de Entrega <span>🚚</span>
                </a>
            </div>
        </div>

        <div class="panel-block">
            <h2>👥 Cadastro de Usuários</h2>
            <p>Gerencie a base de clientes cadastrados no e-commerce e configure níveis administrativos de funcionários.</p>
            
            <div class="action-links">
                <a href="usuarios.php" class="action-item">
                    Ver Clientes Cadastrados <span>➔</span>
                </a>
                <a href="criar_admin.php" class="action-item">
                    Adicionar Novo Admin <span class="icon-plus">+</span>
                </a>
                <a href="excluir_usuario.php" class="action-item">
                    Revogar Permissões <span>✕</span>
                </a>
            </div>
        </div>

    </div>
</div>

<script>
    // ==========================================
    // LÓGICA DO TEMA DARK / LIGHT
    // ==========================================
    const themeToggle = document.getElementById("theme-toggle");
    
    // Verifica a preferência do usuário ao carregar a página
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

    // ==========================================
    // LÓGICA DA SPLASH SCREEN (TELA DE CARREGAMENTO)
    // ==========================================
    document.addEventListener("DOMContentLoaded", () => {
        // Trava o scroll da página enquanto a animação rola
        document.body.classList.add("no-scroll"); 
        
        // Define o tempo que a tela vai ficar aparecendo (2000ms = 2 segundos)
        setTimeout(() => {
            const splash = document.getElementById("splash-screen");
            
            // Adiciona a classe que faz a tela sumir suavemente
            if(splash) {
                splash.classList.add("hidden");
            }
            
            // Libera o scroll para o usuário mexer no painel
            document.body.classList.remove("no-scroll"); 
            
            // Espera a transição de CSS terminar (600ms) e remove o elemento do HTML
            setTimeout(() => {
                if(splash) {
                    splash.remove();
                }
            }, 600);
            
        }, 2000); 
    });
</script>

</body>
</html>