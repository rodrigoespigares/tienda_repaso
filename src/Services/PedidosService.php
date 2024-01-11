<?php
    namespace Services;
    use Repositories\PedidosRepository;
    class PedidosService{
        // Creando variable con
        private PedidosRepository $repository;
        function __construct() {
            $this->repository = new PedidosRepository();
        }
        public function findAll($id) :?array {
            return $this->repository->findAll($id);
        }
        public function nuevoPedido($datos){
            return $this->repository->nuevoPedido($datos);
        }
    }