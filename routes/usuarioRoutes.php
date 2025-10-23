<?php
session_start();

require '../controllers/usuariosController.php';

$CadastroControll = new UsuariosController();


if(isset($_POST['action']) && $_POST['action'] === 'cadastrar'){
    $result = $CadastroControll->cadastrarNovoUsuario();
   header ('location: ../public/painel2.php'); 
   exit;
}

