<?php namespace App\Classes\Facades;


class BarangayData{
    private static $data=[
        '010'=>'Aguinaldo',
        '020'=>'Amparo',
        '021'=>'Amparo - Sumayod',
        '030'=>'Asuncion',
        '031'=>'Asuncion - Bagong Silang',
        '040'=>'Bagong Silang',
        '050'=>'Buscayan',
        '060'=>'Cambaro',
        '070'=>'Canlusay',
        '080'=>'Danao',
        '090'=>'Flordeliz',
        '100'=>'Guadalupe',
        '110'=>'Ichon - 3 Kings',
        '111'=>'Ichon - Candelaria',
        '112'=>'Ichon - Holy Innocents',
        '113'=>'Ichon - Magsaysay',
        '114'=>'Ichon - L. Galdo',
        '115'=>'Ichon - Santolan',
        '120'=>'Ilihan',
        '130'=>'Laray',
        '140'=>'Lower Villa Jacinta',
        '150'=>'Mabini',
        '151'=>'Mabini - Camalig',
        '160'=>'Mohon',
        '170'=>'Molopolo',
        '171'=>'Molopolo - Salimbangon',
        '172'=>'Molopolo - Cacawan',
        '180'=>'Rizal',
        '190'=>'Salvador',
        '200'=>'San Isidro',
        '210'=>'San Joaquin',
        '220'=>'San Roque',
        '230'=>'San Vicente (Pob.)',
        '240'=>'Sindangan',
        '250'=>'Sta. Cruz (Pob.)',
        '260'=>'Sto. Niño',
        '270'=>'Sto. Rosario (Pob.)',
        '280'=>'Upper Ichon',
        '281'=>'Upper Ichon - Tuburan',
        '290'=>'Upper San Vicente',
        '300'=>'Upper Villa Jacinta'
    ];

    public static function names()
    {
        $barangayNames=[];
        foreach(BarangayData::$data as $barangay)
        {
            array_push($barangayNames,$barangay);
        }
        return $barangayNames;
    }
}