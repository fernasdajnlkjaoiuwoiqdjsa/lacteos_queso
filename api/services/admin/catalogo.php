<?php
// Se incluye la clase del modelo.
require_once('../../models/data/catalogo_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $CatalogoProducto = new CatalogoData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    // if (isset($_SESSION['idAdmin'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':

                
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $CatalogoProducto->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$CatalogoProducto->setNombreCatlogo($_POST['nombreCatalogo']) or
                    !$CatalogoProducto->setCantidad($_POST['cantidadCatalogo']) or
                    !$CatalogoProducto->setPrecio($_POST['precioCatalogo']) or
                    !$CatalogoProducto->setCorreo($_POST['correoCatalogo']) or
                    !$CatalogoProducto->setTelfonopro($_POST['telefonoCatalogo']) or
                    !$CatalogoProducto->setLugar($_POST['lugarCatalogo']) or
                    !$CatalogoProducto->setfecharegistro($_POST['registroCatalogo']) 
                    
                ) {
                    $result['error'] = $CatalogoProducto->getDataError();
                } elseif ($CatalogoProducto->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Catalogo creado correctamente';
                    // Se asigna el estado del archivo después de insertar.
                    //$result['fileStatus'] = Validator::saveFile($_FILES['imagenCategoria'], $CatalogoProducto::RUTA_IMAGEN);
                } else {
                    $result['error'] = 'Ocurrió un problema al crear la categoría';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $CatalogoProducto->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen catalogo registradas';
                }
                break;
            case 'readOne':
                if (!$CatalogoProducto->setId($_POST['idCatalogo'])) {
                    $result['error'] = $CatalogoProducto->getDataError();
                } elseif ($result['dataset'] = $CatalogoProducto->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Catalogo inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$CatalogoProducto->setNombreCatlogo($_POST['nombreCatalogo']) or
                    !$CatalogoProducto->setCantidad($_POST['cantidadCatalogo']) or
                    !$CatalogoProducto->setPrecio($_POST['PrecioCatalogo']) or
                    !$CatalogoProducto->setCorreo($_POST['correoCatalogo']) or
                    !$CatalogoProducto->setTelfonopro($_POST['telefonoCatalogo']) or
                    !$CatalogoProducto->setLugar($_POST['lugarCatalogo']) or
                    !$CatalogoProducto->setfecharegistro($_POST['registroCatalogo']) 
                    
                ) {
                    $result['error'] = $CatalogoProducto->getDataError();
                } elseif ($CatalogoProducto->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría modificada correctamente';
                    // Se asigna el estado del archivo después de actualizar.
                    $result['fileStatus'] = Validator::changeFile($_FILES['imagenCatalogo'], $CatalogoProducto::RUTA_IMAGEN, $CatalogoProducto->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el Catalogo';
                }
                break;
            case 'deleteRow':
                if (
                    !$CatalogoProducto->setId($_POST['idCatalogo']) 
                   
                ) {
                    $result['error'] = $CatalogoProducto->getDataError();
                } elseif ($CatalogoProducto->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Catalogo eliminada correctamente';
                    // Se asigna el estado del archivo después de eliminar.
                    $result['fileStatus'] = Validator::deleteFile($CatalogoProducto::RUTA_IMAGEN, $CatalogoProducto->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el catalogo';
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
    // } else {
    //     print(json_encode('Acceso denegado'));
    // }
} else {
    print(json_encode('Recurso no disponible'));
}
