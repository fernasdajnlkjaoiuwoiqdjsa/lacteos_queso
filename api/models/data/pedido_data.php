<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/pedidos_handler.php');
/*
*	Clase para manejar el encapsulamiento de los datos de las tablas PEDIDO y DETALLE_PEDIDO.
*/
class PedidoData extends PedidoHandler
{
      // Atributo genérico para manejo de errores.
      private $data_error = null;

      /*
    *   Métodos para validar y establecer los datos.
    */
      public function setIdPedido($value)
      {
            if (Validator::validateNaturalNumber($value)) {
                  $this->id_pedido = $value;
                  return true;
            } else {
                  $this->data_error = 'El identificador del pedido es incorrecto';
                  return false;
            }
      }
      //Metodo para asignar el id del detalle
      public function setIdDetalle($value)
      {
            if (Validator::validateNaturalNumber($value)) {
                  $this->id_detale = $value;
                  return true;
            } else {
                  $this->data_error = 'El identificador del detalle pedido es incorrecto';
                  return false;
            }
      }
       //Metodo para validar el id del cliente
      public function setCliente($value)
      {
            if (Validator::validateNaturalNumber($value)) {
                  $this->cliente = $value;
                  return true;
            } else {
                  $this->data_error = 'El identificador del cliente es incorrecto';
                  return false;
            }
      }


        //Metodo para validar que la cantidad no sea menor a 10
      public function setCantidad($value)
      {
            if (Validator::validateNaturalNumber($value)) {
                  $this->cantidad = $value;
                  return true;
            } else {
                  $this->data_error = 'La cantidad del producto debe ser mayor o igual a 1';
                  return false;
            }
      }
        //Accion para llamra el id del catalogo al momento de hacer el pedido
      public function setCatalogo($value)
      {
            if (Validator::validateNaturalNumber($value)) {
                  $this->catalogo = $value;
                  return true;
            } else {
                  $this->data_error = 'La cantidad del producto debe ser mayor o igual a 1';
                  return false;
            }
      }

      // Método para obtener el error de los datos.
      public function getDataError()
      {
            return $this->data_error;
      }
}
