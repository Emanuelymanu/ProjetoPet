<?php
class UsuarioModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

     public function getEmailAdmin($email)
    {
        $sql = "select * from usuario where email = :email";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":email", $email);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    public function cadastrarUsuario( $email, $senha)
    {
        try {
            $sql = "INSERT INTO usuario ( email, senha) VALUES ( :email, :senha)";
            $consulta = $this->pdo->prepare($sql);
            //$consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":email", $email);
            $consulta->bindParam(":senha", $senha);
            return $consulta->execute();
            if ($consulta->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }
   


    public function listarAdmin(){
        $sql= "SELECT id_usuario, nome, email FROM usuario WHERE tipo = 'admin' ORDER BY nome";
        $consulta = $this->pdo->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);

    }

     public function listarCliente(){
        $sql= "SELECT id_usuario, nome, email FROM usuario WHERE tipo = 'cliente' ORDER BY nome";
        $consulta = $this->pdo->prepare($sql);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);

    }



    /*public function verificarLogin($email, $senha)
    {
        $sql = "select id, nome, email, senha from administrador where email = :email and senha = :senha";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":senha", $senha);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_OBJ);
    }*/



  
    
}