<?php
session_start();
$rol = $_SESSION["rol"] ?? null;
if ($rol != "ADMIN") {
    header("Location: ../index.php");
    exit();
}

include_once "../includes/conexion.php";
include_once "../includes/funciones.php";
require_once '../datos.php';
require_once '../procesamientoDatos.php';
$conexion = conectarBD();

$proyectosBD = getProyectosBD($conexion);
if (empty($proyectosBD)) {
    $proyectosElegidos = $proyectosLocal;
    $titulo = "local";
} else {
    $proyectosElegidos = $proyectosBD;
    $titulo = "BBDD";
}

$categorias = getCategorias($conexion);
if (empty($categorias)) {
    $categorias = ["Backend", "Frontend", "Fullstack"];
}

$categoriaSeleccionada = $_GET["catSeleccionada"] ?? "";
$categoriaFiltroPanel = $categoriaSeleccionada;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin</title>
    <link rel="stylesheet" href="../static/css/topnav-footer.css">
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="stylesheet" href="../static/css/private.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


<body>
    <?php require_once '../templates/nav-admin.php'; ?>

    <main>

        <div class="panel">
            <h1>Administración de proyectos (Admin) (<?php echo $titulo ?>)</h1>
            <div class="panelBotones">
                <form method="get" action="panel.php">
                    <div class="botonesFiltro">
                        <div class="botonesFiltroIzq">
                            <label for="cat">
                                Filtrar por categoria:
                                <?php echo generarSelect($categorias, $categoriaFiltroPanel); ?>
                            </label>
                            <button id="filter">Filtrar</button>
                        </div>
                        <div class="botonesFiltroDer">
                            <button id="exportCSV" name="exportCSV"><i class="fa fa-file"></i> Exportar CSV</button>
                            <button id="newProyect" name="newProyect"><i class="fa fa-plus"></i> Nuevo Proyecto</button>
                            
                        </div>
                    </div>
                </form>
            </div>
            <table>
                <tr>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Categoria</th>
                    <th>Tecnologías</th>
                    <th>Acciones</th>
                </tr>
                <?php
                foreach ($proyectosElegidos as $proyecto) {
                    echo "<tr>";
                    echo "<td>" . $proyecto["titulo"] . "</td>";
                    echo "<td>" . $proyecto["descripcion"] . "</td>";
                    echo "<td>" . $proyecto["categoria"] . "</td>";
                    $tecnologias = "";
                    foreach ($proyecto['tecnologias'] as $tecnologia) {
                        $tecnologias .= $tecnologia . " ";
                    }
                    echo "<td>" . $tecnologias . "</td>";

                    echo "<td><div class='actionBtnDiv'><button class='btnEditProyect' name='btnEditProyect'><i class='fa fa-pencil'></i> Editar</button>
            <button class='btnDeleteProyect' name='btnDeleteProyect'><i class='fa fa-trash'></i> Borrar</button></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>

        <?php
        echo '<pre>DEBUG get:';
        print_r($_GET);
        echo "<br>";
        echo '</pre>';
        ?>
    </main>
    <?php require_once '../templates/footer-admin.php'; ?>
</body>

</html>