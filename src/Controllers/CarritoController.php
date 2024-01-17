<?php
    namespace Controllers;
    use Lib\Pages;
    use Lib\Correo;
    use Lib\Utils;
    use Services\ProductosService;
    use Services\PedidosService;
    use Services\LineasPedidosService;
    class CarritoController{
        private ProductosService $service;
        private Pages $pages;
        private Correo $correo;
        private PedidosService $pedidosService;
        private LineasPedidosService $lineasService;
        public function __construct()
        {
            $this->pedidosService = new PedidosService();
            $this->service = new ProductosService();
            $this->lineasService = new LineasPedidosService();
            $this->pages = new Pages();   
            $this->correo = new Correo();
        }
        /**
         * Función para ver todos los productos del carrito
         */
        public function index():void {
            $respuesta = [];            
            foreach ($_SESSION['carrito'] as $value) {
                $productos = unserialize($value["producto"]);
                array_push($respuesta,["productos"=>$productos,"unidades"=>$value['unidades'],'id'=>$value['id']]);
            }
            $this->pages->render("pages/carrito/index",["productosCarrito"=>$respuesta]);
        }
        /**
         * Función para quitar un producto de la cantidad total del carrito
         */
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
        /**
         * Función para borrar del carrito
         * 
         * @param string $id con el id del producto a borrar
         */
        public function borrar(string $id):void {
            foreach ($_SESSION['carrito'] as $key => $value) {
                if($value['id']==$id){
                    $_SESSION['carrito'][$key]["unidades"] = 0;
                    if ($_SESSION['carrito'][$key]["unidades"]==0) {
                        unset($_SESSION['carrito'][$key]);
                    }
                }
                header("Location:".BASE_URL."carrito");
            }
        }
        /**
         * Función para añadir un producto al carrito
         */
        public function push() {
            $id = intval($_GET["id"]);
            $result = $this->service->find($id);
            $isAdd = false;
            foreach ($_SESSION['carrito'] as $key => $value) {
                if($value['id']==$id){
                    $isAdd = true;
                    if($_SESSION['carrito'][$key]["unidades"]+1 <= $result[0]->getStock()){
                        $_SESSION['carrito'][$key]["unidades"]++;
                    }
                }
            }
            if(!$isAdd && $result[0]->getStock()>0 && $result[0]->getBorrado() == 0){
                array_push($_SESSION['carrito'], ["id"=>$id,"unidades"=>1,"producto"=>serialize($result)]);
            }
            header("Location:".BASE_URL);
        }
        /**
         * Función para añadir un producto de la cantidad total del carrito
         */
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
        /**
         * Función para cargar el formulario del carrito
         */
        public function pedido(){
            Utils::checkSesion();
            $this->pages->render("pages/carrito/pedido",["carrito"=>$_SESSION['carrito']]);
        }
        /**
         * Función para realizar el pedido
         */
        public function pedir(){
            Utils::checkSesion();
            $datos = $_POST['data'];
            $usuario = $_SESSION['identity']['nombre'];
            $email = $_SESSION['identity']['email'];
            # VALIDAR DATOS
            # PRIMERO RESTAR EL STOCK
            $this->service->nuevoPedido($datos);
            $_SESSION['carrito'] = null;
            $this->correo->sendMail($email,$usuario);
            header("Location:".BASE_URL);
        }
        /**
         * Función para que cada usuario pueda ver sus pedidos
         */
        public function showPedidos(){
            Utils::checkSesion();
            $id = $_SESSION['identity']['id'];
            $result = $this->pedidosService->find($id);
            $this->pages->render("pages/carrito/misPedidos",["pedidos"=>$result]);
        }
        /**
         * Función para ver los usuario puedan ver los detalles de cada pedido
         */
        public function showDetalle(){
            Utils::checkSesion();
            $id = $_SESSION['identity']['id'];
            $result = $this->pedidosService->find($id);
            $id_pedido = $_POST['detalle'];
            $resultDetalles = $this->lineasService->findAll($id_pedido);
            $this->pages->render("pages/carrito/misPedidos",["pedidos"=>$result,"detalles"=>$resultDetalles]);

        }
    }