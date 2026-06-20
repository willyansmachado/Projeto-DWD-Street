<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidade | DWD Street</title>
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
        <div class="banner-actions">
            <a href="../../index.php" class="btn-banner-action">⬅ Voltar ao Início</a>
            <button class="theme-toggle-btn btn-banner-action" id="themeToggle">Modo Escuro 🌙</button>
        </div>

        <h1>POLÍTICA DE <span>PRIVACIDADE</span></h1>
        <p>Sua privacidade é nossa prioridade. Saiba como protegemos seus dados.</p>
    </section>

    <section class="pagina-interna">

        <h1>Política de <span>Privacidade</span></h1>
        <p class="data-atualizacao">Última atualização: 17/06/2026</p>

        <p class="introducao-texto">
            Na DWD Street, privacidade e transparência andam juntas. Esta Política de Privacidade descreve quais dados pessoais nós coletamos, como eles são utilizados, armazenados e protegidos quando você compra em nossa loja ou interage com nossa comunidade.
        </p>

        <!-- TÓPICO 1 -->
        <div class="politica-bloco">        
            <h2>1. Quais informações nós coletamos?</h2>
            <p>Para fornecer a melhor experiência de compra de streetwear, nós coletamos alguns dados essenciais:</p>
            <ul>
                <li><strong>Dados de Cadastro:</strong> Nome completo, CPF, e-mail, telefone e senha criptografada quando você cria uma conta.</li>
                <li><strong>Dados de Entrega e Cobrança:</strong> Endereço residencial, endereço de entrega e informações de pagamento (processadas de forma 100% segura por intermediadores oficiais).</li>
                <li><strong>Dados de Navegação:</strong> Endereço IP, tipo de navegador, produtos visualizados e interações na página através de cookies e tecnologias analíticas.</li>
            </ul>
        </div>

        <!-- TÓPICO 2 -->
        <div class="politica-bloco">
            <h2>2. Como utilizamos os seus dados?</h2>
            <p>Seus dados são coletados exclusivamente para finalidades comerciais e logísticas legítimas, incluindo:</p>
            <ul>
                <li>Processar seus pedidos, confirmar pagamentos e enviar seus produtos com segurança.</li>
                <li>Prestar suporte ao cliente e responder a dúvidas, trocas ou devoluções.</li>
                <li>Enviar atualizações sobre o andamento da sua entrega e novidades exclusivas da loja (caso você autorize o nosso newsletter).</li>
                <li>Garantir a segurança contra fraudes cibernéticas e proteger o ambiente da nossa plataforma.</li>
            </ul>
        </div>

        <!-- TÓPICO 3 -->
        <div class="politica-bloco">
            <h2>3. Com quem compartilhamos seus dados?</h2>
            <p>
                Nós **nunca** vendemos ou alugamos seus dados pessoais para terceiros. O compartilhamento ocorre estritamente para o funcionamento dos serviços contratados por você, sendo compartilhado com:
            </p>
            <ul>
                <li><strong>Empresas de Logística:</strong> Transportadoras e Correios para efetuar a entrega das suas encomendas.</li>
                <li><strong>Gateways de Pagamento:</strong> Instituições financeiras parceiras que processam transações de cartão de crédito e PIX com criptografia de ponta.</li>
                <li><strong>Autoridades Judiciais:</strong> Apenas quando exigido por lei ou por intimação legal competente.</li>
            </ul>
        </div>

        <!-- TÓPICO 4 -->
        <div class="politica-bloco">
            <h2>4. Segurança e Seus Direitos</h2>
            <p>
                Adotamos rígidas medidas técnicas de segurança (como o protocolo SSL) para proteger suas informações de acessos não autorizados. De acordo com a Lei Geral de Proteção de Dados (LGPD), você possui o direito de confirmar a existência do tratamento de dados, acessar suas informações, corrigir dados incompletos ou solicitar a exclusão definitiva da sua conta a qualquer momento entrando em contato conosco.
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