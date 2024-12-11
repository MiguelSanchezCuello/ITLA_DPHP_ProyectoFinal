<?php

include "cliente.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["IDCliente"])){
        $IDCliente = $_POST["IDCliente"];
    }

    if(isset($_POST["accion"])){
        $accion = $_POST["accion"];
        if($accion == "eliminar_cliente"){
            Cliente::eliminarCliente($IDCliente);
        }
        if($accion == "crear_cliente"){
            Cliente::agregarCliente($_POST['nombre'], $_POST['cedula']);
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
    <title>Gestion de Clientes</title>
</head>
<body>
<?php include "header.php" ?>
<h1>Gestionar Clientes</h1>

<div style="border: 1px dotted black; padding: 5px">
<h3>Registrar Cliente</h3>
<form method="post">
    <input type="hidden" name="accion" value="crear_cliente">
    Nombre: <input type="text" name="nombre" required>
    <br><br>
    Cédula: <input type="text" name="cedula" required>
    <br><br>
    <input type="submit" value="Registrar">
</form>
</div>
<br><br>
<?php Cliente::mostarClientes(); ?>
</body>
</html>
