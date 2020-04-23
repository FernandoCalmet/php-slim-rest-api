<?php

declare(strict_types=1);

$app->get('/', 'App\Controller\DefaultController:getHelp');
$app->get('/status', 'App\Controller\DefaultController:getStatus');

$app->post('/login', \App\Controller\User\Login::class);
$app->post('/signup', \App\Controller\User\SignUp::class);

$app->group('/api/v1', function () use ($app): void {
    $app->group('/users', function () use ($app): void{
        $app->get('', \App\Controller\User\GetAll::class);
        $app->get('/[{id}]', \App\Controller\User\GetOne::class);
        $app->get('/search/[{query}]', \App\Controller\User\Search::class);
        $app->post('', \App\Controller\User\Create::class);
        $app->put('/[{id}]', \App\Controller\User\Update::class);
        $app->delete('/[{id}]', \App\Controller\User\Delete::class);
    })->add(new App\Middleware\AuthMiddleware());

    $app->group('/profiles', function () use ($app): void {
        $app->get('', \App\Controller\Profile\GetAll::class);
        $app->get('/[{id}]', \App\Controller\Profile\GetOne::class);
        $app->get('/search/[{query}]', \App\Controller\Profile\Search::class);
        $app->post('', \App\Controller\Profile\Create::class);
        $app->put('/[{id}]', \App\Controller\Profile\Update::class);
        $app->delete('/[{id}]', \App\Controller\Profile\Delete::class);
    })->add(new App\Middleware\AuthMiddleware());
    
    $app->group('/modules', function () use ($app): void {
        $app->get('', \App\Controller\Module\GetAll::class);
        $app->get('/[{id}]', \App\Controller\Module\GetOne::class);
        $app->get('/search/[{query}]', \App\Controller\Module\Search::class);
        $app->post('', \App\Controller\Module\Create::class);
        $app->put('/[{id}]', \App\Controller\Module\Update::class);
        $app->delete('/[{id}]', \App\Controller\Module\Delete::class);
    })->add(new App\Middleware\AuthMiddleware());

    $app->group('/roles', function () use ($app): void {
        $app->get('', \App\Controller\Role\GetAll::class);
        $app->get('/[{id}]', \App\Controller\Role\GetOne::class);
        $app->get('/search/[{query}]', \App\Controller\Role\Search::class);
        $app->post('', \App\Controller\Role\Create::class);
        $app->put('/[{id}]', \App\Controller\Role\Update::class);
        $app->delete('/[{id}]', \App\Controller\Role\Delete::class);
    })->add(new App\Middleware\AuthMiddleware());

    $app->group('/permissions', function () use ($app): void {
        $app->get('', \App\Controller\Permission\GetAll::class);
        $app->get('/[{id}]', \App\Controller\Permission\GetOne::class);
        $app->get('/search/[{query}]', \App\Controller\Permission\Search::class);
        $app->post('', \App\Controller\Permission\Create::class);
        $app->put('/[{id}]', \App\Controller\Permission\Update::class);
        $app->delete('/[{id}]', \App\Controller\Permission\Delete::class);
    })->add(new App\Middleware\AuthMiddleware());

    $app->group('/operations', function () use ($app): void {
        $app->get('', \App\Controller\Operation\GetAll::class);
        $app->get('/[{id}]', \App\Controller\Operation\GetOne::class);
        $app->get('/search/[{query}]', \App\Controller\Operation\Search::class);
        $app->post('', \App\Controller\Operation\Create::class);
        $app->put('/[{id}]', \App\Controller\Operation\Update::class);
        $app->delete('/[{id}]', \App\Controller\Operation\Delete::class);
    })->add(new App\Middleware\AuthMiddleware());
});
