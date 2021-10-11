<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection,WithHeadings
{
    use Exportable;

    private $collection;

    public function headings(): array
    {
        return [
            'Account #',
            'First name',
            'Middle name',
            'Last name',
            'Civil status',
            'Purok',
            'Barangay',
            'Phone #',
            'Connection type',
            'Connection status',
            'Meter IPS',
        ];
    }

    public function withData($data)
    {
        $this->collection=$data;
        return $this;
    }

    public function collection()
    {
        
        return $this->collection?$this->collection:Customer::all([
            'account_number',
            'firstname',
            'middlename',
            'lastname',
            'civil_status',
            'purok',
            'barangay',
            'contact_number',
            'connection_type',
            'connection_status',
            'purchase_option'
        ]);

    }
}
