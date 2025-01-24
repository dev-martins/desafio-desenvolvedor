<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentRequest;
use App\Services\ContentService;

class ContentController extends Controller
{
    public function __construct(protected ContentService $service) {}

    public function contentFile(ContentRequest $request)
    {
        $data = $request->validated();
        $files = $this->service->getFilesWithFilters($data);

        return response()->json($files, 200);
    }
}
