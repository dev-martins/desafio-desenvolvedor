<?php

namespace App\Services;

use App\Repositories\UploadRepository;
use App\Factories\DispatcherFactory;

class UploadService
{
    protected $repository;

    public function __construct(UploadRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleUpload($file)
    {
        $hash = md5_file($file->getRealPath());

        // Verifica se o arquivo já foi enviado
        $this->checksIfFileHasAlreadyBeenSent($hash, $file);

        // Salva os metadados do arquivo no banco de dados
        $response = $this->repository->store([
            'filename' => $file->getClientOriginalName(),
            'hash' => $hash,
        ]);

        if (isset($response->id)) {
            $data = [
                'uploadId' => $response->id,
                'filename' => $response->filename,
                'hash' => $response->hash,
            ];
        }

        // Salva o arquivo no sistema de arquivos
        $filePath = $file->storeAs('public', $file->getClientOriginalName());
        $data['filePath'] = $filePath;

        // Usa o dispatcher configurado para enviar o job
        $dispatcher = DispatcherFactory::make();
        $dispatcher->dispatch(payload: $data);

        return $response;
    }

    /**
     * Busca o histórico de uploads com filtros opcionais.
     *
     * @param array $filters
     * @return \Illuminate\Support\Collection
     */
    public function getUploadsHistory(array $filters)
    {
        return $this->repository->getFilteredUploads($filters);
    }

    private function checksIfFileHasAlreadyBeenSent(string $hash, $file)
    {
        if ($this->repository->findByHashOrFilename($hash, $file->getClientOriginalName())) {
            throw new \Exception('Arquivo já enviado');
        }
    }
}
