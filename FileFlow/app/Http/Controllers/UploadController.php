<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadRequest;
use App\Services\UploadService;

class UploadController extends Controller
{
    public function __construct(protected UploadService $service) {}

    public function upload(UploadRequest $request)
    {
        $data = $request->validated();
        $upload = $this->service->handleUpload($data['file']);

        return response()->json(['message' => 'Arquivo enviado com sucesso', 'upload' => $upload], 201);
    }
}
