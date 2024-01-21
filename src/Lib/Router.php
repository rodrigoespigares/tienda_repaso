<?php
namespace Lib;
// para almacenar las rutas que configuremos desde el archivo index.php
class Router {

    private static $routes = [];
    //para ir añadiendo los métodos y las rutas en el tercer parámetro.
    public static function add(string $method, string $action, Callable $controller):void{
        //die($action);
        $action = trim($action, '/');
       
        self::$routes[$method][$action] = $controller;
       
    }
   
    // Este método se encarga de obtener el sufijo de la URL que permitirá seleccionar
    // la ruta y mostrar el resultado de ejecutar la función pasada al metodo add para esa ruta
    // usando call_user_func()
    public static function dispatch():void {
        $method = $_SERVER['REQUEST_METHOD']; 
        //print_r($_SERVER);die($method);
        
        $action = preg_replace('/tienda_repaso/','',$_SERVER['REQUEST_URI']);
       //$_SERVER['REQUEST_URI'] almacena la cadena de texto que hay después del nombre del host en la URL
        $action = trim($action, '/');

        $param1 = null;
        $param2 = null;
        preg_match('/(\d+)(?:&page=(\d+))?$/', $action, $match);
        if(!empty($match)){
            
            $param1 = $match[1];
            
            $param2 = isset($match[2])?$match[2]:null;
            $action=preg_replace('/'.$match[1].'/',':id',$action);//quitamos la primera parte que se repite siempre (clinicarouter)
            if(isset($match[2])){
                $action=preg_replace('/'.$match[2].'/',':page',$action);
            }
        }
        /*-*-*-*-*-*-*-*-*-* VIEJO *-*-*-*-*-*-*-*-*-
        $callback = self::$routes[$method][$action];
        
        echo call_user_func($callback, $param1, $param2);
        
        
        /*-*-*-*-*-*-*-* MUESTRA ERROR *-*-*-*-*-*-*-*/

        if (isset(self::$routes[$method][$action])) {
            $callback = self::$routes[$method][$action];
            echo call_user_func($callback, $param1, $param2);
        } else {
            header("Location:".BASE_URL."error");
        } 
    }
}
