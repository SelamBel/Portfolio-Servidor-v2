<?php
function getCategorias($conexion)
{
    if ($conexion === null) return [];

    $sql = "SELECT * FROM categorias";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute();
    $rows = $sentencia->fetchAll(PDO::FETCH_ASSOC);

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
                'id' => $row['id'],
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

function getTecnologias($conexion) {
    if ($conexion === null) return [];

    $sql = "SELECT * FROM tecnologias ORDER BY nombre";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute();
    $rows = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    return array_column($rows, 'nombre');
}


function generarSelect($categorias, $catSeleccionada = "", $añadirTodas = true)
{
    $html = "<select name='catSeleccionada'>\n";
    if ($añadirTodas)
        $html .= " <option value='TODAS'>TODAS</option>\n";

    foreach ($categorias as $categoria) {
        $opcion = htmlspecialchars($categoria);
        $selected = (trim($catSeleccionada ?? '') === trim($categoria)) ? " selected" : "";
        $html .= " <option value='$opcion'$selected>$opcion</option>\n";
    }

    $html .= "</select>\n";
    return $html;
}


function generarMultiSelect($tecnologias, $seleccionadas = [], $name = "tecnologias") {
    $html = "<select name='{$name}[]' id='{$name}' multiple>\n";

    foreach ($tecnologias as $tecnologia) {
        $val = htmlspecialchars($tecnologia);
        $selected = in_array($tecnologia, $seleccionadas) ? " selected" : "";
        $html .= " <option value='$val'$selected>$val</option>\n";
    }

    $html .= "</select>\n";
    return $html;
}

function crearProyecto($conexion, $titulo, $descripcion, $categoria, $tecnologias, $imagen) {
    if ($conexion === null) return false;

    try {
        $stmt = $conexion->prepare("SELECT id FROM categorias WHERE nombre = :nombre");
        $stmt->execute([':nombre' => $categoria]);
        $categoriaId = $stmt->fetchColumn();

        if (!$categoriaId) return false;

        $stmt = $conexion->prepare("
            INSERT INTO proyectos (titulo, descripcion, categoria_id, imagen) 
            VALUES (:titulo, :descripcion, :categoria_id, :imagen)
        ");
        $stmt->execute([
            ':titulo' => $titulo,
            ':descripcion' => $descripcion,
            ':categoria_id' => $categoriaId,
            ':imagen' => $imagen
        ]);

        $proyectoId = $conexion->lastInsertId();

        $stmt = $conexion->prepare("INSERT INTO proyecto_tecnologia (proyecto_id, tecnologia_id) 
        SELECT :proyecto_id, id FROM tecnologias WHERE nombre = :nombre");
        
        foreach ($tecnologias as $tecnologia) {
            $stmt->execute([':proyecto_id' => $proyectoId, ':nombre' => $tecnologia]);
        }

        return true;

    } catch (PDOException $e) {
        error_log('Error al crear proyecto: ' . $e->getMessage());
        return false;
    }
}
