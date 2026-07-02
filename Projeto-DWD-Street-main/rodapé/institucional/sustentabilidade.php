<?php
// sustentabilidade.php

// 1. Inclusão manual e direta dos arquivos utilizando caminhos absolutos (__DIR__)
require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensagem_sucesso = false;
$mensagem_erro = false;

// 2. Processamento do Formulário via POST (Para envio de ideias ecológicas)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = strip_tags(trim($_POST['nome']));
    $email_remetente = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $ideia = strip_tags(trim($_POST['ideia']));
    
    if (!empty($nome) && filter_var($email_remetente, FILTER_VALIDATE_EMAIL) && !empty($ideia)) {
        
        $mail = new PHPMailer(true);

        try {
            // --- CONFIGURAÇÃO DO SERVIDOR SMTP ---
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';                             
            $mail->SMTPAuth   = true;                                         
            $mail->Username   = 'edupetryribeiro@gmail.com'; // Seu Gmail pessoal                  
            $mail->Password   = 'bkqr txja khlf mfiu';       // Código de 16 dígitos das 'Senhas de App'
            $mail->SMTPSecure = 'tls';                                        
            $mail->Port       = 587;                                          
            $mail->CharSet    = 'UTF-8';

            // --- REMETENTE E DESTINATÁRIO ---
            $mail->setFrom('edupetryribeiro@gmail.com', 'DWD Eco Sistema'); 
            $mail->addAddress('edupetryribeiro@gmail.com', 'Edu Petry');       
            $mail->addReplyTo($email_remetente, $nome);                        

            // --- CONTEÚDO DO E-MAIL ---
            $mail->isHTML(true);
            $mail->Subject = "🌱 Nova Ideia de Sustentabilidade de $nome";
            
            $mail->Body    = "
                <div style='font-family: Montserrat, sans-serif; padding: 20px; background-color: #f4fbf7; border-left: 5px solid #2ecc71;'>
                    <h2 style='color: #111; text-transform: uppercase;'>Nova sugestão sustentável para a DWD Street!</h2>
                    <p style='color: #333; font-size: 16px;'><strong>Nome:</strong> $nome</p>
                    <p style='color: #333; font-size: 16px;'><strong>E-mail:</strong> $email_remetente</p>
                    <p style='color: #333; font-size: 16px;'><strong>Mensagem / Ideia:</strong><br>$ideia</p>
                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                    <p style='color: #777; font-size: 13px; font-style: italic;'>Esse e-mail foi gerado automaticamente pelo formulário da página de Sustentabilidade.</p>
                </div>
            ";

            $mail->send();
            $mensagem_sucesso = true;
        } catch (Exception $e) {
            $mensagem_erro = "Não foi possível enviar sua sugestão. Erro: {$mail->ErrorInfo}";
        }
    } else {
        $mensagem_erro = "Preencha todos os campos corretamente.";
    }
}

// 3. Definição das variáveis visuais da página
$titulo = 'DWD <span>Green</span>';
$subtitulo = 'O futuro do streetwear é consciente. Descubra nossas metas e ações ecológicas.';

$conteudo_html = '
<p style="text-align: center; font-size: 1.1rem; line-height: 1.6; color: var(--texto-corpo); margin-bottom: 40px;" class="animar-entrada">
    Acreditamos que ditar o ritmo da cultura urbana também significa proteger o espaço onde vivemos. Conheça nossos pilares ecológicos e colabore com o ecossistema.
</p>

<div class="trabalhe-grid">
    <div class="coluna-vagas">
        <h2 class="titulo-secao animar-entrada">🌿 Nossos Compromissos</h2>
        
        <div class="card-vaga animar-entrada" style="animation-delay: 0.2s; border-left-color: #2ecc71;">
            <div class="vaga-tag" style="background: #e8f5e9; color: #2ecc71;">Matéria-Prima</div>
            <h3>Algodão 100% Orgânico</h3>
            <p>Nossos drops utilizam exclusivamente algodão cultivado sem defensivos agrícolas químicos, reduzindo o impacto no solo e o consumo excessivo de água.</p>
        </div>

        <div class="card-vaga animar-entrada" style="animation-delay: 0.4s; border-left-color: #2ecc71;">
            <div class="vaga-tag" style="background: #e8f5e9; color: #2ecc71;">Circularidade</div>
            <h3>Logística Reversa (DWD Cycle)</h3>
            <p>Compramos suas peças antigas da DWD em formato de créditos para novos drops. O material coletado é transformado em novas fibras e designs exclusivos.</p>
        </div>

        <div class="card-vaga animar-entrada" style="animation-delay: 0.6s; border-left-color: #2ecc71;">
            <div class="vaga-tag" style="background: #e8f5e9; color: #2ecc71;">Envios</div>
            <h3>Embalagens Biodegradáveis</h3>
            <p>Todos os pedidos enviados pelo e-commerce saem em sacolas feitas à base de fécula de mandioca, que se decompõem naturalmente em até 180 dias.</p>
        </div>
    </div>

    <div class="coluna-formulario animar-entrada" style="animation-delay: 0.4s;">
        <div class="politica-bloco formulario-bloco" style="border-left-color: #2ecc71;">
            <h2>Mande sua Ideia 🌱</h2>
            <p>Tem alguma sugestão de parceria eco-friendly ou projeto sustentável? Envie para o nosso comitê de impacto!</p>
            
            ';
            if ($mensagem_sucesso) {
                $conteudo_html .= '<div class="mensagem-sucesso" style="background: #2ecc71; display:block;">Sua ideia foi enviada com sucesso! Obrigado por nos ajudar a crescer verde! 🌍</div>';
            }
            if ($mensagem_erro) {
                $conteudo_html .= '<div class="mensagem-erro" style="display:block;">❌ ' . $mensagem_erro . '</div>';
            }
            
$conteudo_html .= '
            <form action="" method="POST" class="form-dwd" id="formSustentabilidade">
                <div class="grupo-input">
                    <label for="nome">Nome / Empresa:</label>
                    <input type="text" id="nome" name="nome" required placeholder="Ex: João Silva">
                </div>

                <div class="grupo-input">
                    <label for="email">E-mail de contato:</label>
                    <input type="email" id="email" name="email" required placeholder="Ex: joao@eco.com">
                </div>

                <div class="grupo-input">
                    <label for="ideia">Sua Proposta ou Ideia:</label>
                    <textarea id="ideia" name="ideia" required placeholder="Descreva aqui sua ideia ou sugestão ecológica para a DWD..." style="width: 100%; padding: 12px; border-radius: 6px; border: 2px solid var(--borda-input); background: var(--bg-input); color: var(--texto-titulo); font-family: \'Montserrat\', sans-serif; font-size: 0.95rem; box-sizing: border-box; transition: all 0.3s ease; height: 120px; resize: vertical;"></textarea>
                </div>

                <button type="submit" class="btn-enviar-form" style="background: #111;">Enviar Sugestão ⚡</button>
            </form>
        </div>
    </div>
</div>';

// 4. Renderização completa do HTML via PHP
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
            --cor-destaque: #2ecc71; /* Verde Sustentável */
            --borda-input: #ddd;
            --bg-input: #f1f1f1;
        }
        [data-theme="dark"] {
            --bg-principal: #121212;
            --bg-card: #1e1e1e;
            --texto-titulo: #ffffff;
            --texto-corpo: #b3b3b3;
            --sombra: rgba(0, 0, 0, 0.3);
            --borda-input: #444;
            --bg-input: #2a2a2a;
        }
        body {
            font-family: "Montserrat", sans-serif;
            background-color: var(--bg-principal);
            color: var(--texto-titulo);
            margin: 0;
            padding: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
            overflow-x: hidden;
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
            background: linear-gradient(135deg, #0d2013 0%, #1a3a25 100%);
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
            animation: flutuar 4s ease-in-out infinite;
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
            max-width: 1050px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .trabalhe-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 40px;
            margin-top: 30px;
        }
        @media (max-width: 850px) {
            .trabalhe-grid {
                grid-template-columns: 1fr;
            }
        }

        .titulo-secao {
            font-weight: 900;
            text-transform: uppercase;
            font-size: 1.4rem;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }

        .card-vaga {
            background: var(--bg-card);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px var(--sombra);
            border-left: 5px solid var(--cor-destaque);
            margin-bottom: 20px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
        }
        .card-vaga:hover {
            transform: translateX(8px) translateY(-2px);
            box-shadow: 0 10px 20px var(--sombra);
        }

        .politica-bloco {
            background: var(--bg-card);
            padding: 35px;
            border-radius: 8px;
            box-shadow: 0 4px 12px var(--sombra);
            border-left: 5px solid var(--cor-destaque);
        }
        .formulario-bloco h2 {
            margin-top: 0;
            font-weight: 900;
            text-transform: uppercase;
        }
        .form-dwd {
            margin-top: 25px;
        }
        .grupo-input {
            margin-bottom: 20px;
        }
        .grupo-input label {
            display: block;
            font-weight: 700;
            font-size: 0.85rem;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .grupo-input input, .grupo-input textarea {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: 2px solid var(--borda-input);
            background: var(--bg-input);
            color: var(--texto-titulo);
            font-family: "Montserrat", sans-serif;
            font-size: 0.95rem;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }
        .grupo-input input:focus, .grupo-input textarea:focus {
            outline: none;
            border-color: var(--cor-destaque);
            background: var(--bg-card);
        }
        .btn-enviar-form {
            width: 100%;
            background: #111;
            color: #fff;
            border: none;
            padding: 14px;
            font-family: "Montserrat", sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 1rem;
            border-radius: 6px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .btn-enviar-form:hover {
            background: var(--cor-destaque);
            color: #111;
            transform: translateY(-2px);
        }
        [data-theme="dark"] .btn-enviar-form {
            background: #fff;
            color: #111;
        }
        [data-theme="dark"] .btn-enviar-form:hover {
            background: var(--cor-destaque);
            color: #111;
        }

        .mensagem-sucesso {
            color: white;
            padding: 12px;
            border-radius: 6px;
            text-align: center;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 15px;
            animation: popUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .mensagem-erro {
            background: #f44336;
            color: white;
            padding: 12px;
            border-radius: 6px;
            text-align: center;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        @keyframes flutuar {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        @keyframes popUp {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .animar-entrada {
            opacity: 0;
            transform: translateY(20px);
            animation: slideInUp 0.6s ease forwards;
        }
        @keyframes slideInUp {
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