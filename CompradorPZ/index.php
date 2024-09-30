<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comparador</title>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
  <script src="main.js" defer></script>
  <script src="carousel.js"></script>
<style>

.caja_pr{
  width: 100%;
  text-align: center;
}

.caja_frame{
  text-align: center;
width: 90%;
margin:0 auto;
box-shadow: 0px 0px 10px 0px #005fad;
background-color: #005fad;
border-radius: 30px;
}

.caja_frame iframe{
  background-color: white;
  border-radius: 30px;
  width: 83%;
  height: 600px;
  box-shadow: 0px 0px 10px 0px white;
  margin: 20px;
  
}

</style>
</head>

<body>
<?php session_start();?>
  <div class="caja_pr">
    <div class="contenedor">
      <?php include "includes/nav.php"; ?>
    </div>
    <section class="presentacion">
      <h1>Bienvenido a PZComparator: Tu Guía Fácil para Comparar Portátiles</h1>
      <p>En PZComparator, entendemos que elegir el portátil adecuado puede ser una tarea abrumadora, especialmente si no tienes conocimientos técnicos sobre hardware. Por eso hemos creado una plataforma sencilla y amigable que te ayudará a comparar diferentes modelos de portátiles de manera rápida y eficiente.</p>
      <h2>¿Qué es PZComparator?</h2>
      <p>PZComparator es una <a href="#contenidoIframe" class="btn">herramienta</a> web diseñada para simplificar el proceso de comparación de portátiles. Nuestra plataforma te permite comparar fácilmente las especificaciones técnicas, el rendimiento y los precios de varios modelos para que puedas tomar la mejor decisión de compra sin necesidad de ser un experto en tecnología.</p>
      <h2>¿Cómo Funciona?</h2>
      <ul>
        <li><strong>Selección Intuitiva:</strong>Escoge los portátiles que deseas comparar de nuestra amplia base de datos.</li>
        <li><strong>Comparación Detallada:</strong>Compara especificaciones clave como procesador, memoria RAM, capacidad de almacenamiento, tarjeta gráfica y más.</li>
        <li><strong>Resultados Claros:</strong> Obtén una comparación visual clara y concisa que destaca las diferencias y similitudes entre los modelos seleccionados.</li>
        <li><strong>Recomendaciones Personalizadas:</strong>Basado en tus necesidades y preferencias, PZComparator te ofrece recomendaciones personalizadas para ayudarte a encontrar el portátil ideal.</li>
      </ul>
      <h2>¿Por Qué Usar PZComparator?</h2>
      <ul>
        <li><strong>Accesibilidad:</strong>Diseñado para ser utilizado por cualquier persona, sin importar su nivel de conocimiento sobre hardware.</li>
        <li><strong>Ahorra Tiempo:</strong>En lugar de navegar por múltiples sitios web y especificaciones técnicas, obtén toda la información que necesitas en un solo lugar.</li>
        <li><strong>Decisiones Informadas:</strong>Compara de forma objetiva y detallada para tomar la mejor decisión de compra.</li>
      </ul>
      <p>Explora nuestra herramienta hoy mismo y descubre lo fácil que puede ser encontrar el portátil perfecto con PZComparator. ¡Tu próxima inversión en tecnología está a solo unos clics de distancia!</p>
    </section>
    <!-- Código del carrusel -->
    <section class="carousel">
      <div class="carousel-inner">
        <div class="carousel-item">
          <img src="/lista/img_comp/Acer Aspire 5.jpg" alt="Imagen 1">
        </div>
        <div class="carousel-item">
          <img src="/lista/img_comp/Acer Predator Helios 300.jpg" alt="Imagen 2">
        </div>
        <div class="carousel-item">
          <img src="/lista/img_comp/Acer Swift 5.jpg" alt="Imagen 3">
        </div>
        <!-- Añade más divs .carousel-item según la cantidad de imágenes -->
      </div>
      <div class="carousel-controls">
        <div class="carousel-control-prev" onclick="prevSlide()">&#10094;</div>
        <div class="carousel-control-next" onclick="nextSlide()">&#10095;</div>
      </div>
    </section>
    <section class="caja_frame">
      <iframe id="contenidoIframe" src="lista/lista.html" frameBorder="0"></iframe>
    </section>
  </div>
  
</body>

</html>
