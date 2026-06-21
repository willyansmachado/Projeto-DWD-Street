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

// 1. Faturamento Total (Soma do valor_total de todos os pedidos finalizados/pagos)
// Nota: mudei para somar tudo genérico, mas você pode filtrar por status_pedido posteriormente
$query_faturamento = "SELECT SUM(valor_total) AS total FROM pedidos";
$res_faturamento = $conn->query($query_faturamento);
$row_faturamento = $res_faturamento->fetch_assoc();
$faturamento_real = $row_faturamento['total'] ?? 0;

// 2. Total de Pedidos Gerados
$query_pedidos = "SELECT COUNT(id) AS total FROM pedidos";
$res_pedidos = $conn->query($query_pedidos);
$row_pedidos = $res_pedidos->fetch_assoc();
$total_pedidos_real = $row_pedidos['total'] ?? 0;

// 3. Novos Clientes Cadastrados (usuarios com nivel = 'cliente')
$query_clientes = "SELECT COUNT(id) AS total FROM usuarios WHERE nivel = 'cliente'";
$res_clientes = $conn->query($query_clientes);
$row_clientes = $res_clientes->fetch_assoc();
$total_clientes_real = $row_clientes['total'] ?? 0;

// 4. Itens Ativos no Catálogo de Produtos
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
       VARIÁVEIS DE COR DINÂMICAS - PREMIUM STREETWEAR DESIGN
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
    }

    a { text-decoration: none; color: inherit; }

    /* ==========================================================================
       HEADER E BARRA DE NAVEGAÇÃO
       ========================================================================== */
    .admin-header {
        background: var(--bg-header);
        border-bottom: 1px solid var(--border-color);
        padding: 18px 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
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
    .admin-info { text-align: right; }
    .admin-info small {
        color: var(--text-muted);
        display: block;
        font-size: 9px;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .admin-info strong { font-size: 13px; font-weight: 600; }

    .theme-btn, .btn-sair {
        background: var(--bg-pill);
        color: var(--text-main);
        border: 1px solid var(--border-color);
        padding: 10px 16px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        border-radius: 2px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .theme-btn:hover { border-color: var(--text-main); }
    .btn-sair:hover { background: var(--brand-red); color: #fff; border-color: var(--brand-red); }

    /* ==========================================================================
       GRID DE COMPONENTES E MÉTRICAS
       ========================================================================== */
    .admin-container {
        max-width: 1400px;
        margin: auto;
        padding: 40px 4%;
    }

    .welcome-section { margin-bottom: 40px; }
    .welcome-section h1 { font-size: 2.2rem; font-weight: 900; text-transform: uppercase; font-style: italic; }
    .welcome-section p { color: var(--text-muted); font-size: 13px; margin-top: 4px; font-weight: 500; }

    /* ROW DE INDICADORES QUANTITATIVOS */
    .metrics-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 45px;
    }

    .metric-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        padding: 24px;
        border-radius: 4px;
        position: relative;
    }
    .metric-card small {
        font-size: 10px;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 700;
        letter-spacing: 1px;
    }
    .metric-num {
        font-size: 1.8rem;
        font-weight: 800;
        margin-top: 6px;
        letter-spacing: -0.5px;
    }
    .metric-badge {
        position: absolute;
        top: 24px;
        right: 24px;
        font-size: 10px;
        font-weight: 700;
        color: var(--accent-green);
        background: rgba(0, 255, 102, 0.08);
        padding: 3px 8px;
        border-radius: 50px;
    }

    /* GRID DAS SUB-PÁGINAS DO ARQUIVO */
    .grid-dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
        gap: 30px;
    }

    .panel-block {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        padding: 30px;
        display: flex;
        flex-direction: column;
    }
    .panel-block:hover { border-color: var(--border-hover); }

    .panel-block h2 {
        font-size: 1.2rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .panel-block > p {
        color: var(--text-muted);
        font-size: 13px;
        line-height: 1.6;
        margin-bottom: 25px;
    }

    .action-links {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: auto;
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    .action-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: var(--bg-pill);
        border: 1px solid var(--border-color);
        border-radius: 2px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .action-item:hover {
        border-color: var(--text-main);
        transform: translateX(4px);
    }
    .action-item span.icon-plus { color: var(--brand-red); font-weight: 900; }

    @media (max-width: 768px) {
        .admin-header { flex-direction: column; gap: 15px; text-align: center; }
        .admin-user { width: 100%; justify-content: center; }
        .admin-info { text-align: center; }
        .welcome-section h1 { font-size: 1.8rem; }
    }
</style>
</head>
<body>

<header class="admin-header">
    <a href="../index.php" class="admin-logo">
        DWD<span>STREET</span>
    </a>

    <div class="admin-user">
        <div class="admin-info">
            <small>Live Database Active</small>
            <strong>👤 <?php echo htmlspecialchars($_SESSION["nome"] ?? "Admin"); ?></strong>
        </div>

        <button id="theme-toggle" class="theme-btn" aria-label="Mudar Tema">🌙</button>
        <a href="../logout.php" class="btn-sair">🚪 Sair</a>
    </div>
</header>

<div class="admin-container">
    
    <div class="welcome-section">
        <h1>Painel de Desempenho</h1>
        <p>Dados integrados diretamente da base MySQL local em tempo de execução</p>
    </div>

    <!-- METRICS ROW ALIMENTADA VIA PHP + SQL REAL -->
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

    <!-- MAIN GRID DE GERENCIAMENTO (MAPEADO COM SUAS PASTAS REAIS) -->
    <div class="grid-dashboard">
        
        <!-- Bloco de Controle de Produtos -->
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
                    Remover do Sistema <span>🗑</span>
                </a>
            </div>
        </div>

        <!-- Bloco de Controle de Vendas/Logística -->
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

        <!-- Bloco de Controle de Usuários e Permissões -->
        <div class="panel-block">
            <h2>👥 Cadastro de Usuários</h2>
            <p>Gerencie a base de clientes cadastrados no e-commerce e configure níveis administrativos de funcionários.</p>
            
            <div class="action-links">
                <a href="usuarios.php" class="action-item">
                    Ver Clientes Cadastrados <span>➔</span>
                </a>
                <a href="criar_admin.php" class="action-item">
                    Adicionar Novo Administrador <span class="icon-plus">+</span>
                </a>
                <a href="excluir_usuario.php" class="action-item">
                    Revogar Permissões / Deletar <span>✕</span>
                </a>
            </div>
        </div>

    </div>
</div>

<script>
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