<?php
// seguranca.php

// 1. Definição das variáveis de conteúdo da página
$titulo = 'Segurança do <span>Site</span>';
$subtitulo = 'Saiba como protegemos seus dados e garantimos uma compra 100% segura.';
$data_atualizacao = '17/06/2026';

$conteudo_html = '
<p style="text-align: center; font-size: 1.1rem; line-height: 1.6; color: var(--texto-corpo); margin-bottom: 40px;">
    Na DWD Street, a segurança dos seus dados e das suas transações financeiras é levada a sério. Utilizamos tecnologias de ponta para garantir que sua navegação e experiência de compra sejam totalmente blindadas contra ameaças.
</p>

<div class="politica-bloco">        
    <h2>1. Criptografia SSL (Navegação Segura)</h2>
    <p>Todo o nosso site opera sob o protocolo HTTPS. Isso significa que:</p>
    <ul>
        <li>Todas as informações trocadas entre o seu navegador e os nossos servidores são totalmente criptografadas através de um certificado <strong>SSL (Secure Sockets Layer)</strong> ativo.</li>
        <li>Dados pessoais, senhas e históricos de navegação ficam ilegíveis para terceiros, impedindo a interceptação de dados por criminosos virtuais.</li>
    </ul>
</div>

<div class="politica-bloco">
    <h2>2. Segurança nos Pagamentos</h2>
    <p>Sua segurança financeira é nossa prioridade absoluta. Por isso, adotamos os seguintes padrões:</p>
    <ul>
        <li><strong>Sem armazenamento de cartões:</strong> Os dados do seu cartão de crédito não ficam salvos em nosso banco de dados. Toda a validação é feita diretamente com as operadoras de cartão através de gateways de pagamento homologados.</li>
        <li><strong>Intermediadores Oficiais:</strong> As transações via PIX ou cartão de crédito utilizam sistemas com certificação PCI-DSS (padrão internacional de segurança para a indústria de cartões de pagamento).</li>
    </ul>
</div>

<div class="politica-bloco">
    <h2>3. Proteção Contra Ataques e Invasões</h2>
    <p>Para manter a estabilidade da nossa plataforma de streetwear e proteger as contas dos usuários, implementamos:</p>
    <ul>
        <li>Sistemas de monitoramento contínuo para bloquear tentativas de acessos suspeitos ou ataques de força bruta (tentativas repetidas de adivinhar senhas).</li>
        <li>Firewalls ativos que filtram o tráfego do site e impedem a execução de códigos maliciosos no nosso banco de dados.</li>
    </ul>
</div>

<div class="politica-bloco">
    <h2>4. O que você pode fazer para se proteger</h2>
    <p>
        A segurança digital também depende de boas práticas do usuário. Recomendamos fortemente que você:
    </p>
    <ul>
        <li>Crie senhas fortes contendo letras maiúsculas, minúsculas, números e caracteres especiais, evitando usar a mesma senha de outros sites.</li>
        <li>Nunca compartilhe suas credenciais de acesso da DWD Street com terceiros.</li>
        <li>Mantenha o sistema operacional e o navegador do seu celular ou computador sempre atualizados.</li>
    </ul>
</div>';

// 2. Renderização do HTML via PHP
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