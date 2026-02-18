<?php
function getCategorias($conexion) {
    if ($conexion === null) return [];

    $sql = "SELECT * FROM categorias";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute();
    $rows = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    // Devolver solo los nombres, igual que el fallback local
    return array_column($rows, 'nombre');
}

function getProyectosBD($conexion)
{
    if ($conexion === null) {
        error_log("No se pudo conectar a la BD");
        return [];
    }

    $sql = "
        SELECT 
            p.id,
            p.titulo,
            p.descripcion,
            p.imagen,
            c.nombre AS categoria,
            GROUP_CONCAT(t.nombre ORDER BY t.nombre SEPARATOR ',') AS tecnologias
        FROM proyectos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        LEFT JOIN proyecto_tecnologia pt ON p.id = pt.proyecto_id
        LEFT JOIN tecnologias t ON pt.tecnologia_id = t.id
        GROUP BY p.id, p.titulo, p.descripcion, p.imagen, c.nombre
        ORDER BY p.id
    ";

    try {
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute();
        $resultados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        $proyectos = [];
        foreach ($resultados as $row) {
            $proyectos[] = [
                'titulo' => $row['titulo'],
                'descripcion' => $row['descripcion'],
                'categoria' => $row['categoria'],
                'tecnologias' => !empty($row['tecnologias'])
                    ? explode(',', $row['tecnologias'])
                    : [],
                'imagen' => 'static/img/img/' . $row['imagen']
            ];
        }

        return $proyectos;
    } catch (PDOException $e) {
        error_log('Error al obtener proyectos: ' . $e->getMessage());
        var_dump($e->getMessage());
        return [];
    }
}

function generarSelect($categorias, $catSeleccionada = "")
{
    $html = "<select name='catSeleccionada'>\n";
    $html .= " <option value='TODAS'>TODAS</option>\n";

    foreach ($categorias as $categoria) {
        $opcion = htmlspecialchars($categoria);
        $selected = (trim($catSeleccionada ?? '' ) === trim($categoria)) ? " selected" : "";
        $html .= " <option value='$opcion'$selected>$opcion</option>\n";
    }

    $html .= "</select>\n";
    return $html;
}
