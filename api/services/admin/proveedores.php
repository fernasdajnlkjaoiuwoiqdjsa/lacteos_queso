<?php
// Se incluye la clase del modelo.
require_once('../../models/data/proveedor_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $ProveedorCatalogo = new ProveedorData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
     if (isset($_SESSION['id_admin'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':

                
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $ProveedorCatalogo->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$ProveedorCatalogo->setNombrepro($_POST['nombreCatalogo']) or
                    !$ProveedorCatalogo->setApellidopro($_POST['cantidadCatalogo']) or
                    !$ProveedorCatalogo->setEmpresa($_POST['precioCatalogo']) or
                    !$ProveedorCatalogo->setCorreopro($_POST['correoCatalogo']) or
                    !$ProveedorCatalogo->setTelfono($_POST['telefonoCatalogo']) or
                    !$ProveedorCatalogo->setfecharegistropro($_POST['registroCatalogo']) 
                    
                ) {
                    $result['error'] = $ProveedorCatalogo->getDataError();
                } elseif ($ProveedorCatalogo->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Proveedor registrado correctamente';
                    // Se asigna el estado del archivo después de insertar.
                    //$result['fileStatus'] = Validator::saveFile($_FILES['imagenCategoria'], $CatalogoProducto::RUTA_IMAGEN);
                } else {
                    $result['error'] = 'Ocurrió un problema al crear la categoría';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $ProveedorCatalogo->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen Proveedorea registrados';
                }
                break;
            case 'readOne':
                if (!$ProveedorCatalogo->setId($_POST['idProve'])) {
                    $result['error'] = $ProveedorCatalogo->getDataError();
                } elseif ($result['dataset'] = $ProveedorCatalogo->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Proveedor inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$ProveedorCatalogo->setNombrepro($_POST['nombreCatalogo']) or
                    !$ProveedorCatalogo->setApellidopro($_POST['cantidadCatalogo']) or
                    !$ProveedorCatalogo->setEmpresa($_POST['precioCatalogo']) or
                    !$ProveedorCatalogo->setCorreopro($_POST['correoCatalogo']) or
                    !$ProveedorCatalogo->setTelfono($_POST['telefonoCatalogo']) or
                    !$ProveedorCatalogo->setfecharegistropro($_POST['registroCatalogo']) 
                    
                ) {
                    $result['error'] = $ProveedorCatalogo->getDataError();
                } elseif ($ProveedorCatalogo->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Proveedor modificado correctamente';
                    // Se asigna el estado del archivo después de actualizar.
                    //$result['fileStatus'] = Validator::changeFile($_FILES['imagenCatalogo'], $CatalogoProducto::RUTA_IMAGEN, $CatalogoProducto->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el Proveedor';
                }
                break;
            case 'deleteRow':
                if (
                    !$ProveedorCatalogo->setId($_POST['idProve']) 
                   
                ) {
                    $result['error'] = $ProveedorCatalogo->getDataError();
                } elseif ($ProveedorCatalogo->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Proveedor eliminado correctamente';
                    // Se asigna el estado del archivo después de eliminar.
                    //$result['fileStatus'] = Validator::deleteFile($ProveedorCatalogo::RUTA_IMAGEN, $ProveedorCatalogo->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el Proveedor';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
        // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
        $result['exception'] = Database::getException();
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('Content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
