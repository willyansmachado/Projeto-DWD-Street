// ==========================================================================
// EVENTOS QUE RODAM QUANDO A PÁGINA CARREGA
// ==========================================================================
document.addEventListener("DOMContentLoaded", () => {
    
    // ----------------------------------------------------------------------
    // 1. MODO ESCURO
    // ----------------------------------------------------------------------
    const themeToggleBtn = document.getElementById('theme-toggle');
    const body = document.body;

    if (themeToggleBtn) {
        // Verifica o que está salvo no LocalStorage
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            themeToggleBtn.textContent = '☀️'; 
        }

        // Ação de clique
        themeToggleBtn.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
                themeToggleBtn.textContent = '☀️';
            } else {
                localStorage.setItem('theme', 'light');
                themeToggleBtn.textContent = '🌙';
            }
        });
    }

    // ----------------------------------------------------------------------
    // 2. CARROSSEL DE BANNERS DA HOME
    // ----------------------------------------------------------------------
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;

    if (slides.length > 0) {
        setInterval(() => {
            slides[currentSlide].classList.remove('active');
            currentSlide++;
            
            if (currentSlide >= slides.length) {
                currentSlide = 0;
            }
            
            slides[currentSlide].classList.add('active');
        }, 4000);
    }

    // ----------------------------------------------------------------------
    // 3. LÓGICA DO CARRINHO COM TRAVA DE LOGIN
    // ----------------------------------------------------------------------
    const cartCountElement = document.getElementById('cart-count');
    
    // Função para atualizar o visual da bolinha (Badge) do carrinho
    function atualizarBadge() {
        if (!cartCountElement) return; // Segurança caso o elemento sumisse
        
        let qtdAtual = parseInt(localStorage.getItem('cart_total_items')) || 0;
        
        if (qtdAtual > 0) {
            cartCountElement.textContent = qtdAtual;
            cartCountElement.style.display = 'flex';
        } else {
            cartCountElement.style.display = 'none';
        }
    }

    // Inicializa o contador na barra de navegação ao carregar a página
    atualizarBadge();

    // Seleciona todos os botões de compra possíveis (.auth-btn e .add-to-cart-btn)
    const botoesComprar = document.querySelectorAll('.auth-btn, .add-to-cart-btn');

    botoesComprar.forEach(botao => {
        botao.addEventListener('click', (evento) => {
            evento.preventDefault(); // Previne comportamentos inesperados do botão

            // CRUCIAL: Verifica se o usuário está logado
            const estaLogado = localStorage.getItem('usuario_logado');

            if (!estaLogado || estaLogado !== 'true') {
                // Barra a compra e avisa o cliente
                alert('Ops! Você precisa estar logado para adicionar itens ao carrinho. 🛒');
                
                // Redireciona na hora para a página de login
                window.location.href = 'login.html';
                return; // Encerra a função aqui para impedir que adicione o item
            }

            // SE PASSOU PELA TRAVA: Executa a compra normalmente
            let qtdAtual = parseInt(localStorage.getItem('cart_total_items')) || 0;
            qtdAtual += 1;
            localStorage.setItem('cart_total_items', qtdAtual);
            
            // Atualiza a bolinha de notificação imediatamente
            atualizarBadge();
            
            // Feedback visual no console e no botão
            console.log("Item adicionado ao carrinho tricolor!");
            
            const textoOriginal = botao.textContent;
            botao.textContent = "Adicionado! ✓";
            botao.style.backgroundColor = "#28a745";
            
            setTimeout(() => {
                botao.textContent = textoOriginal;
                botao.style.backgroundColor = ""; 
            }, 1500);
        });
    });
});