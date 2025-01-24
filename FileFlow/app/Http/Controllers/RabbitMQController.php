<?php

namespace App\Http\Controllers;

use App\Services\FileProcessService;
use Illuminate\Http\Request;

class RabbitMQController extends Controller
{
    public function __construct(protected FileProcessService $fileProcess) {}

    public function fileProcess(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $this->fileProcess->fileProcess($data);
        return response()->json(['message' => 'Fila processada'], 200);
    }
}
