<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\LineasPedidos;
    use PDOException;
    use PDO;
    class LineasPedidosRepository{
        private DataBase $conection;
        private mixed $sql;
        function __construct(){
            $this->conection = new DataBase();
        }
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM categorias;");
            
            return $this->extractAll();
        }
        public function extractAll():?array {
            $resultados = [];
            try{
                $resultadosData = $this->conection->allRegister();
                foreach ($resultadosData as $resultadoData){
                    $resultados[]=LineasPedidos::fromArray($resultadoData);
                }
            }catch(PDOException){
                $resultados=null;
            }
            return $resultados;
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