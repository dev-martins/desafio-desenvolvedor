<?php

namespace App\Repositories;

use App\Models\Upload;

class UploadRepository
{
    public function findByHashOrFilename($hash, $filename)
    {
        return Upload::where('hash', $hash)
            ->orWhere('filename', $filename)
            ->first();
    }

    public function store(array $data)
    {
        return Upload::create($data);
    }

    /**
     * Busca uploads com filtros opcionais.
     *
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    public function getFilteredUploads(array $filters)
    {
        $query = Upload::query();

        if (!empty($filters['filename'])) {
            $query->where('filename', 'like', '%' . $filters['filename'] . '%');
        }

        if (!empty($filters['date'])) {
            $query->whereDate('created_at', $filters['date']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
