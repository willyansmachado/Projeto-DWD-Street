<?php use App\Core\View; require BASE_PATH . '/app/Views/layouts/header.php'; ?>
<main id="conteudo" class="page-shell"><section class="detail-card"><p class="eyebrow">Pedido #<?= (int) $order['id'] ?></p><h1>Status: <?= View::escape($order['status']) ?></h1><p>Realizado em <?= date('d/m/Y H:i', strtotime($order['criado_em'])) ?></p><p class="cart-total">Total: <strong>R$ <?= number_format((float) $order['total'], 2, ',', '.') ?></strong></p><a href="index.php?rota=pedidos">Voltar para pedidos</a></section></main>
<?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>
