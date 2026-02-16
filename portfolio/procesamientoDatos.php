<?php
function getByCategory($proyectos, $cat)
{
    foreach ($proyectos as $proyecto) {
        if ($proyecto['categoria'] === $cat) {
            $proyectosElegidos[] = $proyecto;
        }
    }
    return $proyectosElegidos;
};

function getByFilter($proyectos, $filtro)
{
    $proyectosFiltrados = [];

    foreach ($proyectos as $proyecto) {
        if (strpos(strtolower($proyecto['titulo']), $filtro) !== false || strpos(strtolower($proyecto['descripcion']), $filtro) !== false) {
            $proyectosFiltrados[] = $proyecto;
        }
    }

    return $proyectosFiltrados;
}
