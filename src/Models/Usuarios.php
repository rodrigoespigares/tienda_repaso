<?php

namespace Models;

use Lib\Validar;

class Usuarios
{
    protected static $errores;
    public function __construct(
        private string|null $id = null,
        private string $nombre,
        private string $apellidos,
        private string $email,
        private string $password,
        private string $rol
    ) {
    }
    /**
     * Get the value of id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     */
    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of rol
     */
    public function getRol(): string
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     */
    public function setRol(string $rol): self
    {
        $this->rol = $rol;

        return $this;
    }
    /**
     * Crea un usuario a partir de un array
     */
    public static function fromArray(array $data): Usuarios
    {
        return new Usuarios(
            $data['id'] ?? null,
            $data['nombre'] ?? '',
            $data['apellidos'] ?? "",
            $data['email'] ?? "",
            $data['password'] ?? "",
            $data['rol'] ?? "user",
        );
    }
    /**
     * Función para validar un usuario
     */
    public static function validation(array $data, array &$errores): array
    {
        $pass1 = $data['password'];
        $pass2 = $data['password2'];
        $email = $data['email'];
        $name = $data['name'];
        $subname = $data['subname'];
        ##############
        #  PASSWORD  #
        ##############
        if (empty($pass1)) {
            $errores['password'] = "Contraseña obligatoria";
        } elseif ($pass1 != $pass2) {
            $errores['password'] = "Las contraseñas no coinciden";
            $errores['password2'] = "Las contraseñas no coinciden";
        }
        if (strlen($pass1) <= 8) {
            $errores['password'] = "Contraseña debe tener más de 8 caracteres";
        }
        #Comprobar que tenga una buena forma;
        ##############
        #   EMAIL    #
        ##############
        if (empty($email)) {
            $errores['email'] = "Email obligatorio";
        } elseif (!Validar::esEmail($email)) {
            $errores['email'] = "Email tiene caracteres extraños";
        }
        ##############
        #    NAME    #
        ##############
        if (!empty($name) && !Validar::son_letras($name)) {
            $errores['name'] = "Nombre tiene caracteres extraños";
        }
        ##############
        #  SUBNAME   #
        ##############
        if (!empty($subname) && !Validar::son_letras($subname)) {
            $errores['subname'] = "Apellidos tiene caracteres extraños";
        }


        return $errores;
    }
    /**
     * Funcion para validar el usuario si es un login
     */
    public static function validationLogin(array $data,array &$errores) : array {
        $pass1 = $data['password'];
        $email = $data['email'];
        if (empty($pass1)) {
            $errores['password'] = "Contraseña obligatoria";
        }
        if (empty($email)) {
            $errores['email'] = "Email obligatorio";
        } elseif (!Validar::esEmail($email)) {
            $errores['email'] = "Email tiene caracteres extraños";
        }
        return $errores;
    }
}
