<?php

namespace App\Repository;

use App\Models\EmailVerificationToken;

interface IVerifyCodeRepositoryInterface
{

    /**
     * Find a valid token by its value.
     *
     * @param string $token The token value to find
     * @return EmailVerificationToken|null Returns the token if found and not expired, or null otherwise
     */
    public function findValidToken(string $token): ?EmailVerificationToken;

    /**
     * Create a new email verification token for a user.
     *
     * @param string $userUuid The UUID of the user
     * @param string $token The token value
     * @return EmailVerificationToken Returns the created token
     */
    public function createToken(string $userUuid, string $token): EmailVerificationToken;
}


