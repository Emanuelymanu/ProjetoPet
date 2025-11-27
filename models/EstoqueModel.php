<?php

class EstoqueModel
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function adicionarProduto($dados)
    {
        $sql = "INSERT INTO estoque (id_produto, tipo_movimentacao, quantidade, data_movimentacao, observacao)
        VALUES (:id_produto, :tipo_movimentacao, :quantidade, :data_movimentacao, :observacao)";
        $consulta = $this->pdo->prepare($sql);
        $consulta->bindParam(":id_produto", $dados["id_produto"]);
        $consulta->bindParam(":tipo_movimentacao", $dados["tipo_movimentacao"]);
        $consulta->bindParam(":quantidade", $dados["quantidade"]);
        $consulta->bindParam(":data_movimentacao", $dados["data_movimentacao"]);
        $consulta->bindParam(":observacao", $dados["observacao"]);


        return $consulta->execute();

    }

    public function atualizarQuantidade($id_movimentacao, $novaQuantidade)
    {
        $sql = "UPDATE estoque SET quantidade = ? WHERE id_movimentacao = ?";
        $consulta = $this->pdo->prepare($sql);
        try {
            $resultado = $consulta->execute([$novaQuantidade, $id_movimentacao]);
            return $resultado;
        } catch (PDOException $e) {
            error_log("Erro ao atualizar quantidade do produto ID {$id_movimentacao}: " . $e->getMessage());
            return false;
        }
    }

    public function darBaixa($id_movimentacao, $quantidadeVendida)
    {
        $sql = "SELECT quantidade FROM estoque WHERE id_movimentacao = :id_movimentacao";
        try {
            $consulta = $this->pdo->prepare($sql);
            $consulta->execute([":id_movimentacao" => $id_movimentacao]);
            $produto = $consulta->fetch(PDO::FETCH_ASSOC);

            if (!$produto) {
                return false;
            }

            $quantidadeAtual = $produto["quantidade"];

            if ($quantidadeAtual < $quantidadeVendida) {
                return false;
            }

            $novaQuantidade = $quantidadeAtual - $quantidadeVendida;

            $sql_update = "UPDATE estoque SET quantidade = :novaQuantidade WHERE id_movimentacao = :id_movimentcao";
            $consulta_update = $this->pdo->prepare($sql_update);
            $consulta_update->bindParam(":novaQuantidade", $novaQuantidade);
            $consulta_update->bindParam(":id_movimentacao", $id_movimentacao);
            $resultado_update = $consulta_update->execute();
            return $resultado_update;
        } catch (PDOException $e) {
            error_log("Erro de PDO ao dar baixa no estoque: " . $e->getMessage());
            return false;
        }

    }
}