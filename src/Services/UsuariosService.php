<?php
    namespace Services;
    use Repositories\UsuariosRepository;
    class UsuariosService{
        // Creando variable con
        private UsuariosRepository $userRepository;
        function __construct() {
            $this->userRepository = new UsuariosRepository();
        }
        public function allUsers() :?array {
            return $this->userRepository->findAll();
        }
        public function register($nombre,$apellidos,$email,$password):void{
            $this->userRepository->registro($nombre,$apellidos,$email,$password);
        }
        public function getIdentity($email) {
            return $this->userRepository->getIdentity($email);
        }
    }