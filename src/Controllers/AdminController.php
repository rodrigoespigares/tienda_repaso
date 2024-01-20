<?php
    namespace Controllers;
    use Models\Categorias;
    use Models\Pedidos;
    use Models\Productos;
    use Lib\Pages;
    use Lib\Utils;
    use Services\CategoriasService;
    use Services\ProductosService;
    use Services\PedidosService;
    use Services\UsuariosService;
    use Services\LineasPedidosService;
    class AdminController{
        private CategoriasService $categoriasService;
        private ProductosService $productosService;
        private PedidosService $pedidosService;
        private UsuariosService $usuariosService;
        private LineasPedidosService $lineasService;
        private Pages $pages;
        public function __construct()
        {
            $this->categoriasService = new CategoriasService();
            $this->productosService = new ProductosService();
            $this->pedidosService = new PedidosService();
            $this->usuariosService = new UsuariosService();
            $this->lineasService = new LineasPedidosService();
            $this->pages = new Pages();
        }
        /**
         * Función para gestionar las categorias
         */
        public function gestionCategorias() : void {
            Utils::checkSesionAdmin();
            $categorias = $this->categoriasService->findAll();
            $this->pages->render("pages/admin/gestionCategorias",["cats"=>$categorias]);
        }
        /**
         * Función para añadir una categoria
         */
        public function addCategory() : void {
            Utils::checkSesionAdmin();
            $data['name']=$_POST['nombre'];
            $errores = [];
            Categorias::validation($data,$errores);
            if(empty($errores)){
                $this->categoriasService->addCategory($_POST['nombre']);
                $this->gestionCategorias();
            }else{
                $categorias = $this->categoriasService->findAll();
                $this->pages->render("pages/admin/gestionCategorias",["cats"=>$categorias,"errores"=>$errores]);
            }
        }
        /**
         * Función para editar las categorias
         */
        public function editarCategoria() :void {
            Utils::checkSesionAdmin();
            $data['name'] = $_POST['data']['nombre'];
            $errores = [];
            Categorias::validation($data,$errores);
            if(empty($errores)){
                $this->categoriasService->editar($_POST['data']);
                $this->gestionCategorias();
            }else{
                $result = $this->categoriasService->find($_POST['data']['id']);
                $categorias = $this->categoriasService->findAll();
                $this->pages->render("pages/admin/gestionCategorias",["cats"=>$categorias,"categoriaEditar"=>$result,"errores"=>$errores]);
            }
        }
        /**
         * Función para gestionar las opciones de las categorias
         */
        public function opcionesCategoria() : void {
            Utils::checkSesionAdmin();
            if(isset($_POST['borrar'])){
                $this->categoriasService->borrar($_POST['borrar']);
                $this->gestionCategorias();
            } elseif (isset($_POST['activar'])){
                $this->categoriasService->activar($_POST['activar']);
                $this->gestionCategorias();
            }elseif (isset($_POST['editar'])){
                $result = $this->categoriasService->find($_POST['editar']);
                $categorias = $this->categoriasService->findAll();
                $this->pages->render("pages/admin/gestionCategorias",["cats"=>$categorias,"categoriaEditar"=>$result]);
            }
        }
        /**
         * Función para gestionar los productos
         */
        public function gestionProductos() : void {
            Utils::checkSesionAdmin();
            $productos = $this->productosService->findAll();
            $categorias = $this->categoriasService->findAll();
            $this->pages->render("pages/admin/gestionProductos",["productos"=>$productos,"categorias"=>$categorias]);
        }
        /**
         * Función para añadir un producto
         */
        public function addProduct() : void {
            Utils::checkSesionAdmin();
            $productos = $this->productosService->findAll();
            $categorias = $this->categoriasService->findAll();
            $datos = $_POST['data'];
            $errores = [];
            Productos::validation($datos,$errores);
            if(empty($errores)){
                if(is_uploaded_file($_FILES['imagen']["tmp_name"])){
                    $nombreDirectorio = "subidas/";
                    $nombreFichero = $_FILES['imagen']['name'];
                    $nombreCompleto = $nombreDirectorio.$nombreFichero;
                    if (!is_dir($nombreDirectorio)) {
                        mkdir($nombreDirectorio, 0755, true);
                        chown($nombreDirectorio, 'www-data');
                    }
                    if(is_file($nombreCompleto)){
                        $idUnico=time();
                        $nombreFichero = $idUnico."-".$nombreFichero;   
                    }
                    $_POST['data']['imagen']=$nombreFichero;
                    if(!move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreDirectorio.$nombreFichero)){
                        $errores['file'] = "Error en la subida";
                    }
                }
                else{
                    $errores['file'] = "Error en la carga";
                }
                if(empty($errores)){
                    $this->productosService->addProduct($_POST['data']);
                    $this->gestionProductos();
                }else{
                    $this->pages->render("pages/admin/gestionProductos",["productos"=>$productos,"categorias"=>$categorias,"relleno"=>$datos,"errores"=>$errores]);
                }
            }else{
                $this->pages->render("pages/admin/gestionProductos",["productos"=>$productos,"categorias"=>$categorias,"relleno"=>$datos,"errores"=>$errores]);
            }
            
            
        }
        /**
         * Función para gestionar las opciones de los productos
         */
        public function opcionesProducto() : void {
            Utils::checkSesionAdmin();
            if(isset($_POST['borrar'])){
                $this->productosService->borrar($_POST['borrar']);
                $this->gestionProductos();
            } elseif (isset($_POST['activar'])){
                $this->productosService->activar($_POST['activar']);
                $this->gestionProductos();
            }elseif (isset($_POST['editar'])){
                $productos = $this->productosService->findAll();
                $categorias = $this->categoriasService->findAll();
                $result = $this->productosService->find($_POST['editar']);
                $this->pages->render("pages/admin/gestionProductos",["productos"=>$productos,"categorias"=>$categorias,"productoEditar"=>$result]);
            }
        }
        /**
         * Función para editar los productos
         */
        public function editarProduct() {
            Utils::checkSesionAdmin();
            $array = $_POST['data'];
            if ($_FILES['imagen']['tmp_name'] == ""){
                $array['imagen'] = $_POST['imagen_anterior'];
            }else{
                if(is_uploaded_file($_FILES['imagen']["tmp_name"])){
                    $nombreDirectorio = "subidas/";
                    $nombreFichero = $_FILES['imagen']['name'];
                    $nombreCompleto = $nombreDirectorio.$nombreFichero;
                    if (!is_dir($nombreDirectorio)) {
                        mkdir($nombreDirectorio, 0755, true);
                        chown($nombreDirectorio, 'www-data');
                    }
                    if(is_file($nombreCompleto)){
                        $idUnico=time();
                        $nombreFichero = $idUnico."-".$nombreFichero;   
                    }
                    $array['imagen']=$nombreFichero;
                    if(!move_uploaded_file($_FILES['imagen']['tmp_name'], $nombreDirectorio.$nombreFichero)){
                        $errores['file'] = "Error en la subida";
                    }
                }
                else{
                    $errores['file'] = "Error en la carga";
                }
            }
            $this->productosService->editarProduct($array);
            $this->gestionProductos();
        }
        /**
         * Función para ver todos los pedidos
         */
        public function showAllPedidos() {
            Utils::checkSesionAdmin();
            $result = $this->pedidosService->findAll();
            $this->pages->render("pages/admin/gestionPedidos",["pedidos"=>$result]);
        }
        /**
         * Función para ver todos productos de cada pedido
         */
        public function showDetallePedidos() {
            Utils::checkSesionAdmin();
            $result = $this->pedidosService->findAll();
            $id_pedido = $_POST['detalle'];
            $resultDetalles = $this->lineasService->findAll($id_pedido);
            $this->pages->render("pages/admin/gestionPedidos",["pedidos"=>$result,"detalles"=>$resultDetalles]);
        }
        /**
         * Función para cambiar el estado del pedido
         */
        public function changeEstado($id){
            Utils::checkSesionAdmin();
            $errores = [];
            Pedidos::validationEdit($_POST['estado'],$errores);
            if(empty($errores)){
                $this->pedidosService->changeEstado($id,$_POST['estado']);
                header("Location:".BASE_URL."gestionPedidos");
            }else{
                $result = $this->pedidosService->findAll();
                $this->pages->render("pages/admin/gestionPedidos",["pedidos"=>$result, "errores"=>$errores]);
            }
        }
        /**
         * Función para gestionar los usuarios
         */
        public function gestionUsuarios() : void {
            Utils::checkSesionAdmin();
            $usuarios = $this->usuariosService->allUsers();
            $this->pages->render("pages/admin/gestionUsuarios",["usuarios"=>$usuarios]);
        }
        /**
         * Función para modificar el rol de los usuarios
         */
        public function modRol() :void {
            Utils::checkSesionAdmin();
            $id = $_POST['editar'];
            $rol = $_POST['edit'];
            $this->usuariosService->modRol($id,$rol);
            header("Location:".BASE_URL."gestionUsuarios");
        }
        public function addUserAdmin() :void {
            Utils::checkSesionAdmin();
            $usuarios = $this->usuariosService->allUsers();
            $this->pages->render("pages/admin/gestionUsuarios",["usuarios"=>$usuarios,"addUser"=>true]);
        }
    }