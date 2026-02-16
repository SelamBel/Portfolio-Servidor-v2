<?php
session_start();
include_once "./includes/conexion.php";
include_once "./includes/funciones.php";
require_once 'datos.php';
require_once 'procesamientoDatos.php';
$conexion = conectarBD();

$proyectosBD = getProyectosBD($conexion);
if (empty($proyectosBD)) {
    $proyectosElegidos = $proyectosLocal;
    $titulo = "Proyectos en local";
} else {
    $proyectosElegidos = $proyectosBD;
    $titulo = "Proyectos en BBDD";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?> </title>
    <link rel="stylesheet" href="static/css/topnav-footer.css">
    <link rel="stylesheet" href="static/css/style.css">
</head>

<body>

    <?php require_once 'templates/nav.php'; ?>
    <main>
        <div id="divProyectos">
            <h1><?php echo $titulo ?></h1>
            <div id="searchBar">
                <form id="searchForm" method="GET" action="proyectos.php">
                    <input type="text" id="searchInput" name="filter" placeholder="Buscar en nombre o descripcion...">
                    <?php echo isset($_GET['cat']) ? '<input type="hidden" name="cat" value="' . htmlspecialchars($_GET['cat']) . '">' : ''; ?>
                    <button id="searchButton">Filtrar</button>
                </form>
            </div>
            <div id="projectsContainer">
                <?php

                if (isset($_GET["cat"])) {
                    $categoria = $_GET["cat"];
                    $proyectosElegidos = getByCategory($proyectosElegidos, $categoria);
                }

                if (isset($_GET["filter"])) {
                    $filtro = strtolower($_GET["filter"]);
                    $proyectosElegidos = getByFilter($proyectosElegidos, $filtro);
                }

                $i = 1;
                foreach ($proyectosElegidos as $proyecto) {
                    echo "<div class='projectContainer'>";
                    echo '<img src="' . $proyecto['imagen'] . '" alt="Imagen del Proyecto ' . $i++ . '">';
                    echo '<div class="padding">';
                    echo '<h3>' . $proyecto['titulo'] . '</h3>';
                    echo '<p>' . $proyecto['descripcion'] . '</p>';
                    echo '<p><strong>Categoria:</strong> ' . $proyecto['categoria'] . '</p>';
                    echo '<p><strong>Tecnologias:</strong> ';
                    foreach ($proyecto['tecnologias'] as $tecnologia) {
                        echo $tecnologia . ' ';
                    }
                    echo '</p></div></div>';
                }
                ?>
            </div>
            <h1>Estadisticas Proyectos</h1>
            <div class="stats">
                <p>Total de Proyectos:<br> <?php echo count($proyectosElegidos); ?></p>
                <?php
                $numeroTecnologias = 0;
                foreach ($proyectosElegidos as $proyecto) {
                    $numeroTecnologias += count($proyecto['tecnologias']);
                }
                if (count($proyectosElegidos) > 0) {
                    $numeroTecnologias = $numeroTecnologias / count($proyectosElegidos);
                    $numeroTecnologias = round($numeroTecnologias, 2);
                } else {
                    $numeroTecnologias = 0;
                }

                ?>
                <p>Numero medio de tecnologías:<br><?php echo count($proyectosElegidos) > 0 ? $numeroTecnologias : 0; ?></p>
            </div>
        </div>
    </main>

    <?php require_once 'templates/footer.php'; ?>
</body>

</html>