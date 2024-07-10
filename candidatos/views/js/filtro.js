
document.addEventListener('DOMContentLoaded', function (e) {
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


async function getDataForPrint(event) {
    event.preventDefault();

    const valueFilter = document.querySelector('.search__input').value;
    const listForm = document.querySelector('#listing-form');

    try {
        const formData = new FormData(listForm);
        formData.append('action', 'print');
        const data = {
            action: 'print',
            valueFilter: valueFilter,
        };

        formData.forEach((value, key) => {
            data[key] = value;
        });

        const response = await fetch('../src/repository/CandidateRepository.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error('Erro ao cadastrar usuário!');
        }

        const responseData = await response.json();
        console.log(responseData);

    } catch (error) {
        console.error('Erro no fetch:', error);
        return;
    }
}