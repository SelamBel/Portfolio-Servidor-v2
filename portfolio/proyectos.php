<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="stylesheet" href="static/css/topnav-footer.css">
    <link rel="stylesheet" href="static/css/style.css">
</head>

<body>

    <?php require_once 'templates/nav.php'; ?>
    <main>
        <div id="divProyectos">
            <h1>Proyectos</h1>
            <div id="searchBar">
                <form id="searchForm" method="GET" action="proyectos.php">
                    <input type="text" id="searchInput" name="filter" placeholder="Buscar en nombre o descripcion...">
                    <?php echo isset($_GET['cat']) ? '<input type="hidden" name="cat" value="' . htmlspecialchars($_GET['cat']) . '">' : ''; ?>
                    <button id="searchButton">Filtrar</button>
                </form>
            </div>
            <div id="projectsContainer">
                <?php require_once 'datos.php'; ?>
                <?php
                $i = 1;
                $proyectosElegidos = [];
                
                if (isset($_GET["cat"])) {
                    $categoria = $_GET["cat"];
                    foreach ($proyectos as $proyecto) {
                        if ($proyecto['categoria'] === $categoria) {
                            $proyectosElegidos[] = $proyecto;
                        }
                    }
                } 

                if (isset($_GET["filter"])) {
                    $filtro = strtolower($_GET["filter"]);
                    $proyectosFiltrados = [];

                    if (empty($proyectosElegidos)) {
                        $proyectosElegidos = $proyectos;
                    }

                    foreach ($proyectosElegidos as $proyecto) {
                        if (strpos(strtolower($proyecto['titulo']), $filtro) !== false || strpos(strtolower($proyecto['descripcion']), $filtro) !== false) {
                            $proyectosFiltrados[] = $proyecto;
                        }
                    }
                    $proyectosElegidos = $proyectosFiltrados;
                }

                if (!isset($_GET["cat"]) && !isset($_GET["filter"])) {
                    $proyectosElegidos = $proyectos;
                }

                foreach ($proyectosElegidos as $proyecto) {
                    echo "<div class='projectContainer'>";
                    echo '<img src="' . $proyecto['imagen'] . '" alt="Imagen del Proyecto ' . $i . '">';
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