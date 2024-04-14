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
            <main class="col-md-10 custom-main" id="main-form-user">
                <form id="listUserForm" method="post">
                    <h4 style="padding-bottom: 40px;">Candidatos</h4>
                    <div id="btn-register-user">
                        <button type="submit" class="btn btn-primary" onclick="goToRegister(event)">Cadastrar</button>
                    </div>
                    <?php

                    include __DIR__ . '/../models/candidatos.class.php';


                    $usuarios = new Candidate($pdo);
                    $usuarios = $candidate->listCandidates();


                    if (is_array($usuarios) && !empty($usuarios)) {
                        echo "<div class='table-container' style='padding-top: 10px;' id='table-users'>";
                        echo "<table class='table table-bordered table-rounded'";
                        echo "<thead>
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
                            </thead>";

                        foreach ($usuarios as $row) {
                            echo "<tr>
                                    <td>
                                        <div class='form-check' id='checkbox-table'>
                                            <input class='form-check-input' type='checkbox' value='' id='flexCheckDefault'>
                                            <label class='form-check-label' for='flexCheckDefault'></label>
                                        </div>
                                    </td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['cpf']}</td>
                                    <td>{$row['rg']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['cep']}</td>
                                    <td>{$row['address']}</td>
                                    <td>{$row['city']}</td>
                                    <td>{$row['state']}</td>
                                    <td> 
                                        <button class='btn btn-primary' onclick='goToEdition({$row['id']}, event)'>Editar</button>
                                        <button class='btn btn-danger' onclick='excluirUsuario({$row['id']}, event)'>Excluir</button>
                                    </td>
                                </tr>";
                        }
                        echo "</table>";
                        echo "</div>";
                    }
                    ?>
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