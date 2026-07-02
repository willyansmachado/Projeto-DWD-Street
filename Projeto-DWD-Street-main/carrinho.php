<?php
session_start();

if(!isset($_SESSION["id"])){
    header("Location: login.php");
    exit();
}

include("config/conexao.php");

$usuario_id = $_SESSION["id"];

// ==========================================
// LÓGICA DE CUPOM DE DESCONTO
// ==========================================
if (isset($_POST['aplicar_cupom'])) {
    $codigo_cupom = $_POST['codigo_cupom'];
    
    $sqlCupom = "SELECT * FROM cupons WHERE codigo = ?";
    $stmtC = $conn->prepare($sqlCupom);
    $stmtC->bind_param("s", $codigo_cupom);
    $stmtC->execute();
    $resCupom = $stmtC->get_result();

    if ($resCupom->num_rows > 0) {
        $cupom = $resCupom->fetch_assoc();
        $_SESSION['cupom_ativo'] = $cupom['codigo'];
        $_SESSION['cupom_valor'] = $cupom['valor_desconto'];
        $_SESSION['cupom_tipo'] = $cupom['tipo']; // 'porcentagem' ou 'fixo'
        $msg_cupom = "Cupom aplicado com sucesso!";
    } else {
        $erro_cupom = "Cupom inválido ou expirado.";
        unset($_SESSION['cupom_ativo'], $_SESSION['cupom_valor'], $_SESSION['cupom_tipo']);
    }
}

if (isset($_GET['remover_cupom'])) {
    unset($_SESSION['cupom_ativo'], $_SESSION['cupom_valor'], $_SESSION['cupom_tipo']);
    header("Location: carrinho.php");
    exit();
}

// ==========================================
// LÓGICA DE FRETE (Cálculo Dinâmico por Peso/Região e Frete Grátis)
// ==========================================
if (isset($_POST['calcular_frete'])) {
    $cep = preg_replace('/[^0-9]/', '', $_POST['cep_destino']);
    
    if (strlen($cep) == 8) {
        $url_viacep = "https://viacep.com.br/ws/{$cep}/json/";
        $resposta_api = @file_get_contents($url_viacep);
        
        if ($resposta_api) {
            $dados_endereco = json_decode($resposta_api, true);
            
            if (isset($dados_endereco['erro'])) {
                $erro_frete = "CEP não encontrado.";
                unset($_SESSION['frete_valor'], $_SESSION['cep_calculado'], $_SESSION['cidade_frete']);
            } else {
                $_SESSION['cidade_frete'] = $dados_endereco['localidade'] . ' - ' . $dados_endereco['uf'];
                $_SESSION['cep_calculado'] = $cep;
                
                // --- REGRA DE OURO: FRETE GRÁTIS ACIMA DE R$ 299,90 ---
                // Nota: O PHP vai olhar a variável $total que já soma o valor dos produtos no carrinho
                if ($total >= 299.90) {
                    $_SESSION['frete_valor'] = 0.00; // Frete Grátis!
                } else {
                    // Se a compra for menor que 299,90, roda o cálculo normal por peso e estado:
                    
                    // 1. Busca e soma o peso dos itens no banco
                    $sql_peso = "SELECT SUM(peso * quantidade) AS peso_total FROM carrinho WHERE usuario_id = ?";
                    $stmt_peso = $conn->prepare($sql_peso);
                    $stmt_peso->bind_param("i", $usuario_id);
                    $stmt_peso->execute();
                    $res_peso = $stmt_peso->get_result();
                    $row_peso = $res_peso->fetch_assoc();
                    
                    $peso_carrinho = $row_peso['peso_total'] > 0 ? $row_peso['peso_total'] : 0.3;
                    
                    // 2. Regra de preços por Estado (UF)
                    $uf = $dados_endereco['uf'];
                    $valor_base = 0;
                    $valor_por_kg = 0;
                    
                    if ($uf == 'SC') {
                        $valor_base = 10.00;
                        $valor_por_kg = 2.00;
                    } elseif (in_array($uf, ['PR', 'RS', 'SP', 'RJ', 'MG'])) { 
                        $valor_base = 18.00;
                        $valor_por_kg = 5.00;
                    } else { 
                        $valor_base = 28.00;
                        $valor_por_kg = 10.00;
                    }
                    
                    // 3. Conta final do frete cobrado
                    $_SESSION['frete_valor'] = $valor_base + ($peso_carrinho * $valor_por_kg);
                }
            }
        } else {
            $erro_frete = "Erro ao conectar com a API de CEP.";
        }
    } else {
        $erro_frete = "CEP inválido. Digite 8 números.";
        unset($_SESSION['frete_valor'], $_SESSION['cep_calculado'], $_SESSION['cidade_frete']);
    }
}

// ==========================================
// BUSCA PRODUTOS NO CARRINHO
// ==========================================
$sql = "SELECT * FROM carrinho WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();

// SE O CARRINHO ESTIVER VAZIO, LIMPA OS DADOS DE FRETE E CUPOM DO SITE
if ($resultado->num_rows == 0) {
    unset($_SESSION['frete_valor'], $_SESSION['cep_calculado'], $_SESSION['cidade_frete']);
    unset($_SESSION['cupom_ativo'], $_SESSION['cupom_valor'], $_SESSION['cupom_tipo']);
}

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
    <style>
        :root {
            --bg-dark: #121212;
            --bg-card: #1c1c1c;
            --text-light: #ffffff;
            --text-muted: #888888;
            --dwd-red: #e62429;
            --dwd-red-hover: #c41e22;
            --border-color: #2a2a2a;
        }

        body.dark-mode {
            background-color: var(--bg-dark);
            color: var(--text-light);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            font-family: 'Montserrat', sans-serif;
        }

        .logo { font-size: 24px; font-weight: 900; text-decoration: none; color: var(--text-light); display: inline-block; margin-bottom: 30px; }
        .logo span { color: var(--dwd-red); }

        .title-page { font-size: 2rem; font-weight: 900; text-transform: uppercase; margin-bottom: 30px; letter-spacing: 1px; }

        .cart-grid { display: grid; grid-template-columns: 2fr 1.2fr; gap: 40px; align-items: start; }

        /* Estilos dos Itens */
        .cart-item { display: flex; align-items: center; justify-content: space-between; background-color: var(--bg-card); padding: 20px; border-radius: 8px; margin-bottom: 15px; border: 1px solid var(--border-color); transition: 0.3s; }
        .cart-item:hover { border-color: #444; }
        .cart-item img { border-radius: 6px; object-fit: cover; width: 90px; height: 90px; background-color: #222; }

        .item-details { flex-grow: 1; margin-left: 20px; }
        .item-details h4 { margin: 0 0 8px 0; font-size: 1.1rem; font-weight: 700; text-transform: uppercase; }
        .item-details p { margin: 0; color: var(--text-muted); font-size: 0.9rem; }

        .item-actions { display: flex; flex-direction: column; align-items: flex-end; gap: 15px; }
        .item-price { font-weight: 700; font-size: 1.2rem; }
        .remove-btn { color: var(--text-muted); text-decoration: none; font-size: 0.9rem; display: flex; align-items: center; gap: 5px; transition: 0.2s; }
        .remove-btn:hover { color: var(--dwd-red); }

        /* Estilos do Resumo, Frete e Cupom */
        .cart-summary-box { background-color: var(--bg-card); padding: 30px; border-radius: 8px; border: 1px solid var(--border-color); }
        .cart-summary-box h3 { margin-top: 0; margin-bottom: 25px; font-weight: 900; font-size: 1.2rem; border-bottom: 1px solid var(--border-color); padding-bottom: 15px; }

        .mb-15 { margin-bottom: 15px; }
        .input-group { display: flex; gap: 10px; margin-top: 5px; }
        .input-group input { flex: 1; padding: 12px; border: 1px solid var(--border-color); background: #111; color: var(--text-light); border-radius: 4px; font-family: inherit; }
        .input-group input:focus { outline: 1px solid var(--text-muted); }
        .input-group button { padding: 10px 20px; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: 700; transition: 0.3s; }
        .input-group button:hover { background: #555; }
        
        .btn-remove-cupom { padding: 10px 15px; background: var(--dwd-red); color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: 700; text-decoration: none; display: flex; align-items: center; justify-content: center;}
        
        .text-success { color: #4caf50; font-size: 0.85rem; margin-top: 5px; display: block; font-weight: bold; }
        .text-danger { color: var(--dwd-red); font-size: 0.85rem; margin-top: 5px; display: block; font-weight: bold; }
        .summary-divider { border-top: 1px solid var(--border-color); margin: 25px 0; }

        .summary-line { display: flex; justify-content: space-between; margin-bottom: 15px; color: var(--text-muted); font-weight: 500; }
        .summary-line .free { color: #4caf50; font-weight: 700; }
        .summary-total { display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 1px dotted var(--border-color); font-size: 1.3rem; font-weight: 900; }

        .btn-banner { display: block; width: 100%; text-align: center; background-color: var(--dwd-red); color: #fff; padding: 16px; text-decoration: none; font-weight: 700; border-radius: 4px; margin-top: 30px; text-transform: uppercase; transition: 0.3s; border: none; cursor: pointer; }
        .btn-banner:hover { background-color: var(--dwd-red-hover); }

        /* Estilos do Carrinho Vazio */
        .empty-cart { background-color: var(--bg-card); padding: 50px 20px; text-align: center; border-radius: 8px; border: 1px solid var(--border-color); }
        .empty-cart p { color: var(--text-muted); font-size: 1.1rem; margin-bottom: 20px; }
        .btn-outline { display: inline-block; padding: 12px 25px; border: 2px solid var(--dwd-red); color: var(--dwd-red); text-decoration: none; font-weight: 700; border-radius: 4px; transition: 0.3s; text-transform: uppercase; }
        .btn-outline:hover { background-color: var(--dwd-red); color: #fff; }

        /* Toggle Dark/Light */
        .theme-toggle { position: fixed; bottom: 20px; right: 20px; background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-light); border-radius: 50%; width: 50px; height: 50px; font-size: 1.5rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: 0.3s; }

        @media (max-width: 768px) {
            .cart-grid { grid-template-columns: 1fr; }
            .cart-item { flex-direction: column; text-align: center; }
            .item-details { margin-left: 0; margin-top: 15px; margin-bottom: 15px; }
            .item-actions { align-items: center; }
        }
    </style>
</head>
<body class="dark-mode">
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
                    <img src="<?php echo $produto['imagem']; ?>" alt="<?php echo $produto['produto_nome']; ?>">

                    <div class="item-details">
                        <h4><?php echo $produto['produto_nome']; ?></h4>
                        <p>Quantidade: <?php echo $produto['quantidade']; ?></p>
                    </div>

                    <div class="item-actions">
                        <span class="item-price">
                            R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                        </span>
                        <a href="remover_carrinho.php?id=<?php echo $produto['id']; ?>" class="remove-btn">
                            ✕ Remover
                        </a>
                    </div>
                </div>

                <?php
                    }
                } else {
                ?>
                    <div class="empty-cart">
                        <p>Seu carrinho está vazio no momento.</p>
                        <a href="index.php" class="btn-outline">Continuar Comprando</a>
                    </div>
                <?php
                }
                ?>
            </div>
            
            <div class="cart-summary-box">
                <h3>RESUMO DO PEDIDO</h3>

                <?php if($resultado->num_rows > 0): ?>
                    <form action="carrinho.php" method="POST" class="mb-15">
                        <label style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Calcular Frete</label>
                        <div class="input-group">
                            <input type="text" name="cep_destino" placeholder="00000-000" value="<?php echo $_SESSION['cep_calculado'] ?? ''; ?>" required maxlength="9">
                            <button type="submit" name="calcular_frete">OK</button>
                        </div>
                        <?php if(isset($erro_frete)) echo "<span class='text-danger'>$erro_frete</span>"; ?>
                    </form>

                    <form action="carrinho.php" method="POST" class="mb-15">
                        <label style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Cupom de Desconto</label>
                        <div class="input-group">
                            <input type="text" name="codigo_cupom" placeholder="Insira seu código" value="<?php echo $_SESSION['cupom_ativo'] ?? ''; ?>" <?php echo isset($_SESSION['cupom_ativo']) ? 'readonly' : ''; ?> required>
                            
                            <?php if(!isset($_SESSION['cupom_ativo'])): ?>
                                <button type="submit" name="aplicar_cupom">APLICAR</button>
                            <?php else: ?>
                                <a href="?remover_cupom=1" class="btn-remove-cupom" title="Remover Cupom">✕</a>
                            <?php endif; ?>
                        </div>
                        <?php
                        if(isset($erro_cupom)) echo "<span class='text-danger'>$erro_cupom</span>";
                        if(isset($msg_cupom)) echo "<span class='text-success'>$msg_cupom</span>";
                        ?>
                    </form>

                    <div class="summary-divider"></div>
                <?php endif; ?>

                <?php
                // CÁLCULOS FINAIS
                $frete = $_SESSION['frete_valor'] ?? 0;
                $desconto = 0;

                if (isset($_SESSION['cupom_ativo']) && $total > 0) {
                    if ($_SESSION['cupom_tipo'] == 'porcentagem') {
                        $desconto = ($total * $_SESSION['cupom_valor']) / 100;
                    } else {
                        $desconto = $_SESSION['cupom_valor'];
                    }
                }

                $total_final = $total + $frete - $desconto;
                if($total_final < 0) $total_final = 0;
                ?>

                <div class="summary-line">
                    <span>Subtotal</span> 
                    <span>R$ <?php echo number_format($total, 2, ",", "."); ?></span>
                </div>

                <?php if($desconto > 0): ?>
                <div class="summary-line">
                    <span>Desconto (<?php echo $_SESSION['cupom_ativo']; ?>)</span> 
                    <span style="color: var(--dwd-red);">- R$ <?php echo number_format($desconto, 2, ",", "."); ?></span>
                </div>
                <?php endif; ?>

                <div class="summary-line">
                <span>Frete <?php echo isset($_SESSION['cidade_frete']) ? '('.$_SESSION['cidade_frete'].')' : ''; ?></span>
                    <?php if($frete > 0): ?>
                        <span>R$ <?php echo number_format($frete, 2, ",", "."); ?></span>
                    <?php else: ?>
                        <span class="free">GRÁTIS</span>
                    <?php endif; ?>
                </div>

                <div class="summary-total">
                    <span>TOTAL</span> 
                    <span>R$ <?php echo number_format($total_final, 2, ",", "."); ?></span>
                </div>
                
                <?php if($resultado->num_rows > 0): ?>
    <a href="pagamento.php" class="btn-banner">FINALIZAR COMPRA</a>
<?php else: ?>
    <button class="btn-banner" style="background-color: #555; cursor: not-allowed;" disabled>FINALIZAR COMPRA</button>
<?php endif; ?>
            </div>
            
        </div>
    </main>

    <button id="theme-toggle" class="theme-toggle">☀️</button>

    <script>
        // MODO ESCURO E CLARO
        const themeToggleBtn = document.getElementById('theme-toggle');
        const body = document.body;

        if (localStorage.getItem('theme') === 'light') {
            body.classList.remove('dark-mode');
            themeToggleBtn.textContent = '🌙';
        }

        if (themeToggleBtn) {
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