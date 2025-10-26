<?php
session_start();

require '../controllers/usuariosController.php';

$CadastroControll = new UsuariosController();
$validarLogin = new UsuariosController();


if (isset($_POST['action']) && $_POST['action'] === 'cadastrar') {
    $result = $CadastroControll->cadastrarNovoUsuario();
    header('location: ../views/painelAdmin/painel2.php');
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'login'){
    $result= $validarLogin->verificarLogin();
    header();('location: ../views/painelAdmin/painel2.php');
    exit;
}
