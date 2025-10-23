<?php
class Conexao{
    private static $host = 'localhost';
    private static $user = 'root';
    private static $pass = '';
    private static $dbname = 'petdb';
    private static $charset = 'utf8mb4';

    public static function conectar(){
        try{
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=" . self::$charset;
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lança exceções em erros
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // Retorna objetos por padrão
                PDO::ATTR_EMULATE_PREPARES => false, // Preparações nativas do MySQL
                PDO::ATTR_PERSISTENT => false // Conexões não persistentes
            ];
            
            return new PDO($dsn, self::$user, self::$pass, $options);
            
        } catch(PDOException $e){
            // Em produção, logue o erro em vez de mostrar
            error_log("Erro de conexão: " . $e->getMessage());
            throw new Exception("Erro ao conectar com o banco de dados");
        }
    }
}
?>