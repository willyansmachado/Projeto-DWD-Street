<?php

$conn = new mysqli("localhost", "root", "", "dwd_street");

$senha = password_hash("1234567", PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios
(nome,sobrenome,cpf,email,senha,nivel)
VALUES
(
'Administrador',
'DWD',
'00000000000',
'admin@dwdstreet.com',
'$senha',
'admin'
)";

if($conn->query($sql)){
    echo "Admin criado com sucesso!";
}else{
    echo $conn->error;
}