<?php
namespace Gihyo;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Fluent\Logger\FluentLogger;
use Fluent\Autoloader;

class FluentdServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['fluentd'] = $app->share(function ($app) {
            $host = $app['fluentd.host'] ? $app['fluentd.host'] : 'localhost';
            $port = $app['fluentd.port'] ? $app['fluentd.port'] : '24224';
            Autoloader::register();

            return new FluentLogger($host, $port);
        });
    }

    public function boot(Application $app)
    {
    }
}
