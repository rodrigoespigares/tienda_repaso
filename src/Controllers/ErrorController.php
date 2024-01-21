<?php
// Uso la clase monedero llamandola con su espacion de nombres
namespace Controllers;
use Lib\Pages;
/**
 * Clase para controlar errores
 */
class ErrorController
{
    private Pages $pages;
    public function __construct()
    {
        $this->pages = new Pages();
    }

    /**
     * Creando la funcion para probocar el error 404
     *
     * @return void
     */
    public function show_err404(): void
    {
        $this->pages->render("pages/error");
    }
}
