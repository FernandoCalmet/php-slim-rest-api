<?php

declare(strict_types=1);

namespace App\Service\Operation;

use App\Exception\OperationException;

final class Create extends BaseOperationService
{
    public function create($input)
    {
        $operation = new \stdClass();
        $data = json_decode(json_encode($input), false);
        if (!isset($data->name)) {
            throw new OperationException('Invalid data: name is required.', 400);
        }
        $operation->name = self::validateTitle($data->name);
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
}
