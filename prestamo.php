<?php

include 'db.php';

class Prestamo{
    private $IDPrestamo;
    private $IDCliente;
    private $IDLibro;
    private $FechaPrestamo;
    private $FechaDevolucion;

    public function __construct($idPrestamo,$idCliente,$idLibro,$fecha,$fechaDevolucion){
        $this->IDPrestamo = $idPrestamo;
        $this->IDCliente = $idCliente;
        $this->IDLibro = $idLibro;
        $this->FechaPrestamo = $fecha;
        $this->FechaDevolucion = $fechaDevolucion;
    }

    public function getIDPrestamo(){
        return $this->IDPrestamo;
    }
    public function getIDCliente(){
        return $this->IDCliente;
    }
    public function getIDLibro(){
        return $this->IDLibro;
    }
    public function getFechaPrestamo(){
        return $this->FechaPrestamo;
    }
    public function getFechaDevolucion(){
        return $this->FechaDevolucion;
    }
    public function setIDPrestamo($idPrestamo){
        $this->IDPrestamo = $idPrestamo;
    }
    public function setIDCliente($idCliente){
        $this->IDCliente = $idCliente;
    }
    public function setIDLibro($idLibro){
        $this->IDLibro = $idLibro;
    }
    public function setFechaPrestamo($fecha){
        $this->FechaPrestamo = $fecha;
    }
    public function setFechaDevolucion($fecha){
        $this->FechaDevolucion = $fecha;
    }
    public static function agregarPrestamo($IDCliente, $FechaPrestamo, $FechaDevolucion){
        global $conexion;
        $sql = "INSERT INTO prestamo (IDCliente, FechaPrestamo, FechaDevolucion) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iss", $IDCliente, $FechaPrestamo, $FechaDevolucion);
        $stmt->execute();

        return $conexion->insert_id; // Retorna el ID generado
    }

    public static function asociarLibro($IDPrestamo, $IDLibro) {
        global $conexion;

        $sql = "SELECT COUNT(*) AS total FROM libro WHERE IDLibro = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $IDLibro);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['total'] == 0) {
            return "Error: El libro con ID $IDLibro no existe en la base de datos.";
        }

        $sql = "INSERT INTO prestamo_libro (IDPrestamo, IDLibro) VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ii", $IDPrestamo, $IDLibro);
        if ($stmt->execute()) {
            return "Éxito: Libro con ID $IDLibro asociado al préstamo.";
        } else {
            return "Error: No se pudo asociar el libro con ID $IDLibro.";
        }
    }

    public static function editarPrestamo($idCliente,$idLibro,$fechaPrestamo,$fechaDevolucion,$idPrestamo){
        global $conexion;
        $sql="
            UPDATE prestamo 
            SET
                IDCliente = '$idCliente',
                IDLibro = '$idLibro',
                FechaPrestamo = '$fechaPrestamo',
                FechaDevolucion = '$fechaDevolucion'
            WHERE IDPrestamo = '$idPrestamo'";

        if($conexion->query($sql) === TRUE){
            return true;
        } else {
            return false;
        }
    }


    public static function eliminarPrestamo($IDPrestamo){
        global $conexion;

        // Eliminar libros asociados
        $sql = "DELETE FROM prestamo_libro WHERE IDPrestamo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $IDPrestamo);
        $stmt->execute();

        // Eliminar el préstamo
        $sql = "DELETE FROM prestamo WHERE IDPrestamo = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $IDPrestamo);
        $stmt->execute();
    }


    public static function getArrayPrestamos(){
        global $conexion;
        $sql = "SELECT * FROM prestamo";
        $result = $conexion->query($sql);
        $arrayPrestamos = [];
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $arrayPrestamos[] = new Prestamo($row["IDPrestamo"], $row['IDCliente'], $row['IDLibro'], $row["FechaPrestamo"], $row["FechaDevolucion"]);
            }
            return $arrayPrestamos;
        }
    }

//    public static function mostrarPrestamos(){
//        global $conexion;
//        $sql = "SELECT
//                    prestamo.IDPrestamo,
//                    prestamo.IDCliente,
//                    cliente.Nombre AS NombreCliente,
//                    libro.Titulo AS Libro,
//                    prestamo.FechaPrestamo,
//                    prestamo.FechaDevolucion
//                FROM prestamo
//                    JOIN cliente ON prestamo.IDCliente = cliente.IDCliente
//                    JOIN libro ON prestamo.IDLibro = libro.IDLibro";
//        $result= $conexion->query($sql);
//
//        echo "Lista de Prestamos";
//        if($result->num_rows > 0){
//            echo "
//                <table border='1'>
//                    <tr>
//                        <th>ID</th>
//                        <th>Cliente</th>
//                        <th>Libro</th>
//                        <th>Fecha</th>
//                        <th>Fecha Devolución</th>
//                        <th>Acciones</th>
//                    </tr>
//           ";
//            while($row=$result->fetch_assoc()){
//                echo "<tr>
//                        <td>".$row["IDPrestamo"]."</td>
//                        <td style='text-align:center'>".$row["NombreCliente"]."</td>
//                        <td style='text-align:center'>".$row["Libro"]."</td>
//                        <td>".$row["FechaPrestamo"]."</td>
//                        <td style='text-align:center'>".$row["FechaDevolucion"]."</td>
//                        <td>
//                            <form action='editar_prestamo.php' method='POST' style='display:inline;'>
//                                <input type='hidden' name='accion' value='editar_prestamo'>
//                                <input type='hidden' name='IDPrestamo' value='".$row["IDPrestamo"]."'>
//                                <input type='hidden' name='IDLibro' value='".$row["Libro"]."'>
//                                <input type='hidden' name='FechaPrestamo' value='".$row["FechaPrestamo"]."'>
//                                <input type='hidden' name='FechaDevolucion' value='".$row["FechaDevolucion"]."'>
//                                <input type='hidden' name='IDCliente' value='".$row["IDCliente"]."'>
//                                <button type='submit'>Editar</button>
//                            </form>
//                            <form action='' method='POST' style='display:inline;'>
//                                <input type='hidden' name='accion' value='eliminar_prestamo'>
//                                <input type='hidden' name='IDPrestamo' value='".$row["IDPrestamo"]."'>
//                                <button type='submit'>Eliminar</button>
//                            </form>
//                        </td>
//                    </tr>";
//            }
//            echo "</table>";
//        } else {
//            echo "0 results";
//        }
//        $conexion->close();
//    }

    public static function mostrarPrestamosActivos(){
        global $conexion;

        // Consulta para obtener los préstamos activos y los títulos de los libros asociados
        $sql = "
        SELECT 
            prestamo.IDPrestamo, 
            cliente.Nombre AS NombreCliente, 
            prestamo.FechaPrestamo, 
            prestamo.FechaDevolucion,
            GROUP_CONCAT(libro.Titulo SEPARATOR ', ') AS Libros
        FROM prestamo
        INNER JOIN cliente ON prestamo.IDCliente = cliente.IDCliente
        LEFT JOIN devolucion ON prestamo.IDPrestamo = devolucion.IDPrestamo
        LEFT JOIN prestamo_libro ON prestamo.IDPrestamo = prestamo_libro.IDPrestamo
        LEFT JOIN libro ON prestamo_libro.IDLibro = libro.IDLibro
        WHERE devolucion.IDPrestamo IS NULL
        GROUP BY prestamo.IDPrestamo
    ";

        $result = $conexion->query($sql);

        // Mostrar la tabla de préstamos activos
        echo "<h2>Préstamos Activos</h2>";

        if($result->num_rows > 0){
            echo "
        <table border='1'>
            <tr>
                <th>ID Préstamo</th>
                <th>Cliente</th>
                <th>Fecha de Préstamo</th>
                <th>Fecha de Devolución</th>
                <th>Libros</th>
                <th>Acciones</th>
            </tr>
        ";
            while($row = $result->fetch_assoc()){
                echo "
            <tr>
                <td>{$row['IDPrestamo']}</td>
                <td>{$row['NombreCliente']}</td>
                <td>{$row['FechaPrestamo']}</td>
                <td>{$row['FechaDevolucion']}</td>
                <td>{$row['Libros']}</td>
                <td>
                        <form action='editar_prestamo.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='accion' value='editar_prestamo'>
                            <input type='hidden' name='IDPrestamo' value='".$row["IDPrestamo"]."'>
                            <input type='hidden' name='FechaPrestamo' value='".$row["FechaPrestamo"]."'>
                            <input type='hidden' name='FechaDevolucion' value='".$row["FechaDevolucion"]."'>
                            <button type='submit'>Editar</button>
                        </form>
                        <form action='' method='POST' style='display:inline;'>
                            <input type='hidden' name='accion' value='eliminar_prestamo'>
                            <input type='hidden' name='IDPrestamo' value='".$row["IDPrestamo"]."'>
                            <button type='submit'>Eliminar</button>
                        </form>
                </td>
            </tr>
            
            ";
            }
            echo "</table>";
        } else {
            echo "<p>No hay préstamos activos en este momento.</p>";
        }
    }

    public static function mostrarPrestamosRetrasados(){
        global $conexion;

        // Consulta para obtener los préstamos retrasados
        $sql = "
        SELECT 
            prestamo.IDPrestamo, 
            cliente.Nombre AS NombreCliente, 
            prestamo.FechaPrestamo, 
            prestamo.FechaDevolucion, 
            GROUP_CONCAT(libro.Titulo SEPARATOR ', ') AS Libros
        FROM prestamo
        INNER JOIN cliente ON prestamo.IDCliente = cliente.IDCliente
        LEFT JOIN devolucion ON prestamo.IDPrestamo = devolucion.IDPrestamo
        LEFT JOIN prestamo_libro ON prestamo.IDPrestamo = prestamo_libro.IDPrestamo
        LEFT JOIN libro ON prestamo_libro.IDLibro = libro.IDLibro
        WHERE devolucion.IDPrestamo IS NULL 
          AND prestamo.FechaDevolucion < CURDATE()
        GROUP BY prestamo.IDPrestamo
    ";

        $result = $conexion->query($sql);

        // Mostrar la tabla de préstamos retrasados
        echo "<h2>Préstamos Retrasados</h2>";

        if($result->num_rows > 0){
            echo "
        <table border='1'>
            <tr>
                <th>ID Préstamo</th>
                <th>Cliente</th>
                <th>Fecha de Préstamo</th>
                <th>Fecha de Devolución</th>
                <th>Libros</th>
            </tr>
        ";
            while($row = $result->fetch_assoc()){
                echo "
            <tr>
                <td>{$row['IDPrestamo']}</td>
                <td>{$row['NombreCliente']}</td>
                <td>{$row['FechaPrestamo']}</td>
                <td>{$row['FechaDevolucion']}</td>
                <td>{$row['Libros']}</td>
            </tr>
            ";
            }
            echo "</table>";
        } else {
            echo "<p>No hay préstamos retrasados en este momento.</p>";
        }
    }

    public static function contarTotalPrestamos(){
        global $conexion;

        $sql = "SELECT COUNT(*) AS TotalPrestamos FROM prestamo";

        $result = $conexion->query($sql);

        if($result){
            $row = $result->fetch_assoc();
            return $row['TotalPrestamos'];
        } else {
            return "Error al contar el total de préstamos: " . $conexion->error;
        }
    }

    public static function contarPrestamosActivos(){
        global $conexion;

        $sql = "
        SELECT COUNT(*) AS PrestamosActivos
        FROM prestamo
        WHERE IDPrestamo NOT IN (SELECT IDPrestamo FROM devolucion)
    ";

        $result = $conexion->query($sql);

        if($result){
            $row = $result->fetch_assoc();
            return $row['PrestamosActivos'];
        } else {
            return "Error al contar los préstamos activos: " . $conexion->error;
        }
    }

    public static function contarPrestamosConcretados(){
        global $conexion;

        $sql = "SELECT COUNT(*) AS PrestamosConcretados FROM devolucion";

        $result = $conexion->query($sql);

        if($result){
            $row = $result->fetch_assoc();
            return $row['PrestamosConcretados'];
        } else {
            return "Error al contar los préstamos concretados: " . $conexion->error;
        }
    }

    public static function mostrarPrestamos() {
        global $conexion;

        $sql = "
            SELECT prestamo.IDPrestamo, cliente.Nombre AS NombreCliente, prestamo.FechaPrestamo, prestamo.FechaDevolucion, 
                   GROUP_CONCAT(libro.Titulo SEPARATOR ', ') AS Libros
            FROM prestamo
            JOIN cliente ON prestamo.IDCliente = cliente.IDCliente
            LEFT JOIN prestamo_libro ON prestamo.IDPrestamo = prestamo_libro.IDPrestamo
            LEFT JOIN libro ON prestamo_libro.IDLibro = libro.IDLibro
            GROUP BY prestamo.IDPrestamo
        ";
        $result = $conexion->query($sql);

        echo "<h2>Listado de Todos Los Préstamos</h2>";
        if ($result->num_rows > 0) {
            echo "<table border='1'>
                <tr>
                    <th>ID Préstamo</th>
                    <th>Cliente</th>
                    <th>Fecha Préstamo</th>
                    <th>Fecha Devolución</th>
                    <th>Libros</th>
                    <th>Acciones</th>
                </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['IDPrestamo']}</td>
                    <td>{$row['NombreCliente']}</td>
                    <td>{$row['FechaPrestamo']}</td>
                    <td>{$row['FechaDevolucion']}</td>
                    <td>{$row['Libros']}</td>
                    <td>
                        <form action='editar_prestamo.php' method='POST' style='display:inline;'>
                            <input type='hidden' name='accion' value='editar_prestamo'>
                            <input type='hidden' name='IDPrestamo' value='".$row["IDPrestamo"]."'>
                            <input type='hidden' name='FechaPrestamo' value='".$row["FechaPrestamo"]."'>
                            <input type='hidden' name='FechaDevolucion' value='".$row["FechaDevolucion"]."'>
                            <button type='submit'>Editar</button>
                        </form>
                        <form action='' method='POST' style='display:inline;'>
                            <input type='hidden' name='accion' value='eliminar_prestamo'>
                            <input type='hidden' name='IDPrestamo' value='".$row["IDPrestamo"]."'>
                            <button type='submit'>Eliminar</button>
                        </form>
                    </td>
                </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No hay préstamos registrados.</p>";
        }
    }

}
?>
