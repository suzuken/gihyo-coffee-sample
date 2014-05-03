<?php
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

require __DIR__.'/config.php';
require __DIR__.'/model.php';
require __DIR__.'/controllers.php';
require __DIR__.'/FluentdServiceProvider.php';

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/templates',
]);
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\MonologServiceProvider(), [
    'monolog.logfile' => __DIR__.'/development.log',
]);
$app->register(new Silex\Provider\TranslationServiceProvider(), [
    'locale_fallbacks' => ['ja'],
]);
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Acme\FluentdServiceProvider(), [
    'fluentd.host' => 'localhost',
    'fluentd.port' => '24224',
]);

$app->run();
