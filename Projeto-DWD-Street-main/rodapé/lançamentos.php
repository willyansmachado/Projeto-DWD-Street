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
    <title>DROP EXCLUSIVO | DWD Street</title>
    <!-- Linkando o CSS principal -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    
    <style>
        /* CSS ULTRA PREMIUM - EXCLUSIVO DO DROP */
        body {
            background-color: #0a0a0a !important;
            color: #ffffff !important;
        }

        /* Nav do Drop Minimalista */
        .drop-nav {
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #1a1a1a;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .drop-nav .logo-drop {
            font-size: 1.5rem;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .drop-nav .logo-drop span {
            color: #e31e24;
            text-shadow: 0 0 10px rgba(227, 30, 36, 0.3);
        }

        .btn-back-premium {
            color: #888;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: 1px solid #222;
            padding: 10px 20px;
            border-radius: 50px;
            background: #111;
        }

        .btn-back-premium:hover {
            color: #fff;
            border-color: #e31e24;
            box-shadow: 0 0 15px rgba(227, 30, 36, 0.4);
            transform: translateY(-2px);
        }

        /* Seção do Contador Regressivo (Urgência) */
        .countdown-container {
            background: linear-gradient(90deg, #e31e24, #991115);
            color: #fff;
            text-align: center;
            padding: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: 0 4px 20px rgba(227, 30, 36, 0.2);
        }

        #timer {
            font-weight: 900;
            background: rgba(0, 0, 0, 0.3);
            padding: 3px 8px;
            border-radius: 4px;
            margin-left: 5px;
        }

        /* Hero Banner Estilo Drop Gringo COM IMAGEM DE FUNDO */
        .drop-hero {
            padding: 140px 20px;
            text-align: center;
            position: relative;
            /* Fundo com a imagem do banner + película escura para destacar o texto */
            background-image: linear-gradient(rgba(10, 10, 10, 0.7), rgba(10, 10, 10, 0.95)), url('../assets/css/img/bannerlançamentos.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
            border-bottom: 1px solid #1a1a1a;
        }

        .drop-hero h1 {
            font-size: 4rem;
            font-weight: 900;
            letter-spacing: -1px;
            margin: 0;
            text-transform: uppercase;
            line-height: 1;
            position: relative;
            z-index: 2;
        }

        .drop-hero h1 .glow-text {
            color: transparent;
            -webkit-text-stroke: 1px #fff;
        }

        .drop-hero p {
            font-size: 0.85rem;
            color: #ffffff;
            margin-top: 15px;
            letter-spacing: 3px;
            text-transform: uppercase;
            position: relative;
            z-index: 2;
        }

        /* Grid de Produtos Avançado */
        .premium-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px 100px 20px;
        }

        .premium-card {
            background: #111;
            border: 1px solid #1a1a1a;
            border-radius: 0px; /* Estilo Streetwear reto quadrado */
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
        }

        .premium-card:hover {
            transform: translateY(-10px);
            border-color: #e31e24;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7);
        }

        .premium-img-wrapper {
            position: relative;
            overflow: hidden;
            background: #161616;
            aspect-ratio: 1 / 1;
        }

        .premium-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .premium-card:hover .premium-img-wrapper img {
            transform: scale(1.05);
        }

        /* Badges de Destaque */
        .premium-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #e31e24;
            color: #fff;
            padding: 6px 14px;
            font-size: 0.75rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 2;
        }

        .stock-badge {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            border: 1px solid #ffcc00;
            color: #ffcc00;
            padding: 4px 10px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            z-index: 2;
        }

        /* Detalhes do Produto */
        .premium-info {
            padding: 25px;
            text-align: left;
        }

        .premium-info h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0 0 10px 0;
            color: #fff;
            text-transform: uppercase;
        }

        .premium-info .price-tag {
            font-size: 1.5rem;
            font-weight: 900;
            color: #e31e24;
            margin-bottom: 20px;
        }

        /* Botão de Compra Brutalista */
        .btn-drop-buy {
            width: 100%;
            background: #ffffff;
            color: #000000;
            border: none;
            padding: 16px;
            font-weight: 900;
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .premium-card:hover .btn-drop-buy {
            background: #e31e24;
            color: #ffffff;
        }

        /* Redes Sociais Alinhadas */
        .btn-social {
            background: #111111;
            color: #aaaaaa;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border: 1px solid #222;
        }
        .btn-social:hover {
            background: #e31e24; color: #ffffff; border-color: #e31e24;
        }
        .insta-img { width: 18px; height: 18px; object-fit: contain; border-radius: 4px; }
    </style>
</head>
<body>

    <!-- Contador Regressivo Simulado (Urgência) -->
    <div class="countdown-container">
        🔥 DROP EXCLUSIVO: A PREFERÊNCIA É DE QUEM FECHAR O CARRINHO PRIMEIRO. EXPIRA EM: <span id="timer">00:14:52</span>
    </div>

    <!-- Navegação Superior Fina -->
    <header class="drop-nav">
        <div class="logo-drop">
            DWD<span>STREET</span> // LAUNCH
        </div>
        <a href="../index.php" class="btn-back-premium">
            ← Voltar ao Início
        </a>
    </header>

    <main>
        <!-- Hero Section com o Banner de Lançamentos -->
        <section class="drop-hero">
            <h1>DROP <span class="glow-text">01</span> / FECHADO</h1>
            <p>Peças limitadas. Sem reposição futura.</p>
        </section>

        <!-- Grade de Produtos Customizada -->
        <section class="premium-grid">
            
            <!-- Item 1 -->
            <div class="premium-card">
                <div class="premium-img-wrapper">
                    <span class="premium-badge">NEW DROP</span>
                    <span class="stock-badge">Apenas 4 restantes</span>
                    <img src="../assets/css/img/produto1.png" alt="Camisa Block Core">
                </div>
                <div class="premium-info">
                    <h3>Camisa Block Core JEC</h3>
                    <div class="price-tag">R$ 199,90</div>
                    <form action="../adicionar_carrinho.php" method="POST">
                        <input type="hidden" name="produto_nome" value="Camisa Block Core JEC">
                        <input type="hidden" name="preco" value="199.90">
                        <input type="hidden" name="imagem" value="assets/css/img/produto1.png">
                        <button type="submit" class="btn-drop-buy">Garantir Peça</button>
                    </form>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="premium-card">
                <div class="premium-img-wrapper">
                    <span class="premium-badge">LIMITED</span>
                    <span class="stock-badge">Últimas unidades</span>
                    <img src="../assets/css/img/produto2.png" alt="Moletom Street">
                </div>
                <div class="premium-info">
                    <h3>Moletom DWD Street Black</h3>
                    <div class="price-tag">R$ 249,90</div>
                    <form action="../adicionar_carrinho.php" method="POST">
                        <input type="hidden" name="produto_nome" value="Moletom DWD Street Black">
                        <input type="hidden" name="preco" value="249.90">
                        <input type="hidden" name="imagem" value="assets/css/img/produto2.png">
                        <button type="submit" class="btn-drop-buy">Garantir Peça</button>
                    </form>
                </div>
            </div>

        </section>
    </main>

    <!-- Rodapé Oficial Unificado -->
    <footer class="main-footer" style="background: #000; border-top: 1px solid #111;">
        <div class="footer-container">
            <div class="footer-col">
                <h4>Ajuda e Atendimento</h4>
                <ul>
                    <li><a href="rastreio.php">Acompanhe seu pedido</a></li>
                    <li><a href="faq.html">Dúvidas frequentes</a></li>
                    <li><a href="contato.html">Fale com a gente</a></li>
                    <li><a href="trocas.html">Troca e arrependimento</a></li>
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
                    <li><a href="institucional/lojas.php">Nossas Lojas</a></li>
                    <li><a href="institucional/trabalho.php">Trabalhe Conosco</a></li>
                    <li><a href="institucional/sustentabilidade.php">Sustentabilidade</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Nossos Produtos</h4>
                <ul>
                    <li><a href="lancamentos.php">Lançamentos</a></li>
                    <li><a href="../masculino.php">Coleção Masculina</a></li>
                    <li><a href="../infantil.php">Coleção Infantil</a></li>
                    <li><a href="#">Linha Essential</a></li>
                </ul>
            </div>
        </div>

        <hr class="footer-divider" style="border-color: #111;">

        <div class="footer-bottom">
            <div class="footer-payments">
                <h5>Formas de pagamento</h5>
                <div class="payment-badges" style="display: flex; gap: 10px; margin-top: 10px;">
                    <img src="../assets/css/img/elo.png" alt="Elo" style="height: 30px;">
                    <img src="../assets/css/img/visa.png" alt="Visa" style="height: 30px;">
                    <img src="../assets/css/img/mastercard.png" alt="Mastercard" style="height: 30px;">
                    <img src="../assets/css/img/Pix.png" alt="Pix" style="height: 30px;">                    
                </div>
            </div>

            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

            <div class="footer-socials">
                <h5>Redes sociais</h5>
                <div class="social-icons">
                    <a href="https://www.instagram.com/dwd.street/?utm_source=ig_web_button_share_sheet" target="_blank" class="btn-social">
                        <img src="../assets/css/img/insta.jpg" alt="Instagram" class="insta-img"> Instagram
                    </a>
                    <a href="#" target="_blank" class="btn-social">🎬 TikTok</a>
                    <a href="#" target="_blank" class="btn-social">🎥 YouTube</a>
                </div>
            </div>
        </div>

        <div class="footer-copyright">
            <p>&copy; 2026 DWD STREET. Todos os direitos reservados. Projeto Acadêmico SESI SENAI.</p>
        </div>
    </footer>

    <!-- Lógica JavaScript do Cronômetro -->
    <script>
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = "00:" + minutes + ":" + seconds;

                if (--timer < 0) {
                    timer = duration; // Reinicia se zerar
                }
            }, 1000);
        }

        window.onload = function () {
            var fifteenMinutes = 60 * 14 + 52,
                display = document.querySelector('#timer');
            startTimer(fifteenMinutes, display);
        };
    </script>
</body>
</html>