<?php
$current_page = basename($_SERVER['PHP_SELF']); // Captura o nome do arquivo atual
?>

<div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; height: 100vh;">
    <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
        <span class="fs-4">Menu Principal</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="index.php" class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : 'text-white'; ?>" aria-current="page">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"/></svg>
                Home
            </a>
        </li>
        <li>
            <a href="clientes.php" class="nav-link <?php echo ($current_page == 'clientes.php') ? 'active' : 'text-white'; ?>">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#people-circle"/></svg>
                Clientes
            </a>
        </li>
        <li>
            <a href="produtos.php" class="nav-link <?php echo ($current_page == 'produtos.php') ? 'active' : 'text-white'; ?>">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#grid"/></svg>
                Produtos
            </a>
        </li>
        <li>
            <a href="ordens.php" class="nav-link <?php echo ($current_page == 'ordens.php') ? 'active' : 'text-white'; ?>">
                <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"/></svg>
                Ordens de Serviço
            </a>
        </li>
    </ul>
    <hr>
    <a href="index.php" class="d-flex align-items-center text-white text-decoration-none">
        <strong>Voltar ao Início</strong>
    </a>
</div>
