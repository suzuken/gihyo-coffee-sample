<?php
$app['db.pdo'] = $app->share(function ($c) {
    $db_config = $c['db.config'];
    $pdo = new PDO(
        sprintf('mysql:host=%s;dbname=%s;charset=utf8', $db_config['host'], $db_config['database']),
        $db_config['user'],
        $db_config['password'],
        array(PDO::ATTR_EMULATE_PREPARES => false)
    );

    return $pdo;
});

$app['model.all_items'] = function ($c) {
    $stmt = $c['db.pdo']->query('SELECT id, name, photo_src FROM item');
    $items = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $items[] = $row;
    }

    return $items;
};

$app['model.item_by_id'] = $app->protect(function ($id) use ($app) {
    $sth = $app['db.pdo']->prepare('SELECT * FROM item where id = :id');
    $sth->bindValue(':id', $id, PDO::PARAM_INT);
    $sth->execute();
    $item = $sth->fetch(PDO::FETCH_ASSOC);

    return $item;
});
