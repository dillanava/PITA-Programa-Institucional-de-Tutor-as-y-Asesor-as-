<?php
include("../php/conexion.php");

session_start();

$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
$idnivel = $_SESSION['idnivel'];

if ($usuario == null || $usuario == '' || $idnivel != 5 || $nombreUsuario == '') {
  header("location:../index.php");
  die();
}

// Get profile image URL
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT imagen_de_perfil FROM profesores WHERE nempleado = '" . $_SESSION['user'] . "'";
$result = $conn->query($sql);
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/PITA";
$rutaImagen = $baseUrl . "/imagenes/default.jpg";

if ($result->num_rows > 0) {
  $fila = $result->fetch_assoc();
  if (!empty($fila['imagen_de_perfil'])) {
    $rutaImagen = $baseUrl . "/" . $fila['imagen_de_perfil'];
  }
}

$sql = "SELECT tp.tipo_problema, COUNT(c.tipo) AS total
        FROM citas c
        INNER JOIN tipo_problema tp ON c.tipo = tp.id_tipo_problema
        GROUP BY c.tipo";

$result = $conn->query($sql);

$labels = [];
$data = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    array_push($labels, $row['tipo_problema']);
    array_push($data, $row['total']);
  }
}

// Pasa los datos a JavaScript
echo "<script>const labels = " . json_encode($labels) . ";
            const data = " . json_encode($data) . ";</script>";


$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- jQuery primero -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

  <title>Gráficas citas</title>
  <link rel="stylesheet" type="text/css" href="./css/navbarStyle.css">
  <link rel="icon" type="image/png" href="./css/icon.png">

  <!-- Modo obscuro -->
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

/* Agrega este bloque de estilos al final de tu hoja de estilos o en un archivo separado */

/* Estilo para la clase form-group */
.form-group {
    background-color: #fff; /* Color blanco de fondo */
    color: #000; /* Color del texto en el form-group (puede ser negro u otro color oscuro) */
    border: 1px solid #000; /* Borde del form-group (puede ser del mismo color que el texto) */
    padding: 15px; /* Ajusta el espaciado interior según sea necesario */
    border-radius: 8px; /* Añade esquinas redondeadas si deseas */
}
#citasChart {
    background-color: #fff;
}
#citasEliminadasChart {
    background-color: #fff;
}

.navbar {
  background-color: #8B1D35;
}
  </style>

</head>

<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-vino bg-maroon">
            <div class="container">
                <a class="navbar-brand hover-effect1" href="indexDirector.php"><img src="./css/logo.png" alt="Logo"></a>
                <div class="d-flex align-items-center">
            <!-- Agregado el contenedor para el nuevo logo con mx-auto para centrarlo horizontalmente -->
            <div class="d-flex align-items-center mx-auto">
            <a class="navbar-brand text-center hover-effect1" href="indexDirector.php">
            <img src="./css/NavUPTex.png" alt="Logo" style="width: 200px; height: 50px;">
            </a>
            </div>
                <button id="mensajesBtn" class="btn btn-vino mr-2 hover-effect" onclick="window.location.href='./mensajes.php'">
                    <i class="bi bi-envelope-fill" data-toggle="tooltip" title="Mensajes"></i>
                </button>
                <button id="dark-theme-toggle" class="btn btn-vino mr-2 hover-effect" data-toggle="tooltip" title="Tema obscuro">
                    <i class="bi bi-moon text-white" id="dark-theme-icon"></i>
                </button>
                <button id="regresarBtn" class="btn btn-vino mr-2 hover-effect1" onclick="window.location.href='./graficasMenu.php'">Regresar</button>
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
                            <a class="dropdown-item hover-effect1" href="./perfil.php"><i class="bi bi-person"></i> Perfil</a>
                                <a class="dropdown-item hover-effect1" href="./graficasMenu.php"><i class="bi bi-person-check"></i> Profesores</a>
                                <a class="dropdown-item hover-effect1" href="./notas.php"><i class="bi bi-sticky"></i> Notas</a>
                                <a class="dropdown-item hover-effect1" href="../php/salir.php"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
  <br>
  <br>
  <h1 class="text-center" style="color: #ffffff;"><i class="bi bi-bar-chart-fill" style="color: #088C4F;"></i> <b>Gráficas de las citas</b></h1>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6">
        <form id="form-resultados">
          <div class="form-group">
          <label for="anio" style="color: #000000;">Año:</label>
            <input type="number" class="form-control" id="anio" name="anio" placeholder="Ejemplo: 2023" required>
          </div>
          <div class="form-group">
          <label for="periodo" style="color: #000000;">Periodo:</label>
            <select class="form-control" id="periodo" name="periodo" required>
              <option value="1">Enero - Abril</option>
              <option value="2">Mayo - Agosto</option>
              <option value="3">Septiembre - Diciembre</option>
            </select>
          </div>
        </form>
      </div>
      <div class="col-md-6">
        <form id="form-resultados2">
          <div class="form-group">
          <label for="anio2" style="color: #000000;">Año para comparar (opcional):</label>
            <input type="number" class="form-control" id="anio2" name="anio2" placeholder="Ejemplo: 2022">
          </div>
          <div class="form-group">
          <label for="periodo2" style="color: #000000;">Periodo para comparar (opcional):</label>
            <select class="form-control" id="periodo2" name="periodo2">
              <option value="">Ninguno</option>
              <option value="1">Enero - Abril</option>
              <option value="2">Mayo - Agosto</option>
              <option value="3">Septiembre - Diciembre</option>
            </select>
          </div>
        </form>
      </div>
    </div>
    <div class="text-center">
    <button type="button" class="btn btn-dark btn-opciones" id="btn-mostrar-graficas">Mostrar gráficas</button>
    </div>
  </div>

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6">
        <div class="text-center">
          <h4 class="text-center" style="color: #fff;"><b>Citas activas</b></h4>
        </div>
        <canvas id="citasChart"></canvas>
      </div>
      <div class="col-md-6">
        <div class="text-center">
          <h4 class="text-center" style="color: #fff;"><b>Citas Eliminadas</b></h4>
        </div>
        <canvas id="citasEliminadasChart"></canvas>
      </div>
    </div>
</div>


  <script>
    $(document).ready(function() {
      let citasChart;
      let citasEliminadasChart;

      function actualizarGrafica(anio, periodo, anio2 = null, periodo2 = null) {
        $.ajax({
          url: './php/graficasCitas.php',
          method: 'POST',
          data: {
            anio: anio,
            periodo: periodo,
            anio2: anio2 || null,
            periodo2: periodo2 || null
          },
          dataType: 'json',
          success: function(data) {
            console.log(data);
            mostrarGraficaCitas(data.citas, anio, periodo, anio2, periodo2);
            mostrarGraficaCitasEliminadas(data.citas_elim, anio, periodo, anio2, periodo2);
          }
        });
      }



      function mostrarGraficaCitas(data, anio, periodo, anio2 = null, periodo2 = null) {
        const ctx = document.getElementById('citasChart').getContext('2d');

        if (citasChart) {
          citasChart.destroy();
        }
        const datasets = [{
          label: `Citas del periodo ${periodo} del año ${anio}`,
          data: data.data,
          backgroundColor: 'rgba(0,150,199,0.55)',
          borderColor: '#343A40',
          borderWidth: 1
        }];

        if (anio2 && periodo2 && data.data2) {
          datasets.push({
            label: `Citas del periodo ${periodo2} del año ${anio2}`,
            data: data.data2,
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
          });
        }

        citasChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Citas'],
            datasets: datasets
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }

      function mostrarGraficaCitasEliminadas(data, anio, periodo, anio2 = null, periodo2 = null) {
        const ctx = document.getElementById('citasEliminadasChart').getContext('2d');

        if (citasEliminadasChart) {
          citasEliminadasChart.destroy();
        }

        const datasets = [{
          label: `Citas eliminadas del periodo ${periodo} del año ${anio}`,
          data: data.data_elim, // Cambia esta línea
          backgroundColor: 'rgba(255, 99, 132, 0.55)',
          borderColor: '#343A40',
          borderWidth: 1
        }];

        if (anio2 && periodo2 && data.data_elim2) { // Cambia esta línea
          datasets.push({
            label: `Citas eliminadas del periodo ${periodo2} del año ${anio2}`,
            data: data.data_elim2, // Cambia esta línea
            backgroundColor: 'rgba(255, 206, 86, 0.2)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
          });
        }

        citasEliminadasChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Citas eliminadas'],
            datasets: datasets
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      }



      $('#btn-mostrar-graficas').click(function() {
        const anio = $('#anio').val();
        const periodo = $('#periodo').val();
        const anio2 = $('#anio2').val() || anio;
        const periodo2 = $('#periodo2').val() || null;
        actualizarGrafica(anio, periodo, anio2, periodo2);
      });
    });

    // Controlador de eventos para el envío de formularios
    $('#form-resultados, #form-resultados2').submit(function(event) {
      event.preventDefault();
      $('#btn-mostrar-graficas').trigger('click');
    });
  </script>

</body>

</html>