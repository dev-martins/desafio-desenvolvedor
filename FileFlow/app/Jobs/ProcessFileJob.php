<?php

namespace App\Jobs;

use App\Imports\FileContentImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $upload;
    protected $filePath;

    public function __construct($upload, $filePath)
    {
        $this->upload = $upload;
        $this->filePath = $filePath;
    }

    /**
     * Processa o arquivo usando a classe FileContentImport.
     */
    public function handle()
    {
        $relativePath = str_replace(storage_path('app') . DIRECTORY_SEPARATOR, '', $this->filePath);
        $data['uploadId'] = $this->upload->id;
        $data['filePath'] = $relativePath;
        // dd($relativePath);
        // Processa o arquivo usando Excel::import com chunks
        new FileContentImport($data);
    }
}
