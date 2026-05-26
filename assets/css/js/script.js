// ==========================================================================
// EVENTOS QUE RODAM QUANDO A PÁGINA CARREGA
// ==========================================================================
document.addEventListener("DOMContentLoaded", () => {
    
    // ----------------------------------------------------------------------
    // 1. MODO ESCURO (DARK MODE)
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
    // 3. LÓGICA DE ADICIONAR AO CARRINHO (COM DADOS REAIS E TRAVA)
    // ----------------------------------------------------------------------
    const cartCountElement = document.getElementById('cart-count');
    
    // Função global para atualizar a bolinha (badge) do menu
    function atualizarBadge() {
        if (!cartCountElement) return;
        
        let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
        // Soma a quantidade de todos os itens guardados
        let totalItens = carrinho.reduce((soma, item) => soma + item.quantidade, 0);
        
        if (totalItens > 0) {
            cartCountElement.textContent = totalItens;
            cartCountElement.style.display = 'flex';
        } else {
            cartCountElement.style.display = 'none';
        }
    }

    // Sincroniza a bolinha assim que a página abre
    atualizarBadge();

    // Seleciona os botões de compra dos produtos
    const botoesComprar = document.querySelectorAll('.product-card .auth-btn, .add-to-cart-btn');

    botoesComprar.forEach(botao => {
        botao.addEventListener('click', (evento) => {
            evento.preventDefault();

            // 1. TRAVA DE LOGIN
            const estaLogado = localStorage.getItem('usuario_logado');
            if (!estaLogado || estaLogado !== 'true') {
                alert('Ops! Você precisa estar logado para adicionar itens ao carrinho. 🛒');
                window.location.href = 'login.html';
                return;
            }

            // 2. CAPTURA DINÂMICA DOS DADOS DO CARD NO HTML
            const card = botao.closest('.product-card');
            if (!card) return; // Segurança caso o botão esteja fora de um card

            // Captura o título (aceita tag h3 ou classe .product-title)
            const nomeEl = card.querySelector('h3') || card.querySelector('.product-title');
            // Captura o preço (aceita classe .price ou .product-price)
            const precoEl = card.querySelector('.price') || card.querySelector('.product-price') || card.querySelector('.promo-price');
            // Captura a imagem
            const imgEl = card.querySelector('img');

            const nomeProduto = nomeEl ? nomeEl.textContent.trim() : "Produto Streetwear";
            const imagemUrl = imgEl ? imgEl.getAttribute('src') : "";
            
            // Tratamento do preço text ("R$ 129,90") para número puro (129.90)
            let precoProduto = 0;
            if (precoEl) {
                let textoLimpo = precoEl.textContent.replace('R$', '').replace(/\s/g, '').replace('.', '').replace(',', '.');
                precoProduto = parseFloat(textoLimpo) || 0;
            }

            // 3. SALVAR NO ARRAY DO LOCALSTORAGE
            let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];

            // Vê se esse produto específico já estava na lista
            const produtoExiste = carrinho.find(item => item.nome === nomeProduto);

            if (produtoExiste) {
                produtoExiste.quantidade += 1; // Só aumenta a quantidade dele
            } else {
                // Adiciona um objeto completinho na lista
                carrinho.push({
                    id: Date.now() + Math.random(), // Gera um ID único provisório
                    nome: nomeProduto,
                    preco: precoProduto,
                    imagem_url: imagemUrl,
                    quantidade: 1
                });
            }

            // Devolve a lista pro LocalStorage
            localStorage.setItem('carrinho_itens', JSON.stringify(carrinho));
            
            // Atualiza a bolinha vermelha na hora
            atualizarBadge();
            
            // Feedback de sucesso no botão
            const textoOriginal = botao.textContent;
            botao.textContent = "Adicionado! ✓";
            botao.style.backgroundColor = "#28a745";
            
            setTimeout(() => {
                botao.textContent = textoOriginal;
                botao.style.backgroundColor = ""; 
            }, 1500);
        });
    });

    // ----------------------------------------------------------------------
    // 4. RENDERIZAÇÃO EXCLUSIVA DA PÁGINA DO CARRINHO
    // ----------------------------------------------------------------------
    const containerCarrinho = document.getElementById('itens-do-carrinho-container');

    // Se esse ID existir na página atual, significa que o usuário está na tela do carrinho!
    if (containerCarrinho) {
        renderizarCarrinho();
    }

    function renderizarCarrinho() {
        let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];
        containerCarrinho.innerHTML = ''; // Limpa a simulação estática antiga

        // Se não tiver nada no carrinho
        if (carrinho.length === 0) {
            containerCarrinho.innerHTML = `
                <div style="text-align: center; padding: 40px; color: #888;">
                    <p style="font-size: 1.2rem; margin-bottom: 20px; font-weight: bold;">Seu carrinho está vazio. 🛒</p>
                    <a href="masculino.html" class="auth-btn" style="text-decoration: none; display: inline-block; padding: 12px 25px;">Ver Produtos</a>
                </div>
            `;
            document.getElementById('resumo-subtotal').textContent = 'R$ 0,00';
            document.getElementById('resumo-total').textContent = 'R$ 0,00';
            return;
        }

        let subtotalGeral = 0;

        // Desenha cada produto guardado na tela
        carrinho.forEach(item => {
            let totalDoItem = item.preco * item.quantidade;
            subtotalGeral += totalDoItem;

            const itemCard = document.createElement('div');
            itemCard.className = 'cart-item';
            
            itemCard.innerHTML = `
                <img src="${item.imagem_url}" alt="${item.nome}">
                <div class="item-details">
                    <h4>${item.nome}</h4>
                    <p>Quantidade: <strong>${item.quantidade}</strong></p>
                    <span class="item-price">R$ ${item.preco.toFixed(2).replace('.', ',')}</span>
                </div>
                <button class="remove-btn" data-nome="${item.nome}">🗑️</button>
            `;

            containerCarrinho.appendChild(itemCard);
        });

        // Atualiza a caixa lateral de resumo financeiro
        const subtotalElement = document.getElementById('resumo-subtotal');
        const totalElement = document.getElementById('resumo-total');

        if (subtotalElement && totalElement) {
            subtotalElement.textContent = `R$ ${subtotalGeral.toFixed(2).replace('.', ',')}`;
            totalElement.textContent = `R$ ${subtotalGeral.toFixed(2).replace('.', ',')}`;
        }

        // Liga os eventos nos botões de lixeira instalados
        configurarBotoesRemover();
    }

    function configurarBotoesRemover() {
        const botoesRemover = document.querySelectorAll('.remove-btn');
        
        botoesRemover.forEach(botao => {
            botao.addEventListener('click', () => {
                const nomeParaRemover = botao.getAttribute('data-nome');
                let carrinho = JSON.parse(localStorage.getItem('carrinho_itens')) || [];

                // Filtra a lista removendo o item clicado
                carrinho = carrinho.filter(item => item.nome !== nomeParaRemover);

                // Salva a nova lista limpa
                localStorage.setItem('carrinho_itens', JSON.stringify(carrinho));

                // Recarrega o carrinho e recalcula tudo na tela
                renderizarCarrinho();
                atualizarBadge();
            });
        });
    }

});