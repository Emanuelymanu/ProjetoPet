<?php
<?php
// models/PedidoModel.php
require_once __DIR__ . '/../config/Conexao.php';

class PedidoModel {
    private $con;

    public function __construct() {
        $this->con = Conexao::conectar();
    }

    /**
     * Cria um pedido na tabela `pedido` e insere itens na tabela `item_pedido`.
     * $cliente_id: string|int
     * $itens: array de ['produto_id'=>int, 'quantidade'=>int, 'preco'=>float]
     * $frete: float
     * $dados_pedido: array (opcional) será salvo em JSON no campo dados se existir
     * Retorna id_pedido (int) ou false em erro.
     */
    public function criarPedido($cliente_id, array $itens, $frete = 0.0, array $dados_pedido = []) {
        if (empty($itens)) {
            return false;
        }

        try {
            $this->con->beginTransaction();

            // Calcula total a partir dos itens
            $total = 0.0;
            foreach ($itens as $it) {
                $preco = isset($it['preco']) ? (float)$it['preco'] : 0.0;
                $qtd = isset($it['quantidade']) ? (int)$it['quantidade'] : 1;
                $total += $preco * $qtd;
            }
            $total += (float)$frete;

            // Ajuste de colunas da tabela `pedido` — se sua tabela tiver nomes diferentes, adapte aqui
            $sql = "INSERT INTO pedido (cliente_id, total, frete, status, dados, criado_em)
                    VALUES (:cliente_id, :total, :frete, :status, :dados, NOW())";
            $stmt = $this->con->prepare($sql);
            $statusInicial = 'novo';
            $dadosJson = !empty($dados_pedido) ? json_encode($dados_pedido, JSON_UNESCAPED_UNICODE) : null;
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':total' => $total,
                ':frete' => $frete,
                ':status' => $statusInicial,
                ':dados' => $dadosJson
            ]);

            $pedido_id = (int)$this->con->lastInsertId();

            // Insere itens na tabela item_pedido (colunas conforme seu schema)
            $sqlItem = "INSERT INTO item_pedido (id_pedido, id_produto, quantidade, preco_unitario)
                        VALUES (:id_pedido, :id_produto, :quantidade, :preco_unitario)";
            $stmtItem = $this->con->prepare($sqlItem);

            foreach ($itens as $it) {
                $produto_id = (int)$it['produto_id'];
                $quantidade = max(1, (int)$it['quantidade']);
                $preco_unitario = isset($it['preco']) ? (float)$it['preco'] : 0.0;
                $stmtItem->execute([
                    ':id_pedido' => $pedido_id,
                    ':id_produto' => $produto_id,
                    ':quantidade' => $quantidade,
                    ':preco_unitario' => $preco_unitario
                ]);
            }

            $this->con->commit();
            return $pedido_id;
        } catch (Exception $e) {
            $this->con->rollBack();
            error_log('PedidoModel::criarPedido erro: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Retorna lista de pedidos do cliente (array)
     */
    public function getPedidosPorCliente($cliente_id) {
        $sql = "SELECT id_pedido, cliente_id, total, frete, status, dados, criado_em
                FROM pedido
                WHERE cliente_id = :cliente_id
                ORDER BY criado_em DESC";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([':cliente_id' => $cliente_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retorna detalhes de um pedido (cabecalho + itens)
     */
    public function getPedidoPorId($pedido_id) {
        $sql = "SELECT id_pedido, cliente_id, total, frete, status, dados, criado_em
                FROM pedido
                WHERE id_pedido = :id_pedido
                LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute([':id_pedido' => $pedido_id]);
        $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$pedido) return null;

        $sqlItems = "SELECT ip.id_item, ip.id_produto, ip.quantidade, ip.preco_unitario, p.nome, p.imagem
                     FROM item_pedido ip
                     LEFT JOIN produto p ON p.id_produto = ip.id_produto
                     WHERE ip.id_pedido = :id_pedido";
        $stmt2 = $this->con->prepare($sqlItems);
        $stmt2->execute([':id_pedido' => $pedido_id]);
        $itens = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $pedido['itens'] = $itens;
        return $pedido;
    }
}
?>