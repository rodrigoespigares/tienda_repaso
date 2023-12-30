<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Pedidos;
    use Services\LineasPedidosService;
    use PDOException;
    use PDO;
    class PedidosRepository{
        private DataBase $conection;
        private LineasPedidosService $service;
        private mixed $sql;
        function __construct(){
            $this->conection = new DataBase();
            $this->service = new LineasPedidosService();
        }
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM categorias;");
            
            return $this->extractAll();
        }
        public function extractAll():?array {
            $categorias = [];
            try{
                $categoriasData = $this->conection->allRegister();
                foreach ($categoriasData as $categoriaData){
                    $categorias[]=Pedidos::fromArray($categoriaData);
                }
            }catch(PDOException $e){
                $categorias= $e->getMessage();
            }
            return $categorias;
        }
        public function nuevoPedido($datos)  {
            try{
                $this->conection->beginTransaction();
                $this->sql = $this->conection->prepareSQL("INSERT INTO pedidos(usuario_id,provincia,localidad,direccion,coste,estado,fecha,hora) VALUES (:usuarios_id,:provincia,:localidad,:direccion,:coste,:estado,:fecha,:hora);");
                $costeTotal = 0;
                foreach ($_SESSION['carrito'] as $key => $value) {
                    $costeTotal += $value['unidades']*intval(unserialize($value['producto'])[0]->getPrecio());
                }
                $estado = "pendiente";
                $fecha = date('Y-m-d');
                $hora = date('H:i:s');
                $this->sql->bindValue(":usuarios_id",$_SESSION['identity']['id']);
                $this->sql->bindValue(":provincia",$datos['provincia']);
                $this->sql->bindValue(":localidad",$datos['localidad']);
                $this->sql->bindValue(":direccion",$datos['direccion']);
                $this->sql->bindValue(":coste",$costeTotal);
                $this->sql->bindValue(":estado",$estado);
                $this->sql->bindValue(":fecha",$fecha);
                $this->sql->bindValue(":hora",$hora);
                $this->sql->execute();
                $result = $this->conection->lastInsertId();
                $this->conection->commit();
                $this->service->nuevoPedido($result);
            }catch(PDOException $e){
                $this->conection->rollBack();
                echo $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
    }