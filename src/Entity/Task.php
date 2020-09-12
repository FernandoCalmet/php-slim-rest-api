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

    /** @var int $userId */
    private $userId;

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
        return $this->userId;
    }

    public function updateUserId(?int $userId): self
    {
        $this->userId = $userId;

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
        $task = new \stdClass();
        $task->id = $this->getId();
        $task->name = $this->getName();
        $task->description = $this->getDescription();
        $task->status = $this->getStatus();
        $task->userId = $this->getUserId();
        $task->createdAt = $this->getCreatedAt();
        $task->updatedAt = $this->getUpdatedAt();

        return $task;
    }
}
