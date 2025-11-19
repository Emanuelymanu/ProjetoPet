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

    public function verificar($dados)
    {

        $email = $dados["email"] ?? NULL;
        $senha = $dados["senha"] ?? NULL;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>mensagem('E-mail inválido','error','')</script>";
            exit;
        } else if (empty($senha)) {
            echo "<script>mensagem('Senha inválida','error','')</script>";
            exit;
        }

        $dadosAdmin = $this->admin->getEmailAdmin($email);

        //  $senhaHash = password_hash($_POST['senha'], PASSWORD_BCRYPT);  

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


    public function index()
    {

    }






}