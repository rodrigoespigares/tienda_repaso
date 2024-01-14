<?php
    namespace Controllers;
    use Lib\Pages;
    use Services\CategoriasService;
    use Services\ProductosService;
    use Services\PedidosService;
    class AdminController{
        private CategoriasService $categoriasService;
        private ProductosService $productosService;
        private PedidosService $pedidosService;
        private Pages $pages;
        public function __construct()
        {
            $this->categoriasService = new CategoriasService();
            $this->productosService = new ProductosService();
            $this->pedidosService = new PedidosService();
            $this->pages = new Pages();
        }
        public function gestionCategorias() : void {
            $categorias = $this->categoriasService->findAll();
            $this->pages->render("pages/admin/gestionCategorias",["cats"=>$categorias]);
        }
        public function addCategory() : void {
            $this->categoriasService->addCategory($_POST['nombre']);
            $this->gestionCategorias();
        }
        public function editarCategoria() :void {
            $this->categoriasService->editar($_POST['data']);
            $this->gestionCategorias();
        }
        public function opcionesCategoria() : void {
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
        public function gestionProductos() : void {
            $productos = $this->productosService->findAll();
            $categorias = $this->categoriasService->findAll();
            $this->pages->render("pages/admin/gestionProductos",["productos"=>$productos,"categorias"=>$categorias]);
        }
        public function addProduct() : void {
            
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
            $this->productosService->addProduct($_POST['data']);
            $this->gestionProductos();
        }
        public function opcionesProducto() : void {
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
        public function editarProduct() {
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
        public function showAllPedidos() {
            $result = $this->pedidosService->findAll();
            $this->pages->render("pages/admin/gestionPedidos",["pedidos"=>$result]);
        }
        public function changeEstado($id){
            $this->pedidosService->changeEstado($id,$_POST['estado']);
            header("Location:".BASE_URL."gestionPedidos");
        }
    }