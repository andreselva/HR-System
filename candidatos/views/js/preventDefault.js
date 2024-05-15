function bloquearEnvio(event) {
    // Verifica se a tecla pressionada é Enter (código 13)
    if (event.keyCode === 13) {
        event.preventDefault();
    }
}