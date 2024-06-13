// Constante para completar la ruta de la API.
const CATEGORIA_API = 'services/public/catalogo.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');
// Constante para establecer el contenedor de categorías.
const CATEGORIAS = document.getElementById('catalogo');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Catalogo de Productos';
    fillCards();
});

const fillCards = async (form = null) => {
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll';
    // Petición para obtener las categorías disponibles.
    const DATA = await fetchData(CATEGORIA_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se inicializa el contenedor de categorías.
        CATEGORIAS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se establece la página web de destino con los parámetros.
            let url = `detail.html?id=${row.id_catalogo}`;
            // Se crean y concatenan las tarjetas con los datos de cada categoría.
            CATEGORIAS.innerHTML += `
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <h5 class="caurlrd-title">${row.nombre_catalogo}</h5>
                            <p class="card-text">${row.precio_producto}</p>
                            <a href="${url}" class="btn btn-success">ver más<i class="bi bi-cart"></i></a>
                        </div>
                    </div>
                </div>
            `;
        });
    }
    
    else {
        // Se asigna al título del contenido de la excepción cuando no existen datos para mostrar.
        document.getElementById('mainTitle').textContent = DATA.error;
    }
}

SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillCards(FORM);
});