<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Productos;
    use Services\PedidosService;
    use PDOException;
    use PDO;
    class ProductosRepository{
        private DataBase $conection;
        private PedidosService $service;
        private mixed $sql;
        public function __construct(){
            $this->conection = new DataBase();
            $this->service = new PedidosService();
        }
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM productos;");
            
            return $this->extractAll();
        }
        public function find($id) :? array{
            $resultado = [];
            try{
                $this->sql = $this->conection->prepareSQL("SELECT * FROM productos WHERE id=:id;");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $resultados = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultados as $resultadoData){
                    $resultado[]=Productos::fromArray($resultadoData);
                }
                $this->sql->closeCursor();
            }catch(PDOException $e){
                    $resultado = $e->getMessage();
            }
            return $resultado;
        }
        public function findCategory($id):? array {
            $resultado = [];
            try{
                $this->sql = $this->conection->prepareSQL("SELECT * FROM productos WHERE categoria_id=:categoria_id;");
                $this->sql->bindValue(":categoria_id", $id);
                $this->sql->execute();
                $resultados = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultados as $resultadoData){
                    $resultado[]=Productos::fromArray($resultadoData);
                }
                $this->sql->closeCursor();
            }catch(PDOException $e){
                    $resultado = $e->getMessage();
            }
            return $resultado;
        }
        public function extractAll():?array {
            $resultado = [];
            try{
                $resultadosData = $this->conection->allRegister();
                foreach ($resultadosData as $resultadoData){
                    $resultado[]=Productos::fromArray($resultadoData);
                }
            }catch(PDOException){
                $resultado=null;
            }
            return $resultado;
        }
        public function addProduct($data) :void {
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO productos(categoria_id,nombre,descripcion,precio,stock,oferta,fecha,imagen) VALUES (:categoria_id,:nombre,:descripcion,:precio,:stock,:oferta,:fecha,:imagen);");
                $this->sql->bindValue(":categoria_id",$data['categoria_id']);
                $this->sql->bindValue(":nombre",$data['nombre']);
                $this->sql->bindValue(":descripcion",$data['descripcion']);
                $this->sql->bindValue(":precio",$data['precio']);
                $this->sql->bindValue(":stock",$data['stock']);
                $this->sql->bindValue(":oferta",$data['oferta']);
                $this->sql->bindValue(":fecha",$data['fecha']);
                $this->sql->bindValue(":imagen",$data['imagen']);
                $this->sql->execute();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
        }
        public function nuevoPedido($datos) {
            try{
                $this->conection->beginTransaction();
                foreach ($_SESSION['carrito'] as $key => $value) {
                    $this->sql = $this->conection->prepareSQL("UPDATE productos SET stock = :stock - :unidades WHERE id = :id AND :stock - :unidades >= 0;");
                    $this->sql->bindValue(":id",unserialize($value['producto'])[0]->getId());
                    $this->sql->bindValue(":stock",intval(unserialize($value['producto'])[0]->getStock()));
                    $this->sql->bindValue(":unidades",$value['unidades']);
                    $this->sql->execute();   
                }
                $result = null;
                $this->conection->commit();
                $this->service->nuevoPedido($datos);
                
            }catch(PDOException $e){
                $this->sql->rollBack();
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
        }
        public function borrar($id) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE productos SET borrado = 1 WHERE id = :id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->execute();
                $result = $this->sql->rowCount();
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        public function activar($id) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE productos SET borrado = 0 WHERE id = :id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->execute();
                $result = $this->sql->rowCount();
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
    }