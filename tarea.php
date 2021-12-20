<?php 
    session_start();
    require_once 'login.php';
    require_once 'principal.php';
    
    $conexion = new mysqli($hn, $un, $pw, $db);

    if ($conexion->connect_error) die ("Fatal error");
    
    $username=$_SESSION['username'];
    //Borrar registro
    if (isset($_POST['delete']) && isset($_POST['id_tarea']))
    {   
        $id_tarea= get_post($conexion, 'id_tarea');
        $query = "DELETE FROM tareas WHERE id_tarea='$id_tarea'";
        $result = $conexion->query($query);
        if (!$result) echo "BORRAR falló"; 
    }
    //archivar
    if (isset($_POST['archivar']) && isset($_POST['id_archivar']))
    {   
        //Creando copia a la tabla archivar

        $id_tarea=get_post($conexion,'id_archivar');
        $query="INSERT INTO archivar SELECT * FROM tareas WHERE id_tarea='$id_tarea'";
        $querys = "DELETE FROM tareas WHERE id_tarea='$id_tarea'";
        $result= $conexion->query($query);
        $results= $conexion->query($querys);
        if (!$results) die ("Archivar/ fallo la busqueda");
    } 
    
    
    //Nueva Tarea
        if (isset($_POST['id_tarea']) &&
        isset($_POST['titulo']) &&
        isset($_POST['fecha_registro']) &&
        isset($_POST['fecha_vencimiento']) && 
        isset($_POST['contenido'])&&
        isset($_POST['prioridad']) )
    {
        $username=$_SESSION['username'];
        $id_tarea = get_post($conexion, 'id_tarea');
        $titulo = get_post($conexion, 'titulo');
        $fecha_registro = get_post($conexion, 'fecha_registro');
        $fecha_vencimiento = get_post($conexion, 'fecha_vencimiento');
        $contenido = get_post($conexion, 'contenido');
        $prioridad = get_post($conexion, 'prioridad');
        $query = "INSERT INTO tareas VALUE" .
            "('$username','$id_tarea','$titulo', '$fecha_registro', '$fecha_vencimiento', '$contenido', '$prioridad')";
        $result = $conexion->query($query);
        if (!$result);

    }

    //Nueva Tarea
    $charset="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
    $cad="";
    for($i=0;$i<15;$i++){
        $cad .= substr ($charset,rand (0,61),1);
    }
    date_default_timezone_set("America/Lima");

    $fecha=date('Y-m-d');
    echo <<<_END
    <form action="tarea.php" method="post"><pre>
        <input type="hidden" name="id_tarea" value="$cad"  id="id_tarea">
        TÍTULO: <textarea  placeholder="Titulo" name="titulo" cols="40" rows="1.5" id="titulo"></textarea>
        FECHA DE REGISTRO: <input type="date"  value = "$fecha" name="fecha_registro" id="fecha_registro">
        FECHA DE VENCIMIENTO: <input type="date" name="fecha_vencimiento" id="fecha_vencimiento">
        <textarea placeholder="¿Cúal es la tarea?" name="contenido" cols="48" rows="10" id="contenido"></textarea>
        <label><input name="prioridad" type="radio" value="prioridad" checked /><span>Prioridad</span></label> 

        <label><input name="prioridad" type="radio" value="no prioridad" checked /><span>Sin Prioridad</span></label>

    <input type="submit" value="Agregar">
    </pre></form>
    <form action="principal.php" method="post"><pre>
    <input type="submit" value="Anterior">
    </pre></form><br><br>
    _END;

    $query = "SELECT * FROM tareas WHERE username='$username' ORDER BY prioridad='no prioridad'  and fecha_registro ASC";
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
        </form> <br>
        _END;
    }

    $result->close();
    $conexion->close();

    function get_post($con, $var)
    {
        return $con->real_escape_string($_POST[$var]);
    }
?>