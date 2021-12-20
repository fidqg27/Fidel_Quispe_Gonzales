<?php
    require_once 'login.php';
    require_once 'principal.php';
    $conexion = new mysqli($hn, $un, $pw, $db);

    if ($conexion->connect_error) die ("Fatal error");

    if(isset($_POST['Editar'])){
        $id_tarea=$_REQUEST['id_tarea'];
        $titulo=$_REQUEST['titulo'];
        $fecha_registro=$_REQUEST['fecha_registro'];
        $fecha_vencimiento=$_REQUEST['fecha_vencimiento'];
        $contenido=$_REQUEST['contenido'];
        $query="UPDATE tareas SET titulo='$titulo', fecha_registro='$fecha_registro', fecha_vencimiento='$fecha_vencimiento', contenido='$contenido' WHERE id_tarea='$id_tarea' and fecha_vencimiento >= date(now()) ";
        $val= $conexion->query($query);
        if(!$val){
            echo "No se ha podido Modificar";
        }
        else {
            require_once 'tarea.php';
        }
    }
?>