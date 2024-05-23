<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla CATEGORIA.
 */
class CatalogoHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;
    protected $cantidad = null;
    protected $precio = null;
    protected $correopro = null;
    protected $telefonopro = null;
    protected $lugar = null;
    protected $fechaingreso = null;
    

    // linea d codigo para establecr la imagen.
    const RUTA_IMAGEN = '../../images/catalogo/';

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_catalogo, nombre_catalogo, cantidad,precio,correo_proveedor,telefono_proveedor,lugar,fecha_ingreso
                FROM catalogoproducto
                WHERE nombre_catalogo LIKE ? OR precio LIKE ?
                ORDER BY nombre_catalogo';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO catalogoproducto(nombre_catalogo, cantidad,precio, correo_proveedor, telefono_proveedor, lugar, fecha_ingreso, id_admin)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->cantidad, $this->precio,$this->correopro, $this->telefonopro, $this->lugar, $this->fechaingreso, $_SESSION['id_admin']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_catalogo, nombre_catalogo, cantidad, precio, correo_proveedor, telefono_proveedor, lugar, fecha_ingreso
                FROM catalogoproducto
                ORDER BY nombre_catalogo';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_catalogo, nombre_catalogo, cantidad, precio,correo_proveedor, telefono_proveedor,lugar,fecha_ingreso
                FROM catalogoproducto
                WHERE id_catalogo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT nombre_catalogo
                FROM catalogoproducto
                WHERE id_catalogo = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE catalogoproducto
                SET nombre_catalogo = ?, cantidad = ?, precio = ?, correo_proveedor = ?, telefono_proveedor = ?, lugar = ?, fecha_ingreso = ?, id_admin = ?
                WHERE id_catalogo = ?';
        $params = array($this->nombre, $this->cantidad, $this->precio, $this->correopro, $this->telefonopro, $this->lugar,$this->fechaingreso ,$this->id,);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM catalogoproducto
                WHERE id_catalogo = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    public function checkDuplicate($value)
    {
        $sql = 'SELECT id_catalogo
                FROM catalogoproducto
                WHERE correo_pro = ? OR telefono_pro = ?';
        $params = array($value, $value);
        return Database::getRow($sql, $params);
    }
}
