<?php

    namespace Routes;
    use Lib\Router;
    use Controllers\BaseController;
    use Controllers\LoginController;
    use Controllers\AdminController;
    use Controllers\CarritoController;
    use Controllers\ErrorController;
    class Routes{
        public static function index() {
            // HOME
            Router::add('GET','/', function (){
                return (new BaseController())->showPage();
            });
            // LOGIN
            Router::add('POST','/login', function (){
                return (new LoginController())->login();
            });
            Router::add('GET','/login', function (){
                return (new LoginController())->login();
            });
            // VALIDACION
            Router::add('POST','/vlogin', function (){
                return (new LoginController())->vLogin();
            });
            // LOGOUT
            Router::add('POST','/logout', function (){
                return (new LoginController())->logout();
            });
            // ADMIN MENU
            Router::add('GET','/gestionCategorias', function (){
                return (new AdminController())->gestionCategorias();
            });
            Router::add('GET','/gestionProductos', function (){
                return (new AdminController())->gestionProductos();
            });
            Router::add('GET','/gestionUsuarios', function (){
                return (new AdminController())->gestionUsuarios();
            });
            Router::add('GET','/gestionPedidos', function (){
                return (new AdminController())->showAllPedidos();
            });
            // CATEGORIAS MENU
            Router::add('GET', '/c?id=:id', function ($id) {
                return (new BaseController())->ver($id);
            });
            // AÑADIR CATEGORIAS Y PRODUCTOS
            Router::add('POST','/addC', function (){
                return (new AdminController())->addCategory();
            });
            Router::add('POST','/addP', function (){
                return (new AdminController())->addProduct();
            });

            // EDITAR CATEGORIAS Y PRODUCTOS
            Router::add('POST','/editC', function (){
                return (new AdminController())->editarCategoria();
            });
            Router::add('POST','/editP', function (){
                return (new AdminController())->editarProduct();
            });

            // OPCIONES CATEGORIAS Y PRODUCTOS
            Router::add('POST','/opcionesCat', function (){
                return (new AdminController())->opcionesCategoria();
            });
            Router::add('POST','/opcionesProd', function (){
                return (new AdminController())->opcionesProducto();
            });
            //CARRITO
            Router::add('GET','/carrito', function (){
                return (new CarritoController())->index();
            });
            Router::add('GET', '/push?id=:id', function ($id) {
                return (new CarritoController())->push($id);
            });
            Router::add('GET', '/add?id=:id', function ($id) {
                return (new CarritoController())->add($id);
            });
            Router::add('GET', '/down?id=:id', function ($id) {
                return (new CarritoController())->down($id);
            });

            //PEDIDO
            Router::add('POST','/pedido', function (){
                return (new CarritoController())->pedido();
            });
            Router::add('POST','/pedir', function (){
                return (new CarritoController())->pedir();
            });
            Router::add('GET','/mis_pedidos', function (){
                return (new CarritoController())->showPedidos();
            });
            // DETALLE PEDIDO
            Router::add('POST','/detalle_pedido', function (){
                return (new CarritoController())->showDetalle();
            });
            Router::add('POST','/detalle_pedido_admin', function (){
                return (new AdminController())->showDetallePedidos();
            });
            // GESTION DE PEDIDOS
            Router::add('POST', '/changeEstado/:id', function ($id) {
                return (new AdminController())->changeEstado($id);
            });
            // GESTION DE USUARIOS
            Router::add('POST', '/editUser', function () {
                return (new AdminController())->modRol();
            });

            // ERROR 404
            Router::add('GET', '/error', function () {
                return (new ErrorController())->show_err404();
            });
            Router::dispatch();
        }
    }