// ==========================================
// LÓGICA DO CARRINHO DE COMPRAS
// ==========================================
let totalCart = 0;
const cartCount = document.getElementById('cart-count');
const addButtons = document.querySelectorAll('.add-to-cart-btn');

addButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        totalCart++;
        cartCount.innerText = totalCart;
        
        // Feedback visual tipo "Toast"
        console.log("Item adicionado ao carrinho tricolor!");
    });
});

// ==========================================
// EVENTOS QUE RODAM QUANDO A PÁGINA CARREGA
// ==========================================
document.addEventListener("DOMContentLoaded", () => {
    
    // ------------------------------------------
    // 1. MODO ESCURO
    // ------------------------------------------
    const themeToggleBtn = document.getElementById('theme-toggle');
    const body = document.body;

    // Se o botão não existir na página, o script para aqui para não dar erro
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

    // ------------------------------------------
    // 2. CARROSSEL DE BANNERS DA HOME
    // ------------------------------------------
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;

    // Só executa se encontrar banners na página (ou seja, se estiver na Home)
    if (slides.length > 0) {
        setInterval(() => {
            // Remove a classe 'active' do banner atual (esconde ele)
            slides[currentSlide].classList.remove('active');
            
            // Vai para o próximo banner
            currentSlide++;
            
            // Se chegou no final, volta pro primeiro
            if (currentSlide >= slides.length) {
                currentSlide = 0;
            }
            
            // Adiciona a classe 'active' no novo banner (mostra ele)
            slides[currentSlide].classList.add('active');
        }, 4000); // 4000 = troca a foto a cada 4 segundos
    }
});