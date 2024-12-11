<?php

include "db.php";
class Devolucion {
    private $IDPrestamo;
    private $FechaDevolucion;

    public function __construct($IDPrestamo, $FechaDevolucion) {
        $this->IDPrestamo = $IDPrestamo;
        $this->FechaDevolucion = $FechaDevolucion;
    }

    public function getIDPrestamo() {
        return $this->IDPrestamo;
    }
    public function getFechaDevolucion() {
        return $this->FechaDevolucion;
    }
    public function setIDPrestamo($IDPrestamo) {
        $this->IDPrestamo = $IDPrestamo;
    }
    public function setFechaDevolucion($FechaDevolucion) {
        $this->FechaDevolucion = $FechaDevolucion;
    }

    public static function devolverPrestamo($IDPrestamo, $FechaDevolucion) {
        global $conexion;

        // Verificar si el préstamo es válido y está activo
        $sql = "SELECT * FROM prestamo 
            WHERE IDPrestamo = ? 
            AND IDPrestamo NOT IN (SELECT IDPrestamo FROM devolucion)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $IDPrestamo);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return "El préstamo no es válido o ya ha sido devuelto.";
        }

        // Registrar la devolución
        $sql = "INSERT INTO devolucion (IDPrestamo, FechaDevolucion) VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("is", $IDPrestamo, $FechaDevolucion);
        if ($stmt->execute()) {
            return "Préstamo devuelto exitosamente.";
        } else {
            return "Error al devolver el préstamo: " . $conexion->error;
        }
    }

    public static function mostrarDevoluciones() {
        global $conexion;

        // Consulta para obtener solo las devoluciones concretadas
        $sql = "
            SELECT 
                devolucion.IDPrestamo,
                cliente.Nombre AS NombreCliente,
                GROUP_CONCAT(libro.Titulo SEPARATOR ', ') AS Libros,
                prestamo.FechaPrestamo,
                devolucion.FechaDevolucion
            FROM devolucion
            JOIN prestamo ON devolucion.IDPrestamo = prestamo.IDPrestamo
            JOIN cliente ON prestamo.IDCliente = cliente.IDCliente
            JOIN prestamo_libro ON prestamo.IDPrestamo = prestamo_libro.IDPrestamo
            JOIN libro ON prestamo_libro.IDLibro = libro.IDLibro
            GROUP BY devolucion.IDPrestamo, cliente.Nombre, prestamo.FechaPrestamo, devolucion.FechaDevolucion
        ";

        $result = $conexion->query($sql);

        // Verificar si hay devoluciones concretadas
        if ($result->num_rows > 0) {
            echo "<h2>Lista de Devoluciones Concretadas</h2>";
            echo "
                <table border='1'>
                    <tr>
                        <th>ID Préstamo</th>
                        <th>Cliente</th>
                        <th>Libros</th>
                        <th>Fecha Préstamo</th>
                        <th>Fecha Devolución</th>
                    </tr>
            ";

            // Mostrar cada fila de resultados
            while ($row = $result->fetch_assoc()) {
                echo "
                    <tr>
                        <td>{$row['IDPrestamo']}</td>
                        <td>{$row['NombreCliente']}</td>
                        <td>{$row['Libros']}</td>
                        <td>{$row['FechaPrestamo']}</td>
                        <td>{$row['FechaDevolucion']}</td>
                    </tr>
                ";
            }

            echo "</table>";
        } else {
            // Mostrar mensaje si no hay devoluciones concretadas
            echo "<h2>No hay devoluciones concretadas.</h2>";
        }
    }
}