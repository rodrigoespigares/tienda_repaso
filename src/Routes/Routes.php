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
            // CATEGORIAS MENU
            Router::add('GET', '/c?id=:id', function ($id) {
                return (new BaseController())->ver($id);
            });

            // AÑADIR CATEGORIAS Y PRODUCTOS
            Router::add('POST','/addC', function (){
                return (new AdminController())->addProduct();
            });
            Router::add('POST','/addP', function (){
                return (new AdminController())->addProduct();
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
            

            Router::add('GET', '/contacto/:id', function ($id) {
                return (new ContactoController())->showContact($id);
            });
            Router::add('GET', '/?page=:id', function ($id) {
                return (new ContactoController())->showAll($id);
            });

            // ERROR 404
            Router::add('GET', '/error', function ($id) {
                return (new ErrorController())->show_err404();
            });
            Router::dispatch();
        }
    }