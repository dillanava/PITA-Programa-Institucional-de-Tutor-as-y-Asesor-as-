<?php

include('conexion.php');
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Verifica si el usuario está autenticado
$usuario = $_SESSION['user'];
$nombreUsuario = $_SESSION['nombre'];
//$correo = $_SESSION['correo'];

if ($usuario == null || $usuario == '' || $nombreUsuario == '' || $usuario == 1 || $usuario == 2 || $usuario == 3 || $usuario == 4 || $usuario == 5) {
    header("location:../index.php");
    die();
}

// Verifica si el método de solicitud es POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['calificaciones']) && is_array($_POST['calificaciones'])) {
        $calificaciones = $_POST['calificaciones'];

        // Preparar la consulta para actualizar las calificaciones
        $query = "UPDATE asignaturasa SET calificacion = ? WHERE id_asignaturasa = ?";
        $stmt = $conn->prepare($query);

        // Variables para calcular el promedio
        $sumaCalificaciones = 0;
        $totalCalificaciones = 0;

        // Obtén el grupo del alumno
        $query_get_grupo = "SELECT grupo FROM alumnos WHERE matricula = ?";
        $stmt_get_grupo = $conn->prepare($query_get_grupo);
        $stmt_get_grupo->bind_param("i", $usuario);
        $stmt_get_grupo->execute();
        $stmt_get_grupo->bind_result($grupo);
        $stmt_get_grupo->fetch();
        $stmt_get_grupo->close();

        // Obtén el periodo inicio del alumno
        $query_get_grupo = "SELECT periodo_inicio FROM alumnos WHERE matricula = ?";
        $stmt_get_grupo = $conn->prepare($query_get_grupo);
        $stmt_get_grupo->bind_param("i", $usuario);
        $stmt_get_grupo->execute();
        $stmt_get_grupo->bind_result($periodo_inicio);
        $stmt_get_grupo->fetch();
        $stmt_get_grupo->close();

        // Actualiza cada calificación en la base de datos y calcula el promedio
        $calificaciones_validas = true;
        foreach ($calificaciones as $id_asignaturasa => $calificacion) {
            if ($calificacion < 1 || $calificacion > 10) {
                $calificaciones_validas = false;
                break;
            }

            $stmt->bind_param("ii", $calificacion, $id_asignaturasa);
            $stmt->execute();

            $query_get_periodo_activo = "SELECT periodo FROM periodos WHERE activo = 1";
            $stmt_get_periodo_activo = $conn->prepare($query_get_periodo_activo);
            $stmt_get_periodo_activo->execute();
            $stmt_get_periodo_activo->bind_result($periodo_activo);
            $stmt_get_periodo_activo->fetch();
            $stmt_get_periodo_activo->close();

            $query_generacion_actual = "SELECT generacion, cuatrimestre FROM alumnos WHERE matricula = ?";
            $stmt_generacion_actual = $conn->prepare($query_generacion_actual);
            $stmt_generacion_actual->bind_param("i", $usuario);
            $stmt_generacion_actual->execute();
            $stmt_generacion_actual->bind_result($generacion_actual, $cuatrimestre_actual);
            $stmt_generacion_actual->fetch();
            $stmt_generacion_actual->close();

            // Obtén el id_materia, el id_carrera, y el cuatrimestre
            $query_get_materia_carrera_cuatrimestre = "SELECT m.id_materias, m.id_carrera, m.cuatrimestre FROM materias m
                                               JOIN asignaturasa a ON m.id_materias = a.id_materias
                                               WHERE a.id_asignaturasa = ?";
            $stmt_get_materia_carrera_cuatrimestre = $conn->prepare($query_get_materia_carrera_cuatrimestre);
            $stmt_get_materia_carrera_cuatrimestre->bind_param("i", $id_asignaturasa);
            $stmt_get_materia_carrera_cuatrimestre->execute();
            $stmt_get_materia_carrera_cuatrimestre->bind_result($id_materia, $id_carrera, $cuatrimestre);
            $stmt_get_materia_carrera_cuatrimestre->fetch();
            $stmt_get_materia_carrera_cuatrimestre->close();

            $periodo = $periodo_activo;

            $anio = date('Y'); // Obtiene el año actual del sistema

            // Inserta las calificaciones en la tabla historial_calificaciones
            $query_insert_historial = "INSERT INTO historial_calificaciones (id_carrera, matricula, id_materia, calificacion, cuatrimestre, grupo, periodo, anio, generacion, periodo_inicio) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_insert_historial = $conn->prepare($query_insert_historial);
            $stmt_insert_historial->bind_param("iiidssiiii", $id_carrera, $usuario, $id_materia, $calificacion, $cuatrimestre, $grupo, $periodo, $anio, $generacion_actual, $periodo_inicio);
            $stmt_insert_historial->execute();
            $stmt_insert_historial->close();
            


            $sumaCalificaciones += $calificacion;
            $totalCalificaciones++;
        }
        // ...
            

        if ($calificaciones_validas) {

            function incrementar_grupo($grupo)
            {
                $primer_digito = intval(substr($grupo, 0, 1));

                if ($primer_digito < 10) {
                    $primer_digito++;
                } else {
                    $primer_digito = intval(substr($grupo, 0, 1));
                    $primer_digito++;
                }

                return $primer_digito . substr($grupo, 1);
            }

            $stmt->close();

            if ($calificaciones_validas) {

                // Calcular el promedio y actualizar la columna 'promedio' en la tabla 'alumnos'
                if ($totalCalificaciones > 0) {
                    $promedio = round($sumaCalificaciones / $totalCalificaciones, 2);

                    // Agrega esta consulta para actualizar la columna 'promedio'
                    $query_update_promedio = "UPDATE alumnos SET promedio = ? WHERE matricula = ?";
                    $stmt_update_promedio = $conn->prepare($query_update_promedio);
                    $stmt_update_promedio->bind_param("di", $promedio, $usuario);
                    $stmt_update_promedio->execute();
                    $stmt_update_promedio->close();

                    $query_grupo_actual = "SELECT grupo FROM alumnos WHERE matricula = ?";
                    $stmt_grupo_actual = $conn->prepare($query_grupo_actual);
                    $stmt_grupo_actual->bind_param("i", $usuario);
                    $stmt_grupo_actual->execute();
                    $stmt_grupo_actual->bind_result($grupo_actual);
                    $stmt_grupo_actual->fetch();
                    $stmt_grupo_actual->close();

                    $nuevo_grupo = incrementar_grupo($grupo_actual);

                    $query_update_grupo = "UPDATE alumnos SET grupo = ? WHERE matricula = ?";
                    $stmt_update_grupo = $conn->prepare($query_update_grupo);
                    $stmt_update_grupo->bind_param("si", $nuevo_grupo, $usuario);
                    $stmt_update_grupo->execute();
                    $stmt_update_grupo->close();



                    $query_insert_historial = "INSERT INTO historial_grupos (matricula, grupo, cuatrimestre, generacion, promedio,periodo, periodo_inicio) VALUES (?, ?, ?, ?, ?, ?,?)";
                    $stmt_insert_historial = $conn->prepare($query_insert_historial);
                    $stmt_insert_historial->bind_param("isiidii", $usuario, $grupo_actual, $cuatrimestre_actual, $generacion_actual, $promedio, $periodo_activo, $periodo_inicio);
                    $stmt_insert_historial->execute();
                    $stmt_insert_historial->close();


                    $cuatrimestre_actual++; // Incrementa el cuatrimestre en 1
                    $query_update_cuatrimestre = "UPDATE alumnos SET cuatrimestre = ? WHERE matricula = ?";
                    $stmt_update_cuatrimestre = $conn->prepare($query_update_cuatrimestre);
                    $stmt_update_cuatrimestre->bind_param("ii", $cuatrimestre_actual, $usuario);
                    $stmt_update_cuatrimestre->execute();
                    $stmt_update_cuatrimestre->close();

                    // Obtener la id_carrera del alumno
                    $query_carrera = "SELECT id_carrera FROM alumnos WHERE matricula = ?";
                    $stmt_carrera = $conn->prepare($query_carrera);
                    $stmt_carrera->bind_param("i", $usuario);
                    $stmt_carrera->execute();
                    $stmt_carrera->bind_result($id_carrera);
                    $stmt_carrera->fetch();
                    $stmt_carrera->close();

                    // Obtener las materias del nuevo cuatrimestre
                    $query_materias = "SELECT id_materias FROM materias WHERE id_carrera = ? AND cuatrimestre = ?";
                    $stmt_materias = $conn->prepare($query_materias);
                    $stmt_materias->bind_param("ii", $id_carrera, $cuatrimestre_actual);
                    $stmt_materias->execute();
                    $stmt_materias->bind_result($id_materia);

                    $stmt_materias->store_result();

                    // Eliminar las materias anteriores en la tabla asignaturasa
                    $query_eliminar_materias = "DELETE FROM asignaturasa WHERE matricula = ?";
                    $stmt_eliminar_materias = $conn->prepare($query_eliminar_materias);
                    $stmt_eliminar_materias->bind_param("i", $usuario);
                    $stmt_eliminar_materias->execute();
                    $stmt_eliminar_materias->close();

                    // Agregar las nuevas materias en la tabla asignaturasa
                    $query_agregar_materia = "INSERT INTO asignaturasa (matricula, id_materias, calificacion) VALUES (?, ?, ?)";
                    $stmt_agregar_materia = $conn->prepare($query_agregar_materia);

                    $calificacion_inicial = 0;
                    while ($stmt_materias->fetch()) {
                        $stmt_agregar_materia->bind_param("iid", $usuario, $id_materia, $calificacion_inicial);
                        $stmt_agregar_materia->execute();
                    }

                    // Libera los resultados antes de cerrar el statement
                    $stmt_materias->free_result();
                    $stmt_materias->close();
                    $stmt_agregar_materia->close();

                    $query_update_calificaciones_ingresadas = "UPDATE alumnos SET calificaciones_ingresadas = TRUE WHERE matricula = ?";
                    $stmt_update_calificaciones_ingresadas = $conn->prepare($query_update_calificaciones_ingresadas);
                    $stmt_update_calificaciones_ingresadas->bind_param("i", $usuario);
                    $stmt_update_calificaciones_ingresadas->execute();
                    $stmt_update_calificaciones_ingresadas->close();

                    // Redirige al usuario a una página de éxito
                    header("location:../ingresarCalificaciones.php?calificaciones=approved");
                } else {
                    header("location:../ingresarCalificaciones.php?calificaciones=error");
                }
            } else {
                // Redirige al usuario a una página de error
                header("location:../ingresarCalificaciones.php?calificaciones=error");
            }
        } else {
            // Si el método de solicitud no es POST, redirige al usuario a la página de inicio
            header("location:../ingresarCalificaciones.php?calificaciones=error");
        }
    }
}
?>


