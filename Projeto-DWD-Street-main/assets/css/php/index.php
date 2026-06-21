<?php
// SIMULAÇÃO DE BANCO DE DADOS EM PHP
// No futuro, esses dados vão vir do seu banco MySQL automaticamente
$produtos = [
    [
        "nome" => "Camisa Block Core JEC",
        "preco" => "199,90",
        "imagem" => "assets/css/img/produto1.png",
        "badge" => "Novo"
    ],
    [
        "nome" => "Moletom DWD Street Black",
        "preco" => "249,90",
        "imagem" => "assets/css/img/produto2.png",
        "badge" => ""
    ],
    [
        "nome" => "Boné Snapback DWD",
        "preco" => "89,90",
        "imagem" => "assets/css/img/produto3.png",
        "badge" => ""
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWD Street | Oficial</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <div class="top-bar">ENTREGA RÁPIDA EM TODA JOINVILLE | 10% OFF NA PRIMEIRA COMPRA</div>

    <header class="navbar">
        <div class="logo">DWD<span>STREET</span></div>
        <nav class="main-nav">
            <ul class="nav-links">
                <li class="has-mega">
                    <a href="#">CATEGORIAS ▾</a>
                    <div class="mega-menu">
                        <div class="mega-col">
                            <h4>Acessórios</h4>
                            <ul>
                                <li><a href="#">Bolas</a></li>
                                <li><a href="#">Bonés e Gorros</a></li>
                                <li><a href="#">Mochilas</a></li>
                            </ul>
                        </div>
                        <div class="mega-col">
                            <h4>Feminino</h4>
                            <ul>
                                <li><a href="#">Camisas</a></li>
                                <li><a href="#">Plus Size</a></li>
                            </ul>
                        </div>
                        <div class="mega-col">
                            <h4>Masculino</h4>
                            <ul>
                                <li><a href="#">T-Shirts</a></li>
                                <li><a href="#">Agasalhos</a></li>
                                <li><a href="#">Calção</a></li>
                            </ul>
                        </div>
                        <div class="mega-col">
                            <h4>Outlet</h4>
                            <ul>
                                <li><a href="#">Ofertas</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li><a href="masculino.html">MASCULINO</a></li>
                <li><a href="feminino.html">FEMININO</a></li>
                <li><a href="infantil.html">INFANTIL</a></li>
                <li><a href="ofertas.html">OFERTAS</a></li>
            </ul>
        </nav>

        <div class="nav-icons">
            <a href="login.html" class="icon-btn">👤</a>
            <a href="carrinho.html" class="icon-btn">🛒 <span id="cart-count">0</span></a>
        </div>
    </header>

    <main>
        <section class="main-slider">
            <div class="slide active" style="background-image: url('assets/css/img/bannerdwd.png');">
                <div class="slide-overlay"></div>
                <div class="banner-content">
                    <p class="subtitle">Nova linha casual</p>
                    <h1>BLOCK <span>CORE</span></h1>
                    <a href="masculino.html" class="btn-banner">VER TODOS OS MODELOS</a>
                </div>
            </div>
            <div class="slide" style="background-image: url('assets/css/img/inverno.png');">
                <div class="slide-overlay"></div>
                <div class="banner-content">
                    <p class="subtitle">Coleção de Inverno</p>
                    <h1>MOLETONS <span>DWD</span></h1>
                    <a href="ofertas.html" class="btn-banner">APROVEITE 30% OFF</a>
                </div>
            </div>
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
            <?php 
            // O PHP VARRE O ARRAY DE PRODUTOS E GERA O HTML PARA CADA UM DELES SOZINHO!
            foreach($produtos as $produto): 
            ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['nome']; ?>">
                        <?php if(!empty($produto['badge'])): ?>
                            <span class="badge"><?php echo $produto['badge']; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3><?php echo $produto['nome']; ?></h3>
                        <p class="price">R$ <?php echo $produto['preco']; ?></p>
                        <button class="btn-add">ADICIONAR AO CARRINHO</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <button id="theme-toggle" class="theme-toggle">🌙</button>

    <script>
        // MODO ESCURO
        const themeToggleBtn = document.getElementById('theme-toggle');
        const body = document.body;

        if (themeToggleBtn) {
            if (localStorage.getItem('theme') === 'dark') {
                body.classList.add('dark-mode');
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

        // CARROSSEL
        const slides = document.querySelectorAll('.slide');
        let currentSlide = 0;
        if (slides.length > 0) {
            setInterval(() => {
                slides[currentSlide].classList.remove('active');
                currentSlide++;
                if (currentSlide >= slides.length) { currentSlide = 0; }
                slides[currentSlide].classList.add('active');
            }, 4000); 
        }
    </script>
</body>
</html>