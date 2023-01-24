<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class CustomApiKeyEntryPoint implements AuthenticationEntryPointInterface
{
    private string $apiKey;

    public function __construct( string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        dd('test');
        $apiToken = $request->headers->get('X-AUTH-TOKEN');
        if ($apiToken !== $this->apiKey) {
            return new Response('Invalid API Key', 401);
        }
        //if key is valid, let the request continue
    }
}