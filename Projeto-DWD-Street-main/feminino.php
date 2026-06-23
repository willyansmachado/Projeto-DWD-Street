<?php
// Evita erro caso a variável não venha do login/sessão
$nomeUsuario = $nomeUsuario ?? 'Visitante';

// BANCO DE DADOS SIMULADO - PRODUTOS FEMININOS
$produtos_femininos = [
    [
        "id" => 1,
        "nome" => "Cropped DWD Logo",
        "preco" => 89.90,
        "imagem" => "assets/img/camiseta_banner.png",
        "imagem_hover" => "assets/img/cropped_hover.png", // <- ADICIONA A IMAGEM DO HOVER AQUI
        "alt" => "Cropped"
    ],
    [
        "id" => 2,
        "nome" => "Calça Jogger Moletom",
        "preco" => 189.90,
        "imagem" => "assets/img/camiseta_banner.png",
        "imagem_hover" => "assets/img/calca_hover.png", // <- ADICIONA A IMAGEM DO HOVER AQUI
        "alt" => "Calça Jogger"
    ],
    [
        "id" => 3,
        "nome" => "Jaqueta Corta-Vento",
        "preco" => 229.90,
        "imagem" => "assets/img/camiseta_banner.png",
        "imagem_hover" => "assets/img/jaqueta_hover.png", // <- ADICIONA A IMAGEM DO HOVER AQUI
        "alt" => "Corta-vento"
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feminino | DWD Street</title>
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

        /* ==========================================================================
           LOGO ATUALIZADO (Estilo Inclinado / Itálico)
           ========================================================================== */
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
           CONTEÚDO PRINCIPAL E GRID DE PRODUTOS
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
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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

        /* CONFIGURAÇÃO DO CONTAINER DA IMAGEM E EFEITO HOVER */
        .product-card .img-container {
            position: relative; /* Necessário para sobrepor as imagens */
            width: 100%;
            height: 280px;
            background-color: rgba(255,255,255,0.02);
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
        }

        /* Ambas as imagens ficam uma sobre a outra */
        .product-card img.img-default,
        .product-card img.img-hover {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.5s ease, transform 0.5s ease; /* Animação suave */
        }

        /* A imagem de hover começa invisível */
        .product-card img.img-hover {
            opacity: 0;
        }

        /* Quando passar o mouse no CARD: a imagem padrão some, a hover aparece e dá um leve zoom */
        .product-card:hover img.img-default {
            opacity: 0;
        }

        .product-card:hover img.img-hover {
            opacity: 1;
            transform: scale(1.06);
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
        }

        .auth-btn:hover {
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
           CHATBOT (ESTILIZAÇÃO MODERNA V3)
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
                <li><a href="feminino.php" style="color: var(--accent);">Feminino</a></li>
                <li><a href="infantil.php">Infantil</a></li>
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
        <div class="breadcrumb">HOME > FEMININO</div>
        <h2 class="titulo-secao">Coleção Feminina</h2>
        
        <div class="product-grid">
            <?php foreach ($produtos_femininos as $produto): ?>
                <div class="product-card">
                    <div class="img-container">
                        <img class="img-default" src="<?= $produto['imagem'] ?>" alt="<?= $produto['alt'] ?>">
                        <img class="img-hover" src="<?= $produto['imagem_hover'] ?>" alt="<?= $produto['alt'] ?> - Vestindo">
                    </div>
                    <div>
                        <h3><?= $produto['nome'] ?></h3>
                        <p>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                    </div>
                    <button class="auth-btn">Adicionar ao Carrinho</button>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="red-line-divider"></div>
    </main>

    <div id="chatbot-window">
        <div style="background-color: #e31e24; color: #fff; padding: 18px; font-weight: 700; display: flex; justify-content: space-between; align-items: center; letter-spacing: 0.5px; font-size: 0.95rem;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span>🤖</span> IA DWD STREET
            </div>
            <button id="close-chat" style="background: none; border: none; color: #fff; font-size: 1.5rem; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        
        <div id="chat-messages">
            <div class="bot-msg" style="background-color: var(--btn-gray); padding: 12px 16px; border-radius: 14px 14px 14px 0px; align-self: flex-start; max-width: 85%; color: var(--text-primary); font-size: 0.85rem; line-height: 1.4; font-weight: 500; box-shadow: 0 2px 4px var(--shadow-sm);">
                Salve, <strong><?= htmlspecialchars($nomeUsuario); ?></strong>! Sou a inteligência artificial da DWD. Mande qualquer dúvida ou o que você está procurando no site que eu te guio na hora! ⚡
            </div>
        </div>
        
        <div style="padding: 15px; border-top: 1px solid var(--border-color); display: flex; gap: 8px; background-color: var(--bg-navbar);">
            <input type="text" id="chat-input" placeholder="Digite sua mensagem aqui..." style="flex: 1; padding: 12px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 0.85rem; outline: none; background: var(--bg-body); color: var(--text-primary);">
            <button id="btn-send-chat" style="background-color: #e31e24; color: #fff; border: none; padding: 0 18px; border-radius: 8px; font-weight: 700; font-size: 0.8rem; cursor: pointer;">ENVIAR</button>
        </div>
    </div>

    <button id="chatbot-toggle" style="position: fixed; bottom: 25px; right: 25px; background-color: #e31e24; color: #fff; border: none; width: 60px; height: 60px; border-radius: 50%; font-size: 1.8rem; cursor: pointer; box-shadow: 0 6px 20px rgba(227, 30, 36, 0.4); z-index: 9999; display: flex; align-items: center; justify-content: center; transition: transform 0.2s ease;">
        🤖
    </button>

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
                    <li><a href="essential.php">Linha Essential</a></li>
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
            { chaves: [/trabalh/i, /vaga/i, /emprego/i], resposta: "Quer colar com a gente? <a href='trabalho.php' class='chat-link'>Clique aqui para o Trabalhe Conosco</a>! 🚀" },
            { chaves: [/loja/i, /fisica/i, /endereço/i], resposta: "Quer ver os panos de perto? <a href='lojas.php' class='chat-link'>Clique aqui para ver Nossas Lojas</a>! 📍" },
            { chaves: [/sobre/i, /historia/i], resposta: "<a href='sobre.php' class='chat-link'>Clique aqui para acessar a História da DWD Street</a>! 🕶️" },
            { chaves: [/troca/i, /devolv/i, /reembols/i], resposta: "Sem estresse! <a href='#' class='chat-link'>Clique aqui para abrir solicitação de Troca</a>. 🔄" },
            { chaves: [/rastre/i, /pedido/i, /onde ta/i], resposta: "Acompanhe sua entrega em <a href='meus_pedidos.php' class='chat-link'>Meus Pedidos</a>! 📦" },
            { chaves: [/carrinho/i, /sacola/i], resposta: "Pronto pra fechar? <a href='carrinho.php' class='chat-link'>Vá para o Carrinho de Compras</a>. 🛒" },
            { chaves: [/montador/i, /outfit/i, /look/i], resposta: "Crie combinações insanas! <a href='montador.php' class='chat-link'>Use o Montador de Outfit</a>! 🎨" },
            { chaves: [/oferta/i, /promo/i, /desconto/i], resposta: "Economize nos panos! <a href='ofertas.php' class='chat-link'>Veja as Ofertas</a>! 💥" },
            { chaves: [/masculino/i, /homem/i], resposta: "Confira a <a href='masculino.php' class='chat-link'>Coleção Masculina</a>. 🛹" },
            { chaves: [/feminino/i, /mulher/i], resposta: "Confira a <a href='feminino.php' class='chat-link'>Coleção Feminina</a>. ✨" },
            { chaves: [/oi/i, /olá/i, /salve/i, /eae/i], resposta: "Salve, irmão! Tudo na paz? O que você está procurando hoje?" }
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
                let respostaFinal = "Não captei perfeitamente, mano. 😕 Tente palavras como 'trabalho', 'lojas', 'trocas' ou 'carrinho'!";
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

            document.querySelectorAll('.auth-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const card = e.target.closest('.product-card');
                    const nome = card.querySelector('h3').textContent;
                    const preco = parseFloat(card.querySelector('p').textContent.replace('R$', '').replace('.','').replace(',','.').trim());
                    
                    let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
                    let item = carrinho.find(i => i.nome === nome);
                    
                    if(item) { item.quantidade++; } else { carrinho.push({ nome: nome, preco: preco, quantity: 1, quantidade: 1 }); }
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