<?php
    namespace Controllers;
    use Lib\Pages;
    use Services\CategoriasService;
    use Services\ProductosService;
    class AdminController{
        private CategoriasService $categoriasService;
        private ProductosService $productosService;
        private Pages $pages;
        public function __construct()
        {
            $this->categoriasService = new CategoriasService();
            $this->productosService = new ProductosService();
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
        public function opcionesCategoria() : void {
            if(isset($_POST['borrar'])){
                $this->categoriasService->borrar($_POST['borrar']);
                $this->gestionCategorias();
            } elseif (isset($_POST['activar'])){
                $this->categoriasService->activar($_POST['activar']);
                $this->gestionCategorias();
            }elseif (isset($_POST['editar'])){
                echo "SIN HACER";
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
                echo "SIN HACER";
            }
        }
    }