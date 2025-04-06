<?php

namespace App\Services\Impl;

use App\Exceptions\ErrorException;
use App\Exceptions\RecordExistsException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthUserResource;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Repository\IVerifyCodeRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Services\AuthServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthService implements AuthServiceInterface
{
    use ApiResponse;

    private UserRepositoryInterface $userRepository;
    private IVerifyCodeRepositoryInterface $verifyCodeRepository;

    public function __construct(UserRepositoryInterface $userRepository, IVerifyCodeRepositoryInterface $verifyCodeRepository)
    {
        $this->userRepository = $userRepository;
        $this->verifyCodeRepository = $verifyCodeRepository;
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
        $user = $this->userRepository->getByEmailAndActive($request->email);

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
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone_number' => $request->phone_number,
            'role' => 'user'
        ];

        $existingUser = $this->userRepository->getByEmail($request->email);

        if ($existingUser) {
            // If user exists but email is not verified
            if (!$existingUser->email_verified_at) {
                $existingUser->verificationTokens()->delete();
                $existingUser->delete();
            } else {
                throw new RecordExistsException(
                    'Email already registered. Please login.',
                );
            }
        }

        $this->userRepository->store($details);

        $user = $this->userRepository->getByEmail($request->email);

        // Create verification token
        $token = env("URL_VERIFY_REGISTER") . $this->createVerificationToken($user);

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
        $token = $this->verifyCodeRepository->findValidToken($request->token);

        if (!$token || !$token->user)
            throw new ErrorException("Invalid or expired verification token", 400);

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

        $this->verifyCodeRepository->createToken($user->uuid, $token);

        return $token;
    }

    /**
     * Send verification email to the user.
     *
     * @param User $user
     * @param string $url
     * @return void
     */
    private function sendVerificationEmail(User $user, string $url): void
    {
        Mail::to($user->email)->send(new VerifyEmail($user, $url));
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
