<?php

include "db.php";
class Libro{
    private $IDLibro;
    private $ISBN;
    private $Titulo;
    private $AnioPublicacion;

    public function __construct($IDLibro, $ISBN, $Titulo, $AnioPublicacion){
        $this->IDLibro = $IDLibro;
        $this->ISBN = $ISBN;
        $this->Titulo = $Titulo;
        $this->AnioPublicacion = $AnioPublicacion;
    }
    public function getIDLibro(){
        return $this->IDLibro;
    }
    public function getISBN(){
        return $this->ISBN;
    }
    public function getTitulo(){
        return $this->Titulo;
    }
    public function getAnioPublicacion(){
        return $this->AnioPublicacion;
    }

    public function setIDLibro($IDLibro){
        $this->IDLibro = $IDLibro;
    }
    public function setISBN($ISBN){
        $this->ISBN = $ISBN;
    }
    public function setTitulo($Titulo){
        $this->Titulo = $Titulo;
    }
    public function setAnioPublicacion($AnioPublicacion){
        $this->AnioPublicacion = $AnioPublicacion;
    }

    public static function  agregarLibro($ISBN, $Titulo, $AnioPublicacion){
        global $conexion;
        $sql = "INSERT INTO libro (ISBN, Titulo, AnioPublicacion)
                VALUES ('$ISBN', '$Titulo', '$AnioPublicacion')";

        if($conexion->query($sql) === TRUE){
            return true;
        } else {
            return false;
        }
    }

    public static function editarLibro($IDLibro, $ISBN, $Titulo, $AnioPublicacion){
        global $conexion;
        $sql = "UPDATE libro 
                SET ISBN='$ISBN',Titulo='$Titulo',AnioPublicacion='$AnioPublicacion'
                WHERE IDLibro='$IDLibro'";

        if($conexion->query($sql) === TRUE){
            return true;
        } else {
            return false;
        }
    }

    public static function eliminarLibro($idLibro){
        global $conexion;
        $sql = "DELETE FROM libro WHERE IDLibro = $idLibro";
        if ($conexion->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public static function getArrayLibros(){
        global $conexion;
        $sql = "SELECT * FROM libro";
        $resultado = $conexion->query($sql);
        $libros = array();
        while($row = $resultado->fetch_assoc()){
            $libro = new Libro();
            $libro->setIDLibro($row['IDLibro']);
            $libro->setISBN($row['ISBN']);
            $libro->setTitulo($row['Titulo']);
            $libro->setAnioPublicacion($row['AnioPublicacion']);
            array_push($libros, $libro);
        }
        return $libros;
    }

    public static function contarTotalLibros(){
        global $conexion;

        $sql = "SELECT COUNT(*) AS TotalLibros FROM libro";

        $result = $conexion->query($sql);

        if($result){
            $row = $result->fetch_assoc();
            return $row['TotalLibros'];
        } else {
            return "Error al contar el total de libros: " . $conexion->error;
        }
    }
    public static function contarLibrosPrestados(){
        global $conexion;

        $sql = "
        SELECT COUNT(DISTINCT prestamo_libro.IDLibro) AS LibrosPrestados
        FROM prestamo_libro
    ";

        $result = $conexion->query($sql);

        if($result){
            $row = $result->fetch_assoc();
            return $row['LibrosPrestados'];
        } else {
            return "Error al contar los libros prestados: " . $conexion->error;
        }
    }

    public static function contarLibrosNoPrestados(){
        global $conexion;

        $sql = "
        SELECT COUNT(libro.IDLibro) AS LibrosNoPrestados
        FROM libro
        WHERE libro.IDLibro NOT IN (
            SELECT DISTINCT IDLibro FROM prestamo_libro
        )
    ";

        $result = $conexion->query($sql);

        if($result){
            $row = $result->fetch_assoc();
            return $row['LibrosNoPrestados'];
        } else {
            return "Error al contar los libros no prestados: " . $conexion->error;
        }
    }

    public static function mostrarLibros(){
        global $conexion;
        $sql = "SELECT * FROM libro";
        $resultado = $conexion->query($sql);

        echo "<h2>Lista de Libros Registrados</h2>";
        if($resultado->num_rows > 0){
            echo "
                    <table border='1'>
                        <tr>
                            <td>ID</td>
                            <td>ISBN</td>
                            <td>Titulo</td>
                            <td>Anio Publicacion</td>
                            <td>Acciones</td>
                        </tr>
            ";
            while($row = $resultado->fetch_assoc()){
                echo "
                    <tr>
                        <td>".$row['IDLibro']."</td>
                        <td>".$row['ISBN']."</td>
                        <td>".$row['Titulo']."</td>
                        <td>".$row['AnioPublicacion']."</td>
                        <td>
                            <form action='editar_libro.php' method='POST' style='display: inline;'>
                                <input type='hidden' name='accion' value='editar_libro'>
                                <input type='hidden' name='IDLibro' value='".$row['IDLibro']."'>
                                <input type='hidden' name='ISBN' value='".$row['ISBN']."'>
                                <input type='hidden' name='Titulo' value='".$row['Titulo']."'>
                                <input type='hidden' name='AnioPublicacion' value='".$row['AnioPublicacion']."'>
                                <button type='submit'>Editar</button>
                            </form>
                            <form action='' method='POST' style='display: inline;'>
                                <input type='hidden' name='accion' value='eliminar_libro'>
                                <input type='hidden' name='IDLibro' value='".$row['IDLibro']."'>
                                <button type='submit'>Eliminar</button>
                            </form>
                        </td>
                    </tr>
                ";
            }
            echo "</table>";
        } else {
            echo "No hay libros";
        }
        $conexion->close();
    }
}