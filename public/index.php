<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Home - Sistema de Ordens de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="d-flex">
    <?php include('sidebar.php'); ?>

    <div class="main-content">
        <div class="container mt-5">
            <h1 class="mb-4">Bem-vindo ao Sistema de Ordens de Serviço</h1>

            <div class="row g-3">
                <div class="col-md-4 d-flex">
                    <div class="card text-white bg-primary mb-3 h-100 w-100 d-flex flex-column">
                        <div class="card-body text-center flex-grow-1">
                            <h5 class="card-title">📋 Clientes</h5>
                            <p class="card-text">Gerencie seus clientes cadastrados.</p>
                        </div>
                        <div class="text-center mb-3">
                            <a href="clientes.php" class="btn btn-light">Acessar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 d-flex">
                    <div class="card text-white bg-success mb-3 h-100 w-100 d-flex flex-column">
                        <div class="card-body text-center flex-grow-1">
                            <h5 class="card-title">📦 Produtos</h5>
                            <p class="card-text">Adicione e edite seus produtos.</p>
                        </div>
                        <div class="text-center mb-3">
                            <a href="produtos.php" class="btn btn-light">Acessar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 d-flex">
                    <div class="card text-white bg-warning mb-3 h-100 w-100 d-flex flex-column">
                        <div class="card-body text-center flex-grow-1">
                            <h5 class="card-title">🛠️ Ordens de Serviço</h5>
                            <p class="card-text">Crie e gerencie ordens de serviço.</p>
                        </div>
                        <div class="text-center mb-3">
                            <a href="ordens.php" class="btn btn-light">Acessar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
