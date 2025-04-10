<?php

session_start();
date_default_timezone_set("America/Mexico_City");

if (empty($_SESSION['user']) || empty($_SESSION['nombre'])) {
    header("location:../index.php");
    die();
}

function obtener_medallas_desbloqueadas($nempleado)
{
    include("conexion.php");

    $stmts = [
        'niveles' => "SELECT id_nivel FROM `profesor_nivel` WHERE `nempleado` = ?",
        'total_medallas' => "SELECT COUNT(*) AS total_medallas FROM `medallas`",
        'total_medallas_usuario' => "SELECT COUNT(*) AS total_medallas_usuario FROM `medallas_profesor` WHERE `nempleado` = ?",
        'recien_creado' => "SELECT recien_creado FROM `profesores` WHERE `nempleado` = ?",
        'citas_resueltas' => "SELECT COUNT(*) AS total_resueltas FROM (SELECT * FROM `citas` WHERE `nempleado` = ? AND `status` = 2 UNION ALL SELECT * FROM `citas_eliminadas` WHERE `nempleado` = ? AND `status` = 2) AS citas_resueltas",
        'medallas_desbloqueadas' => "SELECT m.* FROM `medallas` m INNER JOIN `medallas_profesor` mp ON m.id_medalla = mp.id_medalla WHERE mp.nempleado = ?"
    ];

    foreach ($stmts as $key => $sql) {
        $stmt = $conn->prepare($sql);
        if ($key == 'citas_resueltas') {
            $stmt->bind_param("ii", $nempleado, $nempleado);
        } elseif (in_array($key, ['niveles', 'total_medallas_usuario', 'recien_creado', 'medallas_desbloqueadas'])) {
            $stmt->bind_param("i", $nempleado);
        }
        $stmt->execute();
        $results[$key] = $stmt->get_result();
    }

    asignar_medalla_profesor_recien_creado($nempleado, $results['recien_creado']->fetch_assoc()['recien_creado']);
    
    asignar_medallas_citas_resueltas($nempleado, $results['citas_resueltas']->fetch_assoc()['total_resueltas']);

    asignar_medallas_por_nivel($nempleado, $results['niveles']);

    $medallas = [];
    while ($row = $results['medallas_desbloqueadas']->fetch_assoc()) {
        $medallas[] = $row;
    }

    return [
        'medallas' => $medallas,
        'total_medallas' => $results['total_medallas']->fetch_assoc()['total_medallas'],
        'total_medallas_usuario' => $results['total_medallas_usuario']->fetch_assoc()['total_medallas_usuario'],
    ];
}

function asignar_medallas_por_nivel($nempleado, $result_niveles)
{
    include("conexion.php");

    while ($row = $result_niveles->fetch_assoc()) {
        $id_nivel = $row['id_nivel'];

        // Asigna la medalla correspondiente al nivel
        $id_medalla_nivel = null;
        switch ($id_nivel) {
            case 1:
                $id_medalla_nivel = 6; // Medalla para Jefe de Carrera
                break;
            case 2:
                $id_medalla_nivel = 7; // Medalla para Tutor
                break;
            case 3:
                $id_medalla_nivel = 8; // Medalla para Psicólogo
                break;
            case 4:
                $id_medalla_nivel = 9; // Medalla para Profesor
                break;
            case 5:
                // No hay medalla asignada para rector en el conjunto de datos proporcionado
                break;
        }

        if ($id_medalla_nivel !== null) {
            $sql = "INSERT INTO `medallas_profesor` (`nempleado`, `id_medalla`) SELECT ?, ? FROM DUAL WHERE NOT EXISTS (SELECT * FROM `medallas_profesor` WHERE `nempleado` = ? AND `id_medalla` = ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiii", $nempleado, $id_medalla_nivel, $nempleado, $id_medalla_nivel);
            $stmt->execute();
        }
    }
}

function asignar_medalla_profesor_recien_creado($nempleado, $recien_creado)
{
    if ($recien_creado) {
        include("conexion.php");

        $id_medalla_profesor_recien_creado = 4; // Asumiendo que 4 es el ID de la medalla de profesor recién creado

        $sql = "INSERT INTO `medallas_profesor` (`nempleado`, `id_medalla`) SELECT ?, ? FROM DUAL WHERE NOT EXISTS (SELECT * FROM `medallas_profesor` WHERE `nempleado` = ? AND `id_medalla` = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $nempleado, $id_medalla_profesor_recien_creado, $nempleado, $id_medalla_profesor_recien_creado);
        $stmt->execute();
    }
}


function asignar_medallas_citas_resueltas($nempleado, $citas_resueltas)
{
    include("conexion.php");

    $sql = "SELECT * FROM `medallas` WHERE `citas_resueltas` <= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $citas_resueltas);
    $stmt->execute();
    $result = $stmt->get_result();

    $id_medalla_dia_del_profesor = obtener_id_medalla_dia_del_profesor();

    while ($row = $result->fetch_assoc()) {
        $id_medalla = $row['id_medalla'];

        // Intenta asignar las medallas
        $sql = "INSERT INTO `medallas_profesor` (`nempleado`, `id_medalla`) SELECT ?, ? FROM DUAL WHERE NOT EXISTS (SELECT * FROM `medallas_profesor` WHERE `nempleado` = ? AND `id_medalla` = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $nempleado, $id_medalla, $nempleado, $id_medalla);
        $stmt->execute();
    }

    // Si es el Día del Profesor, intenta asignar la medalla "Feliz día"
    if ($id_medalla_dia_del_profesor !== null) {
        $sql = "INSERT INTO `medallas_profesor` (`nempleado`, `id_medalla`) SELECT ?, ? FROM DUAL WHERE NOT EXISTS (SELECT * FROM `medallas_profesor` WHERE `nempleado` = ? AND `id_medalla` = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $nempleado, $id_medalla_dia_del_profesor, $nempleado, $id_medalla_dia_del_profesor);
        $stmt->execute();
    }

    // Verifica si el profesor ha completado citas de nivel 2 y 4
    if (verificar_citas_niveles_2_y_4($nempleado)) {
        $id_medalla_niveles_2_y_4 = 14;
        $sql = "INSERT INTO `medallas_profesor` (`nempleado`, `id_medalla`) SELECT ?, ? FROM DUAL WHERE NOT EXISTS (SELECT * FROM `medallas_profesor` WHERE `nempleado` = ? AND `id_medalla` = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiii", $nempleado, $id_medalla_niveles_2_y_4, $nempleado, $id_medalla_niveles_2_y_4);
        $stmt->execute();
    }
}

function verificar_citas_niveles_2_y_4($nempleado)
{
    include("conexion.php");

    $sql = "SELECT COUNT(*) AS total_nivel_2 FROM `citas` WHERE `nempleado` = ? AND `status` = 2 AND `id_citasN` = 2";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $nempleado);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_nivel_2 = $result->fetch_assoc()['total_nivel_2'];

    $sql = "SELECT COUNT(*) AS total_nivel_4 FROM `citas` WHERE `nempleado` = ? AND `status` = 2 AND `id_citasN` = 4";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $nempleado);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_nivel_4 = $result->fetch_assoc()['total_nivel_4'];

    return $total_nivel_2 > 0 && $total_nivel_4 > 0;
}

function obtener_id_medalla_dia_del_profesor()
{
    $hoy = new DateTime();
    $dia_del_profesor = new DateTime($hoy->format('Y') . '-05-15');

    return $hoy->format('m-d') == $dia_del_profesor->format('m-d') ? 13 : null;
}
