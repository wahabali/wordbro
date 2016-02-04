<?php
/**
 * Created by PhpStorm.
 * User: wts82020
 * Date: 07.08.2015
 * Time: 14:49
 */

require '../../vendor/slim/slim/Slim/Slim.php';
include_once '../commons.php';
include_once '../DL/word.php ';
include_once '../log/log.php';
include_once '../objects/Word.php ';



\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->get('/words/', function () {
    try
    {
        echo 'Hello';
        return DL\Word::getWords();

    }catch (Exception $e)
    {
        $app->response()->status(400);
        $app->response()->header('X-Status-Reason', $e->getMessage());
    }



});

$app->post('/hello/:name', function ($name) {
    echo "Post Hello, " . $name;
});

$app->get('/article/:id', function ($id) {
    echo "Article, " . $id;
});

$app->run();

?>