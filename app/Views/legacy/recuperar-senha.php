<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Recuperar Senha | DWD Street</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;900&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Montserrat',sans-serif;
}

body{
    background:#0b0b0c;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.logo{

    font-size:52px;
    font-weight:900;
    color:#fff;
    margin-bottom:20px;
}

.logo span{

    color:#e31e24;

}

.container{

    width:430px;
    background:#141416;
    border:1px solid #2a2a2e;
    border-radius:18px;
    padding:45px;
}

h2{

    color:#fff;
    text-align:center;
    margin-bottom:10px;
}

.texto{

    color:#a7a7a7;
    text-align:center;
    line-height:24px;
    margin-bottom:30px;

}

label{

    color:#fff;
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:700;

}

input{

    width:100%;
    height:52px;
    border-radius:8px;
    border:2px solid #2a2a2e;
    background:#1b1b1d;
    color:#fff;
    padding:15px;
    margin-bottom:20px;
    outline:none;
}

input:focus{

    border-color:#e31e24;

}

button{

    width:100%;
    height:52px;
    border:none;
    border-radius:8px;
    background:#fff;
    color:#111;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

button:hover{

    background:#e31e24;
    color:#fff;

}

.voltar{

    display:block;
    text-align:center;
    margin-top:25px;
    color:#e31e24;
    text-decoration:none;
    font-weight:700;

}

</style>

</head>

<body>

<div class="logo">
DWD<span>STREET</span>
</div>

<div class="container">

<h2>Recuperar senha</h2>

<p class="texto">
Digite o e-mail cadastrado para receber um código de recuperação.
</p>

<form action="enviar_codigo.php" method="POST">

<label>E-mail</label>

<input
type="email"
name="email"
placeholder="seu@email.com"
required>

<button type="submit">
Enviar código
</button>

</form>

<a class="voltar" href="login.php">
Voltar para o login
</a>

</div>

</body>
</html>