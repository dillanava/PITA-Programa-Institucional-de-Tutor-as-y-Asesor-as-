<?php
include('../php/conexion.php');

session_start();

$usuario = isset($_SESSION['user']) ? $_SESSION['user'] : null;
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : null;
$correo = isset($_SESSION['correo']) ? $_SESSION['correo'] : null;


if ($usuario == null || $usuario == '' || $nombreUsuario == '') {
  header("location:../index.php");
  die();
}

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
  die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Obtener los datos del usuario de la base de datos
$sql = "SELECT * FROM alumnos WHERE matricula = '" . $_SESSION['user'] . "'";
$resultado = $conn->query($sql);

// Verificar si se encontraron resultados
if ($resultado->num_rows > 0) {
  // Mostrar los datos del usuario
  $fila = $resultado->fetch_assoc();

  $email = $fila['email'];
  $grupo = $fila['grupo'];
  $cuatrimestre = $fila['cuatrimestre'];
  $promedio = $fila['promedio'];
  $strikes = $fila['strikes'];
  $turno = $fila['turno'];
} else {
  echo "No se encontraron resultados.";
}


$sql = "SELECT imagen_de_perfil FROM alumnos WHERE matricula = '" . $_SESSION['user'] . "'";
$result_imagen = $conn->query($sql);
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/PITA";
$rutaImagen = $baseUrl . "/imagenes/default.jpg";

if ($result_imagen->num_rows > 0) {
    $fila = $result_imagen->fetch_assoc();
    if (!empty($fila['imagen_de_perfil'])) {
        $rutaImagen = $baseUrl . "/" . $fila['imagen_de_perfil'];
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- jQuery primero -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Estilos de DataTables -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" />

  <!-- jQuery y DataTables JS -->
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

  <!-- Librerías CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

  <!-- SweetAlert JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Luego Popper.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

  <!-- Y finalmente Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <link href="../librerias/lightbox/css/lightbox.css" rel="stylesheet">
  <script src="../librerias/lightbox/js/lightbox.js"></script>
  <link rel="stylesheet" type="text/css" href="./css/navbarStyle.css">
  <link rel="icon" type="image/png" href="./css/icon.png">

  <!-- Tema obscuro-->
  <link id="dark-theme" rel="stylesheet" type="text/css" href="./css/dark-theme.css" disabled>
  <script src="./css/darktheme.js" defer></script>
  <script>

$(document).ready(function() {
$(document).on('keydown', function(event) {
if (event.keyCode == 123 || // si presiona F12
    (event.ctrlKey && event.shiftKey && event.keyCode == 73) || // si presiona Ctrl+Shift+I
    (event.ctrlKey && event.keyCode == 85) || // si presiona Ctrl+u
    event.keyCode == 5427727112 // Bloquear F12
) {
    return false;
}
});

$(document).on('mousedown', function(e) {
if (e.which == 3) {
    alert('Esta opción no está dispuesta, lo sentimos.'); // si presiona el click derecho del mouse
    return false;
}
});

// Bloquear clic derecho
$(document).on('contextmenu', function(e) {
e.preventDefault();
});
});

</script>

  <title>Perfil</title>


  <style>
    body {
        margin: 0;
        font-family:"Segoe UI",Benedict;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1;
        color: #fff;
        text-align: left;
        background-color: #fff;
        }   

        .btn {
  border-radius: 100px;
  background-color: #8B1D35 !important; /* Cambiado a color vino */
  border-color: transparent !important;
  color: #FFFFFF !important; /* Establecer el color del texto (iconos) en blanco */
}

.btn:hover {
  color: #FFFFFF !important; /* Mantener el color del texto (iconos) en blanco al pasar el cursor */
}

.hover-effect:hover {
    transform: rotate(360deg) scale(1.1); /* Rota el botón 10 grados y aumenta su escala al 110% */
    transition: transform 0.7s ease; /* Añade una transición suave */
}
.hover-effect1:hover {
    transform: scale(1.1); /* Hace que el elemento se escale al 110% del tamaño original */
    transition: transform 0.3s ease; /* Agrega una transición suave */
}

.btn-maroon:active,
.btn-maroon:focus,
.btn-vino:active,
.btn-vino:focus {
    outline: none !important; /* Importante para anular el estilo predeterminado */
    box-shadow: none !important; /* Importante para anular el estilo predeterminado (si se aplica) */
}
</style>

  </style>
</head>

<body>
  <header>
  <nav class="navbar navbar-expand-lg navbar-vino bg-maroon">
            <div class="container">
                <a class="navbar-brand hover-effect1" href="indexAlumnos.php"><img src="./css/logo.png" alt="Logo"></a>
                <div class="d-flex align-items-center">
            <!-- Agregado el contenedor para el nuevo logo con mx-auto para centrarlo horizontalmente -->
            <div class="d-flex align-items-center mx-auto">
            <a class="navbar-brand text-center hover-effect1" href="indexAlumnos.php">
            <img src="./css/NavUPTex.png" alt="Logo" style="width: 200px; height: 50px;">
            </a>
            </div>
                <button id="dark-theme-toggle" class="btn btn-vino mr-2 hover-effect" data-toggle="tooltip" title="Tema obscuro">
                    <i class="bi bi-moon text-white" id="dark-theme-icon"></i>
                </button>
                <button id="regresarBtn" class="btn btn-vino mr-2 hover-effect1" onclick="window.location.href='./indexAlumnos.php'">Regresar</button>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
    <a class="btn btn-vino dropdown-toggle mr-2 hover-effect1 d-flex align-items-center" href="#" id="usuarioDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php
        // Obtener la ruta de la imagen de perfil del usuario desde la base de datos
        $rutaImagen = $fila['imagen_de_perfil'];
        // Verificar si la ruta de la imagen de perfil no está vacía
        if (!empty($rutaImagen)) {
            // Si hay una imagen de perfil personalizada, mostrarla
            $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/PITA";
            echo "<img src='" . $baseUrl . "/" . $rutaImagen . "' alt='Imagen de perfil' class='rounded-circle mr-2 img-top' style='width: 30px; height: 30px;'>";
        } else {
            // Si no hay una imagen de perfil personalizada, mostrar la imagen por defecto
            echo "<img src='../imagenes/default.jpg' alt='Imagen de perfil' class='rounded-circle mr-2 img-top' style='width: 30px; height: 30px;'>";
        }
        ?>
                                <?php echo $nombreUsuario; ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="usuarioDropdown">
                            <a class="dropdown-item hover-effect1" href="./materias.php"><i class="bi bi-book"></i> Materias</a>
                                <a class="dropdown-item hover-effect1" href="./calificaciones.php"><i class="bi bi-pencil"></i> Calificaciones</a>
                                <a class="dropdown-item hover-effect1" href="./citas.php"><i class="bi bi-calendar"></i> Citas</a>
                                <a class="dropdown-item hover-effect1" href="./juego.php"><i class="bi bi-joystick"></i> Juego</a>
                                <a class="dropdown-item hover-effect1" href="../php/salir.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

  <!-- Agregar la imagen de perfil -->
  <div class="container h-100 d-flex flex-column justify-content-center align-items-center">
    <div class="text-center">
      <br>
      <br>
      <br>
      <?php
      // Obtener la ruta de la imagen de perfil del usuario desde la base de datos
      $rutaImagen = $fila['imagen_de_perfil'];
      // Verificar si la ruta de la imagen de perfil no está vacía
      if (!empty($rutaImagen)) {
        // Si hay una imagen de perfil personalizada, mostrarla
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/PITA";
        echo "<a href='" . $baseUrl . "/" . $rutaImagen . "' data-lightbox='galeria'><img src='" . $baseUrl . "/" . $rutaImagen . "' alt='Imagen de perfil' class='img-thumbnail rounded-circle mb-3' style='width: 150px; height: 150px;'></a>";
      } else {
        // Si no hay una imagen de perfil personalizada, mostrar la imagen por defecto
        echo "<a href='../imagenes/default.jpg' data-lightbox='galeria'><img src='../imagenes/default.jpg' alt='Imagen de perfil' class='img-thumbnail rounded-circle mb-3' style='width: 150px; height: 150px;'></a>";
      }
      ?>
    </div>
    <div class="text-left">
      <?php
      if ($turno == 'Matutino') {
        $turnoTexto = 'Matutino';
      } else if ($turno == 'Vespertino') {
        $turnoTexto = 'Vespertino';
      } else {
        $turnoTexto = 'Desconocido';
      }
      if ($strikes >= 3) {
        echo "<div class='alert alert-primary' role='alert' style='text-align: center;'>";
        echo "<h2><i class='bi bi-exclamation-triangle-fill me-2'></i></h2>
        Tienes 3 strikes. Por favor, comunícate con el jefe de carrera para agendar más citas";
        echo "</div>";
      }
      echo "<h1 class='mb-3 text-blanco'><b>Bienvenid@,</b> $nombreUsuario</h1>";
echo "<h2 class='mb-3 text-blanco'><b>Correo:</b> $email</h2>";
echo "<h2 class='text-blanco'><b>Matrícula:</b> $usuario</h2>";
echo "<h2 class='text-blanco'><b>Grupo:</b> $grupo</h2>";
echo "<h2 class='text-blanco'><b>Turno:</b> $turnoTexto</h2>";
echo "<h2 class='text-blanco'><b>Promedio:</b> $promedio</h2>";
echo "<h2 class='text-blanco'><b>Strikes:</b> $strikes</h2>";

      // Verificar si el usuario tiene más de tres strikes

      ?>
    </div>
    <div class="text-center">
      <br>
      <div>
        <form action="./php/subirImagen.php" method="post" enctype="multipart/form-data" class="d-flex justify-content-center" id="image-form">
          <div class="form-group">
            <label for="imagen_perfil" class="text-center" style="font-size: 20px;">Cargar imagen de perfil:</label><br>
            <label class="btn btn-seleccionar btn-dark btn-vino" for="imagen_perfil">Seleccionar imagen</label>
            <input type="file" class="form-control-file d-none" name="imagen_perfil" id="imagen_perfil" accept="image/*">
            <button type="submit" class="btn btn-subir btn-dark btn-vino" id="upload-button">Subir imagen</button>
            <p><em>La imagen no debe de ser mayor a 500KB</em></p>
          </div>
      </div>
      <span id="file-name" class="ml-2"></span>
      </form>
      <div class="text-center">
      <button type="button" class="btn btn-dark btn-vino btn-seleccionar mt-3" data-toggle="modal" data-target="#cambiarContrasenaModal">Cambiar contraseña</button>
        <p><em>En caso de que algún dato proporcionado resulte incorrecto, por favor comuníquese con el jefe de carrera correspondiente</em></p>
      </div>

        <!-- Modal de cambio de contraseña -->
  <div class="modal fade" id="cambiarContrasenaModal" tabindex="-1" role="dialog" aria-labelledby="cambiarContrasenaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered justify-content-center" role="document">
      <div class="modal-content">
        <div class="container-fluid">
          <div class="modal-header">
            <h5 class="modal-title text-dark-theme" id="cambiarContrasenaModalLabel">Cambiar contraseña</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-dark-theme">
            <form id="cambiarContrasenaForm" class="text-center">
              <div class="form-group">
                <label for="password_actual">Contraseña actual:</label>
                <input type="password" id="password_actual" name="password_actual" class="form-control" required>
              </div>
              <div class="form-group">
  <label for="nueva_password">Nueva contraseña:</label>
  <input type="password" id="nueva_password" name="nueva_password" class="form-control" required>
  <div class="progress mt-2">
    <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
  <small id="passwordStrengthMessage" class="form-text text-muted"></small>
</div>
              <div class="form-group">
                <label for="confirmar_nueva_password">Confirmar nueva contraseña:</label>
                <input type="password" id="confirmar_nueva_password" name="confirmar_nueva_password" class="form-control" required>
              </div>
              <div class="form-group">
                <button type="button" id="mostrar_ocultar_password_cambio" class="btn btn-dark">Mostrar/Ocultar contraseña</button>
              </div>
              <input type="submit" value="Actualizar contraseña" class="btn opciones btn-dark">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


      <script>

$("#nueva_password").on("input", function() {
    const passwordStrengthBar = $("#passwordStrengthBar");
    const passwordStrengthMessage = $("#passwordStrengthMessage");
    const passwordStrength = isPasswordSecure(this.value);

    let barColor = '';
    let strengthText = '';

    switch (passwordStrength) {
        case 0:
        case 1:
            barColor = 'bg-danger';
            strengthText = 'Muy débil';
            break;
        case 2:
            barColor = 'bg-warning';
            strengthText = 'Débil';
            break;
        case 3:
            barColor = 'bg-info';
            strengthText = 'Buena';
            break;
        case 4:
            barColor = 'bg-success';
            strengthText = 'Fuerte';
            break;
    }

    passwordStrengthBar.removeClass().addClass(`progress-bar ${barColor}`);
    passwordStrengthBar.css("width", `${passwordStrength * 25}%`);
    passwordStrengthMessage.text(strengthText);
});

function isPasswordSecure(password) {
    let strength = 0;
    const regexRules = [
        /[a-z]/,
        /[A-Z]/,
        /[0-9]/,
        /[^A-Za-z0-9]/,
    ];

    for (const regex of regexRules) {
        if (regex.test(password)) strength++;
    }

    return strength;
}
$("form[action='./php/cambiarContrasena.php']").on("submit", function(e) {
    const password_actual = $("#password_actual");
    const nueva_password = $("#nueva_password");
    const confirmar_nueva_password = $("#confirmar_nueva_password");

    if (nueva_password.val() !== confirmar_nueva_password.val()) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Las contraseñas no coinciden',
            text: 'Por favor, asegúrate de que las contraseñas ingresadas coincidan.',
            confirmButtonText: 'Entendido',
            allowOutsideClick: true,
            confirmButtonColor: '#ff7f7f'
        });
    } else {
        const passwordStrength = isPasswordSecure(nueva_password.val());
        if (passwordStrength < 2) {
            e.preventDefault();
            Swal.fire({
                title: 'Contraseña muy débil',
                text: 'Por favor, elige una contraseña más segura',
                icon: 'warning',
                timer: 2000,
                showConfirmButton: false,
                allowOutsideClick: true
            });
            return;
          }
    }
});

// Función para mostrar/ocultar la contraseña
$("#mostrar_ocultar_password_cambio").on("click", function() {
    const password_actual = $("#password_actual");
    const nueva_password = $("#nueva_password");
    const confirmar_nueva_password = $("#confirmar_nueva_password");

    if (password_actual.attr("type") === "password") {
        password_actual.attr("type", "text");
        nueva_password.attr("type", "text");
        confirmar_nueva_password.attr("type", "text");
    } else {
        password_actual.attr("type", "password");
        nueva_password.attr("type", "password");
        confirmar_nueva_password.attr("type", "password");
    }
});


$("#cambiarContrasenaForm").on("submit", function(e) {
    e.preventDefault();

    const password_actual = $("#password_actual");
    const nueva_password = $("#nueva_password");
    const confirmar_nueva_password = $("#confirmar_nueva_password");

    if (nueva_password.val() !== confirmar_nueva_password.val()) {
        Swal.fire({
            icon: 'error',
            title: 'Las contraseñas no coinciden',
            text: 'Por favor, asegúrate de que las contraseñas ingresadas coincidan.',
            confirmButtonText: 'Entendido',
            allowOutsideClick: true,
            confirmButtonColor: '#ff7f7f'
        });
    } else {
        const passwordStrength = isPasswordSecure(nueva_password.val());
        if (passwordStrength < 2) {
            Swal.fire({
                title: 'Contraseña muy débil',
                text: 'Por favor, elige una contraseña más segura',
                icon: 'warning',
                timer: 2000,
                showConfirmButton: false,
                allowOutsideClick: true
            });
            return;
        }

        $.ajax({
            type: "POST",
            url: "./php/cambiarContrasena.php",
            data: {
                password_actual: password_actual.val(),
                nueva_password: nueva_password.val()
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Contraseña actualizada',
                        text: response.message,
                        allowOutsideClick: true,
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then(() => {
                        // Cierra el modal al hacer clic en el botón Entendido
                        $('#cambiarContrasenaModal').modal('hide');
                        // Limpia los campos del formulario
                        password_actual.val('');
                        nueva_password.val('');
                        confirmar_nueva_password.val('');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al actualizar la contraseña',
                        text: response.message,
                        allowOutsideClick: true,
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error en la solicitud',
                    text: 'Ocurrió un error al procesar la solicitud. Por favor, inténtalo de nuevo.',
                    allowOutsideClick: true,
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            }
        });
    }
});


    //Código para actualizar la foto de perfil y recibir la notificaciones
    document.getElementById("upload-button").addEventListener("click", function(event) {
      event.preventDefault();

      const form = document.getElementById("image-form");
      const formData = new FormData(form);

      fetch("./php/subirImagen.php", {
          method: "POST",
          body: formData
        })
        .then((response) => response.json())
        .then((result) => {
          if (result.success) {
            Swal.fire({
              icon: "success",
              title: result.message,
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              // Actualiza la página si es necesario
              location.reload(); // Agrega esta línea
            });
          } else {
            Swal.fire({
              icon: "error",
              title: result.message,
              showConfirmButton: false,
              timer: 1500
            });
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });


    function checkForNewMessages() {
      // Reemplazar esta URL con la ruta del archivo PHP que verifica si hay mensajes nuevos
      const checkNewMessagesUrl = "./php/nuevosMensajes.php";

      fetch(checkNewMessagesUrl)
        .then(response => response.json())
        .then(data => {
          const mensajesBtn = document.getElementById("mensajesBtn");

          if (data.newMessages) {
            mensajesBtn.classList.add("btn-red");
            mensajesBtn.classList.remove("btn-dark");
          } else {
            mensajesBtn.classList.remove("btn-red");
            mensajesBtn.classList.add("btn-dark");
          }
        })
        .catch(error => console.error("Error al verificar mensajes nuevos:", error));
    }

    // Verificar mensajes nuevos cada 10 segundos
    setInterval(checkForNewMessages, 10000);

    // Verificar mensajes nuevos al cargar la página
    checkForNewMessages();

    // Inicializar Lightbox
    lightbox.option({
      'resizeDuration': 50,
      'wrapAround': true
    })
    document.getElementById("imagen_perfil").addEventListener("change", function(event) {
      const fileName = event.target.files[0].name;
      document.getElementById("file-name").innerHTML = "<b>Imagen seleccionada: </b>" + fileName;
    });
  </script>

</body>

</html>