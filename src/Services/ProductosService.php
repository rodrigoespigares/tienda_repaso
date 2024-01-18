<?php
    namespace Services;
    use Repositories\ProductosRepository;
    class ProductosService{
        // Creando variable con
        private ProductosRepository $repository;
        function __construct() {
            $this->repository = new ProductosRepository();
        }
        /**
         * Función para buscar todos los productos
         *
         * @return array con todos los productos
         */
        public function findAll() :?array {
            return $this->repository->findAll();
        }
        /**
         * Función para buscar un producto por id
         * @param string $id id del producto a buscar
         * @return array con todos los productos
         */
        public function find(string $id):?array {
            return $this->repository->find($id);
        }
        /**
         * Función para buscar un producto por categoria
         * @param string $id id de la categoria a buscar
         * @return array con todos los productos de esa categoria
         */
        public function findCategory(string $id) :?array {
            return $this->repository->findCategory($id);
        }
        /**
         * Función para añadir un nuevo producto
         * @param array $data datos del nuevo producto
         *
         */
        public function addProduct(array $data) : void {
            $this->repository->addProduct($data);
        }
        /**
         * Función para restar el stock del pedido
         * @param array $datos datos del pedido
         *
         */
        public function nuevoPedido(array $datos):?string{
            return $this->repository->nuevoPedido($datos);
        }
         /**
         * Función para desactivar un producto
         * @param string $id del producto a desactivar
         *
         */
        public function borrar(string $id) :void {
            $this->repository->borrar($id);
        }
        /**
         * Función para activar un producto
         * @param string $id del producto a activar
         *
         */
        public function activar($id) :void {
            $this->repository->activar($id);
        }
        /**
         * Función para editar los datos de un producto
         * @param array $array con los datos del producto
         *
         */
        public function editarProduct(array $array) :void {
            $this->repository->editarProduct($array);
        }
    }