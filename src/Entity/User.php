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

    /** @var string|null $createdAt */
    private $createdAt;

    /** @var string|null $updatedAt */
    private $updatedAt;

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
        return $this->createdAt;
    }

    public function updateCreatedAt(?string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function updateUpdatedAt(?string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getData(): object
    {
        $user = new \stdClass();
        $user->id = $this->getId();
        $user->name = $this->getName();
        $user->email = $this->getEmail();
        $user->password = $this->getPassword();
        $user->createdAt = $this->getCreatedAt();
        $user->updatedAt = $this->getUpdatedAt();

        return $user;
    }
}
