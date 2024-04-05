<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HR System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    


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
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <span class="navbar-brand">Sistema de RH</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Barra de navegação lateral -->
            <nav class="col-md-2 col-xxl-2 d-md-block sidebar custom-sidebar">
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
                                        <a class="nav-link" href="#">Candidatos</a>
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
                        <!-- Adicione mais itens de navegação conforme necessário -->
                    </ul>
                </div>
            </nav>
            <!-- Conteúdo principal -->
            <main class="col-md-10 custom-main">
                <br>
                <div class="container-sm">
                    <h2>Candidatos</h2>
                </div>
                <br>

                <div class="container-sm">
                    <button type="submit" class="btn btn-primary" onclick="goToRegister()">Cadastrar</button>
                </div>
                <br>
                <form id="listUserForm" method="post">
                    <?php

                    include __DIR__ . '/../models/usuarios.class.php';



                    $usuarios = new User($pdo);
                    $usuarios = $user->listUsers();

                    if (is_array($usuarios) && !empty($usuarios)) {
                        echo "<div class='container mt-4'>";
                        echo "<table class='table table-bordered'>";
                        echo "<thead>
            <tr>
                <th>Nome</th>
                <th>Sobrenome</th>
                <th>E-mail</th>
                <th>Endereço</th>
                <th>Complemento</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
          </thead>";

                        foreach ($usuarios as $row) {
                            echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['lastname']}</td>
                <td>{$row['email']}</td>
                <td>{$row['adress']}</td>
                <td>{$row['complement']}</td>
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