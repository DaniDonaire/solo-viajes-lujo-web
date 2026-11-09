<?php

function svl_list_escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function svl_list_options(array $columns, $defaultSort, $defaultDirection = 'asc', $defaultSize = 50)
{
    $sort = $_GET['sort'] ?? $defaultSort;
    $direction = $_GET['dir'] ?? $defaultDirection;
    $size = filter_var($_GET['per_page'] ?? $defaultSize, FILTER_VALIDATE_INT);
    $page = filter_var($_GET['page'] ?? 1, FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
    return array(
        'sort' => is_string($sort) && isset($columns[$sort]) ? $sort : $defaultSort,
        'dir' => in_array($direction, array('asc', 'desc'), true) ? $direction : $defaultDirection,
        'per_page' => in_array($size, array(10, 25, 50, 100), true) ? $size : $defaultSize,
        'page' => $page === false ? 1 : $page,
    );
}

function svl_list_order(array $options, array $columns, $tieBreaker)
{
    $direction = $options['dir'] === 'asc' ? ' ASC' : ' DESC';
    $parts = array_map(static function ($column) use ($direction) {
        return $column.$direction;
    }, $columns[$options['sort']][1]);
    return ' ORDER BY '.implode(', ', $parts).', '.$tieBreaker;
}

function svl_list_pagination(array $options, $total)
{
    $pages = max(1, (int) ceil($total / $options['per_page']));
    $page = min($options['page'], $pages);
    return array('total' => $total, 'pages' => $pages, 'page' => $page,
        'offset' => ($page - 1) * $options['per_page']);
}

function svl_list_url($action, array $parameters, $fragment = '')
{
    return $action.'?'.http_build_query($parameters, '', '&', PHP_QUERY_RFC3986).$fragment;
}

function svl_list_hidden_fields(array $parameters)
{
    foreach ($parameters as $key => $value) {
        echo '<input type="hidden" name="'.svl_list_escape($key).'" value="'.svl_list_escape($value).'">';
    }
}

function svl_list_selects(array $options, array $columns)
{
    ?>
    <label>Ordenar por
        <select name="sort">
            <?php foreach ($columns as $key => [$label]): ?>
                <option value="<?= svl_list_escape($key) ?>"<?= $options['sort'] === $key ? ' selected' : '' ?>><?= svl_list_escape($label) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Sentido
        <select name="dir">
            <option value="asc"<?= $options['dir'] === 'asc' ? ' selected' : '' ?>>Ascendente</option>
            <option value="desc"<?= $options['dir'] === 'desc' ? ' selected' : '' ?>>Descendente</option>
        </select>
    </label>
    <label>Por página
        <select name="per_page">
            <?php foreach (array(10, 25, 50, 100) as $size): ?>
                <option value="<?= $size ?>"<?= $options['per_page'] === $size ? ' selected' : '' ?>><?= $size ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <?php
}

function svl_list_heading($key, $action, array $parameters, array $columns, $fragment = '')
{
    $active = $parameters['sort'] === $key;
    $direction = $active && $parameters['dir'] === 'asc' ? 'desc' : 'asc';
    $url = svl_list_url($action, array_replace($parameters, array('sort' => $key, 'dir' => $direction, 'page' => 1)), $fragment);
    $arrow = $active ? ($parameters['dir'] === 'asc' ? ' ↑' : ' ↓') : '';
    ?>
    <th scope="col"<?= $active ? ($parameters['dir'] === 'asc' ? ' aria-sort="ascending"' : ' aria-sort="descending"') : '' ?>>
        <a href="<?= svl_list_escape($url) ?>"><?= svl_list_escape($columns[$key][0]) ?><span aria-hidden="true"><?= $arrow ?></span></a>
    </th>
    <?php
}

function svl_list_pager($action, array $parameters, array $pagination, $fragment = '')
{
    $page = $pagination['page'];
    $pages = $pagination['pages'];
    if ($pagination['total'] === 0) {
        return;
    }
    unset($parameters['page']);
    $pageUrl = static function ($number) use ($action, $parameters, $fragment) {
        return svl_list_escape(svl_list_url($action, $parameters + array('page' => $number), $fragment));
    };
    $numbers = $pages <= 7 ? range(1, $pages)
        : array_unique(array_merge(array(1), range(max(1, $page - 2), min($pages, $page + 2)), array($pages)));
    $previous = 0;
    ?>
    <div class="svl-list-pager">
        <span>Página <?= number_format($page, 0, ',', '.') ?> de <?= number_format($pages, 0, ',', '.') ?></span>
        <?php if ($pages > 1): ?>
        <nav class="svl-list-pages" aria-label="Paginación del listado">
            <?php if ($page > 1): ?>
                <a href="<?= $pageUrl(1) ?>">Primera</a><a href="<?= $pageUrl($page - 1) ?>" rel="prev">Anterior</a>
            <?php endif; ?>
            <?php foreach ($numbers as $number): ?>
                <?php if ($number > $previous + 1): ?><span aria-hidden="true">…</span><?php endif; ?>
                <?php if ($number === $page): ?>
                    <span aria-current="page" aria-label="Página <?= $number ?>"><?= $number ?></span>
                <?php else: ?>
                    <a href="<?= $pageUrl($number) ?>" aria-label="Página <?= $number ?>"><?= $number ?></a>
                <?php endif; ?>
                <?php $previous = $number; ?>
            <?php endforeach; ?>
            <?php if ($page < $pages): ?>
                <a href="<?= $pageUrl($page + 1) ?>" rel="next">Siguiente</a><a href="<?= $pageUrl($pages) ?>">Última</a>
            <?php endif; ?>
        </nav>
        <form class="svl-list-jump" method="get" action="<?= svl_list_escape($action.$fragment) ?>">
            <?php svl_list_hidden_fields($parameters); ?>
            <label>Ir a página <input type="number" name="page" min="1" max="<?= $pages ?>" value="<?= $page ?>" required></label>
            <button class="svl-admin-button" type="submit">Ir</button>
        </form>
        <?php endif; ?>
    </div>
    <?php
}

function svl_list_catalogue($select, $count, $order, array $options)
{
    $countResult = execute_sql($count);
    if ($countResult instanceof mysqli_result) {
        $total = (int) $countResult->fetch_row()[0];
        $pagination = svl_list_pagination($options, $total);
        $result = execute_sql($select.$order.' LIMIT '.$options['per_page'].' OFFSET '.$pagination['offset']);
        if ($result instanceof mysqli_result) {
            return array($result->fetch_all(MYSQLI_ASSOC), $pagination, '');
        }
    }
    http_response_code(503);
    return array(array(), svl_list_pagination($options, 0), 'No se ha podido cargar el listado.');
}
