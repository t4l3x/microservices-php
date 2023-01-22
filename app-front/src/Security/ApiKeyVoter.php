<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ApiKeyVoter extends Voter
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    protected function supports($attribute, $subject) : bool
    {
        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) : bool
    {
        $request = $subject;

        if (!$request->headers->has('X-AUTH-TOKEN')) {
            return false;
        }

        $apiToken = $request->headers->get('X-AUTH-TOKEN');

        if ($apiToken !== $this->apiKey) {
            return false;
        }

        return true;
    }
}
