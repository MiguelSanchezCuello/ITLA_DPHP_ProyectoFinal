<?php

include "cliente.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $_POST["nombre"];
    $cedula = $_POST["cedula"];
    $idCliente = $_POST["IDCliente"];

    if($_POST["accion"] == "actualizar"){
        Cliente::editarCliente($_POST["nombre"], $_POST["cedula"], $_POST["IDCliente"]);
        header("Location: gestionar_clientes.php");
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
    <title>Editar Cliente</title>
</head>
<body>
<?php include "header.php" ?>
<h2>Editar Cliente</h2>

<br>
<form method="post">
    <input type="hidden" name="accion" value="actualizar">
    <input type="hidden" name="IDCliente" value="<?= $idCliente ?>">
    Nombre: <input type="text" name="nombre" value="<?= $nombre ?>" required>
    <br><br>
    Cédula: <input type="text" name="cedula" value="<?= $cedula ?>" required>
    <br><br>
    <input type="submit" value="Guardar Cambios">
</form>
