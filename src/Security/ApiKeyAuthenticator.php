<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param Request $request
     *
     * @return bool|null
     */
    public function supports(Request $request): ?bool
    {
        return str_starts_with($request->getPathInfo(), '/api/');
    }

    /**
     * @param Request $request
     *
     * @return Passport
     */
    public function authenticate(Request $request): Passport
    {
        $header = $request->headers->get('x-api-key');
        if (!$header || $header !== $this->apiKey) {
            throw new AuthenticationException('Invalid API key');
        }

        return new SelfValidatingPassport(new UserBadge('api_key_user'));
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $firewallName
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Allowing the request to continue
        return null;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     *
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['error' => 'Authentication failed', 'message' => $exception->getMessage()], 401);
    }
}