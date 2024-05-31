<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla CATEGORIA.
 */
class ComentarioHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombredecli = null;
    protected $descripcion = null;
    protected $estado = null;
    protected $fechacomentario = null;
    

    // linea d codigo para establecr la imagen.
    const RUTA_IMAGEN = '../../images/catalogo/';

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_valoracion, nombre_cliente, descripcion_pro,estado_comentario,fecha_comentario
                FROM comentarios
                WHERE nombre_cliente LIKE ? OR descripcion_pro LIKE ?
                ORDER BY nombre_cliente';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO comentarios(nombre_cliente, descripcion_pro, estado_comentario, fecha_comentario, id_detale)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->nombredecli, $this->descripcion, $this->estado,$this->fechacomentario, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_valoracion, nombre_cliente, descripcion_pro, estado_comentario, fecha_comentario
                FROM comentarios
                ORDER BY nombre_cliente';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_valoracion, nombre_cliente, descripcion_pro, estado_comentario,fecha_comentario
                FROM comentarios
                WHERE id_valoracion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT nombre_cliente
                FROM comentarios
                WHERE id_valoracion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE comentarios
                SET nombre_cliente = ?, descripcion_pro = ?, estado_comentario = ?, fecha_comentario = ? id_detale = ?
                WHERE id_valoracion = ?';
        $params = array($this->nombredecli, $this->descripcion, $this->estado, $this->fechacomentario ,$_SESSION['id_detale'] );
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM comentarios
                WHERE id_valoracion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    /*public function checkDuplicate($value)
    {
        $sql = 'SELECT id_valoracion
                FROM comentarios
                WHERE correo_pro = ? OR telefono_pro = ?';
        $params = array($value, $value);
        return Database::getRow($sql, $params);
    }*/
}
