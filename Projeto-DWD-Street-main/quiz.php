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
    <title>DWD Street | Quiz de Estilo</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        .quiz-container {
            max-width: 650px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            font-family: 'Montserrat', sans-serif;
        }

        body.dark-mode .quiz-container {
            background-color: #1a1a1a;
            border: 1px solid #333;
        }

        .quiz-title {
            font-weight: 900;
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 25px;
            font-size: 1.8rem;
            color: #111;
        }
        
        body.dark-mode .quiz-title {
            color: #fff;
        }

        .quiz-title span {
            color: #e31e24;
        }

        .quiz-step {
            display: none;
        }

        .quiz-step.active {
            display: block;
        }

        .question-text {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #333;
        }

        body.dark-mode .question-text {
            color: #ddd;
        }

        .options-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 25px;
        }

        .option-btn {
            background-color: #f4f4f4;
            border: 2px solid #ddd;
            padding: 15px 20px;
            border-radius: 6px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s ease;
            color: #333;
        }

        body.dark-mode .option-btn {
            background-color: #2b2b2b;
            border-color: #444;
            color: #eee;
        }

        .option-btn:hover {
            border-color: #e31e24;
            background-color: #fff1f1;
        }

        body.dark-mode .option-btn:hover {
            background-color: #3d1a1b;
        }

        .quiz-result {
            display: none;
            text-align: center;
        }

        .quiz-result h3 {
            font-weight: 900;
            font-size: 1.6rem;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .quiz-result p {
            font-size: 1.1rem;
            margin-bottom: 25px;
            color: #666;
        }

        body.dark-mode .quiz-result p {
            color: #aaa;
        }

        /* Container flexível para alinhar os botões no resultado */
        .actions-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .btn-action {
            background-color: #e31e24;
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-weight: 700;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }

        .btn-action:hover {
            background-color: #c1181e;
        }

        .btn-back-home {
            background-color: #111;
            margin-left: 15px;
        }

        body.dark-mode .btn-back-home {
            background-color: #444;
        }

        .btn-back-home:hover {
            background-color: #333;
        }

        /* Layout da Vitrine de IA */
        .ia-outfit-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .ia-product-card {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            width: 170px;
            text-align: center;
            border: 1px solid #eee;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }

        .ia-product-card:hover {
            transform: translateY(-5px);
        }

        body.dark-mode .ia-product-card {
            background: #222;
            border-color: #333;
        }

        .ia-product-tag {
            font-size: 0.75rem;
            background: #e31e24;
            color: #fff;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 8px;
        }

        .ia-product-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .ia-product-card h4 {
            font-size: 0.85rem;
            margin: 5px 0 12px 0;
            min-height: 34px;
            line-height: 1.3;
            color: #111;
        }

        body.dark-mode .ia-product-card h4 {
            color: #eee;
        }

        .ia-product-card .btn-action {
            padding: 8px 12px;
            font-size: 0.75rem;
            width: 100%;
            box-sizing: border-box;
        }
        
        /* Ajuste simples para o navbar limpo do quiz */
        .navbar-quiz {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 5%;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        body.dark-mode .navbar-quiz {
            background-color: #1a1a1a;
            border-bottom: 1px solid #333;
        }
    </style>
</head>
<body>

    <!-- Cabeçalho simplificado apenas com Logo e Botão de Voltar -->
    <header class="navbar-quiz">
        <div class="logo" style="font-family: 'Montserrat', sans-serif; font-weight: 900; font-size: 1.5rem; color: #111;">
            DWD<span style="color: #e31e24;">STREET</span>
        </div>

        <div class="header-actions" style="display: flex; align-items: center;">
            <button id="theme-toggle" class="theme-btn" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">🌙</button>
            <a href="index.php" class="btn-action btn-back-home">🏠 Voltar ao Início</a>
        </div>
    </header>

    <main>
        <div class="quiz-container">
            <h2 class="quiz-title">Quiz de <span>Estilo</span></h2>

            <div class="quiz-step active" id="step-1">
                <p class="question-text">1. Qual tipo de corte ou modelagem de roupa você prefere?</p>
                <div class="options-list">
                    <button class="option-btn" onclick="nextStep(2, 'street')">Larga / Oversized (Estilo Skate/Rua)</button>
                    <button class="option-btn" onclick="nextStep(2, 'casual')">Tradicional / Casual (Mais alinhada ao corpo)</button>
                    <button class="option-btn" onclick="nextStep(2, 'esportivo')">Esportiva (Estilo Bloke Core / Times)</button>
                </div>
            </div>

            <div class="quiz-step" id="step-2">
                <p class="question-text">2. Qual acessório não pode faltar no seu outfit diário?</p>
                <div class="options-list">
                    <button class="option-btn" onclick="nextStep(3, 'street')">Um bom Boné ou Touca</button>
                    <button class="option-btn" onclick="nextStep(3, 'casual')">Relógio discreto ou Correntes</button>
                    <button class="option-btn" onclick="nextStep(3, 'esportivo')">Óculos de sol ou Correntes pesadas</button>
                </div>
            </div>

            <div class="quiz-step" id="step-3">
                <p class="question-text">3. Quando o clima esfria, qual a sua escolha favorita?</p>
                <div class="options-list">
                    <button class="option-btn" onclick="finishQuiz('street')">Moletom Canguru pesado</button>
                    <button class="option-btn" onclick="finishQuiz('casual')">Corta-vento discreto ou Jaqueta</button>
                    <button class="option-btn" onclick="finishQuiz('esportivo')">Jaqueta de time de futebol / Agasalho</button>
                </div>
            </div>

            <div class="quiz-result" id="quiz-result-box">
                <h3 id="result-title">Seu Estilo é...</h3>
                <p id="result-text">Carregando perfil...</p>
                
                <!-- Onde a inteligência artificial vai injetar o Outfit Completo -->
                <div class="ia-outfit-container" id="ia-vitrine"></div>
                
                <div class="actions-container">
                    <a href="quiz.php" class="btn-action" style="background-color: #555;">Refazer Análise</a>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Banco de Dados Inteligente de Peças (Matriz de Associação da IA)
        const catalogoIA = {
            superiores: {
                street: { nome: "T-Shirt Oversized Premium DWD", link: "categorias/t-shirts.php", img: "https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=400" },
                casual: { nome: "Camisa Minimalist Algodão", link: "categorias/camisas.php", img: "https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400" },
                esportivo: { nome: "Corta-Vento Hype Windbreaker", link: "categorias/agasalhos.php", img: "https://images.unsplash.com/photo-1548883354-7622d03aca27?w=400" }
            },
            inferiores: {
                street: { nome: "Bermuda Jorts Jeans Wide", link: "categorias/jorts.php", img: "https://images.unsplash.com/photo-1542272604-787c3835535d?w=400" },
                casual: { nome: "Calça Sarja Slim Cargo", link: "categorias/calcasf.php", img: "https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=400" },
                esportivo: { nome: "Calça Tracksuit Jogger Athletic", link: "categorias/agasalhos.php", img: "https://images.unsplash.com/photo-1515434126000-961d90ff09db?w=400" }
            },
            acessorios: {
                street: { nome: "Boné Snapback Original DWD", link: "categorias/bones.php", img: "https://images.unsplash.com/photo-1588850561407-ed78c282e89b?w=400" },
                casual: { nome: "Relógio Digital Steel Black", link: "categorias/relogios.php", img: "https://images.unsplash.com/photo-1522312346375-d1a52e2b99b3?w=400" },
                esportivo: { nome: "Corrente Ice Cuban Prata 925", link: "categorias/joias.php", img: "https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=400" }
            }
        };

        // Estado das decisões para mapeamento cognitivo
        let historicoPassos = [];
        let escolhas = { street: 0, casual: 0, esportivo: 0 };

        function nextStep(current, tipo) {
            escolhas[tipo]++;
            historicoPassos.push(tipo); 
            document.querySelector('.quiz-step.active').classList.remove('active');
            document.getElementById('step-' + current).classList.add('active');
        }

        function finishQuiz(tipo) {
            escolhas[tipo]++;
            historicoPassos.push(tipo);
            document.querySelector('.quiz-step.active').classList.remove('active');
            
            const resultadoBox = document.getElementById('quiz-result-box');
            const titulo = document.getElementById('result-title');
            const texto = document.getElementById('result-text');
            const vitrine = document.getElementById('ia-vitrine');

            let estiloFinal = Object.keys(escolhas).reduce((a, b) => escolhas[a] > escolhas[b] ? a : b);

            let pecaSuperior = catalogoIA.superiores[historicoPassos[0]]; 
            let pecaAcessorio = catalogoIA.acessorios[historicoPassos[1]]; 
            let pecaInferior = catalogoIA.inferiores[historicoPassos[2]];  

            if (estiloFinal === 'street') {
                titulo.innerHTML = 'Motor IA: Perfil <span>Street Wear</span>';
                texto.textContent = 'A inteligência artificial analisou suas respostas! Identificamos forte conexão com o movimento de rua e a cultura urbana. Abaixo está a combinação ideal gerada para o seu perfil:';
            } else if (estiloFinal === 'esportivo') {
                titulo.innerHTML = 'Motor IA: Perfil <span>Esportivo / Bloke Core</span>';
                texto.textContent = 'Análise do algoritmo concluída! Você possui uma identidade voltada à cultura esportiva urbana e estética dos estádios. Veja seu outfit sob medida:';
            } else {
                titulo.innerHTML = 'Motor IA: Perfil <span>Casual Moderno</span>';
                texto.textContent = 'Mapeamento de estilo finalizado! Suas preferências apontam para um perfil elegante, limpo e super adaptável ao cotidiano. Confira as peças selecionadas:';
            }

            vitrine.innerHTML = `
                <!-- PEÇA SUPERIOR -->
                <div class="ia-product-card">
                    <span class="ia-product-tag">Parte Superior</span>
                    <img src="${pecaSuperior.img}" alt="${pecaSuperior.nome}">
                    <h4>${pecaSuperior.nome}</h4>
                    <a href="${pecaSuperior.link}" class="btn-action">Ver Produto</a>
                </div>

                <!-- PEÇA INFERIOR -->
                <div class="ia-product-card">
                    <span class="ia-product-tag">Parte Inferior</span>
                    <img src="${pecaInferior.img}" alt="${pecaInferior.nome}">
                    <h4>${pecaInferior.nome}</h4>
                    <a href="${pecaInferior.link}" class="btn-action">Ver Produto</a>
                </div>

                <!-- ACESSÓRIO -->
                <div class="ia-product-card">
                    <span class="ia-product-tag">Acessório</span>
                    <img src="${pecaAcessorio.img}" alt="${pecaAcessorio.nome}">
                    <h4>${pecaAcessorio.nome}</h4>
                    <a href="${pecaAcessorio.link}" class="btn-action">Ver Produto</a>
                </div>
            `;

            resultadoBox.style.display = 'block';
        }

        // Script do Modo Escuro (Sincronizado)
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
            document.querySelector('.logo').style.color = '#fff';
        }

        const themeToggleBtn = document.getElementById('theme-toggle');
        const body = document.body;

        if (themeToggleBtn) {
            if (body.classList.contains('dark-mode')) {
                themeToggleBtn.textContent = '☀️'; 
            }
            themeToggleBtn.addEventListener('click', () => {
                body.classList.toggle('dark-mode');
                const logo = document.querySelector('.logo');
                
                if (body.classList.contains('dark-mode')) {
                    localStorage.setItem('theme', 'dark');
                    themeToggleBtn.textContent = '☀️';
                    if(logo) logo.style.color = '#fff';
                } else {
                    localStorage.setItem('theme', 'light');
                    themeToggleBtn.textContent = '🌙';
                    if(logo) logo.style.color = '#111';
                }
            });
        }
    </script>

    <footer class="main-footer" style="text-align: center; padding: 20px; margin-top: 40px;">
        <div class="footer-copyright">
            <p style="color: #666; font-size: 0.9rem;">&copy; 2026 DWD STREET. Todos os direitos reservados. Projeto Acadêmico SESI SENAI.</p>
        </div>
    </footer>
</body>
</html>