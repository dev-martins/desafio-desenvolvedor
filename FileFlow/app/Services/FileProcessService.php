<?php

namespace App\Services;

use App\Jobs\ProcessFileJob;

class FileProcessService
{
    public function fileProcess(array $data)
    {
        ProcessFileJob::dispatch($data);
    }
}
