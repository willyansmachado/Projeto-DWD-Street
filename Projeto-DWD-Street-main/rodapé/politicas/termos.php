<?php
// termos.php

// 1. Definição das variáveis de conteúdo da página
$titulo = 'Termos e <span>Condições</span>';
$subtitulo = 'Regras de uso, condições de compra e responsabilidades da nossa plataforma.';
$data_atualizacao = '17/06/2026';

$conteudo_html = '
<p style="text-align: center; font-size: 1.1rem; line-height: 1.6; color: var(--texto-corpo); margin-bottom: 40px;">
    Ao navegar ou realizar compras no site da DWD Street, você concorda integralmente com os termos, regras e diretrizes descritas abaixo. Estes termos regulamentam a venda de nossos produtos e o uso dos nossos serviços digitais.
</p>

<!-- TÓPICO 1 -->
<div class="politica-bloco">        
    <h2>1. Cadastro e Utilização da Conta</h2>
    <p>Para realizar pedidos e usufruir de nossa loja, o usuário deve observar os seguintes pontos:</p>
    <ul>
        <li>O cliente é o único responsável por fornecer informações corretas e atualizadas (como endereço, e-mail e dados de contato) para garantir o envio e a logística correta de suas encomendas.</li>
        <li>A segurança da senha de acesso é de inteira responsabilidade do usuário. A DWD Street não se responsabiliza por acessos indevidos decorrentes de negligência com as credenciais.</li>
        <li>Menores de 18 anos devem estar sob supervisão de pais ou responsáveis ao realizar transações financeiras na plataforma.</li>
    </ul>
</div>

<!-- TÓPICO 2 -->
<div class="politica-bloco">
    <h2>2. Política de Compras, Preços e Estoque</h2>
    <p>Trabalhamos de forma contínua para manter a precisão das informações em nossa vitrine virtual:</p>
    <ul>
        <li>Preços, descontos e estoques de roupas e acessórios de streetwear estão sujeitos a alterações sem aviso prévio.</li>
        <li>A inclusão de um produto no "Carrinho de Compras" não garante a reserva do item ou o preço atual. O produto só é reservado após a finalização e confirmação do pagamento.</li>
        <li>Em cenários raros de erro sistêmico crasso no valor exibido de um produto, a DWD Street se reserva o direito de cancelar o pedido e estornar o valor integral ao cliente.</li>
    </ul>
</div>

<!-- TÓPICO 3 -->
<div class="politica-bloco">
    <h2>3. Propriedade Intelectual</h2>
    <p>Todo o conteúdo visual e estrutural presente no site da DWD Street é protegido por leis de direitos autorais:</p>
    <ul>
        <li>Logotipos, identidades visuais, estampas, fotografias de produtos, banners, textos descritivos e códigos de programação são de propriedade exclusiva da DWD Street ou de seus fornecedores licenciados.</li>
        <li>É terminantemente proibida a reprodução, modificação, distribuição ou cópia comercial de qualquer elemento da nossa plataforma sem autorização expressa prévia por escrito.</li>
    </ul>
</div>

<!-- TÓPICO 4 -->
<div class="politica-bloco">
    <h2>4. Limitação de Responsabilidade</h2>
    <p>
        Buscamos manter o site no ar de forma ininterrupta, estável e segura. Contudo, não nos responsabilizamos por indisponibilidades temporárias causadas por manutenções preventivas, falhas gerais de conexão de internet ou problemas de servidores de terceiros. Quaisquer divergências jurídicas decorrentes do uso deste site serão resolvidas sob a vigência das leis da República Federativa do Brasil.
    </p>
</div>';

// 2. Renderização do HTML via PHP (Evita conflitos de aspas e telas brancas)
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
            max-width: 850px;
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
        .politica-bloco {
            background: var(--bg-card);
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0 4px 12px var(--sombra);
            border-left: 5px solid var(--cor-destaque);
            margin-bottom: 25px;
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
            margin-bottom: 0;
        }
        .politica-bloco ul {
            padding-left: 20px;
            margin-top: 15px;
            margin-bottom: 0;
        }
        .politica-bloco li {
            color: var(--texto-corpo);
            line-height: 1.7;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        .politica-bloco strong {
            color: var(--texto-titulo);
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