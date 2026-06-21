<?php
// sobre.php

// Dinamizando os fundadores em um Array
$fundadores = [
    [
        "nome" => "Eduardo Ribeiro",
        "imagem" => "../assets/css/img/eduardo.png",
        "descricao" => "Só da Madu Linda"
    ],
    [
        "nome" => "Willyans",
        "imagem" => "../assets/css/img/willyans.png",
        "descricao" => "Só da Duda"
    ],
    [
        "nome" => "Davi",
        "imagem" => "../assets/css/img/davi.png",
        "descricao" => "Só da Isa"
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - DWD Street</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;800;900&display=swap" rel="stylesheet">

<style>
    /* =========================================
       VARIÁVEIS DE CORES E ESTILO
       ========================================= */
    :root {
        --brand-red: #e60000;
        --brand-red-hover: #ff1a1a;
        --brand-red-glow: rgba(230, 0, 0, 0.25);
        --bg-main: #070707;
        --bg-header: rgba(0, 0, 0, 0.85);
        --bg-card: #121212;
        --bg-card-hover: #181818;
        --text-light: #ffffff;
        --text-muted: #b3b3b3;
        --border-subtle: rgba(255, 255, 255, 0.08);
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
        overflow-x: hidden;
    }

    /* =========================================
       TOPO E HEADER
       ========================================= */
    .top-bar {
        background: #111;
        color: var(--text-light);
        text-align: center;
        padding: 10px 15px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        border-bottom: 1px solid var(--border-subtle);
    }

    header {
        background: var(--bg-header);
        backdrop-filter: blur(10px); /* Efeito de vidro esfumaçado */
        -webkit-backdrop-filter: blur(10px);
        padding: 18px 40px;
        display: flex;
        justify-content: center; /* Correção para centralizar perfeitamente */
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1000;
        border-top: 2px solid var(--brand-red);
        border-bottom: 1px solid var(--border-subtle);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .logo {
        font-weight: 900;
        font-size: 1.8rem;
        text-decoration: none;
        color: var(--text-light);
        letter-spacing: -1.5px;
        font-style: italic;
        text-transform: uppercase;
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .logo span {
        color: var(--brand-red);
    }

    .logo:hover {
        transform: scale(1.03) skewX(-2deg);
    }

    /* =========================================
       SESSÃO PRINCIPAL (SOBRE)
       ========================================= */
    .sobre {
        max-width: 1100px;
        margin: auto;
        padding: 100px 20px;
    }

    .sobre h1 {
        text-align: center;
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 60px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .sobre h1 span {
        color: var(--brand-red);
        position: relative;
    }

    /* HISTÓRIA - Layout e Tipografia */
    .historia {
        background: var(--bg-card);
        padding: 60px;
        border-radius: 16px;
        border: 1px solid var(--border-subtle);
        border-left: 4px solid var(--brand-red);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        position: relative;
        overflow: hidden;
    }

    /* Brilho sutil no fundo do card de história */
    .historia::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 150px; height: 100%;
        background: linear-gradient(90deg, var(--brand-red-glow), transparent);
        opacity: 0.3;
        pointer-events: none;
    }

    .historia p {
        margin-bottom: 24px;
        line-height: 1.8;
        font-size: 1.1rem;
        font-weight: 500;
        color: var(--text-muted);
    }

    .historia p:last-child {
        margin-bottom: 0;
        font-weight: 900;
        font-size: 1.6rem;
        color: var(--text-light);
        text-align: center;
        margin-top: 50px;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: relative;
        z-index: 1;
    }

    /* =========================================
       FUNDADORES (GRID E CARDS)
       ========================================= */
    .fundadores {
        margin-top: 120px;
    }

    .fundadores h2 {
        text-align: center;
        font-size: 2.2rem;
        font-weight: 900;
        margin-bottom: 60px;
        text-transform: uppercase;
        letter-spacing: 2px;
        position: relative;
        display: inline-block;
        left: 50%;
        transform: translateX(-50%);
    }

    .fundadores h2::after {
        content: '';
        position: absolute;
        width: 60%;
        height: 4px;
        background: var(--brand-red);
        bottom: -15px;
        left: 20%;
        border-radius: 2px;
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        justify-content: center;
    }

    .card {
        background: var(--bg-card);
        border-radius: 12px;
        overflow: hidden;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        border: 1px solid var(--border-subtle);
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-10px);
        background: var(--bg-card-hover);
        border-color: rgba(230, 0, 0, 0.5); /* Borda fica levemente vermelha no hover */
        box-shadow: 0 15px 35px var(--brand-red-glow);
    }

    .img-container {
        width: 100%;
        aspect-ratio: 4/5; /* Garante que todas as fotos fiquem na mesma proporção */
        overflow: hidden;
        background: #000; /* Fundo escuro enquanto a imagem carrega */
    }

    .card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        filter: grayscale(100%) contrast(1.1);
        transition: all 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .card:hover img {
        filter: grayscale(0%) contrast(1.05);
        transform: scale(1.05);
    }

    .card-info {
        padding: 25px 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card h3 {
        font-size: 1.3rem;
        font-weight: 800;
        color: var(--text-light);
        text-transform: uppercase;
        margin-bottom: 8px;
        letter-spacing: 0.5px;
    }

    .card p {
        color: var(--brand-red);
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin: 0;
    }

    /* =========================================
       FOOTER
       ========================================= */
    footer {
        background: #050505;
        text-align: center;
        padding: 40px 20px;
        margin-top: 100px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        color: var(--text-muted);
        border-top: 1px solid var(--border-subtle);
        text-transform: uppercase;
    }

    /* =========================================
       ANIMAÇÕES DE ENTRADA
       ========================================= */
    .fade-up {
        opacity: 0;
        transform: translateY(40px);
        animation: fadeUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }

    .delay-1 { animation-delay: 0.2s; }
    .delay-2 { animation-delay: 0.4s; }

    @keyframes fadeUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* =========================================
       RESPONSIVIDADE (Telas menores)
       ========================================= */
    @media (max-width: 900px) {
        .sobre {
            padding: 60px 20px;
        }
        .cards {
            grid-template-columns: 1fr;
            max-width: 400px;
            margin: 0 auto;
        }
        .sobre h1 { 
            font-size: 2.2rem; 
            margin-bottom: 40px;
        }
        .historia { 
            padding: 40px 25px; 
        }
        .historia p {
            font-size: 1rem;
        }
        .historia p:last-child {
            font-size: 1.3rem;
        }
        .fundadores h2 { 
            font-size: 1.8rem; 
        }
    }
</style>
</head>

<body>

    <div class="top-bar">
        Entrega rápida em toda Joinville | 10% OFF na primeira compra
    </div>

    <header>
        <a href="../index.php" class="logo" title="Voltar ao Início">
            <span class="logo-dwd">DWD</span>
            <span class="logo-street">STREET</span>
        </a>
    </header>

    <section class="sobre">

        <h1 class="fade-up">Nossa <span>História</span></h1>

        <div class="historia fade-up delay-1">
            <p>
                A <strong>DWD Street</strong> nasceu da união de três amigos apaixonados pela cultura urbana,
                moda streetwear e arte de rua. Tudo começou em encontros simples,
                onde ideias, estilos e sonhos se misturavam entre músicas, skate
                e inspiração das ruas.
            </p>
            <p>
                O objetivo sempre foi criar roupas que representassem atitude,
                autenticidade e liberdade. A marca surgiu como uma forma de expressão,
                trazendo peças modernas, oversized e influenciadas pelo streetwear mundial.
            </p>
            <p>
                Com dedicação e criatividade, a DWD Street foi crescendo e conquistando
                pessoas que enxergam a moda como identidade. Hoje, a marca representa
                mais do que roupas: representa um estilo de vida.
            </p>
            <p>
                DWD Street — Vista sua atitude.
            </p>
        </div>

        <div class="fundadores fade-up delay-2">
            <h2>Fundadores</h2>
            
            <div class="cards">
                <?php foreach ($fundadores as $fundador): ?>
                    <div class="card">
                        <div class="img-container">
                            <img src="<?php echo htmlspecialchars($fundador['imagem']); ?>" alt="<?php echo htmlspecialchars($fundador['nome']); ?>">
                        </div>
                        <div class="card-info">
                            <h3><?php echo htmlspecialchars($fundador['nome']); ?></h3>
                            <p><?php echo htmlspecialchars($fundador['descricao']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </section>

    <footer>
        © <?php echo date('Y'); ?> DWD STREET - TODOS OS DIREITOS RESERVADOS
    </footer>

</body>
</html>