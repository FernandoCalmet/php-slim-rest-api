<?php

declare(strict_types=1);

namespace App\Service\Operation;

final class Search extends BaseOperationService
{
    public function search(string $operationsName): array
    {
        return $this->operationRepository->searchOperations($operationsName);
    }
}
