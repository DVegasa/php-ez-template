<?php

use App\Server;

require __DIR__ . '/../vendor/autoload.php';
main();

function main(): void {
    $server = new Server();
    $server->start();
}
