<?php

include "cliente.php";
include "libro.php";
include "header.php";
include "prestamo.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reportes Biblioteca</title>
</head>
<body>
<h1>Estadisticas mas relevantes de la biblioteca</h1>

<h3>Estadisticas de los clientes</h3>
<table border="1">
    <thead>
    <tr>
        <th>Total de Clientes</th>
        <th>Clientes con Prestamos</th>
        <th>Clientes sin prestamos</th>
    </tr>
    </thead>
        <tr>
            <td style="text-align: center"><?= Cliente::contarTotalClientes() ?></td>
            <td style="text-align: center"><?= Cliente::contarClientesConPrestamosActivos() ?></td>
            <td style="text-align: center"><?= Cliente::contarClientesSinPrestamosActivos() ?></td>
        </tr>
    <tbody>
    </tbody>
</table>
<h3>Estadisticas de los Libros</h3>
<table border="1">
    <thead>
    <tr>
        <th>Total de Libros</th>
        <th>Libros Prestados</th>
        <th>Libros sin Prestar</th>
    </tr>
    </thead>
    <tr>
        <td style="text-align: center"><?= Libro::contarTotalLibros() ?></td>
        <td style="text-align: center"><?= Libro::contarLibrosPrestados() ?></td>
        <td style="text-align: center"><?= Libro::contarLibrosNoPrestados() ?></td>
    </tr>
    <tbody>
    </tbody>
</table>
<h3>Estadisticas de los Prestamos</h3>
<table border="1">
    <thead>
    <tr>
        <th>Total de Prestamos</th>
        <th>Prestamos Activos</th>
        <th>Prestamos Concretados</th>
    </tr>
    </thead>
    <tr>
        <td style="text-align: center"><?= Prestamo::contarTotalPrestamos() ?></td>
        <td style="text-align: center"><?= Prestamo::contarPrestamosActivos() ?></td>
        <td style="text-align: center"><?= Prestamo::contarPrestamosConcretados() ?></td>
    </tr>
    <tbody>
    </tbody>
</table>
</body>
</html>
