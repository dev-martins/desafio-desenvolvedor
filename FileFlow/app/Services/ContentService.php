<?php

namespace App\Services;

use App\Repositories\ContentRepository;

class ContentService
{
    protected $repository;

    public function __construct(ContentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Obtém arquivos com base em filtros e paginação.
     *
     * @param array $filters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilesWithFilters(array $filters)
    {
        return $this->repository->getFilteredFiles($filters);
    }
}
