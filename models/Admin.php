<?php
class admin{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
   

    public function getEmailAdmin($email){
        $sql = "select id, nome, email, senha from administrador
            where email = :email 
            limit 1";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":email", $email);
        $consulta->execute();

        return $consulta->fetch(PDO::FETCH_OBJ);
    }
}