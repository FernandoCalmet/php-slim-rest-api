<?php

declare(strict_types=1);

namespace App\Service\Operation;

final class GetAll extends BaseOperationService
{
    public function getAll(): array
    {
        return $this->operationRepository->getOperations();
    }
}
