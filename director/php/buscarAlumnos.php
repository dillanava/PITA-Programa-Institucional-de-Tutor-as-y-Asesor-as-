<?php
include("../../php/conexion.php");

session_start();
$nempleado_sesion = $_SESSION['user'];

$pagina = isset($_POST['page']) ? intval($_POST['page']) : 1;
$por_pagina = 7;

$textoBusqueda = $_POST['texto'];


function generateSQLForAlumnos($nempleado_sesion, $textoBusqueda) {
    $baseQuery = "SELECT nombre, matricula, grupo, cuatrimestre, promedio, id_carrera, strikes, active, turno, email
        FROM alumnos";

    if (empty($textoBusqueda)) {
        $condition = "";
    } else {
        $condition = "WHERE matricula LIKE '%$textoBusqueda%' OR nombre LIKE '%$textoBusqueda%'";
    }

    if ($nempleado_sesion == 1) {
        $additionalCondition = "AND id_carrera IN (1, 2, 3, 4)";
    } elseif ($nempleado_sesion == 2) {
        $additionalCondition = "AND id_carrera IN (7, 8)";
    } else {
        $additionalCondition = "";
    }

    // Combina las condiciones para construir la consulta final
    if (!empty($condition)) {
        $baseQuery .= " " . $condition;
    }
    if (!empty($additionalCondition)) {
        // Si no hay condiciones previas, cambia AND por WHERE
        if (empty($condition)) {
            $additionalCondition = "WHERE " . substr($additionalCondition, 4);
        }
        $baseQuery .= " " . $additionalCondition;
    }

    return $baseQuery;
}

if (isset($_POST['texto'])) {

    $textoBusqueda = isset($_POST['texto']) ? $_POST['texto'] : "";
    $SQL = generateSQLForAlumnos($nempleado_sesion, $textoBusqueda);
    $dato = mysqli_query($conn, $SQL);
    
    // El resto del código permanece igual...

    if ($dato->num_rows > 0) {
        // Mover los encabezados de las columnas fuera del bucle while
?>
        <thead class="thead-dark">
            <tr>
            <th>Nombre <i class="bi bi-caret-down-fill"></i></th>
                                <th>Matrícula <i class="bi bi-caret-down-fill"></i></th>
                                <th>Carrera <i class="bi bi-caret-down-fill"></i></th>
                                <th>Cuatrimestre <i class="bi bi-caret-down-fill"></i></th>
                                <th>Grupo <i class="bi bi-caret-down-fill"></i></th>
                                <th>Turno <i class="bi bi-caret-down-fill"></i></th>
                                <th>Activo <i class="bi bi-caret-down-fill"></i></th>
                                <th>Promedio <i class="bi bi-caret-down-fill"></i></th>
                                <th>Strikes <i class="bi bi-caret-down-fill"></i></th>
                                <th>Email <i class="bi bi-caret-down-fill"></i></th>
                                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Comienza el bucle while
            while ($fila = mysqli_fetch_array($dato)) {
            ?>
                <tr>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['matricula']; ?></td>
                    <td><?php switch ($fila['id_carrera']) {
                            case 1:
                                echo "Ingeniería en sistemas computacionales";
                                break;
                            case 2:
                                echo "Ingeniería en robótica";
                                break;
                            case 3:
                                echo "Ingeniería en electrónica y telecomunicaciones";
                                break;
                            case 4:
                                echo "Ingeniería en logística y transporte";
                                break;
                            case 7:
                                echo "Licenciatura en administración y gestión empresarial";
                                break;
                            case 8:
                                echo "Licenciatura en comercio internacional y aduanas";
                                break;
                            default:
                                echo $fila['id_carrera'];
                                break;
                        } ?></td>
                    <td><?php echo $fila['cuatrimestre']; ?></td>
                    <td><?php echo $fila['grupo']; ?></td>
                    <td><?php switch ($fila['turno']) {
                            case 'matutino':
                                echo "Matutino";
                                break;
                            case 'vespertino':
                                echo "Vespertino";
                                break;
                            default:
                                echo $fila['id_carrera'];
                                break;
                        } ?></td>
                    <td><?php switch ($fila['active']) {
                            case 0:
                                echo "No";
                                break;
                            case 1:
                                echo "Sí";
                                break;
                            default:
                                echo $fila['active'];
                                break;
                        } ?></td>
                    <td><?php echo $fila['promedio']; ?></td>
                    <td><?php echo $fila['strikes']; ?></td>
                    <td><?php echo $fila['email']; ?></td>
                    <td>
                        <div class="btn-group">
                            <form action="">
                                <button class="btn btn-seleccionar btn-dark btn-editar mr-2" data-id="<?php echo $fila['matricula']; ?>">Editar</button>
                            </form>
                            <form action="./php/eliminarAlumno.php" method="GET">
                                <button class="btn btn-seleccionar btn-dark text-light" type="submit" name="delete" value="<?php echo $fila['matricula'] ?>">Borrar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php
            } // Finaliza el bucle while
            ?>
        </tbody>
<?php
    } else {
        echo '<thead class="thead-dark"><tr><th colspan="8">No existen registros</th></tr></thead>';
    }
}
?>
<script>
            $(document).ready(function() {
            $('th').click(function() {
                const column = $(this).index();
                const table = $(this).closest('table');
                const rows = table.find('tbody tr').toArray().sort(comparer(column));
                this.asc = !this.asc;
                if (!this.asc) {
                    rows.reverse();
                }
                table.children('tbody').empty().html(rows);
            });

            function comparer(index) {
                return function(a, b) {
                    const valA = getCellValue(a, index);
                    const valB = getCellValue(b, index);
                    return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
                };
            }

            function getCellValue(row, index) {
                return $(row).children('td').eq(index).text();
            }
        });
</script>