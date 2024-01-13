<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\LineasPedidos;
    use Models\Productos;
    use PDOException;
    use PDO;
    class LineasPedidosRepository{
        private DataBase $conection;
        private mixed $sql;
        function __construct(){
            $this->conection = new DataBase();
        }
        public function findAll($id) :?array
        {
            try {
                $this->sql = $this->conection->prepareSQL("SELECT productos.* FROM productos JOIN lineas_pedidos ON productos.id = lineas_pedidos.producto_id WHERE lineas_pedidos.pedido_id = :pedido_id;");
                $this->sql->bindValue(":pedido_id", $id);
                $this->sql->execute();
                $resultados = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultados as $key => $resultadoData){
                    
                    
                    $result[$key]= [ 'producto'=> Productos::fromArray($resultadoData), "id_pedido"=> $id];
                }
                $this->sql->closeCursor();
            } catch (PDOException $e) {
                $result = $e->getMessage();
            }
            $this->sql = null;
            return $result;
        }
        public function nuevoPedido($id)  {
            try{
                $this->conection->beginTransaction();
                foreach ($_SESSION['carrito'] as $value) {
                    $this->sql = $this->conection->prepareSQL("INSERT INTO lineas_pedidos(pedido_id,producto_id,unidades) VALUES (:pedido_id,:producto_id,:unidades);");
                    $this->sql->bindValue(":pedido_id",$id);
                    $this->sql->bindValue(":producto_id",unserialize($value['producto'])[0]->getId());
                    $this->sql->bindValue(":unidades",$value['unidades']);
                    $this->sql->execute();
                }
                $this->conection->commit();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
    }