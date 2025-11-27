<?php
require_once __DIR__ . '/../controllers/ProdutoController.php';

$produtoController = new ProdutoController();

if (isset($_POST["action"]) && $_POST["action"] == "salvar") {
    
    $produtoController->salvar();
    exit;
}


if (isset($_GET["action"]) && $_GET["action"] == "excluir") {
    $produtoController->excluir();
    exit;
}
