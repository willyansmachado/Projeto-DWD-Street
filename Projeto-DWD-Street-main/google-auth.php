<?php
session_start();
require_once "config/conexao.php";

// =========================================================================
// CONFIGURAÇÕES DO GOOGLE CONSOLE
// Você deve gerar essas chaves em: https://console.cloud.google.com/
// =========================================================================
$client_id     = 'SEU_CLIENT_ID_AQUI.apps.googleusercontent.com';
$client_secret = 'SEU_CLIENT_SECRET_AQUI';
$redirect_uri  = 'http://localhost:9999/Projeto-DWD-Street-main/Projeto-DWD-Street-main/google_auth.php'; 

// -------------------------------------------------------------------------
// PASSO 1: Redireciona o usuário para a tela de login do Google
// -------------------------------------------------------------------------
if (!isset($_GET['code'])) {
    $auth_url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
        'client_id'     => $client_id,
        'redirect_uri'  => $redirect_uri,
        'response_type' => 'code',
        'scope'         => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
        'access_type'   => 'offline',
        'prompt'        => 'select_account'
    ]);
    header("Location: " . $auth_url);
    exit();
}

// -------------------------------------------------------------------------
// PASSO 2: O Google devolveu o 'code', trocamos ele pelo Access Token
// -------------------------------------------------------------------------
$code = $_GET['code'];
$token_url = "https://oauth2.googleapis.com/token";
$post_fields = [
    'code'          => $code,
    'client_id'     => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri'  => $redirect_uri,
    'grant_type'    => 'authorization_code'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignora erros de SSL no localhost do XAMPP
$response = curl_exec($ch);
curl_close($ch);

$token_data = json_decode($response, true);

if (isset($token_data['access_token'])) {
    $access_token = $token_data['access_token'];

    // -------------------------------------------------------------------------
    // PASSO 3: Busca os dados do perfil (Nome, Sobrenome, E-mail) usando o Token
    // -------------------------------------------------------------------------
    $userinfo_url = "https://www.googleapis.com/oauth2/v2/userinfo?access_token=" . $access_token;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $userinfo_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $user_response = curl_exec($ch);
    curl_close($ch);

    $google_user = json_decode($user_response, true);

    if (isset($google_user['email'])) {
        $email      = mysqli_real_escape_string($conn, $google_user['email']);
        $nome       = mysqli_real_escape_string($conn, $google_user['given_name'] ?? 'Usuário');
        $sobrenome  = mysqli_real_escape_string($conn, $google_user['family_name'] ?? 'Google');
        
        // Verifica se o e-mail do Google já existe na tabela de usuários
        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($conn, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            // Se o usuário já tem cadastro, captura os dados dele
            $usuario = mysqli_fetch_assoc($resultado);
        } else {
            // Se o usuário não existe, faz o cadastro automático na hora!
            // Como sua tabela exige CPF e Senha (NOT NULL), geramos dados temporários/seguros
            $cpf_fake = "GGL-" . time() . rand(10, 99);
            $senha_fake = password_hash(uniqid(rand(), true), PASSWORD_DEFAULT);

            $sql_insert = "INSERT INTO usuarios (nome, sobrenome, cpf, email, senha, nivel) 
                           VALUES ('$nome', '$sobrenome', '$cpf_fake', '$email', '$senha_fake', 'cliente')";
            
            if (mysqli_query($conn, $sql_insert)) {
                $id_novo = mysqli_insert_id($conn);
                $res_busca = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = $id_novo");
                $usuario = mysqli_fetch_assoc($res_busca);
            } else {
                die("Erro ao registrar conta com o Google: " . mysqli_error($conn));
            }
        }

        // -------------------------------------------------------------------------
        // PASSO 4: Inicia as variáveis de sessão (Identidade idêntica ao login.php)
        // -------------------------------------------------------------------------
        $_SESSION["id"]    = $usuario["id"];
        $_SESSION["nome"]  = $usuario["nome"];
        $_SESSION["email"] = $usuario["email"];
        $_SESSION["nivel"] = $usuario["nivel"];

        // Redireciona baseado no nível de acesso
        if ($usuario["nivel"] == "admin") {
            header("Location: admin/admiin.php");
        } else {
            header("Location: index.php");
        }
        exit();
    }
}

// Se o processo falhar por qualquer motivo, volta ao login com aviso
header("Location: login.php");
exit();