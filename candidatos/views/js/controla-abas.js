document.addEventListener('DOMContentLoaded', function() {
    const abas = document.querySelectorAll('.aba');
    const tabContents = document.querySelectorAll('.tab-content');

    abas.forEach(aba => {
        aba.addEventListener('click', function() {
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
