<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/cliente_handler.php');
/*
*	Clase para manejar el encapsulamiento de los datos de la tabla CLIENTE.
*/
class ClienteData extends ClienteHandler
{
    // Atributo genérico para manejo de errores.
    private $data_error = null;

    /*
    *   Métodos para validar y establecer los datos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del cliente es incorrecto';
            return false;
        }
    }

    public function setNombre($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El nombre debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombrecli = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setEdad($value, $min = 2, $max = 50)
    {
        if (!Validator::validateString($value)) {
            $this->data_error = 'la edad debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->edad = $value;
            return true;
        } else {
            $this->data_error = 'la edad debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

	public function setDireccionn($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'la edad debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->direccion = $value;
            return true;
        } else {
            $this->data_error = 'la direccion debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setCorreo($value, $min = 8, $max = 100)
    {
        if (!Validator::validateEmail($value)) {
            $this->data_error = 'El correo no es válido';
            return false;
        } elseif (!Validator::validateLength($value, $min, $max)) {
            $this->data_error = 'El correo debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        } elseif($this->checkDuplicate($value)) {
            $this->data_error = 'El correo ingresado ya existe';
            return false;
        } else {
            $this->cuenta = $value;
            return true;
        }
    }

    public function setTelefonocli($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefonocli = $value;
            return true;
        } else {
            $this->data_error = 'El telefono contiene caracteres prohibidos';
            return false;
        }
    }

	public function setRelacion($value)
    {
        if (Validator::validatePassword($value)) {
            $this->contra = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            $this->data_error = Validator::getPasswordError();
            return false;
        }
    }


    public function setfecharegistro($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaingreso = $value;
            return true;
        } else {
            $this->data_error = 'La fecha de ingreso es incorrecta';
            return false;
        }
    }

    // Método para obtener el error de los datos.
    public function getDataError()
    {
        return $this->data_error;
    }
}
