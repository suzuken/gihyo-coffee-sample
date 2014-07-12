<?php
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

$app->before(function (Request $request) {
    $request->getSession()->start();
});

$after = function (Request $request, Response $response, Application $app) {
    $app['fluentd']->post("log.test", ["hello"=>"world", "server"=>$_SERVER, "session"=>$app['session']->getId()]);
};

$app['template.render'] = $app->protect(function ($path, $params) {
    extract($params, EXTR_SKIP);
    ob_start();
    require $path;
    $html = ob_get_clean();

    return $html;
});

$app->get('/', function (Application $app, Request $request) {
    $items = $app['model.all_items'];
    $render = $app['template.render'];

    return $app['twig']->render('list.html.twig', ['items' => $items]);
})
->after($after);

$app->get('/show/{id}', function ($id, Application $app, Request $request) {
    $get_item_by_id = $app['model.item_by_id'];
    $item = $get_item_by_id($id);
    if (!$item) {
        $app->abort(404);
    }
    $app['fluentd']->post("log.show_item", ["type"=>"show_item", "server"=>$_SERVER, "session"=>$app['session']->getId()]);

    return $app['twig']->render('show.html.twig', ['item' => $item]);
})
->bind('coffee_item')
->after($after);

$app->get('/login', function (Application $app, Request $request) {
    $app['session']->start();
    if ($app['session']->has('user') && $app['session']->has('password')) {
        return $app->redirect('/');
    }

    $form = $app['form.factory']->createBuilder('form')
        ->add('email', 'text', [
            'constraints' => new Assert\Email()
        ])
        ->add('password', 'password', [
            'constraints' => new Assert\NotBlank()
        ])
        ->getForm();

    $app['fluentd']->post("log.user_login", ["type"=>"user_login", "server"=>$_SERVER, "session"=>$app['session']->getId()]);

    return $app['twig']->render('form.html.twig', ['form' => $form->createView()]);
})
->after($after);

$app->post('/auth', function (Application $app, Request $request) {
    $email = $request->request->get('form')['email'];
    $password = $request->request->get('form')['password'];

    if ('guest@example.com' !== $email || 'password' !== $password) {
        return $app->redirect('/login');
    }

    $app['session']->set('email', $email);

    return $app->redirect('/');
});

$app->get('/logout', function (Application $app, Request $request) {
    $app['session']->clear();

    return $app->redirect('/');
});

$app->error(function (\Exception $e, $code) {
    $html = '<html><body><h1>ページが見つかりません</h1></body></html>';
    var_dump($e);

    return new Response($html, $code);
});
