<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nome = $_SESSION["nome"] ?? "Administrador";

?>

<div class="topbar">

    <div>
        <h2>Painel Administrativo</h2>
    </div>

    <div class="usuario">

        <span>
            <i class="fa-solid fa-user"></i>
            <?= htmlspecialchars($nome) ?>
        </span>

        <a href="../logout.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            Sair
        </a>

    </div>

</div>