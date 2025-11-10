<?php
session_start();
require '../controllers/IndexController.php';
$CadastroControll = new IndexController();
$validarLogin = new IndexController();
if (isset($_POST['action']) && $_POST['action'] === 'cadastrar') {
    $result = $CadastroControll->cadastrarNovoUsuario();
    header('location: ../views/painelAdmin/painel2.php');
    exit;
}
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $validarLogin->verificar($_POST);
    header('location: ../public/painel2.php');
    exit;
}