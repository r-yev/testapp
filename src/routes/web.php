<?php


use App\Http\Controllers\SiteController;

return [
    'GET /' => [SiteController::class, 'index'],
    'GET /login' => [SiteController::class, 'login'],
    'GET /register' => [SiteController::class, 'register']
];