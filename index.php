<?php

use App\Server;

require __DIR__ . '/vendor/autoload.php';
main();

function main(): void {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
    $server = new Server();
    $server->start();
}
