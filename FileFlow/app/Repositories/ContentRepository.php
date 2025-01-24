<?php 

namespace App\Repositories;

use App\Models\FileContent;

class ContentRepository
{
    /**
     * Aplica filtros e retorna arquivos paginados.
     *
     * @param array $filters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getFilteredFiles(array $filters)
    {
        $query = FileContent::query();

        // Aplica Specification Pattern para filtros dinâmicos
        foreach ($this->getSpecifications($filters) as $specification) {
            $query = $specification->apply($query);
        }

        // Retorna resultados paginados
        return $query->paginate(10); // 10 registros por página
    }

    /**
     * Retorna as especificações para filtros.
     *
     * @param array $filters
     * @return array
     */
    protected function getSpecifications(array $filters)
    {
        $specifications = [];

        if (!empty($filters['TckrSymb'])) {
            $specifications[] = new Specifications\TckrSymbSpecification($filters['TckrSymb']);
        }

        if (!empty($filters['RptDt'])) {
            $specifications[] = new Specifications\RptDtSpecification($filters['RptDt']);
        }

        return $specifications;
    }
}
