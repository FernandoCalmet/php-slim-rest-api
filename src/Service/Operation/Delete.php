<?php

declare(strict_types=1);

namespace App\Service\Operation;

class Delete extends BaseOperationService
{
    public function delete(int $operationId)
    {
        $this->getOneFromDb($operationId);
        $this->operationRepository->deleteOperation($operationId);
        if (self::isRedisEnabled() === true) {
            $this->deleteFromCache($operationId);
        }
    }
}
