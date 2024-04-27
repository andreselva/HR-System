

// PRE VISUALIZACAO DA IMAGEM

document.getElementById('inputImagem').addEventListener('change', function() {
    const arquivo = this.files[0];
    if (arquivo) {
      const leitor = new FileReader();
      leitor.onload = function() {
        document.getElementById('imagemExibida').src = leitor.result;
      };
      leitor.readAsDataURL(arquivo);
    }
  });


  