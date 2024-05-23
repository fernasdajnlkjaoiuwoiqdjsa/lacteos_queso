<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class AdministradorHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $usuarioadmin = null;
    protected $correo = null;
    protected $contra = null;

    /*
     *  Métodos para gestionar la cuenta del administrador.
     */
    public function checkUser($username, $password)
    {
        $sql = 'SELECT id_admin, usuario_admin, contra_admin
                FROM administrador
                WHERE  usuario_admin = ?';
        $params = array($username);
        if(!$data = Database::getRow($sql, $params)) {
            return false;
        } elseif (password_verify($password, $data['contra_admin'])) {
            $_SESSION['id_admin'] = $data['id_admin'];
            $_SESSION['usuario_admin'] = $data['usuario_admin'];
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT contra_admin
                FROM administrador
                WHERE id_admin = ?';
        $params = array($_SESSION['id_admin']);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['contra_admin'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE administrador
                SET contra_admin = ?
                WHERE id_admin = ?';
        $params = array($this->contra, $_SESSION['id_admin']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_admin, usuario_admin, correo_admin, contra_admin
                FROM administrador
                WHERE id_admin = ?';
        $params = array($_SESSION['id_admin']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE administrador
                SET usuario_admin = ?, correo_admin = ?, contra_admin = ?
                WHERE id_admin = ?';
        $params = array($this->usuarioadmin, $this->correo, $this->contra, $_SESSION['id_admin']);
        return Database::executeRow($sql, $params);
    }

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_admin, usuario_admin, correo_admin, contra_admin
                FROM administrador
                WHERE correo_admin LIKE ? OR usuario_admin LIKE ?
                ORDER BY correo_admin';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO administrador(usuario_admin, correo_admin, contra_admin)
                VALUES(?, ?, ?)';
        $params = array($this->usuarioadmin, $this->correo, $this->contra);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_admin, usuario_admin, correo_admin, contra_admin
                FROM administrador
                ORDER BY correo_admin';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_administrador, nombre_administrador, apellido_administrador, correo_administrador, alias_administrador
                FROM administrador
                WHERE id_administrador = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE administrador
                SET nombre_administrador = ?, apellido_administrador = ?, correo_administrador = ?
                WHERE id_administrador = ?';
        $params = array($this->usuarioadmin, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM administrador
                WHERE id_admin = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
