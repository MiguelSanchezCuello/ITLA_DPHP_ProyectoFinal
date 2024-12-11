<?php

include "libro.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["IDLibro"])){
        $IDLibro = $_POST["IDLibro"];
    }

    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
        if($accion == "eliminar_libro"){
            Libro::eliminarLibro($IDLibro);
        }
        if($accion == "crear_libro"){
            Libro::agregarLibro($_POST['isbn'],$_POST['titulo'],$_POST['anio_publicacion']);
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
    <title>Gestion de Libros</title>
</head>
<body>
    <?php include "header.php"; ?>
    <h1>Gestionar Libros</h1>

    <div style="border: 1px dotted black; padding: 5px">
    <h3>Registrar Libro</h3>
    <form method="post">
        <input type="hidden" name="accion" value="crear_libro">
        ISBN: <input type="text" name="isbn" required>
        <br><br>
        Titulo: <input type="text" name="titulo" required>
        <br><br>
        Anio de Publicacion: <input type="date" name="anio_publicacion" required>
        <br><br>
        <input type="submit" value="Registrar">
    </form>
    </div>
    <br><br>
    <?php Libro::mostrarLibros(); ?>

</body>
</html>
