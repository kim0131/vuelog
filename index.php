<?php

use Slim\Exception\NotFoundException;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/./vendor/autoload.php';
require __DIR__ . '/./src/config/db.php';

$app = new \Slim\app;

require __DIR__ . '/./src/routes/login.php';
require __DIR__ . '/./src/routes/books.php';

$app->get('/login', function (Request $request, Response $reponse) {
    echo 'home user working';
});
$app->post('/api/books/selectdel', \funbook::class . ':selectdel');

$app->post('/api/books/gettoken', \funbook::class . ':gettoken');

$app->post('/api/login', \func::class . ':login');

$app->get('/api/books', \funbook::class . ':read');

$app->get('/api/books/{id}', \funbook::class . ':reada');

$app->post('/api/books/add', \funbook::class . ':add');

$app->post('/api/books/update/{id}', \funbook::class . ':update');

$app->delete('/api/books/delete/{id}', \funbook::class . ':delete');




$app->run();





?>
