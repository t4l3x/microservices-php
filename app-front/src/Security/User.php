<?php

namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

class User extends \Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge implements UserInterface
{
    private string $apiKey;

    public function __construct(string $userIdentifier, callable $userLoader = null)
    {
        parent::__construct($userIdentifier, $userLoader);
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->apiKey;
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername(): string
    {
        return 'api_user';
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
    }
}
