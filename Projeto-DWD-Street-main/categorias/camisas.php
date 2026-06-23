<?php
// BANCO DE DADOS SIMULADO EM PHP - CAMISAS FEMININAS
$produtos = [
    [
        "id" => 1,
        "badge" => "Drop Casual",
        "categoria" => "T-Shirts",
        "titulo" => "Camiseta Oversized Feminina DWD – Black Vintage",
        "preco_antigo" => "R$ 159,00",
        "preco_atual" => "R$ 129,00",
        "parcelas" => "3x de R$ 43,00",
        "imagem" => "https://images.unsplash.com/photo-1554568218-0f1715e72254?q=80&w=500"
    ],
    [
        "id" => 2,
        "badge" => "Mais Vendido",
        "categoria" => "Croppeds",
        "titulo" => "Cropped DWD Street Heavy Cotton – Off-White",
        "preco_antigo" => "R$ 119,00",
        "preco_atual" => "R$ 89,00",
        "parcelas" => "2x de R$ 44,50",
        "imagem" => "https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?q=80&w=500"
    ],
    [
        "id" => 3,
        "badge" => "Novo",
        "categoria" => "T-Shirts",
        "titulo" => "Camiseta Streetwear Feminina DWD Cyberpunk – Grafite",
        "preco_antigo" => null,
        "preco_atual" => "R$ 139,00",
        "parcelas" => "3x de R$ 46,33",
        "imagem" => "https://images.unsplash.com/photo-1509967419530-da38b4704bc6?q=80&w=500"
    ],
    [
        "id" => 4,
        "badge" => "Destaque",
        "categoria" => "Croppeds",
        "titulo" => "Top Cropped Gola Alta DWD – Vermelho Fire",
        "preco_antigo" => "R$ 109,00",
        "preco_atual" => "R$ 79,00",
        "parcelas" => "2x de R$ 39,50",
        "imagem" => "https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=500"
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camisas Femininas - DWD Street</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* ==========================================================================
       VARIÁVEIS DE DESIGN SÓLIDAS (PALETA HIGH-END)
       ========================================================================== */
    :root {
        --brand-red: #ff0000;
        --brand-red-hover: #cc0000;
        --bg-main: #000000;
        --bg-card: #0a0a0a;
        --border-color: #161616;
        --border-hover: #2a2a2a;
        --text-light: #ffffff;
        --text-muted: #7a7a7a;
    }

    /* Reset Avançado */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        background: var(--bg-main);
        color: var(--text-light);
        -webkit-font-smoothing: antialiased;
        border-top: 4px solid var(--brand-red); /* Linha do topo do seu print */
    }

    /* LINKS GLOBAIS */
    a {
        text-decoration: none;
        color: inherit;
    }

    /* BARRA DE AVISO NO TOPO */
    .top-bar {
        background: #000000;
        color: var(--text-light);
        text-align: center;
        padding: 12px 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        border-bottom: 1px solid var(--border-color);
    }

    /* HEADER FIXO MINIMALISTA */
    header {
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        padding: 24px 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
        border-bottom: 1px solid var(--border-color);
    }

    /* LOGO FIEL AO DESIGN DA IDENTIDADE */
    .logo {
        font-weight: 900;
        font-size: 1.6rem;
        letter-spacing: -1.5px;
        font-style: italic;
        text-transform: uppercase;
        cursor: pointer;
    }

    .logo-dwd {
        color: #ffffff;
    }

    .logo-street {
        color: var(--brand-red);
    }

    /* BOTÃO VOLTAR MINIMALISTA (Interação fina) */
    .btn-inicio {
        color: var(--text-light);
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 1px solid #222;
        padding: 10px 20px;
        border-radius: 2px;
        transition: all 0.2s ease-in-out;
    }

    .btn-inicio:hover {
        background: var(--text-light);
        color: #000000;
        border-color: var(--text-light);
    }

    /* HERO BANNER EDITORIAL */
    .category-hero {
        background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,1)), url('../assets/css/img/bannerfeminino.png') no-repeat center center/cover;
        text-align: center;
        padding: 100px 20px 80px;
        background-color: #050505;
        border-bottom: 1px solid var(--border-color);
    }

    .category-hero h1 {
        font-size: 3.5rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 12px;
        font-style: italic;
    }

    .category-hero p {
        color: var(--text-muted);
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.5px;
        max-width: 500px;
        margin: 0 auto;
    }

    /* SEÇÃO VITRINE */
    .shop-container {
        max-width: 1300px;
        margin: auto;
        padding: 40px 4%;
    }

    /* FILTROS CLEAN EM PÍLULA */
    .filter-bar {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-bottom: 60px;
        flex-wrap: wrap;
    }

    .filter-btn {
        background: transparent;
        color: var(--text-muted);
        border: 1px solid #1a1a1a;
        padding: 12px 24px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        border-radius: 50px;
        transition: all 0.2s ease;
    }

    .filter-btn.active, .filter-btn:hover {
        border-color: var(--text-light);
        color: #000000;
        background: var(--text-light);
    }

    /* GRID REORGANIZADO */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 40px 30px;
    }

    /* CARD DESIGN LUXO URBANO */
    .product-card {
        background: transparent;
        position: relative;
        display: flex;
        flex-direction: column;
    }

    /* Badge Flutuante sem Amadorismo */
    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--brand-red);
        color: #ffffff;
        font-size: 9px;
        font-weight: 800;
        padding: 4px 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 5;
        border-radius: 1px;
    }

    /* Moldura da Imagem com Overflow Oculto */
    .product-img-holder {
        width: 100%;
        height: 380px;
        background: #080808;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-color);
    }

    .product-img-holder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Transição em bezier premium para o efeito de zoom */
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* INTERAÇÃO DOS CARDS (O GRANDE DIFERENCIAL) */
    .product-card:hover .product-img-holder img {
        transform: scale(1.05); /* Zoom elegante sem estourar as bordas */
    }

    .product-card:hover .product-img-holder {
        border-color: var(--border-hover);
    }

    /* Detalhes do Produto */
    .product-info {
        padding: 20px 2px 0 2px; /* Encostado nas bordas verticais para estilo catálogo */
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-category {
        font-size: 10px;
        text-transform: uppercase;
        color: var(--text-muted);
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 6px;
    }

    .product-title {
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 12px;
        line-height: 1.4;
        color: var(--text-light);
        min-height: 40px; /* Alinha o grid perfeitamente */
    }

    .product-price-box {
        margin-top: auto;
        margin-bottom: 16px;
    }

    .old-price {
        font-size: 11px;
        color: var(--text-muted);
        text-decoration: line-through;
        margin-bottom: 2px;
        display: block;
    }

    .current-price {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-light);
    }

    .price-parcelas {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
        display: block;
    }

    /* BOTÃO ADICIONAR COM HOVER INVERTIDO IMPACTANTE */
    .btn-add-cart {
        background: transparent;
        color: var(--text-light);
        border: 1px solid var(--text-light);
        padding: 14px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        width: 100%;
        transition: all 0.2s ease-in-out;
    }

    .btn-add-cart:hover {
        background: var(--brand-red);
        color: #ffffff;
        border-color: var(--brand-red);
    }

    /* ==========================================================================
       RODAPÉ FIEL AO SEU TEMPLATE E ÁRVORE DE PASTAS (CORRIGIDO)
       ========================================================================== */
    footer {
        background: #000000;
        border-top: 4px solid var(--brand-red); /* Faixa vermelha fiel à Imagem 2 */
        padding: 70px 5% 40px;
        margin-top: 100px;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 45px;
    }

    .footer-col h4 {
        color: var(--brand-red); /* Títulos em vermelho igual ao seu print */
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 25px;
    }

    .footer-col ul {
        list-style: none;
    }

    .footer-col ul li {
        margin-bottom: 14px;
    }

    .footer-col ul li a {
        color: #aaaaaa; /* Cinza suave profissional */
        font-size: 13px;
        font-weight: 500;
        display: inline-block;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    /* Efeito de micro-deslocamento nos links do rodapé */
    .footer-col ul li a:hover {
        color: #ffffff;
        transform: translateX(3px);
    }

    .footer-bottom {
        text-align: center;
        margin-top: 60px;
        padding-top: 30px;
        border-top: 1px solid #111;
        font-size: 11px;
        color: #444;
        letter-spacing: 1px;
        font-weight: 600;
    }

    /* COMPATIBILIDADE MÓVEL IMPECÁVEL */
    @media (max-width: 768px) {
        header { padding: 20px 4%; }
        .category-hero h1 { font-size: 2.5rem; }
        .products-grid { grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 25px; }
        .product-img-holder { height: 320px; }
        .footer-container { grid-template-columns: 1fr; gap: 35px; }
    }
</style>
</head>
<body>

    <div class="top-bar">
        Entrega rápida em toda Joinville | 10% OFF na primeira compra
    </div>

    <header>
        <div class="logo">
            <span class="logo-dwd">DWD</span><span class="logo-street">STREET</span>
        </div>
        <nav>
            <a href="../index.php" class="btn-inicio">⬅ Voltar ao Início</a>
        </nav>
    </header>

    <section class="category-hero">
        <h1>Camisas Femininas</h1>
        <p>Corte oversized premium, croppeds pesados e caimento streetwear autêntico</p>
    </section>

    <main class="shop-container">

        <div class="filter-bar">
            <button class="filter-btn active">Todos</button>
            <button class="filter-btn">Oversized T-Shirts</button>
            <button class="filter-btn">Croppeds / Tops</button>
            <button class="filter-btn">Camisas Street</button>
        </div>

        <div class="products-grid">

            <?php foreach ($produtos as $item): ?>
            <div class="product-card">
                <?php if (!empty($item['badge'])): ?>
                    <div class="product-badge"><?= htmlspecialchars($item['badge']) ?></div>
                <?php endif; ?>
                
                <div class="product-img-holder">
                    <img src="<?= htmlspecialchars($item['imagem']) ?>" alt="<?= htmlspecialchars($item['titulo']) ?>">
                </div>
                
                <div class="product-info">
                    <span class="product-category"><?= htmlspecialchars($item['categoria']) ?></span>
                    <h2 class="product-title"><?= htmlspecialchars($item['titulo']) ?></h2>
                    
                    <div class="product-price-box">
                        <?php if (!empty($item['preco_antigo'])): ?>
                            <span class="old-price"><?= htmlspecialchars($item['preco_antigo']) ?></span>
                        <?php endif; ?>
                        
                        <span class="current-price"><?= htmlspecialchars($item['preco_atual']) ?></span>
                        <span class="price-parcelas">ou <?= htmlspecialchars($item['parcelas']) ?></span>
                    </div>
                    
                    <button class="btn-add-cart" onclick="alert('<?= addslashes($item['titulo']) ?> adicionado ao carrinho!')">Adicionar ao Carrinho</button>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </main>

    <footer>
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
                    <li><a href="institucional/sobre.html">Sobre a DWD Street</a></li>
                    <li><a href="institucional/lojas.php">Nossas Lojas</a></li>
                    <li><a href="institucional/trabalho.php">Trabalhe Conosco</a></li>
                    <li><a href="institucional/sustentabilidade.php">Sustentabilidade</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Nossos Produtos</h4>
                <ul>
                    <li><a href="lançamentos.php">Lançamentos</a></li>
                    <li><a href="masculino.php">Coleção Masculina</a></li>
                    <li><a href="infantil.php">Coleção Infantil</a></li>
                    <li><a href="essential.php">Linha Essencial</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            © 2026 DWD STREET - TODOS OS DIREITOS RESERVADOS. PROJETO ACADÊMICO SESI SENAI.
        </div>
    </footer>

</body>
</html>