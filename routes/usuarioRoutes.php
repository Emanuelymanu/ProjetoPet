<?php
session_start();
require '../controllers/IndexController.php';
$CadastroControll = new IndexController();
$validarLogin = new IndexController();
$controller = new IndexController();

if (isset($_POST['action']) && $_POST['action'] === 'cadastrar') {


    $result = $CadastroControll->cadastrarNovoUsuario();
  
   
}
if (isset($_POST['action']) && $_POST['action'] === 'login') {


    if ($validarLogin->verificar($_POST)) {

        header('location: ../public/painel2.php');
    } else {

        header('location: ../public/index.php');


    }
    exit;
}






