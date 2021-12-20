<?php 
    session_start();
    require_once 'login.php';
    require_once 'principal.php';
    echo "<h1>Todas las Tareas</h1>";
    $conexion = new mysqli($hn, $un, $pw, $db);

    if ($conexion->connect_error) die ("Fatal error");
    
    $username=$_SESSION['username'];
    $query = "SELECT * FROM  tareas WHERE  username='$username'  ORDER BY prioridad='prioridad'  and fecha_vencimiento DESC";
    $result = $conexion->query($query);
    if (!$result) die ("Falló el acceso a la base de datos");

    $rows = $result->num_rows;

    for ($j = 0; $j < $rows; $j++)
    {
        $row = $result->fetch_array(MYSQLI_NUM);

        $r0 = htmlspecialchars($row[0]);
        $r1 = htmlspecialchars($row[1]);
        $r2 = htmlspecialchars($row[2]);
        $r3 = htmlspecialchars($row[3]);
        $r4 = htmlspecialchars($row[4]);
        $r5 = htmlspecialchars($row[5]);
        $r6 = htmlspecialchars($row[6]);
        echo <<<_END
        <pre>
        titulo: $r2
        Fecha de Registro: $r3
        Fecha de vencimiento: $r4
        contenido: $r5
        Prioridad: $r6
        </pre>
          </pre>
        <form action='tarea.php' method='post'>
        <input type='hidden' name='delete' value='yes'>
        <input type='hidden' name='id_tarea' value='$r1'>
        <input type='submit' value='BORRAR'> 
        </form>

        <form method="post" action="editartarea.php">
        <input type="hidden" name="id_trabajo" value='$r1'>
        <input type="submit" name="Editar" value="Editar">
        </form>

        <form method="post" action="tarea.php">
        <input type="hidden" name="id_archivar" value='$r1'>
        <input type="submit" name="archivar" value="Archivar">
        </form><br><br>
        _END;
    }

    $result->close();
    $conexion->close();

    function get_post($con, $var)
    {
        return $con->real_escape_string($_POST[$var]);
    }
  
?>