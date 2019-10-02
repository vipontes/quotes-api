<?php

use function src\{
    slimConfiguration,
    jwtAuth
};

use App\v1\Controllers\{
    AuthController,
    QuoteController,
    QuoteRacaoController,
    ReacaoController,
    UsuarioController
};

use App\v1\Middlewares\JwtDateTimeMiddleware;

$app = new \Slim\App(slimConfiguration());

$app->group('/v1', function() use($app) {

    $app->post('/login', AuthController::class . ':login');
    $app->post('/refresh-token', AuthController::class . ':refreshToken');

    $app->group('', function() use ($app) {
        // Usuários
        $app->get('/usuarios', UsuarioController::class . ':getUsuarios');
        $app->get('/usuario/{usuarioId}', UsuarioController::class . ':getUsuario');
        $app->post('/usuario', UsuarioController::class . ':postUsuario');
        $app->put('/usuario', UsuarioController::class . ':putUsuario');
        $app->delete('/usuario', UsuarioController::class . ':deleteUsuario');
        
        // Quotes
        $app->get('/quotes', QuoteController::class . ':getQuotes');
        $app->get('/quote', QuoteController::class . ':getQuote');
        $app->post('/quote', QuoteController::class . ':postQuote');
        $app->put('/quote', QuoteController::class . ':putQuote');
        $app->delete('/quote', QuoteController::class . ':deleteQuote');
        
        // Reações
        $app->get('/reacoes', ReacaoController::class . ':getReacoes');
        $app->get('/reacao', ReacaoController::class . ':getReacao');
        $app->post('/reacao', ReacaoController::class . ':postReacao');
        $app->put('/reacao', ReacaoController::class . ':putReacao');
        $app->delete('/reacao', ReacaoController::class . ':deleteReacao');

    })->add(new JwtDateTimeMiddleware())
      ->add(jwtAuth());
});

$app->run();