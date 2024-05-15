<?php

require_once __DIR__ . '/../src/entity/Candidate.php';
require_once __DIR__ . '/../src/repository/CandidateRepository.php';
require_once __DIR__ . '/../src/functions/functions.php';

$userId = getId($_GET['id']);
$getCandidate = new CandidateRepository();
$candidate = $getCandidate->getCandidateById($userId);

?>

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
    <link rel="stylesheet" href="estilos/scrollbar.css">
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
            <main>
                <form id="edit-form" method="post" enctype="multipart/form-data">

                    <div>
                        <div class="row-img">
                            <h3 style="padding-bottom: 20px;"><?= $candidate->getName() ?></h3>
                            <div class="row-img-1">
                                <label for="inputImagem" class="botao-selecionar">Selecionar Imagem</label>
                                <input type="file" id="inputImagem" accept="image/*" value="">
                                <img id="imagemExibida" src="./img/img-teste.jpg">
                            </div>
                        </div>
                        <div class="abas-cadastro">
                            <div class="aba" data-tab="dados-pessoais">
                                <h6>Dados pessoais</h6>
                            </div>
                            <div class="aba" data-tab="experiencia-profissional">
                                <h6>Experiência profissional</h6>
                            </div>
                        </div>
                    </div>
                    <div id="dados-pessoais" class="tab-content">

                        <div class="row-1">
                            <div class="row-col-1">
                                <label for="name" class="user-label">Nome</label>
                                <input required="" type="text" id="name" name="name" autocomplete="off" class="input" value="<?= $candidate->getName() ?>">
                            </div>
                            <div class="row-col-2">
                                <label for="cpf">CPF</label>
                                <input type="text" id="cpf" name="cpf" placeholder="Insira seu CPF..." class="input" oninput="formatarCPF(this)" value="<?= $candidate->getCPF() ?>" required>
                            </div>
                            <div class="row-col-3">
                                <label for="name">RG</label>
                                <input type="text" id="rg" name="rg" placeholder="Insira seu RG..." class="input" value="<?= $candidate->getRG() ?>" required>
                            </div>
                        </div>
                        <div class="row-2">
                            <div class="row-col-4">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" placeholder="Insira seu melhor e-mail..." class="input" value="<?= $candidate->getEmail() ?>" required>
                            </div>
                            <div class="row-col-5">
                                <label for="password">Senha</label>
                                <input type="password" id="password" name="password" class="input" value="<?= $candidate->getPassword() ?>" required>
                            </div>
                            <div class="row-col-6">
                                <label for="username">Nome de usuário</label>
                                <input type="text" id="username" name="username" class="input" value="<?= $candidate->getUsername() ?>" required>
                            </div>
                        </div>
                        <div class="row-3">
                            <div>
                                <label for="username">CEP</label>
                                <div style="display: flex; align-items: center;">
                                    <input type="text" id="cep" name="cep" class="input" value="<?= $candidate->getCEP() ?>" required>
                                    <button style="border: none; background: none; cursor: pointer;">
                                        <i class="fas fa-map-marker-alt" style="font-size: 1.5em;"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row-col-7">
                                <label for="address">Endereço</label>
                                <input type="text" id="address" name="address" class="input" value="<?= $candidate->getAddress() ?>" required>
                            </div>
                            <div class="row-col-8">
                                <label for="complement">Complemento</label>
                                <input type="text" id="complement" name="complement" class="input" value="<?= $candidate->getComplement() ?>">
                            </div>
                        </div>
                        <div class="row-4">
                            <div class="row-col-9">
                                <label for="city">Cidade</label>
                                <input type="text" id="city" name="city" class="input" value="<?= $candidate->getCity() ?>">
                            </div>
                            <div class="row-col-10">
                                <label for="state">Estado</label>
                                <input type="text" id="state" name="state" class="input" value="<?= $candidate->getState() ?>">
                            </div>
                        </div>
                    </div>
                    <div id="experiencia-profissional" class="tab-content" style="display: none;">
                        <div class="row-exp">
                            <div>
                                <label>Currículo</label>
                                <input type="file">
                            </div>
                            <div class="row-5">
                                <div class="row-col-7">
                                    <label>Empresa</label>
                                    <input type="text" id="empresa" class="input">
                                </div>
                                <div class="row-col-7">
                                    <label>Ocupação</label>
                                    <input type="text" id="ocupacao" class="resizable-input">
                                </div>

                                <div class="row-col-10">
                                    <label>Último salário</label>
                                    <input type="text" id="ocupacao" class="input">
                                </div>

                                <div class="row-period">
                                    <label>Período</label>
                                    <div class="row-period-date">
                                        <input type="date" id="dt-one" class="input">
                                        <input type="date" id="dt-two" class="input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row-button">
                            <input type="hidden" id="userId" name="userId" value="<?php echo $userId; ?>">
                            <button class="button-cadastrar" onclick="salvarEdicao(id, event)">Salvar</button>
                            <button class="button-cancelar" onclick="cancelEdit(event)">Cancelar</button>
                        </div>
                    </div>
                </form>

            </main>
        </div>
    </div>

    <script src="./js/form.cadastro.usuario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="sweetalert2/package/dist /sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/controla-abas.js"></script>
    <script src="./js/controla-img.js"></script>
    <script src="./js/formataCPF.js"></script>
</body>

</html>