<?php
// BANCO DE DADOS SIMULADO EM PHP - CATEGORIA PLUS SIZE
$produtos = [
    [
        "id" => 1,
        "badge" => "Refletivo",
        "categoria" => "Corta-Vento",
        "titulo" => "Windbreaker Reflective DWD GG-G3 – Cinza/Preto",
        "preco_antigo" => "R$ 249,00",
        "preco_atual" => "R$ 186,00",
        "parcelas" => "4x de R$ 46,50",
        "imagem" => "https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=500"
    ],
    [
        "id" => 2,
        "badge" => "Mais Vendido",
        "categoria" => "T-Shirts",
        "titulo" => "Oversized T-Shirt Extra Premium – All Black G1-G4",
        "preco_antigo" => "R$ 169,00",
        "preco_atual" => "R$ 138,00",
        "parcelas" => "3x de R$ 46,00",
        "imagem" => "https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=500"
    ],
    [
        "id" => 3,
        "badge" => "Heavy Weight",
        "categoria" => "Moletom",
        "titulo" => "Urban Hoodie Grand-Size DWD – Preto Estonado",
        "preco_antigo" => null,
        "preco_atual" => "R$ 156,00",
        "parcelas" => "3x de R$ 52,00",
        "imagem" => "https://images.unsplash.com/photo-1556821840-3a63f95609a7?q=80&w=500"
    ],
    [
        "id" => 4,
        "badge" => "Novo Drop",
        "categoria" => "Calças",
        "titulo" => "Calça Jogger Street Confort Plus – Grafite Cargo",
        "preco_antigo" => "R$ 219,00",
        "preco_atual" => "R$ 179,00",
        "parcelas" => "4x de R$ 44,75",
        "imagem" => "https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=500"
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coleção Plus Size - DWD Street</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* CORES OFICIAIS DO SITE */
    :root {
        --brand-red: #e60000;
        --bg-main: #0a0a0a;
        --bg-sec: #111111;
        --bg-card: #161616;
        --text-light: #ffffff;
        --text-muted: #aaaaaa;
    }

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
    }

    /* BARRA DE AVISO NO TOPO */
    .top-bar {
        background: #111111;
        color: #ffffff;
        text-align: center;
        padding: 10px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* HEADER PADRÃO DWD BRANCO */
    header {
        background: #ffffff;
        padding: 20px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    }

    /* ==========================================================================
           LOGO ATUALIZADO (Estilo Inclinado / Itálico)
           ========================================================================== */
        .logo {
            font-weight: 900;
            font-size: 1.8rem; /* Aumentei levemente para dar mais destaque */
            text-decoration: none;
            color: var(--text-primary); /* Mantém branco no dark e preto no light */
            letter-spacing: -1.5px; /* Deixa as letras bem juntas como na imagem */
            font-style: italic; /* Deixa a fonte inclinada */
            text-transform: uppercase;
            display: inline-block;
            /* transform: skewX(-5deg); Caso queira ainda mais inclinado, descomente esta linha */
        }

        .logo span {
            color: var(--accent); /* O vermelho padrão da marca */
        }
    .logo-street { color: var(--brand-red); }

    .btn-inicio {
        color: #000000;
        text-decoration: none;
        font-weight: 800;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 2px solid #000000;
        padding: 10px 24px;
        transition: all 0.3s ease;
    }

    .btn-inicio:hover {
        background: var(--brand-red);
        color: #ffffff;
        border-color: var(--brand-red);
    }

    /* BANNER HERO PLUS SIZE */
    .category-hero {
        background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.7)), url('../assets/css/img/bannerplussize.png') no-repeat center center/cover;
        text-align: center;
        padding: 100px 20px;
        border-bottom: 2px solid var(--brand-red);
        background-color: #151515;
    }

    .category-hero h1 {
        font-size: 46px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 10px;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
    }

    .category-hero p {
        color: #ffffff;
        font-size: 16px;
        letter-spacing: 1px;
        font-weight: 600;
        text-shadow: 1px 1px 8px rgba(0, 0, 0, 0.8);
    }

    /* CONTAINER PRINCIPAL */
    .shop-container {
        max-width: 1200px;
        margin: auto;
        padding: 40px 20px;
    }

    /* BARRA DE FILTROS */
    .filter-bar {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }

    .filter-btn {
        background: var(--bg-sec);
        color: var(--text-light);
        border: 1px solid rgba(255,255,255,0.1);
        padding: 12px 30px;
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn.active, .filter-btn:hover {
        border-color: var(--brand-red);
        background: var(--brand-red);
        box-shadow: 0 0 15px rgba(230, 0, 0, 0.3);
    }

    /* GRID DE PRODUTOS */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 30px;
    }

    /* CARD DO PRODUTO */
    .product-card {
        background: var(--bg-card);
        border: 1px solid rgba(255,255,255,0.03);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        border-color: rgba(255,255,255,0.15);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
    }

    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--brand-red);
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        padding: 5px 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 5;
    }

    .product-img-holder {
        width: 100%;
        height: 300px;
        background: #1e1e1e;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-img-holder img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-img-holder img {
        transform: scale(1.06);
    }

    .product-info {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-category {
        font-size: 11px;
        text-transform: uppercase;
        color: var(--brand-red);
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .product-title {
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        line-height: 1.4;
        color: var(--text-light);
    }

    .product-price-box {
        margin-top: auto;
        margin-bottom: 20px;
    }

    .old-price {
        font-size: 13px;
        color: var(--text-muted);
        text-decoration: line-through;
        margin-bottom: 2px;
        display: block;
    }

    .current-price {
        font-size: 20px;
        font-weight: 800;
        color: #ffffff;
    }

    .price-parcelas {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 4px;
        display: block;
    }

    .btn-add-cart {
        background: transparent;
        color: var(--text-light);
        border: 2px solid var(--brand-red);
        padding: 12px;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        background: var(--brand-red);
        box-shadow: 0 0 15px rgba(230, 0, 0, 0.4);
    }

    /* FOOTER */
    footer {
        background: #000000;
        text-align: center;
        padding: 40px 20px;
        margin-top: 80px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        color: #555;
        border-top: 2px solid var(--brand-red);
    }

    /* RESPONSIVIDADE */
    @media (max-width: 768px) {
        header { flex-direction: column; gap: 20px; padding: 20px; }
        .category-hero h1 { font-size: 32px; }
        .products-grid { grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; }
    }
</style>
</head>
<body>

    <div class="top-bar">
        Entrega rápida em toda Joinville | 10% OFF na primeira compra
    </div>

    <header>
        <div class="logo">
            <span class="logo-dwd">DWD</span>
            <span class="logo-street">STREET</span>
        </div>
        <nav>
            <!-- VOLTANDO CERTINHO PARA O INDEX.PHP DA RAIZ -->
            <a href="../index.php" class="btn-inicio">⬅ Voltar ao Início</a>
        </nav>
    </header>

    <section class="category-hero">
        <h1>Coleção Plus Size</h1>
        <p>Estilo de rua sem limites — Caimento perfeito do G1 ao G4 com a pegada das ruas</p>
    </section>

    <main class="shop-container">

        <!-- FILTROS DA CATEGORIA -->
        <div class="filter-bar">
            <button class="filter-btn active">Todos</button>
            <button class="filter-btn">Camisetas G1-G4</button>
            <button class="filter-btn">Moletons / Casacos</button>
            <button class="filter-btn">Calças / Shorts</button>
        </div>

        <div class="products-grid">

            <!-- RENDERIZAÇÃO VIA LOOP PHP -->
            <?php foreach ($produtos as $item): ?>
            <div class="product-card">
                <?php if (!empty($item['badge'])): ?>
                    <div class="product-badge"><?= $item['badge'] ?></div>
                <?php endif; ?>
                
                <div class="product-img-holder">
                    <img src="<?= $item['imagem'] ?>" alt="<?= $item['titulo'] ?>">
                </div>
                
                <div class="product-info">
                    <span class="product-category"><?= $item['categoria'] ?></span>
                    <h2 class="product-title"><?= $item['titulo'] ?></h2>
                    
                    <div class="product-price-box">
                        <?php if (!empty($item['preco_antigo'])): ?>
                            <span class="old-price"><?= $item['preco_antigo'] ?></span>
                        <?php endif; ?>
                        
                        <span class="current-price"><?= $item['preco_atual'] ?></span>
                        <span class="price-parcelas">ou <?= $item['parcelas'] ?></span>
                    </div>
                    
                    <button class="btn-add-cart" onclick="alert('<?= $item['titulo'] ?> adicionado ao carrinho!')">Adicionar ao Carrinho</button>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </main>

    <footer>
        © 2026 DWD STREET - TODOS OS DIREITOS RESERVADOS
    </footer>

</body>
</html>