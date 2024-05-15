
document.addEventListener('DOMContentLoaded', function (e) {
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


function imprimirListagem(event) {
    event.preventDefault();
    // Copia apenas o conteúdo visível da tabela
    const tabela = document.getElementById('table-users').cloneNode(true);
    const linhas = tabela.querySelectorAll('tr');
    linhas.forEach(linha => {
        if (linha.style.display === 'none') {
            linha.remove();
        }
    });

    // Abre uma nova janela e insere a tabela nela
    const novaJanela = window.open('', '_blank');
    novaJanela.document.body.innerHTML = '<h1>Listagem de Candidatos</h1>';
    novaJanela.document.body.appendChild(tabela);

    // Aciona o comando de impressão na nova janela
    novaJanela.print();
}
