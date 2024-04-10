function mostrarConteudo(aba) {
    if (aba === 'aba1') {
        document.getElementById('conteudoAba1').style.visibility = 'visible';
        document.getElementById('conteudoAba1').style.display = 'flex'; // ou 'block', dependendo do layout desejado
        document.getElementById('conteudoAba2').style.visibility = 'hidden';
        document.getElementById('conteudoAba2').style.display = 'none';
    } else if (aba === 'aba2') {
        document.getElementById('conteudoAba1').style.visibility = 'hidden';
        document.getElementById('conteudoAba1').style.display = 'none';
        document.getElementById('conteudoAba2').style.visibility = 'visible';
        document.getElementById('conteudoAba2').style.display = 'flex'; // ou 'block', dependendo do layout desejado
    }
}   