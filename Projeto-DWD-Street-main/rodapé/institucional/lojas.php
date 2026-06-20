<?php
// lojas.php

// 1. Definição das variáveis de conteúdo da página
$titulo = 'Nossa <span>Loja</span>';
$subtitulo = 'Vivencie a cultura streetwear de perto. Venha conhecer nosso espaço e trocar uma ideia!';
$data_atualizacao = '17/06/2026';

// Todo o HTML complexo estruturado em variáveis do PHP
$conteudo_html = '
<p style="text-align: center; font-size: 1.1rem; line-height: 1.6; color: var(--texto-corpo); margin-bottom: 30px;">
    Além da nossa plataforma online que entrega para todo o Brasil, a DWD Street conta com um espaço físico em Joinville pensado para quem respira o estilo de rua. Nosso ambiente une coleções exclusivas, arte urbana e música.
</p>

<!-- CONTEÚDO DA LOJA EM JOINVILLE -->
<div class="loja-content active">
    <div class="loja-grid">
        <div class="politica-bloco no-margin">        
            <h2>DWD Street HQ — Joinville</h2>
            <p>Nossa loja oficial e centro de distribuição. Chegue mais para conferir os lançamentos mais disputados (Drops) em primeira mão:</p>
            <ul class="info-loja-lista">
                <li><strong>Endereço:</strong> Rua Osni Borges, 86 - Joinville - SC</li>
                <li><strong>Horário:</strong> Segunda a Sexta: 09h às 19h | Sábados: 09h às 16h</li>
                <li><strong>WhatsApp Comercial:</strong> (47) 99123-4567</li>
                <li><strong>Ambiente:</strong> Mostruário completo de streetwear, espaço para café e retirada rápida de pedidos feitos online.</li>
            </ul>
            <a href="https://maps.google.com/?q=Rua+Osni+Borges,+86+-+Joinville+-+SC" target="_blank" class="btn-rota">Abrir no GPS 🚀</a>
        </div>
        <div class="mapa-container">
            <!-- Iframe do Google Maps configurado exatamente para a Rua Osni Borges, 86 - Joinville -->
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3579.5471676344585!2d-48.8523179!3d-26.2113338!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94de8f7004d271fb%3A0x6b189ff7033ea64d!2sR.%20Osni%20Borges%2C%2086%20-%20Joinville%20-%20SC!5e0!3m2!1spt-BR!2sbr!4v1710000000000!5m2!1spt-BR!2sbr" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>

<!-- CARD INFORMATIVO INFERIOR -->
<div class="politica-bloco" style="margin-top: 30px;">
    <h2>🛍️ Compre no Site e Retire na Loja (Joinville)</h2>
    <p>
        Mora na região ou quer economizar no frete? Em nosso site, você pode selecionar a opção <strong>"Retirar na Loja"</strong> na tela de checkout. Assim que o pagamento for aprovado, seu pedido estará separado e pronto para retirada no nosso balcão em até 2 horas!
    </p>
</div>';

// 2. Renderização completa do HTML via PHP
echo '<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . strip_tags($titulo) . ' | DWD Street</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-principal: #f9f9f9;
            --bg-card: #ffffff;
            --texto-titulo: #111111;
            --texto-corpo: #555555;
            --sombra: rgba(0, 0, 0, 0.05);
            --cor-destaque: #e31e24;
            --borda-input: #ddd;
        }
        [data-theme="dark"] {
            --bg-principal: #121212;
            --bg-card: #1e1e1e;
            --texto-titulo: #ffffff;
            --texto-corpo: #b3b3b3;
            --sombra: rgba(0, 0, 0, 0.3);
            --borda-input: #444;
        }
        body {
            font-family: "Montserrat", sans-serif;
            background-color: var(--bg-principal);
            color: var(--texto-titulo);
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .banner-actions {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            display: flex;
            justify-content: space-between;
            z-index: 10;
        }
        .btn-banner-action {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid var(--cor-destaque);
            color: #fff;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-family: "Montserrat", sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .btn-banner-action:hover {
            background: var(--cor-destaque);
            transform: scale(1.05);
            color: #fff;
        }
        [data-theme="dark"] .btn-banner-action {
            background: var(--bg-card);
            color: var(--texto-titulo);
        }
        .pagina-banner {
            position: relative;
            background: linear-gradient(135deg, #111 0%, #222 100%);
            color: #fff;
            text-align: center;
            padding: 70px 20px;
            border-bottom: 4px solid var(--cor-destaque);
        }
        .pagina-banner h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .pagina-banner h1 span {
            color: var(--cor-destaque);
        }
        .pagina-banner p {
            margin: 10px 0 0 0;
            font-size: 1rem;
            color: #ccc;
        }
        .pagina-interna {
            max-width: 950px;
            margin: 50px auto;
            padding: 0 20px;
        }
        .pagina-interna > h1 {
            text-align: center;
            font-weight: 900;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .pagina-interna > h1 span {
            color: var(--cor-destaque);
        }
        .data-atualizacao {
            text-align: center;
            color: var(--texto-corpo);
            font-size: 0.9rem;
            margin-bottom: 40px;
            font-style: italic;
        }
        
        /* GRID DE DESIGN COMPLEXO DO MAPA */
        .loja-content {
            animation: fadeIn 0.5s ease;
        }
        .loja-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }
        @media (max-width: 768px) {
            .loja-grid {
                grid-template-columns: 1fr;
            }
        }
        .politica-bloco {
            background: var(--bg-card);
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0 4px 12px var(--sombra);
            border-left: 5px solid var(--cor-destaque);
            margin-bottom: 25px;
        }
        .politica-bloco.no-margin {
            margin-bottom: 0;
        }
        .politica-bloco h2 {
            margin-top: 0;
            font-weight: 900;
            font-size: 1.3rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .politica-bloco p {
            color: var(--texto-corpo);
            line-height: 1.7;
            font-size: 1rem;
        }
        .info-loja-lista {
            padding-left: 0;
            list-style: none;
            margin: 20px 0;
        }
        .info-loja-lista li {
            color: var(--texto-corpo);
            margin-bottom: 12px;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .info-loja-lista strong {
            color: var(--texto-titulo);
        }
        .btn-rota {
            display: inline-block;
            background: #111;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 4px;
            text-transform: uppercase;
            transition: background 0.3s ease;
            margin-top: 10px;
        }
        .btn-rota:hover {
            background: var(--cor-destaque);
        }
        [data-theme="dark"] .btn-rota {
            background: #fff;
            color: #111;
        }
        [data-theme="dark"] .btn-rota:hover {
            background: var(--cor-destaque);
            color: #fff;
        }
        .mapa-container {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px var(--sombra);
            border: 2px solid var(--borda-input);
            min-height: 320px;
        }
        .mapa-container iframe {
            width: 100%;
            height: 100%;
            border: 0;
            min-height: 320px;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <section class="pagina-banner">
        <div class="banner-actions">
            <a href="../../index.php" class="btn-banner-action">⬅ Voltar ao Início</a>
            <button class="theme-toggle-btn btn-banner-action" id="themeToggle">Modo Escuro 🌙</button>
        </div>
        <h1>' . $titulo . '</h1>
        <p>' . $subtitulo . '</p>
    </section>

    <section class="pagina-interna">
        <h1>' . $titulo . '</h1>
        <p class="data-atualizacao">Última atualização: ' . $data_atualizacao . '</p>
        ' . $conteudo_html . '
    </section>

    <script>
        // Lógica do Modo Escuro / Claro
        const themeToggleBtn = document.getElementById("themeToggle");
        const currentTheme = localStorage.getItem("theme");
        
        if (currentTheme) {
            document.documentElement.setAttribute("data-theme", currentTheme);
            if (currentTheme === "dark") {
                themeToggleBtn.innerHTML = "Modo Claro ☀️";
            }
        }
        
        themeToggleBtn.addEventListener("click", () => {
            let theme = document.documentElement.getAttribute("data-theme");
            if (theme === "dark") {
                document.documentElement.setAttribute("data-theme", "light");
                localStorage.setItem("theme", "light");
                themeToggleBtn.innerHTML = "Modo Escuro 🌙";
            } else {
                document.documentElement.setAttribute("data-theme", "dark");
                localStorage.setItem("theme", "dark");
                themeToggleBtn.innerHTML = "Modo Claro ☀️";
            }
        });
    </script>
</body>
</html>';
?>