<?php
    namespace Services;
    use Repositories\CategoriasRepository;
    class CategoriasService{
        // Creando variable con
        private CategoriasRepository $repository;
        function __construct() {
            $this->repository = new CategoriasRepository();
        }
        public function findAll() :?array {
            return $this->repository->findAll();
        }
        public function addCategory($nombre):void {
            $this->repository->addCategory($nombre);
        }
        public function borrar($id) :void {
            $this->repository->borrar($id);
        }
        public function editar($id) {
            $this->repository->editar($id);
        }
    }