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