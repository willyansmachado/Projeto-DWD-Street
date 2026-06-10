<?php
include("proteger.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Painel Admin | DWD Street</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#0f0f0f;
    color:#fff;
    font-family:'Montserrat',sans-serif;
    transition:.3s;
}

/* HEADER */

.admin-header{
    background:#151515;
    border-bottom:2px solid #e31e24;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.admin-logo{
    font-size:34px;
    font-weight:900;
    color:white;
    text-decoration:none;
}

.admin-logo span{
    color:#e31e24;
}

.admin-user{
    display:flex;
    align-items:center;
    gap:15px;
}

.admin-info{
    text-align:right;
}

.admin-info small{
    color:#999;
    display:block;
    font-size:12px;
}

.admin-info strong{
    color:white;
}

.btn-loja{
    background:#252525;
    color:white;
    text-decoration:none;
    padding:10px 16px;
    border-radius:8px;
    font-weight:700;
    transition:.3s;
}

.btn-loja:hover{
    background:#333;
}

.btn-sair{
    background:#e31e24;
    color:white;
    text-decoration:none;
    padding:10px 16px;
    border-radius:8px;
    font-weight:700;
    transition:.3s;
}

.btn-sair:hover{
    background:#c91920;
}

/* CONTEUDO */

.admin-container{
    max-width:1300px;
    margin:auto;
    padding:50px 25px;
}

.admin-title{
    text-align:center;
    font-size:48px;
    font-weight:900;
    margin-bottom:15px;
}

.admin-title::after{
    content:"";
    display:block;
    width:120px;
    height:4px;
    background:#e31e24;
    margin:15px auto;
    border-radius:10px;
}

.admin-subtitle{
    text-align:center;
    color:#999;
    margin-bottom:50px;
}

/* CARDS */

.cards-admin{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
}

.card-admin{
    background:#181818;
    border:1px solid #252525;
    border-radius:16px;
    padding:30px;
    transition:.3s;
}

.card-admin:hover{
    transform:translateY(-6px);
    border-color:#e31e24;
    box-shadow:0 0 20px rgba(227,30,36,.2);
}

.card-admin h3{
    font-size:24px;
    margin-bottom:15px;
}

.card-admin p{
    color:#bdbdbd;
    margin-bottom:20px;
    line-height:1.6;
}

.btn-admin{
    display:inline-block;
    background:#e31e24;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:8px;
    font-weight:700;
}

.btn-admin:hover{
    opacity:.9;
}

/* RESPONSIVO */

@media(max-width:900px){

.admin-header{
    flex-direction:column;
    gap:15px;
}

.admin-user{
    flex-wrap:wrap;
    justify-content:center;
}

.admin-title{
    font-size:34px;
}

}
.theme-btn{
    background:#252525;
    color:white;
    border:none;
    padding:10px 16px;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
    font-weight:700;
    transition:.3s;
}

.theme-btn:hover{
    background:#333;
}body.light-mode{
    background:#f5f5f5;
    color:#111;
}

body.light-mode .admin-header{
    background:white;
    border-bottom:2px solid #e31e24;
}

body.light-mode .card-admin{
    background:white;
    color:#111;
    border:1px solid #ddd;
}

body.light-mode .card-admin p{
    color:#555;
}

body.light-mode .admin-info strong{
    color:#111;
}

body.light-mode .btn-loja,
body.light-mode .theme-btn{
    background:#eee;
    color:#111;
}
body.light-mode{
    background:#f5f5f5;
    color:#111;
}

body.light-mode .admin-header{
    background:white;
    border-bottom:2px solid #e31e24;
}

body.light-mode .card-admin{
    background:white;
    color:#111;
    border:1px solid #ddd;
}

body.light-mode .card-admin p{
    color:#555;
}

body.light-mode .admin-info strong{
    color:#111;
}

body.light-mode .btn-loja,
body.light-mode .theme-btn{
    background:#eee;
    color:#111;
}body.light-mode{
    background:#f5f5f5;
    color:#111;
}

body.light-mode .admin-header{
    background:white;
    border-bottom:2px solid #e31e24;
}

body.light-mode .card-admin{
    background:white;
    color:#111;
    border:1px solid #ddd;
}

body.light-mode .card-admin p{
    color:#555;
}

body.light-mode .admin-info strong{
    color:#111;
}

body.light-mode .btn-loja,
body.light-mode .theme-btn{
    background:#eee;
    color:#111;
}

</style>

</head>
<body>

<header class="admin-header">

<a href="../index.php" class="admin-logo">
DWD<span>STREET</span>
</a>

<div class="admin-user">

    <div class="admin-info">
        <small>Usuário Logado</small>
        <strong>
            👤 <?php echo $_SESSION["nome"]; ?>
        </strong>
    </div>

    <button id="theme-toggle" class="theme-btn">
        🌙
    </button>

    <a href="../logout.php" class="btn-sair">
        🚪 Sair
    </a>

</div>

</header>

<div class="admin-container">

<h1 class="admin-title">
Painel Administrativo
</h1>

<p class="admin-subtitle">
Gerencie produtos, pedidos e usuários da DWD Street
</p>

<div class="cards-admin">

    <div class="card-admin">
        <h3>📦 Produtos</h3>

        <p>
            Cadastre novos produtos, altere preços,
            estoque, categorias e imagens.
        </p>

        <a href="produtos.php" class="btn-admin">
            Gerenciar Produtos
        </a>
    </div>

    <div class="card-admin">
        <h3>🛒 Pedidos</h3>

        <p>
            Acompanhe pedidos realizados e altere
            os status de entrega.
        </p>

        <a href="pedidos.php" class="btn-admin">
            Gerenciar Pedidos
        </a>
    </div>

    <div class="card-admin">
        <h3>👥 Usuários</h3>

        <p>
            Visualize todos os clientes cadastrados
            e gerencie permissões.
        </p>

        <a href="usuarios.php" class="btn-admin">
            Gerenciar Usuários
        </a>
    </div>

</div>

</div>
<script>

if(localStorage.getItem("theme") === "light"){
    document.body.classList.add("light-mode");
    document.getElementById("theme-toggle").innerHTML = "☀️";
}

document.getElementById("theme-toggle").addEventListener("click", function(){

    document.body.classList.toggle("light-mode");

    if(document.body.classList.contains("light-mode")){

        localStorage.setItem("theme","light");
        this.innerHTML = "☀️";

    }else{

        localStorage.setItem("theme","dark");
        this.innerHTML = "🌙";

    }

});

</script>

</body>
</html>