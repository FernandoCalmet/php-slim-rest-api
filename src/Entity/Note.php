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
        $note = new \stdClass();
        $note->id = $this->getId();
        $note->name = $this->getName();
        $note->description = $this->getDescription();
        $note->created_at = $this->getCreatedAt();
        $note->updated_at = $this->getUpdatedAt();

        return $note;
    }
}
