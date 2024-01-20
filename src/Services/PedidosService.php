<?php
    namespace Services;
    use Repositories\PedidosRepository;
    class PedidosService{
        // Creando variable con
        private PedidosRepository $repository;
        function __construct() {
            $this->repository = new PedidosRepository();
        }
        /**
         * Función para buscar un pedido
         * @param string $id con el id del pedido a buscar
         * @return array con el pedidos
         */
        public function find(string $id) :?array {
            return $this->repository->find($id);
        }
        /**
         * Función para buscar todos los pedidos
         * 
         * @return array con todos los pedidos
         */
        public function findAll() :?array {
            return $this->repository->findAll();
        }
        /**
         * Función para añadir un pedido
         * @param array $datos con los datos del pedido
         * 
         */
        public function nuevoPedido(array $datos):?string{
            return $this->repository->nuevoPedido($datos);
        }
        /**
         * Función para cambiar el estado de un pedido
         * @param string $id con el id del pedido
         * @param string $estado con el nuevo estado del pedido
         */
        public function changeEstado(string $id,string $estado) :void {
            $this->repository->changeEstado($id,$estado);
        }
    }