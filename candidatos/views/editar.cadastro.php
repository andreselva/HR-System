<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" style="background-color: #222831;">
    <title>HR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/style.css">

</head>

<body>

    <?php

    include __DIR__ . '/../models/candidatos.class.php';

    // Verifique se o ID do usuário foi passado via GET na URL
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
    } else {
        // Se o ID do usuário não estiver definido, redirecione ou mostre uma mensagem de erro
        echo "ID do usuário não fornecido.";
        exit; // Saia do script para evitar processamento adicional
    }


    $candidate = $candidate->getCandidateById($userId);

    $name = $candidate['name'];
    $lastname = $candidate['lastname'];
    $username = $candidate['username'];
    $email = $candidate['email'];
    $password = $candidate['password'];
    $address = $candidate['address'];
    $complement = $candidate['complement'];
    $city = $candidate['city'];
    $state = $candidate['state'];

    ?>

    <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>">

    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg" id="nav-principal">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <span class="navbar-brand" id="hr-system">Sistema de RH</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Barra de navegação lateral -->
            <nav class="col-md-2 col-xxl-2 d-md-block sidebar custom-sidebar" id="nav-lateral">
                <div class="position-sticky" id="elementos-nav-lateral">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#cadastrosMenu" id="elem-nav-lat">
                                Cadastros
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="collapse" id="cadastrosMenu">
                                <ul class="nav flex-column ml-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" id="elem-nav-lat">Candidatos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" id="elem-nav-lat">Vagas</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="elem-nav-lat">Configurações <i class="fas fa-cogs" id="elem-nav-lat"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="elem-nav-lat">Relatórios <i class="fas fa-chart-bar" id="elem-nav-lat"></i></a>
                        </li>

                    </ul>
                </div>
            </nav>
            <!-- Conteúdo principal -->
            <main class="col-md-10 custom-main" id="main-form-user-edit">
                <form id="editUserForm" class="row g-3" method="post">

                    <h4 style="padding-bottom: 20px;"><?php echo $name ?></h4>
                    <div class="col-md-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" placeholder="Insira seu nome..." required>
                    </div>
                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Sobrenome</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname; ?>" placeholder="Insira seu sobrenome..." required>
                    </div>
                    <div class="col-md-3">
                        <label for="username" class="form-label">Nome de usuário</label>
                        <div class="input-group">
                            <div class="input-group-text">@</div>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" placeholder="Username" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" placeholder="Insira seu melhor e-mail..." required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" value="<?php echo $password; ?>" name="password" required>
                    </div>
                    <div class="col-7">
                        <label for="address" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
                    </div>
                    <div class="col-5">
                        <label for="complement" class="form-label">Complemento</label>
                        <input type="text" class="form-control" id="complement" value="<?php echo $complement; ?>" name="complement">
                    </div>
                    <div class="col-md-6">
                        <label for="city" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo $city; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="state" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="state" name="state" value="<?php echo $state; ?>">
                    </div>
                    <div class="col-md-3">
                        <div>
                            <button class="btn btn-primary" onclick="salvarEdicao(id, event)">Salvar</button>
                            <button class="btn btn-danger" onclick="cancelEdit(event)">Cancelar</button>
                        </div>
                    </div>
                </form>

            </main>
        </div>
    </div>

    <script src="form.cadastro.usuario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="sweetalert2/package/dist /sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>