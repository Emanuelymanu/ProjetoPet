<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../config/Conexao.php";
require_once __DIR__ . "/../models/ProdutosModel.php";

class ProdutoController
{
    private $produtoModel;

    public function __construct()
    {
        $conexao = new Conexao();
        $pdo = $conexao->conectar();
        $this->produtoModel = new ProdutoModel($pdo);
    }

    public function salvar()
    {
        $dados = $_POST;
        $arquivo = $_FILES['imagens'] ?? null;

       
        if (empty($dados['nome']) || empty($dados['id_categoria']) || empty($dados['valor'])) {
            
            header("Location: ../public/painel2.php?page=produtos&status=error&message=Campos obrigatórios não preenchidos.");
            exit;
        }

        $diretorioUpload = __DIR__ . '/../public/img/produtos/';
        if (!is_dir($diretorioUpload)) {
            mkdir($diretorioUpload, 0777, true);
        }

       
        if ($arquivo && $arquivo['error'] === UPLOAD_ERR_OK) {
            $nomeTemporario = $arquivo['tmp_name'];

            
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            $nomeUnico = uniqid('prod_', true) . '.' . strtolower($extensao);

            $caminhoDestino = $diretorioUpload . $nomeUnico;

            
            if (move_uploaded_file($nomeTemporario, $caminhoDestino)) {
               
                $dados['imagens'] = $nomeUnico;

               
                if (!empty($dados['imagem_atual'])) {
                    $caminhoImagemAntiga = $diretorioUpload . $dados['imagem_atual'];
                    if (file_exists($caminhoImagemAntiga)) {
                        unlink($caminhoImagemAntiga);
                    }
                }
            } else {
              
                header("Location: ../public/painel2.php?page=produtos&status=error&message=Falha ao mover a imagem.");
                exit;
            }
        } else {
            
            $dados['imagens'] = $dados['imagem_atual'] ?? null;
        }

        
        unset($dados['imagem_atual']);

        if ($this->produtoModel->salvar($dados)) {
            header("Location: ../public/painel2.php?page=produtos&status=success");
        } else {
            header("Location: ../public/painel2.php?page=produtos&status=error&message=Erro ao salvar no banco de dados.");
        }
        exit;
    }

    public function listar()
    {
        return $this->produtoModel->listarProdutos();
    }

    public function excluir()
    {
        $id = trim($_GET["id"] ?? NULL);
        if (empty($id)) {
            
            header("Location: ../public/painel2.php?page=produtos&status=error&message=ID inválido.");
            exit;
        }

        

        if ($this->produtoModel->excluirProduto($id)) {
            header("Location: ../public/painel2.php?page=produtos&status=success_delete");
        } else {
            header("Location: ../public/painel2.php?page=produtos&status=error&message=Erro ao excluir.");
        }
        exit;
    }
}
