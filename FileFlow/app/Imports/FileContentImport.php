<?php

namespace App\Imports;

use App\Models\FileContent;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;

class FileContentImport implements
    ToModel,
    WithHeadingRow,
    WithCustomCsvSettings,
    WithBatchInserts,
    WithChunkReading
{
    protected $uploadId;
    protected $file;

    public function __construct(array $data)
    {
        $this->uploadId = $data['uploadId'];
        $this->file = $data['filePath'];
        $this->storeWorksheet();
    }

    public function storeWorksheet(): void
    {
        Excel::import(
            $this,
            base_path('storage/app/' . $this->file)
        );
    }

    /**
     * Define o delimitador do arquivo CSV.
     *
     * @return array
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';', // Define o delimitador como ponto e vírgula
        ];
    }

    /**
     * Processa um bloco de linhas do arquivo.
     *
     */
    public function model(array $rows)
    {
        // dd($rows);
        return new FileContent([
            'upload_id' => $this->uploadId,
            'RptDt' => $rows['rptdt'],
            'TckrSymb' => $rows['tckrsymb'],
            'MktNm' => $rows['mktnm'] ,
            'SctyCtgyNm' => $rows['sctyctgynm'] ,
            'ISIN' => $rows['isin'] ,
            'CrpnNm' => $rows['crpnnm'] ,
        ]);
    }

    // /**
    //  * Regras de validação para os dados processados.
    //  *
    //  * @return array
    //  */
    // public function rules(): array
    // {
    //     return [
    //         'RptDt' => 'required|date',
    //         'TckrSymb' => 'required|string',
    //         'MktNm' => 'required|string',
    //         'SctyCtgyNm' => 'required|string',
    //         'ISIN' => 'required|string',
    //         'CrpnNm' => 'required|string',
    //     ];
    // }


    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Define o tamanho do bloco de leitura para evitar sobrecarga de memória.
     *
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
