<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $IDPrestamo = $_POST['IDPrestamo'];
    $librosSeleccionados = $_POST['libros'] ?? [];

    // Eliminar todos los libros actuales asociados al préstamo
    $conexion->query("DELETE FROM prestamo_libro WHERE IDPrestamo = $IDPrestamo");

    // Agregar los libros seleccionados nuevamente
    foreach ($librosSeleccionados as $IDLibro) {
        $conexion->query("INSERT INTO prestamo_libro (IDPrestamo, IDLibro) VALUES ($IDPrestamo, $IDLibro)");
    }

    echo "Préstamo actualizado correctamente.";
    header("Location: editar_prestamo.php?IDPrestamo=$IDPrestamo");
}
?>
