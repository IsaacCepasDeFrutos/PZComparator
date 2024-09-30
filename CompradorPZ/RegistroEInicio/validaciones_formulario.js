// Función para verificar la disponibilidad del email
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    form.addEventListener("submit", async function(event) {
        event.preventDefault(); // Prevenir el envío del formulario

        const submitButton = form.querySelector('input[type="submit"]');
        submitButton.disabled = true;

        const result = await validarFormulario();
        if (result) {
            form.submit(); // Si la validación pasa, envía el formulario
        }

        // Habilitar el botón después de manejar el envío (solo si la validación falla)
        submitButton.disabled = false;
    });
});
function verificarDisponibilidadEmail() {
    return new Promise((resolve, reject) => {
        var email = document.getElementById('email').value;
        var emailDisponibilidad = document.getElementById('emailDisponibilidad');
        
        emailDisponibilidad.innerHTML = "";
        
        if (email.length === 0) {
            resolve(false);
            return;
        }
        
        var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]+$/;
        
        if (!emailRegex.test(email)) {
            emailDisponibilidad.innerHTML = "<span class='error'>Formato de correo inválido</span>";
            resolve(false);
            return;
        }
        
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "verificar_disponibilidad.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    try {
                        var respuesta = JSON.parse(xhr.responseText);
                        if (respuesta.disponible) {
                            emailDisponibilidad.innerHTML = "<span class='correcto'>Disponible</span>";
                            resolve(true);
                        } else {
                            emailDisponibilidad.innerHTML = "<span class='error'>No disponible</span>";
                            resolve(false);
                        }
                    } catch (e) {
                        emailDisponibilidad.innerHTML = "<span class='error'>Error en la respuesta del servidor</span>";
                        reject(e);
                    }
                } else {
                    emailDisponibilidad.innerHTML = "<span class='error'>Error en la solicitud</span>";
                    reject(new Error("Error en la solicitud"));
                }
            }
        };
        
        xhr.send("valor=" + encodeURIComponent(email));
    });
}

// Función para verificar la disponibilidad del nombre de usuario
function verificarDisponibilidadNombreUsuario() {
    return new Promise((resolve, reject) => {
        var nombreUsuario = document.getElementById('nombre_usuario').value;
        var nombreUsuarioDisponibilidad = document.getElementById('nombreUsuarioDisponibilidad');
        
        nombreUsuarioDisponibilidad.innerHTML = "";
        
        if (nombreUsuario.length === 0) {
            resolve(false);
            return;
        }
        
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "verificar_disponibilidad_nombreUsuario.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    try {
                        var respuesta = JSON.parse(xhr.responseText);
                        if (respuesta.disponible) {
                            nombreUsuarioDisponibilidad.innerHTML = "<span class='correcto'>Disponible</span>";
                            resolve(true);
                        } else {
                            nombreUsuarioDisponibilidad.innerHTML = "<span class='error'>No disponible</span>";
                            resolve(false);
                        }
                    } catch (e) {
                        nombreUsuarioDisponibilidad.innerHTML = "<span class='error'>Error en la respuesta del servidor</span>";
                        reject(e);
                    }
                } else {
                    nombreUsuarioDisponibilidad.innerHTML = "<span class='error'>Error en la solicitud</span>";
                    reject(new Error("Error en la solicitud"));
                }
            }
        };
        
        xhr.send("valor=" + encodeURIComponent(nombreUsuario));
    });
}

function validarNombre() {
    var nombre = document.getElementById("nombre").value.trim();
    var erroresNombre = document.getElementById("erroresNombre");
    
    if (/[^a-zA-Z\s]/.test(nombre)) {
        erroresNombre.innerHTML = "<span class='error'>El nombre no puede contener números ni caracteres especiales.</span>";
        return false;
    } else if (nombre === "") {
        erroresNombre.innerHTML = "<span class='error'></span>";
        return false;
    } else {
        erroresNombre.innerHTML = "<span class='correcto'>El nombre es válido</span>";
        return true;
    }
}

function validarApellidos() {
    var apellidos = document.getElementById("apellidos").value.trim();
    var erroresApellidos = document.getElementById("erroresApellidos");
    
    if (/[^a-zA-Z\s]/.test(apellidos)) {
        erroresApellidos.innerHTML = "<span class='error'>Los apellidos no pueden contener números ni caracteres especiales.</span>";
        return false;
    } else if (apellidos === "") {
        erroresApellidos.innerHTML = "<span class='error'></span>";
        return false;
    } else {
        erroresApellidos.innerHTML = "<span class='correcto'>Los apellidos son válidos</span>";
        return true;
    }
}

function verificarContrasenias() {
    var contrasenia = document.getElementById("contrasenia").value;
    var repiteContrasenia = document.getElementById("repiteContrasenia").value;
    var erroresContrasenia = document.getElementById("erroresContrasenia");
    
    erroresContrasenia.innerHTML = "";
    
    if (contrasenia === "" || repiteContrasenia === "") {
        return false;
    } else if (contrasenia === repiteContrasenia) {
        erroresContrasenia.innerHTML = "<span class='correcto'>Las contraseñas coinciden.</span>";
        return true;
    } else {
        erroresContrasenia.innerHTML = "<span class='error'>Las contraseñas no coinciden.</span>";
        return false;
    }
}



async function validarFormulario() {
    var nombre = document.getElementById("nombre").value;
    var apellidos = document.getElementById("apellidos").value;
    var email = document.getElementById("email").value;
    var nombreUsuario = document.getElementById("nombre_usuario").value;
    var contrasenia = document.getElementById("contrasenia").value;
    var repiteContrasenia = document.getElementById("repiteContrasenia").value;
    var errores = [];

    var emailValido = await verificarDisponibilidadEmail();
    if (!emailValido) {
        errores.push("Por favor, introduce un correo electrónico válido.");
    }

    var usuarioValido = await verificarDisponibilidadNombreUsuario();
    if (!usuarioValido) {
        errores.push("El nombre de usuario no está disponible.");
    }

    if (nombre.trim() === "" || apellidos.trim() === "" || email.trim() === "" || nombreUsuario.trim() === "" || contrasenia.trim() === "" || repiteContrasenia.trim() === "") {
        errores.push("Por favor, completa todos los campos.");
    }
    if (!validarNombre()){
        errores.push("El nombre no puede contener números ni caracteres especiales.");
    }
    if (!validarApellidos()){
        errores.push("Los apellidos no pueden contener números ni caracteres especiales.");
    }
    if (contrasenia !== repiteContrasenia) {
        errores.push("Las contraseñas no coinciden.");
    }

    var erroresDiv = document.getElementById("errores");
    erroresDiv.innerHTML = ""; // Limpiar errores anteriores

    if (errores.length > 0) {
        errores.forEach(function(error) {
            erroresDiv.innerHTML += "<span class='error'>" + error + "</span><br>";
        });
        return false;
    } else {
        // Enviar formulario usando AJAX si todas las validaciones pasan
        var formData = new FormData();
        formData.append('nombre', nombre);
        formData.append('apellidos', apellidos);
        formData.append('email', email);
        formData.append('nombreUsuario', nombreUsuario);
        formData.append('contrasenia', contrasenia);

        try {
            var response = await fetch('procesar_formulario.php', {
                method: 'POST',
                body: formData
            });
		
		window.location.href="../index.php";
		


            var result = await response.json();

            if (result.success) {
                window.location.href = 'pCC.php';
            } else {
                erroresDiv.innerHTML = "<span class='error'>" + result.message + "</span><br>";
            }
        } catch (e) {
          /*  console.log(result);
            erroresDiv.innerHTML = "<span class='error'>Error al procesar el formulario.</span><br>";*/
            session_start();
            window.location.href = '../index.php';

        return false; // Prevenir el envío del formulario convencional
    }
}}
