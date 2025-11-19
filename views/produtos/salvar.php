<?php

$id = $_POST["id"] ?? NULL;
$nome = $_POST["nome"] ?? NULL;
$id_categoria = $_POST["id_categoria"] ?? NULL;
$descricao = $_POST["descricao"] ?? NULL;
$valor = $_POST["valor"] ?? NULL;
$imagem = $_POST["imagem"] ?? NULL;
$ativo = $_POST["ativo"] ?? NULL;
$destaque = $_POST["destaque"] ?? NULL;

$valor = str_replace(".", "", $valor);
$valor = str_replace(",", ".", $valor);
$_POST['valor'] = $valor;


if (empty($nome)){
    echo "<script>mensagem('Digite o nome do produto','produtos', 'error');</script>";
    exit;
}else if(empty($id_categoria)){
    echo "<script>mensagem('Selecione a categoria','produtos', 'error');</script>";
    exit;
}else if(empty($descricao)){
    echo "<script>mensagem('Digite a descrição do produto','produtos', 'error');</script>";
    exit;
}else if(empty($valor)){
    echo "<script>mensagem('Digite o valor do produto','produtos', 'error');</script>";
    exit;  
}else if(empty($destaque)){
    echo "<script>mensagem('Selecione se o produto é destaque','produtos', 'error');</script>";
    exit;
}else if(empty($ativo)){
    echo "<script>mensagem('Selecione se o produto é ativo','produtos', 'error');</script>";
    exit;
}
$imagem = $_POST["imagens"] ?? time().".jpg";
$_POST["imagens"] = $imagem;

$msg = null;

if (file_exists(__DIR__ . '/../../controllers/ProdutoController.php')) {
    require_once __DIR__ . '/../../controllers/ProdutoController.php';
    if (class_exists('ProdutoController')) {
        $produtoController = new ProdutoController();
      
        $msg = $produtoController->salvar($_POST, $_FILES);
    }
}


if ($msg === null && file_exists(__DIR__ . '/../../models/ProdutoModel.php')) {
    require_once __DIR__ . '/../../config/Conexao.php';
    require_once __DIR__ . '/../../models/ProdutoModel.php';
    $conexao = new Conexao();
    $pdo = $conexao->conectar();
    $produtoModel = new ProdutoModel($pdo);
    
    $msg = $produtoModel->salvar($_POST);
}

if ($msg == 1) {
    echo "<script>mensagem('Dados salvos!','produtos', 'ok');</script>";
} else {
    echo "<script>mensagem('Erro ao salvar dados','produtos', 'error');</script>";
}
      