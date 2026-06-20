<?php
session_start();

// Evita erro caso a variável não venha do login/sessão
$nomeUsuario = $_SESSION["nome"] ?? "Visitante";

// Simulando um banco de dados de produtos em oferta da DWD Street
$ofertas = [
    [
        "id" => 1,
        "nome" => "Moletom Canguru Oversized Heavy",
        "categoria" => "masculino",
        "preco_original" => 289.90,
        "preco_desconto" => 199.90,
        "desconto" => 31,
        "img" => "https://images.unsplash.com/photo-1556911220-e15b29be8c8f?w=500",
    ],
    [
        "id" => 2,
        "nome" => "Camisa Minimalist Algodão Off-White",
        "categoria" => "masculino",
        "preco_original" => 149.90,
        "preco_desconto" => 99.90,
        "desconto" => 33,
        "img" => "https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500",
    ],
    [
        "id" => 3,
        "nome" => "Bermuda Jorts Wide Dark",
        "categoria" => "masculino",
        "preco_original" => 199.90,
        "preco_desconto" => 139.90,
        "desconto" => 30,
        "img" => "https://images.unsplash.com/photo-1542272604-787c3835535d?w=500",
    ],
    [
        "id" => 4,
        "nome" => "Calça Cargo Feminina Street Style",
        "categoria" => "feminino",
        "preco_original" => 249.90,
        "preco_desconto" => 179.90,
        "desconto" => 28,
        "img" => "https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=500",
    ],
    [
        "id" => 5,
        "nome" => "Boné Snapback DWD Aba Curva",
        "categoria" => "acessorios",
        "preco_original" => 119.90,
        "preco_desconto" => 79.90,
        "desconto" => 33,
        "img" => "https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=500",
    ],
    [
        "id" => 6,
        "nome" => "Relógio Digital Sport All Black",
        "categoria" => "acessorios",
        "preco_original" => 349.90,
        "preco_desconto" => 239.90,
        "desconto" => 31,
        "img" => "https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=500",
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas do Dia | DWD Street</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    
    <style>
        /* ==========================================================================
           VARIÁVEIS DE TEMA (DARK MODE PADRÃO / LIGHT MODE FLUIDO)
           ========================================================================== */
        :root {
            --bg-body: #0a0a0a;
            --bg-navbar: #121212;
            --bg-card: #121212;
            --text-primary: #ffffff;
            --text-muted: #a0a0a0;
            --border-color: #222222;
            --accent: #e31e24;
            --accent-hover: #b31317;
            --btn-gray: #1f1f1f;
            --shadow-sm: rgba(0, 0, 0, 0.5);
            --promo-bg: linear-gradient(135deg, #1a0505 0%, #000000 100%);
        }

        body.light-mode {
            --bg-body: #f8f9fa;
            --bg-navbar: #ffffff;
            --bg-card: #ffffff;
            --text-primary: #1a1a1a;
            --text-muted: #6c757d;
            --border-color: #e0e0e0;
            --btn-gray: #e9ecef;
            --shadow-sm: rgba(0, 0, 0, 0.05);
            --promo-bg: linear-gradient(135deg, #ffffff 0%, #f1f1f1 100%);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        /* ==========================================================================
           TOP BAR E NAVBAR
           ========================================================================== */
        .top-banner {
            background-color: #000000;
            color: #ffffff;
            text-align: center;
            font-size: 0.7rem;
            padding: 10px 0;
            font-weight: 700;
            letter-spacing: 1.5px;
            border-bottom: 1px solid #1c1c1c;
            text-transform: uppercase;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 4%;
            background-color: var(--bg-navbar);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px var(--shadow-sm);
        }

        .logo {
            font-weight: 900;
            font-size: 1.6rem;
            text-decoration: none;
            color: var(--text-primary);
            letter-spacing: -1px;
        }

        .logo span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 25px;
        }

        .nav-links a {
            color: var(--text-primary);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            padding-bottom: 4px;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-status {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-align: right;
            line-height: 1.3;
        }

        .user-status span {
            color: var(--text-primary);
            font-weight: 700;
            display: block;
            font-size: 0.85rem;
        }

        .nav-btn {
            background-color: var(--btn-gray);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 6px var(--shadow-sm);
        }

        .nav-btn:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        /* Botão Sair Customizado com Hover */
        .btn-sair {
            background-color: var(--accent);
            color: #ffffff;
            border: none;
        }

        .btn-sair:hover {
            background-color: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(227, 30, 36, 0.3);
        }

        .theme-toggle-nav {
            background: var(--btn-gray);
            border: 1px solid var(--border-color);
            font-size: 1.2rem;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px var(--shadow-sm);
        }

        .theme-toggle-nav:hover {
            transform: scale(1.05);
            border-color: var(--accent);
        }

        /* ==========================================================================
           CONTEÚDO PRINCIPAL
           ========================================================================== */
        .container {
            padding: 40px 4%;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Banner Promocional Premium */
        .promo-banner {
            background: var(--promo-bg);
            border: 1px solid var(--accent);
            border-radius: 16px;
            padding: 50px 20px;
            text-align: center;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(227, 30, 36, 0.15);
            position: relative;
            overflow: hidden;
        }

        .promo-banner::before {
            content: '🔥';
            position: absolute;
            font-size: 10rem;
            opacity: 0.05;
            top: -30px;
            left: -20px;
            transform: rotate(-15deg);
        }

        .promo-banner h1 {
            font-weight: 900;
            font-size: 2.8rem;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-primary);
        }

        .promo-banner p {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 25px;
        }

        /* Cronômetro Glassmorphism */
        .countdown-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .countdown-box {
            background: rgba(227, 30, 36, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(227, 30, 36, 0.3);
            padding: 15px 20px;
            border-radius: 12px;
            min-width: 80px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .countdown-box span {
            display: block;
            font-size: 2rem;
            font-weight: 900;
            color: var(--accent);
            line-height: 1;
            margin-bottom: 5px;
        }

        .countdown-box label {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-primary);
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Filtros Modernos */
        .filter-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .filter-btn {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 12px 24px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 30px;
            cursor: pointer;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px var(--shadow-sm);
        }

        .filter-btn:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .filter-btn.active {
            background: var(--accent);
            border-color: var(--accent);
            color: #ffffff;
        }

        /* Grid de Produtos */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 35px;
        }

        .product-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 15px var(--shadow-sm);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-8px);
            border-color: rgba(227, 30, 36, 0.4);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        @keyframes pulseAlert {
            0% { transform: scale(1); }
            50% { transform: scale(1.08); }
            100% { transform: scale(1); }
        }

        .discount-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--accent);
            color: #fff;
            padding: 6px 14px;
            font-weight: 900;
            font-size: 0.9rem;
            border-radius: 6px;
            text-transform: uppercase;
            z-index: 2;
            box-shadow: 0 4px 12px rgba(227, 30, 36, 0.5);
            animation: pulseAlert 2s infinite;
        }

        .img-container {
            width: 100%;
            height: 280px;
            background-color: rgba(255,255,255,0.02);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border-color);
        }

        .product-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-card:hover img {
            transform: scale(1.06);
        }

        .product-info {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            text-align: center;
        }

        .product-info h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--text-primary);
            min-height: 40px;
        }

        .price-container {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }

        .old-price {
            text-decoration: line-through;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .new-price {
            color: var(--accent);
            font-weight: 900;
            font-size: 1.5rem;
        }

        /* Botão de Adicionar ao Carrinho Modernizado com Hover Nítido */
        .auth-btn {
            width: 100%;
            background-color: var(--text-primary);
            color: var(--bg-body);
            border: none;
            padding: 14px;
            font-weight: 900;
            font-size: 0.85rem;
            text-transform: uppercase;
            border-radius: 6px;
            cursor: pointer;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px var(--shadow-sm);
            margin-top: auto;
        }

        .auth-btn:hover {
            background-color: var(--accent);
            color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(227, 30, 36, 0.4);
        }

        /* ==========================================================================
           CHATBOT
           ========================================================================== */
        #chatbot-window {
            position: fixed; 
            bottom: 100px; 
            right: 25px; 
            width: 360px; 
            height: 500px; 
            background-color: var(--bg-card); 
            border-radius: 16px; 
            box-shadow: 0 12px 36px rgba(0,0,0,0.4); 
            z-index: 9999; 
            display: none; 
            flex-direction: column; 
            overflow: hidden; 
            border: 1px solid var(--border-color);
        }

        #chat-messages {
            flex: 1; 
            padding: 20px; 
            overflow-y: auto; 
            background-color: rgba(0,0,0,0.02); 
            display: flex; 
            flex-direction: column; 
            gap: 14px;
        }

        #chat-messages::-webkit-scrollbar { width: 5px; }
        #chat-messages::-webkit-scrollbar-thumb { background-color: var(--border-color); border-radius: 10px; }

        .chat-link { color: var(--accent); text-decoration: underline; font-weight: 700; }

        /* Botões internos do chatbot com efeitos Hover */
        #close-chat {
            background: none; 
            border: none; 
            color: #fff; 
            font-size: 1.5rem; 
            cursor: pointer; 
            line-height: 1;
        }
        
        #close-chat:hover {
            transform: scale(1.2);
            color: #f1f1f1;
        }

        #btn-send-chat {
            background-color: #e31e24; 
            color: #fff; 
            border: none; 
            padding: 0 18px; 
            border-radius: 8px; 
            font-weight: 700; 
            font-size: 0.8rem; 
            cursor: pointer;
        }

        #btn-send-chat:hover {
            background-color: var(--accent-hover);
            transform: scale(1.03);
        }

        #chatbot-toggle {
            position: fixed; 
            bottom: 25px; 
            right: 25px; 
            background-color: var(--accent); 
            color: #fff; 
            border: none; 
            width: 60px; 
            height: 60px; 
            border-radius: 50%; 
            font-size: 1.8rem; 
            cursor: pointer; 
            box-shadow: 0 6px 20px rgba(227, 30, 36, 0.4); 
            z-index: 9999; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }

        #chatbot-toggle:hover { transform: scale(1.08); background-color: var(--accent-hover); }

        /* ==========================================================================
           FOOTER
           ========================================================================== */
        .main-footer {
            background-color: #000000;
            padding: 70px 4% 30px;
            border-top: 1px solid var(--border-color);
            margin-top: 60px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-col h4 {
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 25px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 14px; }
        .footer-col ul li a { text-decoration: none; color: #888888; font-size: 0.85rem; }
        .footer-col ul li a:hover { color: var(--accent); }

        .footer-copyright {
            text-align: center;
            color: #444444;
            font-size: 0.75rem;
            margin-top: 60px;
            border-top: 1px solid #111111;
            padding-top: 25px;
        }
    </style>
</head>
<body>

    <div class="top-banner">
        Entrega rápida em toda Joinville | 10% OFF na primeira compra
    </div>

    <header class="navbar">
        <a href="index.php" class="logo">DWD<span>STREET</span></a>
        
        <nav>
            <ul class="nav-links">
                <li><a href="#">Categorias ▾</a></li>
                <li><a href="masculino.php">Masculino</a></li>
                <li><a href="feminino.php">Feminino</a></li>
                <li><a href="infantil.php">Infantil</a></li>
                <li><a href="ofertas.php" style="color: var(--accent);">Ofertas</a></li>
                <li><a href="montador.php">Montador de Outfit</a></li>
            </ul>
        </nav>

        <div class="nav-right">
            <div class="user-status">
                Usuário Logado
                <span><?= htmlspecialchars($nomeUsuario) ?></span>
            </div>
            <a href="meus_pedidos.php" class="nav-btn">📦 Pedidos</a>
            <a href="carrinho.php" class="nav-btn">
                🛒 Carrinho <span id="cart-count" style="color: var(--accent); margin-left:5px; font-weight:900;">(0)</span>
            </a>
            <button class="theme-toggle-nav" id="theme-toggle-nav" aria-label="Mudar tema">☀️</button>
            <a href="logout.php" class="nav-btn btn-sair">Sair</a>
        </div>
    </header>

    <main class="container">
        
        <section class="promo-banner">
            <h1>🔥 Ofertas Limitadas 🔥</h1>
            <p>Os melhores drops de Joinville com descontos surreais. Acaba hoje!</p>
            
            <div class="countdown-container">
                <div class="countdown-box">
                    <span id="hours">24</span>
                    <label>Horas</label>
                </div>
                <div class="countdown-box">
                    <span id="minutes">00</span>
                    <label>Min</label>
                </div>
                <div class="countdown-box">
                    <span id="seconds">00</span>
                    <label>Seg</label>
                </div>
            </div>
        </section>

        <div class="filter-container">
            <button class="filter-btn active" onclick="filtrarCategoria('todos', this)">Ver Todas</button>
            <button class="filter-btn" onclick="filtrarCategoria('masculino', this)">Masculino</button>
            <button class="filter-btn" onclick="filtrarCategoria('feminino', this)">Feminino</button>
            <button class="filter-btn" onclick="filtrarCategoria('acessorios', this)">Acessórios</button>
        </div>

        <section class="product-grid">
            <?php foreach($ofertas as $produto): ?>
                <div class="product-card" data-category="<?php echo $produto['categoria']; ?>">
                    <span class="discount-badge">-<?php echo $produto['desconto']; ?>%</span>
                    
                    <div class="img-container">
                        <img src="<?php echo $produto['img']; ?>" alt="<?php echo $produto['nome']; ?>">
                    </div>
                    
                    <div class="product-info">
                        <h3><?php echo $produto['nome']; ?></h3>
                        
                        <div class="price-container">
                            <span class="old-price">R$ <?php echo number_format($produto['preco_original'], 2, ',', '.'); ?></span>
                            <span class="new-price">R$ <?php echo number_format($produto['preco_desconto'], 2, ',', '.'); ?></span>
                        </div>
                        
                        <button class="auth-btn">Adicionar ao Carrinho</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>

    <div id="chatbot-window">
        <div style="background-color: #e31e24; color: #fff; padding: 18px; font-weight: 700; display: flex; justify-content: space-between; align-items: center; letter-spacing: 0.5px; font-size: 0.95rem;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span>🤖</span> IA DWD STREET
            </div>
            <button id="close-chat">&times;</button>
        </div>
        
        <div id="chat-messages">
            <div class="bot-msg" style="background-color: var(--btn-gray); padding: 12px 16px; border-radius: 14px 14px 14px 0px; align-self: flex-start; max-width: 85%; color: var(--text-primary); font-size: 0.85rem; line-height: 1.4; font-weight: 500; box-shadow: 0 2px 4px var(--shadow-sm);">
                Salve, <strong><?= htmlspecialchars($nomeUsuario); ?></strong>! Encontrou alguma pechincha braba nas Ofertas? Se precisar de ajuda pra achar seu tamanho, é só falar! ⚡
            </div>
        </div>
        
        <div style="padding: 15px; border-top: 1px solid var(--border-color); display: flex; gap: 8px; background-color: var(--bg-navbar);">
            <input type="text" id="chat-input" placeholder="Digite sua mensagem aqui..." style="flex: 1; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.85rem; outline: none; background: var(--bg-body); color: var(--text-primary);">
            <button id="btn-send-chat">ENVIAR</button>
        </div>
    </div>

    <button id="chatbot-toggle">🤖</button>

    <footer class="main-footer">
        <div class="footer-container">
            <div class="footer-col">
                <h4>Ajuda e Atendimento</h4>
                <ul>
                    <li><a href="#">Acompanhe seu pedido</a></li>
                    <li><a href="#">Dúvidas frequentes</a></li>
                    <li><a href="#">Fale com a gente</a></li>
                    <li><a href="#">Troca e arrependimento</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Políticas e Regulamentos</h4>
                <ul>
                    <li><a href="politicas/pol_coo.php">Política de cookies</a></li>
                    <li><a href="politicas/privacidade.php">Política de privacidade</a></li>
                    <li><a href="politicas/termos.php">Termos e condições</a></li>
                    <li><a href="politicas/seguranca.php">Segurança do site</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Institucional</h4>
                <ul>
                    <li><a href="sobre.php">Sobre a DWD Street</a></li>
                    <li><a href="lojas.php">Nossas Lojas</a></li>
                    <li><a href="trabalho.php">Trabalhe Conosco</a></li>
                    <li><a href="sustentabilidade.php">Sustentabilidade</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Nossos Produtos</h4>
                <ul>
                    <li><a href="lançamentos.php">Lançamentos</a></li>
                    <li><a href="masculino.php">Coleção Masculina</a></li>
                    <li><a href="feminino.php">Coleção Feminina</a></li>
                    <li><a href="infantil.php">Coleção Infantil</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-copyright">
            <p>&copy; 2026 DWD STREET. Todos os direitos reservados. Projeto Acadêmico SESI SENAI.</p>
        </div>
    </footer>

    <script>
        // ==========================================================================
        // 1. FILTROS DA GRID
        // ==========================================================================
        function filtrarCategoria(categoria, botao) {
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            botao.classList.add('active');

            document.querySelectorAll('.product-card').forEach(card => {
                if (categoria === 'todos' || card.getAttribute('data-category') === categoria) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // ==========================================================================
        // 2. CRONÔMETRO DE URGÊNCIA (MEIA NOITE)
        // ==========================================================================
        function atualizarCronometro() {
            const agora = new Date();
            const fimDoDia = new Date();
            fimDoDia.setHours(23, 59, 59, 999);

            const diferenca = fimDoDia - agora;

            const horas = Math.floor((diferenca / (1000 * 60 * 60)) % 24);
            const minutos = Math.floor((diferenca / 1000 / 60) % 60);
            const segundos = Math.floor((diferenca / 1000) % 60);

            document.getElementById('hours').textContent = String(horas).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutos).padStart(2, '0');
            document.getElementById('seconds').textContent = String(segundos).padStart(2, '0');
        }
        setInterval(atualizarCronometro, 1000);
        atualizarCronometro();

        // ==========================================================================
        // 3. SISTEMA INTEGRADO DE MODO ESCURO E CLARO
        // ==========================================================================
        const themeToggleNav = document.getElementById('theme-toggle-nav');
        const body = document.body;

        if (localStorage.getItem('theme') === 'light') {
            body.classList.add('light-mode');
            if (themeToggleNav) themeToggleNav.textContent = '🌙';
        }

        if (themeToggleNav) {
            themeToggleNav.addEventListener('click', () => {
                body.classList.toggle('light-mode');
                if (body.classList.contains('light-mode')) {
                    localStorage.setItem('theme', 'light');
                    themeToggleNav.textContent = '🌙';
                } else {
                    localStorage.setItem('theme', 'dark');
                    themeToggleNav.textContent = '☀️';
                }
            });
        }

        // ==========================================================================
        // 4. MOTOR COGNITIVO DA IA (CHATBOT)
        // ==========================================================================
        const chatBotBtn = document.getElementById('chatbot-toggle');
        const chatWindow = document.getElementById('chatbot-window');
        const closeChatBtn = document.getElementById('close-chat');
        const chatInput = document.getElementById('chat-input');
        const btnSendChat = document.getElementById('btn-send-chat');
        const chatMessages = document.getElementById('chat-messages');

        const baseConhecimentoIA = [
            { chaves: [/trabalh/i, /vaga/i, /emprego/i], resposta: "Quer colar com a gente? <a href='trabalho.php' class='chat-link'>Clique aqui para ir para a página Trabalhe Conosco</a>! 🚀" },
            { chaves: [/loja/i, /fisica/i, /endereço/i], resposta: "Quer ver os panos de perto? <a href='lojas.php' class='chat-link'>Clique aqui para ver Nossas Lojas</a>! 📍" },
            { chaves: [/troca/i, /devolv/i, /reembols/i], resposta: "Sem estresse! Se precisar trocar, <a href='#' class='chat-link'>clique aqui para abrir as solicitações de Troca</a>. 🔄" },
            { chaves: [/rastre/i, /pedido/i, /onde ta/i], resposta: "Acompanhe sua entrega na página <a href='meus_pedidos.php' class='chat-link'>Meus Pedidos</a>! 📦" },
            { chaves: [/carrinho/i, /sacola/i, /fechar/i], resposta: "Pronto para finalizar? <a href='carrinho.php' class='chat-link'>Clique aqui para ir para o Carrinho de Compras</a>. 🛒" },
            { chaves: [/montador/i, /outfit/i, /look/i], resposta: "Crie combinações insanas! <a href='montador.php' class='chat-link'>Use o Montador de Outfit</a>! 🎨" },
            { chaves: [/oferta/i, /promo/i, /desconto/i], resposta: "Você já está no lugar certo! Dá uma olhada nas opções dessa página, acabam hoje! 💥" },
            { chaves: [/oi/i, /olá/i, /salve/i, /eae/i], resposta: "Salve! Sou a IA da DWD Street. O que você está buscando hoje?" }
        ];

        if (chatBotBtn && chatWindow && closeChatBtn) {
            chatBotBtn.addEventListener('click', () => {
                chatWindow.style.display = (chatWindow.style.display === 'none' || chatWindow.style.display === '') ? 'flex' : 'none';
            });
            closeChatBtn.addEventListener('click', () => { chatWindow.style.display = 'none'; });
        }

        function adicionarMensagem(texto, remetente) {
            const novaMsg = document.createElement('div');
            if (remetente === 'usuario') {
                novaMsg.style.cssText = "background-color: #e31e24; color: #fff; padding: 12px 16px; border-radius: 14px 14px 0px 14px; align-self: flex-end; max-width: 85%; font-size: 0.85rem; line-height: 1.4; font-weight: 500; box-shadow: 0 2px 4px var(--shadow-sm);";
                novaMsg.textContent = texto;
            } else {
                novaMsg.style.cssText = "background-color: var(--btn-gray); padding: 12px 16px; border-radius: 14px 14px 14px 0px; align-self: flex-start; max-width: 85%; color: var(--text-primary); font-size: 0.85rem; line-height: 1.4; font-weight: 500; box-shadow: 0 2px 4px var(--shadow-sm);";
                novaMsg.innerHTML = texto;
            }
            chatMessages.appendChild(novaMsg);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function enviarMensagemDigitada() {
            const textoOriginal = chatInput.value.trim();
            if (textoOriginal === '') return;

            adicionarMensagem(textoOriginal, 'usuario');
            chatInput.value = '';

            setTimeout(() => {
                let respostaFinal = "Não captei, mano. Tente 'lojas', 'carrinho', 'pedidos' ou 'outfit'!";
                const msgMinuscula = textoOriginal.toLowerCase();
                
                for (let item of baseConhecimentoIA) {
                    if (item.chaves.some(regex => regex.test(msgMinuscula))) {
                        respostaFinal = item.resposta;
                        break;
                    }
                }
                adicionarMensagem(respostaFinal, 'bot');
            }, 600);
        }

        if (btnSendChat) {
            btnSendChat.addEventListener('click', enviarMensagemDigitada);
        }

        if (chatInput) {
            chatInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    enviarMensagemDigitada();
                }
            });
    
                }
                adicionarMensagem(respostaFinal, 'bot');
            , (400);
        

        if(btnSendChat && chatInput) {
            btnSendChat.addEventListener('click', enviarMensagemDigitada);
            chatInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') enviarMensagemDigitada(); });
        }

        // ==========================================================================
        // 5. LÓGICA DO CARRINHO COM SUPORTE A PREÇO PROMOCIONAL
        // ==========================================================================
        document.addEventListener("DOMContentLoaded", () => {
            const badge = document.getElementById('cart-count');
            function atualizaBadge() {
                let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
                let total = carrinho.reduce((soma, item) => soma + item.quantidade, 0);
                if(badge) badge.textContent = `(${total})`;
            }
            atualizaBadge();

            document.querySelectorAll('.auth-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const card = e.target.closest('.product-card');
                    const nome = card.querySelector('h3').textContent;
                    
                    // Extrai o NOVO PREÇO com desconto (segundo span dentro de price-container)
                    const precoTexto = card.querySelector('.new-price').textContent;
                    const preco = parseFloat(precoTexto.replace('R$', '').replace('.','').replace(',','.').trim());
                    
                    let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
                    let item = carrinho.find(i => i.nome === nome);
                    
                    if(item) {
                        item.quantidade++;
                    } else {
                        carrinho.push({ nome: nome, preco: preco, quantidade: 1 });
                    }
                    localStorage.setItem('carrinho_itens', JSON.stringify(carrinho));
                    atualizaBadge();

                    btn.textContent = "Adicionado! ✓";
                    btn.style.backgroundColor = "#28a745";
                    btn.style.color = "#fff";
                    setTimeout(() => {
                        btn.textContent = "Adicionar ao Carrinho";
                        btn.style.backgroundColor = "";
                        btn.style.color = "";
                    }, 1000);
                });
            });
        });
    </script>
</body>
</html>