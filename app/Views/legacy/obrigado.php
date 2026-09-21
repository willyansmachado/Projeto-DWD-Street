<?php
session_start();
include("config/conexao.php");

if (!isset($_GET['pedido'])) {
    header("Location: index.php");
    exit();
}

$pedido_id = intval($_GET['pedido']);
$usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : 1; 

$sql = "SELECT * FROM pedidos WHERE id = ? AND usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $pedido_id, $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    die("Pedido não encontrado.");
}

$pedido = $resultado->fetch_assoc();

// Configurações do Pix
$sua_chave_pix = "dwdstreet2026@gmail.com"; 
$seu_numero_whatsapp = "5547933830748"; 

// Gera a URL do QR Code usando uma API gratuita baseada na sua chave Pix
$url_qr_code = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($sua_chave_pix);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido | DWD Street</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #1a1a1a; color: #f5f5f5; font-family: 'Montserrat', sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; padding: 20px; }
        .success-box { background-color: #242424; padding: 40px; border-radius: 12px; border: 1px solid #333; max-width: 500px; width: 100%; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        h1 { color: #28a745; font-weight: 900; margin-top: 0; }
        .total-price { font-size: 2rem; font-weight: 900; color: #ff3b30; margin: 10px 0; }
        .pix-container { background-color: #1a1a1a; border: 2px dashed #444; padding: 25px; border-radius: 8px; margin-top: 20px; }
        .qr-code-img { margin: 20px 0; border: 10px solid #fff; border-radius: 8px; }
        .btn { display: inline-block; width: 100%; padding: 15px; border: none; border-radius: 6px; font-weight: 800; cursor: pointer; text-decoration: none; box-sizing: border-box; margin-bottom: 10px; }
        .btn-copy { background-color: #f5f5f5; color: #121212; }
        .btn-simulate { background-color: #ffc107; color: #121212; margin-top: 15px; border: 2px dashed #000; }
        .btn-home { background-color: transparent; color: #ff3b30; border: 2px solid #ff3b30; }
        .status-pago { background-color: rgba(40, 167, 69, 0.1); border: 2px solid #28a745; padding: 30px; border-radius: 8px; margin-top: 20px; color: #28a745; }
    </style>
</head>
<body>

    <div class="success-box">
        <h1>PEDIDO #<?php echo str_pad($pedido['id'], 5, "0", STR_PAD_LEFT); ?></h1>
        
        <?php if ($pedido['status'] == 'Pagamento Aprovado'): ?>
            <div class="status-pago">
                <div style="font-size: 4rem; margin-bottom: 10px;">✅</div>
                <h2 style="margin: 0; font-weight: 900;">PAGAMENTO APROVADO!</h2>
                <p>Seu pagamento foi confirmado com sucesso. Estamos preparando seu pedido para envio.</p>
            </div>
            
        <?php else: ?>
            <p>Valor a ser pago:</p>
            <div class="total-price">R$ <?php echo number_format($pedido['total'], 2, ",", "."); ?></div>

            <?php if ($pedido['forma_pagamento'] == 'PIX'): ?>
                <div class="pix-container">
                    <h3 style="margin-top: 0;">ESCANEIE O QR CODE</h3>
                    <p style="color: #a0a0a0; font-size: 0.9rem;">Abra o app do seu banco e escaneie a imagem abaixo:</p>
                    
                    <img src="<?php echo $url_qr_code; ?>" alt="QR Code" class="qr-code-img">
                    
                    <button class="btn btn-copy" onclick="copiarPix()" id="chavePix" data-chave="<?php echo $sua_chave_pix; ?>">📋 COPIAR CHAVE (COPIA E COLA)</button>
                    
                    <a href="simular_pagamento.php?pedido=<?php echo $pedido['id']; ?>" class="btn btn-simulate">
                        🛠️ SIMULAR PAGAMENTO (MODO DEV)
                    </a>
                </div>
            <?php else: ?>
                <p>Aguardando pagamento via <?php echo htmlspecialchars($pedido['forma_pagamento']); ?>.</p>
            <?php endif; ?>
        <?php endif; ?>

        <div style="margin-top: 30px;">
            <a href="index.php" class="btn btn-home">VOLTAR PARA A LOJA</a>
        </div>
    </div>

    <script>
        function copiarPix() {
            var btn = document.getElementById("chavePix");
            var chave = btn.getAttribute("data-chave");
            navigator.clipboard.writeText(chave).then(function() {
                btn.innerText = "✅ CHAVE COPIADA!";
                btn.style.backgroundColor = "#28a745";
                btn.style.color = "#fff";
                setTimeout(function() {
                    btn.innerText = "📋 COPIAR CHAVE (COPIA E COLA)";
                    btn.style.backgroundColor = "#f5f5f5";
                    btn.style.color = "#121212";
                }, 3000);
            });
        }
    </script>
</body>
</html>