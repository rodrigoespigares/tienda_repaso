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
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM categorias;");
            
            return $this->extractAll();
        }
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
        public function addCategory($nombre) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO categorias(nombre) VALUES (:nombre);");
                $this->sql->bindValue(":nombre",$nombre);
                $this->sql->execute();
                $result = $this->sql->rowCount();
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        public function borrar($id) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE categorias SET borrado = 1 WHERE id = :id;");
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
                $this->sql = $this->conection->prepareSQL("UPDATE categorias SET borrado = 0 WHERE id = :id;");
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
        public function editar($id) :?string {
            try{
                $this->sql = $this->conection->prepareSQL("DELETE FROM categorias WHERE id = :id;");
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