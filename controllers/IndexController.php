<?php

require "../config/Conexao.php";
require "../models/Admin.php";

class IndexController{
    private $admin;

    public function __construct()
    {
        $conexao = New Conexao();
        $pdo = $conexao->conectar();

        $this->admin = new Admin($pdo);
    }

    public function verificacao($email, $senha){
        

    
        $dadosAdmin = $this->admin->getEmailAdmin($email);

        if(empty($dadosAdmin->id)){
            echo "<script>mensagem('Administrador inválido','index','error')</script>";
            exit;
        }else if(!password_hash($senha, $dadosAdmin->senha)){
            echo "<script>mensagem('Senha inválida','index','error')</script>";
            exit;
        }else{
            $_SESSION["Admin"] = array(
                "id" => $dadosAdmin->id,
                "nome" => $dadosAdmin->nome
            );
            echo "<script>location.href='index'</script>";
        }
    }    
}