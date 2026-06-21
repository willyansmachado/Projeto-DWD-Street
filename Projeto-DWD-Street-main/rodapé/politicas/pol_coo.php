<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Cookies | DWD Street</title>
    <!-- Link para o seu CSS global -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Link para a fonte Montserrat -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        /* 1. VARIÁVEIS DE CORES */
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

        /* Estilos Gerais */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-principal);
            color: var(--texto-titulo);
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Botões de Ação do Banner (Topo Esquerdo e Direito) */
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
            font-family: 'Montserrat', sans-serif;
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

        /* Banner Superior */
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
        }

        .pagina-banner h1 span {
            color: var(--cor-destaque);
        }

        .pagina-banner p {
            margin: 10px 0 0 0;
            font-size: 1rem;
            color: #ccc;
        }

        /* Seção Interna */
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

        .introducao-texto {
            font-size: 1.1rem;
            line-height: 1.6;
            color: var(--texto-corpo);
            margin-bottom: 40px;
            text-align: center;
        }

        /* Cards de Tópicos de Política */
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

        /* Lista de cookies estilizada */
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

        .politica-bloco li:last-child {
            margin-bottom: 0;
        }

        .politica-bloco strong {
            color: var(--texto-titulo);
        }
    </style>
</head>
<body>

    <section class="pagina-banner">
        <!-- Botões do Topo (Voltar e Tema) CORRIGIDO PARA SUBIR DUAS PASTAS -->
        <div class="banner-actions">
            <a href="../../index.php" class="btn-banner-action">⬅ Voltar ao Início</a>
            <button class="theme-toggle-btn btn-banner-action" id="themeToggle">Modo Escuro 🌙</button>
        </div>

        <h1>POLÍTICA DE <span>COOKIES</span></h1>
        <p>Transparência total sobre como cuidamos da sua experiência e privacidade.</p>
    </section>

    <section class="pagina-interna">

        <h1>Política de <span>Cookies</span></h1>
        <p class="data-atualizacao">Última atualização: 29/05/2026</p>

        <p class="introducao-texto">
            Seja bem-vindo! Quando você visita o DWD Street, nós podemos armazenar ou recuperar informações no seu navegador, principalmente na forma de cookies. Essa política explica o que são essas tecnologias, como as usamos e os seus direitos de controle.
        </p>

        <!-- TÓPICO 1 -->
        <div class="politica-bloco">        
            <h2>1. O que são Cookies?</h2>
            <p>
                Cookies são pequenos arquivos de texto salvos no seu computador ou celular quando você visita um site. Eles servem para fazer o site funcionar mais rápido, lembrar das suas preferências (como idioma e login) e nos ajudar a entender como você interage com a nossa página para melhorar sua navegação.
            </p>
        </div>

        <!-- TÓPICO 2 -->
        <div class="politica-bloco">
            <h2>2. Que tipo de Cookies nós usamos?</h2>
            <p>Nós dividimos os cookies do nosso site em quatro categorias principais:</p>
            
            <ul>
                <li>
                    <strong>Cookies Estritamente Necessários (Essenciais):</strong> São obrigatórios para o site funcionar. Eles garantem a segurança da página, o carregamento correto dos elementos e recursos básicos (como fazer login ou encher um carrinho de compras). Esses não podem ser desligados do nosso sistema.
                </li>
                <li>
                    <strong>Cookies de Desempenho e Analíticos:</strong> Nos ajudam a saber quais páginas são mais populares e como os visitantes se movem pelo site. Toda a informação coletada é anônima e serve apenas para melhorar a performance técnica da nossa loja (ex: Google Analytics).
                </li>
                <li>
                    <strong>Cookies de Funcionalidade:</strong> Permitem que o site lembre de escolhas que você fez no passado (como seu nome de usuário, tema ou região) para proporcionar uma experiência mais fluida e personalizada.
                </li>
                <li>
                    <strong>Cookies de Publicidade/Marketing:</strong> Podem ser definidos por nós ou por parceiros de anúncios (como Facebook ou Google). Eles servem para criar um perfil dos seus interesses e mostrar anúncios baseados em tendências de streetwear que tenham mais a ver com você em outros sites.
                </li>
            </ul>
        </div>

        <!-- TÓPICO 3 -->
        <div class="politica-bloco">
            <h2>3. Como Gerenciar ou Excluir Cookies?</h2>
            <p>
                Você pode, a qualquer momento, desativar ou alterar a forma como seu navegador lida com cookies acessando as configurações de privacidade do seu browser (Chrome, Edge, Firefox, Safari, etc.). Vale ressaltar que a desativação total de cookies pode impactar a sua experiência de navegação, impedindo o funcionamento perfeito de algumas ferramentas de compra da nossa loja.
            </p>
        </div>

    </section>

    <!-- SCRIPT DE GERENCIAMENTO DE TEMA -->
    <script>
        const themeToggleBtn = document.getElementById('themeToggle');
        const currentTheme = localStorage.getItem('theme');

        if (currentTheme) {
            document.documentElement.setAttribute('data-theme', currentTheme);
            if (currentTheme === 'dark') {
                themeToggleBtn.innerHTML = 'Modo Claro ☀️';
            }
        }

        themeToggleBtn.addEventListener('click', () => {
            let theme = document.documentElement.getAttribute('data-theme');
            
            if (theme === 'dark') {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
                themeToggleBtn.innerHTML = 'Modo Escuro 🌙';
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                themeToggleBtn.innerHTML = 'Modo Claro ☀️';
            }
        });
    </script>

</body>
</html>