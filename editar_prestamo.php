<?php
//Conexión a la base de datos

include 'db.php';

global $conexion;

// Obtener el ID del préstamo actual
if(isset($_GET["IDPrestamo"])){
    $IDPrestamo = $_GET["IDPrestamo"];
    echo "<h3>Prestamo actualizado!!!</h3>";
    echo "<p>Puede seguir realizando cambios o regresar al listado de prestamos usando el menu</p>";
} else {
    $IDPrestamo = $_POST['IDPrestamo'];
}


// Obtener todos los libros
$libros = $conexion->query("SELECT * FROM libro");

// Obtener los libros asociados al préstamo
$librosPrestamo = $conexion->query("SELECT IDLibro FROM prestamo_libro WHERE IDPrestamo = $IDPrestamo");

// Convertir los libros asociados en un array para facilitar la comparación
$librosPrestamoArray = [];
while ($libro = $librosPrestamo->fetch_assoc()) {
    $librosPrestamoArray[] = $libro['IDLibro'];
}
?>

<?php include "header.php"; ?>
<form method="post" action="actualizar_prestamo.php">
    <input type="hidden" name="IDPrestamo" value="<?= $IDPrestamo ?>">

    <h3>Selecciona los libros para este préstamo:</h3>
    <?php while ($libro = $libros->fetch_assoc()): ?>
        <label>
            <input type="checkbox" name="libros[]" value="<?= $libro['IDLibro'] ?>"
                <?= in_array($libro['IDLibro'], $librosPrestamoArray) ? 'checked' : '' ?>>
            <?= htmlspecialchars($libro['Titulo']) ?>
        </label><br>
    <?php endwhile; ?>

    <button type="submit">Actualizar Préstamo</button>
</form>
