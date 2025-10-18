<?php

Class Conexao{

    private static $host = 'localhost';
    private static $user = 'root';
    private static $pass = '';
    private static $dbname = 'petdb';


    public static function conectar(){
        try{
            return new PDO("mysql:host=".self::$host.";dbname=".self::$dbname, self::$user,self::$pass);
        }catch(PDOException $e){
            echo 'Erro: '.$e->getMessage();
        }
    }
}