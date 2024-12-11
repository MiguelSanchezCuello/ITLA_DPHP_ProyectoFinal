<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $idCliente=$_POST['IDCliente'];
    $idLibro=$_POST['IDLibro'];
    $fechaPrestamo=$_POST['FechaPrestamo'];
    $fechaDevolucion=$_POST['FechaDevolucion'];

    $sql="INSERT INTO prestamo (IDCliente, IDLibro, FechaPrestamo, FechaDevolucion) VALUES ('$idCliente','$idLibro', '$fechaPrestamo','$fechaDevolucion')";

    if($conexion->query($sql)===TRUE){
        echo "Nuevo préstamo registrado";
    }
    else{
        echo "Error: ".$sql."<br>".$conexion->error;
    }
}

$sql="
SELECT prestamo.IDPrestamo, cliente.Nombre AS NombreCliente, prestamo.IDLibro, prestamo.FechaPrestamo, prestamo.FechaDevolucion 
FROM prestamo
JOIN cliente ON prestamo.IDCliente = cliente.IDCliente
";
$result=$conexion->query($sql);

echo "<h2>Lista de Préstamos</h2>";
if($result->num_rows>0){
    echo "
        <table border='1'>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Libro</th>
                <th>Fecha</th>
                <th>Fecha Devolución</th>
            </tr>
        ";
    while($row=$result->fetch_assoc()){
        echo "<tr><td>".$row["IDPrestamo"]."</td><td>".$row["NombreCliente"]."</td><td>".$row["IDLibro"]."</td><td>".$row["FechaPrestamo"]."</td><td>".$row["FechaDevolucion"]."</td></tr>";
    }
    echo "</table>";
}
else{
    echo "No hay préstamo registrados.";
}

$conexion->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>Registrar Préstamo</h2>
    <form method="post">
        ID Cliente: <input type="text" name="IDCliente" required>
        <br><br>
        ID Libro: <input type="text" name="IDLibro" required>
        <br><br>
        Fecha Préstamo: <input type="date" name="FechaPrestamo" required>
        <br><br>
        Fecha Devolución: <input type="date" name="FechaDevolucion" required>
        <br><br>
        <input type="submit" value="Registrar">
    </form>
</body>
</html>


