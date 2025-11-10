<?php
class Admin
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

     public function getEmailAdmin($email)
    {
        $sql = "select * from administrador where email = :email";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":email", $email);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_OBJ);
    }

    public function cadastrarUsuario($email, $senha)
    {
        try {
            $sql = "INSERT INTO administrador (email, senha) VALUES (:email, :senha)";
            $consulta = $this->pdo->prepare($sql);
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
   

    /*public function verificarLogin($email, $senha)
    {
        $sql = "select id, nome, email, senha from administrador where email = :email and senha = :senha";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":email", $email);
        $consulta->bindParam(":senha", $senha);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_OBJ);
    }*/


    public function listarAdmins($email)
    {
        $sql = "select id, nome, email from administrador";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":email", $email);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }

    /* public function novoAdmin($nome, $email, $senha){
         $sql = "insert into administrador (nome, email, senha) values (:nome, :email, :senha)";
         $consulta = $this->pdo->prepare($sql);
         $consulta->bindParam(":nome", $nome);
         $consulta->bindParam(":email", $email);
         $consulta->bindParam(":senha", $senha);
         $consulta->execute();

         return $consulta->fetchAll(PDO::FETCH_OBJ);
     }*/

    public function removerAdmin($id)
    {
        $sql = "delete from administrador where id = :id";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }
}