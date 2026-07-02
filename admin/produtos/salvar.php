<?php
session_start();

include("../../config/conexao.php");
include("../includes/verificar_login.php");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit();
}

/* SALVA O FORMULÁRIO CASO DÊ ERRO */
$_SESSION["form_produto"] = $_POST;

/* DADOS */

$nome = trim($_POST["nome"]);
$categoria_id = (int)$_POST["categoria_id"];
$sku = trim($_POST["sku"]);

$preco = str_replace(",", ".", $_POST["preco"]);

$preco_promocional = !empty($_POST["preco_promocional"])
    ? str_replace(",", ".", $_POST["preco_promocional"])
    : NULL;

$estoque = (int)$_POST["estoque"];

$descricao_curta = trim($_POST["descricao_curta"]);
$descricao = trim($_POST["descricao"]);

$destaque = (int)$_POST["destaque"];
$lancamento = (int)$_POST["lancamento"];
$ativo = (int)$_POST["ativo"];

/* VALIDA SKU */

if (!empty($sku)) {

    $sql = "SELECT id FROM produtos WHERE sku = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $sku);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) > 0) {

        $_SESSION["erro_produto"] = "Já existe um produto utilizando o SKU <strong>" . htmlspecialchars($sku) . "</strong>. Utilize outro código e tente novamente.";

        header("Location: erro_produto.php");
        exit();

    }

}

/* GERAR SLUG */

$slug = strtolower($nome);
$slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
$slug = trim($slug, '-');

$slugBase = $slug;
$contador = 2;

while (true) {

    $sqlSlug = "SELECT id FROM produtos WHERE slug = ?";

    $stmtSlug = mysqli_prepare($conn, $sqlSlug);

    mysqli_stmt_bind_param($stmtSlug, "s", $slug);

    mysqli_stmt_execute($stmtSlug);

    $resultadoSlug = mysqli_stmt_get_result($stmtSlug);

    if (mysqli_num_rows($resultadoSlug) == 0) {
        break;
    }

    $slug = $slugBase . "-" . $contador;
    $contador++;

}

/* UPLOAD DA IMAGEM */

$imagem = "";

if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {

    $pasta = "../../uploads/produtos/";

    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $ext = strtolower(pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION));

    $nomeImagem = uniqid() . "." . $ext;

    if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $pasta . $nomeImagem)) {

        $imagem = "uploads/produtos/" . $nomeImagem;

    }

}

/* INSERT */

$sql = "INSERT INTO produtos
(
categoria_id,
nome,
slug,
descricao,
descricao_curta,
sku,
preco,
preco_promocional,
estoque,
imagem,
destaque,
lancamento,
ativo
)

VALUES
(
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?
)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "isssssddisiii",
    $categoria_id,
    $nome,
    $slug,
    $descricao,
    $descricao_curta,
    $sku,
    $preco,
    $preco_promocional,
    $estoque,
    $imagem,
    $destaque,
    $lancamento,
    $ativo
);

if (mysqli_stmt_execute($stmt)) {

    unset($_SESSION["form_produto"]);

    $_SESSION["sucesso"] = "Produto cadastrado com sucesso!";

    header("Location: index.php");
    exit();

} else {

    $_SESSION["erro_produto"] = "Ocorreu um erro ao salvar o produto.";

    header("Location: erro_produto.php");
    exit();

}