<?php

use App\Http\Controllers\Api\AuthController;

return [
    'POST /login' => [AuthController::class, 'auth'],
    'POST /register' => [AuthController::class, 'register']
];