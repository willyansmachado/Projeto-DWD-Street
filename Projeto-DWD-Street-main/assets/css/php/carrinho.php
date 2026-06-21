<?php
// Inicia a sessão para saber se o cliente está logado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Exemplo de verificação: Se você quiser que apenas usuários logados vejam o carrinho
// if (!isset($_SESSION['usuario_id'])) {
//     header("Location: login.php");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Carrinho | DWD Street</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body class="bg-light">
    <main class="container">
         <a href="index.php" class="logo">DWD<span>STREET</span></a>
        <h2 class="title-page">MEU CARRINHO</h2>
        <div class="cart-grid">
            
            <div class="cart-items-list" id="lista-carrinho">
                </div>
            
            <div class="cart-summary-box">
                <h3>RESUMO</h3>
                <div class="summary-line"><span>Subtotal</span> <span id="subtotal-preco">R$ 0,00</span></div>
                <div class="summary-line"><span>Frete</span> <span class="free">GRÁTIS</span></div>
                <div class="summary-total"><span>TOTAL</span> <span id="total-preco">R$ 0,00</span></div>
                
                <a href="pagamento.php" class="btn-banner" id="btn-finalizar">FINALIZAR COMPRA</a>
            </div>
        </div>
    </main>
    <button id="theme-toggle" class="theme-toggle">🌙</button>

    <script>
        // ==========================================
        // MODO ESCURO 
        // ==========================================
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }

        const themeToggleBtn = document.getElementById('theme-toggle');
        const body = document.body;

        if (themeToggleBtn) {
            if (body.classList.contains('dark-mode')) {
                themeToggleBtn.textContent = '☀️'; 
            }

            themeToggleBtn.addEventListener('click', () => {
                body.classList.toggle('dark-mode');
                
                if (body.classList.contains('dark-mode')) {
                    localStorage.setItem('theme', 'dark');
                    themeToggleBtn.textContent = '☀️';
                } else {
                    localStorage.setItem('theme', 'light');
                    themeToggleBtn.textContent = '🌙';
                }
            });
        }

        // ==========================================
        // SISTEMA DO CARRINHO
        // ==========================================
        function carregarCarrinho() {
            let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
            
            const containerItens = document.getElementById('lista-carrinho');
            const subtotalPreco = document.getElementById('subtotal-preco');
            const totalPreco = document.getElementById('total-preco');
            const btnFinalizar = document.getElementById('btn-finalizar');
            
            if (!containerItens) return;
            
            containerItens.innerHTML = '';
            let valorTotal = 0;

            if (carrinho.length === 0) {
                containerItens.innerHTML = '<p style="text-align: center; padding: 20px; color: #888;">Seu carrinho está vazio.</p>';
                if(subtotalPreco) subtotalPreco.textContent = 'R$ 0,00';
                if(totalPreco) totalPreco.textContent = 'R$ 0,00';
                
                // Desativa o botão se o carrinho estiver vazio
                if(btnFinalizar) {
                    btnFinalizar.style.pointerEvents = 'none';
                    btnFinalizar.style.opacity = '0.5';
                }
                return;
            } else {
                if(btnFinalizar) {
                    btnFinalizar.style.pointerEvents = 'auto';
                    btnFinalizar.style.opacity = '1';
                }
            }

            carrinho.forEach((produto, index) => {
                valorTotal += (produto.preco * produto.quantidade);
                
                containerItens.innerHTML += `
                    <div class="cart-item">
                        <img src="${produto.imagem_url}" alt="${produto.nome}">
                        <div class="item-details">
                            <h4>${produto.nome}</h4>
                            <p>Quantidade: ${produto.quantidade}</p>
                            <span class="item-price">R$ ${produto.preco.toFixed(2).replace('.', ',')}</span>
                        </div>
                        <button class="remove-btn" onclick="removerItem(${index})">🗑️</button>
                    </div>
                `;
            });

            let valorFormatado = 'R$ ' + valorTotal.toFixed(2).replace('.', ',');
            if(subtotalPreco) subtotalPreco.textContent = valorFormatado;
            if(totalPreco) totalPreco.textContent = valorFormatado;
        }

        window.removerItem = function(index) {
            let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
            carrinho.splice(index, 1);
            localStorage.setItem('carrinho_itens', JSON.stringify(carrinho));
            carregarCarrinho();
        };

        document.addEventListener("DOMContentLoaded", carregarCarrinho);
    </script>
</body>
</html>