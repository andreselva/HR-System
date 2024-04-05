function goToEdition(id, event) {
    event.preventDefault();
    window.location.href = './editar.cadastro.php?id=' + id;
}

function goToRegister() {
    window.location.href = './form.cadastro.usuarios.php';
}

function cancelEdit(event) {
    event.preventDefault();
    window.location.href = './listagem.cadastros.php';
}

async function confirmSweet(mensagem, tipo) {
    let resultado;

    if (tipo === 'saving') {
        const { value: confirmado } = await Swal.fire({
            icon: 'question',
            title: 'Confirmação',
            text: mensagem,
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
        });

        resultado = confirmado;
    }

    if (tipo === 'warning') {
        const { value: deletar } =
            await Swal.fire({
                icon: 'warning',
                title: 'Cuidado...',
                text: mensagem,
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
            });

        resultado = deletar;
    }

    if (tipo === 'warning_dois') {
        const { value: aceitar } = await Swal.fire({
            icon: 'warning',
            title: 'Atenção!',
            text: mensagem,
            showCancelButton: false,
            confirmButtonText: 'Ok',
            cancelButtonText: 'Não',
        });

        resultado = aceitar;
    }
    return resultado;
}


async function cadastrarUsuario(event) {
    let campoVazio = null;

    event.preventDefault();

    const form_cadastro = document.querySelector('#userForm');
    const campos = ['name', 'lastname', 'username', 'email', 'password', 'adress', 'complement', 'city', 'state'];

    for (const campo of campos) {
        const elemento = document.querySelector(`#${campo}`);

        if (!elemento) {
            console.error(`Elemento com ID '${campo}' não encontrado.`);
            break;  // Pular para o próximo campo se o elemento não for encontrado
        }

        const valor = elemento.value.trim();

        if (valor === '') {
            await confirmSweet('Todos os campos devem ser preenchidos!', 'warning_dois');
            campoVazio = elemento;
            return setTimeout(() => campoVazio.focus(), 260);
        }

    }

    try {
        const confirmado = await confirmSweet('O usuário será cadastrado. Deseja prosseguir?', 'saving');
        if (!confirmado) return;

        const formData = new FormData(form_cadastro);
        formData.append('action', 'cadastrar');
        const data = {
            action: 'cadastrar',
        };

        formData.forEach((value, key) => {
            data[key] = value;
        });

        const response = await fetch('../models/usuarios.class.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error('Erro ao cadastrar usuário!');
        }

        Swal.fire({
            title: "",
            text: 'Cadastro realizado com sucesso!',
            icon: "success"
        }).then(() => {
            window.location.href = './listagem.cadastros.php';
        });

        const responseData = await response.json(); // Aqui está a segunda chamada de response.json()
        console.log(responseData);

    } catch (error) {
        console.error('Erro no fetch:', error);
        return;
    }
}

async function excluirUsuario(id, event) {
    event.preventDefault();

    const formCadastro = document.querySelector('#listUserForm');

    try {
        const deletar = await confirmSweet('O usuário será excluído permanentemente. Deseja prosseguir?', 'warning');
        if (!deletar) return;

        const formData = new FormData(formCadastro);
        const data = {
            action: 'excluir',
            id: id,
        };

        const response = await fetch('../models/usuarios.class.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            throw new Error('Erro ao excluir usuário!');
        }
        Swal.fire({
            title: "",
            text: 'Usuário excluído com sucesso!',
            icon: "success"
        }).then(() => {
            window.location.reload();
        });

        const responseData = await response.json();
        console.log(responseData);

    } catch (error) {
        console.error('Erro no fetch:', error);
        alert('Ocorreu um erro ao excluir usuário.');
    }
}

async function salvarEdicao(id, event) {
    event.preventDefault();

    const formEdition = document.querySelector('#editUserForm');
    const userId = document.querySelector('#userId').value;

    try {

        const confirmado = await confirmSweet('Depois de salvar, todos os dados alterados serão salvos. Deseja continuar?', 'saving');
        if (!confirmado) return;

        const formData = new FormData(formEdition);
        formData.append('action', 'editar');
        formData.append('id', userId); // Enviar o ID do usuário

        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        const response = await fetch('../models/usuarios.class.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            console.error('Erro ao salvar edição!');
        }
        Swal.fire({
            title: "",
            text: 'Dados alterados!',
            icon: "success"
        }).then(() => {
            window.location.href = './listagem.cadastros.php';
        });

        const responseData = await response.json();
        console.log(responseData);

    } catch (error) {
        console.error('Erro no fetch:', error);
        alert('Ocorreu um erro ao salvar.');
    }
}

