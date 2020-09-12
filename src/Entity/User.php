<?php

declare(strict_types=1);

namespace App\Entity;

final class User
{
    /** @var int $id */
    private $id;

    /** @var string $name */
    private $name;

    /** @var string|null $email */
    private $email;

    /** @var string|null $password */
    private $password;

    /** @var string|null $created_at */
    private $created_at;

    /** @var string|null $updated_at */
    private $updated_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function updateName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function updateEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function updatePassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }

    public function updateCreatedAt(?string $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updated_at;
    }

    public function updateUpdatedAt(?string $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getData(): object
    {
        $user = new \stdClass();
        $user->id = $this->getId();
        $user->name = $this->getName();
        $user->email = $this->getEmail();
        $user->password = $this->getPassword();
        $user->created_at = $this->getCreatedAt();
        $user->updated_at = $this->getUpdatedAt();

        return $user;
    }
}
