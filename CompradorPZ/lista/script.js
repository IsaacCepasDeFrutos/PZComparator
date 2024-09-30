window.addEventListener('DOMContentLoaded', function() {
    let contador;
    let valorImput = "";
    let res;
    let btn_buscar = document.getElementById('btn_buscar');
    let mostrarRes = document.getElementById('mostrarRes');
    let btn_comp = document.getElementById('btn_comp');
    let arrayFiltrado = [];
    
    console.log(btn_comp);
    
    const request = new XMLHttpRequest();
    
    request.open('GET', '../Ordenadores.json');
    request.responseType = 'json';
    request.send();

    btn_buscar.addEventListener('click', capturarValor);
    btn_comp.addEventListener('click', compValor);

    document.getElementById('palabra').addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            capturarValor();
        }
    });

    request.onload = function() {
        res = request.response;
        console.log(res);
        
        sacar_categoria();
        capturarValor();  // Llamar a capturarValor para mostrar resultados al cargar la página
    }
    
    function sacar_categoria() {
        let categoria = [];
        let categoria2 = [];
   
        // Llenar el array categoria con las marcas
        for(let i = 0; i < res.mejores_ordenadores.length; i++) {
            categoria.push(res.mejores_ordenadores[i].caracteristicas.diseño.marca_original);
        }

        // Ordenar el array categoria alfabéticamente
        categoria.sort();

        // Buscar y guardar elementos únicos en categoria2
        for(let i = 0; i < categoria.length; i++) {
            if (i === 0 || categoria[i] !== categoria[i - 1]) {
                categoria2.push(categoria[i]);
            }
        }
    
        // Llamar a la función de impresión con categoria2
        impr_categoria(categoria2);
    }

    function impr_categoria(categorias) {
        let select = '<select name="Categoria" id="categoria"><option value="all">Todo</option>';
    
        categorias.forEach(categoria => {
            select += '<option value="' + categoria + '">' + categoria + '</option>';
        });

        select += '</select>'
        category.innerHTML = select;
    }

    function capturarValor() {
        valorImput = document.getElementById('palabra').value.toUpperCase();
        console.log(valorImput);
        recorrerJson(valorImput);
    }
    
    function recorrerJson(valorImput = "") {
        arrayFiltrado = [];  // Vaciar el array antes de llenar con nuevos resultados
        let valor_categoria = document.getElementById('categoria').value;
        let p_min = document.getElementById('pre_min').value;
        let p_max = document.getElementById('pre_max').value;
        
        if (p_min === "") {
            p_min = 0;
        }
        if (p_max === "") {
            p_max = 999999;
        }

        console.log(p_min, p_max);

        for (let i = 0; i < res.mejores_ordenadores.length; i++) {
            if (valor_categoria === res.mejores_ordenadores[i].caracteristicas.diseño.marca_original || valor_categoria === "all") {
                if (res.mejores_ordenadores[i].descripcion.toUpperCase().includes(valorImput) || 
                res.mejores_ordenadores[i].nombre.toUpperCase().includes(valorImput) || 
                valorImput === "") {

                    if (parseFloat(res.mejores_ordenadores[i].precio.replace("Desde ", "")) >= p_min && parseFloat(res.mejores_ordenadores[i].precio.replace("Desde ", "")) <= p_max) {
                        console.log("entró");
                        arrayFiltrado.push(res.mejores_ordenadores[i]);
                    }
                }
            }
        }
    
        imprimirResultado(arrayFiltrado, valor_categoria);
    }
    
    function imprimirResultado(arrayFiltrado, valor_categoria) {
        let cont_busc = 0;
        let tabla = '';

        console.log(arrayFiltrado);

        tabla += '<div class="grid-container">';

        arrayFiltrado.forEach((element, index) => {
            tabla += '<div class="grid-item">';
            tabla += '<div class="img_comp"><button value="'+ element.nombre +'" id="fav'+ index +'" class="fav"><img src="heart_2.gif" align="right"></button><input type="checkbox" id="'+ element.nombre +'" class="comp_check" value="'+ element.nombre +'" align="right"><br><label for="'+ element.nombre +'"><img src="img_comp/'+ element.nombre +'.jpg" width="200" class="imcom"><h4>' + element.nombre + '</h4></label></div><br><p>' + element.precio + '</p><hr>'

            if (valor_categoria === "all") {
                tabla += '<p>Marca: ' + element.caracteristicas.diseño.marca_original + '&nbsp;&nbsp;&nbsp;';
            }

            cont_busc++;
            tabla += ' Clase: ' +
            element.caracteristicas.diseño.posicionamiento_mercado + '</p><hr><p>Pantalla: ' +
            element.caracteristicas.exhibicion.diagonal_pantalla + ' ' + element.caracteristicas.exhibicion.resolucion_pantalla + '</p><hr><p>Procesador: ' +
            element.caracteristicas.procesador.fabricante + ' ' +element.caracteristicas.procesador.modelo +'</p><hr><p>RAM: ' +
            element.caracteristicas.memoria.capacidad + ' ' +element.caracteristicas.memoria.velocidad +'</p><hr><p>Disco duro: ' +
            element.caracteristicas.almacenamiento.capacidad + ' ' +element.caracteristicas.almacenamiento.tipo +'</p><hr><p>Graficos: ';

            if (element.caracteristicas.graficos.integrados) {
                tabla += 'Integrados</p>'
            } else {
                tabla += element.caracteristicas.graficos.modelo_discreto + '</p>'
            }

            tabla += '</div>';
        });

        tabla += '</div>';
        tabla += '<br><br><a href="#"><img src="top.gif" alt="TOP" align="absmiddle"></a>'

        mostrarRes.innerHTML = tabla;

        if (cont_busc === 0) {
            mostrarRes.innerHTML = '<h3>No se encontraron resultados</h3><img src="img/278.gif" alt="barra" class="barra">';
        }

        // Agregar eventos de click a los botones de favoritos después de renderizar los resultados
        agregarEventosFavoritos();
    }

    function agregarEventosFavoritos() {
        for (let i = 0; i < arrayFiltrado.length; i++) {
            let boton = document.getElementById("fav" + i);
            if (boton) { // Verifica que el botón existe
                boton.addEventListener('click', function() {
                    let valor = boton.value; // Obtener el valor del botón directamente
                    console.log(valor);

                    // Enviar el valor al archivo PHP
                    fetch('dar_fav.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams({
                            'valor': valor
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.resultado);
                        // Mostrar el resultado en el HTML
                        alert(data.mensaje);
                    })
                    .catch(error => console.error('Error:', error));
                });
            }
        }
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
            for(let j = 0; j < arrayFiltrado.length; j++) {
                if (valoresSeleccionados[i] === arrayFiltrado[j].nombre) {
                    array_comp.push(arrayFiltrado[j]);
                }
            }
        }

        console.log(array_comp);
        let urlDestino = "comparar.html?array=" + JSON.stringify(array_comp);
        window.open(urlDestino, '_blank');
    }
});