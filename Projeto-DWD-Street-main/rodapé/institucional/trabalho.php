<?php
// trabalho.php

// 1. Inclusão manual e direta dos arquivos utilizando caminhos absolutos (__DIR__)
require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

// CORREÇÃO DO NAMESPACE: Importando formalmente as classes para evitar o Fatal Error
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensagem_sucesso = false;
$mensagem_erro = false;

// 2. Processamento do Formulário via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = strip_tags(trim($_POST['nome']));
    $email_remetente = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $area = strip_tags(trim($_POST['area']));
    
    if (!empty($nome) && filter_var($email_remetente, FILTER_VALIDATE_EMAIL) && isset($_FILES['curriculo'])) {
        $arquivo = $_FILES['curriculo'];
        
        if ($arquivo['error'] == UPLOAD_ERR_OK && $arquivo['type'] == 'application/pdf') {
            
            // Instanciação limpa usando a classe importada pelo 'use' lá em cima
            $mail = new PHPMailer(true);

            try {
                // --- CONFIGURAÇÃO DO SERVIDOR SMTP ---
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';                             // Servidor SMTP do Gmail
                $mail->SMTPAuth   = true;                                         // Ativa a autenticação SMTP
                
                // CORREÇÃO DA CONTA: Usando o seu Gmail pessoal dono da senha de app criada
                $mail->Username   = 'dwdstreet2026@gmail.com';                  
                $mail->Password   = 'yldd eebq bzpe rhpu';                        // Código de 16 dígitos das 'Senhas de App'
                
                $mail->SMTPSecure = 'tls';                                        // Protocolo TLS
                $mail->Port       = 587;                                          // Porta padrão para TLS
                $mail->CharSet    = 'UTF-8';

                // --- REMETENTE E DESTINATÁRIO ---
                $mail->setFrom('dwdstreet2026@gmail.com', 'DWD Street Sistema'); // Remetente combinado com a autenticação
                $mail->addAddress('dwdstreet2026@gmail.com', 'Edu Petry');       // E-mail onde você vai RECEBER os currículos
                $mail->addReplyTo($email_remetente, $nome);                        // Ao clicar em responder, vai para o candidato

                // --- ANEXO DO CURRÍCULO ---
                $mail->addAttachment($arquivo['tmp_name'], $arquivo['name']);

                // --- CONTEÚDO DO E-MAIL ---
                $mail->isHTML(true);
                $mail->Subject = "⚡ Novo Currículo recebido: $nome ($area)";
                
                $mail->Body    = "
                    <div style='font-family: Montserrat, sans-serif; padding: 20px; background-color: #f9f9f9; border-left: 5px solid #e31e24;'>
                        <h2 style='color: #111; text-transform: uppercase;'>Novo candidato para a equipe DWD Street!</h2>
                        <p style='color: #333; font-size: 16px;'><strong>Nome:</strong> $nome</p>
                        <p style='color: #333; font-size: 16px;'><strong>E-mail:</strong> $email_remetente</p>
                        <p style='color: #333; font-size: 16px;'><strong>Área de Interesse:</strong> " . strtoupper($area) . "</p>
                        <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                        <p style='color: #777; font-size: 13px; font-style: italic;'>O currículo em PDF foi anexado automaticamente a esta mensagem.</p>
                    </div>
                ";

                $mail->send();
                $mensagem_sucesso = true;
            } catch (Exception $e) {
                $mensagem_erro = "Não foi possível enviar o e-mail. Detalhes do erro: {$mail->ErrorInfo}";
            }
        } else {
            $mensagem_erro = "Por favor, envie o currículo apenas no formato PDF.";
        }
    } else {
        $mensagem_erro = "Preencha todos os campos corretamente.";
    }
}

// 3. Definição das variáveis visuais da página
$titulo = 'Trabalhe <span>Conosco</span>';
$subtitulo = 'Faça parte da nossa equipe e ajude a ditar o ritmo da cultura urbana.';
$data_atualizacao = '17/06/2026';

$conteudo_html = '
<p style="text-align: center; font-size: 1.1rem; line-height: 1.6; color: var(--texto-corpo); margin-bottom: 40px;" class="animar-entrada">
    Buscamos pessoas autênticas, criativas e que respirem streetwear. Se você tem paixão por moda, arte urbana, atendimento ou logística, seu lugar é com a gente!
</p>

<div class="trabalhe-grid">
    <div class="coluna-vagas">
        <h2 class="titulo-secao animar-entrada">🔥 Vagas Abertas (Joinville / Remoto)</h2>
        
        <div class="card-vaga animar-entrada" style="animation-delay: 0.2s;">
            <div class="vaga-tag">Presencial</div>
            <h3>Consultor de Vendas (Loja Física)</h3>
            <p>Seja a cara do nosso ecossistema. Atendimento ao cliente de forma autêntica e organização da loja conceito.</p>
            <span class="vaga-local">📍 Rua Osni Borges, 86 - Joinville</span>
        </div>

        <div class="card-vaga animar-entrada" style="animation-delay: 0.4s;">
            <div class="vaga-tag remoto">Remoto / Híbrido</div>
            <h3>Social Media & Creator de Moda</h3>
            <p>Responsável pela criação de conteúdo orgânico (TikTok/Instagram), cobertura de drops e conexão com influenciadores.</p>
            <span class="vaga-local">📍 Joinville ou 100% Remoto</span>
        </div>

        <div class="card-vaga animar-entrada" style="animation-delay: 0.6s;">
            <div class="vaga-tag">Presencial</div>
            <h3>Auxiliar de Logística (E-commerce)</h3>
            <p>Responsável pelo controle minucioso do estoque de streetwear, embalagem cuidadosa e expedição veloz dos drops enviados a todo o país.</p>
            <span class="vaga-local">📍 Centro de Distribuição - Joinville</span>
        </div>
    </div>

    <div class="coluna-formulario animar-entrada" style="animation-delay: 0.4s;">
        <div class="politica-bloco formulario-bloco">
            <h2>Mande seu currículo ⚡</h2>
            <p>Preencha os campos abaixo e anexe seu portfólio ou currículo para análise de nossa equipe de talentos.</p>
            
            ';
            if ($mensagem_sucesso) {
                $conteudo_html .= '<div class="mensagem-sucesso" style="display:block;">Inscrição enviada com sucesso para nossa equipe! 🔥</div>';
            }
            if ($mensagem_erro) {
                $conteudo_html .= '<div class="mensagem-erro" style="display:block;">❌ ' . $mensagem_erro . '</div>';
            }
            
$conteudo_html .= '
            <form action="" method="POST" enctype="multipart/form-data" class="form-dwd" id="formCarreira">
                <div class="grupo-input">
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" required placeholder="Ex: Lucas Silva">
                </div>

                <div class="grupo-input">
                    <label for="email">E-mail para contato:</label>
                    <input type="email" id="email" name="email" required placeholder="Ex: lucas@email.com">
                </div>

                <div class="grupo-input">
                    <label for="area">Área de Interesse:</label>
                    <select id="area" name="area" required>
                        <option value="" disabled selected>Selecione...</option>
                        <option value="vendas">Vendas / Atendimento</option>
                        <option value="marketing">Marketing / Social Media</option>
                        <option value="logistica">Logística / Estoque</option>
                        <option value="design">Design de Produto / Estampas</option>
                    </select>
                </div>

                <div class="grupo-input">
                    <label for="curriculo" class="label-file">📄 Enviar Currículo (PDF apenas):</label>
                    <input type="file" id="curriculo" name="curriculo" accept=".pdf" required>
                </div>

                <button type="submit" class="btn-enviar-form">Enviar Candidatura 🚀</button>
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
            --cor-destaque: #e31e24;
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
            border-left: 5px solid #111;
            margin-bottom: 20px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
        }
        .card-vaga:hover {
            transform: translateX(8px) translateY(-2px);
            border-left-color: var(--cor-destaque);
            box-shadow: 0 10px 20px var(--sombra);
        }
        [data-theme="dark"] .card-vaga {
            border-left-color: #444;
        }
        [data-theme="dark"] .card-vaga:hover {
            border-left-color: var(--cor-destaque);
        }
        .card-vaga h3 {
            margin: 10px 0 5px 0;
            font-weight: 700;
            font-size: 1.15rem;
        }
        .card-vaga p {
            font-size: 0.95rem;
            color: var(--texto-corpo);
            margin: 0 0 15px 0;
            line-height: 1.5;
        }
        .vaga-tag {
            display: inline-block;
            background: #e1f5fe;
            color: #0288d1;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .vaga-tag.remoto {
            background: #e8f5e9;
            color: #388e3c;
        }
        .vaga-local {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--texto-titulo);
            opacity: 0.8;
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
        .grupo-input input, .grupo-input select {
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
        .grupo-input input:focus, .grupo-input select:focus {
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
            transform: translateY(-2px);
        }
        [data-theme="dark"] .btn-enviar-form {
            background: #fff;
            color: #111;
        }
        [data-theme="dark"] .btn-enviar-form:hover {
            background: var(--cor-destaque);
            color: #fff;
        }

        .mensagem-sucesso {
            background: #4caf50;
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