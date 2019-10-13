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

use App\v1\Middlewares\{JwtDateTimeMiddleware, ValidTokenMiddleware};

$app = new \Slim\App(slimConfiguration());

$app->group('/v1', function() use($app) {

    $app->post('/login', AuthController::class . ':login');
    $app->post('/refresh-token', AuthController::class . ':refreshToken');
    $app->post('/esqueci-minha-senha', UsuarioController::class . ':esqueciMinhaSenha');
    $app->post('/usuario', UsuarioController::class . ':postUsuario');

    $app->group('', function() use ($app) {
        // Usuários
        $app->get('/usuarios', UsuarioController::class . ':getUsuarios');
        $app->get('/usuario/{usuarioId}', UsuarioController::class . ':getUsuario');
        $app->put('/usuario', UsuarioController::class . ':putUsuario');
        $app->put('/usuario/atualiza-senha', UsuarioController::class . ':changePassword');
        $app->delete('/usuario/{usuarioId}', UsuarioController::class . ':deleteUsuario');
        
        // Quotes
        $app->get('/quotes', QuoteController::class . ':getQuotes');
        $app->get('/quote/{quoteId}', QuoteController::class . ':getQuote');
        $app->post('/quote', QuoteController::class . ':postQuote');
        $app->put('/quote', QuoteController::class . ':putQuote');
        $app->delete('/quote/{quoteId}', QuoteController::class . ':deleteQuote');
        
        // Reações
        $app->get('/reacoes', ReacaoController::class . ':getReacoes');
        $app->get('/reacao/{reacaoId}', ReacaoController::class . ':getReacao');
        $app->post('/reacao', ReacaoController::class . ':postReacao');
        $app->put('/reacao', ReacaoController::class . ':putReacao');
        $app->delete('/reacao/{reacaoId}', ReacaoController::class . ':deleteReacao');

        // Reações nos quotes
        $app->get('/quote-reacao/{usuarioId}/{quoteId}', QuoteReacaoController::class . ':getQuoteReacao');
        $app->get('/quote-reacao/quantidade/{quoteId}', QuoteReacaoController::class . ':getQuoteReacaoCount');
        $app->post('/quote-reacao', QuoteReacaoController::class . ':postQuoteReacao');
        $app->delete('/quote-reacao/{usuarioId}/{reacaoId}', QuoteReacaoController::class . ':deleteQuoteReacao');

    })->add(new JwtDateTimeMiddleware())
      ->add(jwtAuth());
});

$app->run();