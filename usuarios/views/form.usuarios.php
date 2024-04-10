<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="sweetalert2/package/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="estilos/style.css">

    <style>
        .custom-sidebar {
            width: 200px;
            /* Ajuste a largura conforme necessário */
        }

        .custom-main {
            flex: 0 0 80%;
            /* Ajuste a largura conforme necessário */
            max-width: 100%;
            /* Ajuste a largura conforme necessário */
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg bg-dark" id="nav-cabecalho">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <span class="navbar-brand" style="color: white">Sistema de RH</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Barra de navegação lateral -->
            <nav class="col-md-2 col-xxl-2 d-md-block bg-dark sidebar custom-sidebar" id="nav-lateral">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#cadastrosMenu">
                                Cadastros
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="collapse" id="cadastrosMenu">
                                <ul class="nav flex-column ml-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/../../HR-System/HR-System/candidatos/views/listagem.cadastros.php">Candidatos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Vagas</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Configurações <i class="fas fa-cogs"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Relatórios <i class="fas fa-chart-bar"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- Conteúdo principal -->
            <main class="col-md-8 custom-main">
                <br>
                <div class="container-fluid">
                    <h2 id="h2-cadastro-usuario">Cadastrar usuário</h2>
                </div>
                <br>
                <div class=" container-fluid" style="margin:auto; width:700px;" id="form-usuarios">
                    <div id="abas">
                        <button id="aba1" onclick="mostrarConteudo('aba1')">Aba 1</button>
                        <button id="aba2" onclick="mostrarConteudo('aba2')">Aba 2</button>
                    </div>
                    <form id="userForm" class="row g-3" method="post">
                        <!-- Conteúdo da aba 1 -->
                        <div id="conteudoAba1" class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Insira seu nome..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Insira seu melhor e-mail..." required>
                            </div>
                            <div class="col-md-5">
                                <label for="username" class="form-label">Nome de usuário</label>
                                <div class="input-group">
                                    <div class="input-group-text">@</div>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <!-- Conteúdo da aba 2 -->
                        <div id="conteudoAba2" class="row g-3" style="display: none;">
                            <!-- Adicione o conteúdo da aba 2 aqui, mantendo a mesma estrutura -->
                        </div>
                        <div class="col-md-4">
                            <div>
                                <button class="btn btn-primary" onclick="cadastrarUsuario(event)">Cadastrar</button>
                                <button class="btn btn-danger" onclick="cancelEdit(event)">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="sweetalert2/package/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="form.usuarios.js"></script>
</body>

</html>