<?php

namespace App\Services;

use App\Repositories\UploadRepository;
use App\Factories\FileFactory;
use App\Commands\ProcessFileCommand;
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
        // $this->checksIfFileHasAlreadyBeenSent($hash, $file);

        // Salva os metadados do arquivo no banco de dados
        $upload = $this->repository->store([
            'filename' => $file->getClientOriginalName(),
            'hash' => $hash,
        ]);

        // Salva o arquivo no sistema de arquivos
        $filePath = $file->storeAs('public', $file->getClientOriginalName());

        // Obter o caminho absoluto para leitura posterior
        $absolutePath = storage_path("app" . DIRECTORY_SEPARATOR . "{$filePath}");

        // Gera um comando para processamento
        $payload = [FileFactory::createProcessCommand($upload, $absolutePath)];

        // Usa o dispatcher configurado para enviar o job
        $dispatcher = DispatcherFactory::make();
        $dispatcher->dispatch(ProcessFileCommand::class, $payload);

        return $upload;
    }

    private function checksIfFileHasAlreadyBeenSent(string $hash, $file)
    {
        if ($this->repository->findByHashOrFilename($hash, $file->getClientOriginalName())) {
            throw new \Exception('Arquivo já enviado');
        }
    }
}
