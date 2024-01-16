<?php
    namespace Services;
    use Repositories\CategoriasRepository;
    class CategoriasService{
        // Creando variable con
        private CategoriasRepository $repository;
        function __construct() {
            $this->repository = new CategoriasRepository();
        }
        /**
         * Función que devuelve todos los repositorios
         * 
         * @return array
         */
        public function findAll() :?array {
            return $this->repository->findAll();
        }
        /**
         * Función que devuelve un id dentro del array
         * 
         * @param string $id el id la categoria a buscar
         * @return array
         */
        public function find(string $id) :?array {
            return $this->repository->find($id);
        }
        /**
         * Función que añade una categoria
         * 
         * @param string $nombre nombre de la categoria
         * @return void
         */
        public function addCategory(string $nombre):void {
            $this->repository->addCategory($nombre);
        }
        /**
         * Función que desactiva una categoria
         * 
         * @param string $id con la categoria a desactivar
         * @return void
         */
        public function borrar(string $id) :void {
            $this->repository->borrar($id);
        }
        /**
         * Función que activa una categoria
         * 
         * @param string $id con la categoria a activar
         * @return void
         */
        public function activar($id) :void {
            $this->repository->activar($id);
        }
        /**
         * Función que activa una categoria
         * 
         * @param array $array con los datos de la categoria
         * @return void
         */
        public function editar(array $array):void {
            $this->repository->editar($array);
        }

    }