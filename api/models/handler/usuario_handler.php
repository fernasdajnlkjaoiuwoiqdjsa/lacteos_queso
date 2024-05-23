<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
*/
class UsuarioHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */
    protected $id = null;
    protected $nombreusu = null;
    protected $edad = null;
    protected $tipo = null;
    protected $correousu = null;
    protected $telefonousu = null;
    protected $cuenta = null;
    protected $fecharegistro = null;

    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images/productos/';

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_usuario, nombre_usuario, edad_usuario, tipo_usuario, correo_usuario, telefono_usuario, cuenta_usuario,fecha_registro
                FROM Usuarios
                INNER JOIN Administrador USING(id_usuario)
                WHERE nombre_usuario LIKE ? OR tipo_usuario LIKE ?
                ORDER BY nombre_usuario';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO Usuarios(nombre_usuario, edad_usuario, tipo_usuario, correo_usuario, telefono_usuario, cuenta_usuario,fecha_registro, id_amin)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombreusu, $this->edad, $this->tipo, $this->correousu, $this->telefonousu, $this->cuenta, $this->fecharegistro, $_SESSION['id_admin']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, edad_usuario, tipo_usuario, correo_usuario, telefono_usuario, cuenta_usuario,fecha_registro
                FROM Usuarios
                INNER JOIN Administrador USING(id_admin)
                ORDER BY nombre_usuario';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, edad_usuario, tipo_usuario, correo_usuario, telefono_usuario, cuenta_usuario,fecha_registro
                FROM Usuarios
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT nombre_usuario
                FROM Usuarios
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE Usuarios
                SET nombre_usuario = ?, edad_usuario = ?, tipo_usuario = ?, correo_usuario = ?,telefono_usuario = ? ,cuenta_usuario = ? ,fecha_registro = ?, id_admin = ?
                WHERE id_usuario = ?';
        $params = array($this->nombreusu, $this->edad, $this->tipo, $this->correousu, $this->telefonousu, $this->cuenta,$this->cuenta,$this->fecharegistro, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM Usuarios
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readUsuarios()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, edad_usuario, tipo_usuario, correo_usuario, telefono_usuario, cuenta_usuario,fecha_registro
                FROM Usuarios
                INNER JOIN administrador USING(id_admin)
                WHERE id_admin = ? AND cuenta_usuario = true
                ORDER BY nombre_usuario';
        $params = array($this->categoria);
        return Database::getRows($sql, $params);
    }

    /*
    *   Métodos para generar gráficos.
    */
    public function tipoUsuariosAdministrador()
    {
        $sql = 'SELECT nombre_admin, COUNT(id_usuario) tipo_usuario
                FROM Usuarios
                INNER JOIN administrador USING(id_admin)
                GROUP BY nombre_admin ORDER BY tipo_usuario DESC LIMIT 5';
        return Database::getRows($sql);
    }

    
    /*
    *   Métodos para generar reportes.
    */
    public function productosCategoria()
    {
        $sql = 'SELECT nombre_usuario, edad_usuario, cuenta_usuario
                FROM Usuarios
                INNER JOIN administrador USING(id_admin)
                WHERE id_admin = ?
                ORDER BY nombre_usuario';
        $params = array($this->categoria);
        return Database::getRows($sql, $params);
    }
}
