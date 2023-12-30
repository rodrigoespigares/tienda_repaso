<?php

namespace Models;

use Lib\Validar;

class Pedidos{
    protected static $errores;
    public function __construct(
        private string|null $id = null,
        private string $usuario_id,
        private string $provincia,
        private string $localidad,
        private string $direccion,
        private string $coste,
        private string $estado,
        private string $fecha,
        private string $hora
    ){}

    // Getter y Setter para $id
    public function getId(): ?string {
        return $this->id;
    }

    public function setId(?string $id): void {
        $this->id = $id;
    }

    // Getter y Setter para $usuario_id
    public function getUsuario_id(): string {
        return $this->usuario_id;
    }

    public function setUsuario_id(string $usuario_id): void {
        $this->usuario_id = $usuario_id;
    }

    // Getter y Setter para $provincia
    public function getProvincia(): string {
        return $this->provincia;
    }
    public function setProvincia(string $provincia): void {
        $this->provincia = $provincia;
    }

    // Getter y Setter para $localidad
    public function getLocalidad(): string {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): void {
        $this->localidad = $localidad;
    }
    // Getter y Setter para $direccion
    public function getDireccion(): string {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void {
        $this->direccion = $direccion;
    }

    // Getter y Setter para $estado
    public function getEstado(): string {
        return $this->estado;
    }

    public function setEstado(string $estado): void {
        $this->estado = $estado;
    }

    // Getter y Setter para $fecha
    public function getFecha(): string {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

    // Getter y Setter para $hora
    public function getHora(): string {
        return $this->hora;
    }

    public function setHora(string $hora): void {
        $this->hora = $hora;
    }

    public static function fromArray(array $data): Pedidos
    {
        return new Pedidos(
            $data['id'] ?? null,
            $data['usuario_id'] ?? '',
            $data['provincia'] ?? "",
            $data['localidad'] ?? "",
            $data['direccion'] ?? "",
            $data['coste'] ?? "",
            $data['estado'] ?? "",
            $data['fecha'] ?? "",
            $data['hora'] ?? "",
        );
    }
}