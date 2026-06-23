<?php
// 1. Carrega as dependências do sistema
require_once BASE_PATH . '/vendor/autoload.php';

use App\Core\Database;
use App\Core\Tenant;

// Middlewares e Helpers de segurança
require_once BASE_PATH . '/app/Middleware/admin.php';
require_once BASE_PATH . '/app/Helpers/csrf.php';

$db = Database::getInstance();
$empresaId = Tenant::empresaId();

// 2. Comandos DML (SELECT) com isolamento de Loja (Tenant)
$stmtCat = $db->prepare("SELECT id, nome FROM categorias WHERE empresa_id = ? ORDER BY nome");
$stmtCat->execute([$empresaId]);
$categorias = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

$stmtMarca = $db->prepare("SELECT id, nome FROM marcas WHERE empresa_id = ? ORDER BY nome");
$stmtMarca->execute([$empresaId]);
$marcas = $stmtMarca->fetchAll(PDO::FETCH_ASSOC);

$titulo = "Novo Produto - Vendy Facil";

// O header já traz a estrutura do topo, menu lateral e o fundo correto
include __DIR__ . '/../includes/header.php';
?>

<div class="bg-white shadow-sm" style="border: 1px solid #e5e7eb; border-radius: 10px; padding: 50px;">
    
    <div class="mb-5 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1" style="color: #111111;">Novo Produto</h3>
            <p class="text-muted mb-0">Preencha os dados abaixo para cadastrar um novo item na loja.</p>
        </div>
        
        <a href="<?= URL_BASE ?>/produtos" class="btn btn-outline-secondary shadow-sm fw-bold px-4 py-2">
            <i class="bi bi-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <form action="<?= defined('URL_BASE') ? URL_BASE : '/Vendy-Facil/public' ?>/produtos/store" method="POST">
        
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

        <div class="row mb-4 g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold" style="color: #111111;">Nome do Produto</label>
                <input type="text" name="nome" class="form-control py-2" placeholder="Ex: Smartphone Samsung Galaxy S23" required style="border-color: #e5e7eb; box-shadow: none;">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold" style="color: #111111;">Código (SKU)</label>
                <input type="text" name="sku" class="form-control py-2" placeholder="Ex: SM-S23-128" style="border-color: #e5e7eb; box-shadow: none;">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold" style="color: #111111;">Peso (kg)</label>
                <input type="number" step="0.001" name="peso" class="form-control py-2" placeholder="Ex: 0.500" style="border-color: #e5e7eb; box-shadow: none;">
            </div>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold" style="color: #111111;">Categoria</label>
                <select name="categoria_id" class="form-select py-2" required style="border-color: #e5e7eb; box-shadow: none;">
                    <option value="">Selecione...</option>
                    <?php foreach($categorias as $categoria): ?>
                        <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold" style="color: #111111;">Marca</label>
                <select name="marca_id" class="form-select py-2" style="border-color: #e5e7eb; box-shadow: none;">
                    <option value="">Nenhuma / Sem Marca</option>
                    <?php foreach($marcas as $marca): ?>
                        <option value="<?= $marca['id'] ?>"><?= htmlspecialchars($marca['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold" style="color: #111111;">Preço Original (R$)</label>
                <input type="number" step="0.01" name="preco" class="form-control py-2" placeholder="0,00" required style="border-color: #e5e7eb; box-shadow: none;">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold" style="color: #111111;">Preço Promocional (R$)</label>
                <input type="number" step="0.01" name="preco_promocional" class="form-control py-2" placeholder="0,00" style="border-color: #e5e7eb; box-shadow: none;">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold" style="color: #111111;">Descrição Detalhada</label>
            <textarea name="descricao" class="form-control" rows="6" placeholder="Descreva os detalhes, especificações e diferenciais do seu produto..." style="border-color: #e5e7eb; box-shadow: none;"></textarea>
        </div>

        <div class="d-flex justify-content-end mt-5">
            <button type="submit" class="btn btn-verde-ky py-2 px-5 fw-bold shadow-sm" style="font-size: 1.1rem;">
                <i class="bi bi-check-lg me-2"></i> Salvar Produto
            </button>
        </div>

    </form>
</div>

<style>
    /* Estilização focada na paleta da Vendy Facil */
    .btn-verde-ky {
        background-color: #28a745;
        color: #ffffff;
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-verde-ky:hover {
        background-color: #218838;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3) !important;
    }
</style>

<?php include __DIR__ . '/../includes/footer.php'; ?>