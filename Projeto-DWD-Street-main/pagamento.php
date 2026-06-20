<?php
session_start();

include("config/conexao.php");

$usuario_id = $_SESSION["id"];

$sql = "SELECT * FROM carrinho WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$resultado = $stmt->get_result();

$total = 0;

if(!isset($_SESSION["id"])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento | DWD Street</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
        <a href="index.php" class="logo">DWD<span>STREET</span></a>
        <div class="nav-icons">
            <a href="login.php" class="icon-btn">👤</a>
            <a href="carrinho.php" class="icon-btn">🛒</a>
        </div>
    </header>

    <main class="container">
        <h2 class="title-page">FINALIZAR PAGAMENTO</h2>
        
        <div class="checkout-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; padding: 20px 0;">
            
            <div class="checkout-form-box">
                <form action="finalizar_pedido.php" method="POST">
                    
                    <h3>1. Dados de Entrega</h3>
                    <div class="auth-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
    <input type="text" name="cep" placeholder="CEP" class="auth-input" style="flex: 1;" required>

    <input type="text" name="numero" placeholder="Número" class="auth-input" style="width: 80px;" required>
</div>

<input type="text" name="endereco" placeholder="Endereço de Entrega" class="auth-input" required>

<input type="text" name="bairro" placeholder="Bairro" class="auth-input" required>
                    <br>
                    <h3>2. Forma de Pagamento</h3>
                    
                    <div class="payment-methods" style="display: flex; gap: 10px; margin-bottom: 20px;">
                        <label style="flex: 1; border: 1px solid #eee; padding: 15px; text-align: center; border-radius: 8px; cursor: pointer;">
                            <input type="radio" name="payment" value="card" checked style="margin-bottom: 8px;">
                            <div>💳 Cartão</div>
                        </label>
                        <label style="flex: 1; border: 1px solid #eee; padding: 15px; text-align: center; border-radius: 8px; cursor: pointer;">
                            <input type="radio" name="payment" value="pix" style="margin-bottom: 8px;">
                            <div>📱 Pix</div>
                        </label>
                        <label style="flex: 1; border: 1px solid #eee; padding: 15px; text-align: center; border-radius: 8px; cursor: pointer;">
                            <input type="radio" name="payment" value="boleto" style="margin-bottom: 8px;">
                            <div>📄 Boleto</div>
                        </label>
                    </div>

                    <div id="card-fields">
                        <input type="text" placeholder="Número do Cartão" class="auth-input">
                        <input type="text" placeholder="Nome impresso no cartão" class="auth-input">
                        <div class="auth-row" style="display: flex; gap: 10px;">
                            <input type="text" placeholder="Validade (MM/AA)" class="auth-input" style="flex: 1;">
                            <input type="text" placeholder="CVV" class="auth-input" style="flex: 1;">
                        </div>
                    </div>
                    
                    <button type="submit" class="auth-btn" style="width: 100%; margin-top: 20px; background-color: #28a745;">CONCLUIR PEDIDO</button>
                </form>
            </div>
            
            <div class="cart-summary-box" style="border: 1px solid #eee; padding: 25px; border-radius: 8px; height: fit-content;">
                <h3>REVISAR PEDIDO</h3>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
                
                <?php
while($produto = $resultado->fetch_assoc()){

    $subtotal = $produto["preco"] * $produto["quantidade"];
    $total += $subtotal;
?>
<div class="checkout-item" style="display:flex;gap:15px;align-items:center;margin-bottom:15px;">

    <img src="<?php echo $produto["imagem"]; ?>"
         style="width:60px;height:60px;object-fit:cover;">

    <div style="flex:1;">
        <h4><?php echo $produto["produto_nome"]; ?></h4>

        <p>
            Qtd:
            <?php echo $produto["quantidade"]; ?>
        </p>
    </div>

    <span>
        R$ <?php echo number_format($subtotal,2,",","."); ?>
    </span>

</div>
<?php
}
?>
                
                <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
                
                <div class="summary-line" style="display: flex; justify-content: space-between; margin-bottom: 10px;"><span>
R$ <?php echo number_format($total,2,",","."); ?>
</span></div>
                <div class="summary-line" style="display: flex; justify-content: space-between; margin-bottom: 10px;"><span>Frete</span> <span style="color: #28a745; font-weight: bold;">GRÁTIS</span></div>
                <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
                <div class="summary-total" style="display: flex; justify-content: space-between; font-weight: 900; font-size: 1.2rem;"><span>
R$ <?php echo number_format($total,2,",","."); ?>
</span></div>
            </div>

        </div>
    </main>

    <button id="theme-toggle" class="theme-toggle">🌙</button>

    <script>
        // 1. MODO ESCURO - VERIFICAÇÃO IMEDIATA
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }

        const themeToggleBtn = document.getElementById('theme-toggle');
        if (themeToggleBtn && document.body.classList.contains('dark-mode')) {
            themeToggleBtn.textContent = '☀️'; 
        }

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                document.body.classList.toggle('dark-mode');
                if (document.body.classList.contains('dark-mode')) {
                    localStorage.setItem('theme', 'dark');
                    themeToggleBtn.textContent = '☀️';
                } else {
                    localStorage.setItem('theme', 'light');
                    themeToggleBtn.textContent = '🌙';
                }
            });
        }

        // 2. ALTERNÂNCIA DE CAMPOS DO CARTÃO + VALIDAÇÃO DINÂMICA
        const paymentRadios = document.querySelectorAll('input[name="payment"]');
        const cardFields = document.getElementById('card-fields');
        
        // Captura todos os inputs que estão dentro da caixinha do cartão
        const cardInputs = cardFields.querySelectorAll('input');

        function gerenciarCamposCartao() {
            // Descobre qual rádio está selecionado no momento
            const metodoSelecionado = document.querySelector('input[name="payment"]:checked').value;

            if (metodoSelecionado === 'card') {
                cardFields.style.display = 'block';
                // Se for cartão, todos os campos dele passam a ser obrigatórios
                cardInputs.forEach(input => input.required = true);
            } else {
                cardFields.style.display = 'none';
                // Se for Pix ou Boleto, remove a obrigação para o formulário poder ser enviado
                cardInputs.forEach(input => {
                    input.required = false;
                    input.value = ''; // Limpa o que o usuário digitou por engano
                });
            }
        }

        // Roda a função assim que a página carregar (para alinhar com o rádio padrão "card")
        gerenciarCamposCartao();

        // Escuta as mudanças de opção que o usuário fizer
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', gerenciarCamposCartao);
        });
    </script>
    
</body>
</html>