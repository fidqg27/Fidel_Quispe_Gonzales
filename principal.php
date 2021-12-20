<?php
    echo "<h1>MIS TAREAS</h1>";
    echo <<<_END
    <select name="username" onchange="location = this.value">  
    <option value="tarea.php">Mi Cuenta
    </option>
    <option value="logout.php">Cerrar Sesion
    </option>
    </select>

    <p><a href='tarea.php'>
    Nueva tarea</a></p> 

    <p><a href='pendiente.php'>Tareas Pendientes</a></p>
    <p><a href='vencida.php'>Tareas Vencidas</a></p>
    <p><a href='archivar.php'>Tareas Archivadas</a></p>
    <p><a href='todo.php'>Todas las Tareas</a></p> 
    _END;
?>
