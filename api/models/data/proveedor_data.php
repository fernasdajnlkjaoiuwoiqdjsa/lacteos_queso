<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/proveedores_handler.php');
/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla CATEGORIA.
 */
class ProveedorData extends ProveedorHandler
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
                  $this->data_error = 'El identificador del Proveedor es incorrecto';
                  return false;
            }
      }
       //Metodo para validar el campo donde ira el nombre del proveedor
      public function setNombrepro($value, $min = 2, $max = 50)
      {
            if (!Validator::validateAlphanumeric($value)) {
                  $this->data_error = 'El nombre debe ser un valor alfanumérico';
                  return false;
            } elseif (Validator::validateLength($value, $min, $max)) {
                  $this->nombrepro = $value;
                  return true;
            } else {
                  $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
                  return false;
            }
      }
       //Metodo para validar el campo donde ira el apellido del proveedor
      public function setApellidopro($value, $min = 2, $max = 250)
      {
            if (!$value) {
                  return true;
            } elseif (!Validator::validateString($value)) {
                  $this->data_error = 'El apellido contiene caracteres incorrectos';
                  return false;
            } elseif (Validator::validateLength($value, $min, $max)) {
                  $this->apellidopro = $value;
                  return true;
            } else {
                  $this->data_error = 'El apellido debe tener una longitud entre ' . $min . ' y ' . $max;
                  return false;
            }
      }

       //Metodo para validar el campo donde ira la empresa del proveedor
      public function setEmpresa($value, $min = 2, $max = 250)
      {
            if (!$value) {
                  return true;
            } elseif (!Validator::validateString($value)) {
                  $this->data_error = 'La empresa contiene caracteres prohibidos';
                  return false;
            } elseif (Validator::validateLength($value, $min, $max)) {
                  $this->empresa = $value;
                  return true;
            } else {
                  $this->data_error = 'La empresa  debe tener una longitud entre ' . $min . ' y ' . $max;
                  return false;
            }
      }
       //Metodo para validar el campo donde ira el correo del provedor
      public function setCorreopro($value, $min = 8, $max = 100)
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
       //Metodo para validar el campo del telefono sin caracteres especiales 
      public function setTelfono($value)
      {
            if (Validator::validatePhone($value)) {
                  $this->numeropro = $value;
                  return true;
            } else {
                  $this->data_error = 'El telefono contiene caracteres prohibidos';
                  return false;
            }
      }

       //Metodo para validar la fecha de tipo date
      public function setfecharegistropro($value)
      {
            if (Validator::validateDate($value)) {
                  $this->fecharegistro = $value;
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
