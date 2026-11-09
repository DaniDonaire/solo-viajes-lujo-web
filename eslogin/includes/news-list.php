<?php
require_once __DIR__.'/sql_admin.php';
require_once __DIR__.'/execute_sql_admin.php';
require_once __DIR__.'/list-controls.php';

$sortColumns = array(
    'position' => array('Orden de publicación', array('orden')),
    'title' => array('Título', array('titulo')),
    'visibility' => array('Visible', array('visible')),
    'country' => array('País', array('nombre_pais')),
);
$listOptions = svl_list_options($sortColumns, 'position', 'asc', 25);
$launchResult = execute_sql(sql_all_lanzamientos());
$launches = $launchResult instanceof mysqli_result ? $launchResult->fetch_all(MYSQLI_ASSOC) : array();
$requestedLaunch = filter_var($_GET['id_lanzamiento'] ?? ($_POST['id_lanzamiento'] ?? null),
    FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
$selectedLaunch = $requestedLaunch ?: (int) ($launches[0]['id_lanzamiento'] ?? 0);
$listParameters = array('id_lanzamiento' => $selectedLaunch) + $listOptions;
[$listRows, $pagination, $listError] = svl_list_catalogue(
    'SELECT * FROM ('.sql_all_news_lanza($selectedLaunch).') AS launch_news',
    'SELECT COUNT(*) FROM newsletter WHERE id_lanzamiento='.$selectedLaunch,
    svl_list_order($listOptions, $sortColumns, 'id_news ASC'),
    $listOptions
);
