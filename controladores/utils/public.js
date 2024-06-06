/*
*   Controlador es de uso general en las páginas web del sitio público.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/public/cliente.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
MAIN.style.paddingTop = '75px';
MAIN.style.paddingBottom = '100px';
MAIN.classList.add('container');
// Se establece el título de la página web.
document.querySelector('title').textContent = 'Lacteos - Doña';
// Constante para establecer el elemento del título principal.
const MAIN_TITLE = document.getElementById('mainTitle');
MAIN_TITLE.classList.add('text-center', 'py-3');

/*  Función asíncrona para cargar el encabezado y pie del documento.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const loadTemplate = async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'getUser');
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (DATA.session) {
        // Se verifica si la página web no es el inicio de sesión, de lo contrario se direcciona a la página web principal.
        if (!location.pathname.endsWith('login.html')) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
                    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
                        <div class="container">
                            <a class="navbar-brand" href="index.html"><img src="../../recursos/img/titulo-removebg-preview.png" height="50" alt="Lacteos"></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                <div class="navbar-nav ms-auto">
                                    <a class="nav-link" href="inicio.html"><i class="bi bi-house-door"></i> Inicio</a>
                                    <a class="nav-link" href="nosotros.html"><i class="bi bi-people-fill"></i>Nosotros</a>
                                    <a class="nav-link" href="carrito.html"><i class="bi bi-cart"></i> Carrito</a>
                                    <a class="nav-link" href="#" onclick="logOut()"><i class="bi bi-box-arrow-left"></i> Cerrar sesión</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </header>
            `);
        } else {
            location.href = 'index.html';
        }
    } else {
        // Se agrega el encabezado de la página web antes del contenido principal.
        MAIN.insertAdjacentHTML('beforebegin', `
            <header>
                <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
                    <div class="container">
                        <a class="navbar-brand" href="index.html"><img src="../../recursos/img/titulo-removebg-preview.png" height="50" alt="CoffeeShop"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav ms-auto">
                                <a class="nav-link" href="index.html"><i class="bi bi-shop"></i> Catálogo</a>
                                <a class="nav-link" href="signup.html"><i class="bi bi-person"></i> Crear cuenta</a>
                                <a class="nav-link" href="login.html"><i class="bi bi-box-arrow-right"></i> Iniciar sesión</a>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
        `);
    }

    MAIN.insertAdjacentHTML('afterend', `
    <footer>
    <footer>
            <div class="footer-content">
                  <center>
                        <h3>Lacteos Doña Queso</h3>
                  </center>
                  <p>Este año empezamos con la distrubucion de los mejores lacteos en toda ciudad ya que son productos
                        100%
                        natural</p>
                  <ul class="socials">
                        <li><a href="https://www.facebook.com/profile.php?id=61557180795985&mibextid=ZbWKwL"><i
                                          class="bi bi-facebook"></i></a></li>
                        <li><a href="#"><i class="bi bi-twitter"></i></a></li>
                        <li><a href="https://chat.whatsapp.com/Ja1XaBabc690ruCBIbzXcf"><i class="bi bi-whatsapp"></i></a></li>
                        <li><a href="https://www.instagram.com/papiriki22?igsh=eDJieml6MTIyeGNj"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="https://www.tiktok.com/@teclas568?_t=8krtubotSgX&_r=1"><i class="bi bi-tiktok"></i></a></li>
                  </ul>
            </div>
            <div class="footer-bottom">
                  <p style="font-family: Arial;">copyright &copy;2024 Lacteos Doña Queso. designed by
                        <span>Quesos</span>
                  </p>
            </div>
      </footer>
`);
 }
    // Se agrega el pie de la página web después del contenido principal.
   

   
