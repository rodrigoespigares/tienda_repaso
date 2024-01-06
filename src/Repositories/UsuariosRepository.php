<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Usuarios;
    use PDOException;
    use PDO;
    class UsuariosRepository{
        private DataBase $conection;
        private mixed $sql;
        function __construct(){
            $this->conection = new DataBase();
        }
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM usuarios;");
            return $this->extractAll();
        }
        public function extractAll():?array {
            $usuarios = [];
            try{
                $this->conection->querySQL("SELECT * FROM usuarios");
                $usuariosData = $this->conection->allRegister();
                foreach ($usuariosData as $usuarioData){
                    $usuarios[]=Usuarios::fromArray($usuarioData);
                }
            }catch(PDOException){
                $usuarios=null;
            }
            return $usuarios;
        }
        public function registro($nombre,$apellidos,$email,$password){
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO usuarios(nombre,apellidos,email,password,rol) VALUES (:nombre,:apellidos,:email,:password,:rol);");
                $rol = "user";
                $this->sql->bindValue(":nombre",$nombre);
                $this->sql->bindValue(":apellidos",$apellidos);
                $this->sql->bindValue(":email",$email);
                $this->sql->bindValue(":password",$password);
                $this->sql->bindValue(":rol",$rol);
                $this->sql->execute();
                $result = $this->sql->rowCount();
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        public function getIdentity($email) {
            $usuario = null;
            try {
                $this->sql = $this->conection->prepareSQL("SELECT * FROM usuarios WHERE email = :email");
                $this->sql->bindValue(":email", $email);
                $this->sql->execute();
                $usuarioData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $usuario = $usuarioData ?: null;
                
            } catch (PDOException $e) {
                $usuario = $e->getMessage();
            }
        
            return $usuario;
        }
    }