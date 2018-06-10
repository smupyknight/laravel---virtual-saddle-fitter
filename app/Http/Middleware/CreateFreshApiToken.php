<?php
namespace App\Http\Middleware;

use Illuminate\Http\Response;

class CreateFreshApiToken extends \Laravel\Passport\Http\Middleware\CreateFreshApiToken
{
    /**
     * Determine if the response should receive a fresh token.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return bool
     */
    protected function responseShouldReceiveFreshToken($response)
    {
        return $response instanceof Response && ! $this->alreadyContainsToken($response);
    }
}