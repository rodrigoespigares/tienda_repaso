<?php

    namespace Lib;
    use DateTime;
    class Utils{
        /**
         * Función que revisa si la sesión esta iniciada y 
         * en caso de no estar iniciada te manda a la url BASE 
         */
        public static function checkSesion() :void {
            if(!isset($_SESSION['identity'])){
                header("Location:".BASE_URL);
            }
        }
        /**
         * Función que revisa si la sesión esta iniciada y que el usuario es administrador.
         * En caso de no estar iniciada o no ser administrador te manda a la url BASE 
         */
        public static function checkSesionAdmin() :void {
            if(!isset($_SESSION['identity'])){
                header("Location:".BASE_URL);
            }
        }
    }