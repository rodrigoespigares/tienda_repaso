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
        /**
         * Función para buscar todos los productos
         * 
         * @return array con los resultados
         */
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM productos;");
            
            return $this->extractAll();
        }
        /**
         * Función para buscar un producto por el id
         * 
         * @param string $id con el id
         * 
         * @return array con los resultados
         */
        public function find(string $id) :? array{
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
        /**
         * Función para buscar todos los productos por la categoria
         * 
         * @param string $id con la id de la categoria
         * 
         * @return array con los resultados
         */
        public function findCategory(string $id):? array {
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
        /**
         * Función para buscar todos los productos
         * 
         * @return array con los resultados
         */
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
        /**
         * Función para añadir un producto
         * 
         * @param array $data con los datos del producto
         * 
         * @return string si hay errores
         */
        public function addProduct(array $data) :?string {
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

            return $result;
        }
        /**
         * Funcion para hacer un nuevo pedido con la transaccion
         * 
         * @param array $datos con los datos
         * @return string si hay errores
         */
        public function nuevoPedido($datos):?string {
            try{
                $this->conection->beginTransaction();
                foreach ($_SESSION['carrito'] as $key => $value) {
                    $this->sql = $this->conection->prepareSQL("UPDATE productos SET stock = :stock - :unidades WHERE id = :id AND :stock - :unidades >= 0;");
                    $this->sql->bindValue(":id",unserialize($value['producto'])[0]->getId());
                    $this->sql->bindValue(":stock",intval(unserialize($value['producto'])[0]->getStock()));
                    $this->sql->bindValue(":unidades",$value['unidades']);
                    $this->sql->execute();   
                }
                $this->conection->commit();
                $result =$this->service->nuevoPedido($datos);
                
            }catch(PDOException $e){
                $this->sql->rollBack();
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        /**
         * Función para desactivar un producto
         * 
         * @param string $id con el id del producto a desactivar
         * 
         * @return string si hay errores
         */
        public function borrar(string $id) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE productos SET borrado = 1 WHERE id = :id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->execute();
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        /**
         * Función para activar un producto
         * 
         * @param string $id con el id del producto a activar
         * 
         * @return string si hay errores
         */
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
        /**
         * Función para editar un producto
         * 
         * @param array $data con los nuevos datos del producto
         * 
         * @return string si hay errores
         */
        public function editarProduct(array $data) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE productos SET categoria_id = :categoria_id , nombre= :nombre , descripcion= :descripcion , precio= :precio , stock= :stock ,oferta= :oferta , fecha= :fecha ,imagen= :imagen WHERE id = :id;;");
                $this->sql->bindValue(":id",$data['id']);
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
            return $result;
        }
    }