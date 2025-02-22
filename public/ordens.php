<?php include('../config/db.php'); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Ordens</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<div class="d-flex">
    <?php include('sidebar.php'); ?>

    <div class="container mt-5">
        <h2>Cadastrar Ordens</h2>
        <form id="ordemForm" method="POST" action="ordens.php">
            <div class="col-md-5 mb-3">
                <label>Número da Ordem</label>
                <input type="text" name="numeroOrdem" class="form-control" required>
            </div>

            <div class="col-md-5 mb-3">
                <label>Data de Abertura</label>
                <input type="date" name="dataAbertura" class="form-control" required>
            </div>

            <div class="col-md-5 mb-3">
                <label>Nome do Consumidor</label>
                <input type="text" name="nomeConsumidor" class="form-control" required>
            </div>

            <div class="col-md-5 mb-3">
                <label>CPF do Consumidor</label>
                <input type="text" name="cpfConsumidor" class="form-control" required>
            </div>

            <div class="col-md-5 mb-3">
                <label>Produto</label>
                <select class="form-select" name="produto_id" required>
                    <option value="">Selecione um Produto</option>
                    <?php
                    // Carregar produtos do banco
                    $produtos = $conn->query("SELECT id, descricao FROM produtos");
                    while ($produto = $produtos->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$produto['id']}'>{$produto['descricao']}</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Cadastrar</button>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </form>

        <h3 class="mt-5">Ordens Cadastradas</h3>
        <table class="table">
            <thead>
            <tr>
                <th>Número da Ordem</th>
                <th>Data de Abertura</th>
                <th>Nome do Consumidor</th>
                <th>CPF do Consumidor</th>
                <th>Produto</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $conn->query("SELECT o.id, o.numero_ordem, o.data_abertura, o.nome_consumidor, o.cpf_consumidor, p.descricao AS produto 
                                  FROM ordens o
                                  JOIN produtos p ON o.produto_id = p.id");
            while ($ordem = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$ordem['numero_ordem']}</td>
                    <td>{$ordem['data_abertura']}</td>
                    <td>{$ordem['nome_consumidor']}</td>
                    <td>{$ordem['cpf_consumidor']}</td>
                    <td>{$ordem['produto']}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class='btn btn-sm edit-btn' 
                            data-id='{$ordem['id']}'
                            data-numero_ordem='{$ordem['numero_ordem']}'
                            data-data_abertura='{$ordem['data_abertura']}'
                            data-nome_consumidor='{$ordem['nome_consumidor']}'
                            data-cpf_consumidor='{$ordem['cpf_consumidor']}'
                            data-produto='{$ordem['produto']}'>
                            <i class='bi bi-pencil-square' style='font-size: 20px;'></i>
                        </button>

                        <!-- Delete Button -->
                        <button class='btn btn-sm delete-btn' data-id='{$ordem['id']}'>
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

<!-- Modal de Edição de Ordem -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editOrdemForm" method="POST" action="ordens.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Ordem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="mb-3">
                        <label for="edit_numero_ordem" class="form-label">Número da Ordem</label>
                        <input type="text" name="edit_numero_ordem" id="edit_numero_ordem" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_data_abertura" class="form-label">Data de Abertura</label>
                        <input type="date" name="edit_data_abertura" id="edit_data_abertura" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_nome_consumidor" class="form-label">Nome do Consumidor</label>
                        <input type="text" name="edit_nome_consumidor" id="edit_nome_consumidor" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_cpf_consumidor" class="form-label">CPF do Consumidor</label>
                        <input type="text" name="edit_cpf_consumidor" id="edit_cpf_consumidor" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_produto" class="form-label">Produto</label>
                        <input type="text" name="edit_produto" id="edit_produto" class="form-control" readonly>
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
        const numero_ordem = $(this).data('numero_ordem');
        const data_abertura = $(this).data('data_abertura');
        const nome_consumidor = $(this).data('nome_consumidor');
        const cpf_consumidor = $(this).data('cpf_consumidor');
        const produto = $(this).data('produto');

        $('#edit_id').val(id);
        $('#edit_numero_ordem').val(numero_ordem);
        $('#edit_data_abertura').val(data_abertura);
        $('#edit_nome_consumidor').val(nome_consumidor);
        $('#edit_cpf_consumidor').val(cpf_consumidor);
        $('#edit_produto').val(produto);

        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    });

    // Confirmação Antes de Excluir Ordem
    $(document).on('click', '.delete-btn', function () {
        if (confirm('Tem certeza que deseja excluir esta ordem?')) {
            const id = $(this).data('id');
            window.location.href = `ordens.php?delete_id=${id}`;
        }
    });

    // Validação do CPF
    $('#ordemForm').on('submit', function(e) {
        let cpf = $('input[name="cpfConsumidor"]').val().trim();
        if (cpf.length != 11 || isNaN(cpf)) {
            e.preventDefault();
            alert("CPF deve conter exatamente 11 dígitos numéricos.");
        }
    });

</script>

</body>
</html>

<?php
// Inserção no banco
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update'])) {
    $numeroOrdem = $_POST['numeroOrdem'];
    $dataAbertura = $_POST['dataAbertura'];
    $nomeConsumidor = $_POST['nomeConsumidor'];
    $cpfConsumidor = $_POST['cpfConsumidor'];
    $produto_id = $_POST['produto_id'];

    try {
        $sql = "INSERT INTO ordens (numero_ordem, data_abertura, nome_consumidor, cpf_consumidor, produto_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$numeroOrdem, $dataAbertura, $nomeConsumidor, $cpfConsumidor, $produto_id]);

        header("Location: ordens.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao cadastrar ordem: " . $e->getMessage();
    }
}

// Atualizar Ordem
if (isset($_POST['update'])) {
    $id = $_POST['edit_id'];
    $numeroOrdem = $_POST['edit_numero_ordem'];
    $dataAbertura = $_POST['edit_data_abertura'];
    $nomeConsumidor = $_POST['edit_nome_consumidor'];
    $cpfConsumidor = $_POST['edit_cpf_consumidor'];

    try {
        $sql = "UPDATE ordens SET numero_ordem = ?, data_abertura = ?, nome_consumidor = ?, cpf_consumidor = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$numeroOrdem, $dataAbertura, $nomeConsumidor, $cpfConsumidor, $id]);

        header("Location: ordens.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao atualizar ordem: " . $e->getMessage();
    }
}

// Excluir Ordem
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    try {
        $sql = "DELETE FROM ordens WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        header("Location: ordens.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro ao excluir ordem: " . $e->getMessage();
    }
}
?>
