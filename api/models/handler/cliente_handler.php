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
      protected $cuenta = null;
      protected $telefonocli = null;
      protected $contra = null;
      protected $fechaingreso = null;
      protected $estadocliente = null;


      /*
    *   Métodos para gestionar la cuenta del cliente.
    */
      public function checkUser($mail, $password)
      {
            $sql = 'SELECT id_cliente, contra , estado_cliente, cuenta_cliente
                FROM clientes
                WHERE cuenta_cliente = ?';
            $params = array($mail);
            if (!$data = Database::getRow($sql, $params)) {
                  return false;
            } elseif (password_verify($password, $data['contra'])) {
                  $this->id = $data['id_cliente'];
                  $this->cuenta = $data['cuenta_cliente'];
                  $this->estadocliente = $data['estado_cliente'];
                  return true;
            } else {
                  return false;
            }
      }
        // accion para chequear los dtaos de la bd.
      public function checkStatus()
      {
            if ($this->estadocliente) {
                  $_SESSION['id_cliente'] = $this->id;
                  $_SESSION['cuenta_cliente'] = $this->cuenta;
                  return true;
            } else {
                  return false;
            }
      }
        // accion ejecutar la accion de la contraseña.
      public function changePassword()
      {
            $sql = 'UPDATE clientes
                WHERE id_cliente = ?';
            $params = array($this->id);
            return Database::executeRow($sql, $params);
      }
      // accion ejecutar la accion de cambiar el nombre y contraseña del cliente
      public function editProfile()
      {
            $sql = 'UPDATE clientes
                SET nombre_cliente = ?, edad_cliente = ?, direccion = ?, cuenta_cliente = ?, telefono_cliente = ?, relaciocontran_cliente = ?, fecha_registro = ?, estado_cliente = ?
                WHERE id_cliente = ?';
            $params = array($this->nombrecli, $this->edad, $this->direccion, $this->cuenta, $this->telefonocli, $this->contra, $this->fechaingreso, $this->estadocliente);
            return Database::executeRow($sql, $params);
      }
      // accion ejecutar la accion dentro de la sesion.
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
            $sql = 'SELECT id_cliente, nombre_cliente, edad_cliente, direccion, cuenta_cliente, telefono_cliente, contra, fecha_registro, estado_cliente
                FROM clientes
                WHERE edad_cliente LIKE ? OR nombre_cliente LIKE ? OR cuenta_cliente LIKE ?
                ORDER BY nombre_cliente';
            $params = array($value, $value, $value);
            return Database::getRows($sql, $params);
      }
        // accion para quese pueda registrar un nuevo cliente poniendo los parrametros de la base .
      public function createRow()
      {
            $sql = 'INSERT INTO clientes(nombre_cliente, edad_cliente, direccion, cuenta_cliente, telefono_cliente, contra, fecha_registro )
                VALUES(?, ?, ?, ?, ?, ?, ?)';
            $params = array($this->nombrecli, $this->edad, $this->direccion, $this->cuenta, $this->telefonocli, $this->contra, $this->fechaingreso);
            return Database::executeRow($sql, $params);
      }
        // accion para leer los datos de los clientes .
      public function readAll()
      {
            $sql = 'SELECT id_cliente, nombre_cliente, edad_cliente, direccion, cuenta_cliente, telefono_cliente,contra,fecha_registro
                FROM clientes
                ORDER BY nombre_cliente';
            return Database::getRows($sql);
      }
        // accion para leer los datos.
      public function readOne()
      {
            $sql = 'SELECT id_cliente, nombre_cliente, edad_cliente, direccion, cuenta_cliente, telefono_cliente,contra,fecha_registro
                FROM clientes
                WHERE id_cliente = ?';
            $params = array($this->id);
            return Database::getRow($sql, $params);
      }
        // accion para actualizar un nuevo cliente .
      public function updateRow()
      {
            $sql = 'UPDATE clientes
                SET nombre_cliente = ?, edad_cliente = ?, direccion = ?, cuenta_cliente = ?, telefono_cliente = ?, contra = ?, fecha_registro = ?
                WHERE id_cliente = ?';
            $params = array($this->nombrecli, $this->edad, $this->direccion, $this->cuenta, $this->telefonocli, $this->contra, $this->fechaingreso);
            return Database::executeRow($sql, $params);
      }
        // accion para eliminar o dar de baja al cliente.
      public function deleteRow()
      {
            $sql = 'DELETE FROM clientes
                WHERE id_cliente = ?';
            $params = array($this->id);
            return Database::executeRow($sql, $params);
      }
        // accion para verificar que los datos no se dupliquen.
      public function checkDuplicate($value)
      {
            $sql = 'SELECT id_cliente
                FROM clientes
                WHERE cuenta_cliente = ? OR telefono_cliente = ?';
            $params = array($value, $value);
            return Database::getRow($sql, $params);
      }
}
