<?php
    require_once 'login.php';
    require_once 'principal.php';
    $conexion = new mysqli($hn, $un, $pw, $db);

    if ($conexion->connect_error) die ("Fatal error");

    if(isset($_REQUEST['Editar'])){
        $id_tarea=$_POST['id_trabajo'];
        $query = "SELECT * FROM tareas where id_tarea='$id_tarea'";
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
        }
        echo <<<_END
        <form action="editafinal.php" method="post"><pre>
            <input type="hidden" name="id_tarea" value="$r1"  id="id_tarea">
            <textarea  placeholder="Titulo" name="titulo" cols="40" rows="1.5" id="titulo">$r2</textarea><input type="date" name="fecha_registro" id="fecha_registro" value='$r3'><input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value='$r4'>
            <textarea placeholder="contenido" name="contenido" cols="80" rows="10" id="contenido">$r5</textarea>
            <input type="submit" name="Editar" value="Guardar Cambios">
        </pre></form>
        <a href='tarea.php'>Regresar</a>
    _END;
    }
?>