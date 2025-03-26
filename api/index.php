<?php

use Illuminate\Http\Request;

// Charger l'autoloader de Composer
require __DIR__ . '/../vendor/autoload.php';

// Créer l'application Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Créer le noyau de l'application
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Capturer la requête
$request = Request::capture();

// Gérer la requête
$response = $kernel->handle($request);

// Envoyer la réponse
$response->send();

// Terminer le kernel
$kernel->terminate($request, $response);

