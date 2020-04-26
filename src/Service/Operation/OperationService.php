<?php

declare(strict_types=1);

namespace App\Service\Operation;

use App\Exception\OperationException;

final class OperationService extends Base
{
    public function getAll(): array
    {
        return $this->operationRepository->getOperations();
    }

    public function getOne(int $operationId)
    {
        if (self::isRedisEnabled() === true) {
            $operation = $this->getOneFromCache($operationId);
        } else {
            $operation = $this->getOneFromDb($operationId);
        }
        return $operation;
    }

    public function search(string $operationsName): array
    {
        return $this->operationRepository->searchOperations($operationsName);
    }

    public function create($input)
    {
        $operation = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name)) {
            throw new OperationException('Invalid data: name is required.', 400);
        }
        $operation->name = self::validateOperationName($data->name);
        $operation->description = null;
        if (isset($data->description)) {
            $operation->description = self::validateDescription($data->description); 
        } 
        $operations = $this->operationRepository->createOperation($operation);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($operations->id, $operations);
        }

        return $operations;
    }

    public function update($input, int $operationId)
    {
        $operation = $this->getOneFromDb($operationId);
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name) && !isset($data->description)) {
            throw new OperationException('Enter the data to update the operation.', 400);
        }
        if (isset($data->name)) {
            $operation->name = self::validateOperationName($data->name);
        }
        if (isset($data->description)) {
            $operation->description = self::validateDescription($data->description);
        }

        return $operations;
    }

    public function delete(int $operationId): void
    {
        $this->getOneFromDb($operationId);
        $this->operationRepository->deleteOperation($operationId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($operationId);
        }
    }
}
