<?php

declare(strict_types=1);

namespace App\Service\Operation;

use App\Exception\OperationException;

final class Update extends BaseOperationService
{
    public function update($input, int $operationId)
    {
        $operation = $this->getOneFromDb($operationId);
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name) && !isset($data->description)) {
            throw new OperationException('Enter the data to update the operation.', 400);
        }
        if (isset($data->name)) {
            $operation->name = self::validateTitle($data->name);
        }
        if (isset($data->description)) {
            $operation->description = self::validateDescription($data->description);
        }
        $operations = $this->operationRepository->updateOperation($operation);
        if (self::isRedisEnabled() === true) {
            $this->saveInCache($operations->id, $operations);
        }

        return $operations;
    }
}
