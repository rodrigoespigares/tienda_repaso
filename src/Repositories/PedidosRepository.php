<?php

namespace Repositories;

use Lib\DataBase;
use Models\Pedidos;
use Services\LineasPedidosService;
use PDOException;
use PDO;

class PedidosRepository
{
    private DataBase $conection;
    private LineasPedidosService $service;
    private mixed $sql;
    function __construct()
    {
        $this->conection = new DataBase();
        $this->service = new LineasPedidosService();
    }
    /**
     * Fución para obtener todos los datos
     * 
     * @return array si hay datos
     */
    public function findAll():? array {
        $this->conection->querySQL("SELECT * FROM pedidos;");
        
        return $this->extractAll();
    }
    /**
     * Función para extraer todos los pedidos
     * 
     * @return array si hay resultados
     */
    public function extractAll():?array {
        $resultado = [];
        try{
            $resultadosData = $this->conection->allRegister();
            foreach ($resultadosData as $resultadoData){
                $resultado[]=Pedidos::fromArray($resultadoData);
            }
        }catch(PDOException){
            $resultado=null;
        }
        return $resultado;
    }
    /**
     * Función para buscar un pedido por el id
     * 
     * @param string $id con el id a buscar
     * 
     * @return array con los datos
     */
    public function find(string $id) :?array
    {
        $result = [];
        try {
            $this->sql = $this->conection->prepareSQL("SELECT * FROM pedidos WHERE usuario_id=:usuario_id;");
            $this->sql->bindValue(":usuario_id", $id);
            $this->sql->execute();
            $resultados = $this->sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultados as $resultadoData){
                $result[]=Pedidos::fromArray($resultadoData);
            }
            $this->sql->closeCursor();
        } catch (PDOException $e) {
            $result = null;
        }
        $this->sql = null;
        return $result;
    }
    /**
     * Función para hacer un nuevo pedido
     * 
     * @param array $datos con los datos del pedido
     * 
     * @return string con el id del ultimo insert si no hay errores
     */
    public function nuevoPedido(array $datos) :?string
    {
        try {
            $this->conection->beginTransaction();
            $this->sql = $this->conection->prepareSQL("INSERT INTO pedidos(usuario_id,provincia,localidad,direccion,coste,estado,fecha,hora) VALUES (:usuarios_id,:provincia,:localidad,:direccion,:coste,:estado,:fecha,:hora);");
            $costeTotal = 0;
            foreach ($_SESSION['carrito'] as $key => $value) {
                $costeTotal += $value['unidades'] * intval(unserialize($value['producto'])[0]->getPrecio());
            }
            $estado = "pendiente";
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $this->sql->bindValue(":usuarios_id", $_SESSION['identity']['id']);
            $this->sql->bindValue(":provincia", $datos['provincia']);
            $this->sql->bindValue(":localidad", $datos['localidad']);
            $this->sql->bindValue(":direccion", $datos['direccion']);
            $this->sql->bindValue(":coste", $costeTotal);
            $this->sql->bindValue(":estado", $estado);
            $this->sql->bindValue(":fecha", $fecha);
            $this->sql->bindValue(":hora", $hora);
            $this->sql->execute();
            $result = $this->conection->lastInsertId();
            $this->conection->commit();
            $this->service->nuevoPedido($result);
        } catch (PDOException $e) {
            $this->conection->rollBack();
            $result = $e->getMessage();
        }
        $this->sql->closeCursor();
        $this->sql = null;
        return $result;
    }
    /**
     * Funcion para cambiar el estado del pedido
     * 
     * @param string $id con el id del pedido
     * @param string $estado con el nuevo estado
     * 
     * @return string si hay error
     */
    public function changeEstado(string $id,string $estado):? string{
        try {
            $this->sql = $this->conection->prepareSQL("UPDATE pedidos SET estado = :estado WHERE id = :id;");
            $this->sql->bindValue(":id", $id);
            $this->sql->bindValue(":estado", $estado);
            $this->sql->execute();
            $result = null;
            $this->sql->closeCursor();
        } catch (PDOException $e) {
            $result = $e->getMessage();
        }
        $this->sql = null;
        return $result;
    }
}
