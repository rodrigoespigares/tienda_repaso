<?php
    namespace Controllers;
    use Lib\Pages;
use Models\Pedidos;
use Services\ProductosService;
    use Services\PedidosService;
    use Services\LineasPedidosService;
    class CarritoController{
        private ProductosService $service;
        private Pages $pages;
        private PedidosService $pedidosService;
        private LineasPedidosService $lineasService;
        public function __construct()
        {
            $this->pedidosService = new PedidosService();
            $this->service = new ProductosService();
            $this->lineasService = new LineasPedidosService();
            $this->pages = new Pages();   
        }
        public function index():void {
            $respuesta = [];            
            foreach ($_SESSION['carrito'] as $value) {
                $productos = unserialize($value["producto"]);
                array_push($respuesta,["productos"=>$productos,"unidades"=>$value['unidades'],'id'=>$value['id']]);
            }
            $this->pages->render("pages/carrito/index",["productosCarrito"=>$respuesta]);
        }
        public function down():void {
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                foreach ($_SESSION['carrito'] as $key => $value) {
                    if($value['id']==$id){
                        $_SESSION['carrito'][$key]["unidades"]--;
                        if ($_SESSION['carrito'][$key]["unidades"]==0) {
                            unset($_SESSION['carrito'][$key]);
                        }
                    }
                    header("Location:".BASE_URL."carrito");
                }
            }
        }
        public function push() {
            $id = intval($_GET["id"]);
            if(!isset($_SESSION['carrito'][$id])){
                $result = $this->service->find($id);
                array_push($_SESSION['carrito'], ["id"=>$id,"unidades"=>1,"producto"=>serialize($result)]);
            }else{
                $_SESSION['carrito'][$id]["unidades"]++;
            }
            header("Location:".BASE_URL);
        }
        public function add(){
            $id = $_GET["id"];
            foreach ($_SESSION['carrito'] as $key => $value) {
                if($value['id']==$id){
                    if ($_SESSION['carrito'][$key]["unidades"] < unserialize($_SESSION['carrito'][$key]["producto"])[0]->getStock()) {
                        $_SESSION['carrito'][$key]["unidades"]++;
                    }
                }
                header("Location:".BASE_URL."carrito");
            }
        }
        public function pedido(){
            $this->pages->render("pages/carrito/pedido",["carrito"=>$_SESSION['carrito']]);
        }
        public function pedir(){
            $datos = $_POST['data'];
            
            $usuario = $_SESSION['identity']['nombre'];
            $email = $_SESSION['identity']['email'];
            # VALIDAR DATOS
            # PRIMERO RESTAR EL STOCK
            $this->service->nuevoPedido($datos);
            $_SESSION['carrito'] = null;
            header("Location:".BASE_URL);
        }
        public function showPedidos(){
            $id = $_SESSION['identity']['id'];
            $result = $this->pedidosService->findAll($id);
            $this->pages->render("pages/carrito/misPedidos",["pedidos"=>$result]);
        }
        public function showDetalle(){
            $id = $_SESSION['identity']['id'];
            $result = $this->pedidosService->findAll($id);
            $id_pedido = $_POST['detalle'];
            $resultDetalles = $this->lineasService->findAll($id_pedido);
            $this->pages->render("pages/carrito/misPedidos",["pedidos"=>$result,"detalles"=>$resultDetalles]);

        }
    }