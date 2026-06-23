<?php
// Evita erro caso a variável não venha do login/sessão
$nomeUsuario = $nomeUsuario ?? 'Visitante';

// BANCO DE DADOS SIMULADO - PRODUTOS INFANTIS (Agora com Frente e Costas)
$produtos_infantis = [
    [
        "id" => 1,
        "nome" => "Camiseta Mini DWD",
        "preco" => 79.90,
        "imagem_frente" => "assets/img/camiseta_frente.png",
        "imagem_costas" => "assets/img/camiseta_costas.png",
        "alt_frente" => "Camiseta Infantil Preta Mini DWD - Frente",
        "alt_costas" => "Camiseta Infantil Preta Mini DWD - Costas"
    ],
    [
        "id" => 2,
        "nome" => "Moletom Kids Street",
        "preco" => 149.90,
        "imagem_frente" => "assets/img/moletom_frente.png",
        "imagem_costas" => "assets/img/moletom_costas.png",
        "alt_frente" => "Moletom Infantil Kids Street - Frente",
        "alt_costas" => "Moletom Infantil Kids Street - Costas"
    ],
    [
        "id" => 3,
        "nome" => "Boné Kids Aba Reta",
        "preco" => 59.90,
        "imagem_frente" => "assets/img/bone_frente.png",
        "imagem_costas" => "assets/img/bone_costas.png",
        "alt_frente" => "Boné Infantil Aba Reta - Frente",
        "alt_costas" => "Boné Infantil Aba Reta - Costas"
    ],
    [
        "id" => 4,
        "nome" => "Calça Jogger Mini",
        "preco" => 119.90,
        "imagem_frente" => "assets/img/calca_frente.png",
        "imagem_costas" => "assets/img/calca_costas.png",
        "alt_frente" => "Calça Jogger Infantil Mini - Frente",
        "alt_costas" => "Calça Jogger Infantil Mini - Costas"
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infantil | DWD Street</title>
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
            --accent: #e31e24; /* Vermelho DWD */
            --btn-gray: #1f1f1f;
            --shadow-sm: rgba(0, 0, 0, 0.5);
            --chat-bg: #ffffff;
            --chat-text: #212529;
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
            --chat-bg: #f8f9fa;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
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
            font-size: 1.8rem;
            text-decoration: none;
            color: var(--text-primary);
            letter-spacing: -1.5px;
            font-style: italic;
            text-transform: uppercase;
            display: inline-block;
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

        .nav-btn.btn-sair {
            background-color: var(--accent);
            color: #ffffff;
            border: none;
        }

        .nav-btn.btn-sair:hover {
            opacity: 0.9;
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
           CONTEÚDO PRINCIPAL E GRID DE PRODUTOS (COM EFEITO FLIP/HOVER IMAGE)
           ========================================================================== */
        .container {
            padding: 60px 4%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .breadcrumb {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-bottom: 12px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .titulo-secao {
            font-weight: 900;
            font-size: 2.5rem;
            margin-bottom: 50px;
            text-transform: uppercase;
            letter-spacing: -1px;
            position: relative;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 35px;
        }

        .product-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 25px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 6px 15px var(--shadow-sm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card:hover {
            transform: translateY(-8px);
            border-color: rgba(227, 30, 36, 0.4);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        /* Contêiner da imagem preparado para o efeito Frente/Costas */
        .product-card .img-container {
            width: 100%;
            height: 280px;
            background-color: rgba(255,255,255,0.02);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
            position: relative; /* Essencial para alinhar as duas imagens sobrepostas */
        }

        .product-card img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        /* Configuração Inicial da Imagem de Costas */
        .product-card .img-costas {
            opacity: 0; /* Escondida por padrão */
        }

        /* Efeito ao passar o Mouse (Mousse) */
        .product-card:hover .img-frente {
            opacity: 0; /* Some a frente */
            transform: scale(1.03);
        }

        .product-card:hover .img-costas {
            opacity: 1; /* Aparece as costas */
            transform: scale(1.03);
        }

        .product-card h3 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--text-primary);
        }

        .product-card p {
            font-weight: 900;
            font-size: 1.4rem;
            color: var(--accent);
            margin-bottom: 22px;
        }

        .add-to-cart-btn {
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
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .add-to-cart-btn:hover {
            opacity: 0.9;
            transform: scale(1.01);
        }

        .red-line-divider {
            height: 4px;
            background-color: var(--accent);
            width: 100%;
            margin-top: 80px;
            border-radius: 2px;
        }

        /* ==========================================================================
           CHATBOT
           ========================================================================= */
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

        #chat-messages::-webkit-scrollbar {
            width: 5px;
        }
        #chat-messages::-webkit-scrollbar-thumb {
            background-color: var(--border-color);
            border-radius: 10px;
        }

        .chat-link {
            color: var(--accent);
            text-decoration: underline;
            font-weight: 700;
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
            transition: transform 0.2s ease;
        }

        #chatbot-toggle:hover {
            transform: scale(1.08);
        }

        /* ==========================================================================
           FOOTER
           ========================================================================== */
        .main-footer {
            background-color: #000000;
            padding: 70px 4% 30px;
            border-top: 1px solid var(--border-color);
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

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 14px;
        }

        .footer-col ul li a {
            text-decoration: none;
            color: #888888;
            font-size: 0.85rem;
        }

        .footer-col ul li a:hover {
            color: var(--accent);
        }

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
                <li><a href="infantil.php" style="color: var(--accent);">Infantil</a></li>
                <li><a href="ofertas.php">Ofertas</a></li>
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
        <div class="breadcrumb">HOME > INFANTIL</div>
        <h2 class="titulo-secao">Coleção Infantil</h2>
        
        <div class="product-grid">
            <?php foreach ($produtos_infantis as $produto): ?>
                <div class="product-card">
                    <!-- Estrutura de Imagem Dupla para o Efeito Hover -->
                    <div class="img-container">
                        <img src="<?= htmlspecialchars($produto['imagem_frente']) ?>" alt="<?= htmlspecialchars($produto['alt_frente']) ?>" class="img-frente">
                        <img src="<?= htmlspecialchars($produto['imagem_costas']) ?>" alt="<?= htmlspecialchars($produto['alt_costas']) ?>" class="img-costas">
                    </div>
                    <div>
                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                        <p>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                    </div>
                    <button class="add-to-cart-btn">Adicionar ao Carrinho</button>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="red-line-divider"></div>
    </main>

    <div id="chatbot-window" aria-hidden="true">
        <div style="background-color: #e31e24; color: #fff; padding: 18px; font-weight: 700; display: flex; justify-content: space-between; align-items: center; letter-spacing: 0.5px; font-size: 0.95rem;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span>🤖</span> IA DWD STREET
            </div>
            <button id="close-chat" style="background: none; border: none; color: #fff; font-size: 1.5rem; cursor: pointer; line-height: 1;" aria-label="Fechar chat">&times;</button>
        </div>
        
        <div id="chat-messages">
            <div class="bot-msg" style="background-color: var(--btn-gray); padding: 12px 16px; border-radius: 14px 14px 14px 0px; align-self: flex-start; max-width: 85%; color: var(--text-primary); font-size: 0.85rem; line-height: 1.4; font-weight: 500; box-shadow: 0 2px 4px var(--shadow-sm);">
                Salve, <strong><?= htmlspecialchars($nomeUsuario); ?></strong>! Alguma dúvida sobre os tamanhos da nossa linha infantil ou sobre o seu pedido? Manda bala! ⚡
            </div>
        </div>
        
        <div style="padding: 15px; border-top: 1px solid var(--border-color); display: flex; gap: 8px; background-color: var(--bg-navbar);">
            <input type="text" id="chat-input" placeholder="Digite sua mensagem aqui..." style="flex: 1; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.85rem; outline: none; background: var(--bg-body); color: var(--text-primary);">
            <button id="btn-send-chat" style="background-color: #e31e24; color: #fff; border: none; padding: 0 18px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">ENVIAR</button>
        </div>
    </div>

    <button id="chatbot-toggle" aria-label="Abrir assistente virtual">🤖</button>

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
        // 1. SISTEMA INTEGRADO DE MODO ESCURO E CLARO
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
        // 2. MOTOR COGNITIVO DA IA (CHATBOT)
        // ==========================================================================
        const chatBotBtn = document.getElementById('chatbot-toggle');
        const chatWindow = document.getElementById('chatbot-window');
        const closeChatBtn = document.getElementById('close-chat');
        const chatInput = document.getElementById('chat-input');
        const btnSendChat = document.getElementById('btn-send-chat');
        const chatMessages = document.getElementById('chat-messages');

        const baseConhecimentoIA = [
            {
                chaves: [/trabalh/i, /vaga/i, /emprego/i, /curriculo/i, /tramp/i],
                resposta: "Quer colar e somar com a nossa equipe? Massa! <a href='trabalho.php' class='chat-link'>Clique aqui para ir para a página Trabalhe Conosco</a> e envie seu currículo! 🚀"
            },
            {
                chaves: [/loja/i, /fisica/i, /endereço/i, /onde fica/i, /perto/i, /bairro/i],
                resposta: "Quer ver os panos de perto? <a href='lojas.php' class='chat-link'>Clique aqui para ver Nossas Lojas</a> e descobrir o endereço mais próximo de você! 📍"
            },
            {
                chaves: [/sobre/i, /historia/i, /quem sao/i, /empresa/i, /dwd/i],
                resposta: "Quer entender de onde veio a nossa identidade streetwear? <a href='sobre.php' class='chat-link'>Clique aqui para acessar o Sobre a DWD Street</a>! 🕶️"
            },
            {
                chaves: [/sustentav/i, /sustentabilidade/i, /meio ambiente/i, /recicla/i],
                resposta: "Nós nos importamos com o futuro do planeta. <a href='sustentabilidade.php' class='chat-link'>Clique aqui para conhecer nossas ações de Sustentabilidade</a>. 🌿"
            },
            {
                chaves: [/troca/i, /devolv/i, /reembols/i, /arrepend/i, /nao serviu/i, /trocar/i],
                resposta: "Sem estresse! Se precisar trocar, o processo é bem simples. <a href='#' class='chat-link'>Clique aqui para abrir as solicitações de Troca</a>. Você tem até 7 dias! 🔄"
            },
            {
                chaves: [/rastre/i, /pedido/i, /onde ta/i, /cadê/i, /compra/i, /status/i, /acompanh/i],
                resposta: "Para monitorar sua entrega, confira os detalhes na página <a href='meus_pedidos.php' class='chat-link'>Meus Pedidos</a>! 📦"
            },
            {
                chaves: [/duvida/i, /faq/i, /pergunta/i, /ajuda/i],
                resposta: "Tem alguma dúvida pontual sobre a plataforma? <a href='#' class='chat-link'>Clique aqui para ver as Dúvidas Frequentes (FAQ)</a>. ❓"
            },
            {
                chaves: [/contato/i, /suporte/i, /telefone/i, /whatsapp/i, /email/i],
                resposta: "Precisa falar diretamente com o nosso time de suporte humano? Vá na nossa seção de atendimento no rodapé! 📞"
            },
            {
                chaves: [/carrinho/i, /sacola/i, /fechar/i],
                resposta: "Pronto para finalizar o seu visual? <a href='carrinho.php' class='chat-link'>Clique aqui para ir para o Carrinho de Compras</a>. 🛒"
            },
            {
                chaves: [/montador/i, /outfit/i, /look/i],
                resposta: "Crie combinações insanas agora! <a href='montador.php' class='chat-link'>Clique aqui para usar o Montador de Outfit</a>! 🎨"
            },
            {
                chaves: [/oferta/i, /promo/i, /desconto/i, /liquida/i],
                resposta: "Quem não curte economizar, né? <a href='ofertas.php' class='chat-link'>Clique aqui para ver a aba de Ofertas</a>! 💥"
            },
            {
                chaves: [/masculino/i, /homem/i],
                resposta: "Confira bermudas e casacos irados. <a href='masculino.php' class='chat-link'>Clique aqui para ver a Coleção Masculina</a>. 🛹"
            },
            {
                chaves: [/feminino/i, /mulher/i, /menina/i],
                resposta: "Tops, calças confortáveis e blusas exclusivas. <a href='feminino.php' class='chat-link'>Clique aqui para ver a Coleção Feminina</a>. ✨"
            },
            {
                chaves: [/infantil/i, /crianca/i, /kids/i],
                resposta: "Roupa com estilo e conforto para a criançada? <a href='infantil.php' class='chat-link'>Clique aqui para ver a Coleção Infantil</a>. 👶🛹"
            },
            {
                chaves: [/oi/i, /olá/i, /salve/i, /eae/i, /bom dia/i, /boa tarde/i, /boa noite/i],
                resposta: "Salve, irmão! Tudo na paz? Sou a Inteligência Artificial da DWD Street. Me diz aí, o que você está procurando hoje?"
            }
        ];

        if (chatBotBtn && chatWindow && closeChatBtn) {
            chatBotBtn.addEventListener('click', () => {
                const isHidden = chatWindow.style.display === 'none' || chatWindow.style.display === '';
                chatWindow.style.display = isHidden ? 'flex' : 'none';
                chatWindow.setAttribute('aria-hidden', !isHidden);
            });
            closeChatBtn.addEventListener('click', () => { 
                chatWindow.style.display = 'none'; 
                chatWindow.setAttribute('aria-hidden', 'true');
            });
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
                let respostaFinal = "Não captei perfeitamente, mano. 😕 Tente palavras diretas como 'trabalho', 'lojas', 'trocas', 'carrinho' ou 'outfit'!";
                const msgMinuscula = textoOriginal.toLowerCase();
                
                for (let item of baseConhecimentoIA) {
                    let matchFound = item.chaves.some(regex => regex.test(msgMinuscula));
                    if (matchFound) {
                        respostaFinal = item.resposta;
                        break;
                    }
                }
                adicionarMensagem(respostaFinal, 'bot');
            }, 400);
        }

        if(btnSendChat && chatInput) {
            btnSendChat.addEventListener('click', enviarMensagemDigitada);
            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') enviarMensagemDigitada();
            });
        }

        // ==========================================================================
        // 3. LÓGICA DO CARRINHO (LOCALSTORAGE)
        // ==========================================================================
        document.addEventListener("DOMContentLoaded", () => {
            const badge = document.getElementById('cart-count');
            function atualizaBadge() {
                let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
                let total = carrinho.reduce((soma, item) => soma + item.quantidade, 0);
                if(badge) badge.textContent = `(${total})`;
            }
            atualizaBadge();

            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const card = e.target.closest('.product-card');
                    const nome = card.querySelector('h3').textContent;
                    // Correção simples para pegar o valor numérico correto independente das tags de imagem adicionais
                    const precoText = card.querySelector('p').textContent;
                    const preco = parseFloat(precoText.replace('R$', '').replace('.','').replace(',','.').trim());
                    
                    let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
                    let item = carrinho.find(i => i.nome === nome);
                    
                    if(item) {
                        item.quantidade++;
                    } else {
                        carrinho.push({ nome: nome, preco: preco, quantity: 1 });
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