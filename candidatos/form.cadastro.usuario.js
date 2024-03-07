function goToEdition(id, event) {
    event.preventDefault();
    window.location.href = './editar.cadastro.php?id=' + id;
    
}

function goToRegister() {
    window.location.href = './form.cadastro.usuarios.php';
}

function cancelEdit() {
    window.location.href = './listagem.cadastros.php';
}


async function cadastrarUsuario(event) {
    event.preventDefault();

    const form_cadastro = document.querySelector('#userForm');
    const campos = ['name', 'lastname', 'username', 'email', 'password', 'adress', 'complement', 'city', 'state'];

    for (const campo of campos) {
        const elemento = document.querySelector(`#${campo}`);

        if (!elemento) {
            console.error(`Elemento com ID '${campo}' não encontrado.`);
            continue;  // Pular para o próximo campo se o elemento não for encontrado
        }

        const valor = elemento.value.trim();

        if (valor === '') {
            alert('Todos os campos devem ser preenchidos!');
            return;
        }
    }

    try {
        const formData = new FormData(form_cadastro);
        formData.append('action', 'cadastrar');
        const data = {
            action: 'cadastrar',  // Adicione a ação aqui
        };

        formData.forEach((value, key) => {
            data[key] = value;
        });

        const response = await fetch('./usuarios.class.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error('Erro ao cadastrar usuário!');
        } else {
            window.location.href = './listagem.cadastros.php';
        }
        const responseData = await response.json();
        console.log(responseData);
        alert(responseData.message);

    } catch (error) {
        console.error('Erro no fetch:', error);
        alert('Ocorreu um erro ao cadastrar usuário.');
        return;
    }
}

async function excluirUsuario(id, event) {
    event.preventDefault();

    const formCadastro = document.querySelector('#listUserForm');

    try {
        const formData = new FormData(formCadastro);
        const data = {
            action: 'excluir',
            id: id,
        };

        const response = await fetch('./usuarios.class.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            throw new Error('Erro ao excluir usuário!');
        } else {
            window.location.reload();
        }

        const responseData = await response.json();
        console.log(responseData);
        alert(responseData.message);
    } catch (error) {
        console.error('Erro no fetch:', error);
        alert('Ocorreu um erro ao excluir usuário.');
    }
}

async function salvarUsuario(id, event) {
    event.preventDefault();

    const formEdition = document.querySelector('#editUserForm');

    try {
        const formData = new FormData(formEdition);
        formData.append('action', 'editar');
        formData.append('id', id);

        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        const response = await fetch('./usuarios.class.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            throw new Error('Erro ao salvar edição!');
        } else {
            window.location.href = './listagem.cadastros.php';
        }

        const responseData = await response.json();
        console.log(responseData);
        alert(responseData.message);
    } catch (error) {
        console.error('Erro no fetch:', error);
        alert('Ocorreu um erro ao salvar edição do usuário.');
    }
}
