document.addEventListener('DOMContentLoaded', function () {
    const abas = document.querySelectorAll('.aba');
    const tabContents = document.querySelectorAll('.tab-content');

    abas.forEach(aba => {
        aba.addEventListener('click', function () {
            const tabName = this.getAttribute('data-tab');

            // Remove a classe 'active' de todas as abas
            abas.forEach(aba => {
                aba.classList.remove('active');
            });

            // Adiciona a classe 'active' apenas na aba clicada
            this.classList.add('active');

            // Oculta todos os conteúdos de aba
            tabContents.forEach(content => {
                content.style.display = 'none';
            });

            // Mostra o conteúdo da aba correspondente
            document.getElementById(tabName).style.display = 'flex';
        });
    });
});


function iniciarRedimensionamento(event) {
    // Definir o elemento que está sendo redimensionado
    var elementoRedimensionado = event.target;
    // Definir a posição inicial do mouse
    var posicaoInicialMouseX = event.clientX;
    var posicaoInicialMouseY = event.clientY;

    // Definir as dimensões iniciais do elemento
    var larguraInicial = elementoRedimensionado.offsetWidth;
    var alturaInicial = elementoRedimensionado.offsetHeight;

    // Função para redimensionar o elemento
    function redimensionar(event) {
        // Calcular a diferença de posição do mouse
        var diferencaPosicaoX = event.clientX - posicaoInicialMouseX;
        var diferencaPosicaoY = event.clientY - posicaoInicialMouseY;

        // Ajustar a largura do elemento com base na diferença de posição do mouse
        elementoRedimensionado.style.width = larguraInicial + diferencaPosicaoX + 'px';
        // Ajustar a altura do elemento com base na diferença de posição do mouse
        elementoRedimensionado.style.height = alturaInicial + diferencaPosicaoY + 'px';
    }

    // Adicionar evento de redimensionamento ao movimentar o mouse
    document.addEventListener('mousemove', redimensionar);

    // Função para encerrar o redimensionamento
    function encerrarRedimensionamento() {
        // Remover o evento de redimensionamento
        document.removeEventListener('mousemove', redimensionar);
        // Remover o evento de encerramento do redimensionamento
        document.removeEventListener('mouseup', encerrarRedimensionamento);
    }

    // Adicionar evento de encerramento do redimensionamento ao soltar o botão do mouse
    document.addEventListener('mouseup', encerrarRedimensionamento);
}

// Adicionar evento de clique ao input para iniciar o redimensionamento
document.getElementById('ocupacao').addEventListener('mousedown', iniciarRedimensionamento);