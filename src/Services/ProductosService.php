<?php
    namespace Services;
    use Repositories\ProductosRepository;
    class ProductosService{
        // Creando variable con
        private ProductosRepository $repository;
        function __construct() {
            $this->repository = new ProductosRepository();
        }
        public function findAll() :?array {
            return $this->repository->findAll();
        }
        public function find($id) {
            return $this->repository->find($id);
        }
        public function findCategory($id) :?array {
            return $this->repository->findCategory($id);
        }
        public function addProduct($data) : void {
            $this->repository->addProduct($data);
        }
        public function nuevoPedido($datos){
            return $this->repository->nuevoPedido($datos);
        }
    }