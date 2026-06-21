<?php
session_start();

$nomeUsuario = "Visitante";

if(isset($_SESSION["nome"])){
    $nomeUsuario = $_SESSION["nome"];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWD Street | Oficial</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        /* ====================================
           VARIÁVEIS E CONFIGURAÇÕES GLOBAIS DWD
           ==================================== */
        :root {
            --primary: #e31e24;
            --primary-hover: #c1181e;
            --dark-base: #0d0d0d;
            --dark-card: #161616;
            --dark-border: #262626;
            --light-base: #ffffff;
            --light-card: #f8f9fa;
            --light-border: #e9ecef;
            --transition-smooth: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-base);
            color: #111;
            transition: background-color 0.3s ease, color 0.3s ease;
            overflow-x: hidden;
        }

        body.dark-mode {
            background-color: var(--dark-base);
            color: var(--light-base);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #111;
        }
        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        /* ====================================
           TOP BAR & NAVBAR PREMIUM
           ==================================== */
        .top-bar {
            background: #000;
            color: #fff;
            text-align: center;
            padding: 10px 20px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            border-bottom: 2px solid var(--primary);
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 4%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid var(--light-border);
            transition: var(--transition-smooth);
        }

        body.dark-mode .navbar {
            background: rgba(13, 13, 13, 0.95);
            border-bottom: 1px solid var(--dark-border);
        }

        .logo {
            font-size: 1.75rem;
            font-weight: 900;
            letter-spacing: -1.5px;
            text-transform: uppercase;
            color: inherit;
        }

        .logo span {
            color: var(--primary);
            font-style: italic;
        }

        .main-nav .nav-links {
            display: flex;
            list-style: none;
            gap: 24px;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            text-decoration: none;
            color: inherit;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: relative;
            padding: 8px 0;
            transition: var(--transition-smooth);
            opacity: 0.8;
        }

        .nav-links a:hover {
            opacity: 1;
            color: var(--primary);
        }

        /* Mega Menu Inovador */
        .has-mega {
            position: relative;
        }

        .mega-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: var(--light-base);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 30px;
            display: none;
            gap: 40px;
            min-width: 650px;
            border: 1px solid var(--light-border);
            z-index: 1000;
            opacity: 0;
            transition: var(--transition-smooth);
        }

        body.dark-mode .mega-menu {
            background: var(--dark-card);
            border-color: var(--dark-border);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
        }

        .has-mega.active .mega-menu,
        .has-mega:hover .mega-menu {
            display: flex;
            opacity: 1;
            transform: translateX(-50%) translateY(5px);
        }

        .mega-col h4 {
            font-size: 0.9rem;
            text-transform: uppercase;
            color: var(--primary);
            margin: 0 0 15px 0;
            letter-spacing: 1.5px;
            font-weight: 900;
        }

        .mega-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mega-col ul a {
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: none;
            color: #555;
            opacity: 1;
        }

        body.dark-mode .mega-col ul a {
            color: #bbb;
        }

        .mega-col ul a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        /* Ações do Header (Botões e User) */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-info {
            font-size: 0.75rem;
            text-transform: uppercase;
            text-align: right;
            line-height: 1.3;
            margin-right: 5px;
        }

        .user-info span {
            color: #777;
            display: block;
        }

        .header-btn, .logout-btn, .theme-btn {
            background: transparent;
            border: 1px solid var(--light-border);
            color: inherit;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: var(--transition-smooth);
        }

        body.dark-mode .header-btn, 
        body.dark-mode .logout-btn, 
        body.dark-mode .theme-btn {
            border-color: var(--dark-border);
        }

        .header-btn:hover {
            background: #000;
            color: #fff;
            border-color: #000;
            transform: translateY(-2px);
        }

        body.dark-mode .header-btn:hover {
            background: #fff;
            color: #000;
            border-color: #fff;
        }

        .logout-btn:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .theme-btn {
            font-size: 1rem;
            padding: 10px;
            justify-content: center;
            width: 42px;
            height: 42px;
        }

        .theme-btn:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* ====================================
           CINEMATIC SLIDER CORREÇÃO & OVERHAUL
           ==================================== */
        .main-slider {
            position: relative;
            height: 75vh;
            width: 100%;
            background: #000;
            overflow: hidden;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transform: scale(1.08);
            transition: opacity 1.2s ease-in-out, transform 4s linear;
            display: flex;
            align-items: center;
            justify-content: center; /* Centraliza horizontalmente o bloco de texto */
        }

        .slide.active {
            opacity: 1;
            transform: scale(1);
        }

        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0.85) 100%);
        }

        .banner-content {
            position: relative;
            z-index: 10;
            text-align: center; /* Centraliza o texto das tags internas */
            color: #fff;
            max-width: 850px;
            width: 100%;        /* Ocupa o espaço correto antes de bater no limite de 850px */
            margin: 0 auto;     /* Alinha o bloco inteiro no meio da tela */
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Garante que o botão abaixo do título também centralize */
        }

        .banner-content .subtitle {
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 5px;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .banner-content h1 {
            font-size: 5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -2px;
            margin: 0 0 30px 0;
            line-height: 0.95;
        }

        .banner-content h1 span {
            color: transparent;
            -webkit-text-stroke: 1.5px #fff;
        }

        .btn-banner {
            display: inline-block;
            background: #fff;
            color: #000;
            padding: 16px 36px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            border: 2px solid #fff;
            transition: var(--transition-smooth);
        }

        .btn-banner:hover {
            background: transparent;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255,255,255,0.1);
        }

        /* ====================================
           QUIZ BANNER ASYMMETRIC STREETWEAR
           ==================================== */
        .quiz-banner {
            background: linear-gradient(135deg, #111111 0%, #1c1c1c 100%);
            color: #fff;
            padding: 60px 40px;
            text-align: center;
            margin: 60px 4%;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        body.dark-mode .quiz-banner {
            background: linear-gradient(135deg, #050505 0%, #121212 100%);
            border: 1px solid var(--dark-border);
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
        }

        .quiz-banner h2 {
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            font-size: 2.5rem;
        }

        .quiz-banner h2 span {
            color: var(--primary);
            background: linear-gradient(180deg, transparent 65%, rgba(227,30,36,0.2) 65%);
        }

        .quiz-banner p {
            font-size: 1.15rem;
            margin-bottom: 35px;
            color: #aaa;
            font-weight: 400;
        }

        .btn-quiz {
            background-color: var(--primary);
            color: #fff;
            padding: 18px 40px;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 6px;
            letter-spacing: 1px;
            display: inline-block;
            transition: var(--transition-smooth);
            box-shadow: 0 6px 20px rgba(227, 30, 36, 0.2);
        }

        .btn-quiz:hover {
            background-color: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 12px 26px rgba(227, 30, 36, 0.4);
        }

        /* ====================================
           BENEFITS SECTION BRUTALIST
           ==================================== */
        .benefits {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 30px;
            padding: 50px 4%;
            background: var(--light-card);
            margin: 60px 0;
            border-radius: 0;
        }

        body.dark-mode .benefits {
            background: var(--dark-card);
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 20px;
            max-width: 320px;
        }

        .benefit-item .icon {
            font-size: 2.2rem;
            background: rgba(227, 30, 36, 0.08);
            padding: 16px;
            border-radius: 12px;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .benefit-item h4 {
            margin: 0 0 6px 0;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .benefit-item p {
            margin: 0;
            font-size: 0.85rem;
            color: #666;
            line-height: 1.4;
        }

        body.dark-mode .benefit-item p {
            color: #999;
        }

        /* ====================================
           PRODUCT GRID HYPEBEAST LOOK
           ==================================== */
        .product-grid-container {
            padding: 60px 4%;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -1.5px;
            margin-bottom: 40px;
            text-align: center;
        }

        .section-title span {
            color: var(--primary);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 35px;
        }

        .product-card {
            background: var(--light-base);
            border: 1px solid var(--light-border);
            border-radius: 16px;
            overflow: hidden;
            transition: var(--transition-smooth);
            position: relative;
        }

        body.dark-mode .product-card {
            background: var(--dark-card);
            border-color: var(--dark-border);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        body.dark-mode .product-card:hover {
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        .product-image {
            position: relative;
            background: #f0f0f0;
            padding-top: 110%; /* Proporção Streetwear verticalizada */
            overflow: hidden;
        }

        body.dark-mode .product-image {
            background: #1e1e1e;
        }

        .product-image {
    position: relative;
    background: #f0f0f0;
    padding-top: 110%;
    overflow: hidden;
}

.product-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s ease;
}

.img-front {
    opacity: 1;
    z-index: 1;
}

.img-hover {
    opacity: 0;
    z-index: 2;
}

.product-card:hover .img-front {
    opacity: 0;
    transform: scale(1.08);
}

.product-card:hover .img-hover {
    opacity: 1;
    transform: scale(1.08);
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}
        

        .product-card:hover .product-image img {
            transform: scale(1.06);
        }

        .product-image .badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #000;
            color: #fff;
            padding: 6px 14px;
            font-size: 0.7rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 4px;
            z-index: 2;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .product-info {
            padding: 25px;
            text-align: left; /* Alinhamento moderno assimétrico */
        }

        .product-info h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 10px 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-info .price {
            font-size: 1.35rem;
            font-weight: 900;
            color: var(--primary);
            margin: 0 0 20px 0;
        }

        .btn-add {
            width: 100%;
            background: #000;
            color: #fff;
            border: none;
            padding: 14px;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 8px;
            transition: var(--transition-smooth);
        }

        body.dark-mode .btn-add {
            background: #fff;
            color: #000;
        }

        .btn-add:hover {
            background: var(--primary);
            color: #fff;
            transform: scale(1.02);
        }

        body.dark-mode .btn-add:hover {
            background: var(--primary);
            color: #fff;
        }

        /* ====================================
           CHATBOT SMART WINDOW REVOLUTION
           ==================================== */
        #chatbot-window {
            border-radius: 20px !important;
            box-shadow: 0 15px 40px rgba(0,0,0,0.25) !important;
            border: 1px solid var(--light-border) !important;
        }

        body.dark-mode #chatbot-window {
            background-color: #121212 !important;
            border-color: #222 !important;
            color: #fff !important;
            box-shadow: 0 20px 50px rgba(0,0,0,0.6) !important;
        }

        body.dark-mode #chat-messages {
            background-color: #0a0a0a !important;
        }

        body.dark-mode .bot-msg {
            background-color: #1a1a1a !important;
            color: #eee !important;
            border: 1px solid #252525 !important;
        }

        body.dark-mode .chat-footer-bg {
            background-color: #121212 !important;
            border-top-color: #222 !important;
        }

        body.dark-mode #chat-input {
            background-color: #181818 !important;
            border-color: #2c2c2c !important;
            color: #fff !important;
        }

        .chat-link {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            border-bottom: 2px solid var(--primary);
            transition: var(--transition-smooth);
        }

        .chat-link:hover {
            color: var(--primary-hover);
            border-bottom-color: var(--primary-hover);
        }

        body.dark-mode .chat-link {
            color: #ff4d52;
            border-bottom-color: #ff4d52;
        }

        #chatbot-toggle {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), background-color 0.2s !important;
        }

        /* ====================================
           MODERN INDUSTRIAL FOOTER
           ==================================== */
        .main-footer {
            background: #000;
            color: #fff;
            padding: 80px 4% 30px 4%;
            margin-top: 80px;
            border-top: 4px solid var(--primary);
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer-col h4 {
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0 0 25px 0;
            color: var(--primary);
            font-weight: 900;
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-col ul a {
            color: #aaa;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: var(--transition-smooth);
        }

        .footer-col ul a:hover {
            color: #fff;
            padding-left: 6px;
        }

        .footer-divider {
            border: 0;
            height: 1px;
            background: #222;
            margin: 40px 0;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 40px;
        }

        .footer-payments h5, .footer-socials h5 {
            margin: 0 0 15px 0;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #666;
            font-weight: 700;
        }

        .social-icons {
            display: flex;
            gap: 20px;
        }

        .social-icons a {
            color: #aaa;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 700;
            transition: var(--transition-smooth);
        }

        .social-icons a:hover {
            color: var(--primary);
            transform: scale(1.05);
        }

        .footer-copyright {
            text-align: center;
            font-size: 0.75rem;
            color: #444;
            border-top: 1px solid #111;
            padding-top: 25px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="top-bar">ENTREGA RÁPIDA EM TODA JOINVILLE | 10% OFF NA PRIMEIRA COMPRA</div>

    <header class="navbar">

        <div class="logo">
            DWD<span>STREET</span>
        </div>

        <nav class="main-nav">
            <ul class="nav-links">

                <li class="has-mega">
                    <a href="#">CATEGORIAS ▾</a>

                    <div class="mega-menu">

                        <div class="mega-col">
                            <h4>Acessórios</h4>
                            <ul>
                                <li><a href="categorias/relogios.php">Relógios</a></li>
                                <li><a href="categorias/bones.php">Bonés</a></li>
                                <li><a href="categorias/joias.php">Jóias</a></li>
                            </ul>
                        </div>

                        <div class="mega-col">
                            <h4>Feminino</h4>
                            <ul>
                                <li><a href="categorias/camisas.php">Camisas</a></li>
                                <li><a href="categorias/plus.php">Plus Size</a></li>
                                 <li><a href="categorias/calcasf.php">Calças Femininas</a></li>
                            </ul>
                        </div>

                        <div class="mega-col">
                            <h4>Masculino</h4>
                            <ul>
                                <li><a href="categorias/t-shirts.php">T-Shirts</a></li>
                                <li><a href="categorias/agasalhos.php">Agasalhos</a></li>
                                <li><a href="categorias/jorts.php">Jorts</a></li>
                            </ul>
                        </div>
                    </div>
                </li>

                <li><a href="masculino.php">MASCULINO</a></li>
                <li><a href="feminino.php">FEMININO</a></li>
                <li><a href="infantil.php">INFANTIL</a></li>
                <li><a href="ofertas.php">OFERTAS</a></li>
                <li><a href="montador.php">MONTADOR DE OUTFIT</a></li>

            </ul>
        </nav>

        <div class="header-actions">

            <div class="user-info">
                <span>Usuário Logado</span>
                <strong><?php echo $nomeUsuario; ?></strong>
            </div>

            <a href="meus_pedidos.php" class="header-btn">
                📦 Pedidos
            </a>

            <a href="carrinho.php" class="header-btn">
                🛒 Carrinho
            </a>

            <button id="theme-toggle" class="theme-btn">
                🌙
            </button>

            <a href="logout.php" class="logout-btn">
                🚪 Sair
            </a>

        </div>

    </header>

    <main>
        <section class="main-slider">
            
            <div class="slide active" style="background-image: url('assets/css/img/banner1.png');">
                <div class="slide-overlay"></div>
                <div class="banner-content">
                    <p class="subtitle">Nova linha casual</p>
                    <h1>BLOCK <span>CORE</span></h1>
                    <a href="masculino.php" class="btn-banner">VER TODOS OS MODELOS</a>
                </div>
            </div>

            <div class="slide" style="background-image: url('assets/css/img/banner4.png');">
                <div class="slide-overlay"></div>
                <div class="banner-content">
                    <p class="subtitle">Coleção de Inverno</p>
                    <h1>MOLETONS <span>DWD</span></h1>
                    <a href="ofertas.php" class="btn-banner">APROVEITE 30% OFF</a>
                </div>
            </div>

            <div class="slide" style="background-image: url('assets/css/img/banner3.png');">
                <div class="slide-overlay"></div>
                <div class="banner-content">
                    <p class="subtitle">Skate Culture</p>
                    <h1>STREET <span>WEAR</span></h1>
                    <a href="produtos.php" class="btn-banner">VER LANÇAMENTOS</a>
                </div>
            </div>

        </section>

        <section class="quiz-banner">
            <h2>Descubra seu <span>Estilo</span></h2>
            <p>Responda algumas perguntas e nós te mostramos os looks que são a sua cara.</p>
            <a href="quiz.php" class="btn-quiz">Começar o Teste</a>
        </section>

    </main>

    <section class="benefits">
        <div class="benefit-item">
            <span class="icon">🚚</span>
            <div>
                <h4>FRETE GRÁTIS</h4>
                <p>Para compras acima de R$ 299</p>
            </div>
        </div>
        <div class="benefit-item">
            <span class="icon">💳</span>
            <div>
                <h4>6X SEM JUROS</h4>
                <p>No cartão de crédito</p>
            </div>
        </div>
        <div class="benefit-item">
            <span class="icon">🔄</span>
            <div>
                <h4>TROCA FÁCIL</h4>
                <p>Até 7 dias para devolver</p>
            </div>
        </div>
    </section>

    <section class="product-grid-container">
        <h2 class="section-title">DESTAQUES <span>DWD</span></h2>
        
        <div class="product-grid">
            <div class="product-card">
              <div class="product-image">
    <img class="img-front" src="assets/css/img/produto1.png" alt="Produto">
    <img class="img-hover" src="assets/css/img/produto1-hover.png" alt="Produto">
    <span class="badge">🔥 Novo</span>
</div>
                <div class="product-info">
                    <h3>Camisa Block Core JEC</h3>
                    <p class="price">R$ 199,90</p>

                    <form action="adicionar_carrinho.php" method="POST">
                        <input type="hidden" name="produto_nome" value="Camisa Block Core JEC">
                        <input type="hidden" name="preco" value="199.90">
                        <input type="hidden" name="imagem" value="assets/css/img/produto1.png">

                        <button type="submit" class="btn-add">
                            ADICIONAR AO CARRINHO
                        </button>
                    </form>
                </div> 
            </div>

            <div class="product-card">
               <div class="product-image">
    <img class="img-front" src="assets/css/img/camisa1index.png" alt="Produto">
    <img class="img-hover" src="assets/css/img/camisa2.png" alt="Produto">
    <span class="badge">🔥 Drop</span>
</div>
                <div class="product-info">
                    <h3>Moletom DWD Street Black</h3>
                    <p class="price">R$ 249,90</p>

                    <form action="adicionar_carrinho.php" method="POST">
                        <input type="hidden" name="produto_nome" value="Moletom DWD Street Black">
                        <input type="hidden" name="preco" value="249.90">
                        <input type="hidden" name="imagem" value="assets/css/img/produto2.png">

                        <button type="submit" class="btn-add">
                            ADICIONAR AO CARRINHO
                        </button>
                    </form>
                </div>
            </div>

            <div class="product-card">
             <div class="product-image">
    <img class="img-front" src="assets/css/img/produto3.png" alt="Produto">
    <img class="img-hover" src="assets/css/img/produto3-hover.png" alt="Produto">
    <span class="badge">🔥 Destaque</span>
</div>
                <div class="product-info">
                    <h3>Boné Snapback DWD</h3>
                    <p class="price">R$ 89,90</p>

                    <form action="adicionar_carrinho.php" method="POST">
                        <input type="hidden" name="produto_nome" value="Boné Snapback DWD">
                        <input type="hidden" name="preco" value="89.90">
                        <input type="hidden" name="imagem" value="assets/css/img/produto3.png">

                        <button type="submit" class="btn-add">
                            ADICIONAR AO CARRINHO
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <div id="chatbot-window" style="position: fixed; bottom: 95px; right: 25px; width: 340px; height: 460px; background-color: #fff; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.25); z-index: 9999; display: none; flex-direction: column; overflow: hidden; font-family: 'Montserrat', sans-serif; border: 1px solid #eee; transition: background-color 0.3s, border-color 0.3s;">
        <div style="background-color: #e31e24; color: #fff; padding: 15px; font-weight: 700; display: flex; justify-content: space-between; align-items: center; letter-spacing: 0.5px; font-size: 0.95rem;">
            <div style="display: flex; align-items: center; gap: 8px;">
                <span>🤖</span> IA DWD STREET
            </div>
            <button id="close-chat" style="background: none; border: none; color: #fff; font-size: 1.4rem; cursor: pointer; line-height: 1; padding: 0 5px;">&times;</button>
        </div>
        
        <div id="chat-messages" style="flex: 1; padding: 15px; overflow-y: auto; background-color: #f8f9fa; display: flex; flex-direction: column; gap: 12px; transition: background-color 0.3s;">
            <div class="bot-msg" style="background-color: #e9ecef; padding: 10px 14px; border-radius: 12px 12px 12px 0px; align-self: flex-start; max-width: 85%; color: #212529; font-size: 0.85rem; line-height: 1.4; font-weight: 500; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                Salve, <strong><?php echo $nomeUsuario; ?></strong>! Sou a inteligência artificial da DWD. Mande qualquer dúvida ou o que você está procurando no site que eu te guio na hora! ⚡
            </div>
        </div>
        
        <div class="chat-footer-bg" style="padding: 12px; border-top: 1px solid #eee; display: flex; gap: 8px; background-color: #fff; transition: background-color 0.3s, border-color 0.3s;">
            <input type="text" id="chat-input" placeholder="Digite sua mensagem aqui..." style="flex: 1; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-family: 'Montserrat', sans-serif; font-size: 0.85rem; outline: none; transition: all 0.2sordem;" onfocus="this.style.borderColor='#e31e24'" onblur="this.style.borderColor='#ddd'">
            <button id="btn-send-chat" style="background-color: #e31e24; color: #fff; border: none; padding: 0 16px; border-radius: 6px; font-weight: 700; font-size: 0.8rem; cursor: pointer; transition: background-color 0.2s; font-family: 'Montserrat', sans-serif;">ENVIAR</button>
        </div>
    </div>

    <button id="chatbot-toggle" style="position: fixed; bottom: 25px; right: 25px; background-color: #e31e24; color: #fff; border: none; width: 60px; height: 60px; border-radius: 50%; font-size: 1.8rem; cursor: pointer; box-shadow: 0 4px 16px rgba(227, 30, 36, 0.4); z-index: 9999; display: flex; align-items: center; justify-content: center; transition: transform 0.2s, background-color 0.2s;" onmouseover="this.style.transform='scale(1.08)'" onmouseout="this.style.transform='scale(1)'">
        🤖
    </button>

    <script>
        // 1. MODO ESCURO - VERIFICAÇÃO IMEDIATA
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

        // MOTOR DE PROCESSAMENTO DE LINGUAGEM NATURAL E INTENÇÕES MAPPED COM BASE DO PRINT
        const chatBotBtn = document.getElementById('chatbot-toggle');
        const chatWindow = document.getElementById('chatbot-window');
        const closeChatBtn = document.getElementById('close-chat');
        const chatInput = document.getElementById('chat-input');
        const btnSendChat = document.getElementById('btn-send-chat');
        const chatMessages = document.getElementById('chat-messages');

        // Mapeamento dinâmico dos arquivos da DWD Street obtidos do print do seu VS Code
        const baseConhecimentoIA = [
            {
                chaves: [/trabalh/i, /vaga/i, /emprego/i, /curriculo/i, /tramp/i],
                resposta: "Quer colar e somar com a nossa equipe? Massa! <a href='rodapé/institucional/trabalho.php' class='chat-link'>Clique aqui para ir para a página Trabalhe Conosco</a> e envie seu currículo! 🚀"
            },
            {
                chaves: [/loja/i, /fisica/i, /endereço/i, /onde fica/i, /perto/i, /bairro/i],
                resposta: "Quer ver os panos de perto? <a href='rodapé/institucional/lojas.php' class='chat-link'>Clique aqui para ver Nossas Lojas</a> e descobrir o endereço mais próximo de você aqui na região! 📍"
            },
            {
                chaves: [/sobre/i, /historia/i, /quem sao/i, /empresa/i, /dwd/i],
                resposta: "Quer entender de onde veio a nossa identidade e cultura streetwear? <a href='rodapé/sobre.php' class='chat-link'>Clique aqui para acessar o Sobre a DWD Street</a>! 🕶️"
            },
            {
                chaves: [/sustentav/i, /sustentabilidade/i, /meio ambiente/i, /recicla/i],
                resposta: "Nós nos importamos com o futuro do nosso planeta. <a href='rodapé/institucional/sustentabilidade.php' class='chat-link'>Clique aqui para conhecer nossas ações de Sustentabilidade</a>. 🌿"
            },
            {
                chaves: [/troca/i, /devolv/i, /reembols/i, /arrepend/i, /nao serviu/i, /trocar/i],
                resposta: "Sem estresse! Se precisar trocar, o processo é bem simples. <a href='rodapé/trocas.html' class='chat-link'>Clique aqui para abrir as solicitações de Troca e Arrependimento</a>. Lembrando que você tem até 7 dias! 🔄"
            },
            {
                chaves: [/rastre/i, /pedido/i, /onde ta/i, /cadê/i, /compra/i, /status/i, /acompanh/i],
                resposta: "Para monitorar cada passo da sua entrega, <a href='rodapé/rastreio.php' class='chat-link'>clique aqui para ir ao Rastreio de Pedidos</a>. Você também pode conferir todos os detalhes em <a href='meus_pedidos.php' class='chat-link'>Meus Pedidos</a>! 📦"
            },
            {
                chaves: [/duvida/i, /faq/i, /pergunta/i, /ajuda/i, /frequente/i],
                resposta: "Tem alguma dúvida pontual sobre a plataforma? <a href='rodapé/faq.html' class='chat-link'>Clique aqui para ver as Dúvidas Frequentes (FAQ)</a> e ganhe tempo! ❓"
            },
            {
                chaves: [/contato/i, /fale conosco/i, /suporte/i, /telefone/i, /whatsapp/i, /email/i, /atend/i],
                resposta: "Precisa falar diretamente com o nosso time de suporte humano? <a href='rodapé/contato.html' class='chat-link'>Clique aqui para acessar nossa página de Contato</a>. 📞"
            },
            {
                chaves: [/cookie/i, /privacidade/i, /seguranç/i, /termo/i, /lei/i, /lgpd/i],
                resposta: "Sua navegação e seus dados estão totalmente seguros conosco. Confira nossas diretrizes completas em: <a href='rodapé/politicas/privacidade.php' class='chat-link'>Política de Privacidade</a> ou nos <a href='rodapé/politicas/termos.php' class='chat-link'>Termos e Condições</a>. 🔐"
            },
            {
                chaves: [/lançamento/i, /novo/i, /novidade/i, /drop/i, /chegou/i],
                resposta: "Fique por dentro das últimas tendências e do drop que acabou de sair das fábricas! <a href='rodapé/lançamentos.php' class='chat-link'>Clique aqui para ver os Lançamentos</a>! 🔥"
            },
            {
                chaves: [/essential/i, /basico/i, /linha basica/i, /essencial/i],
                resposta: "Quer peças versáteis para o dia a dia sem perder o estilo de rua? <a href='rodapé/essential.php' class='chat-link'>Clique aqui para acessar a Linha Essential</a>. 👕"
            },
            {
                chaves: [/carrinho/i, /sacola/i, /compra/i, /fechar/i],
                resposta: "Pronto para finalizar o seu visual? <a href='carrinho.php' class='chat-link'>Clique aqui para ir para o Carrinho de Compras</a>. 🛒"
            },
            {
                chaves: [/montador/i, /outfit/i, /combinar/i, /look/i],
                resposta: "Crie combinações insanas e mude seu estilo visual agora! <a href='montador.php' class='chat-link'>Clique aqui para usar o Montador de Outfit</a>! 🎨"
            },
            {
                chaves: [/quiz/i, /teste/i, /estilo/i],
                resposta: "Não sabe qual é a sua real vertente no streetwear? Descubra agora! <a href='quiz.php' class='chat-link'>Clique aqui para iniciar o seu Quiz de Estilo</a>. 🎯"
            },
            {
                chaves: [/oferta/i, /promo/i, /desconto/i, /barato/i, /liquida/i],
                resposta: "Quem não curte economizar, né? <a href='ofertas.php' class='chat-link'>Clique aqui para ver a aba de Ofertas</a> e aproveite os descontos ativos! 💥"
            },
            {
                chaves: [/masculino/i, /homem/i, /menino/i],
                resposta: "Confira bermudas, camisetas block core e casacos irados. <a href='masculino.php' class='chat-link'>Clique aqui para ver a Coleção Masculina</a>. 🛹"
            },
            {
                chaves: [/feminino/i, /mulher/i, /menina/i],
                resposta: "Tops, calças streetwear confortáveis e blusas exclusivas. <a href='feminino.php' class='chat-link'>Clique aqui para ver a Coleção Feminina</a>. ✨"
            },
            {
                chaves: [/infantil/i, /criança/i, /kids/i],
                resposta: "Estilo de rua vem desde pequeno! <a href='infantil.php' class='chat-link'>Clique aqui para conferir a Linha Infantil</a>. 🛹👶"
            },
            {
                chaves: [/entrar/i, /login/i, /conta/i, /cadastro/i, /perfil/i],
                resposta: "Para gerenciar seus dados ou acessar sua conta, vá na nossa página de <a href='login.php' class='chat-link'>Login</a> ou faça o seu <a href='cadastro.php' class='chat-link'>Cadastro</a> rápido! 👤"
            },
            {
                chaves: [/oi/i, /olá/i, /salve/i, /eae/i, /tudo bem/i, /bom dia/i, /boa tarde/i, /boa noite/i],
                resposta: "Salve, irmão! Tudo na paz? Sou a Inteligência Artificial da DWD Street. Me diz aí, o que você está procurando ou qual sua dúvida hoje?"
            }
        ];

        if (chatBotBtn && chatWindow && closeChatBtn) {
            chatBotBtn.addEventListener('click', () => {
                chatWindow.style.display = (chatWindow.style.display === 'none' || chatWindow.style.display === '') ? 'flex' : 'none';
            });

            closeChatBtn.addEventListener('click', () => {
                chatWindow.style.display = 'none';
            });
        }

        function adicionarMensagem(texto, remetente) {
            const novaMsg = document.createElement('div');
            
            if (remetente === 'usuario') {
                novaMsg.style.cssText = "background-color: #e31e24; color: #fff; padding: 10px 14px; border-radius: 12px 12px 0px 12px; align-self: flex-end; max-width: 85%; font-size: 0.85rem; line-height: 1.4; font-weight: 500; box-shadow: 0 1px 2px rgba(0,0,0,0.05);";
                novaMsg.textContent = texto; // Evita injeção de HTML do usuário
            } else {
                novaMsg.className = "bot-msg";
                novaMsg.style.cssText = "background-color: #e9ecef; padding: 10px 14px; border-radius: 12px 12px 12px 0px; align-self: flex-start; max-width: 85%; color: #212529; font-size: 0.85rem; line-height: 1.4; font-weight: 500; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: background-color 0.3s;";
                novaMsg.innerHTML = texto; // Permite os links HTML criados pela IA
            }
            
            chatMessages.appendChild(novaMsg);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Processador Inteligente baseado em RegEx 
        function processarIA(mensagemDoUsuario) {
            setTimeout(() => {
                let respostaFinal = "Não captei perfeitamente o que você quis dizer, mano. 😕 Tente usar palavras mais diretas sobre a página que busca (ex: 'trabalho', 'lojas físicas', 'trocas', 'lançamentos' ou 'outfit')!";
                
                // Varre a árvore de intenções procurando correspondências de RegEx
                for (let item of baseConhecimentoIA) {
                    let matchFound = item.chaves.some(regex => regex.test(mensagemDoUsuario));
                    if (matchFound) {
                        respostaFinal = item.resposta;
                        break;
                    }
                }
                
                adicionarMensagem(respostaFinal, 'bot');
            }, 450);
        }

        function enviarMensagemDigitada() {
            const textoOriginal = chatInput.value.trim();
            if (textoOriginal === '') return;

            adicionarMensagem(textoOriginal, 'usuario');
            chatInput.value = '';

            // Dispara o motor cognitivo da IA
            processarIA(textoOriginal.toLowerCase());
        }

        if(btnSendChat && chatInput) {
            btnSendChat.addEventListener('click', enviarMensagemDigitada);
            chatInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') enviarMensagemDigitada();
            });
        }

        // 2. CARROSSEL PASSANDO SOZINHO (A CADA 4 SEGUNDOS)
        const slides = document.querySelectorAll('.slide');
        let currentSlide = 0;

        if (slides.length > 0) {
            setInterval(() => {
                slides[currentSlide].classList.remove('active');
                currentSlide++;
                if (currentSlide >= slides.length) {
                    currentSlide = 0;
                }
                slides[currentSlide].classList.add('active');
            }, 4000); 
        }

        // 3. SELEÇÃO DE CATEGORIA (CLICK)
        const botaoCategoria = document.querySelector('.has-mega');
        if (botaoCategoria) {
            botaoCategoria.addEventListener('click', function () {
                botaoCategoria.classList.toggle('active');
            });
        }
    </script>

    <footer class="main-footer">
        <div class="footer-container">
            
            <div class="footer-col">
                <h4>Ajuda e Atendimento</h4>
                <ul>
                    <li><a href="rodapé/rastreio.php">Acompanhe seu pedido</a></li>
                    <li><a href="rodapé/faq.html">Dúvidas frequentes</a></li>
                    <li><a href="rodapé/contato.html">Fale com a gente</a></li>
                    <li><a href="rodapé/trocas.html">Troca e arrependimento</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Políticas e Regulamentos</h4>
                <ul>
                    <li><a href="rodapé/politicas/pol_coo.php">Política de cookies</a></li>
                    <li><a href="rodapé/politicas/privacidade.php">Política de privacidade</a></li>
                    <li><a href="rodapé/politicas/termos.php">Termos e condições</a></li>
                    <li><a href="rodapé/politicas/seguranca.php">Segurança do site</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Institucional</h4>
                <ul>
                    <li><a href="rodapé/sobre.php">Sobre a DWD Street</a></li>
                    <li><a href="rodapé/institucional/lojas.php">Nossas Lojas</a></li>
                    <li><a href="rodapé/institucional/trabalho.php">Trabalhe Conosco</a></li>
                    <li><a href="rodapé/institucional/sustentabilidade.php">Sustentabilidade</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Nossos Produtos</h4>
                <ul>
                    <li><a href="rodapé/lançamentos.php">Lançamentos</a></li>
                    <li><a href="masculino.php">Coleção Masculina</a></li>
                    <li><a href="infantil.php">Coleção Infantil</a></li>
                    <li><a href="rodapé/essential.php">Linha Essential</a></li>
                </ul>
            </div>

        </div>

        <hr class="footer-divider">

        <div class="footer-bottom">
            
            <div class="footer-payments">
                <h5>Formas de pagamento</h5>
                <div class="payment-badges" style="display: flex; gap: 10px; margin-top: 10px;">
                    <img src="assets/css/img/elo.png" alt="Elo" style="height: 30px;">
                    <img src="assets/css/img/visa.png" alt="Visa" style="height: 30px;">
                    <img src="assets/css/img/mastercard.png" alt="Mastercard" style="height: 30px;">
                    <img src="assets/css/img/Pix.png" alt="Pix" style="height: 30px;">                    
                </div>
            </div>

            <div class="footer-socials">
                <h5>Redes sociais</h5>
                <div class="social-icons">
                    <a href="https://www.instagram.com/dwd.street/?utm_source=ig_web_button_share_sheet" target="_blank">📸 Instagram</a>
                    <a href="#" target="_blank">🎬 TikTok</a>
                    <a href="#" target="_blank">🎥 YouTube</a>
                </div>
            </div>

        </div>

        <div class="footer-copyright">
            <p>&copy; 2026 DWD STREET. Todos os direitos reservados. Projeto Acadêmico SESI SENAI.</p>
        </div>
    </footer>
</body>
</html>