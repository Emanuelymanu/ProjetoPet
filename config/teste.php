<?php
require_once 'Conexao.php';

try {
    $pdo = Conexao::conectar();
    
    // Testar consulta simples
    $stmt = $pdo->query("SELECT 1 as teste");
    $result = $stmt->fetch();
    
    if ($result && $result->teste == 1) {
        echo "✅ Conexão com o banco de dados funcionando perfeitamente!";
    } else {
        echo "❌ Problema na conexão com o banco";
    }
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage();
}
?>