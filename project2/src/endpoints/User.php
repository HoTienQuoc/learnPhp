<?php
namespace Php8\Project2;

class User
{
    public readonly int $userId;

    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phoneNumber
    ) {
        // Constructor logic
    }

    public function create(): self
    {
        return $this;
    }

    public function retrieveAll(): array
    {
        return [];
    }

    public function retrieve(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function update(): self
    {
        return $this;
    }

    public function delete(string $userId): bool
    {
        return true;
    }
}
