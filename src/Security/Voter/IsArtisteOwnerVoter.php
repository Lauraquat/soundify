<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class IsArtisteOwnerVoter extends Voter
{

    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === 'isArtistOwner';
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $token->getUser();
        $artist = $user->getArtiste();
        $songArtists = $subject->getArtistes();
        
        // if the user is anonymous, do not grant access
        return $songArtists->contains($artist);
    }
}
