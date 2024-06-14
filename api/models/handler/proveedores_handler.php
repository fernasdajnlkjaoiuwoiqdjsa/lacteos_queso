<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla CLIENTE.
*/
class ProveedorHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */
    protected $id = null;
    protected $nombrepro = null;
    protected $apellidopro = null;
    protected $empresa = null;
    protected $correopro = null;
    protected $numeropro = null;
    protected $fecharegistro = null;
    
    /*
    *   Métodos para gestionar la cuenta del cliente.
    */
    public function checkUser($mail, $password)
    {
        $sql = 'SELECT id_proveedor, correo_pro
                FROM proveedores
                WHERE correo_pro = ?';
        $params = array($mail);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['correo_pro'])) {
            $this->id = $data['id_proveedor'];
            $this->correopro = $data['correo_pro'];
            return true;
        } else {
            return false;
        }
    }
    
    //metodo para chequear los datos de la base
    public function checkStatus()
    {
        if ($this->fecharegistro) {
            $_SESSION['id_proveedor'] = $this->id;
            $_SESSION['correo_pro'] = $this->correopro;
            return true;
        } else {
            return false;
        }
    }
     //metodo para chequear los datos correctos y contraseña
    public function changePassword()
    {
        $sql = 'UPDATE proveedores
                WHERE id_proveedor = ?';
        $params = array( $this->id);
        return Database::executeRow($sql, $params);
    }
     //metodo para ediatar el perfil los perfiles
    public function editProfile()
    {
        $sql = 'UPDATE proveedores
                SET nombre_pro = ?, apellido_pro = ?, empresa = ?, correo_pro = ?, numero_pro = ?, fecha_registro = ?
                WHERE id_proveedor = ?';
        $params = array($this->nombrepro, $this->apellidopro, $this->empresa, $this->correopro, $this->numeropro,  $this->fecharegistro, $this->id);
        return Database::executeRow($sql, $params);
    }
     //metodo para chequear los datos de la base
    public function changeStatus()
    {
        $sql = 'UPDATE proveedores
                SET fecha_registro = ?
                WHERE id_proveedor = ?';
        $params = array($this->fecharegistro, $this->id);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */

     //metodo para hacer la accion de busqueds
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_proveedor, nombre_pro, apellido_pro, empresa, correo_pro,numero_pro , fecha_registro
                FROM proveedores
                WHERE apellido_pro LIKE ? OR nombre_pro LIKE ? OR correo_pro LIKE ?
                ORDER BY nombre_pro';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }
     //metodo para agregar y crear nuevos proveedor
    public function createRow()
    {
        $sql = 'INSERT INTO proveedores(nombre_pro, apellido_pro, empresa, correo_pro, numero_pro, fecha_registro)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombrepro, $this->apellidopro, $this->empresa, $this->correopro, $this->numeropro, $this->fecharegistro, $this->id );
        return Database::executeRow($sql, $params);
    }
     //metodo para leer los datos de las tablas
    public function readAll()
    {
        $sql = 'SELECT id_proveedor, nombre_pro, apellido_pro, empresa, correo_pro,numero_pro , fecha_registro
                FROM proveedores
                ORDER BY nombre_pro';
        return Database::getRows($sql);
    }
     //metodo para leer los datos
    public function readOne()
    {
        $sql = 'SELECT id_proveedor, nombre_pro, apellido_pro, empresa, correo_pro,numero_pro , fecha_registro
                FROM proveedores = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
     //metodo para actualizar y editar los datos del proveedor 
    public function updateRow()
    {
        $sql = 'UPDATE proveedores
                SET nombre_pro = ?, apellido_pro = ?, empresa = ?, correo_pro = ?, numero_pro = ?, fecha_registro = ?
                WHERE id_proveedor = ?';
        $params = array($this->nombrepro, $this->apellidopro, $this->empresa, $this->correopro, $this->numeropro, $this->fecharegistro, $this->id);
        return Database::executeRow($sql, $params);
    }
     //metodo para eliminar  los datos del proveedor 
    public function deleteRow()
    {
        $sql = 'DELETE FROM proveedores
                WHERE id_proveedor = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
     //metodo para verificar que los datos no se dupliquen
    public function checkDuplicate($value)
    {
        $sql = 'SELECT id_proveedor
                FROM proveedores
                WHERE correo_pro = ? OR numero_pro = ?';
        $params = array($value, $value);
        return Database::getRow($sql, $params);
    }
}
