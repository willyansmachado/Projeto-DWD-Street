<?php
session_start();

if(!isset($_SESSION["id"])){
    header("Location: login.php");
    exit();
}

include("config/conexao.php");

$usuario_id = $_SESSION["id"];

$sql = "SELECT * FROM carrinho WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$resultado = $stmt->get_result();

$total = 0;
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
            
            <div class="cart-items-list">

<?php
if($resultado->num_rows > 0){

    while($produto = $resultado->fetch_assoc()){

        $subtotal = $produto["preco"] * $produto["quantidade"];
        $total += $subtotal;
?>

<div class="cart-item">

    <img src="<?php echo $produto['imagem']; ?>" width="80">

    <div class="item-details">
        <h4><?php echo $produto['produto_nome']; ?></h4>

        <p>
            Quantidade:
            <?php echo $produto['quantidade']; ?>
        </p>

        <span class="item-price">
            R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
        </span>
    </div>

    <a href="remover_carrinho.php?id=<?php echo $produto['id']; ?>"
       class="remove-btn">
       🗑️
    </a>

</div>

<?php
    }
}else{
    echo "<p>Seu carrinho está vazio.</p>";
}
?>

</div>
            
            <div class="cart-summary-box">
                <h3>RESUMO</h3>
                <div class="summary-line"><span>Subtotal</span> <span>
R$ <?php echo number_format($total,2,",","."); ?>
</span></div>
                <div class="summary-line"><span>Frete</span> <span class="free">GRÁTIS</span></div>
                <div class="summary-total"><span>TOTAL</span> <span>
R$ <?php echo number_format($total,2,",","."); ?>
</span></div>
                <a href="pagamento.php" class="btn-banner">FINALIZAR COMPRA</a>
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
    </script>
</body>
</html>