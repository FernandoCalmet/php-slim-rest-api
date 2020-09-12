<?php

declare(strict_types=1);

namespace App\Entity;

final class Note
{
    /** @var int $id */
    private $id;

    /** @var string $name */
    private $name;

    /** @var string|null $description */
    private $description;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function updateDescription(?string $description): self
    {
        $this->description = $description;

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
        $note = new \stdClass();
        $note->id = $this->getId();
        $note->name = $this->getName();
        $note->description = $this->getDescription();
        $note->createdAt = $this->getCreatedAt();
        $note->updatedAt = $this->getUpdatedAt();

        return $note;
    }
}
