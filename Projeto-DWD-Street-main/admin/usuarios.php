<?php
include("proteger.php");
include("../config/conexao.php");

$sql = "SELECT * FROM usuarios ORDER BY id DESC";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuários | DWD Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#0f0f0f;
    color:white;
    font-family:'Montserrat',sans-serif;
}

.container{
    width:95%;
    max-width:1400px;
    margin:40px auto;
}

.topo{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

h1{
    font-size:38px;
    font-weight:900;
}

h1 span{
    color:#e31e24;
}

.voltar{
    background:#252525;
    color:white;
    text-decoration:none;
    padding:12px 18px;
    border-radius:8px;
    font-weight:700;
}

.voltar:hover{
    background:#333;
}

.card{
    background:#1a1a1a;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 0 20px rgba(0,0,0,.4);
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#e31e24;
    padding:16px;
    text-align:left;
    font-size:14px;
}

td{
    padding:16px;
    border-bottom:1px solid #2c2c2c;
}

tr:hover{
    background:#222;
}

.btn-excluir{
    background:#e31e24;
    color:white;
    text-decoration:none;
    padding:8px 14px;
    border-radius:6px;
    font-size:14px;
    font-weight:700;
}

.btn-excluir:hover{
    background:#c9181d;
}

.badge{
    background:#252525;
    padding:6px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:700;
}

.info{
    margin-bottom:20px;
    color:#bbb;
}

</style>

</head>
<body>

<div class="container">

<div class="topo">

<h1>
👥 Usuários <span>DWD</span>
</h1>

<a href="admiin.php" class="voltar">
← Voltar ao Painel
</a>

</div>

<p class="info">
Total de usuários cadastrados:
<strong><?php echo $resultado->num_rows; ?></strong>
</p>

<div class="card">

<table>

<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Sobrenome</th>
    <th>Email</th>
    <th>Cadastro</th>
    <th>Ações</th>
</tr>

<?php while($usuario = $resultado->fetch_assoc()){ ?>

<tr>

<td>
<span class="badge">
#<?php echo $usuario["id"]; ?>
</span>
</td>

<td>
<?php echo $usuario["nome"]; ?>
</td>

<td>
<?php echo $usuario["sobrenome"]; ?>
</td>

<td>
<?php echo $usuario["email"]; ?>
</td>

<td>
<?php echo date("d/m/Y", strtotime($usuario["data_cadastro"])); ?>
</td>

<td>

<a
class="btn-excluir"
href="excluir_usuario.php?id=<?php echo $usuario["id"]; ?>"
onclick="return confirm('Deseja realmente excluir este usuário?')"
>
🗑 Excluir
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>