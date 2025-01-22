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
}
