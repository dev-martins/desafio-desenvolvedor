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

    public function history(UploadRequest $request)
    {
        // Validação dos parâmetros de busca
        $data = $request->validated();

        // Busca o histórico via serviço
        $uploads = $this->service->getUploadsHistory($data);

        return response()->json($uploads, 200);
    }
}
