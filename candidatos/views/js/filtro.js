
document.addEventListener('DOMContentLoaded', function(e) {
    e.preventDefault();
    const campoDeBusca = document.querySelector('.search__input');

    campoDeBusca.addEventListener('input', filtrarTabela);

    function filtrarTabela() {
        const textoDeBusca = campoDeBusca.value.toUpperCase();
        const linhasDaTabela = document.querySelectorAll('#table-users tr');

        linhasDaTabela.forEach((linha, index) => {
            if (index === 0) return; // Ignorar o cabeçalho da tabela
            const celulas = linha.querySelectorAll('td');
            let textoDaLinha = '';
            celulas.forEach(celula => {
                textoDaLinha += celula.textContent.toUpperCase() + ' ';
            });

            if (textoDaLinha.includes(textoDeBusca)) {
                linha.style.display = '';
            } else {
                linha.style.display = 'none';
            }
        });
    }
});
