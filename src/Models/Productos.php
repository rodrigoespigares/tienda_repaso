<?php

namespace Models;

use Lib\Validar;

class Productos{
    protected static $errores;
    public function __construct(
        private string|null $id = null,
        private string $categoria_id,
        private string $nombre,
        private string $descripcion,
        private string $precio,
        private string $stock,
        private string $oferta,
        private string $fecha,
        private string $imagen,
        private string $borrado
    ){}

    // Getter y Setter para $id
    public function getId(): ?string {
        return $this->id;
    }

    public function setId(?string $id): void {
        $this->id = $id;
    }

    // Getter y Setter para $nombre
    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    // Getter y Setter para $imagen
    public function getImagen(): string {
        return $this->imagen;
    }
    public function setImagen(string $imagen): void {
        $this->imagen = $imagen;
    }
    
    // Getter y Setter para $categoria_id
    public function getCategoriaId(): string {
        return $this->categoria_id;
    }

    public function setCategoriaId(string $categoria_id): void {
        $this->categoria_id = $categoria_id;
    }

    // Getter y Setter para $descripcion
    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    // Getter y Setter para $precio
    public function getPrecio(): string {
        return $this->precio;
    }

    public function setPrecio(string $precio): void {
        $this->precio = $precio;
    }

    // Getter y Setter para $stock
    public function getStock(): string {
        return $this->stock;
    }

    public function setStock(string $stock): void {
        $this->stock = $stock;
    }

    // Getter y Setter para $oferta
    public function getOferta(): string {
        return $this->oferta;
    }

    public function setOferta(string $oferta): void {
        $this->oferta = $oferta;
    }

    // Getter y Setter para $fecha
    public function getFecha(): string {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }
    // Getter y Setter para $borrado
    public function getBorrado(): string {
        return $this->borrado;
    }

    public function setBorrado(string $borrado): void {
        $this->borrado = $borrado;
    }
    /**
     * Crea un producto a partir de un array
     */
    public static function fromArray(array $data): Productos
    {
        return new Productos(
            $data['id'] ?? null,
            $data['categoria_id'] ?? '',
            $data['nombre'] ?? "",
            $data['descripcion'] ?? "",
            $data['precio'] ?? "",
            $data['stock'] ?? "",
            $data['oferta'] ?? "",
            $data['fecha'] ?? "",
            $data['imagen'] ?? "",
            $data['borrado'] ?? "",
        );
    }
    /**
     * Función para validar un producto
     */
    public static function validation(array $data, array &$errores): array
    {
        #Comprobar que tenga una buena forma;
        ##############
        #   Nombre   #
        ##############
        if (empty($data['nombre'])) {
            $errores['nombre'] = "Nombre obligatorio";
        } elseif (!Validar::son_letras($data['nombre'])) {
            $errores['nombre'] = "Nombre tiene caracteres extraños";
        }
        #####################
        #    Descripcion    #
        #####################
        if (empty($data['descripcion'])) {
            $errores['descripcion'] = "Descripcion obligatorio";
        } elseif (!Validar::son_letras($data['descripcion'])) {
            $errores['descripcion'] = "Descripcion tiene caracteres extraños";
        }
        ##############
        #   Precio   #
        ##############
        if (empty($data['precio'])) {
            $errores['precio'] = "Precio obligatorio";
        } elseif ($data['precio']<=0) {
            $errores['precio'] = "Precio es menor o igual que 0";
        }
        ##############
        #    Stock   #
        ##############
        if (empty($data['stock'])) {
            $errores['stock'] = "Stock obligatorio";
        }
        ##############
        #    Fecha   #
        ##############
        if (empty($data['fecha'])) {
            $errores['fecha'] = "Fecha obligatorio";
        }elseif (!Validar::validarFecha($data['fecha'])) {
            $errores['fecha'] = "Formato incorrecto";
        }

        return $errores;
    }
}