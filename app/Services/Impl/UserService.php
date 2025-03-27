<?php

namespace App\Services\Impl;

use App\Exceptions\ErrorException;
use App\Exceptions\RecordExistsException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthUserResource;
use App\Mail\VerifyEmail;
use App\Models\EmailVerificationToken;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use App\Services\UserServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UserService implements UserServiceInterface
{
    use ApiResponse;

    private UserRepositoryInterface $UserRepository;

    public function __construct(UserRepositoryInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }

    /**
     * Handle user login.
     *
     * @param LoginRequest $request
     * @return AuthUserResource Returns user data and token on success, false on failure
     * @throws UnauthorizedException
     */
    public function login(LoginRequest $request): AuthUserResource
    {
        $user = User::where('email', $request->email)
            ->where('email_verified_at', '!=', NULL)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new UnauthorizedException();
        }

        return new AuthUserResource($user, $this->createToken($user));
    }

    /**
     * Register a new user.
     *
     * @param RegisterRequest $request
     * @return void
     * @throws RecordExistsException If email already exists and is verified
     */
    public function register(RegisterRequest $request): void
    {
        $details = [
            "uuid" => Str::uuid(),
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'role' => 'user'
        ];

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            // If user exists but email is not verified
            if (!$existingUser->email_verified_at) {
                $existingUser->verificationTokens()->delete();
                $existingUser->delete();
            } else {
                throw new RecordExistsException(
                    'Email already registered. Please login.'
                );
            }
        }

        $this->UserRepository->store($details);

        $user = User::where('email', $request->email)->first();

        // Create verification token
        $token = $this->createVerificationToken($user);

        // Send verification email
        $this->sendVerificationEmail($user, $token);
    }

    /**
     * Verify email with token.
     *
     * @param Request $request
     * @return AuthUserResource
     * @throws ErrorException
     */
    public function verifyEmail(Request $request): AuthUserResource
    {
        $token = EmailVerificationToken::where('token', $request->token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$token || !$token->user)
            throw new ErrorException("Invalid or expired verification token");

        $user = $token->user;

        // Mark email as verified
        $user->email_verified_at = now();
        $user->save();

        // Delete the token
        $token->delete();

        return new AuthUserResource($user, $this->createToken($user));
    }

    /**
     * Create a verification token for the user.
     *
     * @param User $user
     * @return string
     */
    private function createVerificationToken(User $user): string
    {
        // Delete any existing tokens
        $user->verificationTokens()->delete();

        // Create new token
        $token = Str::random(64);

        EmailVerificationToken::create([
            'user_uuid' => $user->uuid,
            'token' => $token,
            'expires_at' => now()->addMinutes((int)env('REGISTER_CODE_DURATION')),
        ]);

        return $token;
    }

    /**
     * Send verification email to the user.
     *
     * @param User $user
     * @param string $token
     * @return void
     */
    private function sendVerificationEmail(User $user, string $token): void
    {
        Mail::to($user->email)->send(new VerifyEmail($user, $token));
    }


    /**
     * Generate a personal access token for the user.
     *
     * @param User $user The user for whom the token is generated
     * @return string Returns a plain text token
     */
    private function createToken(User $user): string
    {
        return $user->createToken($user->email, [$user->role])->plainTextToken;
    }
}
