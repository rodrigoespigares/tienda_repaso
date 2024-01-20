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
        /**
         * Función para buscar todos los productos
         * 
         * @return array con los resultados
         */
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM usuarios;");
            return $this->extractAll();
        }
        /**
         * Función para buscar todos los productos
         * 
         * @return array con los resultados
         */
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
        /**
         * Función para registrar un usuario
         * 
         * @param string $nombre con el nombre de usuario
         * @param string $apellidos con el apellido del usuario
         * @param string $email con el email del usuario
         * @param string $password con la contraseña del usuario
         * @param string $rol por defecto sera user pero sera el rol del usuario
         * 
         * @return string si hay error
         */
        public function registro($nombre,$apellidos,$email,$password,$rol="user") :?string{
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO usuarios(nombre,apellidos,email,password,rol) VALUES (:nombre,:apellidos,:email,:password,:rol);");      
                $this->sql->bindValue(":nombre",$nombre);
                $this->sql->bindValue(":apellidos",$apellidos);
                $this->sql->bindValue(":email",$email);
                $this->sql->bindValue(":password",$password);
                $this->sql->bindValue(":rol",$rol);
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
         * Función para obtener todos los datos del usuario por el email
         * 
         * @param string $email con el email del usuario
         * 
         * @return array con los datos del usuario
         */
        public function getIdentity(string $email) :?array {
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
        /**
         * Función para modificar el rol de un usuario
         * 
         * @param string $id con el id del usuario
         * @param string $rol con el rol modificado
         * 
         * @return string si hay error
         */
        public function modRol($id,$rol) :?string{
            try {
                $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET rol = :rol WHERE id = :id;");
                $this->sql->bindValue(":id", $id);
                $this->sql->bindValue(":rol", $rol);
                $this->sql->execute();
                $this->sql->closeCursor();
                $result = null;
            } catch (PDOException $e) {
                $result = $e->getMessage();
            }
            $this->sql = null;
            return $result;
        }
    }