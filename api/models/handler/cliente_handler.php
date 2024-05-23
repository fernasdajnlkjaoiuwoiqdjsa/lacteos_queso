<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla CLIENTE.
*/
class ClienteHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */
    protected $id = null;
    protected $nombrecli = null;
    protected $edad = null;
    protected $direccion = null;
    protected $correocli = null;
    protected $telefonocli = null;
    protected $relacioncli = null;
    protected $fechaingreso = null;


    /*
    *   Métodos para gestionar la cuenta del cliente.
    */
    public function checkUser($mail, $password)
    {
        $sql = 'SELECT id_cliente, correo_Cliente
                FROM clientes
                WHERE correo_Cliente = ?';
        $params = array($mail);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['correo_cliente'])) {
            $this->id = $data['id_cliente'];
            $this->correocli = $data['correo_cliente'];
            return true;
        } else {
            return false;
        }
    }

    public function checkStatus()
    {
        if ($this->fechaingreso) {
            $_SESSION['id_cliente'] = $this->id;
            $_SESSION['correo_cliente'] = $this->correocli;
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE clientes
                WHERE id_cliente = ?';
        $params = array( $this->id);
        return Database::executeRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE clientes
                SET nombre_cliente = ?, edad_cliente = ?, direccion = ?, correo_Cliente = ?, telefono_cliente = ?, relacion_cliente = ?, fecha_registro = ?
                WHERE id_cliente = ?';
        $params = array($this->nombrecli, $this->edad, $this->direccion, $this->correocli, $this->telefonocli, $this->relacioncli, $this->fechaingreso, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function changeStatus()
    {
        $sql = 'UPDATE clientes
                SET fecha_ingreso = ?
                WHERE id_cliente = ?';
        $params = array($this->fechaingreso, $this->id);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_cliente, nombre_cliente, edad_cliente, direccion, correo_Cliente, telefono_cliente, relacion_cliente, fecha_registro
                FROM clientes
                WHERE edad_cliente LIKE ? OR nombre_cliente LIKE ? OR correo_cliente LIKE ?
                ORDER BY edad_cliente';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO clientes(nombre_cliente, edad_cliente, direccion, correo_Cliente, telefono_cliente, relacion_cliente, fecha_registro)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombrecli, $this->edad, $this->correocli, $this->telefonocli, $this->relacioncli, $this->fechaingreso);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, edad_cliente, direccion, correo_Cliente, telefono_cliente,relacion_cliente,fecha_registro
                FROM clientes
                ORDER BY edad_cliente';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, edad_cliente, direccion, correo_Cliente, telefono_cliente,relacion_cliente,fecha_registro
                FROM Clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE clientes
                SET nombre_cliente = ?, edad_cliente = ?, direccion = ?, correo_Cliente = ?, telefono_cliente = ?, relacion_cliente = ?, fecha_registro = ?
                WHERE id_cliente = ?';
        $params = array($this->nombrecli, $this->edad, $this->direccion, $this->correocli, $this->telefonocli, $this->relacioncli, $this->fechaingreso, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function checkDuplicate($value)
    {
        $sql = 'SELECT id_cliente
                FROM clientes
                WHERE correo_cliente = ? OR telefono_cliente = ?';
        $params = array($value, $value);
        return Database::getRow($sql, $params);
    }
}
