$estoque = new EstoqueController();

// Editar movimentação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'editar_movimentacao') {
$id_movimentacao = $_POST['id_movimentacao'] ?? null;
$id_produto = $_POST['id_produto'] ?? null;
$tipo_movimentacao = $_POST['status'] ?? null;
$quantidade = $_POST['quantidade'] ?? null;
$data_movimentacao = $_POST['data_movimentacao'] ?? date('Y-m-d H:i:s');
$observacao = $_POST['observacao'] ?? '';

if ($id_movimentacao && $id_produto && $tipo_movimentacao && $quantidade) {
$result = $estoque->editarMovimentacao($id_movimentacao, $id_produto, $tipo_movimentacao, $quantidade,
$data_movimentacao, $observacao);
if ($result) {
header('Location: ../views/estoque/index.php?edit_success=1');
exit;
} else {
header('Location: ../views/estoque/index.php?edit_error=1');
exit;
}
} else {
header('Location: ../views/estoque/index.php?edit_error=2');
exit;
}
}
<?php

require "../controllers/EstoqueController.php";


$estoque = new EstoqueController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'salvar_movimentacao') {
    $id_produto = $_POST['id_produto'] ?? null;
    $tipo_movimentacao = $_POST['status'] ?? null;
    $quantidade = $_POST['quantidade'] ?? null;
    $observacao = $_POST['observacao'] ?? '';

    if ($id_produto && $tipo_movimentacao && $quantidade) {
        $result = $estoque->insert($id_produto, $tipo_movimentacao, $quantidade, $observacao);
        if ($result) {
            header('Location: ../views/estoque/index.php?success=1');
            exit;
        } else {
            header('Location: ../views/estoque/index.php?error=1');
            exit;
        }
    } else {
        header('Location: ../views/estoque/index.php?error=2');
        exit;
    }
}