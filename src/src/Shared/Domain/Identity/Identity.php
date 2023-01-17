<?php

declare(strict_types=1);

namespace App\Shared\Domain\Identity;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

final class Identity implements JWTUserInterface
{
    public function __construct(
        protected string $username = '',
        protected string $sub = '',
        protected string $role = '',
        protected array $scopes = [],
        protected array $shops = [],
        protected array $dealIds = [],
        protected array $dealCategories = [],
    ) {
    }

    public static function createFromPayload($username, array $payload): Identity
    {
        return new self(
            $username,
            $payload['sub'],
            $payload['role'],
            $payload['scopes'],
            $payload['shops'],
            $payload['dealIds'],
            $payload['dealCategories'],
        );
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function getPassword(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getUserIdentifier(): string
    {
        return $this->sub;
    }
}
