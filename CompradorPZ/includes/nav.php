<nav class="navbar">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" id="navbar-toggle">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-links" id="navbar-links">
            <img src="/logoPZ.png" alt="">
            <ul class="nav navbar-nav">
                <li><a href="/index.php">Inicio</a></li>
                <li><a href="/lista/favoritos.php">Favoritos</a></li>
                <li><a href="/contacto.php">Contactos</a></li>
                <?php
                
                if (isset($_SESSION['usuario_id']) && isset($_SESSION['usuario_email'])): ?>
                    <li><a href="/RegistroEInicio/cerrarSesion.php">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="/RegistroEInicio/inicioSesion.php">Iniciar sesión</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<hr>

<style>
    hr {
        margin-left: 15%;
        width: 70%;
        color: black;
    }

    /* Estilos para el navbar */
    .navbar {
        background-color: white;
        overflow: hidden;
        padding: 15px;
    }

    .navbar-nav {
        float: none;
        text-align: center;
    }

    .navbar-nav li {
        display: inline-block;
    }

    .navbar-nav li:hover {
        transform: scale(1.3);
    }

    .navbar-nav li a {
        padding: 20px;
        color: black;
        text-decoration: none;
    }

    /* Estilos para el botón de menú en dispositivos pequeños */
    .navbar-toggle {
        border: none;
        background: none;
        cursor: pointer;
    }

    .navbar-toggle {
        display: none; /* Ocultar por defecto en pantallas grandes */
        border: none;
        background: none;
        cursor: pointer;
    }

    .icon-bar {
        background-color: black;
        display: block;
        width: 20px;
        height: 2px;
        border-radius: 10px;
        margin: 3px -15px;
    }

    /* Estilos para cuando se colapsa el menú */
    .navbar-links {
        display: block; /* Mostrar por defecto en pantallas grandes */
    }

    @media (max-width: 767px) { /* Media query para pantallas más pequeñas */
        .navbar-toggle {
            display: block; /* Mostrar el botón de menú en dispositivos pequeños */
        }

        .navbar-links {
            display: none; /* Ocultar el menú por defecto en dispositivos pequeños */
        }

        .navbar-links.active {
            display: block; /* Mostrar el menú cuando se activa en dispositivos pequeños */
        }
    }

    .container {
        width: 90%;
        margin: auto;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbarToggle = document.getElementById('navbar-toggle');
        const navbarLinks = document.getElementById('navbar-links');

        navbarToggle.addEventListener('click', function() {
            navbarLinks.classList.toggle('active');
        });
    });
</script>
