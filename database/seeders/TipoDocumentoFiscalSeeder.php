<?php

namespace Database\Seeders;

use App\Models\TipoDocumentoFiscal;
use Illuminate\Database\Seeder;

class TipoDocumentoFiscalSeeder extends Seeder
{
    public function run(): void
    {
        $documentos = [
            // VENEZUELA
            [
                'codigo' => 'RIF',
                'nombre' => 'Registro de Información Fiscal',
                'pais' => 'VEN',
                'formato' => '/^[JGVE][-]?[0-9]{8}[-]?[0-9]$/',
                'descripcion' => 'Documento tributario venezolano',
                'longitud' => 12,
            ],
            
            // ESPAÑA
            [
                'codigo' => 'NIF',
                'nombre' => 'Número de Identificación Fiscal',
                'pais' => 'ESP', 
                'formato' => '/^[A-Z][0-9]{8}$/',
                'descripcion' => 'Documento tributario español',
                'longitud' => 9,
            ],
            
            // ARGENTINA
            [
                'codigo' => 'CUIT',
                'nombre' => 'Clave Única de Identificación Tributaria',
                'pais' => 'ARG',
                'formato' => '/^[0-9]{2}[-][0-9]{8}[-][0-9]$/',
                'descripcion' => 'Documento tributario argentino',
                'longitud' => 13,
            ],
            
            // COLOMBIA
            [
                'codigo' => 'NIT',
                'nombre' => 'Número de Identificación Tributaria',
                'pais' => 'COL',
                'formato' => '/^[0-9]{9}[-][0-9]$/',
                'descripcion' => 'Documento tributario colombiano',
                'longitud' => 11,
            ],
            
            // MÉXICO
            [
                'codigo' => 'RFC',
                'nombre' => 'Registro Federal de Contribuyentes',
                'pais' => 'MEX',
                'formato' => '/^[A-Z&Ñ]{3,4}[0-9]{6}[A-Z0-9]{3}$/',
                'descripcion' => 'Documento tributario mexicano',
                'longitud' => 13,
            ],
            
            // INTERNACIONAL
            [
                'codigo' => 'VAT',
                'nombre' => 'Value Added Tax',
                'pais' => 'INT',
                'formato' => null,
                'descripcion' => 'Número de IVA intracomunitario',
                'longitud' => null,
            ],
        ];

        foreach ($documentos as $documento) {
            TipoDocumentoFiscal::create($documento);
        }
    }
}