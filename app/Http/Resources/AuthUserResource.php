<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AuthUserResource extends UserResource
{
    /**
     * The token for the user.
     *
     * @var string
     */
    protected $token;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     * @param string|null $token
     * @return void
     */
    public function __construct($resource, $token = null)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => parent::toArray($request),
            'access_token' => $this->token,
        ];
    }
}
