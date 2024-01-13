<?php
    namespace Services;
    use Repositories\LineasPedidosRepository;
    class LineasPedidosService{
        // Creando variable con
        private LineasPedidosRepository $repository;
        function __construct() {
            $this->repository = new LineasPedidosRepository();
        }
        public function findAll($id) :?array {
            return $this->repository->findAll($id);
        }
        public function nuevoPedido($datos){
            return $this->repository->nuevoPedido($datos);
        }
    }