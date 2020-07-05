<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;

class CheckPassportClientCredentials extends CheckClientCredentials
{
    /**
     * The Resource Server instance.
     *
     * @var \League\OAuth2\Server\ResourceServer
     */
    protected $server;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$scopes
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$scopes)
    {
        $psr = (new DiactorosFactory())->createRequest($request);
        try {
            $psr = $this->server->validateAuthenticatedRequest($psr);
            //
            // Set an "client_id" field on the request with the client id determined by the bearer token.
            $request['client_id'] = $psr->getAttribute('oauth_client_id');
            //
        } catch (OAuthServerException $e) {
            throw new AuthenticationException();
        }

        $this->validateScopes($psr, $scopes);

        return $next($request);
    }
}
