<?php 


require '../vendor/slim/slim/Slim/Slim.php';
\Slim\Slim::registerAutoloader();


$app = new \Slim\Slim();
$app->get('/hello/', function () {
    echo "Hello";
});

$app->post('/hello/:name', function ($name) {
    echo "Post Hello, " . $name;
});

$app->get('/article/:id', function ($id) {
    echo "Article, " . $id;
});

$app->run();

?>
