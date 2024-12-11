<?php

include "devolucion.php";
include "prestamo.php";

global $conexion;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion == "devolver_prestamo") {
            $IDPrestamo = $_POST['IDPrestamo'];
            $FechaDevolucion = $_POST['FechaDevolucion'];
            $mensaje = Devolucion::devolverPrestamo($IDPrestamo, $FechaDevolucion);
            echo "<p>$mensaje</p>";
        }
    }
}

// Obtener prestamos activos
$sql = "SELECT prestamo.IDPrestamo, cliente.Nombre AS NombreCliente
        FROM prestamo
        JOIN cliente ON prestamo.IDCliente = cliente.IDCliente
        WHERE prestamo.IDPrestamo NOT IN (SELECT IDPrestamo FROM devolucion)";
$result = $conexion->query($sql);

$prestamosActivos = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $prestamosActivos[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestionar Devoluciones</title>
</head>
<body>
<?php include "header.php"; ?>

<h1>Devolver Préstamo</h1>
<div style="border: 1px dotted black; padding: 5px">
<form method="post">
    <label for="IDPrestamo">Seleccione el Préstamo:</label>
    <select name="IDPrestamo" required>
        <option value="">Seleccione un préstamo</option>
        <?php foreach ($prestamosActivos as $prestamo): ?>
            <option value="<?= $prestamo['IDPrestamo'] ?>">
                <?= htmlspecialchars($prestamo['NombreCliente']) ?> (Préstamo ID: <?= $prestamo['IDPrestamo'] ?>)
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <label for="FechaDevolucion">Fecha de Devolución:</label>
    <input type="date" name="FechaDevolucion" value="<?= date("Y-m-d") ?>" required>
    <br><br>
    <input type="hidden" name="accion" value="devolver_prestamo">
    <input type="submit" value="Devolver Préstamo">
</form>
</div>
<?php Devolucion::mostrarDevoluciones(); ?>

</body>
</html>
