<?php

include "db.php";
class Cliente {
    private $IDCliente;
    private $nombre;
    private $cedula;

    public function __construct($idCliente, $nombre, $cedula)
    {
        $this->IDCliente = $idCliente;
        $this->nombre = $nombre;
        $this->cedula = $cedula;
    }
    public function getIDCliente(){
        return $this->IDCliente;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getCedula(){
        return $this->cedula;
    }
    public function setIDCliente($idCliente){
        $this->IDCliente = $idCliente;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setCedula($cedula){
        $this->cedula = $cedula;
    }

    public static function agregarCliente($nombre, $cedula){
        global $conexion;
        $sql = "INSERT INTO cliente (Nombre, Cedula) 
                VALUES ('$nombre', '$cedula')";

        if($conexion->query($sql) === TRUE){
            return true;
        } else {
            return false;
        }
    }

    public static function editarCliente($nombre, $cedula, $idCliente){
        global $conexion;
        $sql = "UPDATE cliente 
                SET Nombre='$nombre', Cedula='$cedula' 
                WHERE IDCliente='$idCliente'";

        if($conexion->query($sql) === TRUE){
            return true;
        } else {
            return false;
        }
    }

    public static function eliminarCliente($idCliente){
        global $conexion;
        $sql = "DELETE FROM cliente WHERE IDCliente='$idCliente'";
        if($conexion->query($sql) === TRUE){
            return true;
        } else {
            return false;
        }
    }

    public static function getArrayClientes(){
        global $conexion;
        $sql = "SELECT * FROM cliente";
        $result = $conexion->query($sql);
        $arrayClientes = [];
        while($row = $result->fetch_assoc()){
            $arrayClientes[] = new Cliente($row['IDCliente'], $row['Nombre'], $row['Cedula']);
        }
        return $arrayClientes;
    }

    public static function contarTotalClientes(){
        global $conexion;

        // Consulta para contar el número total de clientes
        $sql = "SELECT COUNT(*) AS TotalClientes FROM cliente";

        $result = $conexion->query($sql);

        if($result){
            $row = $result->fetch_assoc();
            return $row['TotalClientes'];
        } else {
            return "Error al contar los clientes: " . $conexion->error;
        }
    }

    public static function contarClientesConPrestamosActivos(){
        global $conexion;

        // Consulta para contar clientes con préstamos activos
        $sql = "
        SELECT COUNT(DISTINCT prestamo.IDCliente) AS ClientesConPrestamosActivos
        FROM prestamo
        LEFT JOIN devolucion ON prestamo.IDPrestamo = devolucion.IDPrestamo
        WHERE devolucion.IDPrestamo IS NULL
    ";

        $result = $conexion->query($sql);

        if($result){
            $row = $result->fetch_assoc();
            return $row['ClientesConPrestamosActivos'];
        } else {
            return "Error al contar clientes con préstamos activos: " . $conexion->error;
        }
    }

    public static function contarClientesSinPrestamosActivos(){
        global $conexion;

        // Consulta para contar clientes sin préstamos activos
        $sql = "
        SELECT COUNT(cliente.IDCliente) AS ClientesSinPrestamosActivos
        FROM cliente
        WHERE cliente.IDCliente NOT IN (
            SELECT DISTINCT prestamo.IDCliente
            FROM prestamo
            LEFT JOIN devolucion ON prestamo.IDPrestamo = devolucion.IDPrestamo
            WHERE devolucion.IDPrestamo IS NULL
        )
    ";

        $result = $conexion->query($sql);

        if($result){
            $row = $result->fetch_assoc();
            return $row['ClientesSinPrestamosActivos'];
        } else {
            return "Error al contar clientes sin préstamos activos: " . $conexion->error;
        }
    }

    public static function mostarClientes(){
        global $conexion;
        $sql = "SELECT * FROM cliente";
        $result = $conexion->query($sql);

        echo "<h2>Lista de clientes</h2>";
        if($result->num_rows > 0){
            echo "
                    <table border='1'>
                        <tr>
                            <td>ID</td>
                            <td>Nombre</td>
                            <td>Cedula</td>
                            <td>Acciones</td>
                        </tr>
            ";
            while($row = $result->fetch_assoc()){
                echo "
                        <tr>
                            <td>".$row["IDCliente"]."</td>
                            <td>".$row["Nombre"]."</td>
                            <td>".$row["Cedula"]."</td>
                            <td>
                                <form action='editar_cliente.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='accion' value='editar_cliente'>
                                    <input type='hidden' name='IDCliente' value='".$row["IDCliente"]."'>
                                    <input type='hidden' name='nombre' value='".$row["Nombre"]."'>
                                    <input type='hidden' name='cedula' value='".$row["Cedula"]."'>
                                    <button type='submit'>Editar</button>
                                </form>
                                <form action='' method='POST' style='display:inline;'>
                                    <input type='hidden' name='accion' value='eliminar_cliente'>
                                    <input type='hidden' name='IDCliente' value='".$row["IDCliente"]."'>
                                    <button type='submit'>Eliminar</button>
                                </form>
                            </td>
                        </tr>
                ";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conexion->close();
    }
}