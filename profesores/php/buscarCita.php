<?php
include("./conexion.php");

session_start();
$nempleado_sesion = $_SESSION['user'];

function isPastDate($date, $time)
{
    $dateTime = new DateTime($date . '' . $time);
    $now = new DateTime();
    return $dateTime < $now;
}

if (isset($_POST['texto'])) {
    $textoBusqueda = $_POST['texto'];

    if ($textoBusqueda == "") {
        $SQL = "SELECT id_citas, matricula, nempleado, id_citasN, status, fecha, hora
        FROM citas
        WHERE nempleado = '$nempleado_sesion'";
    } else {
        $SQL = "SELECT id_citas, matricula, nempleado, id_citasN, status, fecha, hora 
        FROM citas 
        WHERE nempleado = '$nempleado_sesion' AND (id_citas LIKE '%$textoBusqueda%' OR nempleado LIKE '%$textoBusqueda%' OR fecha LIKE '%$textoBusqueda%' OR hora LIKE '%$textoBusqueda%' OR matricula LIKE '%$textoBusqueda%')";
    }

    $dato = mysqli_query($conn, $SQL);


    if ($dato->num_rows > 0) {
        // Mover los encabezados de las columnas fuera del bucle while
?>
        <thead class="thead-dark">
            <tr>
            <th>Cita <i class="bi bi-caret-down-fill"></i></th>
                                    <th>Tipo de cita<i class="bi bi-caret-down-fill"></i></th>
                                    <th>Matrícula del alumno <i class="bi bi-caret-down-fill"></i></th>
                                    <th>Activa <i class="bi bi-caret-down-fill"></i></th>
                                    <th>Fecha <i class="bi bi-caret-down-fill"></i></th>
                                    <th>Hora <i class="bi bi-caret-down-fill"></i></th>
                                    <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Comienza el bucle while
            while ($fila = mysqli_fetch_array($dato)) {
                $isPast = isPastDate($fila['fecha'], $fila['hora']);
            ?>
<tr>
    <td><?php echo $fila['id_citas']; ?></td>
    <td>
        <?php 
            if ($fila['id_citasN'] == 1) {
                echo 'Tutoría';
            } elseif ($fila['id_citasN'] == 2) {
                echo 'Psicológica';
            } elseif ($fila['id_citasN'] == 3) {
                echo 'Profesor';
            } else {
                echo 'Desconocido';
            }
        ?>
    </td>
    <td><?php echo $fila['matricula']; ?></td>
    <td class="<?php echo ($fila['status'] == "1") ? 'text-dark' : ' text-dark'; ?>" style="background-color: <?php echo ($fila['status'] == "1") ? '#C5E5A4' : '#FF7F7F'; ?>;">
        <?php
        if ($fila['status'] == "1") {
            echo 'Activa';
        } else {
            echo "Inactiva";
        }
        ?>
    </td>
    <td><?php echo $fila['fecha']; ?></td>
    <td><?php echo $fila['hora']; ?></td>
    <td>
        <div class="btn-group">
            <?php if ($isPast) : ?>
                <button class="btn btn-seleccionar btn-dark mr-2 btn-strike" data-matricula="<?php echo $fila['matricula']; ?>">Strike</button>
            <?php endif; ?>
            <button class="btn  mr-2 btn-seleccionar btn-dark btn-editar" data-id="<?php echo $fila['id_citas']; ?>">Descripción</button>
        </div>
    </td>
</tr>
            <?php
            } // Finaliza el bucle while
            ?>
        </tbody>
<?php
    } else {
        echo '<thead class="thead-dark"><tr><th colspan="8">Aún no tienes citas</th></tr></thead>';
    }
}
?>
<script>
    $('.btn-strike').click(function() {
        var matricula = $(this).data('matricula');
        $.ajax({
            url: './php/addStrike.php',
            type: 'POST',
            data: {
                matricula: matricula
            },
            success: function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Strike agregado',
                    text: 'Strike agregado al alumno con matrícula ' + matricula,
                    timer: 3000,
                    showConfirmButton: false,
                    allowOutsideClick: true
                });
            },
            error: function(xhr, status, error) {
                if (xhr.status === 400 && xhr.statusText === "Max Strikes") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Strikes máximos',
                        text: 'El alumno con matrícula ' + matricula + ' ya tiene el máximo de strikes (3).',
                        timer: 3000,
                        showConfirmButton: false,
                        allowOutsideClick: true
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al agregar strike',
                        text: 'Ocurrió un error al intentar agregar el strike.',
                        timer: 3000,
                        showConfirmButton: false,
                        allowOutsideClick: true
                    });
                }
            }
        });
    });
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