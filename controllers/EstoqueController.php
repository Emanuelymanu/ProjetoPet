<?php

require_once __DIR__ . '/../config/Conexao.php';
require_once __DIR__ . '/../models/EstoqueModel.php';

class EstoqueController
{
    private $estoqueModel;

    public function __construct()
    {
        $conexao = new Conexao();
        $pdo = $conexao->conectar();
        $this->estoqueModel = new EstoqueModel($pdo);
    }

    public function editarMovimentacao($id_movimentacao, $id_produto, $tipo_movimentacao, $quantidade, $data_movimentacao, $observacao = '')
    {
        $dados = [
            'id_movimentacao' => $id_movimentacao,
            'id_produto' => $id_produto,
            'tipo_movimentacao' => $tipo_movimentacao,
            'quantidade' => $quantidade,
            'data_movimentacao' => $data_movimentacao,
            'observacao' => $observacao
        ];
        return $this->estoqueModel->editarMovimentacao($dados);
    }

    public function insert($id_produto, $tipo_movimentacao, $quantidade, $observacao = '')
    {
        $dados = [
            'id_produto' => $id_produto,
            'tipo_movimentacao' => $tipo_movimentacao,
            'quantidade' => $quantidade,
            'data_movimentacao' => date('Y-m-d H:i:s'),
            'observacao' => $observacao
        ];
        return $this->estoqueModel->adicionarProduto($dados);
    }

    public function listarProdutos()
    {
        return $this->estoqueModel->buscarProdutos();
    }
}

