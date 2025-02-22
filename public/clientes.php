<?php include('../config/db.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>

<div class="d-flex">
    <?php include('sidebar.php'); ?>

    <div class="container mt-5">
        <h2>Cadastrar Cliente</h2>
        <form id="clienteForm" method="POST" action="clientes.php">

            <div class="col-md-5 mb-3">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="col-md-5 mb-3">
                <label>CPF</label>
                <input type="text" name="cpf" class="form-control" required>
            </div>

            <div class="col-md-5 mb-3">
                <label>Endereço</label>
                <input type="text" name="endereco" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Cadastrar</button>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </form>

        <h3 class="mt-5">Clientes Cadastrados</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $conn->query("SELECT * FROM clientes");
            while ($cliente = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$cliente['nome']}</td>
                    <td>{$cliente['cpf']}</td>
                    <td>{$cliente['endereco']}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class='btn btn-sm edit-btn' 
                            data-id='{$cliente['id']}'
                            data-nome='{$cliente['nome']}'
                            data-cpf='{$cliente['cpf']}'
                            data-endereco='{$cliente['endereco']}'>
                            <i class='bi bi-pencil-square' style='font-size: 20px;'></i>
                        </button>

                        <!-- Delete Button -->
                        <button class='btn  btn-sm delete-btn' data-id='{$cliente['id']}'>
                            <i class='bi bi-trash' style='font-size: 20px'></i>
                        </button>
                    </td>
                  </tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de Edição -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editClienteForm" method="POST" action="clientes.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_nome" class="form-label">Nome</label>
                        <input type="text" name="edit_nome" id="edit_nome" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_cpf" class="form-label">CPF</label>
                        <input type="text" name="edit_cpf" id="edit_cpf" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_endereco" class="form-label">Endereço</label>
                        <input type="text" name="edit_endereco" id="edit_endereco" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="update" class="btn btn-primary">Salvar Alterações</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Abrir Modal com Dados
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        const nome = $(this).data('nome');
        const cpf = $(this).data('cpf');
        const endereco = $(this).data('endereco');

        $('#edit_id').val(id);
        $('#edit_nome').val(nome);
        $('#edit_cpf').val(cpf);
        $('#edit_endereco').val(endereco);

        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    });

    // Excluir Cliente
    $(document).on('click', '.delete-btn', function () {
        if (confirm('Tem certeza que deseja excluir este cliente?')) {
            const id = $(this).data('id');
            window.location.href = `clientes.php?delete_id=${id}`;
        }
    });

    // Validação CPF no Formulário Principal
    $('#clienteForm').on('submit', function(e) {
        let cpf = $('input[name="cpf"]').val();
        if (cpf.length != 11) {
            e.preventDefault();
            alert("CPF deve conter 11 dígitos.");
        }
    });
</script>

</body>
</html>

<?php
// Inserção no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $endereco = $_POST['endereco'];

    try {
        $sql = "INSERT INTO clientes (nome, cpf, endereco) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome, $cpf, $endereco]);

        header("Location: clientes.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar cliente: " . $e->getMessage();
    }
}

// Atualizar Cliente
if (isset($_POST['update'])) {
    $id = $_POST['edit_id'];
    $nome = $_POST['edit_nome'];
    $cpf = $_POST['edit_cpf'];
    $endereco = $_POST['edit_endereco'];

    try {
        $sql = "UPDATE clientes SET nome = ?, cpf = ?, endereco = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome, $cpf, $endereco, $id]);

        header("Location: clientes.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar cliente: " . $e->getMessage();
    }
}

// Excluir Cliente
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    try {
        $sql = "DELETE FROM clientes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        header("Location: clientes.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao excluir cliente: " . $e->getMessage();
    }
}
?>
