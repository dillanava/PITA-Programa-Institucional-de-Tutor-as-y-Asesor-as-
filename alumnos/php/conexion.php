<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbs10610773";

/*$servername = "db5012625707.hosting-data.io";
$username = "dbu2516024";
$password = "pfx5RY6JqN&THtPT";
$dbname = "dbs10610773";*/

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión a la base de datos es exitosa
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

?>