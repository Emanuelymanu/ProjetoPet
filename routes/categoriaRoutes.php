<?php
session_start();
require "../controllers/CategoriaController.php";

$categoriaController = new CategoriaController();

if (isset($_POST["action"]) && $_POST["action"] == "salvar") {
    $categoriaController->salvar();
    header("Location: ../public/painel2.php");
    exit;
}