<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

session_start();
require_once '../RegistroEInicio/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../RegistroEInicio/inicioSesion.php");
    exit();
}

$db = new DB();
$conexion = $db->connect();

// Obtener lista de ordenadores favoritos del usuario autenticado
$usuarioId = $_SESSION['usuario_id'];
$sql = "SELECT * FROM favoritos WHERE usuario_id = :usuario_id";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
$stmt->execute();
$ordenadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="../style.css">
    <title>Favoritos</title>
</head>
<body>
<div class="caja_pr">
  <div class="contenedor">
    <?php
    include "../includes/nav.php"
    ?>
  </div>

 <div id="cacharro">

</div> 
<center><button id="btn_comp" align="absmiddle">Comparar</button>
<br><br><div class="btn_pri"><a href="#" onclick="window.print();return false"><h3>IMPRIMIR</h3></a></div></center>

</div>

<script>
    //boton fav
window.addEventListener('DOMContentLoaded', function() {
    let contenedor = document.getElementById('cacharro');
    let cadena = '';
    let btn_comp = document.getElementById('btn_comp');
    btn_comp.addEventListener('click', compValor);
    let datos = [];

    // Pasar la variable PHP a JavaScript
    let ordenadores = <?php echo json_encode($ordenadores); ?>;

    // Ahora puedes usar la variable `ordenadores` en JavaScript
    console.log(ordenadores);

    // Ejemplo: Mostrar los datos en la consola
    ordenadores.forEach(function(ordenador) {
        console.log('ID: ' + ordenador.usuario_id + ', Nombre: ' + ordenador.nombreOrdenador);
    });

    const request = new XMLHttpRequest();
    request.open('GET', '../Ordenadores.json');
    request.responseType = 'json';
    request.send();

    request.onload = function() {
        res = request.response;
        console.log(res);
        sacar_datos();
    };

    function sacar_datos() {
        for (let i = 0; i < res.mejores_ordenadores.length; i++) {
            for(let j = 0; j < ordenadores.length; j++) {
                if (res.mejores_ordenadores[i].nombre === ordenadores[j].nombreOrdenador) {
                    datos.push(res.mejores_ordenadores[i]);
                }
            }
        }
        impr_fav(datos);
    }

    function impr_fav(arrayObtenido) {
        for (let i = 0; i < arrayObtenido.length; i++) {
            cadena += '<div class="comp_pr"><h2>Ordenador ' + (i+1) + ': <u>'+ arrayObtenido[i].nombre +'</u><input type="checkbox" id="'+ arrayObtenido[i].nombre +'" class="comp_check" value="'+ arrayObtenido[i].nombre +'" align="right"></h2>';
            cadena += '<div class="comp_img2"><img src="img_comp/'+ arrayObtenido[i].nombre +'.jpg"></div>';
            cadena += '<div class="comp_info">';
            cadena += '<p><strong>Precio:</strong> ' + arrayObtenido[i].precio + '</p>';
            cadena += '<p><strong>Descripción:</strong> ' + arrayObtenido[i].descripcion + '</p>';
            cadena += '<p><strong>Pantalla:</strong> ';

            if(arrayObtenido[i].caracteristicas.exhibicion.pantalla_tactil) {
                cadena += 'Tactil ';
            }

            cadena +=  arrayObtenido[i].caracteristicas.exhibicion.diagonal_pantalla + ' ' + arrayObtenido[i].caracteristicas.exhibicion.resolucion_pantalla + '</p>';
            cadena += '<p><strong>Procesador:</strong> ' + arrayObtenido[i].caracteristicas.procesador.fabricante + ' ' + arrayObtenido[i].caracteristicas.procesador.modelo + ' ' + arrayObtenido[i].caracteristicas.procesador.frecuencia + ' ' + arrayObtenido[i].caracteristicas.procesador.nucleos_procesador + ' nucleos</p>';
            cadena += '<p><strong>RAM:</strong> ' + arrayObtenido[i].caracteristicas.memoria.capacidad + ' ' + arrayObtenido[i].caracteristicas.memoria.velocidad + ' ' + arrayObtenido[i].caracteristicas.memoria.tipo + '</p>';
            cadena += '<p><strong>Disco duro:</strong> ' + arrayObtenido[i].caracteristicas.almacenamiento.capacidad + ' ' + arrayObtenido[i].caracteristicas.almacenamiento.tipo + '</p>';
            cadena += '<p><strong>Graficos:</strong> ';

            if(arrayObtenido[i].caracteristicas.graficos.integrados) {
                cadena += 'Integrados</p>';
            } else {
                cadena += arrayObtenido[i].caracteristicas.graficos.modelo_discreto + '</p>';
            }
            cadena += '</div></div>';
        }
        
        if(ordenadores.length === 0) {
            cadena = '<br><h2 class="error1">No tienes ningún ordenador en favoritos todavía</h2>';
        }

        contenedor.innerHTML = cadena;
    }

    function compValor() {
        let checkboxes = document.getElementsByClassName('comp_check');
        let valoresSeleccionados = [];
        let array_comp = [];
        
        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                valoresSeleccionados.push(checkboxes[i].value);
            }
        }
        console.log(valoresSeleccionados);
        for (let i = 0; i < valoresSeleccionados.length; i++) {
            for(let j = 0; j < datos.length; j++) {
                if (valoresSeleccionados[i] === datos[j].nombre) {
                    array_comp.push(datos[j]);
                }
            }
        }

        console.log(array_comp);
        let urlDestino = "comparar.html?array=" + JSON.stringify(array_comp);
        window.open(urlDestino, '_blank');
    }
});

    </script>
</body>
</html>