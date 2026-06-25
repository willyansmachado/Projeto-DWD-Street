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
        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            themeToggleBtn.textContent = '☀️'; 
        }

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
    // 3. LÓGICA DO CARRINHO: TRAVA DE LOGIN E CAPTURA DE DADOS
    // ----------------------------------------------------------------------
    const cartCountElement = document.getElementById('cart-count');
    
    // Atualiza a bolinha de contagem lendo o array real de produtos
    function atualizarBadge() {
        if (!cartCountElement) return; 
        
        let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
        let qtdAtual = carrinho.reduce((soma, item) => soma + item.quantidade, 0);
        
        if (qtdAtual > 0) {
            cartCountElement.textContent = qtdAtual;
            cartCountElement.style.display = 'flex';
        } else {
            cartCountElement.style.display = 'none';
        }
    }

    atualizarBadge();

    const botoesComprar = document.querySelectorAll('.auth-btn, .add-to-cart-btn');

    botoesComprar.forEach(botao => {
        botao.addEventListener('click', (evento) => {
            evento.preventDefault(); 

            // 1. VERIFICAÇÃO DE LOGIN
            const estaLogado = localStorage.getItem('usuario_logado');
            if (!estaLogado || estaLogado !== 'true') {
                alert('Ops! Você precisa estar logado para adicionar itens ao carrinho. 🛒');
                window.location.href = 'login.html';
                return; 
            }

            // 2. CAPTURA DOS DADOS DO PRODUTO NO HTML
            const card = botao.closest('.product-card'); // Encontra o card em volta do botão
            if (!card) return; // Segurança caso o HTML esteja estruturado diferente

            const nomeProduto = card.querySelector('h3').textContent.trim();
            const imagemUrl = card.querySelector('img').getAttribute('src');
            
            // Pega o texto do preço e limpa para virar número de verdade
            const precoElemento = card.querySelector('.preco-promocional') || card.querySelector('.item-price') || card.querySelector('p');
            let precoTexto = precoElemento.textContent;
            let precoLimpo = precoTexto.replace('Por', '').replace('R$', '').replace(/\s/g, '').replace('.', '').replace(',', '.');
            const precoProduto = parseFloat(precoLimpo) || 0;

            // 3. SALVA NO LOCALSTORAGE
            let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
            const produtoExistente = carrinho.find(item => item.nome === nomeProduto);

            if (produtoExistente) {
                produtoExistente.quantidade += 1;
            } else {
                carrinho.push({
                    nome: nomeProduto,
                    preco: precoProduto,
                    imagem_url: imagemUrl,
                    quantidade: 1
                });
            }

            localStorage.setItem('carrinho_itens', JSON.stringify(carrinho));
            
            // 4. ATUALIZA A TELA E DÁ FEEDBACK AO USUÁRIO
            atualizarBadge();
            
            const textoOriginal = botao.textContent;
            botao.textContent = "Adicionado! ✓";
            botao.style.backgroundColor = "#28a745";
            botao.style.color = "#fff";
            
            setTimeout(() => {
                botao.textContent = textoOriginal;
                botao.style.backgroundColor = ""; 
                botao.style.color = "";
            }, 1500);
        });
    });
});