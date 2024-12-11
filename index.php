<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Gestión de Préstamos de Libros">
    <title>Inicio - Sistema de Gestión de Préstamos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background-color: #0056b3;
            color: white;
            padding: 1rem;
            text-align: center;
        }

        main {
            padding: 2rem;
        }

        h1 {
            color: #0056b3;
        }

        p {
            line-height: 1.6;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 1rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px;
            background-color: #0056b3;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #003d80;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php include "header.php" ?>

<main>
    <h2>Bienvenido</h2>
    <p>Este sistema ha sido desarrollado por Miguel Sanchez para el Diplomado de programacion Back-End PHP del
        Instituto Tecnologico de las Americas ITLA en Bonao. Con el maestro Adrián Francisco Fondeur Fernandez.
    Este sistema se basa en aplicar las competencias aprendidas en clase construyendo un sistema de gestion de
    prestamos de libros para una biblioteca utilizando Programacion Orientada a Objetos con PHP y base de datos MySQL.</p>

    <h3>Funciones principales:</h3>
    <ul>
        <li>Gestionar nuevos préstamos de libros. (CRUD)</li>
        <li>Gestionar clientes (CRUD)</li>
        <li>Gestionar Libros (CRUD)</li>
        <li>Gestionar devoluciones y verificar préstamos activos.</li>
        <li>Visualizar estadísticas, como el número total de libros y préstamos, entre otros.</li>
        <li>Identificar libros retrasados.</li>
    </ul>



    <div class="button-container">
        <a href="gestionar_prestamos.php" class="button">Gestionar Préstamos</a>
        <a href="gestionar_devoluciones.php" class="button">Gestionar Devoluciones</a>
        <a href="gestionar_clientes.php" class="button">Gestionar Clientes</a>
        <a href="gestionar_libros.php" class="button">Gestionar Libros</a>
    </div>
</main>

<footer>
    <p>© 2024 Biblioteca Digital. Miguel Sanchez.</p>
</footer>
</body>
</html>
