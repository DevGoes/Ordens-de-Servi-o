<?php include('../config/db.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<div class="d-flex">
    <?php include('sidebar.php'); ?>

    <div class="container mt-5">
        <h2>Cadastrar Produtos</h2>
        <form id="produtoForm" method="POST" action="produtos.php">
            <div class="col-md-5  mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" name="codigo" class="form-control" id="codigo" required>
            </div>

            <div class="col-md-5 mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" name="descricao" id="descricao" rows="3" required></textarea>
            </div>

            <div class="col-md-5 mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" id="status" required>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Cadastrar</button>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </form>

        <h3 class="mt-5">Produtos Cadastrados</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $conn->query("SELECT * FROM produtos");
            while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$produto['codigo']}</td>
                    <td>{$produto['descricao']}</td>
                    <td>{$produto['status']}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class='btn btn-sm edit-btn' 
                            data-id='{$produto['id']}'
                            data-codigo='{$produto['codigo']}'
                            data-descricao='{$produto['descricao']}'
                            data-status='{$produto['status']}'>
                            <i class='bi bi-pencil-square' style='font-size: 20px;'></i>
                        </button>

                        <!-- Delete Button -->
                        <button class='btn  btn-sm delete-btn' data-id='{$produto['id']}'>
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

<!-- Modal de Edição de Produto -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editProdutoForm" method="POST" action="produtos.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_codigo" class="form-label">Código</label>
                        <input type="text" name="edit_codigo" id="edit_codigo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" name="edit_descricao" id="edit_descricao" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" name="edit_status" id="edit_status" required>
                            <option value="Ativo">Ativo</option>
                            <option value="Inativo">Inativo</option>
                        </select>
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
    // Abrir Modal com Dados para Edição
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        const codigo = $(this).data('codigo'); // Agora funciona
        const descricao = $(this).data('descricao');
        const status = $(this).data('status');

        $('#edit_id').val(id);
        $('#edit_codigo').val(codigo);
        $('#edit_descricao').val(descricao);
        $('#edit_status').val(status);

        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    });

    // Confirmação Antes de Excluir Produto
    $(document).on('click', '.delete-btn', function () {
        if (confirm('Tem certeza que deseja excluir este produto?')) {
            const id = $(this).data('id');
            window.location.href = `produtos.php?delete_id=${id}`;
        }
    });

    // Validação ao Cadastrar Produto
    $('#produtoForm').on('submit', function (e) {
        let codigo = $('input[name="codigo"]').val().trim();
        let descricao = $('textarea[name="descricao"]').val().trim();
        let status = $('select[name="status"]').val();

        if (codigo.length < 5) {
            e.preventDefault();
            alert("O código deve conter pelo menos 5 caracteres.");
        } else if (descricao === '') {
            e.preventDefault();
            alert("A descrição não pode estar vazia.");
        } else if (status === '') {
            e.preventDefault();
            alert("Selecione o status do produto.");
        }
    });

</script>

</body>
</html>

<?php
// Inserção no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update'])) {
    $codigo = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];

    try {
        $sql = "INSERT INTO produtos (codigo, descricao, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$codigo, $descricao, $status]);

        header("Location: produtos.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar produto: " . $e->getMessage();
    }
}

// Atualizar Produto
if (isset($_POST['update'])) {
    $id = $_POST['edit_id'];
    $codigo = $_POST['edit_codigo'];
    $descricao = $_POST['edit_descricao'];
    $status = $_POST['edit_status'];

    try {
        $sql = "UPDATE produtos SET codigo = ?, descricao = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$codigo, $descricao, $status, $id]);

        header("Location: produtos.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar produto: " . $e->getMessage();
    }
}

// Excluir Produto
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    try {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        header("Location: produtos.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao excluir produto: " . $e->getMessage();
    }
}
?>


