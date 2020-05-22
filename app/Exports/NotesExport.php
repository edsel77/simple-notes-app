<?php

namespace App\Exports;

use App\NotesModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class NotesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return NotesModel::all();
    }
}
