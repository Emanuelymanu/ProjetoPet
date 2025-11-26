<?php

require "../config/Conexao.php";
require "../models/UsuarioModel.php";

class IndexController
{
    private $usuario;

    public function __construct()
    {
        $conexao = new Conexao();
        $pdo = $conexao->conectar();

        $this->usuario = new UsuarioModel($pdo);
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

        $dadosAdmin = $this->usuario->getEmailAdmin($email);

        //  $senhaHash = password_hash($_POST['senha'], PASSWORD_BCRYPT);  

        if (empty($dadosAdmin->id_usuario)) {
        return ['login' => false];
        } else if (!password_verify($senha, $dadosAdmin->senha)) {
        return ['login' => false];
    } else {
        
        if (isset($dadosAdmin->tipo) && $dadosAdmin->tipo == 'admin') {
          
            $_SESSION["admin"] = [
                "id" => $dadosAdmin->id_usuario,
                "nome" => $dadosAdmin->nome,
                "email" => $dadosAdmin->email,
                "tipo" => $dadosAdmin->tipo
            ];
            return ['login' => true, 'tipo' => 'admin'];
        } else {
           
            $_SESSION["cliente"] = [
                "id" => $dadosAdmin->id_usuario,
                "nome" => $dadosAdmin->nome,
                "email" => $dadosAdmin->email,
                "tipo" => $dadosAdmin->tipo ?? 'cliente'
            ];
            return ['login' => true, 'tipo' => 'cliente'];
        }
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


            if ($this->usuario->getEmailAdmin($_POST['email'])) {
                return ['status' => 'error', 'message' => 'Este email já está cadastrado'];
            }

            $senhaHash = password_hash($_POST['senha'], PASSWORD_BCRYPT);

            if ($this->usuario->cadastrarUsuario($_POST['email'], $senhaHash)) {
                  header('location: ../public/painel2.php');
            } else {
                return ['status' => 'error', 'message' => 'Erro ao cadastrar usuário'];
            }

        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Erro interno: ' . $e->getMessage()];
        }
    }

    public function listarUsuariosPorTipo($tipo)
    {
        if ($tipo === 'admin') {
            return $this->usuario->listarAdmins();
        } elseif ($tipo === 'cliente') {
            return $this->usuario->listarClientes();
        } else {
            return [];
        }
    }


}