<?php
    namespace Services;
    use Repositories\UsuariosRepository;
    class UsuariosService{
        // Creando variable con
        private UsuariosRepository $userRepository;
        function __construct() {
            $this->userRepository = new UsuariosRepository();
        }
        /**
         * Funcion para buscar todos los usuarios
         * @return array con todos los usuarios
         */
        public function allUsers() :?array {
            return $this->userRepository->findAll();
        }
        /**
         * Funcion para registrar un usuario
         * 
         * @param string $nombre con el nombre del usuario
         * @param string $apellidos con los apellidos del usuario
         * @param string $email con el email del usuario
         * @param string $password con la pass del usuario
         */
        public function register(string $nombre,string $apellidos,string $email,string $password,string $rol = "user"):void{
            $this->userRepository->registro($nombre,$apellidos,$email,$password,$rol);
        }
        /**
         * Funcion para buscar todos los datos del usuario
         * 
         * @param string $email con el email del usuario
         * @return array con los datos del usuario
         */
        public function getIdentity(string $email) :? array{
            return $this->userRepository->getIdentity($email);
        }
        /**
         * Función para modificar el rol de un usuario
         * @param string $id con el id del usuario
         * @param string $rol con el nuevo rol del usuario
         */
        public function modRol(string $id,string $rol) :void{
            $this->userRepository->modRol($id,$rol);
        }
    }