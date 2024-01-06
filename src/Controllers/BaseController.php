<?php
namespace Controllers;

use Lib\Pages;
use Services\ProductosService;
class BaseController {
    private Pages $pages;
    private ProductosService $productosService;
    public function __construct() {
        $this->productosService = new ProductosService();
        $this->pages = new Pages();
    }
    public function showPage(): void {
        $productos = $this->productosService->findAll();
        $this->pages->render("pages/base/principal",["productos"=>$productos]);
    }
    public function ver() : void {
        $productos = $this->productosService->findCategory($_GET["id"]);
        $this->pages->render("pages/base/principal",["productos"=>$productos]);
    }
}