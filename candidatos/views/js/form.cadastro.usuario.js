
function goToEdition(id, event) {
    event.preventDefault();
    window.location.href = './editar.cadastro.php?id=' + id;
}

function goToRegister(event) {
    event.preventDefault();
    window.location.href = './form.cadastro.usuarios.php';
}

async function cancelEdit(event) {
    event.preventDefault();

    //Verifica se é a edição de um cadastro ou se é um novo cadastro. Se for um novo cadastro, não retorna o alert.
    if (typeof window.location.search !== 'undefined' && window.location.search !== null) {
        let params = new URLSearchParams(window.location.search);
        if (params.has('id')) {
            const cancelar = await confirmSweet('Todas as alterações realizadas serão perdidas. Deseja continuar?', 'cancel');
            if (!cancelar) return;
        }

        window.location.href = './listagem.cadastros.php';

    }
}


function formatarCPF(input) {
    let cpf = input.value.replace(/\D/g, '');
    cpf = cpf.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
    input.value = cpf;
}

async function verificaCampos(campos) {
    for (const campo of campos) {
        const elemento = document.querySelector(`#${campo}`);

        if (!elemento) {
            Swal.fire({
                title: "Erro!",
                text: `Elemento com ID '${campo}' não encontrado.`,
                icon: "error"
            }).then(() => {
                return;
            });
        }

        const valor = await elemento.value.trim();

        if (valor === '') {
            await confirmSweet('Todos os campos devem ser preenchidos!', 'warning_dois');
            campoVazio = elemento;
            return setTimeout(() => campoVazio.focus(), 260);
        }
    }
}


async function cadastrarUsuario(event) {
    event.preventDefault();
    let campoVazio = null;
    const form_cadastro = document.querySelector('#registration-form');
    const campos = ['name', 'cpf', 'rg', 'username', 'email', 'cep', 'password', 'address', 'complement', 'city', 'state'];
    verificaCampos(campos);

    try {
        const salvar = await confirmSweet('O cliente será cadastrado. Deseja prosseguir?', 'saving');
        if (!salvar) return;
        
        const formData = new FormData(form_cadastro);
        formData.append('action', 'cadastrar');
        const data = {
            action: 'cadastrar',
        };

        formData.forEach((value, key) => {
            data[key] = value;
        });

        const response = await fetch('../repository/CandidateRepository.php', {
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

        const responseData = await response.json();
        console.log(responseData);

    } catch (error) {
        console.error('Erro no fetch:', error);
        return;
    }
}

async function excluirUsuario(id, event) {
    event.preventDefault();
    const formCadastro = document.querySelector('#listing-form');

    try {
        const deletar = await confirmSweet('O usuário será excluído permanentemente. Deseja prosseguir?', 'warning');
        if (!deletar) return;

        const formData = new FormData(formCadastro);
        const data = {
            action: 'excluir',
            id: id,
        };

        const response = await fetch('../repository/CandidateRepository.php', {
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
        if (!responseData) {
            console.error(`Erro ${responseData}`)
        }

        console.log(responseData);

    } catch (error) {
        console.error('Erro no fetch:', error);
        alert('Ocorreu um erro ao excluir usuário.');
    }
}

async function salvarEdicao(id, event) {
    event.preventDefault();

    const formEdition = document.querySelector('#edit-form');
    const userId = document.querySelector('#userId').value;

    try {
        const salvar = await confirmSweet('Todos os dados alterados serão salvos. Deseja continuar?', 'saving');
        if (!salvar) return;

        const formData = new FormData(formEdition);
        formData.append('action', 'editar');
        formData.append('id', userId); // Enviar o ID do usuário

        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        const response = await fetch('../repository/CandidateRepository.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            console.error('Erro ao salvar edição!');
        }

        const responseData = await response.json();

        if (!responseData) {
            console.error(`Erro ${responseData}`)
        }

        console.log(responseData);

        Swal.fire({
            title: "",
            text: 'Dados alterados!',
            icon: "success"
        }).then(() => {
            window.location.href = './listagem.cadastros.php';
        });

    } catch (error) {
        console.error('Erro no fetch:', error);
        Swal.fire({
            title: "",
            text: `Erro ao editar. Verifique o response!`,
            icon: "error"
        }).then(() => {
            return;
        });
    }
}


async function confirmSweet(mensagem, tipo) {
    let resultado;

    if (tipo === 'saving') {
        const { value: salvar } =
            await Swal.fire({
                icon: 'question',
                title: 'Confirmação',
                text: mensagem,
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
            });

        resultado = salvar;
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
        const { value: aceitar } =
            await Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: mensagem,
                showCancelButton: false,
                confirmButtonText: 'Ok',
                cancelButtonText: 'Não',
            });

        resultado = aceitar;
    }

    if (tipo === 'cancel') {
        const { value: cancelar } =
            await Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: mensagem,
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
            })

        resultado = cancelar;
    }
    return resultado;
}