<?php
session_start();

include("config/conexao.php");

// Verifica se está logado
if(!isset($_SESSION["id"])){
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION["id"];

$sql = "SELECT * FROM carrinho WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$resultado = $stmt->get_result();
$subtotal_carrinho = 0;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento | DWD Street</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,600;0,700;0,900;1,900&display=swap" rel="stylesheet">
    
    <style>
        /* RESET E CORES BASE FIÉIS AO SEU PRINT */
        * { box-sizing: border-box; font-family: 'Montserrat', sans-serif; margin: 0; padding: 0; }
        body { background-color: #111111; color: #ffffff; }
        
        /* HEADER ORIGINAL */
        .navbar { background-color: #111111; padding: 20px 40px; border-bottom: 1px solid #222; display: flex; justify-content: space-between; align-items: center; }
        .logo { text-decoration: none !important; font-size: 26px; font-weight: 900; color: #ffffff; letter-spacing: -0.5px; }
        .logo span { color: #ed1c24; font-style: italic; }
        .nav-icons a { color: #888; text-decoration: none; margin-left: 20px; font-size: 18px; transition: color 0.3s; }
        .nav-icons a:hover { color: #fff; }

        /* CONTAINER PRINCIPAL */
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .title-page { text-align: center; font-size: 24px; font-weight: 900; margin-bottom: 40px; text-transform: uppercase; letter-spacing: 1px; }
        
        /* GRID DE CHECKOUT */
        .checkout-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 30px; align-items: start; }
        .box { background-color: #1a1a1a; padding: 30px; border-radius: 6px; border: 1px solid #222; }
        
        h3 { font-size: 13px; font-weight: 700; margin-bottom: 20px; text-transform: uppercase; color: #fff; }
        
        /* INPUTS */
        .auth-row { display: flex; gap: 15px; margin-bottom: 15px; }
        .auth-input { width: 100%; padding: 14px; margin-bottom: 15px; background-color: #222222; border: 1px solid #333333; border-radius: 4px; color: #ffffff; font-size: 14px; outline: none; transition: border-color 0.3s; }
        .auth-input::placeholder { color: #777; }
        .auth-input:focus { border-color: #ed1c24; }

        /* BOTÕES DE PAGAMENTO */
        .payment-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px; }
        .payment-label { background-color: #222222; border: 1px solid #333333; padding: 20px 10px; text-align: center; border-radius: 4px; cursor: pointer; color: #aaa; font-size: 13px; font-weight: 600; display: flex; flex-direction: column; align-items: center; gap: 10px; transition: all 0.3s; }
        .payment-label input[type="radio"] { display: none; }
        .payment-label:has(input[type="radio"]:checked) { border-color: #ed1c24; color: #ffffff; }

        .icon-svg { width: 24px; height: 24px; fill: currentColor; }

        /* BOTÃO CONFIRMAR */
        .auth-btn { width: 100%; padding: 16px; background-color: #ed1c24; color: #ffffff; border: none; border-radius: 4px; font-size: 14px; font-weight: 800; cursor: pointer; text-transform: uppercase; transition: background-color 0.3s; }
        .auth-btn:hover { background-color: #d11820; }

        /* REESTRUTURAÇÃO DO RESUMO DA COMPRA (IGUAL AO ESTILO DO CARRINHO) */
        .box-summary h3 { font-size: 22px; font-weight: 900; letter-spacing: 0.5px; margin-bottom: 25px; }
        
        .checkout-item { display: flex; gap: 15px; align-items: center; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #282828; }
        .checkout-item img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #333; }
        .checkout-item-details { flex: 1; }
        .checkout-item-details h4 { margin: 0 0 5px 0; font-size: 14px; font-weight: 600; color: #fff; }
        .checkout-item-details p { margin: 0; font-size: 12px; color: #888; }
        .checkout-item-price { font-weight: 700; font-size: 14px; color: #fff; }
        
        .summary-line { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 16px; color: #cccccc; }
        .summary-line span:last-child { font-weight: 700; color: #ffffff; }
        
        /* Cor verde do frete grátis igual ao carrinho original */
        .frete-destaque { color: #28a745 !important; font-weight: 700; }
        
        .dashed-line { border: 0; border-top: 1px dashed #444; margin: 20px 0; }
        
        .summary-total { display: flex; justify-content: space-between; font-weight: 900; font-size: 22px; color: #ffffff; text-transform: uppercase; }

        @media (max-width: 768px) { .checkout-grid { grid-template-columns: 1fr; } }
        .product-card.esgotado {
    opacity: .8;
}

.product-card.esgotado .product-image img{
    filter: grayscale(40%) brightness(.75);
}

.badge-esgotado{
    position:absolute;
    top:15px;
    left:15px;
    background:#e31e24;
    color:#fff;
    padding:8px 15px;
    font-size:12px;
    font-weight:800;
    border-radius:5px;
    z-index:5;
    letter-spacing:1px;
}

.btn-esgotado{
    width:100%;
    padding:14px;
    border:none;
    border-radius:8px;
    background:#777;
    color:#fff;
    font-weight:bold;
    cursor:not-allowed;
    text-transform:uppercase;
}
    </style>
</head>
<body>
    <header class="navbar">
        <a href="index.php" class="logo">DWD<span>STREET</span></a>
        <div class="nav-icons"></div>
    </header>

    <main class="container">
        <h2 class="title-page">FINALIZAR PEDIDO</h2>
        
        <div class="checkout-grid">
            <div class="box">
                <form action="finalizar_pedido.php" method="POST">
                    
                    <h3>1. Endereço de Entrega</h3>
                    <div class="auth-row">
                        <input type="text" name="cep" id="cep" placeholder="CEP" class="auth-input" style="flex: 2;" required maxlength="9">
                        <input type="text" name="numero" placeholder="Número" class="auth-input" style="flex: 1;" required>
                    </div>
                    <input type="text" name="endereco" id="endereco" placeholder="Rua, Avenida..." class="auth-input" required>
                    <input type="text" name="bairro" id="bairro" placeholder="Bairro" class="auth-input" required>
                    
                    <br><br>
                    
                    <h3>2. Forma de Pagamento</h3>
                    <div class="payment-methods">
                        <label class="payment-label">
                            <input type="radio" name="forma_pagamento" value="Cartão de Crédito">
                            <svg class="icon-svg" viewBox="0 0 24 24"><path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/></svg>
                            <span>Cartão</span>
                        </label>
                        
                        <label class="payment-label">
                            <input type="radio" name="forma_pagamento" value="Pix" checked>
                            <svg class="icon-svg" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                            <span>Pix</span>
                        </label>
                    </div>

                    <div id="card-fields" style="display: none;">
                        <input type="text" placeholder="Número do Cartão" class="auth-input">
                        <input type="text" placeholder="Nome impresso no cartão" class="auth-input">
                        <div class="auth-row">
                            <input type="text" placeholder="Validade (MM/AA)" class="auth-input" style="flex: 1;">
                            <input type="text" placeholder="CVV" class="auth-input" style="flex: 1;">
                        </div>
                    </div>
                    
                    <input type="hidden" name="frete" id="input_frete" value="0">
                    
                    <button type="submit" class="auth-btn">CONFIRMAR E PAGAR</button>
                </form>
            </div>
            
            <div class="box box-summary" style="position: sticky; top: 20px;">
                <h3>RESUMO DA COMPRA</h3>
                
                <?php
                if($resultado->num_rows > 0):
                    while($produto = $resultado->fetch_assoc()):
                        $subtotal_item = $produto["preco"] * $produto["quantidade"];
                        $subtotal_carrinho += $subtotal_item;
                ?>
                <div class="checkout-item">
                    <img src="<?php echo htmlspecialchars($produto["imagem"]); ?>" alt="Produto">
                    <div class="checkout-item-details">
                        <h4><?php echo htmlspecialchars($produto["produto_nome"]); ?></h4>
                        <p>Qtd: <?php echo htmlspecialchars($produto["quantidade"]); ?></p>
                    </div>
                    <span class="checkout-item-price">
                        R$ <?php echo number_format($subtotal_item, 2, ",", "."); ?>
                    </span>
                </div>
                <?php 
                    endwhile;
                else: 
                ?>
                    <p style="color: #888; font-size: 16px; margin-bottom: 20px;">Seu carrinho está vazio.</p>
                <?php endif; ?>
                
                <div class="summary-line" style="margin-top: 20px;">
                    <span>Subtotal</span>
                    <span>R$ <?php echo number_format($subtotal_carrinho, 2, ",", "."); ?></span>
                </div>
                <div class="summary-line">
                    <span>Frete</span> 
                    <span id="display-frete" class="frete-destaque">GRÁTIS</span>
                </div>
                
                <div class="dashed-line"></div>
                
                <div class="summary-total">
                    <span>TOTAL</span>
                    <span id="display-total">R$ <?php echo number_format($subtotal_carrinho, 2, ",", "."); ?></span>
                </div>
            </div>
        </div>
    </main>

    <script>
        const tabelaFrete = {
            'SC': 15.00, 'PR': 18.00, 'RS': 18.00, 
            'SP': 22.00, 'RJ': 25.00, 'MG': 25.00, 'ES': 28.00, 
            'DF': 35.00, 'GO': 35.00, 'MT': 40.00, 'MS': 40.00, 
            'BA': 45.00, 'SE': 45.00, 'AL': 48.00, 'PE': 48.00, 'PB': 50.00, 'RN': 50.00, 'CE': 50.00, 'PI': 55.00, 'MA': 55.00, 
            'TO': 58.00, 'PA': 60.00, 'AP': 65.00, 'RO': 65.00, 'RR': 70.00, 'AC': 70.00, 'AM': 70.00 
        };

        const inputCep = document.getElementById('cep');
        const displayFrete = document.getElementById('display-frete');
        const displayTotal = document.getElementById('display-total');
        const inputFreteOculto = document.getElementById('input_frete');
        
        const subtotalBase = <?php echo $subtotal_carrinho; ?>;

        inputCep.addEventListener('blur', function() {
            let cepDigitado = this.value.replace(/\D/g, ''); 
            
            if (cepDigitado.length === 8) {
                displayFrete.innerText = "...";
                displayFrete.style.color = "#888"; 
                
                fetch(`https://viacep.com.br/ws/${cepDigitado}/json/`)
                .then(resposta => resposta.json())
                .then(dados => {
                    if (!dados.erro) {
                        document.getElementById('endereco').value = dados.logradouro;
                        document.getElementById('bairro').value = dados.bairro;
                        
                        let valorFrete = 40.00; 
                        
                        if (dados.localidade && dados.localidade.toUpperCase() === 'JOINVILLE') {
                            valorFrete = 10.00; 
                        } else if (tabelaFrete[dados.uf] !== undefined) {
                            valorFrete = tabelaFrete[dados.uf];
                        }
                        
                        let novoTotal = subtotalBase + valorFrete;

                        displayFrete.innerText = "R$ " + valorFrete.toFixed(2).replace('.', ',');
                        displayFrete.style.color = "#ffffff"; 
                        
                        displayTotal.innerText = "R$ " + novoTotal.toFixed(2).replace('.', ',');
                        
                        inputFreteOculto.value = valorFrete;
                    } else {
                        displayFrete.innerText = "CEP Inválido";
                        displayFrete.style.color = "#ed1c24";
                    }
                })
                .catch(erro => {
                    displayFrete.innerText = "Erro";
                });
            }
        });

        const paymentRadios = document.querySelectorAll('input[name="forma_pagamento"]');
        const cardFields = document.getElementById('card-fields');
        const cardInputs = cardFields.querySelectorAll('input');

        function gerenciarCamposCartao() {
            const metodoSelecionado = document.querySelector('input[name="forma_pagamento"]:checked').value;
            if (metodoSelecionado === 'Cartão de Crédito') {
                cardFields.style.display = 'block';
                cardInputs.forEach(input => input.required = true);
            } else {
                cardFields.style.display = 'none';
                cardInputs.forEach(input => {
                    input.required = false;
                    input.value = '';
                });
            }
        }
        gerenciarCamposCartao();
        paymentRadios.forEach(radio => radio.addEventListener('change', gerenciarCamposCartao));
    </script>
</body>
</html>