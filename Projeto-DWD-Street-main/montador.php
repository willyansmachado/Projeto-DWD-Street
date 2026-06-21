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
    <title>Montador de Outfit | DWD Street</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    
    <style>
        .montador-section {
            padding: 60px 20px;
            max-width: 1300px;
            margin: 0 auto;
            text-align: center;
        }

        .montador-title {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: #111;
            text-transform: uppercase;
        }

        .montador-title span { color: #e31e24; }

        .montador-subtitle {
            margin-bottom: 40px;
            color: #666;
            font-weight: 500;
        }

        .builder-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            align-items: stretch;
        }

        /* COLUNA 1: SELETORES */
        .selectors-area {
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .item-slot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: 1px solid #eee;
        }

        .item-slot img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }

        .item-controls {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            padding: 0 10px;
        }

        .item-name {
            font-weight: 700;
            font-size: 0.85rem;
            margin-bottom: 5px;
            color: #333;
        }

        .item-price {
            color: #666;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .nav-btn {
            background: #eee;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-btn:hover {
            background: #e31e24;
            color: #fff;
        }

        /* COLUNA 2: MANEQUIM / MODELO */
        .model-display-area {
            flex: 1;
            min-width: 300px;
            background: #f8f9fa;
            border-radius: 12px;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.05);
            border: 2px dashed #ddd;
            min-height: 450px;
        }

        .model-layer {
            position: absolute;
            transition: opacity 0.3s ease, transform 0.3s ease;
            object-fit: contain;
        }

        /* Posições para simular um corpo (Ajuste o Top/Width conforme suas imagens reais) */
        #model-acessorio { top: 20px; width: 120px; z-index: 3; }
        #model-top { top: 120px; width: 220px; z-index: 2; }
        #model-bottom { top: 310px; width: 190px; z-index: 1; }

        .model-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #e31e24;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 900;
            z-index: 4;
            box-shadow: 0 4px 10px rgba(227,30,36,0.3);
        }

        /* COLUNA 3: RESUMO E CHECKOUT */
        .summary-area {
            flex: 1;
            min-width: 300px;
            background: #111;
            color: #fff;
            padding: 40px 30px;
            border-radius: 12px;
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .summary-area h3 {
            font-size: 1.5rem;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .summary-list {
            list-style: none;
            margin-bottom: 20px;
        }

        .summary-list li {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.9rem;
            color: #ccc;
        }

        .discount-row {
            background: rgba(227, 30, 36, 0.1);
            border: 1px dashed #e31e24;
            padding: 10px;
            border-radius: 6px;
            color: #e31e24 !important;
            font-weight: 700;
        }

        .price-box {
            text-align: right;
            margin-bottom: 30px;
        }

        .preco-antigo {
            font-size: 1rem;
            color: #888;
            margin-bottom: 5px;
            display: block;
        }

        .preco-novo {
            font-size: 2rem;
            font-weight: 900;
            color: #fff;
        }

        .preco-novo span { color: #e31e24; }

        .btn-buy-look {
            width: 100%;
            background: #e31e24;
            color: #fff;
            border: none;
            padding: 18px;
            font-size: 1rem;
            font-weight: 900;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
        }

        .btn-buy-look:hover {
            background: #c1181e;
            transform: translateY(-2px);
        }

        /* Dark Mode */
        body.dark-mode .montador-title { color: #fff; }
        body.dark-mode .item-slot { background: #222; border-color: #333; }
        body.dark-mode .item-name { color: #ddd; }
        body.dark-mode .nav-btn { background: #333; color: #fff; }
        body.dark-mode .nav-btn:hover { background: #e31e24; }
        body.dark-mode .model-display-area { background: #1a1a1a; border-color: #333; }
    </style>
</head>
<body>

    <div class="top-bar">ENTREGA RÁPIDA EM TODA JOINVILLE | 10% OFF NA PRIMEIRA COMPRA</div>
    <header class="navbar">
        <div class="logo">
            <a href="index.php" style="color: inherit; text-decoration: none;">DWD<span>STREET</span></a>
        </div>
        <nav class="main-nav">
            <ul class="nav-links">
                <li><a href="index.php">INÍCIO</a></li>
                <li><a href="masculino.php">MASCULINO</a></li>
                <li><a href="feminino.php">FEMININO</a></li>
                <li><a href="ofertas.php">OFERTAS</a></li>
                <li><a href="montador.php" style="color: #e31e24;">MONTADOR DE OUTFIT</a></li>
            </ul>
        </nav>
        <div class="header-actions">
            <div class="user-info">
                <span>Usuário Logado</span>
                <strong><?php echo $nomeUsuario; ?></strong>
            </div>
            <a href="carrinho.php" class="header-btn">🛒 Carrinho</a>
            <button id="theme-toggle" class="theme-btn">🌙</button>
        </div>
    </header>

    <main>
        <section class="montador-section">
            <h1 class="montador-title">MONTE SEU <span>OUTFIT</span></h1>
            <p class="montador-subtitle">Escolha as peças, veja como fica no corpo e ganhe 15% OFF no look completo!</p>

            <div class="builder-container">
                
                <!-- COLUNA 1: SELETORES -->
                <div class="selectors-area">
                    <!-- PEÇA DE CIMA -->
                    <div class="item-slot">
                        <button class="nav-btn" onclick="mudarItem('top', -1)">❮</button>
                        <div class="item-controls">
                            <img id="img-top" src="" alt="Peça de cima">
                            <div class="item-name" id="nome-top">Carregando...</div>
                            <div class="item-price" id="preco-top">R$ 0,00</div>
                        </div>
                        <button class="nav-btn" onclick="mudarItem('top', 1)">❯</button>
                    </div>

                    <!-- PEÇA DE BAIXO -->
                    <div class="item-slot">
                        <button class="nav-btn" onclick="mudarItem('bottom', -1)">❮</button>
                        <div class="item-controls">
                            <img id="img-bottom" src="" alt="Peça de baixo">
                            <div class="item-name" id="nome-bottom">Carregando...</div>
                            <div class="item-price" id="preco-bottom">R$ 0,00</div>
                        </div>
                        <button class="nav-btn" onclick="mudarItem('bottom', 1)">❯</button>
                    </div>

                    <!-- ACESSÓRIO -->
                    <div class="item-slot">
                        <button class="nav-btn" onclick="mudarItem('acessorio', -1)">❮</button>
                        <div class="item-controls">
                            <img id="img-acessorio" src="" alt="Acessório">
                            <div class="item-name" id="nome-acessorio">Carregando...</div>
                            <div class="item-price" id="preco-acessorio">R$ 0,00</div>
                        </div>
                        <button class="nav-btn" onclick="mudarItem('acessorio', 1)">❯</button>
                    </div>
                </div>

                <!-- COLUNA 2: MANEQUIM -->
                <div class="model-display-area">
                    <div class="model-badge">LOOK COMPLETO</div>
                    <!-- Imagens sobrepostas -->
                    <img id="model-acessorio" class="model-layer" src="" alt="Acessorio Modelo">
                    <img id="model-top" class="model-layer" src="" alt="Top Modelo">
                    <img id="model-bottom" class="model-layer" src="" alt="Bottom Modelo">
                </div>

                <!-- COLUNA 3: RESUMO E CHECKOUT -->
                <div class="summary-area">
                    <div>
                        <h3>Seu Look</h3>
                        <ul class="summary-list">
                            <li>
                                <span id="resumo-nome-top">-</span>
                                <span id="resumo-preco-top">R$ 0,00</span>
                            </li>
                            <li>
                                <span id="resumo-nome-bottom">-</span>
                                <span id="resumo-preco-bottom">R$ 0,00</span>
                            </li>
                            <li>
                                <span id="resumo-nome-acessorio">-</span>
                                <span id="resumo-preco-acessorio">R$ 0,00</span>
                            </li>
                            <li class="discount-row">
                                <span>Desconto Outfit (15%)</span>
                                <span id="resumo-desconto">- R$ 0,00</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <div class="price-box">
                            <del class="preco-antigo" id="preco-original">R$ 0,00</del>
                            <div class="preco-novo"><span>R$</span> <span id="preco-final">0,00</span></div>
                        </div>

                        <form action="adicionar_carrinho.php" method="POST" id="form-look">
                            <!-- Inputs que serão processados pelo carrinho -->
                            <input type="hidden" name="look_completo" value="sim">
                            <input type="hidden" name="desconto_aplicado" value="0.15">
                            
                            <input type="hidden" name="produto1_nome" id="input-nome-top" value="">
                            <input type="hidden" name="produto1_preco" id="input-preco-top" value="">
                            
                            <input type="hidden" name="produto2_nome" id="input-nome-bottom" value="">
                            <input type="hidden" name="produto2_preco" id="input-preco-bottom" value="">
                            
                            <input type="hidden" name="produto3_nome" id="input-nome-acessorio" value="">
                            <input type="hidden" name="produto3_preco" id="input-preco-acessorio" value="">

                            <button type="submit" class="btn-buy-look">🔥 COMPRAR LOOK COMPLETO</button>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <footer class="main-footer">
        <div class="footer-container">
            <div class="footer-col">
                <h4>Institucional</h4>
                <ul>
                    <li><a href="#">Sobre a DWD Street</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Ajuda</h4>
                <ul>
                    <li><a href="#">Rastreio</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-copyright" style="text-align: center; padding: 20px; color: #666;">
            <p>&copy; 2026 DWD STREET. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        // BANCO DE DADOS DAS PEÇAS
        // Para o manequim ficar perfeito, as imagens precisam ser PNGs com fundo transparente.
        const db = {
            top: [
                { nome: "Camisa Block Core JEC", preco: 199.90, img: "assets/css/img/produto1.png" },
                { nome: "Moletom DWD Black", preco: 249.90, img: "assets/css/img/produto2.png" },
                { nome: "T-Shirt Oversized", preco: 119.90, img: "https://via.placeholder.com/200x250/eee/333?text=Camiseta" }
            ],
            bottom: [
                { nome: "Calça Cargo Black", preco: 229.90, img: "https://via.placeholder.com/200x300/ddd/333?text=Calca+Cargo" },
                { nome: "Jorts Jeans Street", preco: 159.90, img: "https://via.placeholder.com/200x200/ddd/333?text=Jorts" },
                { nome: "Calça Moletom", preco: 189.90, img: "https://via.placeholder.com/200x300/ddd/333?text=Moletom" }
            ],
            acessorio: [
                { nome: "Boné Snapback DWD", preco: 89.90, img: "assets/css/img/produto3.png" },
                { nome: "Corrente Prata", preco: 149.90, img: "https://via.placeholder.com/100x100/ccc/333?text=Corrente" },
                { nome: "Touca DWD Inverno", preco: 69.90, img: "https://via.placeholder.com/100x100/ccc/333?text=Touca" }
            ]
        };

        let indices = { top: 0, bottom: 0, acessorio: 0 };

        const formatarMoeda = (valor) => valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

        function mudarItem(categoria, direcao) {
            let maxIndex = db[categoria].length - 1;
            indices[categoria] += direcao;
            
            if (indices[categoria] > maxIndex) indices[categoria] = 0;
            if (indices[categoria] < 0) indices[categoria] = maxIndex;

            atualizarTela();
        }

        function atualizarTela() {
            let totalOriginal = 0;

            ['top', 'bottom', 'acessorio'].forEach(cat => {
                let itemAtual = db[cat][indices[cat]];
                
                // Atualiza Miniaturas na esquerda
                document.getElementById(`img-${cat}`).src = itemAtual.img;
                document.getElementById(`nome-${cat}`).innerText = itemAtual.nome;
                document.getElementById(`preco-${cat}`).innerText = formatarMoeda(itemAtual.preco);

                // Atualiza Imagens do Manequim no centro
                document.getElementById(`model-${cat}`).src = itemAtual.img;

                // Atualiza Resumo e Inputs na direita
                document.getElementById(`resumo-nome-${cat}`).innerText = itemAtual.nome;
                document.getElementById(`resumo-preco-${cat}`).innerText = formatarMoeda(itemAtual.preco);
                document.getElementById(`input-nome-${cat}`).value = itemAtual.nome;
                document.getElementById(`input-preco-${cat}`).value = itemAtual.preco;

                totalOriginal += itemAtual.preco;
            });

            // Lógica do Desconto (15% OFF)
            let valorDesconto = totalOriginal * 0.15;
            let totalFinal = totalOriginal - valorDesconto;

            document.getElementById('resumo-desconto').innerText = `- ${formatarMoeda(valorDesconto)}`;
            document.getElementById('preco-original').innerHTML = `<del>${formatarMoeda(totalOriginal)}</del>`;
            
            // Ocultando o "R$" da span interna para não duplicar
            document.getElementById('preco-final').innerText = totalFinal.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        // Dark mode setup
        if (localStorage.getItem('theme') === 'dark') document.body.classList.add('dark-mode');
        const themeBtn = document.getElementById('theme-toggle');
        if (themeBtn) {
            themeBtn.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
                themeBtn.textContent = document.body.classList.contains('dark-mode') ? '☀️' : '🌙';
            });
        }

        // Executa a primeira atualização de tela
        atualizarTela();
    </script>
</body>
</html>