<header class="topbar">

    <div class="topbar-left">

        <h2>Painel Administrativo</h2>

    </div>

    <div class="topbar-right">

        <div class="pesquisa">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input type="text" placeholder="Pesquisar...">

        </div>

        <div class="notificacao">

            <i class="fa-solid fa-bell"></i>

            <span class="badge">0</span>

        </div>

        <div class="usuario">

            <img src="img/user.png" alt="Administrador">

            <div class="info">

            <strong><?php echo $_SESSION["nome"]; ?></strong>

                <small><?php echo $_SESSION["email"]; ?></small>

            </div>

            <div class="dropdown">

                <i class="fa-solid fa-chevron-down"></i>

                <div class="dropdown-menu">

                    <a href="perfil.php">
                        <i class="fa-solid fa-user"></i>
                        Meu Perfil
                    </a>

                    <a href="configuracoes.php">
                        <i class="fa-solid fa-lock"></i>
                        Alterar Senha
                    </a>

                    <hr>

                    <a href="logout.php" class="sair">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Sair
                    </a>

                </div>

            </div>

        </div>

    </div>

</header>

<script>

const dropdown = document.querySelector(".dropdown");

dropdown.addEventListener("click", function(){

    this.classList.toggle("ativo");

});

window.addEventListener("click", function(e){

    if(!dropdown.contains(e.target)){

        dropdown.classList.remove("ativo");

    }

});

</script>