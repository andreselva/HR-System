<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" style="background-color: #222831;">
    <title>HR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estilos/forms.css">
    <link rel="stylesheet" href="estilos/buttons.css">
    <link rel="stylesheet" href="estilos/inputs.css">

</head>

<body>

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
                                        <a class="nav-link" href="listagem.cadastros.php" id="elem-nav-lat">Candidatos</a>
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
            <main id="main-form-user">
                <form id="listing-form" method="post">
                    <h4 style="padding-bottom: 40px;">Candidatos</h4>
                    <div class="print-search">
                        <div id="btn-register-user">
                            <button type="submit" class="button-cadastrar" onclick="goToRegister(event)">Cadastrar</button>
                        </div>
                        <div class="btn-impressora-pesquisa">
                            <div>
                                <button class="download-btn">
                                    <svg id="download" viewBox="0 0 24 24" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.29,17.29,13,18.59V13a1,1,0,0,0-2,0v5.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l3-3a1,1,0,0,0-1.42-1.42ZM18.42,6.22A7,7,0,0,0,5.06,8.11,4,4,0,0,0,6,16a1,1,0,0,0,0-2,2,2,0,0,1,0-4A1,1,0,0,0,7,9a5,5,0,0,1,9.73-1.61,1,1,0,0,0,.78.67,3,3,0,0,1,.24,5.84,1,1,0,1,0,.5,1.94,5,5,0,0,0,.17-9.62Z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                            <div class="search">
                                <input type="text" class="search__input" placeholder="Type your text">
                                <button class="search__button">
                                    <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                                        <g>
                                            <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>


                    <?php

                    require_once __DIR__ . '/../src/repository/CandidateRepository.php';
                    require_once __DIR__ . '/../src/entity/Candidate.php';


                    $getCandidates = new CandidateRepository();
                    $usuarios = $getCandidates->listCandidates();


                    if (is_array($usuarios) && !empty($usuarios)) {

                    ?>
                        <div class='table-container' style='padding-top: 10px;' id='table-users'>
                            <table class='table table-bordered table-rounded'>
                                <thead>
                                    <tr>
                                        <th>
                                            <div class='form-check' id='checkbox-table'>
                                                <input class='form-check-input' type='checkbox' value='' id='flexCheckDefault'>
                                                <label class='form-check-label' for='flexCheckDefault'></label>
                                            </div>
                                        </th>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>RG</th>
                                        <th>E-mail</th>
                                        <th>CEP</th>
                                        <th>Endereço</th>
                                        <th>Cidade</th>
                                        <th>Estado</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <?php foreach ($usuarios as $row) : ?>
                                    <tr>
                                        <td>
                                            <div class='form-check' id='checkbox-table'>
                                                <input class='form-check-input' type='checkbox' value='' id='flexCheckDefault'>
                                                <label class='form-check-label' for='flexCheckDefault'></label>
                                            </div>
                                        </td>
                                        <td><?= $row->getName() ?></td>
                                        <td><?= $row->getCPF() ?></td>
                                        <td><?= $row->getRG() ?></td>
                                        <td><?= $row->getEmail() ?></td>
                                        <td><?= $row->getCEP() ?></td>
                                        <td><?= $row->getAddress() ?></td>
                                        <td><?= $row->getCity() ?></td>
                                        <td><?= $row->getState() ?></td>
                                        <td>
                                            <button class='editBtn' onclick='goToEdition(<?= $row->getId() ?>, event)'>
                                                <svg height='1em' viewBox='0 0 512 512'>
                                                    <path d='M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 
                                                    89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 
                                                    480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 
                                                    27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 
                                                    6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 
                                                    18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 
                                                    14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 
                                                    144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z'>
                                                    </path>
                                                </svg>
                                            </button>
                                            <button class='button' onclick='excluirUsuario(<?= $row->getId() ?>, event)'>
                                                <svg viewBox='0 0 448 512' class='svgIcon'>
                                                    <path d='M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 
                                                96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 
                                                0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 
                                                47.9-45L416 128z'></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            } ?>
                </form>
            </main>
        </div>
    </div>

    <script src="./js/form.cadastro.usuario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="sweetalert2/package/dist /sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>