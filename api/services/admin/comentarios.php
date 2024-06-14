<?php
// Se incluye la clase del modelo.
require_once('../../models/data/comentarios_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $ComentarioCatalogo = new ComentarioData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_admin'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $ComentarioCatalogo->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$ComentarioCatalogo->setNombreClicome($_POST['nombreCatalogo']) or
                    !$ComentarioCatalogo->setDescipcionpro($_POST['cantidadCatalogo']) or
                    !$ComentarioCatalogo->setEstado($_POST['estadocomentario']) or
                    !$ComentarioCatalogo->setfecharegistro($_POST['registroCatalogo']) 
                    
                ) {
                    $result['error'] = $ComentarioCatalogo->getDataError();
                } elseif ($ComentarioCatalogo->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Comentario creado correctamente';
                    // Se asigna el estado del archivo después de insertar.
                    //$result['fileStatus'] = Validator::saveFile($_FILES['imagenCategoria'], $CatalogoProducto::RUTA_IMAGEN);
                } else {
                    $result['error'] = 'Ocurrió un problema';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $ComentarioCatalogo->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen catalogo registradas';
                }
                break;
            case 'readOne':
                if (!$ComentarioCatalogo->setId($_POST['idValoracion'])) {
                    $result['error'] = $ComentarioCatalogo->getDataError();
                } elseif ($result['dataset'] = $ComentarioCatalogo->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Comentario inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$ComentarioCatalogo->setNombreClicome($_POST['nombreCatalogo']) or
                    !$ComentarioCatalogo->setDescipcionpro($_POST['cantidadCatalogo']) or
                    !$ComentarioCatalogo->setEstado($_POST['estadocomentario']) or
                    !$ComentarioCatalogo->setfecharegistro($_POST['registroCatalogo']) 
                    
                ) {
                    $result['error'] = $ComentarioCatalogo->getDataError();
                } elseif ($ComentarioCatalogo->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'comentario modificada correctamente';
                    // Se asigna el estado del archivo después de actualizar.
                    //$result['fileStatus'] = Validator::changeFile($_FILES['imagenCatalogo'], $CatalogoProducto::RUTA_IMAGEN, $CatalogoProducto->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema';
                }
                break;
            case 'deleteRow':
                if (
                    !$ComentarioCatalogo->setId($_POST['idValoracion']) 
                   
                ) {
                    $result['error'] = $ComentarioCatalogo->getDataError();
                } elseif ($ComentarioCatalogo->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Catalogo eliminada correctamente';
                    // Se asigna el estado del archivo después de eliminar.
                    $result['fileStatus'] = Validator::deleteFile($ComentarioCatalogo::RUTA_IMAGEN, $ComentarioCatalogo->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el comentario';
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
