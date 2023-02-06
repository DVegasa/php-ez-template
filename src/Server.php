<?php

namespace App;

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;



function response (Response $r, $body=null, $code=200): Response {
    if ($body !== null) {
        $r->getBody()->write(json_encode($body));
    } else {
        $r->getBody()->write('');
    }
    $r = $r->withHeader('Content-Type', 'application/json');
    $r = $r->withStatus($code);
    return $r;
}

function getPostParams(Request $req): ?array {
    return json_decode($req->getBody(), true);
}

function getGetParams(Request $req): ?array {
    return $req->getQueryParams();
}



class Server {
    function start() {
        $app = AppFactory::create();
        $this->setupRouting($app);
        $this->setupCors($app);
        $app->run();
    }

    protected function setupCors ($app): void {
        $app->add(function ($request, $handler) {
            $response = $handler->handle($request);
            return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
        });
    }

    protected function setupRouting($app) {
        $app->post('/hello', function (Request $req, Response $res, $args) {
            return response($res, [
                'method' => $req->getMethod(),
                'params' => [
                    'get' => getGetParams($req),
                    'post' => getPostParams($req),
                ],
            ]);
        });
    }
}
