<?php

require "../config/Conexao.php";
require "../models/Admin.php";

class IndexController
{
    private $admin;

    public function __construct()
    {
        $conexao = new Conexao();
        $pdo = $conexao->conectar();

        $this->admin = new Admin($pdo);
    }



    public function verificacao($email, $senha)
    {
        $dadosAdmin = $this->admin->getEmailAdmin($email);

        if (empty($dadosAdmin->id)) {
            echo "<script>mensagem('Administrador inválido','index','error')</script>";
            exit;
        } else if (!password_verify($senha, $dadosAdmin->senha)) {
            echo "<script>mensagem('Senha inválida','index','error')</script>";
            exit;
        } else {
            $_SESSION["admin"] = array(
                "id" => $dadosAdmin->id,
                "nome" => $dadosAdmin->nome
            );
            echo "<script>location.href='index'</script>";
        }
    }

    public function validarLoginAdmin()
    {
        session_start();
        if (!isset($_SESSION["admin"]) || empty($_SESSION["admin"]["id"])) {
            echo "<script>mensagem('Acesso negado! Faça login para continuar.','../view/login/index.php','error')</script>";
            exit;
        } else {
            echo "<script>mensagem('Bem-vindo!','../views/painelAdmin/painel2.php','success')</script>";
        }
    }

    public function cadastrarNovoUsuario()
    {
        try {
            if (!isset($_POST['email']) || !isset($_POST['senha'])) {
                return ['status' => 'error', 'message' => 'Email e senha são obrigatórios'];
            }

            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            if (!$email) {
                return ['status' => 'error', 'message' => 'Email inválido'];
            }

            if (strlen($_POST['senha']) < 6) {
                return ['status' => 'error', 'message' => 'A senha deve ter no mínimo 6 caracteres'];
            }

            // Verificar se o email já existe
            if ($this->admin->getEmailAdmin($_POST['email'])) {
                return ['status' => 'error', 'message' => 'Este email já está cadastrado'];
            }

            $senhaHash = password_hash($_POST['senha'], PASSWORD_BCRYPT);

            if ($this->admin->cadastrarUsuario($_POST['email'], $senhaHash)) {
                return ['status' => 'success', 'message' => 'Usuário cadastrado com sucesso'];
            } else {
                return ['status' => 'error', 'message' => 'Erro ao cadastrar usuário'];
            }

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Erro interno: ' . $e->getMessage()];
        }
    }

    /*public function verificarLogin($email, $senha)
    {
        try {
            $dadosAdmin = $this->admin->verificarLogin($email, $senha);

            if (empty($dadosAdmin->id)) {
                return ['status' => 'error', 'message' => 'Administrador inválido'];
            } else {
                $_SESSION["admin"] = array(
                    "id" => $dadosAdmin->id,
                    "nome" => $dadosAdmin->nome
                );
                return ['status' => 'success', 'message' => 'Login realizado com sucesso'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Erro interno: ' . $e->getMessage()];
        }
    }*/
    public function index()
    {

    }

    public function verificar($dados)
    {

        $email = $dados["email"] ?? NULL;
        $senha = $dados["senha"] ?? NULL;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>mensagem('Digite um e-mail válido','error','')</script>";
            exit;
        } else if (empty($senha)) {
            echo "<script>mensagem('Senha inválida','error','')</script>";
            exit;
        }

        $dadosAdmin = $this->admin->getEmailAdmin($email, $senha);


        if (empty($dadosAdmin->id)) {
            echo "<script>mensagem('Usuário inválido','error','')</script>";
            exit;
        } else if (!password_verify($senha, $dadosAdmin->senha)) {


            echo "<script>
            mensagem('Senha inválida','error','')
            </script>";
            exit;
        } else {
            $_SESSION["admin"] = array(
                "id" => $dadosAdmin->id,
                "nome" => $dadosAdmin->nome
            );
            echo "<script>location.href='index.php'</script>";
        }


    }

}