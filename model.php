<?php
$app['data.json'] = $app->share(function ($c) {
    $filename = __DIR__ . '/data/item.json';
    return json_decode(fread(fopen($filename, 'r'), filesize($filename)), true);
});

$app['model.all_items'] = function ($c) {
    return $c['data.json'];
};

$app['model.item_by_id'] = $app->protect(function ($id) use ($app) {
    foreach ($app['data.json'] as $d) {
        if ($d['id'] === (int)$id) {
            return $d;
        }
    }
});
