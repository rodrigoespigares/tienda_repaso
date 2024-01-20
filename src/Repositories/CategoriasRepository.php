<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Categorias;
    use PDOException;
    use PDO;
    class CategoriasRepository{
        private DataBase $conection;
        private mixed $sql;
        function __construct(){
            $this->conection = new DataBase();
        }
        /**
         * Función para buscar todas las categorias en la base de datos
         * 
         * @return array si todo ocurre correctamente
         */
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM categorias;");
            
            return $this->extractAll();
        }
        /**
         * Función para buscar una categoria por el id
         * 
         * @param string $id id de la categoria que buscamos
         * 
         * @return array si todo ocurre correctamente
         */
        public function find(string $id) :? array{
            $resultado = [];
            try{
                $this->sql = $this->conection->prepareSQL("SELECT * FROM categorias WHERE id=:id;");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $resultados = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultados as $resultadoData){
                    $resultado[]=Categorias::fromArray($resultadoData);
                }
                $this->sql->closeCursor();
            }catch(PDOException $e){
                    $resultado = $e->getMessage();
            }
            return $resultado;
        }
        /**
         * Función para extraer todas las categorias en la base de datos
         * 
         * @return array si todo ocurre correctamente
         */
        public function extractAll():?array {
            $categorias = [];
            try{
                $categoriasData = $this->conection->allRegister();
                foreach ($categoriasData as $categoriaData){
                    $categorias[]=Categorias::fromArray($categoriaData);
                }
            }catch(PDOException){
                $categorias=null;
            }
            return $categorias;
        }
        /**
         * Función para añadir una categoria a la base de datos
         * 
         * @param string nombre con el nombre de la categoria
         * @return string si hay un error
         */
        public function addCategory(string $nombre) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO categorias(nombre) VALUES (:nombre);");
                $this->sql->bindValue(":nombre",$nombre);
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
         * Función para desactivar una categoria por el id
         * 
         * @param string id con el id de la categoria a desactivar
         * @return string si hay un error
         */
        public function borrar(string $id) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE categorias SET borrado = 1 WHERE id = :id;");
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
         * Función para activar una categoria por el id
         * 
         * @param string id con el id de la categoria a activar
         * @return string si hay un error
         */
        public function activar(string $id) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE categorias SET borrado = 0 WHERE id = :id;");
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
         * Función para editar una categoria
         * 
         * @param array $array con los datos a editar
         * @return string si hay un error
         */
        public function editar(array $array) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE categorias SET nombre = :nombre WHERE id = :id;");
                $this->sql->bindValue(":id",$array['id']);
                $this->sql->bindValue(":nombre",$array['nombre']);
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