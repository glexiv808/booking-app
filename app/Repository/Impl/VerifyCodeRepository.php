<?php

namespace App\Repository\Impl;

use App\Models\EmailVerificationToken;
use App\Repository\IVerifyCodeRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VerifyCodeRepository implements IVerifyCodeRepositoryInterface
{
    private string $tableName = 'email_verification_tokens';


    /**
     * @param string $token
     * @return EmailVerificationToken|null
     */
    public function findValidToken(string $token): ?EmailVerificationToken
    {
        $record = DB::table($this->tableName)
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return null;
        }

        return $this->mapToModel($record);
    }

    /**
     * Create a new email verification token for a user.
     *
     * @param string $userUuid The UUID of the user
     * @param string $token The token value
     * @return EmailVerificationToken Returns the created token
     */
    public function createToken(string $userUuid, string $token): EmailVerificationToken
    {
        $expiresInMinutes = (int)env('REGISTER_CODE_DURATION', 60); // Default to 60 minutes if not set

        $now = now();
        $data = [
            'user_uuid' => $userUuid,
            'token' => $token,
            'expires_at' => now()->addMinutes($expiresInMinutes),
            'created_at' => $now,
            'updated_at' => $now,
        ];

        // Insert the record
        $id = DB::table($this->tableName)->insertGetId($data);

        // Retrieve the created token
        $record = DB::table($this->tableName)->find($id);

        return $this->mapToModel($record);
    }

    /**
     * Map a database record to an EmailVerificationToken model.
     *
     * @param object $record
     * @return EmailVerificationToken
     */
    private function mapToModel(object $record): EmailVerificationToken
    {
        $token = new EmailVerificationToken();

        // Map all properties from the record to the model
        foreach ((array)$record as $key => $value) {
            $token->setAttribute($key, $value);
        }

        // Mark the model as existing
        $token->exists = true;

        return $token;
    }
}

