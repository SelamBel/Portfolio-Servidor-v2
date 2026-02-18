<?php
session_start();
$rol = $_SESSION["rol"] ?? null;
if ($rol != "ADMIN") {
    header("Location: ../index.php");
    exit();
}
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
</head>


<body>
    <?php require_once '../templates/nav-admin.php'; ?>

    <main>
        <div class="panel">
            <h1>Administración de proyectos (Admin)</h1>
            <div class="panelBotones">
                <div class="botonesFiltro">
                    <div class="botonesFiltroIzq">
                        <label for="cat">
                            Filtrar por categoria:
                            <select>
                                <option>Front</option>
                                <option>Back</option>
                                <option>Full</option>
                            </select>
                        </label>
                        <button>Filtrar</button>
                    </div>
                    <div class="botonesFiltroDer">
                        <button id="exportCSV" name="exportCSV">Exportar CSV</button>
                        <button id="newProyect" name="newProyect">Nuevo Proyecto</button>
                    </div>
                </div>
            </div>
            <table>
                <th>Titulo</th>
                <th>Descripcion</th>
                <th>Categoria</th>
                <th>Tecnologías</th>
                <th>Acciones</th>
            </table>
        </div>

    </main>

    <?php require_once '../templates/footer-admin.php'; ?>
</body>

</html>