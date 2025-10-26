<?php
require "../controllers/CategoriaController.php";

$categoriaController = new CategoriaController();

if (isset($_POST["action"]) && $_POST["action"] == "salvar") {
    $categoriaController->salvar();
    header("Location: ../views/categoria/listar.php");
}