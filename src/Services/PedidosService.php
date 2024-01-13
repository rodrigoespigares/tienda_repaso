<?php
    namespace Services;
    use Repositories\PedidosRepository;
    class PedidosService{
        // Creando variable con
        private PedidosRepository $repository;
        function __construct() {
            $this->repository = new PedidosRepository();
        }
        public function find($id) :?array {
            return $this->repository->find($id);
        }
        public function findAll() :?array {
            return $this->repository->findAll();
        }
        public function nuevoPedido($datos){
            return $this->repository->nuevoPedido($datos);
        }
        public function changeEstado($id,$estado){
            return $this->repository->changeEstado($id,$estado);
        }
    }