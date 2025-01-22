<?php

namespace App\Factories;

use App\Commands\ProcessFileCommand;

class FileFactory
{
    public static function createProcessCommand($upload, $filePath)
    {
        return new ProcessFileCommand($upload, $filePath);
    }
}
