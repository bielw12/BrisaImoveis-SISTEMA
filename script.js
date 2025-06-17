// Seleciona todos os botões de dropdown
document.addEventListener("DOMContentLoaded", function () {
  const dropdownButtons = document.querySelectorAll(".dropbtn");

  dropdownButtons.forEach((button) => {
    button.addEventListener("click", function (event) {
      event.stopPropagation(); // evita que o clique feche o menu imediatamente
      const dropdown = this.parentElement;
      dropdown.classList.toggle("active");

      // Fecha outros dropdowns
      document.querySelectorAll(".dropdown").forEach((otherDropdown) => {
        if (otherDropdown !== dropdown) {
          otherDropdown.classList.remove("active");
        }
      });
    });
  });

  // Fecha os dropdowns se clicar fora
  window.addEventListener("click", function () {
    document.querySelectorAll(".dropdown").forEach((dropdown) => {
      dropdown.classList.remove("active");
    });
  });
});
const estrelas = document.querySelectorAll('.star');
const mensagem = document.getElementById('mensagem');
let nota = 0;

estrelas.forEach((estrela, index) => {
    estrela.addEventListener('click', () => {
        nota = index + 1;
        atualizarEstrelas();
        mensagem.innerText = `Você avaliou com ${nota} estrela${nota > 1 ? 's' : ''}. Obrigado!`;
    });

    estrela.addEventListener('mouseover', () => {
        preencherEstrelas(index);
    });

    estrela.addEventListener('mouseout', () => {
        atualizarEstrelas();
    });
});

function preencherEstrelas(indice) {
    estrelas.forEach((estrela, i) => {
        estrela.classList.toggle('selecionada', i <= indice);
    });
}

function atualizarEstrelas() {
    estrelas.forEach((estrela, i) => {
        estrela.classList.toggle('selecionada', i < nota);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const slide = document.querySelector('.carousel-slide');
    const items = document.querySelectorAll('.carousel-item');
    const nextBtn = document.querySelector('.carousel-button.next');
    const prevBtn = document.querySelector('.carousel-button.prev');
    const dotsContainer = document.querySelector('.carousel-dots');

    let currentIndex = 0;
    const totalItems = items.length;
    let autoSlideInterval;

    // Criar bolinhas de navegação
    for (let i = 0; i < totalItems; i++) {
        const dot = document.createElement('div');
        dot.classList.add('dot');
        dot.addEventListener('click', () => {
            goToSlide(i);
            resetAutoSlide();
        });
        dotsContainer.appendChild(dot);
    }
    const dots = document.querySelectorAll('.dot');

    // Função para ir para um slide específico
    function goToSlide(index) {
        if (index < 0) {
            index = totalItems - 1;
        } else if (index >= totalItems) {
            index = 0;
        }
        slide.style.transform = `translateX(-${index * 100}%)`;
        currentIndex = index;
        updateDots();
    }

    // Função para atualizar a bolinha ativa
    function updateDots() {
        dots.forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    // Função para iniciar o carrossel automático
    function startAutoSlide() {
        autoSlideInterval = setInterval(() => {
            goToSlide(currentIndex + 1);
        }, 2000); // Troca a cada 2 segundos (2000 ms)
    }

    // Função para reiniciar o timer do carrossel automático
    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        startAutoSlide();
    }

    // Event Listeners para os botões
    nextBtn.addEventListener('click', () => {
        goToSlide(currentIndex + 1);
        resetAutoSlide();
    });

    prevBtn.addEventListener('click', () => {
        goToSlide(currentIndex - 1);
        resetAutoSlide();
    });

    // Iniciar o carrossel
    updateDots();
    startAutoSlide();
});