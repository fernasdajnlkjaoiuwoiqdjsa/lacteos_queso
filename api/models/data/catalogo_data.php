<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/catalogo_handler.php');
/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla CATEGORIA.
 */
class CatalogoData extends CatalogoHandler
{
      /*
     *  Atributos adicionales.
     */
      private $data_error = null;
      private $filename = null;

      /*
     *  Métodos para validar y establecer los datos.
     */
      public function setId($value)
      {
            if (Validator::validateNaturalNumber($value)) {
                  $this->id = $value;
                  return true;
            } else {
                  $this->data_error = 'El identificador del catalogo es incorrecto';
                  return false;
            }
      }
      //Metodo para validar el campo donde ira el nombre
      public function setNombreCatlogo($value, $min = 2, $max = 50)
      {
            if (!Validator::validateAlphanumeric($value)) {
                  $this->data_error = 'El nombre debe ser un valor alfanumérico';
                  return false;
            } elseif (Validator::validateLength($value, $min, $max)) {
                  $this->nombre = $value;
                  return true;
            } else {
                  $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
                  return false;
            }
      }
      //Metodo para validar de forma numerica en cantidad
      public function setCantidad($value, $min = 2, $max = 250)
      {
            if (!$value) {
                  return true;
            } elseif (!Validator::validateString($value)) {
                  $this->data_error = 'La Cantidad contiene caracteres incorrectos';
                  return false;
            } elseif (Validator::validateLength($value, $min, $max)) {
                  $this->cantidad = $value;
                  return true;
            } else {
                  $this->data_error = 'La Cantidad debe tener una longitud entre ' . $min . ' y ' . $max;
                  return false;
            }
      }

      //Metodo para validar de forma numerica en precio
      public function setPrecio($value)
      {
            if (Validator::validateMoney($value)) {
                  $this->precio = $value;
                  return true;
            } else {
                  $this->data_error = 'El precio es incorrecto';
                  return false;
            }
      }
      //Metodo para validar el campo de correo
      public function setCorreo($value, $min = 8, $max = 100)
      {
            if (!Validator::validateEmail($value)) {
                  $this->data_error = 'El correo no es válido';
                  return false;
            } elseif (!Validator::validateLength($value, $min, $max)) {
                  $this->data_error = 'El correo debe tener una longitud entre ' . $min . ' y ' . $max;
                  return false;
            } elseif ($this->checkDuplicate($value)) {
                  $this->data_error = 'El correo ingresado ya existe';
                  return false;
            } else {
                  $this->correopro = $value;
                  return true;
            }
      }
      //Metodo para validar el campo del telefono
      public function setTelfonopro($value)
      {
            if (Validator::validatePhone($value)) {
                  $this->telefonopro = $value;
                  return true;
            } else {
                  $this->data_error = 'El telefono contiene caracteres prohibidos';
                  return false;
            }
      }


      //Metodo para validar el campo donde ira el lugra de negocio
      public function setLugar($value, $min = 2, $max = 250)
      {
            if (!$value) {
                  return true;
            } elseif (!Validator::validateString($value)) {
                  $this->data_error = 'El Lugar contiene caracteres prohibidos';
                  return false;
            } elseif (Validator::validateLength($value, $min, $max)) {
                  $this->lugar = $value;
                  return true;
            } else {
                  $this->data_error = 'El Lugar debe tener una longitud entre ' . $min . ' y ' . $max;
                  return false;
            }
      }
      //Metodo para validar de tipo date la fecha
      public function setfecharegistro($value)
      {
            if (Validator::validateDate($value)) {
                  $this->fechaingreso = $value;
                  return true;
            } else {
                  $this->data_error = 'La fecha de registro es incorrecta';
                  return false;
            }
      }
      /*
     *  Métodos para obtener los atributos adicionales.
     */
      public function getDataError()
      {
            return $this->data_error;
      }

      public function getFilename()
      {
            return $this->filename;
      }
}
