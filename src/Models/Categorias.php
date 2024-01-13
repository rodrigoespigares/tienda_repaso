<?php

namespace Models;

use Lib\Validar;

class Categorias{
    public function __construct(
        private string|null $id = null,
        private string $nombre,
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

    // Getter y Setter para $borrado
    public function getBorrado(): ?string {
        return $this->borrado;
    }

    public function setBorrado(?string $borrado): void {
        $this->borrado = $borrado;
    }

    public static function fromArray(array $data): Categorias
    {
        return new Categorias(
            $data['id'] ?? null,
            $data['nombre'] ?? "",
            $data['borrado'] ?? "",
        );
    }
}