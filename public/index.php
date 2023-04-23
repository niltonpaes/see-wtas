<?php

// ----------------------------------------------------------------------------------------
// set the base_path
// ----------------------------------------------------------------------------------------
// local
const BASE_PATH = __DIR__.'/../';
// host
// const BASE_PATH = __DIR__.'/../../';
require BASE_PATH.'core/functions.php';
// from now on I can just use the function base_path
// dd(BASE_PATH);

require base_path('core/Router.php');

// dd($_SERVER);

$router = new Router();

require base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

// dd($uri);

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);


