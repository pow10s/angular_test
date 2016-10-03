<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

$app = new Silex\Application();
$app['debug'] = true;

//Register validator service
$app->register(new Silex\Provider\ValidatorServiceProvider());

// Register Provider to DB
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array (
        'mysql_read' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'angularTest',
            'user'      => 'root',
            'password'  => '',

        ),
        'mysql_write' => array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'angularTest',
            'user'      => 'root',
            'password'  => '',
        ),
    ),
));

// Make json accepting functionality
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);

        $request->request->replace(is_array($data) ? $data : array());
    }
});

//Mount needed controllers
$app->mount('/questions', new StackOverflow\QuestionController());

$app->error(function (\Exception $e, $code) use ($app) {
    return $app->json(array("error" => $e->getMessage()), $code);
});

$app->run();
