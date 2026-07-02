<?php
session_start();

include("../../config/conexao.php");
include("../includes/verificar_login.php");

$pesquisa = "";

if(isset($_GET["pesquisa"])){
    $pesquisa = trim($_GET["pesquisa"]);
}

$sql = "SELECT
    p.*,
    c.nome AS categoria
FROM produtos p
INNER JOIN categorias c
ON c.id = p.categoria_id";

if($pesquisa != ""){
    $pesquisaBanco = mysqli_real_escape_string($conn, $pesquisa);
    $sql .= " WHERE p.nome LIKE '%$pesquisaBanco%'";
}

$sql .= " ORDER BY p.id DESC";

$resultado = mysqli_query($conn,$sql);

$totalProdutos = mysqli_num_rows($resultado);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Produtos</title>

<link rel="stylesheet" href="../css/admin.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

.topo-lista{

display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
flex-wrap:wrap;
gap:15px;

}

.topo-lista h1{

color:#fff;
font-size:30px;

}

.info-produtos{

color:#999;
margin-top:5px;

}

.acoes{

display:flex;
gap:10px;

}

.form-pesquisa{

display:flex;
gap:10px;

}

.form-pesquisa input{

width:260px;
padding:12px;
border-radius:8px;
border:none;
background:#202020;
color:#fff;

}

.form-pesquisa button{

background:#d90429;
border:none;
color:#fff;
padding:12px 18px;
border-radius:8px;
cursor:pointer;

}

.table-produtos{

width:100%;
border-collapse:collapse;
overflow:hidden;
border-radius:12px;
background:#1b1b1b;

}

.table-produtos th{

background:#181818;
color:#fff;
padding:16px;

}

.table-produtos td{

padding:15px;
border-bottom:1px solid #2d2d2d;
color:#ddd;
vertical-align:middle;

}

.table-produtos tr:hover{

background:#222;

}

.foto{

width:60px;
height:60px;
border-radius:8px;
object-fit:cover;
background:#2a2a2a;

}

.badge{

padding:6px 12px;
border-radius:30px;
font-size:13px;
font-weight:bold;

}

.ativo{

background:#0f7b37;
color:#fff;

}

.inativo{

background:#7b1d1d;
color:#fff;

}

.estoque-ok{

color:#27d160;
font-weight:bold;

}

.estoque-baixo{

color:#ffb000;
font-weight:bold;

}

.sem-estoque{

color:#ff4040;
font-weight:bold;

}

.btn-acao{

padding:8px 12px;
border-radius:6px;
text-decoration:none;
font-size:14px;
color:#fff;
margin-right:5px;

}

.editar{

background:#0b84ff;

}

.excluir{

background:#d90429;

}

</style>

</head>

<body>

<div class="container">

<?php include("../includes/menu.php"); ?>

<div class="main">

<?php include("../includes/topbar.php"); ?>

<div class="conteudo">

<div class="topo-lista">

<div>

<h1>Produtos</h1>

<p class="info-produtos">

<?= $totalProdutos ?> produto(s) encontrado(s)

</p>

</div>

<div class="acoes">

<form class="form-pesquisa" method="GET">

<input
type="text"
name="pesquisa"
placeholder="Pesquisar produto..."
value="<?= htmlspecialchars($pesquisa) ?>">

<button>

<i class="fa-solid fa-magnifying-glass"></i>

</button>

</form>

<a href="criar.php" class="btn">

<i class="fa-solid fa-plus"></i>

Novo Produto

</a>

</div>

</div>

<table class="table-produtos">

<tr>

<th>Foto</th>
<th>Nome</th>
<th>Categoria</th>
<th>Estoque</th>
<th>Preço</th>
<th>Status</th>
<th width="170">Ações</th>

</tr>

<?php while($produto = mysqli_fetch_assoc($resultado)){ ?>

<?php

if(!empty($produto["imagem"])){

    $imagem = "../../" . $produto["imagem"];

}else{

    $imagem = "../img/sem-imagem.png";

}

if($produto["estoque"] <= 0){

    $classeEstoque = "sem-estoque";
    $textoEstoque = "Sem estoque";

}elseif($produto["estoque"] <= 5){

    $classeEstoque = "estoque-baixo";
    $textoEstoque = $produto["estoque"] . " un.";

}else{

    $classeEstoque = "estoque-ok";
    $textoEstoque = $produto["estoque"] . " un.";

}

?>

<tr>

<td>

<img
src="<?= $imagem ?>"
class="foto">

</td>

<td>

<strong><?= htmlspecialchars($produto["nome"]) ?></strong>

<?php if(!empty($produto["sku"])){ ?>

<br>

<small style="color:#888;">

SKU: <?= htmlspecialchars($produto["sku"]) ?>

</small>

<?php } ?>

</td>

<td>

<?= htmlspecialchars($produto["categoria"]) ?>

</td>

<td>

<span class="<?= $classeEstoque ?>">

<?= $textoEstoque ?>

</span>

</td>

<td>

<strong>

R$ <?= number_format($produto["preco"],2,",",".") ?>

</strong>

<?php if(!empty($produto["preco_promocional"])){ ?>

<br>

<small style="color:#27d160;">

Promo:

R$ <?= number_format($produto["preco_promocional"],2,",",".") ?>

</small>

<?php } ?>

</td>

<td>

<?php if($produto["ativo"]){ ?>

<span class="badge ativo">

<i class="fa-solid fa-circle-check"></i>

Ativo

</span>

<?php }else{ ?>

<span class="badge inativo">

<i class="fa-solid fa-circle-xmark"></i>

Inativo

</span>

<?php } ?>

<?php if($produto["destaque"]){ ?>

<br><br>

<span style="color:#ffd000;font-size:13px;">

⭐ Destaque

</span>

<?php } ?>

<?php if($produto["lancamento"]){ ?>

<br>

<span style="color:#4db7ff;font-size:13px;">

🚀 Lançamento

</span>

<?php } ?>

</td>

<td>

<a
href="editar.php?id=<?= $produto["id"] ?>"
class="btn-acao editar">

<i class="fa-solid fa-pen"></i>

</a>

<a
href="excluir.php?id=<?= $produto["id"] ?>"
class="btn-acao excluir"
onclick="return confirm('Deseja realmente excluir este produto?')">

<i class="fa-solid fa-trash"></i>

</a>

</td>

</tr>

<?php } ?>
</table>

<?php if($totalProdutos == 0){ ?>

<div style="
margin-top:30px;
padding:30px;
background:#1b1b1b;
border-radius:12px;
text-align:center;
color:#888;
">

<i class="fa-solid fa-box-open"
style="font-size:60px;color:#444;margin-bottom:15px;"></i>

<h2 style="color:#fff;margin-bottom:10px;">

Nenhum produto encontrado

</h2>

<p>

Cadastre um novo produto ou altere o filtro da pesquisa.

</p>

<br>

<a href="criar.php" class="btn">

<i class="fa-solid fa-plus"></i>

Novo Produto

</a>

</div>

<?php } ?>

</div>

</div>

</div>

</body>

</html>