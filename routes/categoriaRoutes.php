<?php
session_start();
require "../controllers/CategoriaController.php";

$categoriaController = new CategoriaController();


if (isset($_POST["action"]) && $_POST["action"] == "salvar") {
    $categoriaController->salvar();


}


if (isset($_GET["action"]) && $_GET["action"] == "excluir") {
    $categoriaController->excluir();
    exit;
}