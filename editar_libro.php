<?php

include "libro.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $IDLibro = $_POST["IDLibro"];
    $titulo = $_POST["Titulo"];
    $isbn = $_POST["ISBN"];
    $anioPublicacion = $_POST["AnioPublicacion"];

    if($_POST['accion'] == "actualizar"){
        Libro::editarLibro($_POST["IDLibro"], $_POST["ISBN"], $_POST["Titulo"], $_POST["AnioPublicacion"]);
        header("location: gestionar_libros.php");
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
    <title>Editar Libro</title>
</head>
<body>
<?php include "header.php"; ?>
<h2>Editar Libro</h2>

<br>
<form method="post">
    <input type="hidden" name="accion" value="actualizar">
    <input type="hidden" name="IDLibro" value="<?= $IDLibro ?>">
    ISBN: <input type="text" name="ISBN" value="<?= $isbn ?>" required>
    <br><br>
    Titulo: <input type="text" name="Titulo" value="<?= $titulo ?>" required>
    <br><br>
    Anio de Publicacion: <input type="text" name="AnioPublicacion" value="<?= $anioPublicacion ?>" required>
    <br><br>
    <input type="submit" value="Guardar Cambios">
</form>
</body>
</html>
