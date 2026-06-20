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
    <title>Linha Essential | DWD Street</title>
    <!-- Linkando o CSS principal voltando uma pasta -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700;900&display=swap" rel="stylesheet">
    
    <style>
        /* CSS PREMIUM - COLECÃO ESSENTIAL */
        body {
            background-color: #0f0f10 !important;
            color: #f5f5f7 !important;
            font-family: 'Montserrat', sans-serif;
        }

        /* Nav Minimalista e Elegante */
        .essential-nav {
            background: rgba(15, 15, 16, 0.95);
            backdrop-filter: blur(12px);
            padding: 25px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #1c1c1e;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .essential-nav .logo-essential {
            font-size: 1.3rem;
            font-weight: 900;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #ffffff;
        }

        .essential-nav .logo-essential span {
            font-weight: 300;
            color: #8e8e93;
        }

        .btn-back-essential {
            color: #f5f5f7;
            text-decoration: none;
            font-weight: 400;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
            border: 1px solid #2c2c2e;
            padding: 12px 24px;
            background: transparent;
        }

        .btn-back-essential:hover {
            background: #ffffff;
            color: #000000;
            border-color: #ffffff;
        }

        /* Hero Banner Clean */
        .essential-hero {
            padding: 120px 20px;
            text-align: center;
            background: linear-gradient(180deg, #121214 0%, #0f0f10 100%);
            border-bottom: 1px solid #1c1c1e;
        }

        .essential-hero h1 {
            font-size: 3.5rem;
            font-weight: 300;
            letter-spacing: 8px;
            margin: 0;
            text-transform: uppercase;
            color: #ffffff;
        }

        .essential-hero h1 strong {
            font-weight: 900;
            color: #ffffff;
        }

        .essential-hero p {
            font-size: 0.95rem;
            color: #8e8e93;
            margin-top: 20px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            font-weight: 400;
            letter-spacing: 1px;
            line-height: 1.6;
        }

        /* Grid de Produtos de Luxo */
        .essential-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px;
        }

        .essential-card {
            background: #121214;
            border: 1px solid #1c1c1e;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .essential-card:hover {
            border-color: #ffffff;
            transform: translateY(-5px);
        }

        .essential-img-wrapper {
            position: relative;
            overflow: hidden;
            background: #1a1a1c;
            aspect-ratio: 1 / 1;
        }

        .essential-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }

        .essential-card:hover .essential-img-wrapper img {
            transform: scale(1.03);
        }

        /* Tags Minimalistas */
        .essential-tag {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #ffffff;
            color: #000000;
            padding: 5px 12px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Detalhes do Card */
        .essential-info {
            padding: 30px;
        }

        .essential-info h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 8px 0;
            color: #ffffff;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .essential-info .material-desc {
            font-size: 0.8rem;
            color: #8e8e93;
            margin-bottom: 15px;
        }

        .essential-info .price-tag {
            font-size: 1.3rem;
            font-weight: 300;
            color: #ffffff;
            margin-bottom: 25px;
        }

        /* Botão de Compra Minimalista */
        .btn-essential-buy {
            width: 100%;
            background: transparent;
            color: #ffffff;
            border: 1px solid #2c2c2e;
            padding: 16px;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .essential-card:hover .btn-essential-buy {
            background: #ffffff;
            color: #000000;
            border-color: #ffffff;
        }

        /* Ajuste do botão de rede social para o tema */
        .btn-social {
            background: #121214;
            color: #aaaaaa;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border: 1px solid #1c1c1e;
        }
        .btn-social:hover {
            background: #ffffff; color: #000000; border-color: #ffffff;
        }
        .insta-img { width: 18px; height: 18px; object-fit: contain; border-radius: 4px; }
    </style>
</head>
<body>

    <!-- Header Elegante -->
    <header class="essential-nav">
        <div class="logo-essential">
            DWD <span>ESSENTIALS</span>
        </div>
        <a href="../index.php" class="btn-back-essential">
            Acessar Início
        </a>
    </header>

    <main>
        <!-- Banner Principal Clean -->
        <section class="essential-hero">
            <h1>ESSENTIAL <strong>LINE</strong></h1>
            <p>O básico elevado ao topo. Peças atemporais desenvolvidas com algodão de alta gramatura, caimento relaxed e paleta de cores sóbrias para o dia a dia urbano.</p>
        </section>

        <!-- Grade de Produtos Minimalista -->
        <section class="essential-grid">
            
            <!-- Produto 1: Exemplo de Camiseta Essential -->
            <div class="essential-card">
                <div class="essential-img-wrapper">
                    <span class="essential-tag">Heavyweight</span>
                    <img src="../assets/css/img/produto1.png" alt="Camiseta Heavyweight Off-White">
                </div>
                <div class="essential-info">
                    <h3>Camiseta Essential Off-White</h3>
                    <p class="material-desc">100% Algodão Premium • 260 GSM</p>
                    <div class="price-tag">R$ 149,90</div>
                    <form action="../adicionar_carrinho.php" method="POST">
                        <input type="hidden" name="produto_nome" value="Camiseta Essential Off-White">
                        <input type="hidden" name="preco" value="149.90">
                        <input type="hidden" name="imagem" value="assets/css/img/produto1.png">
                        <button type="submit" class="btn-essential-buy">Adicionar ao Carrinho</button>
                    </form>
                </div>
            </div>

            <!-- Produto 2: Exemplo de Moletom Essential -->
            <div class="essential-card">
                <div class="essential-img-wrapper">
                    <span class="essential-tag">Oversized</span>
                    <img src="../assets/css/img/produto2.png" alt="Moletom Essential Boxy">
                </div>
                <div class="essential-info">
                    <h3>Moletom Essential Boxy Black</h3>
                    <p class="material-desc">Algodão e Poliéster • Interior Peluciado</p>
                    <div class="price-tag">R$ 279,90</div>
                    <form action="../adicionar_carrinho.php" method="POST">
                        <input type="hidden" name="produto_nome" value="Moletom Essential Boxy Black">
                        <input type="hidden" name="preco" value="279.90">
                        <input type="hidden" name="imagem" value="assets/css/img/produto2.png">
                        <button type="submit" class="btn-essential-buy">Adicionar ao Carrinho</button>
                    </form>
                </div>
            </div>

        </section>
    </main>

    <!-- Rodapé Oficial Adaptado -->
    <footer class="main-footer" style="background: #0a0a0b; border-top: 1px solid #1c1c1e;">
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

        <hr class="footer-divider" style="border-color: #1c1c1e;">

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
</body>
</html>