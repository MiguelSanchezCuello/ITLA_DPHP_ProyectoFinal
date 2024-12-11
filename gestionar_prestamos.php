<?php

include "prestamo.php";
include "cliente.php";

global $conexion;

$clientes = null;
$clientes = Cliente::getArrayClientes();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['IDPrestamo'])){
        $IDPrestamo = $_POST['IDPrestamo'];
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion == "agregar_prestamo") {
            // Iniciar una transacción para asegurar consistencia
            $conexion->begin_transaction();
            try {
                // Crear el préstamo
                $IDPrestamo = Prestamo::agregarPrestamo(
                    $_POST["IDCliente"],
                    $_POST["FechaPrestamo"],
                    $_POST["FechaDevolucion"]
                );

                // Asociar libro(s) al préstamo
                $IDLibros = explode(',', $_POST["IDLibros"]); // Permitir múltiples libros separados por coma
                foreach ($IDLibros as $IDLibro) {
                    $resultado = Prestamo::asociarLibro($IDPrestamo, trim($IDLibro));
                    if (strpos($resultado, "Error") !== false) {
                        throw new Exception($resultado); // Lanzar excepción si falla la asociación
                    }
                }

                // Confirmar la transacción si todo salió bien
                $conexion->commit();
                echo "Préstamo creado y libros asociados correctamente.";

            } catch (Exception $e) {
                // Revertir la transacción en caso de error
                $conexion->rollback();

                // Eliminar el préstamo creado
                $sql = "DELETE FROM prestamo WHERE IDPrestamo = ?";
                $stmt = $conexion->prepare($sql);
                $stmt->bind_param("i", $IDPrestamo);
                $stmt->execute();

                // Mostrar el mensaje de error
                echo "Error al crear el préstamo: " . $e->getMessage();
            }
        }

        if($accion == "eliminar_prestamo"){
            Prestamo::eliminarPrestamo("$IDPrestamo");
        }
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
    <title>Gestionar Prestamos</title>
</head>
<body>
<?php include "header.php" ?>

<h2><u>Gestionar Préstamos</u></h2>
<div style="border: 1px dotted black; padding: 5px">
<h3>Registrar Nuevo Prestamo</h3>

<form method="post">
    <label for="IDCliente"><h2 style="display: inline;">Cliente: </h2></label>
    <?php if(!$clientes): ?>
        <h2>No hay Clientes registrados, proceda a agregar cliente.</h2>
        <p><a href="gestionar_clientes.php">Gestionar Clientes</a></p>
    <?php else : ?>
        <select name="IDCliente">
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?= $cliente->getIDCliente() ?>"><?= $cliente->getNombre() ?></option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
    <input type="hidden" name="accion" value="agregar_prestamo">
<!--    ID Cliente: <input type="text" name="IDCliente" required>-->
    <br><br>
    ID Libros: (separados por coma): <input type="text" name="IDLibros" required>
    <br><br>
    Fecha Préstamo: <input type="date" name="FechaPrestamo" value="<?= date("Y-m-d") ?>" required>
    <br><br>
    Fecha Devolución: <input type="date" name="FechaDevolucion" required>
    <br><br>
    <input type="submit" value="Registrar"><br><br>
</form>
</div>
<br>
<?php Prestamo::mostrarPrestamosActivos() ?>
<?php Prestamo::mostrarPrestamosRetrasados(); ?>
<?php Prestamo::mostrarPrestamos(); ?>
<br>
</body>
</html>