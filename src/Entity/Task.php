<?php

declare(strict_types=1);

namespace App\Entity;

final class Task
{
    /** @var int $id */
    private $id;

    /** @var string $name */
    private $name;

    /** @var string|null $description */
    private $description;

    /** @var int|null $status */
    private $status;

    /** @var int $user_id */
    private $user_id;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function updateStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function updateUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

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
        $task = new \stdClass();
        $task->id = $this->getId();
        $task->name = $this->getName();
        $task->description = $this->getDescription();
        $task->status = $this->getStatus();
        $task->user_id = $this->getUserId();
        $task->created_at = $this->getCreatedAt();
        $task->updated_at = $this->getUpdatedAt();

        return $task;
    }
}
